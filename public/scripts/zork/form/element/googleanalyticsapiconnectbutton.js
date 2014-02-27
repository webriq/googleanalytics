(function(global, $, js) {
	"use strict";

	if (typeof js.form.element.googleAnalyticsApiConnectButton !== "undefined") {
		return;
	}

	global.Zork.Form.Element.prototype.googleAnalyticsApiConnectButton = function(element) {
		
		element = $(element);
		
		element.click(function() {

			var clientId = $('#googleAnalytics_form_settings_googleApi_clientId').val();
			var clientSecret = $('#googleAnalytics_form_settings_googleApi_clientSecret').val();
				
			if (clientId.trim() != '' && clientId.trim() != '') {
				js.core.rpc( {
	                "method"    : "Grid\\GoogleAnalytics\\Model\\Rpc::getGoogleApiAuthenticationUrl",
	                "callback"  : function ( result ) {
	                    js.console.log(result);
	                    
	                    if(typeof result.authenticationUrl == 'string') {
	                    	window.open(result.authenticationUrl, '_blank');
	                    }
	                }
	            } ).invoke({
	            	'clientId'     : clientId,
	            	'clientSecret' : $('#googleAnalytics_form_settings_googleApi_clientSecret').val(),
	            	'trackingId'   : $('#googleAnalytics_form_settings_trackingId').val()
	            });
			} else {
				// @TODO form validátor szerű hibaüzeneteket megjeleníteni
			}
		});
	};

	global.Zork.Form.Element.prototype.googleAnalyticsApiConnectButton.isElementConstructor = true;

}(window, jQuery, zork));
