(function( $ ) {
	'use strict';
	jQuery(document).ready(function($) {
		$('.importUpdateCompatibility').submit(function(e){
			// alert('Start Importing');
			// alert($(this).find( ".idEbay" ).val());
			jQuery.post(
				ajax_custom.ajaxurl,{action:'update_create_product_compatibility'}, function(response) {
					console.log (response);
				}); 
			// var IdProd=$(this).find( ".idEbay" ).val();
			// var data ={
				// action: 'update_create_product_compatibility',
				// data:{
					// ebayId: IdProd,
					// nonce:ajax_custom.nonce
				// }
				// 
			// }
			// $.post(ajax_custom.ajaxurl,data)
			// .done(function(response){
				// console.log(response);
			// })
			return false;
		});	
	});
	
	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	})( jQuery );
