jQuery(function($){
	$('#wl_faq').click(function (e) {
		$('#wl_vidtt, #wl_support').removeClass('active');
		$(this).addClass('active');

		$('#wl_vidtt_content, #wl_support_content').removeClass('active');
		$('#wl_faq_content').addClass('active');
	});
	$('#wl_vidtt').click(function (e) {
		$('#wl_faq, #wl_support').removeClass('active');
		$(this).addClass('active');

		$('#wl_faq_content, #wl_support_content').removeClass('active');
		$('#wl_vidtt_content').addClass('active');
	});
	$('#wl_support').click(function (e) {
		$('#wl_faq, #wl_vidtt').removeClass('active');
		$(this).addClass('active');
		
		$('#wl_faq_content, #wl_vidtt_content').removeClass('active');
		$('#wl_support_content').addClass('active');
	});

	$('.woolementor-help-heading').click(function(e){
		var $this = $(this);
		var target = $this.data('target');
		$('.woolementor-help-text:not('+target+')').slideUp();
		if($(target).is(':hidden')){
			$(target).slideDown();
		}
		else {
			$(target).slideUp();
		}
	});

	$(document).on("click","#wl-widget-survey-btn, .is-dismissible.wl-widget-survey .notice-dismiss",function(e){
		e.preventDefault();
		$('.notice.notice-success.is-dismissible.wl-widget-survey').slideUp('slow');
		var $survey = $(this).data('survey');
		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: { 'action':'widget-survey', survey: $survey, '_nonce' : WOOLEMENTOR.nonce },
			type: 'POST',
			dataType: 'JSON',
			success: function(resp){
				console.log(resp);
			}
		});
	});

	$(document).on( 'click', '#wl-reset-widgets', function(e){
		e.preventDefault();
		$('#wl-confirm-box-container').show();
	} );

	$(document).on( 'click', '#wl-cancle-reset', function(e){
		e.preventDefault();
		$('#wl-confirm-box-container').hide();
	} );

	$(document).on( 'click', '#wl-confirm-reset', function(e){
		e.preventDefault();
		var btn = $('#wl-reset-widgets')
		btn.after( '<div id="wl-loader"></div>' );
		btn.prop('disabled', true);
		$('#wl-confirm-box-container').hide()
		
		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: { 'action':'wl-reset', '_nonce' : WOOLEMENTOR.nonce },
			type: 'POST',
			dataType: 'JSON',
			success: function(resp){
				$('#wl-loader').remove()
				btn.prop('disabled', false);
				console.log(resp);
			}
		});
	} );

	$('#wl-report-copy').click(function(e) {
		e.preventDefault();
		$('#wl-site-report').select();

		try {
			var successful = document.execCommand('copy');
			if( successful ){
				$(this).html('<span class="dashicons dashicons-saved"></span>');
			}
		} catch (err) {
			console.log('Oops, unable to copy!');
		}
	});

	$(document).on( 'click', '#wl-enable-debug', function(e){

		var enable_debug = 'yes';
		var par = $(this).closest('.wl-toggle-switch');
		if (!$(this).prop("checked")){
			enable_debug = 'no';
		 	par.removeClass('active');
		 }else{
			par.addClass('active');
		 }
		 console.log(enable_debug)
		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: { 'action':'wl-enable-debug', '_nonce' : WOOLEMENTOR.nonce, 'enable_debug':enable_debug },
			type: 'POST',
			dataType: 'JSON',
			success: function(resp){
				console.log(resp);
			}
		});
	} );
})