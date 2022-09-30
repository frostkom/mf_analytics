if(script_analytics_google.allow_cookies == true || document.cookie.indexOf("cookie_accepted=") !== -1)
{
	var no = document.createElement('script');
	no.type = 'text/javascript';
	no.async = true;
	no.src = 'https://google-analytics.com/analytics.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(no, s);

	window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
	ga('create', script_analytics_google.api_key, 'auto');
	ga('send', 'pageview');
}