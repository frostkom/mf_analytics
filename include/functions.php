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

function add_action_analytics($links)
{
	$links[] = "<a href='".admin_url('options-general.php?page=settings_mf_base#settings_analytics')."'>".__("Settings", 'lang_analytics')."</a>";

	return $links;
}

function settings_analytics()
{
	$options_area = "settings_analytics";

	add_settings_section($options_area, "", $options_area."_callback", BASE_OPTIONS_PAGE);

	$arr_settings = array(
		"setting_analytics_google" => __("Google", 'lang_analytics'),
		"setting_analytics_clicky" => __("Clicky", 'lang_analytics'),
		"setting_analytics_save_admin_stats" => __("Save admin statistics", 'lang_analytics'),
	);

	foreach($arr_settings as $handle => $text)
	{
		add_settings_field($handle, $text, $handle."_callback", BASE_OPTIONS_PAGE, $options_area);

		register_setting(BASE_OPTIONS_PAGE, $handle);
	}
}

function settings_analytics_callback()
{
	echo settings_header('settings_analytics', __("Analytics", 'lang_analytics'));
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
		<input type='text' name='setting_analytics_google' value='".$option."' placeholder='".$tracking_example."...'>
		<p class='description'>".__("Login to your account and find the tracking code looking like", 'lang_analytics')." ".$tracking_example."</p>
	</label>";
}

function setting_analytics_clicky_callback()
{
	$option = get_option('setting_analytics_clicky');

	//$tracking_example = "UA-0000000-0";

	echo "<label>
		<input type='text' name='setting_analytics_clicky' value='".$option."'>" // placeholder='".$tracking_example."...'
		//."<p class='description'>".__("Login to your account and find the tracking code looking like", 'lang_analytics')." ".$tracking_example."</p>"
	."</label>";
}

function setting_analytics_save_admin_stats_callback()
{
	$option = get_option('setting_analytics_save_admin_stats');

	echo "<label>
		<input type='checkbox' name='setting_analytics_save_admin_stats' value='1' ".checked(1, $option, false).">
		<p class='description'>".__("Check if you would like to save admin statistics", 'lang_analytics')."</p>
	</label>";
}

function footer_analytics()
{
	$setting_analytics_google = get_option('setting_analytics_google');
	$setting_analytics_clicky = get_option('setting_analytics_clicky');

	if($setting_analytics_google != '')
	{
		echo "<script src='//google-analytics.com/ga.js'></script>
		<script>
			_uacct = '".$setting_analytics_google."';
			
			try
			{
				urchinTracker();
		    }catch(err){}
		</script>";
	}

	if($setting_analytics_clicky != '')
	{
		echo "<script src='//static.getclicky.com/js'></script>
		<script>clicky.init(".$setting_analytics_clicky.");</script>";
	}
}