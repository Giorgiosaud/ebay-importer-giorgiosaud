(function( $ ) {
	'use strict';
	jQuery(document).ready(function($) {
		$('.importUpdateCompatibility').submit(function(e){
			alert('Start Importing');
			alert($(this).find( ".idEbay" ).val());

			// $.ajax({
			// 	url: ajaxurl,
			// 	headers: {
			// 		"Content-Type": "text/xml;charset=utf-8",
			// 		"X-EBAY-API-APP-ID":ebay_api_name,
			// 		"X-EBAY-API-SITE-ID":"0",
			// 		"X-EBAY-API-CALL-NAME":"GetSingleItem",
			// 		"X-EBAY-API-VERSION":"863",
			// 		"X-EBAY-API-REQUEST-ENCODING":"json"
			// 	},
			// 	data: "<GetSingleItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\"><IncludeSelector>Compatibility</IncludeSelector><ItemID>$productId</ItemID></GetSingleItemRequest>", 
			// 	type: 'POST',
			// 	contentType: "text/xml",
			// 	dataType: "xml",
			// 	success : function(){

			// 	},
			// 	error : function (xhr, ajaxOptions, thrownError){  
			// 		console.log(xhr.status);          
			// 		console.log(thrownError);
			// 	} 
			// }); 
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
