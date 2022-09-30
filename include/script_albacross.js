if(script_analytics_albacross.allow_cookies == true || document.cookie.indexOf("cookie_accepted=") !== -1)
{
	nQc = script_analytics_albacross.api_key;
	_nQs = 'WordPress-Plugin';
	_nQsv = '1.3.1';
	_nQt = new Date().getTime();
	(function()
	{
		var no = document.createElement('script');
		no.type = 'text/javascript';
		no.async = true;
		no.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'serve.albacross.com/track.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(no, s);
	})();
}