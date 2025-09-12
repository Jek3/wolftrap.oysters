jQuery(function($){
	// add to wishlist
	$('.ajax_add_to_wish').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		var $product_id = $this.data('product_id');
		
		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: { 'action' : 'add-to-wish', _wpnonce : WOOLEMENTOR._nonce, product_id : $product_id },
			type: 'POST',
			dataType: 'JSON',
			success: function( resp ) {
				if(resp.action=='added') {
					$this.addClass('fav-item')
				}
				else {
					$this.removeClass('fav-item')
				}
			},
			error: function( resp ) {
				console.log(resp)
			}
		})
	});
	// remove from wishlist
	$('.ajax_remove_from_wish').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		var $product_id = $this.data('product_id');
		
		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: { 'action' : 'add-to-wish', _wpnonce : WOOLEMENTOR._nonce, product_id : $product_id },
			type: 'POST',
			dataType: 'JSON',
			success: function( resp ) {
				if(resp.action=='removed') {
					$this.closest('tr').remove()
				}
			},
			error: function( resp ) {
				console.log(resp)
			}
		})
	});

	// multiple-product-add-to-cart
	$('.multiple-product-add-to-cart').on('submit',function(e){
		e.preventDefault();
		var $formData = $( this ).serializeArray();
		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: $formData,
			type: 'POST',
			dataType: 'JSON',
			success: function( resp ) {
				if ( resp.status == 1 ) {
					$('.multiselect-view-cart').show()
				}
			},
			error: function( resp ) {
				console.log(resp)
			}
		});
	});

})