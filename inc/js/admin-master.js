// Admin Javascript
jQuery( document ).ready( function( $ ) {
	jQuery(document).on('click', '.beryl-rating-dismiss', function() {
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'beryl_dismiss_notice'
			},
			success: function(data) {
				jQuery('.beryl-rating-notice').remove();
			}
		});
	});
});