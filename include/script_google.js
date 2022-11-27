if(script_analytics_google.allow_cookies == true || document.cookie.indexOf("cookie_accepted=") !== -1)
{
	jQuery(function($)
	{
		$("body").append("<script src='https://google-analytics.com/analytics.js?ver=" + script_analytics_google.version + "'></script>");

		setTimeout(function()
		{
			window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)}; ga.l=+new Date;
			ga('create', script_analytics_google.api_key, 'auto');
			ga('send', 'pageview');
		}, 500);
	});
}