if(script_analytics_tag_manager.allow_cookies == true || document.cookie.indexOf("cookie_accepted=") !== -1)
{
	var no = document.createElement('script');
	no.type = 'text/javascript';
	no.async = true;
	no.src = 'https://www.googletagmanager.com/gtm.js?id=' + script_analytics_tag_manager.api_key;
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(no, s);

	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', script_analytics_tag_manager.api_key);
}