<?php
/**
 * All admin facing functions
 */
namespace codexpert\Woolementor;
use codexpert\product\Base;
use codexpert\product\Setup;
use codexpert\product\Metabox;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author codexpert <hello@codexpert.io>
 */
class Admin extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
		$this->assets 	= WOOLEMENTOR_ASSETS;
	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'woolementor', false, WOOLEMENTOR_DIR . '/languages/' );
	}
	
	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts( $screen ) {

		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';
		
		// vendors
		if( $screen == 'toplevel_page_woolementor' ) {
			wp_enqueue_style( 'gogole-fonts', 'https://fonts.googleapis.com/css?family=Nunito&display=swap', '', $this->version, 'all' );

			// enqueue stylesheet
			wp_enqueue_style( "{$this->slug}-pro-features", "{$this->assets}/css/pro-features{$min}.css", '', $this->version, 'all' );
			wp_enqueue_style( "{$this->slug}-widgets-settings", "{$this->assets}/css/widgets-settings{$min}.css", '', $this->version, 'all' );

			// enqueue JavaScript
			wp_enqueue_script( "{$this->slug}-widgets-settings", "{$this->assets}/js/widgets-settings{$min}.js", array( 'jquery' ), $this->version, true );
		}

		wp_enqueue_style( $this->slug, "{$this->assets}/css/admin{$min}.css", '', $this->version, 'all' );

		wp_enqueue_script( $this->slug, "{$this->assets}/js/admin{$min}.js", array( 'jquery' ), $this->version, true );

		$localized = array(
			'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
            'nonce' 	=> wp_create_nonce( 'woolementor' ),
		);
		wp_localize_script( $this->slug, 'WOOLEMENTOR', apply_filters( "{$this->slug}-localized", $localized ) );
	}

	public function footer_text( $text ) {
		if(get_current_screen()->parent_base != $this->slug ) return $text;

		return sprintf( __( 'If you like <strong>%1$s</strong>, please <a href="%2$s" target="_blank">leave us a %3$s rating</a> on WordPress.org! It\'d motivate and inspire us to make the plugin even better!', 'woolementor' ), $this->name, "https://wordpress.org/support/plugin/{$this->slug}/reviews/?filter=5#new-post", '⭐⭐⭐⭐⭐' );
	}



	/**
	 * Installer. Runs once when the plugin in activated.
	 *
	 * @since 1.0
	 */
	public function install() {
		/**
		 * Schedule an event to sync help docs
		 */
		if ( !wp_next_scheduled ( 'woolementor_daily' )) {
		    wp_schedule_event( time(), 'daily', 'woolementor_daily' );
		}

		if( !get_option( 'woolementor_version' ) ){
			update_option( 'woolementor_version', $this->version );
		}
		
		if( !get_option( 'woolementor_install_time' ) ){
			update_option( 'woolementor_install_time', time() );
		}

		/**
		 * Sync docs & others
		 */
		self::daily();
	}

	/**
	 * Uninstaller. Runs once when the plugin in deactivated.
	 *
	 * @since 1.0
	 */
	public function uninstall() {
		/**
		 * Remove scheduled hooks
		 */
		wp_clear_scheduled_hook( 'woolementor_daily' );
	}

	public function settings_page_redirect(){
    	if( get_option( 'woolementor-activated' ) != 1 ) {
			update_option( 'woolementor-activated', 1 );
    		wp_safe_redirect( admin_url( 'admin.php?page=woolementor' ) );
			exit();
    	}
	}

	/**
	 * Setup the instance
	 *
	 * @since 1.0
	 */
	public function setup() {
		add_image_size( 'woolementor-thumb', 400, 400, true );
	}

	/**
	 * Add some script to head
	 *
	 * @since 1.0
	 */
	public function head() {
    }

	/**
	 * Adds a widget in /wp-admin/ page
	 *
	 * @since 1.0
	 */
	public function dashboard_widget() {
		wp_add_dashboard_widget( 'wl-overview', __( 'Woolementor Docs & FAQs', 'woolementor' ), [ $this, 'callback_dashboard_widget' ] );

		// Move our widget to top.
		global $wp_meta_boxes;

		$dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$ours = [
			'wl-overview' => $dashboard['wl-overview'],
		];

		$wp_meta_boxes['dashboard']['normal']['core'] = array_merge( $ours, $dashboard );
	}

	/**
	 * Call back for dashboard widget in /wp-admin/
	 *
	 * @see dashboard_widget()
	 *
	 * @since 1.0
	 */
	public function callback_dashboard_widget() {
		$docs = get_option( 'woolementor-docs-json', [] );
		
		if( count( $docs ) > 0 ) :
		
		$docs = array_slice( $docs, 0, 5 );
		$utm = [ 'utm_source' => 'dashboard', 'utm_medium' => 'metabox', 'utm_campaign' => 'faq' ];

		echo '<ul id="wl-docs-wrapper">';
		
		foreach ( $docs as $doc ) {

			$doc_link = add_query_arg( $utm, $doc['link'] );
			echo "
			<li>
				<a href='{$doc_link}' target='_blank'><span aria-hidden='true' class='wl-doc-title-icon dashicons dashicons-external'></span> <span class='wl-doc-title'>{$doc['title']['rendered']}</span></a>
				" . wpautop( wp_trim_words( $doc['content']['rendered'], 10 ) ) . "
			</li>";
		}
		
		echo '</ul>';
		endif; // count( $docs ) > 0

		$_links = apply_filters( 'woolementor-widget_links', [
			'help'	=> [
				'url'		=> add_query_arg( $utm, 'https://help.codexpert.io/docs/woolementor/' ),
				'label'		=> __( 'Help', 'woolementor' ),
				'target'	=> '_blank',
			],
			'gopro'	=> [
				'url'		=> add_query_arg( $utm, 'https://woolementor.com' ),
				'label'		=> __( 'Go Pro', 'woolementor' ),
				'target'	=> '_blank',
			],
			'settings'	=> [
				'url'		=> admin_url( 'admin.php?page=woolementor' ),
				'label'		=> __( 'Settings', 'woolementor' ),
				'target'	=> '',
			],
		] );

		$footer_links = [];
		foreach ( $_links as $id => $link ) {
			$_has_icon = ( $link['target'] == '_blank' ) ? '<span class="screen-reader-text">' . __( '(opens in a new tab)', 'woolementor' ) . '</span><span aria-hidden="true" class="dashicons dashicons-external"></span>' : '';

			$footer_links[] = "<a href='{$link['url']}' target='{$link['target']}'>{$link['label']}{$_has_icon}</a>";
		}

		echo '<p class="community-events-footer">' . implode( ' | ', $footer_links ) . '</p>';
	}

	/**
	 * Daily events
	 */
	public static function daily() {
		/**
		 * Sync docs from https://help.codexpert.io daily
		 *
		 * @since 1.0
		 */
	    $json_url = 'https://help.codexpert.io/wp-json/wp/v2/docs/?parent=1960&per_page=20';
	    if( !is_wp_error( $data = wp_remote_get( $json_url ) ) ) {
	        update_option( 'woolementor-docs-json', json_decode( $data['body'], true ) );
	    }

	    // checks pro
	    woolementor_check_pro();
	}

	public function action_links( $links ) {
		$links['settings'] = '<a href="' . add_query_arg( 'page', $this->slug, admin_url( 'admin.php' ) ) . '">' . __( 'Settings', 'woolementor' ) . '</a>';
		
		return $links;
	}

	public function plugin_row_meta( $plugin_meta, $plugin_file ) {

		if ( $this->plugin['basename'] === $plugin_file ) {
			$plugin_meta['help'] = '<a href="https://wordpress.org/support/plugin/woolementor/" target="_blank" class="wl-plugins-help">' . __( 'Help', 'woolementor-pro' ) . '</a>';

			if( !woolementor_is_pro() ) {
				$plugin_meta['go_pro'] = '<a href="https://woolementor.com/?utm_source=dashboard&utm_medium=plugins&utm_campaign=go-pro" target="_blank" class="wl-plugins-gopro">' . __( 'Go Pro', 'woolementor' ) . '</a>';
			}
		}

		return $plugin_meta;
	}

	public function _survey_notice() {

		$install_time 	= get_option( 'woolementor_install_time' );
		$survey_agreed 	= get_option( "{$this->slug}_widget_survey_agreed" );

		if ( $survey_agreed ) return;

		if ( $install_time == '' || $install_time + ( DAY_IN_SECONDS * 2 ) <= time() ) {
			?>
		    <div class="notice notice-success is-dismissible wl-widget-survey">
		    	<div class="cx-notice-success-panel">
		    		<div class="cx-notice-success-panel-content">
		    			<div class="cx-notice-success-panel-left">
		    				<img src="<?php echo esc_url( plugins_url( 'assets/img/widgets.png', WOOLEMENTOR ) ); ?>" />
		    			</div>
		    			<div class="cx-notice-success-panel-right">
		    				<h3>Hi <?php echo get_userdata( get_current_user_id() )->display_name; ?>,</h3>
		    				<p>I hope you're doing great. This is <strong>Nazmul Ahsan</strong> from <a href="https://codexpert.io">codexpert.io</a>, the team behind Woolementor!</p>
		    				<p>We're always working to make Woolementor even better! As part of this process, we're going to completely rewrite the plugin to give you a better experience using it, which includes improving UI/UX, security and performance. To achieve this, we actually need to know which of the widgets you're using - which ones are activated, to be specific. We won't collect any sensitive info.</p>
		    				<p>Would you like to help us?</p>
		        			<div class="wl-widget-survey-btn-content">
		        				<button id="wl-widget-survey-btn" class="button button-primary button-hero" data-survey="yes"><?php _e( 'Okay. Don\'t bother me again!', 'woolementor' ); ?></button>
		        			</div>
		    			</div>
		    		</div>
		    	</div>
		    </div>
		    <?php
		}
	}
}