<?php
/**
 * All settings related functions
 */
namespace codexpert\Woolementor;
use codexpert\product\Base;
use codexpert\product\Table;
use codexpert\product\License;

/**
 * @package Plugin
 * @subpackage Settings
 * @author codexpert <hello@codexpert.io>
 */
class Settings extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}
	
	public function init_menu() {
		
		$icon = woolementor_get_icon( true ); // true: include img tag or only the url?
		
		$settings = [
			'id'            => $this->slug,
			'label'         => $this->name,
			'title'         => "{$icon} {$this->name} v2",
			'header'        => $this->name,
			'priority'      => 10,
			'capability'    => 'manage_options',
			'icon'          => '',
			'position'      => 59,
			'sections'      => [
				'woolementor_widgets'	=> [
					'id'        => 'woolementor_widgets',
					'label'     => __( 'Widgets', 'woolementor' ),
					'icon'      => 'dashicons-screenoptions',
					'color'		=> '#E9345F',
					'sticky'	=> true,
					'content'	=> woolementor_get_template( 'widgets', 'views/admin/settings' ),
					'fields'    => [],
				],
				'woolementor_help'	=> [
					'id'        => 'woolementor_help',
					'label'     => __( 'Help', 'woolementor' ),
					'icon'      => 'dashicons-sos',
					'color'		=> '#1d7b06',
					'hide_form'	=> true,
					'fields'    => [],
				],
				'woolementor_tools'	=> [
					'id'        => 'woolementor_tools',
					'label'     => __( 'Tools', 'woolementor' ),
					'icon'      => 'dashicons-admin-tools',
					'color'		=> '#ff8d29',
					'hide_form'	=> true,
					'fields'    => [],
				],
				'woolementor_upgrade'	=> [
					'id'        => 'woolementor_upgrade',
					'label'     => __( 'PRO Features', 'woolementor' ),
					'icon'      => 'dashicons-buddicons-groups',
					'color'		=> '#34B6E9',
					'hide_form'	=> true,
					'content'	=> woolementor_get_template( 'pro-features', 'views/admin/settings' ),
					'fields'    => [],
				],
			],
		];

		new \codexpert\product\Settings( apply_filters( 'woolementor-settings_args', $settings ) );
	}

	public function add_action_links( $links ) {
		$links[] = sprintf( '<a href="%1$s">%2$s</a>', admin_url( "admin.php?page={$this->slug}" ), __( 'Settings', 'woolementor' ) );
		$links[] = sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://codexpert.io', __( 'Help', 'woolementor' ) );

		return $links;
	}

	/**
	 * Adds an admin bar in the frontend
	 *
	 * @since 1.0
	 */
	public function add_admin_bar( $admin_bar ) {
		if( is_admin() || !current_user_can( 'manage_options' ) ) return;

		$admin_bar->add_menu( [
			'id'    => $this->slug,
			'title' => $this->name,
			'href'  => add_query_arg( 'page', $this->slug, admin_url( 'admin.php' ) ),
			'meta'  => [
				'title' => $this->name
			],
		] );
	}

	/**
	 * Filters contents of the help tab in the settings page
	 *
	 * @since 1.0
	 */
	public function help_content( $section ) {
		if( 'woolementor_help' != $section['id'] ) return;

		?>
		<div class="wl_tab_btns">
			<ul>			
				<li class="wl_help_tablink active" id="wl_faq"><?php _e( 'FAQ', 'woolementor' ); ?></li>
				<li class="wl_help_tablink" id="wl_vidtt"><?php _e( 'Video Tutorial', 'woolementor' ); ?></li>
				<li class="wl_help_tablink" id="wl_support"><?php _e( 'Ask Support', 'woolementor' ); ?></li>
			</ul>
		</div>

		<div id="wl_faq_content" class="tabcontent active">
			 <div class='wrap'>
			     <div id='woolementor-helps'>
			    <?php

			    $helps = get_option( 'woolementor-docs-json', [] );
				$utm = [ 'utm_source' => 'dashboard', 'utm_medium' => 'settings', 'utm_campaign' => 'faq' ];

			    if( is_array( $helps ) ) :
			    foreach ( $helps as $help ) {
			    	$help_link = add_query_arg( $utm, $help['link'] );
			        ?>
			        <div id='woolementor-help-<?php echo $help['id']; ?>' class='woolementor-help'>
			            <h2 class='woolementor-help-heading' data-target='#woolementor-help-text-<?php echo $help['id']; ?>'>
			                <a href='<?php echo $help_link; ?>' target='_blank'>
			                <span class='dashicons dashicons-admin-links'></span></a>
			                <span class="heading-text"><?php echo $help['title']['rendered']; ?></span>
			            </h2>
			            <div id='woolementor-help-text-<?php echo $help['id']; ?>' class='woolementor-help-text' style='display:none'>
			                <?php echo wpautop( wp_trim_words( $help['content']['rendered'], 55, " <a class='wl-more' href='{$help_link}' target='_blank'>[more..]</a>" ) ); ?>
			            </div>
			        </div>
			        <?php

			    }
			    else:
			        _e( 'Something is wrong! No help found!', 'woolementor' );
			    endif;
			    ?>
			    </div>
			</div>
		</div>

		<div id="wl_vidtt_content" class="tabcontent">
			<iframe width="900" height="525" src="https://www.youtube.com/embed/videoseries?list=PLljE6A-xP4wKNreIV76Tl6uQUw-40XQsZ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>

		<div id="wl_support_content" class="tabcontent">
				<p><?php _e( 'Having an issue or got something to say? Feel free to reach out to us! Our award winning support team is always ready to help you.', 'woolementor' ); ?></p>
			<div id="support_btn_div">
				<a href="https://help.codexpert.io/?utm_source=dashboard&utm_medium=settings&utm_campaign=submit-ticket" id="support_btn" target="_blank"><?php _e( 'Submit a Ticket', 'woolementor' ); ?></a>
			</div>
		</div>
		<?php
	}

	public function tools_content( $section )	{
		if( 'woolementor_tools' != $section['id'] ) return;


			$site_config = [
 				'PHP Version'				=> PHP_VERSION,
 				'WordPress Version' 		=> get_bloginfo( 'version' ),
 				'WooCommerce Version'		=> is_plugin_active( 'woocommerce/woocommerce.php' ) ? get_option( 'woocommerce_version' ) : 'Not Active',
 				'Elementor Version'			=> is_plugin_active( 'elementor/elementor.php' ) ? get_option( 'elementor_version' ) : 'Not Active',
 				'Elementor Pro Version'		=> is_plugin_active( 'elementor-pro/elementor-pro.php' ) ? get_option( 'elementor_pro_version' ) : 'Not Active',
 				'Woolementor Version'		=> $this->version,
 				'Woolementor Pro Version'	=> defined( 'WOOLEMENTOR_PRO' ) ? get_plugin_data( WOOLEMENTOR_PRO )['Version'] : 'Not Active',
 				'Woolementor Pro Activated'	=> defined( 'WOOLEMENTOR_PRO' ) && woolementor_pro_license_activated() ? 'Yes' : 'No',
 				'Active Plugins'			=> get_option( 'active_plugins' ),
				'Checkout Page ID'			=> get_option( 'woocommerce_checkout_page_id' ),
 				'Enable Debug' 				=> get_option( 'wl_enable_debug' ),
				'Enabled Widgets'			=> woolementor_active_widgets(),
 				'Checkout Fields'			=> defined( 'WOOLEMENTOR_PRO' ) ? get_option( '_woolementor_checkout_fields' ) : [],
			];
			$wl_enable_debug = get_option( 'wl_enable_debug' );
			$wl_enable_debug = $wl_enable_debug == 'yes' ? 'checked' : '';
		?>
			<div id="wl-confirm-box-container">
				<div id="wl-confirm-box">
					<div id="wl-confirm-content"><?php _e( 'Are you sure you want to reset?', 'woolementor' ) ?></div>
					<div id="wl-confirm-btns">
						<button class="wl-confirm-btn button" id="wl-cancle-reset"><?php _e( 'Cancel', 'woolementor' ) ?></button>
						<button class="wl-confirm-btn button" id="wl-confirm-reset"><?php _e( 'Confirm', 'woolementor' ) ?></button>
					</div>
				</div>	
			</div>
			<div class="cxrow">
				<div class="cx-label-wrap"><label ><?php _e( 'Enable Debug', 'woolementor' ) ?></label></div>
				<div class="cx-field-wrap">
					<label class='wl-toggle-switch <?php echo $wl_enable_debug == 'checked' ? 'active' : '' ?>'>
					  	<input type='checkbox' class='wl-widget-checkbox' id='wl-enable-debug' name='enable_debug' <?php echo $wl_enable_debug; ?>>
					  	<span class='wl-toggle-slider'></span>
					</label>
					<p class="cx-desc"><?php _e( 'Emable plugin debug', 'woolementor' ) ?></p>
				</div>
			</div>

			<div class="cxrow">
				<div class="cx-label-wrap"><label ><?php _e( 'Reset', 'woolementor' ) ?></label></div>
				<div class="cx-field-wrap">
					<div style="display: flex; gap: 10px;">
						<button id="wl-reset-widgets" class="button button-primary wl-reset-widget"><?php _e( 'Reset', 'woolementor' ) ?></button>
					</div>
					<p class="cx-desc"><?php _e( 'Reset your Woolementor settings. Don\'t do this unless you know what you\'re doing.', 'woolementor' ) ?></p>
				</div>
			</div>
			<div class="cxrow">
				<div class="cx-label-wrap"><label ><?php _e( 'Report', 'woolementor' ) ?></label></div>
				<div class="cx-field-wrap wl-report">
					<textarea id="wl-site-report" name="wl-site-report" rows="10" readonly><?php print_r( $site_config ) ?></textarea>
					<button id="wl-report-copy" class="button button-primary"><span class="dashicons dashicons-admin-page"></span></button>
					<p class="cx-desc"><?php _e( 'If you face any issues and contact the support, we may ask you about this report. Click the copy icon to copy.', 'woolementor' ) ?></p>
				</div>
			</div>
		<?php
	}
}