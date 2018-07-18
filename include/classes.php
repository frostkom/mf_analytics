<?php

class mf_analytics
{
	function __construct()
	{

	}

	function settings_analytics()
	{
		$options_area = __FUNCTION__;

		add_settings_section($options_area, "", array($this, $options_area."_callback"), BASE_OPTIONS_PAGE);

		$arr_settings = array();
		$arr_settings['setting_analytics_google'] = __("Google Analytics", 'lang_analytics');

		if(get_option('setting_analytics_google') != '')
		{
			$arr_settings['setting_analytics_save_admin_stats'] = __("Save admin statistics", 'lang_analytics');
			$arr_settings['setting_analytics_event_tracking'] = __("Track events", 'lang_analytics');
		}

		$arr_settings['setting_analytics_tag_manager'] = __("Google Tag Manager", 'lang_analytics');
		$arr_settings['setting_analytics_clicky'] = __("Clicky", 'lang_analytics');
		$arr_settings['setting_analytics_fullstory'] = __("FullStory", 'lang_analytics');

		show_settings_fields(array('area' => $options_area, 'object' => $this, 'settings' => $arr_settings));
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

		$suffix = ($option == '' ? "<a href='//analytics.google.com/analytics/web/'>".__("Get Yours Here", 'lang_analytics')."</a>" : "");

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'placeholder' => "UA-0000000-0", 'suffix' => $suffix));
	}

	function setting_analytics_tag_manager_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		$suffix = ($option == '' ? "<a href='//google.com/analytics/tag-manager/'>".__("Get Yours Here", 'lang_analytics')."</a>" : "");

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'placeholder' => "GTM-00000", 'suffix' => $suffix));
	}

	function setting_analytics_save_admin_stats_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		echo show_select(array('data' => get_yes_no_for_select(array('return_integer' => true)), 'name' => $setting_key, 'value' => $option));
	}

	function setting_analytics_event_tracking_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		echo show_textarea(array('name' => $setting_key, 'value' => $option, 'placeholder' => __("Outbound Links", 'lang_analytics')."|.phone a, .url a"));

		if($option != '')
		{
			echo "<ol>
				<li>".sprintf(__("Log in to your account at %s", 'lang_analytics'), "<a href='//analytics.google.com'>Analytics</a>")."</li>
				<li>".__("Choose this website if you have more than one connected", 'lang_analytics')."</li>
				<li>".__("Go to Content -> Events -> Overview", 'lang_analytics')."</li>
			</ol>";
		}
	}

	function setting_analytics_clicky_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		$suffix = ($option == '' ? "<a href='//clicky.com/user/register'>".__("Get yours here", 'lang_analytics')."</a>" : "");

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'suffix' => $suffix));
	}

	function setting_analytics_fullstory_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		$suffix = ($option == '' ? "<a href='//fullstory.com/pricing/'>".__("Get yours here", 'lang_analytics')."</a>" : "");

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'placeholder' => "ABCD", 'suffix' => $suffix));
	}

	function admin_init()
	{
		if(get_option('setting_analytics_save_admin_stats') && is_user_logged_in())
		{
			$this->wp_head();
		}
	}

	function gather_services_used()
	{
		$out = "";
		$arr_services = array();

		if(get_option('setting_analytics_google') != '')
		{
			$arr_services[] = __("Google Analytics", 'lang_analytics');
		}

		if(get_option('setting_analytics_tag_manager') != '')
		{
			$arr_services[] = __("Google Tag Manager", 'lang_analytics');
		}

		if(get_option('setting_analytics_clicky') != '')
		{
			$arr_services[] = __("Clicky", 'lang_analytics');
		}

		if(get_option('setting_analytics_fullstory') != '')
		{
			$arr_services[] = __("FullStory", 'lang_analytics');
		}

		$count_temp = count($arr_services);

		for($i = 0; $i < $count_temp; $i++)
		{
			if($out != '')
			{
				if($i == ($count_temp - 1))
				{
					$out .= " & ";
				}

				else
				{
					$out .= ", ";
				}
			}

			$out .= $arr_services[$i];
		}

		return $out;
	}

	function add_policy($content)
	{
		$content .= "<h3>".__("Analytics", 'lang_analytics')."</h3>"
		.sprintf(__("We use %s which stores aggregated data regarding your visit on this site to improve our website and evaluate our marketing efforts.", 'lang_analytics'), $this->gather_services_used());

		return $content;
	}

	function wp_head()
	{
		$setting_analytics_google = get_option('setting_analytics_google');
		$setting_analytics_tag_manager = get_option('setting_analytics_tag_manager');
		$setting_analytics_clicky = get_option('setting_analytics_clicky');
		$setting_analytics_fullstory = get_option('setting_analytics_fullstory');

		$plugin_include_url = plugin_dir_url(__FILE__);
		$plugin_version = get_plugin_version(__FILE__);

		if($setting_analytics_google != '')
		{
			wp_enqueue_script('script_analytics_google_api', "https://google-analytics.com/analytics.js", array(), $plugin_version); //www.googletagmanager.com/gtag/js?id=
			mf_enqueue_script('script_analytics_google', $plugin_include_url."script_google.js", array('api_key' => $setting_analytics_google), $plugin_version);

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
							$arr_events[] = array('title' => $event_title, 'selector' => trim($event_selector));
						}
					}
				}

				if(count($arr_events) > 0)
				{
					mf_enqueue_script('script_analytics_events', $plugin_include_url."script_events.js", array('events' => $arr_events), $plugin_version);
				}
			}
		}

		if($setting_analytics_tag_manager != '')
		{
			wp_enqueue_script('script_analytics_tag_manager_api', "https://www.googletagmanager.com/gtm.js?id=".$setting_analytics_tag_manager, $plugin_version);
			mf_enqueue_script('script_analytics_tag_manager', $plugin_include_url."script_tag_manager.js", array('api_key' => $setting_analytics_tag_manager), $plugin_version);
		}

		if($setting_analytics_clicky != '')
		{
			mf_enqueue_script('script_analytics_clicky_api', "//static.getclicky.com/js", $plugin_version);
			mf_enqueue_script('script_analytics_clicky', $plugin_include_url."script_clicky.js", array('api_key' => $setting_analytics_clicky), $plugin_version);
		}

		if($setting_analytics_fullstory != '')
		{
			mf_enqueue_script('script_analytics_fullstory', $plugin_include_url."script_fullstory.js", array('api_key' => $setting_analytics_fullstory), $plugin_version);
		}
	}
}