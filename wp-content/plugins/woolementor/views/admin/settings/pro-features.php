<?php
$utm = [ 'utm_source' => 'dashboard', 'utm_medium' => 'settings', 'utm_campaign' => 'pro-tab' ];
$pro_link		= add_query_arg( $utm, 'https://woolementor.com' );
$pro_features	= [
	'checkout-widgets'	=> [
		'title'			=> __( 'Checkout Page', 'woolementor' ),
		'subtitle'		=> __( 'Customizable Checkout', 'woolementor' ),
		'description'	=> __( 'Helps you customize your checkout page. Adding new billing or shipping fields, changing field attributes, styling your own.. You name it.', 'woolementor' ),
	],
	'template-builder'	=> [
		'title'			=> __( 'Template Builder', 'woolementor' ),
		'subtitle'		=> __( 'Header, Footer & Much More', 'woolementor' ),
		'description'	=> __( 'You can now create header, footer, product archive, single product etc templates conditionally with a lot of customization options.', 'woolementor' ),
	],
	'copy-paste'	=> [
		'title'			=> __( 'Smart Copy-Paste', 'woolementor' ),
		'subtitle'		=> __( 'Cross-Domain Copy-Paste', 'woolementor' ),
		'description'	=> __( 'Designed a beautiful page and want to copy that over to another site? Woolementor can help you with this too.', 'woolementor' ),
	],
	'more-shop-design'	=> [
		'title'			=> __( 'New Shop Designs', 'woolementor' ),
		'subtitle'		=> __( 'More Shop Widgets', 'woolementor' ),
		'description'	=> __( 'Woolementor Pro includes 6 additional beautiful shop widgets. But, we\'re not stopping here, our team is continuously working and more widgets will be added soon.', 'woolementor' ),
	],
	'pricing-table'	=> [
		'title'			=> __( 'Pricing Table', 'woolementor' ),
		'subtitle'		=> __( 'Amazing Pricing Tables', 'woolementor' ),
		'description'	=> __( 'Along with 2 Pricing Tables included in the free version, Woolementor Pro brings 3 more Pricing Table widgets that are amazing and mindblowing.', 'woolementor' ),
	],
	'beautiful-wishlist'	=> [
		'title'			=> __( 'Wishlist', 'woolementor' ),
		'subtitle'		=> __( 'Smart Wishlist Included', 'woolementor' ),
		'description'	=> __( 'Woolementor Pro includes a very smart and intuitive Wishlist feature. You customers can now add products to Wishlish and to the cart right from there.', 'woolementor' ),
	],
	'sales-notification'=> [
		'title'			=> __( 'Sales Notification', 'woolementor' ),
		'subtitle'		=> __( 'Display Recent Sales', 'woolementor' ),
		'description'	=> __( 'Sales Notification widget lets you display your recent sales. It\'s a proven token of trust! Notifications can be pulled from your orders or added manually.', 'woolementor' ),
	],
	'ready-made-templates'=> [
		'title'			=> __( 'Ready-made templates', 'woolementor' ),
		'subtitle'		=> __( 'More Templates For You', 'woolementor' ),
		'description'	=> __( 'If you upgrade to Woolementor Pro, you\'ll have access to number of ready-made templates to be imported using the native Elementor importer.', 'woolementor' ),
	],
];
?>
<div id="wl-pro-wrap">
	<a href="<?php echo $pro_link; ?>" target="_blank">
		<div id="wl-pro-banner">
			<div class="wl-large-title">
				<h4><?php _e( 'More cool features in', 'woolementor' ); ?></h4>
				<h1><?php _e( 'Woolementor Pro', 'woolementor' ) ?></h1>
			</div>
		</div>
	</a>
	<div id="wl-pro-features">
		<a href="<?php echo $pro_link; ?>"><h1 class="wl-large-title"><?php _e( 'Premium Features', 'woolementor' ); ?></h1></a>
		<p class="wl-desc"><?php _e( 'Along with the <strong>Award Winning</strong> premium and priority support from our dedicated support team, you\'re going to get these awesome features if you upgrade to Woolementor Pro.', 'woolementor' ) ?></p>
		<div class="wl-pro-row">
			<?php
			foreach ( $pro_features as $id => $data ) {
				echo "
				<div class='wl-pro-feature wl-half'>
					<img src='" . plugins_url( "assets/img/{$id}.png", WOOLEMENTOR ) . "' />
					<a href='{$pro_link}' target='_blank'><h3 class='wl-widget-subtitle'>{$data['title']}</h3></a>
					<h2 class='wl-widget-title'>{$data['subtitle']}</h2>
					<p class='wl-desc'>{$data['description']}</p>
				</div>
				";
			}
			?>
		</div>
	</div>
	<div id="wl-pro-widgets" class="wl-pro-row">
		<div id="wl-widgets-heading" class="wl-half">
			<h1 class="wl-large-title"><?php _e( 'Pro Widgets', 'woolementor' ); ?></h1>
			<p class="wl-desc"><?php _e( 'Here is a list of widgets included in Woolemento Pro. Also, as we already said, we\'re not stopping and new widgets are getting added regularly.', 'woolementor' ) ?></p>
			<p class="wl-desc"><?php _e( 'Take a deep breath, we\'re going to make your life better than ever!', 'woolementor' ) ?></p>
		</div>
		<div id="wl-widgets-list" class="wl-half">
			<ul class="wl-pro-row">
				<?php
				foreach ( woolementor_widgets() as $id => $widget ) {
					if( woolementor_is_pro_feature( $id ) ) {
						echo "<li><i class='{$widget['icon']}'></i><a href='{$widget['demo']}' target='_blank'>{$widget['title']}</a></li>";
					}
				}
				?>
			</ul>
		</div>
	</div>
	<div id="wl-pro-upgrade" class="wl-pro-row">
		<div id="wl-invite" class="wl-half">
			<div class="wl-invite-title">
				<h4><?php _e( 'Interested?', 'woolementor' ) ?></h4>
				<h4><?php _e( 'Upgrade now and relax..', 'woolementor' ) ?></h4>
			</div>
		</div>
		<div id="wl-download" class="wl-half">
			<a href="<?php echo $pro_link; ?>" target="_blank"><button class="wl-button"><?php _e( 'Get Woolementor Pro', 'woolementor' ) ?></button></a>
		</div>
	</div>
</div>