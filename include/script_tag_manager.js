if(script_analytics_tag_manager.allow_cookies == true || document.cookie.indexOf("cookie_accepted=") !== -1)
{
	jQuery(function($)
	{
		var script_src = 'https://www.googletagmanager.com/gtag/js?id=' + script_analytics_tag_manager.api_key; /*https://www.googletagmanager.com/gtm.js*/

		/*var script_tag = document.createElement('script');
		script_tag.type = 'text/javascript';
		script_tag.async = true;
		script_tag.src = script_src;
		
		var first_sibling_tag = document.getElementsByTagName('script')[0];
		first_sibling_tag.parentNode.insertBefore(script_tag, first_sibling_tag);*/

		$("body").append("<script src='" + script_src + "&ver=" + script_analytics_tag_manager.version + "'></script>");

		setTimeout(function()
		{
			window.dataLayer = (window.dataLayer || []);
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', script_analytics_tag_manager.api_key);
		}, 500);
	});
}