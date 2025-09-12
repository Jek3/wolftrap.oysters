<?php
/**
 * All public facing functions
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
 * @subpackage Front
 * @author codexpert <hello@codexpert.io>
 */
class Front extends Base {

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

	public function add_admin_bar( $admin_bar ) {
		if( !current_user_can( 'manage_options' ) ) return;

		$admin_bar->add_menu( [
			'id'    => $this->slug,
			'title' => $this->name,
			'href'  => add_query_arg( 'page', $this->slug, admin_url( 'admin.php' ) ),
			'meta'  => [
				'title' => $this->name,            
			],
		] );
	}
	
	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';

		// slick
		wp_register_style(  'slick', "{$this->assets}/third-party/slick/slick.css", '', '1.8.1', 'all' );
		wp_register_script( 'slick', "{$this->assets}/third-party/slick/slick.min.js", [ 'jquery' ], '1.8.1', true );

		//box-slider
		wp_register_script( 'modernizr', "{$this->assets}/third-party/box-slider/modernizr.min.js", [ 'jquery' ], $this->version, true );
		wp_register_script( 'box-slider', "{$this->assets}/third-party/box-slider/box-slider-all.jquery.min.js", [ 'jquery' ], $this->version, true );

		//lc_lightbox
		wp_register_style(  'lc_lightbox', "{$this->assets}/third-party/lc_lightbox/lc_lightbox.min.css", '', $this->version, 'all' );
		wp_register_style( 'minimal', "{$this->assets}/third-party/lc_lightbox/minimal.min.css", '', $this->version, 'all' );
		wp_register_script( 'lc_lightbox', "{$this->assets}/third-party/lc_lightbox/lc_lightbox.lite.min.js", [ 'jquery' ], $this->version, true );

		// fancybox
		wp_register_style(  'fancybox', "{$this->assets}/third-party/fancybox/jquery.fancybox.min.css", '', '3.5.7', 'all' );
		wp_register_script( 'fancybox', "{$this->assets}/third-party/fancybox/jquery.fancybox.min.js", [ 'jquery' ], '3.5.7', true );

		// DataTables
		wp_register_style(  'dataTables', "{$this->assets}/third-party/dataTables/jquery.dataTables.min.css", '', '1.10.20', 'all' );
		wp_register_script( 'dataTables', "{$this->assets}/third-party/dataTables/jquery.dataTables.min.js", [ 'jquery' ], '1.10.20', true );

		// enqueue stylesheet
		wp_enqueue_style( $this->slug, "{$this->assets}/css/front{$min}.css", '', $this->version, 'all' );
		wp_enqueue_style( "{$this->slug}-grid", "{$this->assets}/css/cx-grid{$min}.css", '', $this->version, 'all' );

		// enqueue JavaScript
		wp_enqueue_script( $this->slug, "{$this->assets}/js/front{$min}.js", [ 'jquery' ], $this->version, true );
		
		// define localized scripts
		$localized = array(
			'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
			'_nonce'		=> wp_create_nonce( $this->slug ),
			'icon'			=> file_get_contents( WOOLEMENTOR_DIR . '/icon.txt' ),
			'widgets'		=> woolementor_active_widgets(),
			'min_price'		=> floor( $min_price = woolementor_price_limit( 'min' ) ),
			'max_price'		=> ceil( $max_price = woolementor_price_limit( 'max' ) ),
			'cart_url'		=> function_exists( 'WC' ) ? wc_get_cart_url() : '',
			'crnt_min'		=> isset( $_GET['filter']['min_price'] ) ? sanitize_text_field( $_GET['filter']['min_price'] ) : floor( $min_price ),
			'crnt_max'		=> isset( $_GET['filter']['max_price'] ) ? sanitize_text_field( $_GET['filter']['max_price'] ) : ceil( $max_price ),
			'pro_installed'	=> woolementor_is_pro(),
			'pro_activated'	=> woolementor_is_pro_activated(),
		);

		wp_localize_script( $this->slug, 'WOOLEMENTOR', apply_filters( "{$this->slug}-localized", $localized ) );
	}

	/**
	 * Add some script to head
	 *
	 * @since 1.0
	 */
	public function head() {
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
	 * Overrides some page templated with Woolementor's one
	 *
	 * @since 1.0
	 */
	public function override_template( $template ) {
		if( !is_shop() && !is_tax( 'product_cat' ) ) return $template;

		return WOOLEMENTOR_DIR . '/templates/woolementor.php';
	}

	/**
	 * Adds a class to the <body> tag
	 *
	 * @since 1.0
	 */
	public function body_class( $class ) {
		$class[] = $this->slug;
		$class[] = 'wl';

		return $class;
	}

	/**
	 * Re-generate checkout fields
	 *
	 * @since 1.0
	 */
	public function regenerate_fields( $fields ) {

		if( !woolementor_is_pro() ) return $fields;

		/**
		 * @since 1.3.2
		 */
		global $post;
		if( has_shortcode( $post->post_content, 'woocommerce_checkout' ) ) return $fields;

		$_checkout_fields = get_option( '_woolementor_checkout_fields', [] );

		foreach ( $_checkout_fields as $section => $_fields ) {
			if( count( $_fields ) > 0 ) {
				foreach ( $_fields as $_field ) {
					$fields[ $section ][ $_field["{$section}_input_name"] ] = [
						'label'			=> $_field["{$section}_input_label"],
						'required'		=> $_field["{$section}_input_required"],
						'class'			=> $_field["{$section}_input_class"],
						'autocomplete'	=> $_field["{$section}_input_autocomplete"],
						'type'			=> $_field["{$section}_input_type"],
					];
				}
			}
		}

		return $fields;
	}

	/**
	 * Save additional checkout fields added with the repeater
	 *
	 * @since 1.0
	 */
	public function save_additional_fields( $order, $data ) {
		$posted = $_POST;

		unset( $posted['woocommerce-process-checkout-nonce'] );
		unset( $posted['_wp_http_referer'] );
		
		$wc_fields = woolementor_wc_fields();
		$default_fields = array_merge( $wc_fields['billing'], $wc_fields['shipping'], $wc_fields['order'] );

		foreach ( $posted as $key => $value ) {
			if( !in_array( $key, $default_fields ) ) {
				$order->update_meta_data( $key, sanitize_text_field( $value ) );
			}
		}
	}
}