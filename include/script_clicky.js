if(script_analytics_clicky.allow_cookies == true || document.cookie.indexOf("cookie_accepted=") !== -1)
{
	jQuery(function($)
	{
		var script_src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'static.getclicky.com/js';

		$("body").append("<script src='" + script_src + "?ver=" + script_analytics_clicky.version + "'></script>");

		setTimeout(function()
		{
			clicky.init(script_analytics_clicky.api_key);
		}, 500);
	});
}