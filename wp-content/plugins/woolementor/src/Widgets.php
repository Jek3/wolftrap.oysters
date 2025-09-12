<?php
/**
 * All Widgets facing functions
 */

namespace codexpert\Woolementor;
use codexpert\product\Base;
use \Elementor\Plugin as Elementor_Plugin;
use \Elementor\Controls_Manager;
use \Elementor\Scheme_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Widgets
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Widgets extends Base {

	public $plugin;

	/**
	 * Constructor function
	 *
	 * @since 1.0
	 */
	public function __construct( $plugin ) {
		$this->plugin   = $plugin;
        $this->slug     = $this->plugin['TextDomain'];
        $this->name     = $this->plugin['Name'];
        $this->version  = $this->plugin['Version'];
		$this->widgets 	= woolementor_widgets();
		$this->active_widgets = woolementor_active_widgets();
		$this->active_controls = $this->active_widgets;
		$this->assets 	= WOOLEMENTOR_ASSETS;
	}

	public function editor_enqueue_styles() {
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';

		wp_enqueue_style( "{$this->slug}-editor", "{$this->assets}/css/editor{$min}.css", '', $this->version, 'all' );
	}

	/**
	 * Registers categories for widgets
	 *
	 * @since 1.0
	 */
	public function register_category( $elements_manager ) {
		foreach ( woolementor_widget_categories() as $id => $data ) {
			$elements_manager->add_category(
				$id,
				[
					'title'	=> $data['title'],
					'icon'	=> $data['icon'],
				]
			);
		}
	}

	/**
	 * Registers THE widgets
	 *
	 * @since 1.0
	 */
	public function register_widgets() {

		foreach( $this->active_widgets as $active_widget ) {
			if(
				woolementor_is_pro_feature( $active_widget ) &&
				defined( 'WOOLEMENTOR_PRO_DIR' ) &&
				woolementor_is_pro_activated() &&
				file_exists( $file = WOOLEMENTOR_PRO_DIR . "/widgets/{$active_widget}/{$active_widget}.php" )
			) {
				require_once( $file );

				$class = str_replace( ' ', '_', ucwords( str_replace( array( '-', '.php' ), array( ' ', '' ), $active_widget ) ) );
				
				$widget = "codexpert\\Woolementor_Pro\\{$class}";

				if( class_exists( $widget ) ) {
					Elementor_Plugin::instance()->widgets_manager->register_widget_type( new $widget() );
				}
			}
			elseif( file_exists( $file = WOOLEMENTOR_DIR . "/widgets/{$active_widget}/{$active_widget}.php" ) ) {
				require_once( $file );

				$class = str_replace( ' ', '_', ucwords( str_replace( array( '-', '.php' ), array( ' ', '' ), $active_widget ) ) );
				
				$widget = "codexpert\\Woolementor\\{$class}";

				if( class_exists( $widget ) ) {
					Elementor_Plugin::instance()->widgets_manager->register_widget_type( new $widget() );
				}
			}
		}
	}

	/**
	 * Registers additional controls for widgets
	 *
	 * @since 1.0
	 */
	public function register_controls() {
		
		include_once( WOOLEMENTOR_DIR . '/controls/gradient-text.php' );
        $gradient_text = __NAMESPACE__ . '\Controls\Group_Control_Gradient_Text';

        Elementor_Plugin::instance()->controls_manager->add_group_control( $gradient_text::get_type(), new $gradient_text() );
	}

	/**
	 * Enables Woolementor's place in the default content
	 *
	 * @since 1.0
	 *
	 * @TODO: use a better hook to add this
	 */
	public function the_content( $content ) {
		$content_start = apply_filters( 'woolementor-content_start', '' );
		$content_close = apply_filters( 'woolementor-content_close', '' );

		return $content_start . $content . $content_close;
	}
}