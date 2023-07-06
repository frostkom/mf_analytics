if(script_analytics_albacross.allow_cookies == true || document.cookie.indexOf("cookie_accepted=") !== -1)
{
	jQuery(function($)
	{
		nQc = script_analytics_albacross.api_key;
		_nQs = 'WordPress-Plugin';
		_nQsv = '1.3.1';
		_nQt = new Date().getTime();
		(function()
		{
			var script_src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'serve.albacross.com/track.js'

			/*var script_tag = document.createElement('script');
			script_tag.type = 'text/javascript';
			script_tag.async = true;
			script_tag.src = script_src;

			var first_sibling_tag = document.getElementsByTagName('script')[0];
			first_sibling_tag.parentNode.insertBefore(script_tag, first_sibling_tag);*/

			$("body").append("<script src='" + script_src + "?ver=" + script_analytics_albacross.version + "'></script>");
		})();
	});
}