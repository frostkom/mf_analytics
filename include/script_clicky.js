if(script_analytics_clicky.allow_cookies == true || document.cookie.indexOf("cookie_accepted=") !== -1)
{
	var no = document.createElement('script');
	no.type = 'text/javascript';
	no.async = true;
	no.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'static.getclicky.com/js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(no, s);

	clicky.init(script_analytics_clicky.api_key);
}