<?php
$widgets = woolementor_widgets();
$active_widgets = woolementor_active_widgets();

// sort by category first
$widget_categories = [];
$category_names = woolementor_widget_categories();
foreach ( $widgets as $id => $widget ) {
	$categories = $widget['categories'];
	if( count( $categories ) > 0 ) {
		$widget_categories[ $categories[0] ][ $id ] = $widget; // assign in first list only
	}
}
?>

<div class="wl-content-area">
	<div class="wl-header-content">
		<div class="wl-header-filter">
			<div class="wl-group-wrap">
				<div class="wl-filter-group">
					<button type="button" class="wl-filter filter-all active" data-filter=".free, .pro"><?php _e( 'All', 'woolementor' ); ?></button>
					<button type="button" class="wl-filter filter-free" data-filter=".free"><?php _e( 'Free', 'woolementor' ); ?></button>
					<button type="button" class="wl-filter filter-pro" data-filter=".pro"><?php _e( 'Pro', 'woolementor' ); ?></button>
				</div>
				<span class="wl-action-divider"></span>
				<div class="wl-toggle-group">
					<label class="wl-toggle-all-wrap">
					  	<input type="checkbox">
					  	<span class="wl-toggle-all"><?php _e( 'All', 'woolementor' ); ?></span>
					</label>
				</div>
			</div>
		</div>
		<div class="wl-header-search">
			<div class="wl-search-area">
				<input id="wl-search" type="text" placeholder="<?php _e( 'Search Widgets', 'woolementor' ); ?>">
				<button type="button" class="wl-search-btn"><span class="dashicons dashicons-search"></span></button>
			</div>
		</div>
	</div>

	<?php
	foreach ( $widget_categories as $category => $widgets ) {
		echo '<div class="wl-dashboard-widgets">';

		$category = str_replace( 'Woolementor - ', '', $category_names[ $category ]['title'] );
		echo "<h3 class='wl-widget-category'>{$category}</h3>";
		foreach ( $widgets as $id => $widget ) {

			$_class = isset( $widget['pro_feature'] ) && $widget['pro_feature'] ? 'pro' : 'free';

			$_active	= in_array( $id, $active_widgets ) ? 'active' : '';
			$_checked	= in_array( $id, $active_widgets ) ? 'checked' : '';

			$_demo = "<span class='wl-demo-icon'><a href='{$widget['demo']}' title='" . __( 'View Demo', 'woolementor' ) . "' target='_blank'><i class='eicon-preview-medium'></i></a></span>";

			$_button	= "
			<label class='wl-toggle-switch'>
				{$_demo}
			  	<input type='checkbox' class='wl-widget-checkbox' id='woolementot-checkbox-{$id}' name='{$id}' {$_checked}>
			  	<span class='wl-toggle-slider'></span>
			</label>
			";

			if( !woolementor_is_pro_activated() && $_class == 'pro' ) {
				$_button	= "
				<label class='wl-toggle-switch'>
					{$_demo}
				  	<input type='checkbox' class='wl-widget-checkbox' id='woolementot-checkbox-{$id}' name='{$id}' {$_checked}>
				  	<span class='wl-pro-slider' data-demo='{$widget['demo']}'>" . __( 'PRO', 'woolementor' ) . "</span>
				</label>
				";
			}

			$keywords = implode( ' ', $widget['keywords'] ) . " {$widget['title']}";

			$title = str_replace( 'Shop - ', '', $widget['title'] );
			echo "
			<div id='wl-{$id}' class='wl-widget {$_class} {$_active}' data-keywords='{$keywords}'>
				<span class='wl-widget-icon'><i class='{$widget['icon']}'></i></span>
				<label class='wl-widget-title' for='woolementot-checkbox-{$id}'>{$title}</label>
				{$_button}
			</div>
			";
		}
		echo '</div>';
	}
	?>
</div>