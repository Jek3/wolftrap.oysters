jQuery(function($){
	$('.wl-fh-price-range').on('change', function() {
		var min_price = $(this).data("min_price")
		var max_price = $(this).data("max_price")

		$('.wl-fh-min_price').val( min_price )
		$('.wl-fh-max_price').val( max_price )
	});
})