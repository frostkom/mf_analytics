<?php

function init_analytics()
{
	$setting_analytics_save_admin_stats = get_option('setting_analytics_save_admin_stats');

	if($setting_analytics_save_admin_stats)
	{
		if(is_user_logged_in())
		{
			add_filter('admin_footer_text', 'footer_analytics');
		}

		else
		{
			add_filter('login_footer', 'footer_analytics');
		}
	}
}

function settings_analytics()
{
	$options_page = "settings_mf_base";
	$options_area = "settings_analytics";

	add_settings_section(
		$options_area,
		"",
		'settings_analytics_callback',
		$options_page
	);

	$arr_settings = array(
		"setting_analytics_google" => __("Google", 'lang_analytics'),
		"setting_analytics_clicky" => __("Clicky", 'lang_analytics'),
		"setting_analytics_save_admin_stats" => __("Save admin statistics", 'lang_analytics'),
	);

	foreach($arr_settings as $handle => $text)
	{
		add_settings_field($handle, $text, $handle."_callback", $options_page, $options_area);

		register_setting($options_page, $handle);
	}
}

function settings_analytics_callback()
{
	echo "<div id='settings_analytics'>&nbsp;</div>
	<a href='#settings_analytics'><h3>".__("Analytics", 'lang_analytics')."</h3></a>";
}

function setting_analytics_google_callback()
{
	$option = get_option('setting_analytics_google');

	if($option == '')
	{
		$option = get_option('web_property_id');
	}

	$tracking_example = "UA-0000000-0";

	echo "<label>
		<input type='text' name='setting_analytics_google' value='".$option."' placeholder='".$tracking_example."...'>"
		."<span class='description'>".__("Login to your account and find the tracking code looking like", 'lang_analytics')." ".$tracking_example."</span>"
	."</label>";
}

function setting_analytics_clicky_callback()
{
	$option = get_option('setting_analytics_clicky');

	//$tracking_example = "UA-0000000-0";

	echo "<label>
		<input type='text' name='setting_analytics_clicky' value='".$option."'>" // placeholder='".$tracking_example."...'
		//."<br><span class='description'>".__("Login to your account and find the tracking code looking like", 'lang_analytics')." ".$tracking_example."</span>"
	."</label>";
}

function setting_analytics_save_admin_stats_callback()
{
	$option = get_option('setting_analytics_save_admin_stats');

	echo "<label>
		<input type='checkbox' name='setting_analytics_save_admin_stats' value='1' ".checked(1, $option, false).">
		<br><span class='description'>".__("Check if you would like to save admin statistics", 'lang_analytics')."</span>
	</label>";
}

function footer_analytics()
{
	$setting_analytics_google = get_option('setting_analytics_google');
	$setting_analytics_clicky = get_option('setting_analytics_clicky');

	if($setting_analytics_google != '')
	{
		/*echo "<script>
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '".$setting_analytics_google."']);
			_gaq.push(['_trackPageview']);
			(function()
			{
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>";*/

		//google-analytics.com/urchin.js

		echo "<script src='//google-analytics.com/ga.js'></script>
		<script>
			_uacct = '".$setting_analytics_google."';
			urchinTracker();
		</script>";
	}

	if($setting_analytics_clicky != '')
	{
		echo "<script src='//static.getclicky.com/js'></script>
		<script>clicky.init(".$setting_analytics_clicky.");</script>";
	}
}