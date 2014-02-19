(function(global, $, js) {
	"use strict";

	if (typeof js.form.element.googleAnalyticsApiConnectButton !== "undefined") {
		return;
	}

	global.Zork.Form.Element.prototype.googleAnalyticsApiConnectButton = function(element) {
		
		element = $(element);
		
		element.bind('open-new-window', function () {
			var requestUrl = element.attr('data-protocol')
			+ element.attr('data-http-host') + '/app/'
			+ js.core.defaultLocale
			+ '/admin/googleanalytics/api/connect' 
			+ '?'
			+ 'clientId='
			+ $(
					'#googleAnalytics_form_settings_googleApi_clientId')
					.val()
			+ '&'
			+ 'clientSecret='
			+ $(
					'#googleAnalytics_form_settings_googleApi_clientSecret')
					.val()
			+ '&'
			+ 'analyticsId='
			+ $('#googleAnalytics_form_settings_analyticsId')
					.val();
		
			window.open(requestUrl, '_blank');
		});
		
		element.click(function() {

			js.core.rpc( {
                "method"    : "Grid\\GoogleAnalytics\\Model\\Rpc::getGoogleApiAuthenticationUrl",
                "callback"  : function ( result ) {
                    js.console.log(result);

                	if (result.action == "redirect") {
                		element.attr("disabled", "disabled");

                		element.parent().append($('<iframe id="' + element.attr('id') + '_iframe"  style="display: none;"></iframe>'));

                		var iframe = $('#' + element.attr('id') + '_iframe');
                		
						iframe.load(function() {
							try {
								iframe.contents();
							} catch (err) {
								
								element.trigger('open-new-window');
								element.removeAttr("disabled");
								iframe.remove();
							}
							
						});

						iframe.attr('src', result.url);
					}
                }
            } ).invoke({
            	'clientId' : $('#googleAnalytics_form_settings_googleApi_clientId').val(),
            	'clientSecret' : $('#googleAnalytics_form_settings_googleApi_clientSecret').val(),
            	'analiticsId' : $('#googleAnalytics_form_settings_analyticsId').val()
            });
		
		});

	};

	global.Zork.Form.Element.prototype.googleAnalyticsApiConnectButton.isElementConstructor = true;

}(window, jQuery, zork));
