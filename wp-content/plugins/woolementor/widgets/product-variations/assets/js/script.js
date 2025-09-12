jQuery(function($){
	$('.wl-pl-pricelist-form').on('submit',function(e){
		e.preventDefault()
		var $formData = $( this ).serializeArray()
		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: $formData,
			type: 'POST',
			dataType: 'JSON',
			success: function( resp ) {
				if ( resp.status ) {
					$('.add-variations-to-cart').html( '<a href="'+WOOLEMENTOR.cart_url+'">View Cart</a>' )
				}
			},
			error: function( resp ) {
				console.log(resp)
			}
		})
	})
})