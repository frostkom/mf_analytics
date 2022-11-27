if(script_analytics_clicky.allow_cookies == true || document.cookie.indexOf("cookie_accepted=") !== -1)
{
	jQuery(function($)
	{
		var script_src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'static.getclicky.com/js';

		/*var script_tag = document.createElement('script');
		script_tag.type = 'text/javascript';
		script_tag.async = true;
		script_tag.src = script_src;
		
		var first_sibling_tag = document.getElementsByTagName('script')[0];
		first_sibling_tag.parentNode.insertBefore(script_tag, first_sibling_tag);*/

		$("body").append("<script src='" + script_src + "?ver=" + script_analytics_clicky.version + "'></script>");

		setTimeout(function()
		{
			clicky.init(script_analytics_clicky.api_key);
		}, 500);
	});
}