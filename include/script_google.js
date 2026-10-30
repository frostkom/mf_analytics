if(script_analytics_google.allow_cookies == true || document.cookie.split('; ').indexOf('cookie_accepted=true') !== -1)
{
	jQuery(function($)
	{
		var id = script_analytics_google.api_key; // must be a "G-XXXXXXXXXX" ID
		console.log("GA id:", id);

		$.getScript("https://www.googletagmanager.com/gtag/js?id=" + encodeURIComponent(id));

		window.dataLayer = window.dataLayer || [];
		function gtag(){ dataLayer.push(arguments); }
		gtag('js', new Date());
		gtag('config', id);
	});
}