<?php
/**
 * All template related functions
 */

namespace codexpert\Woolementor;
use codexpert\product\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Templates_Manager
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Templates_Manager extends Base {

	public $plugin;

	/**
	 * A reference to an instance of this class.
	 *
	 */
	private static $instance = null;

	/**
	 * Template option name
	 */
	protected $option = 'woolementor_elementor_categories';

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
	}

	/**
	 * Register
	 */
	public function register_templates_source() {

		$elementor = \Elementor\Plugin::instance();
		$elementor->templates_manager->register_source( '\codexpert\Woolementor\Templates_Source' );

	}

	/**
	 * Return transient key
	 */
	public function transient_key() {
		return "{$this->option}_{$this->version}";
	}

	/**
	 * Retrieves categories list
	 */
	public function get_categories() {

		$categories = get_transient( $this->transient_key() );

		if ( !$categories ) {
			$categories = $this->remote_get_categories();
			set_transient( $this->transient_key(), $categories, DAY_IN_SECONDS );
		}

		return $categories;
	}

	/**
	 * Get categories
	 */
	public function remote_get_categories() {
		$url = WOOLEMENTOR_LIB_URL . '/block-cats';
		return json_decode( file_get_contents( $url ), true );
	}

	/**
	 * Add templates to Elementor templates list
	 */
	public function prepend_categories( $library_data ) {

		$categories = $this->get_categories();

		if ( ! empty( $categories ) ) {

			if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '2.3.9', '>' ) ) {
				$library_data['types_data']['block']['categories'] = array_merge( $categories, $library_data['types_data']['block']['categories'] );
			} else {
				$library_data['categories'] = array_merge( $categories, $library_data['categories'] );
			}

			return $library_data;

		} else {
			return $library_data;
		}

	}

	/**
	 * Register AJAX actions
	 */
	public function register_ajax_actions( $ajax ) {
		if ( ! isset( $_REQUEST['actions'] ) ) {
			return;
		}

		$actions = json_decode( stripslashes( $_REQUEST['actions'] ), true );
		$data    = false;

		foreach ( $actions as $id => $action_data ) {
			if ( ! isset( $action_data['get_template_data'] ) ) {
				$data = $action_data;
			}
		}

		if ( ! $data ) {
			return;
		}

		if ( ! isset( $data['data'] ) ) {
			return;
		}

		$data = $data['data'];

		if ( empty( $data['template_id'] ) ) {
			return;
		}

		if ( false === strpos( $data['template_id'], 'woolementor_' ) ) {
			return;
		}

		$ajax->register_ajax_action( 'get_template_data', array( $this, 'get_template_data' ) );
	}

	/**
	 * Get template data.
	 */
	public function get_template_data( $args ) {

		$source = \Elementor\Plugin::instance()->templates_manager->get_source( 'wl-templates' );

		$data = $source->get_data( $args );

		return $data;
	}

	/**
	 * Return template data insted of elementor template.
	 */
	public function force_template_source() {

		if ( empty( $_REQUEST['template_id'] ) ) {
			return;
		}

		if ( false === strpos( $_REQUEST['template_id'], 'woolementor_' ) ) {
			return;
		}

		$_REQUEST['source'] = 'wl-templates';
	}

	/**
	 * Returns the instance.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}