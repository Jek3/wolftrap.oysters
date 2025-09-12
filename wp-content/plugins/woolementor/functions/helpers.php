<?php
if( !function_exists( 'get_plugin_data' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if( ! function_exists( 'woolementor_pri' ) ) :
function woolementor_pri( $data ) {
	echo '<pre>';
	if( is_object( $data ) || is_array( $data ) ) {
		print_r( $data );
	}
	else {
		var_dump( $data );
	}
	echo '</pre>';
}
endif;

if( ! function_exists( 'woolementor_get_posts' ) ) :
function woolementor_get_posts( $post_type = 'post', $show_instruction = true, $show_cached = false, $limit = -1 ) {
	$arg = [
		'post_type'         => $post_type,
		'posts_per_page'    => $limit
	];
	$p = new WP_Query( $arg );
	$posts = $show_instruction ? [ '' => sprintf( __( '- Choose a %s -', 'woolementor' ), $post_type ) ] : [];
	if( $show_cached && false !== ( $cached_posts = wp_cache_get( "woolementor_{$post_type}", 'woolementor' ) ) ) {
		return apply_filters( 'woolementor_get_posts', ( $posts + $cached_posts ), $post_type, $limit );
	}
	foreach( $p->posts as $post ) :
		$posts[ $post->ID ] = $post->post_title;
	endforeach;
	wp_cache_add( "woolementor_{$post_type}", $posts, 'woolementor', 3600 );
	return apply_filters( 'woolementor_get_posts', $posts, $post_type, $limit );
}
endif;

if( ! function_exists( 'woolementor_get_option' ) ) :
function woolementor_get_option( $key, $section, $default = '' ) {

	$options = get_option( $key );

	if ( isset( $options[ $section ] ) ) {
		return $options[ $section ];
	}

	return $default;
}
endif;

if( !function_exists( 'woolementor_get_template' ) ) :
/**
 * Includes a template file resides in /views diretory
 *
 * It'll look into /woolementor directory of your active theme
 * first. if not found, default template will be used.
 * can be overriden with woolementor_template_override_dir hook
 *
 * @param string $slug slug of template. Ex: template-slug.php
 * @param string $sub_dir sub-directory under base directory
 * @param array $fields fields of the form
 */
function woolementor_get_template( $slug, $base = 'views', $args = null ) {

	// templates can be placed in this directory
	$override_template_dir = apply_filters( 'woolementor_template_override_dir', get_stylesheet_directory() . '/woolementor/', $slug, $base, $args );
	
	// default template directory
	$plugin_template_dir = dirname( WOOLEMENTOR ) . "/{$base}/";

	// full path of a template file in plugin directory
	$plugin_template_path =  $plugin_template_dir . $slug . '.php';
	
	// full path of a template file in override directory
	$override_template_path =  $override_template_dir . $slug . '.php';

	// if template is found in override directory
	if( file_exists( $override_template_path ) ) {
		ob_start();
		include $override_template_path;
		return ob_get_clean();
	}
	// otherwise use default one
	elseif ( file_exists( $plugin_template_path ) ) {
		ob_start();
		include $plugin_template_path;
		return ob_get_clean();
	}
	else {
		return __( 'Template not found!', 'woolementor' );
	}
}
endif;

/**
 * Generates some action links of a plugin
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_action_link' ) ) :
function woolementor_action_link( $plugin, $action = '' ) {

	$exploded	= explode( '/', $plugin );
	$slug		= $exploded[0];

	$links = [
		'install'		=> wp_nonce_url( admin_url( "update.php?action=install-plugin&plugin={$slug}" ), "install-plugin_{$slug}" ),
		'update'		=> wp_nonce_url( admin_url( "update.php?action=upgrade-plugin&plugin={$plugin}" ), "upgrade-plugin_{$plugin}" ),
		'activate'		=> wp_nonce_url( admin_url( "plugins.php?action=activate&plugin={$plugin}&plugin_status=all&paged=1&s" ), "activate-plugin_{$plugin}" ),
		'deactivate'	=> wp_nonce_url( admin_url( "plugins.php?action=deactivate&plugin={$plugin}&plugin_status=all&paged=1&s" ), "deactivate-plugin_{$plugin}" ),
	];

	if( $action != '' && array_key_exists( $action, $links ) ) return $links[ $action ];

	return $links;
}
endif;

/**
 * Checks either we're in the edit mode
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_is_edit_mode' ) ) :
function woolementor_is_edit_mode( $post_id = 0 ) {
	return \Elementor\Plugin::$instance->editor->is_edit_mode( $post_id );
}
endif;

/**
 * Checks either we're in the preview mode
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_is_preview_mode' ) ) :
function woolementor_is_preview_mode( $post_id = 0 ) {
	if ( empty( $post_id ) ) {
		$post_id = get_the_ID();
	}

	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return false;
	}

	if ( !isset( $_GET['preview_id'] ) || $post_id !== (int) $_GET['preview_id'] ) {
		return false;
	}

	return true;
}
endif;

/**
 * Checks either we're in the live mode
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_is_live_mode' ) ) :
function woolementor_is_live_mode( $post_id = 0 ) {
	return !woolementor_is_edit_mode( $post_id ) && !woolementor_is_preview_mode( $post_id );
}
endif;

/**
 * List of Woolementor widgets
 *
 * @icons https://elementor.github.io/elementor-icons/
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_widgets' ) ) :
function woolementor_widgets() {
	$widgets = [
		/**
		 * Shop widgets
		 */
		'shop-classic'		=> [
			'title'			=> __( 'Shop Classic', 'woolementor' ),
			'icon'			=> 'eicon-gallery-grid',
			'categories'	=> [ 'woolementor-shop', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/shop-classic/',
			'keywords'		=> [ 'cart', 'store', 'products', 'shop', 'grid', 'regular' ],
		],
		'shop-standard'		=> [
			'title'			=> __( 'Shop Standard', 'woolementor' ),
			'icon'			=> 'eicon-apps',
			'categories'	=> [ 'woolementor-shop', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/shop-standard/',
			'keywords'		=> [ 'cart', 'store', 'products', 'shop', 'grid', 'regular' ],
		],
		'shop-flip'			=> [
			'title'			=> __( 'Shop Flip', 'woolementor' ),
			'icon'			=> 'eicon-flip-box',
			'categories'	=> [ 'woolementor-shop', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/shop-flip/',
			'keywords'		=> [ 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ],
			'pro_feature'	=> true,
		],
		'shop-trendy'		=> [
			'title'			=> __( 'Shop Trendy', 'woolementor' ),
			'icon'			=> 'eicon-products',
			'categories'	=> [ 'woolementor-shop', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/shop-trendy/',
			'keywords'		=> [ 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ],
			'pro_feature'	=> true,
		],
		'shop-curvy'		=> [
			'title'			=> __( 'Shop Curvy', 'woolementor' ),
			'icon'			=> 'eicon-posts-grid',
			'categories'	=> [ 'woolementor-shop', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/shop-curvy/',
			'keywords'		=> [ 'cart', 'store', 'products', 'shop', 'grid', 'elegant' ],
		],
		'shop-curvy-horizontal'	=> [
			'title'			=> __( 'Shop Curvy Horizontal', 'woolementor' ),
			'icon'			=> 'eicon-posts-group',
			'categories'	=> [ 'woolementor-shop', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/shop-curvy-horizontal/',
			'keywords'		=> [ 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ],
			'pro_feature'	=> true,
		],
		'shop-slider'	=> [
			'title'			=> __( 'Shop Slider', 'woolementor' ),
			'icon'			=> 'eicon-slider-device',
			'categories'	=> [ 'woolementor-shop', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/shop-slider/',
			'keywords'		=> [ 'cart', 'store', 'products', 'shop', 'grid', 'slider' ],
		],
		'shop-accordion'	=> [
			'title'			=> __( 'Shop Accordion', 'woolementor' ),
			'icon'			=> 'eicon-accordion',
			'categories'	=> [ 'woolementor-shop', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/shop-accordion/',
			'keywords'		=> [ 'cart', 'store', 'products', 'shop', 'grid', 'accordion' ],
			'pro_feature'	=> true,
		],
		'shop-table'		=> [
			'title'			=> __( 'Shop Table', 'woolementor' ),
			'icon'			=> 'eicon-table',
			'categories'	=> [ 'woolementor-shop', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/shop-table/',
			'keywords'		=> [ 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ],
			'pro_feature'	=> true,
		],
		'shop-beauty'		=> [
			'title'			=> __( 'Shop Beauty', 'woolementor' ),
			'icon'			=> 'eicon-table',
			'categories'	=> [ 'woolementor-shop', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/shop-beauty/',
			'keywords'		=> [ 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ],
			'pro_feature'	=> true,
		],

		/**
		 * Shop filter
		 */
		'filter-horizontal'	=> [
			'title'			=> __( 'Filter Horizontal', 'woolementor' ),
			'icon'			=> 'eicon-ellipsis-h',
			'categories'	=> [ 'woolementor-filter', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/filter-horizontal/',
			'keywords'		=> [ 'cart', 'store', 'products', 'product', 'single', 'single-product', 'filter', 'horizontal' ],
		],
		'filter-vertical'	=> [
			'title'			=> __( 'Filter Vertical', 'woolementor' ),
			'icon'			=> 'eicon-ellipsis-v',
			'categories'	=> [ 'woolementor-filter', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/filter-vertical/',
			'keywords'		=> [ 'cart', 'store', 'products', 'product', 'single', 'single-product', 'filter', 'verticle' ],
			'pro_feature'	=> true,
		],
		
		/*
		* Single Product
		*/
		'product-title'	=> [
			'title'			=> __( 'Product Title', 'woolementor' ),
			'icon'			=> 'eicon-post-title',
			'categories'	=> [ 'woolementor-single', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/product-title/',
			'keywords'		=> [ 'cart', 'store', 'products', 'product-title', 'single', 'single-product' ],
		],
		'product-breadcrumbs'	=> [
			'title'			=> __( 'Breadcrumbs', 'woolementor' ),
			'icon'			=> 'eicon-post-navigation',
			'categories'	=> [ 'woolementor-single', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/breadcrumbs/',
			'keywords'		=> [ 'cart', 'breadcrumbs', 'single', 'product' ],
		],
		'product-short-description'	=> [
			'title'			=> __( 'Product Short Description', 'woolementor' ),
			'icon'			=> 'eicon-product-description',
			'categories'	=> [ 'woolementor-single', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/product-short-description/',
			'keywords'		=> [ 'cart', 'products', 'product', 'short', 'description', 'single', 'product' ],
		],
		'product-variations'=> [
			'title'			=> __( 'Product Variations', 'woolementor' ),
			'icon'			=> 'eicon-product-related',
			'categories'	=> [ 'woolementor-single', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/product-variations/',
			'keywords'		=> [ 'cart', 'store', 'products', 'product-title', 'single', 'single-product' ],
		],
		'product-add-to-cart'	=> [
			'title'			=> __( 'Add to Cart', 'woolementor' ),
			'icon'			=> 'eicon-cart',
			'categories'	=> [ 'woolementor-single', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/add-to-cart/',
			'keywords'		=> [ 'cart', 'add to cart', 'add-to-cart', 'short', 'single', 'product' ],
		],
		'product-sku'	=> [
			'title'			=> __( 'Product SKU', 'woolementor' ),
			'icon'			=> 'eicon-anchor',
			'categories'	=> [ 'woolementor-single', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/add-to-cart/',
			'keywords'		=> [ 'cart', 'add to cart', 'sku', 'short', 'single', 'product' ],
		],
		'product-categories'	=> [
			'title'			=> __( 'Product Categories', 'woolementor' ),
			'icon'			=> 'eicon-flow',
			'categories'	=> [ 'woolementor-single', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/add-to-cart/',
			'keywords'		=> [ 'cart', 'category', 'categories', 'short', 'single', 'product' ],
		],
		'product-tags'	=> [
			'title'			=> __( 'Product Tags', 'woolementor' ),
			'icon'			=> 'eicon-tags',
			'categories'	=> [ 'woolementor-single', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/add-to-cart/',
			'keywords'		=> [ 'cart', 'add to cart', 'tags', 'short', 'single', 'product' ],
		],
		'product-thumbnail'		=> [
			'title'			=> __( 'Product Thumbnail', 'woolementor' ),
			'icon'			=> 'eicon-featured-image',
			'categories'	=> [ 'woolementor-single' ],
			'demo'			=> 'https://demo.woolementor.com/product-thumbnail',
			'keywords'		=> [ 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'product-thumbnail' ],
		],
		'product-add-to-wishlist'	=> [
			'title'			=> __( 'Add to wishlist', 'woolementor' ),
			'icon'			=> 'eicon-tags',
			'categories'	=> [ 'woolementor-single', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/add-to-cart/',
			'keywords'		=> [ 'cart', 'add to cart', 'add to wishlist', 'tags', 'short', 'single', 'product' ],
		],

		/**
		 * Pricing tables
		 */
		'pricing-table-advanced'	=> [
			'title'			=> __( 'Pricing Table Advanced', 'woolementor' ),
			'icon'			=> 'eicon-price-table',
			'categories'	=> [ 'woolementor-pricing', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/pricing-table-advanced/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing' ],
		],
		'pricing-table-basic'	=> [
			'title'			=> __( 'Pricing Table Basic', 'woolementor' ),
			'icon'			=> 'eicon-price-table',
			'categories'	=> [ 'woolementor-pricing', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/pricing-table-basic/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing' ],
		],
		'pricing-table-regular'	=> [
			'title'			=> __( 'Pricing Table Regular', 'woolementor' ),
			'icon'			=> 'eicon-price-table',
			'categories'	=> [ 'woolementor-pricing', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/pricing-table-regular/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing' ],
			'pro_feature'	=> true,
		],
		'pricing-table-smart'	=> [
			'title'			=> __( 'Pricing Table Smart', 'woolementor' ),
			'icon'			=> 'eicon-price-table',
			'categories'	=> [ 'woolementor-pricing', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/pricing-table-smart/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing' ],
			'pro_feature'	=> true,
		],
		'pricing-table-fancy'	=> [
			'title'			=> __( 'Pricing Table Fancy', 'woolementor' ),
			'icon'			=> 'eicon-price-table',
			'categories'	=> [ 'woolementor-pricing', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/pricing-table-fancy/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing' ],
			'pro_feature'	=> true,
		],

		/**
		 * Related Products
		 */
		'related-products-classic'	=> [
			'title'			=> __( 'Related Products Classic', 'woolementor' ),
			'icon'			=> 'eicon-gallery-grid',
			'categories'	=> [ 'woolementor-related', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/related-products-classic/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing', 'related-products-classic' ],
		],
		'related-products-standard'	=> [
			'title'			=> __( 'Related Products Standard', 'woolementor' ),
			'icon'			=> 'eicon-apps',
			'categories'	=> [ 'woolementor-related', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/related-products-standard/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing', 'related-products-standard' ],
		],
		'related-products-flip'	=> [
			'title'			=> __( 'Related Products Flip', 'woolementor' ),
			'icon'			=> 'eicon-flip-box',
			'categories'	=> [ 'woolementor-related', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/related-products-flip/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing', 'related-products-flip' ],
			'pro_feature'	=> true,
		],
		'related-products-trendy'	=> [
			'title'			=> __( 'Related Products Trendy', 'woolementor' ),
			'icon'			=> 'eicon-products',
			'categories'	=> [ 'woolementor-related', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/related-products-trendy/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing', 'related-products-trendy' ],
			'pro_feature'	=> true,
		],
		'related-products-curvy'	=> [
			'title'			=> __( 'Related Products Curvy', 'woolementor' ),
			'icon'			=> 'eicon-posts-grid',
			'categories'	=> [ 'woolementor-related', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/related-products-curvy/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing', 'related-products-curvy' ],
		],
		'related-products-accordion'	=> [
			'title'			=> __( 'Related Products Accordion', 'woolementor' ),
			'icon'			=> 'eicon-accordion',
			'categories'	=> [ 'woolementor-related', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/related-products-accordion/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing', 'related-products-accordion' ],
			'pro_feature'	=> true,
		],
		'related-products-table'	=> [
			'title'			=> __( 'Related Products Table', 'woolementor' ),
			'icon'			=> 'eicon-table',
			'categories'	=> [ 'woolementor-related', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/related-products-table/',
			'keywords'		=> [ 'cart', 'single', 'pricing-table', 'pricing', 'related-products-table' ],
			'pro_feature'	=> true,
		],

		/**
		 * Photo gallery
		 */
		'gallery-fancybox'	=> [
			'title'			=> __( 'Gallery Fancybox', 'woolementor' ),
			'icon'			=> 'eicon-slider-push',
			'categories'	=> [ 'woolementor-gallery', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/gallery-fancybox/',
			'keywords'		=> [ 'cart', 'single', 'product-gallery-fancybox' ],
		],
		'gallery-lc-lightbox'	=> [
			'title'			=> __( 'Gallery LC Lightbox', 'woolementor' ),
			'icon'			=> 'eicon-gallery-group',
			'categories'	=> [ 'woolementor-gallery', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/gallery-lc-lightbox/',
			'keywords'		=> [ 'cart', 'single', 'product-gallery-lightbox' ],
		],
		'gallery-box-slider'	=> [
			'title'			=> __( 'Gallery Box Slider', 'woolementor' ),
			'icon'			=> 'eicon-slider-album',
			'categories'	=> [ 'woolementor-gallery', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/gallery-box-slider/',
			'keywords'		=> [ 'cart', 'single', 'product-gallery-adaptor' ],
		],

		/**
		 * Cart widgets
		 */
		'cart-items'		=> [
			'title'			=> __( 'Cart Items', 'woolementor' ),
			'icon'			=> 'eicon-products',
			'categories'	=> [ 'woolementor-cart', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/cart/',
			'keywords'		=> [ 'cart', 'store', 'products', 'cart-items-standard' ],
		],
		'cart-overview'		=> [
			'title'			=> __( 'Cart Overview', 'woolementor' ),
			'icon'			=> 'eicon-product-price',
			'categories'	=> [ 'woolementor-cart', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/cart/',
			'keywords'		=> [ 'cart', 'store', 'products', 'cart-overview-standard' ],
		],
		'coupon-form'		=> [
			'title'			=> __( 'Coupon Form', 'woolementor' ),
			'icon'			=> 'eicon-product-meta',
			'categories'	=> [ 'woolementor-cart', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/cart/',
			'keywords'		=> [ 'cart', 'store', 'products', 'coupon-form-standard' ],
		],

		/*
		*Checkout Page items
		*/
		'billing-address'	=> [
			'title'			=> __( 'Billing Address', 'woolementor' ),
			'icon'			=> 'eicon-google-maps',
			'categories'	=> [ 'woolementor-checkout', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/checkout/',
			'keywords'		=> [ 'cart', 'single', 'billing', 'address', 'form' ],
			'pro_feature'	=> true,
		],
		'shipping-address'	=> [
			'title'			=> __( 'Shipping Address', 'woolementor' ),
			'icon'			=> 'eicon-google-maps',
			'categories'	=> [ 'woolementor-checkout', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/checkout/',
			'keywords'		=> [ 'cart', 'single', 'shipping', 'address', 'form' ],
			'pro_feature'	=> true,
		],
		'order-notes'		=> [
			'title'			=> __( 'Order Notes', 'woolementor' ),
			'icon'			=> 'eicon-table-of-contents',
			'categories'	=> [ 'woolementor-checkout', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/checkout/',
			'keywords'		=> [ 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes' ],
			'pro_feature'	=> true,
		],
		'order-review'		=> [
			'title'			=> __( 'Order Review', 'woolementor' ),
			'icon'			=> 'eicon-product-info',
			'categories'	=> [ 'woolementor-checkout', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/checkout/',
			'keywords'		=> [ 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review' ],
			'pro_feature'	=> true,
		],
		'order-pay'		=> [
			'title'			=> __( 'Order Pay', 'woolementor' ),
			'icon'			=> 'eicon-product-info',
			'categories'	=> [ 'woolementor-checkout', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/checkout/',
			'keywords'		=> [ 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'pay' ],
			'pro_feature'	=> true,
		],
		'payment-methods'	=> [
			'title'			=> __( 'Payment Methods', 'woolementor' ),
			'icon'			=> 'eicon-product-upsell',
			'categories'	=> [ 'woolementor-checkout', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/checkout/',
			'keywords'		=> [ 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'payment', 'methods' ],
			'pro_feature'	=> true,
		],
		'thankyou'			=> [
			'title'			=> __( 'Thank You', 'woolementor' ),
			'icon'			=> 'eicon-nerd',
			'categories'	=> [ 'woolementor-checkout', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/thank-you/',
			'keywords'		=> [ 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'thank', 'you', 'thankyou' ],
			'pro_feature'	=> true,
		],
		'checkout-login'	=> [
			'title'			=> __( 'Checkout Login', 'woolementor' ),
			'icon'			=> 'eicon-lock-user',
			'categories'	=> [ 'woolementor-checkout', 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/thank-you/',
			'keywords'		=> [ 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'thank', 'you', 'thankyou' ],
			'pro_feature'	=> true,
		],

		/*
		* Others Widgets
		*/
		'my-account'		=> [
			'title'			=> __( 'My Account', 'woolementor' ),
			'icon'			=> 'eicon-call-to-action',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/my-account/',
			'keywords'		=> [ 'my', 'account', 'cart', 'customer' ],
		],
		'wishlist'			=> [
			'title'			=> __( 'Wishlist', 'woolementor' ),
			'icon'			=> 'eicon-heart-o',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/wishlist/',
			'keywords'		=> [ 'cart', 'store', 'products', 'coupon-form-standard', 'wish', 'list' ],
			'pro_feature'	=> true,
		],
		'customer-reviews-classic'		=> [
			'title'			=> __( 'Customer Reviews Classic', 'woolementor' ),
			'icon'			=> 'eicon-product-rating',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/customer-reviews-classic/',
			'keywords'		=> [ 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'customer-reviews-vertical', 'customer-reviews', 'vertical' ],
		],
		'customer-reviews-standard'		=> [
			'title'			=> __( 'Customer Reviews Standard', 'woolementor' ),
			'icon'			=> 'eicon-rating',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/customer-reviews-standard/',
			'keywords'		=> [ 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'customer-reviews-horizontal', 'customer-reviews', 'horizontal' ],
			'pro_feature'	=> true,
		],
		'faqs-accordion'		=> [
			'title'			=> __( 'FAQs Accordion', 'woolementor' ),
			'icon'			=> 'eicon-accordion',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/faqs-accordion',
			'keywords'		=> [ 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product' ],
			'pro_feature'	=> true,
		],
		'tabs-basic'		=> [
			'title'			=> __( 'Tabs Basic', 'woolementor' ),
			'icon'			=> 'eicon-tabs',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/tabs-basic/',
			'keywords'		=> [ 'tab', 'tabs', 'content tab', 'menu', 'tabs basic' ],
		],
		'tabs-classic'		=> [
			'title'			=> __( 'Tabs Classic', 'woolementor' ),
			'icon'			=> 'eicon-tabs',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/tabs-classic',
			'keywords'		=> [ 'tab', 'tabs', 'content tab', 'menu', 'tabs classic' ],
		],
		'tabs-fancy'		=> [
			'title'			=> __( 'Tabs Fancy', 'woolementor' ),
			'icon'			=> 'eicon-tabs',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/tabs-fancy',
			'keywords'		=> [ 'tab', 'tabs', 'content tab', 'menu', 'tabs fancy' ],
		],
		'tabs-beauty'		=> [
			'title'			=> __( 'Tabs Beauty', 'woolementor' ),
			'icon'			=> 'eicon-tabs',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/tabs-beauty',
			'keywords'		=> [ 'tab', 'tabs', 'content tab', 'menu', 'tabs beauty' ],
		],
		'gradient-button'		=> [
			'title'			=> __( 'Gradient Button', 'woolementor' ),
			'icon'			=> 'eicon-button',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/gradient-button',
			'keywords'		=> [ 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product' ],
		],
		'sales-notification'		=> [
			'title'			=> __( 'Sales Notification', 'woolementor' ),
			'icon'			=> 'eicon-posts-ticker',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/sales-notification',
			'keywords'		=> [ 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product' ],
			'pro_feature'	=> true,
		],
		'category'		=> [
			'title'			=> __( 'Shop Categories', 'woolementor' ),
			'icon'			=> 'eicon-flow',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/shop-categories',
			'keywords'		=> [ 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category' ],
			'pro_feature'	=> true,
		],
		'basic-menu'		=> [
			'title'			=> __( 'Basic Menu', 'woolementor' ),
			'icon'			=> 'eicon-nav-menu',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/basic-menu',
			'keywords'		=> [ 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'basic-menu' ],
			'pro_feature'	=> true,
		],
		'dynamic-tabs'		=> [
			'title'			=> __( 'Dynamic Tabs', 'woolementor' ),
			'icon'			=> 'eicon-tabs',
			'categories'	=> [ 'woolementor' ],
			'demo'			=> 'https://demo.woolementor.com/dynamic-tabs',
			'keywords'		=> [ 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'dynamic-tabs' ],
			'pro_feature'	=> true,
		],
	];

	return apply_filters( 'woolementor_widgets', $widgets );
}
endif;

/**
 * List of Woolementor widget categories
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_widget_categories' ) ) :
function woolementor_widget_categories() {
	$categories = [
		'woolementor-shop' => [
			'title'	=> __( 'Woolementor - Shop', 'woolementor' ),
			'icon'	=> 'eicon-cart',
		],
		'woolementor-filter' => [
			'title'	=> __( 'Woolementor - Filter', 'woolementor' ),
			'icon'	=> 'eicon-search',
		],
		'woolementor-single' => [
			'title'	=> __( 'Woolementor - Single Product', 'woolementor' ),
			'icon'	=> 'eicon-cart',
		],
		'woolementor-pricing' => [
			'title'	=> __( 'Woolementor - Pricing Table', 'woolementor' ),
			'icon'	=> 'eicon-cart',
		],
		'woolementor-related' => [
			'title'	=> __( 'Woolementor - Related Products', 'woolementor' ),
			'icon'	=> 'eicon-cart',
		],
		'woolementor-gallery' => [
			'title'	=> __( 'Woolementor - Image Gallery', 'woolementor' ),
			'icon'	=> 'eicon-photo-library',
		],
		'woolementor-cart' => [
			'title'	=> __( 'Woolementor - Cart', 'woolementor' ),
			'icon'	=> 'eicon-cart',
		],
		'woolementor-checkout' => [
			'title'	=> __( 'Woolementor - Checkout', 'woolementor' ),
			'icon'	=> 'eicon-cart',
		],
		'woolementor' => [
			'title'	=> __( 'Woolementor - Others', 'woolementor' ),
			'icon'	=> 'eicon-skill-bar',
		],
	];

	return apply_filters( 'woolementor_widget_categories', $categories );
}
endif;

/**
 * Get a widget data by $id or __CLASS__
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_get_widget' ) ) :
function woolementor_get_widget( $id ) {
	$widgets = woolementor_widgets();

	// if a __CLASS__ name was supplied as $id
	$id = woolementor_get_widget_id( $id );

	return isset( $widgets[ $id ] ) ? $widgets[ $id ] : false;
}
endif;

/**
 * Get widget $id from __CLASS__ name
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_get_widget_id' ) ) :
function woolementor_get_widget_id( $__CLASS__ ) {
	
	// if it's under a namespace
	if( strpos( $__CLASS__, '\\' ) !== false ) {
		$path = explode( '\\', $__CLASS__ );
		$__CLASS__ = array_pop( $path );
	}

	return strtolower( str_replace( '_', '-', $__CLASS__ ) );
}
endif;

/**
 * Determines if a widget is a pro feature or not
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_is_pro_feature' ) ) :
function woolementor_is_pro_feature( $id ) {
	$widgets = woolementor_widgets();
	return isset( $widgets[ $id ]['pro_feature'] ) && $widgets[ $id ]['pro_feature'];
}
endif;

/**
 * List widgets enabled by the admin
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_active_widgets' ) ) :
function woolementor_active_widgets() {
	$active_widgets = get_option( 'woolementor_widgets' ) ? : [];

	return apply_filters( 'woolementor_active_widgets', array_keys( $active_widgets ) );
}
endif;

/**
 * Get Woolementor logo
 *
 * @param boolean $img either we want to return an <img /> tag
 *
 * @since 1.0
 *
 * @return string image url or tag
 */
if( !function_exists( 'woolementor_get_icon' ) ) :
function woolementor_get_icon( $img = false ) {
	$url = WOOLEMENTOR_ASSETS . '/img/icon.png';

	if( $img ) return "<img src='{$url}'>";

	return $url;
}
endif;

/**
 * Determines if the pro version is installed
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_is_pro' ) ) :
function woolementor_is_pro() {
	return apply_filters( 'woolementor-is_pro', false );
}
endif;

/**
 * Determines if the pro version is activated
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_is_pro_activated' ) ) :
function woolementor_is_pro_activated() {
	return function_exists( 'woolementor_pro_license_activated' ) && woolementor_pro_license_activated();
}
endif;

/**
 * Generates some action links of a plugin
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_action_link' ) ) :
function woolementor_action_link( $plugin, $action = '' ) {

	$exploded	= explode( '/', $plugin );
	$slug		= $exploded[0];

	$links = [
		'install'		=> wp_nonce_url( admin_url( "update.php?action=install-plugin&plugin={$slug}" ), "install-plugin_{$slug}" ),
		'update'		=> wp_nonce_url( admin_url( "update.php?action=upgrade-plugin&plugin={$plugin}" ), "upgrade-plugin_{$plugin}" ),
		'activate'		=> wp_nonce_url( admin_url( "plugins.php?action=activate&plugin={$plugin}&plugin_status=all&paged=1&s" ), "activate-plugin_{$plugin}" ),
		'deactivate'	=> wp_nonce_url( admin_url( "plugins.php?action=deactivate&plugin={$plugin}&plugin_status=all&paged=1&s" ), "deactivate-plugin_{$plugin}" ),
	];

	if( $action != '' && array_key_exists( $action, $links ) ) return $links[ $action ];

	return $links;
}
endif;

/**
 * List product categories
 *
 * @since 1.0
 *
 * @return array
 */
if( !function_exists( 'woolementor_get_terms' ) ) :
function woolementor_get_terms( $taxonomy = 'product_cat' ) {

	$terms = get_terms( [ 'taxonomy' => $taxonomy, 'hide_empty' => false ] );
	$cats = [];
	if ( is_array( $terms ) ) {		
		foreach ( $terms as $term ) {
			if ( isset( $term->term_id ) ) {
		    	$cats[ $term->term_id ] = $term->name;
			}
		}
	}
	return $cats;
}
endif;

/**
 * Get wishlist of the user
 *
 * @var int $user_id user ID
 *
 * @since 1.0
 *
 * @return array
 */
if( !function_exists( 'woolementor_get_wishlist' ) ) :
function woolementor_get_wishlist( $user_id = 0 ) {
	$_wishlist_key = '_woolementor-wishlist';
	$_wishlist = [];

	if( $user_id != 0 ) {
		$_wishlist = get_user_meta( $user_id, $_wishlist_key, true ) ? : [];
	}
	elseif( isset( $_COOKIE[ $_wishlist_key ] ) ) {
		$_wishlist = unserialize( stripslashes( $_COOKIE[ $_wishlist_key ] ) );
	}

	return apply_filters( 'woolementor-wishlist', array_unique( $_wishlist ) );
}
endif;

/**
 * Set wishlist of the user
 *
 * @var array $wishlist a set of product IDs
 * @var int $user_id user ID
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_set_wishlist' ) ) :
function woolementor_set_wishlist( $wishlist, $user_id = 0 ) {
	$_wishlist_key = '_woolementor-wishlist';
	$_wishlist = [];

	if( $user_id != 0 ) {
		update_user_meta( $user_id, $_wishlist_key, $wishlist );
	}
	else {
		setcookie( $_wishlist_key, serialize( $wishlist ), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
	}
}
endif;

/**
 * Order options used for product query
 *
 * @since 1.0
 *
 * @return []
 */
if( !function_exists( 'woolementor_order_options' ) ) :
function woolementor_order_options() {
	$options = [
        'none'      			=> __( 'None', 'woolementor' ),
        'ID'        			=> __( 'ID', 'woolementor' ),
        'title'     			=> __( 'Title', 'woolementor' ),
        'name'      			=> __( 'Name', 'woolementor' ),
        'date'      			=> __( 'Date', 'woolementor' ),
        'rand'      			=> __( 'Random', 'woolementor' ),
        'menu_order'      		=> __( 'Menu Order', 'woolementor' ),
        '_price' 				=> __( 'Product Price', 'woolementor' ),
        'total_sales' 			=> __( 'Top Seller', 'woolementor' ),
        'comment_count' 		=> __( 'Most Reviewed', 'woolementor' ),
        '_wc_average_rating'	=> __( 'Top Rated', 'woolementor' ),
    ];

    return apply_filters( 'woolementor-order_options', $options );
}
endif;

/**
 * Query products based on input
 *
 * @since 1.0
 *
 * @return []
 */
if( !function_exists( 'woolementor_query_products' ) ) :
function woolementor_query_products( $query ) {
	extract( $query );

	$paged  = get_query_var( 'paged') ? get_query_var( 'paged') : 1;
	// global $wp_query;
	// woolementor_pri(is_front_page());
	// woolementor_pri($wp_query->query);

	if ( is_front_page() ) {
		global $wp_query;
		if ( is_array( $wp_query->query ) && count( $wp_query->query ) > 0 && isset( $wp_query->query['paged'] ) ) {
			$paged = $wp_query->query['paged'];
		}
	}

	if( !empty( $_GET['q'] ) ){
        $paged = 1;
    }

    $args   = array(
        'post_type'         => 'product',
        'post_status '		=> 'publish',
        'posts_per_page'    =>  ( isset( $number ) ? $number : 10 ),
        'paged'             => $paged,
        'order'             => $order,
        'orderby'           => $orderby,
        'tax_query' 		=> array(
		    array(
		        'taxonomy' => 'product_visibility',
		        'field'    => 'name',
		        'terms'    => 'exclude-from-catalog',
		        'operator' => 'NOT IN',
		    ),
		)
    );

    /**
     * Are we going to use a custom query?
     *
     * @since 1.2
     */
    if ( 'yes' == $custom_query ) {
    	if( !empty( $categories ) ) {
			$args['tax_query'][] = array(
				'taxonomy'  => 'product_cat',
				'field'     => 'id', 
				'terms'     => $categories,
			);
		}
		if ( !empty($out_of_stock) && $out_of_stock == 'yes' ) {
			$args['meta_query'][] = array(
				'key'       => '_stock_status',
				'value'     => 'outofstock',
				'compare'   => 'NOT IN'
			);
		}

		$_sale_products = wc_get_product_ids_on_sale();
		$sale_products 	= implode( ',', $_sale_products );

		if ( 'yes' == $sale_products_show_hide ) {
			$include_products = $sale_products.','.$include_products;
		}

		$_include_products 	= explode( ',', $include_products );
	    $inc_products 		= array_map( 'trim', $_include_products );

	    $_exclude_products 	= explode( ',', $exclude_products );
	    $exc_products 		= array_map( 'trim', $_exclude_products );

	    if( 'yes' == $sale_products_show_hide ) {
	    	$inc_products = array_diff( $inc_products, $exc_products );
	    }

	    if( !empty( $include_products ) ) {
	        $args['post__in'] 	= $inc_products;
	    }

	    if( !empty( $exclude_products ) ) {
	        $args['post__not_in'] = $exc_products;
	    }

	    if( !empty( $exclude_categories ) ) {
	        $args['tax_query'][] = array(
               'relation' => 'AND',
               	array(
                   	'taxonomy' => 'product_cat',
                   	'field'    => 'term_id',
                   	'terms'    => $exclude_categories,
                   	'operator' => 'NOT IN',
               	),
           );
	    }

	    if( !empty( $offset ) ) {
	        $args['offset'] 	= $offset;
	    }

	    if( in_array( $orderby, [ '_price', 'total_sales', '_wc_average_rating' ] ) ) {
	    	$args['meta_key'] 	= $orderby;
	    	$args['orderby'] 	= 'meta_value_num';
	    }
    }
    
    /**
     * Is this a taxonomy archive page? e.g. category or tag
     * 
     * @since 1.2
     */
    elseif( is_tax() ){
		$term       = get_queried_object();
	    $term_id    = $term->term_id;
	    $args['tax_query'][] = array(
            'taxonomy'  => $term->taxonomy,
            'field'     => 'id', 
            'terms'     => $term_id
        );
    }

    /**
     * Is this an author archive page? e.g. for multivendor shops
     * 
     * @since 1.2
     */
	elseif ( is_author() ) {
       	$author_id 		= get_the_author_meta( 'ID' );
       	$args['author'] = $author_id;
    }
    
    /**
     * Apply filters
     */
    if ( isset( $_GET['filter'] ) && !empty( $_GET['filter'] ) ) {
    	
		if( !empty( $_GET['filter']['taxonomies'] ) ) {
			foreach ( $_GET['filter']['taxonomies'] as $key => $term ) {
		        $args['tax_query'][] = array(
		          'taxonomy' => sanitize_text_field( $key ),
		          'field'    => 'slug',
		          'terms'    => $term,
		        );
			}
		}

		if ( isset( $args['tax_query'] ) && count( $args['tax_query'] ) > 1 ) {
			$args['tax_query']['relation'] = 'AND';
		}

		if ( !empty( $_GET['filter']['max_price'] ) && !empty( $_GET['filter']['min_price'] ) ) {
			$max_price = sanitize_text_field( $_GET['filter']['max_price'] );
			$min_price = sanitize_text_field( $_GET['filter']['min_price'] );

			$args['relation']	  = 'AND';
	       	$args['meta_query'][] = array(
		          'key' 	=> '_price',
	              'value' 	=> [ $min_price, $max_price ],
	              'compare' => 'BETWEEN',
	              'type' 	=> 'NUMERIC'
	        );
		}

		if ( !empty( $_GET['filter']['orderby'] ) ) {					
			$orderby = sanitize_text_field( $_GET['filter']['orderby'] );
			$args['orderby']	= $orderby;

		    if( in_array( $orderby, [ '_price', 'total_sales', '_wc_average_rating' ] ) ) {
		    	$args['meta_key']	= $orderby;
		    	$args['orderby'] 	= 'meta_value_num';
		    }
		}

		if( !empty( $_GET['filter']['order'] ) ){
	        $args['order']	= sanitize_text_field( $_GET['filter']['order'] );
	    }
	    if( !empty( $_GET['q'] ) ){
	        $args['s'] 		= sanitize_text_field( $_GET['q'] );
	    }
    }
    
	$products = new \WP_Query( apply_filters( 'woolementor-product_query_params', $args ) );

	return apply_filters( 'woolementor-queried_products', $products, $query );
}
endif;

/**
 * Get list of taxonomies
 *
 * @return []
 */
if( !function_exists( 'woolementor_get_taxonomies' ) ) :
function woolementor_get_taxonomies() {
	$_taxonomies = get_object_taxonomies( 'product' );
	$taxonomies = [];
	foreach ( $_taxonomies as $_taxonomy ) {
		$taxonomy = get_taxonomy( $_taxonomy );
		if( $taxonomy->show_ui ) {
			$taxonomies[ $_taxonomy ] = $taxonomy->label;
		}
	}
	
    return $taxonomies;
}
endif;

/**
 * Min or Max value from the entire store
 *
 * @var string $limit min or max
 * @var bool $intval do we need an integer "formatted" value?
 *
 * @return mix
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_price_limit' ) ) :
function woolementor_price_limit( $limit = 'max', $intval = true ) {
	if( !in_array( $limit, [ 'min', 'max' ] ) ) return 0;

    global $wpdb;
    $query = "SELECT {$limit}( CAST( meta_value as UNSIGNED ) ) FROM {$wpdb->postmeta} WHERE meta_key = '_price'";
    $value = $wpdb->get_var( $query );
    return $intval ? (int)$value : $value;
}
endif;

/**
 * Checkout form fields
 *
 * @var string $section billing, shipping or order
 *
 * @return []
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_checkout_fields' ) ) :
function woolementor_checkout_fields( $section = 'billing' ) {
	if( !function_exists( 'WC' ) ) return [];

	if ( is_admin() ) {
		WC()->session = new \WC_Session_Handler();
		WC()->session->init();
	}

	$get_fields = WC()->checkout->get_checkout_fields();

	$fields = [];
	foreach ( $get_fields[ $section ] as $key => $field ) {
		$fields[] = [
			"{$section}_input_label" 		=> $field['label'],
			"{$section}_input_name" 		=> $key,
			"{$section}_input_required" 	=> isset( $field['required'] ) ? $field['required'] : false,
			"{$section}_input_type" 		=> isset( $field['type'] ) ? $field['type'] : 'text',
			"{$section}_input_class" 		=> $field['class'] ,
			"{$section}_input_autocomplete" => isset( $field['autocomplete'] ) ? $field['autocomplete'] : '' ,
			"{$section}_input_placeholder"	=> isset( $field['placeholder'] ) ? $field['placeholder'] : '' ,
		];
	}

	return $fields;
}
endif;

/**
 * Gets a random order ID
 *
 * @return int
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_get_random_order_id' ) ) :
function woolementor_get_random_order_id(){
	if( !function_exists( 'WC' ) ) return false;

	$query = new \WC_Order_Query( array(
	    'limit' => 1,
	    'orderby' => 'rand',
	    'order' => 'DESC',
	    'return' => 'ids',
	) );
	$orders = $query->get_orders();

	if ( count( $orders ) > 0 ) {
		return $orders[0];
	}

	return false;
}
endif;

/**
 * Gets list of gallery images from a product
 *
 * @var int $product_id
 *
 * @return []
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_product_gallery_images' ) ) :
function woolementor_product_gallery_images( $product_id ) {

	if( !function_exists( 'WC' ) ) return;

	if( get_post_type( $product_id ) !== 'product' ) return;

	$product 	= wc_get_product( $product_id );
	$image_ids 	= $product->get_gallery_image_ids();

	$images 	= [];
	foreach ( $image_ids as $image_id ) {
		$images[] = [
			'id' 	=> $image_id,
			'url' 	=> wp_get_attachment_url( $image_id ),
		];
	}

	return $images;
}
endif;

/**
 * Populates a notice
 *
 * @var string $text the text to show
 * @var string $heading the heading
 * @var array $modes available screens [ live, preview, edit ]
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_notice' ) ) :
function woolementor_notice( $text, $heading = null, $modes = [ 'edit', 'preview' ] ) {
	if(
		woolementor_is_preview_mode() && !in_array( 'preview', $modes ) ||
		woolementor_is_edit_mode() && !in_array( 'edit', $modes ) ||
		woolementor_is_live_mode() && !in_array( 'live', $modes )
	) return;

	if( is_null( $heading ) ) {
		$heading = '<i class="eicon-warning"></i> ' . __( 'Admin Notice', 'woolementor' );
	}
	
	$notice = "
	<div class='wl-notice'>
		<h3>{$heading}</h3>
		<p>{$text}</p>
	</div>";

	return $notice;
}
endif;

/**
 * Default checkout fields
 *
 * @param string $section form section billing|shipping|order
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_wc_fields' ) ) :
function woolementor_wc_fields( $section = '' ) {
	$fields = [
		'billing' => [ 'billing_first_name', 'billing_last_name', 'billing_company', 'billing_country', 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_state', 'billing_postcode', 'billing_phone', 'billing_email' ],
		'shipping' => [ 'shipping_first_name', 'shipping_last_name', 'shipping_company', 'shipping_country', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_state', 'shipping_postcode' ],
		'order' => [ 'order_comments' ]
	];

	if( $section != '' && isset( $fields[ $section ] ) ) {
		return apply_filters( 'woolementor_wc_fields', $fields[ $section ] );
	}

	return apply_filters( 'woolementor_wc_fields', $fields );
}
endif;

/**
 * Get an attachment with additional data
 *
 * @var int $attachment_id
 *
 * @return []
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_get_attachment' ) ) :
function woolementor_get_attachment( $attachment_id ) {

    $attachment = get_post( $attachment_id );

    if( !$attachment ) return false;

    return [
        'alt' 			=> get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' 		=> $attachment->post_excerpt,
        'description' 	=> $attachment->post_content,
        'href' 			=> get_permalink( $attachment->ID ),
        'src' 			=> $attachment->guid,
        'title' 		=> $attachment->post_title
    ];
}
endif;

/**
 * Get the attributes which are not in variations
 *
 * @var int $attachment_id
 *
 * @return []
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_attrs_notin_variations' ) ) :
function woolementor_attrs_notin_variations( $attributes, $product ) {

    if ( count( $attributes ) < 1 ) return;
    
    $extra_attrs = [];
    foreach ( $attributes as $vkey => $variation_attr ) {
		if( $attributes[ $vkey ] == '' ){
			$term_key = explode( 'attribute_', $vkey );
			$get_attrs = $product->get_attribute( $term_key[1] );
			$attrs = explode( '|', $get_attrs );
			$extra_attrs[ $vkey ] = $attrs;
		}
    }

    return $extra_attrs;
}
endif;

/**
 * Returns the text (Pro) if pro version is not activated.
 *
 * @return boolen
 *
 * @since 1.0
 */
if( !function_exists( 'woolementor_pro_text' ) ) :
function woolementor_pro_text() {
    return ( woolementor_is_pro_activated() ? '' : '<span class="wl-pro-text"> ('. __( 'PRO', 'woolementor' ) .')</span>' );
}
endif;

/**
 * Checks pro
 *
 * @return array
 *
 * @since 1.3.0
 */
if( !function_exists( 'woolementor_check_pro' ) ) :
function woolementor_check_pro() {

    if( defined( 'WOOLEMENTOR_PRO' ) && woolementor_pro_license_activated() ) {
    	$pro_basename = str_replace( [ '/', '.' ], [ '-', '-' ], plugin_basename( WOOLEMENTOR_PRO ) );
    	
    	$args = [
    		'slm_action'	=> 'slm_check',
    		'secret_key'	=> '580cc082161006.41870101',
    		'license_key'	=> get_option( $pro_basename )
    	];

    	$api = add_query_arg( $args, 'https://codexpert.io' );
    	$response = wp_remote_get( $api, [ 'timeout' => 20, 'sslverify' => false ] );
    	$data = json_decode( wp_remote_retrieve_body( $response ) );
    	
    	if( $data->result == 'error' ) {
    		delete_option( $pro_basename );
    	}
    	elseif( isset( $data->status ) && in_array( $data->status,  [ 'expired', 'blocked' ] ) ) {
    		delete_option( $pro_basename );
    		update_option( "{$pro_basename}-status", $data->status );
    	}
    	elseif( isset( $data->date_expiry ) && strtotime( $data->date_expiry ) < time() ) {
    		delete_option( $pro_basename );
    		update_option( "{$pro_basename}-status", 'expired' );
    	}
    	elseif( isset( $data->date_expiry ) && strtotime( $data->date_expiry ) > time() ) {
    		update_option( "{$pro_basename}-expiry", strtotime( $data->date_expiry ) );
    	}
    }
}
endif;

/**
 * Woolementor pagination
 * @var wp_query $products 
 * @var string $left_icon and $right_icon
 */
if( !function_exists( 'woolementor_pagination' ) ) :
function woolementor_pagination( $products, $left_icon, $right_icon ) {

    $total_pages 	= $products->max_num_pages;
    $big 			= 999999999;

    if ( $total_pages > 1 ) {

    	$paged = get_query_var( 'paged' );

    	if ( is_front_page() ) {
    		global $wp_query;
    		if ( is_array( $wp_query->query ) && count( $wp_query->query ) > 0 && isset( $wp_query->query['paged'] ) ) {
    			$paged = $wp_query->query['paged'];
    		}
    	}
    	
        $current_page = max( 1, $paged );

        echo paginate_links( array(
            'base'      => str_replace( $big, '%#%', get_pagenum_link( $big, false ) ),
            'format'    => '?paged=%#%',
            'current'   => $current_page,
            'total'     => $total_pages,
            'prev_text' => '<i class="'. esc_attr( $left_icon['value'] ) .'"></i>',
            'next_text' => '<i class="'. esc_attr( $right_icon['value'] ) .'"></i>',
        ) );
    }
}
endif;

/**
 * Get meta keys
 *
 * @return array
 */
if( !function_exists( 'woolementor_get_meta_keys' ) ) :
function woolementor_get_meta_keys() {
    global $wpdb;
    $sql 		= "SELECT distinct meta_key FROM {$wpdb->postmeta}";
    $result 	= $wpdb->get_results( $sql );    
    $meta_keys 	= [];

    foreach ( $result as $row ) {
        $meta_keys[ $row->meta_key ] = $row->meta_key;
    }   

    return $meta_keys;
}
endif;

/**
 * Get meta keys
 *
 * @return array
 */
if( !function_exists( 'woolementor_get_product_id' ) ) :
function woolementor_get_product_id() {

	global $post;

	if ( $post->post_type == 'product' ) {
		return $post->ID;
	}

    $args = [  
        'post_type' 	 => 'product',
        'post_status' 	 => 'publish',
        'posts_per_page' => 1, 
        'order' 		 => 'DESC',
    ];

    $result = new \WP_Query( $args );
    return $result->post->ID;
}
endif;

/**
 * Get related_product_ids in cart
 *
 * @return array
 */
if( !function_exists( 'woolementor_get_related_products_in_cart' ) ) :
function woolementor_get_related_products_in_cart( $product_limit ) {

	$cart_product_ids = [];
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
        $_product_ids = wc_get_related_products( $product_id );
        $cart_product_ids = array_merge( $cart_product_ids, $_product_ids );
    }

    $related_product_ids = array_unique( $cart_product_ids );
    shuffle( $related_product_ids );
    $related_product_ids = array_slice( $related_product_ids, 0, $product_limit );
    return $related_product_ids;
}
endif;