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
	$options_area = __FUNCTION__;

	add_settings_section($options_area, "", $options_area."_callback", BASE_OPTIONS_PAGE);

	$setting_analytics_google = get_option('setting_analytics_google');
	$setting_analytics_clicky = get_option('setting_analytics_clicky');

	$arr_settings = array();

	if($setting_analytics_clicky == '')
	{
		$arr_settings['setting_analytics_google'] = __("Google", 'lang_analytics');

		if($setting_analytics_google != '')
		{
			$arr_settings['setting_analytics_save_admin_stats'] = __("Save admin statistics", 'lang_analytics');
			$arr_settings['setting_analytics_event_tracking'] = __("Track events", 'lang_analytics');
		}
	}

	if($setting_analytics_google == '')
	{
		$arr_settings['setting_analytics_clicky'] = __("Clicky", 'lang_analytics');
	}

	foreach($arr_settings as $handle => $text)
	{
		add_settings_field($handle, $text, $handle."_callback", BASE_OPTIONS_PAGE, $options_area);

		register_setting(BASE_OPTIONS_PAGE, $handle);
	}
}

function settings_analytics_callback()
{
	$setting_key = get_setting_key(__FUNCTION__);

	echo settings_header($setting_key, __("Analytics", 'lang_analytics'));
}

function setting_analytics_google_callback()
{
	$setting_key = get_setting_key(__FUNCTION__);
	$option = get_option($setting_key);

	$description = ($option == '' ? "<a href='//analytics.google.com/analytics/web/' rel='external'>".__("Get yours here", 'lang_analytics')."</a>" : "");

	echo show_textfield(array('name' => $setting_key, 'value' => $option, 'placeholder' => "UA-0000000-0", 'suffix' => $description));
}

function setting_analytics_save_admin_stats_callback()
{
	$setting_key = get_setting_key(__FUNCTION__);
	$option = get_option($setting_key);

	echo show_select(array('data' => get_yes_no_for_select(array('return_integer' => true)), 'name' => $setting_key, 'value' => $option, 'description' => __("Check if you would like to save admin statistics", 'lang_analytics')));
}

function setting_analytics_event_tracking_callback()
{
	$setting_key = get_setting_key(__FUNCTION__);
	$option = get_option($setting_key);

	echo show_textarea(array('name' => $setting_key, 'value' => $option, 'xtra' => "class='widefat'", 'placeholder' => __("Outbound Links", 'lang_analytics')."|.phone a, .url a"));
}

function setting_analytics_clicky_callback()
{
	$setting_key = get_setting_key(__FUNCTION__);
	$option = get_option($setting_key);

	echo show_textfield(array('name' => $setting_key, 'value' => $option));
}

function footer_analytics()
{
	$setting_analytics_google = get_option('setting_analytics_google');
	$setting_analytics_clicky = get_option('setting_analytics_clicky');

	if($setting_analytics_google != '')
	{
		echo "<script>
			window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
			ga('create', '".$setting_analytics_google."', 'auto');
			ga('send', 'pageview');
		</script>
		<script async src='https://google-analytics.com/analytics.js'></script>";

		$option = get_option('setting_analytics_event_tracking');

		if($option != '')
		{
			$arr_events = array();

			foreach(explode("\n", $option) as $event)
			{
				if(strpos($event, "|"))
				{
					list($event_title, $event_selector) = explode("|", $event);

					if($event_title != '' && $event_selector != '')
					{
						$arr_events[] = array('title' => $event_title, 'selector' => $event_selector);
					}
				}
			}

			if(count($arr_events) > 0)
			{
				mf_enqueue_script('script_analytics', plugin_dir_url(__FILE__)."script_analytics.js", array('events' => $arr_events));
			}
		}
	}

	if($setting_analytics_clicky != '')
	{
		echo "<script src='//static.getclicky.com/js'></script>
		<script>clicky.init(".$setting_analytics_clicky.");</script>";
	}
}