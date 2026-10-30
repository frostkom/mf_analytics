if(script_analytics_tag_manager.allow_cookies == true || document.cookie.split('; ').indexOf('cookie_accepted=true') !== -1)
{
	jQuery(function($)
	{
		var id = script_analytics_tag_manager.api_key; // "GTM-XXXXXXX"

		window.dataLayer = window.dataLayer || [];
		window.dataLayer.push({'gtm.start': new Date().getTime(), event: 'gtm.js'});

		$.getScript('https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(id));
	});
}