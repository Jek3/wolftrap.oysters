<?php
/**
 * Plugin Name: Woolementor
 * Description: Woolementor connects the #1 page builder plugin on the earth, <strong>Elementor</strong> with the most popular eCommerce plugin, <strong>WooCommerce</strong>.
 * Plugin URI: https://woolementor.com/?utm_source=dashboard&utm_medium=plugins&utm_campaign=plugin-uri
 * Author: Woolementor
 * Version: 2.4.0
 * Author URI: https://woolementor.com/?utm_source=dashboard&utm_medium=plugins&utm_campaign=author-uri
 * Text Domain: woolementor
 * Domain Path: /languages
 *
 * Woolementor is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Woolementor is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

namespace codexpert\Woolementor;
use codexpert\product\Survey;
use codexpert\product\Notice;
use codexpert\product\Deactivator;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class for the plugin
 * @package Plugin
 * @author codexpert <hello@codexpert.io>
 */
final class Plugin {
	
	public static $_instance;

	public function __construct() {
		self::include();
		self::define();
		self::hook();
	}

	/**
	 * Includes files
	 */
	public function include() {
		require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
	}

	/**
	 * Define variables and constants
	 */
	public function define() {
		// constants
		define( 'WOOLEMENTOR', __FILE__ );
		define( 'WOOLEMENTOR_DIR', dirname( WOOLEMENTOR ) );
		define( 'WOOLEMENTOR_ASSETS', plugins_url( 'assets', WOOLEMENTOR ) );
		define( 'WOOLEMENTOR_DEBUG', apply_filters( 'woolementor-debug', get_option( 'wl_enable_debug' ) == 'yes' ) );
		define( 'WOOLEMENTOR_LIB_URL', 'https://demo.woolementor.com/wp-json/templates/v1.0' );

		// plugin data
		$this->plugin				= get_plugin_data( WOOLEMENTOR );
		$this->plugin['basename']	= plugin_basename( WOOLEMENTOR );
		$this->plugin['file']		= WOOLEMENTOR;
		$this->plugin['server']		= apply_filters( 'woolementor_server', 'https://my.codexpert.io' );
		$this->plugin['min_php']	= '5.6';
		$this->plugin['min_wp']		= '4.0';
		$this->plugin['depends']	= [ 'woocommerce/woocommerce.php' => 'WooCommerce', 'elementor/elementor.php' => 'Elementor' ];
	}

	/**
	 * Hooks
	 */
	public function hook() {

		if( is_admin() ) :

			/**
			 * Admin facing hooks
			 *
			 * To add an action, use $admin->action()
			 * To apply a filter, use $admin->filter()
			 */
			$admin = new Admin( $this->plugin );
			$admin->activate( 'install' );
			$admin->deactivate( 'uninstall' );
			$admin->action( 'admin_head', 'head' );
			$admin->action( 'admin_head', 'settings_page_redirect' );
			$admin->action( 'admin_notices', '_survey_notice' );
			$admin->action( 'admin_footer_text', 'footer_text' );
			$admin->action( 'admin_enqueue_scripts', 'enqueue_scripts' );
			$admin->action( 'plugins_loaded', 'i18n' );
			$admin->action( 'after_setup_theme', 'setup' );
			$admin->action( 'wp_dashboard_setup', 'dashboard_widget', 99 );
			$admin->action( 'woolementor_daily', 'daily' );
			$admin->filter( "plugin_action_links_{$this->plugin['basename']}", 'action_links' );
			$admin->filter( 'plugin_row_meta', 'plugin_row_meta', 10, 2 );
			$admin->filter( 'http_request_host_is_external', '__return_true', 10, 3 );

			/**
			 * Settings related hooks
			 *
			 * To add an action, use $settings->action()
			 * To apply a filter, use $settings->filter()
			 */
			$settings = new Settings( $this->plugin );
			$settings->action( 'plugins_loaded', 'init_menu' );
			$settings->action( 'cx-settings-before-form', 'help_content' );
			$settings->action( 'cx-settings-before-form', 'tools_content' );
			$settings->action( 'admin_bar_menu', 'add_admin_bar', 70 );

			// Product related classes
			$survey			= new Survey( $this->plugin );
			$notice			= new Notice( $this->plugin );
			$deactivator	= new Deactivator( $this->plugin );

		else : // is_admin() ?

			/**
			 * Front facing hooks
			 *
			 * To add an action, use $front->action()
			 * To apply a filter, use $front->filter()
			 */
			$front = new Front( $this->plugin );
			$front->action( 'wp_head', 'head' );
			$front->action( 'after_setup_theme', 'setup' );
			$front->action( 'admin_bar_menu', 'add_admin_bar', 70 );
			$front->action( 'wp_enqueue_scripts', 'enqueue_scripts' );
			$front->action( 'woocommerce_checkout_create_order', 'save_additional_fields', 10, 2 );
			$front->filter( 'body_class', 'body_class' );
			$front->filter( 'woocommerce_checkout_fields', 'regenerate_fields' );

			
			/**
			 * Templates and library
			 *
			 * To add an action, use $settings->action()
			 * To apply a filter, use $settings->filter()
			 *
			 * @since 1.0
			 */
			$templates = new Templates_Manager( $this->plugin );
			$templates->action( 'elementor/init', 'register_templates_source' );
			$templates->filter( 'option_elementor_remote_info_library', 'prepend_categories' );
			$templates->action( 'elementor/ajax/register_actions', 'register_ajax_actions', 20 );

		endif;

		/**
		 * Widgets related hooks
		 *
		 * To add an action, use $settings->action()
		 * To apply a filter, use $settings->filter()
		 *
		 * @since 1.0
		 */
		$widgets = new Widgets( $this->plugin );
		$widgets->action( 'elementor/elements/categories_registered', 'register_category' );
		$widgets->action( 'elementor/widgets/widgets_registered', 'register_widgets' );
		$widgets->action( 'elementor/controls/controls_registered', 'register_controls' );
		$widgets->action( 'elementor/editor/after_enqueue_scripts', 'editor_enqueue_styles' );
		$widgets->action( 'elementor/frontend/the_content', 'the_content' );


		/**
		 * AJAX facing hooks
		 *
		 * To add a hook for logged in users, use $ajax->priv()
		 * To add a hook for non-logged in users, use $ajax->nopriv()
		 */
		$ajax = new AJAX( $this->plugin );
		$ajax->priv( 'wl-search-docs', 'search_docs' );
		$ajax->all( 'add-to-wish', 'add_to_wish' );
		$ajax->all( 'add-variations-to-cart', 'add_variations_to_cart' );
		$ajax->all( 'multiple-product-add-to-cart', 'multiple_product_add_to_cart' );
		$ajax->all( 'widget-survey', 'widget_survey' );
		$ajax->priv( 'wl-reset', 'reset' );
		$ajax->priv( 'wl-enable-debug', 'enable_debug' );
	}

	/**
	 * Cloning is forbidden.
	 */
	private function __clone() { }

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	// private function __wakeup() { }

	/**
	 * Instantiate the plugin
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

Plugin::instance();