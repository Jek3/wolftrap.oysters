jQuery(function($){
	//add .active class to the wrapper based on checkbox status
	$('.wl-widget-checkbox').change(function(e){
		if($(this).is(':checked')) {
			$(this).closest('.wl-widget:visible').addClass('active');
		}
		else {
			$(this).closest('.wl-widget:visible').removeClass('active');
		}
	});

	// enable/disable all widgets
	$('.wl-toggle-all').click(function(e){
		if(!$('.wl-toggle-all-wrap input').is(':checked')) {
			$('.wl-widget-checkbox:visible').prop('checked',true).change();
		}
		else {
			$('.wl-widget-checkbox:visible').prop('checked',false).change();
		}
	});

	// filter widgets - pro or free
	$('.wl-filter').click(function(e) {
		var filter = $(this).data('filter');
		$('.wl-filter').removeClass('active');
		$(this).addClass('active');
		$('.wl-widget').hide();
		$(filter).show();
	});

	// search widgets
	$('#wl-search').keyup(function(e){
		var $keyword = $(this).val();
		$('.wl-widget').hide().each(function(e){
			if($(this).data('keywords').toLowerCase().indexOf($keyword.toLowerCase()) >= 0) $(this).show()
		})
	});
})