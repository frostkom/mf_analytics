<?php

class mf_analytics
{
	function __construct(){}

	function settings_analytics()
	{
		$options_area = __FUNCTION__;

		add_settings_section($options_area, "", array($this, $options_area."_callback"), BASE_OPTIONS_PAGE);

		$arr_settings = array();
		$arr_settings['setting_analytics_clicky'] = "Clicky";
		$arr_settings['setting_analytics_facebook'] = "Facebook Pixel";
		$arr_settings['setting_analytics_fullstory'] = "FullStory";
		$arr_settings['setting_analytics_google'] = "Google Analytics";

		if(get_option('setting_analytics_google') != '')
		{
			$arr_settings['setting_analytics_event_tracking'] = __("Track Events", 'lang_analytics');
			$arr_settings['setting_analytics_campaign_name'] = __("Campaign Name", 'lang_analytics');
			$arr_settings['setting_analytics_save_admin_stats'] = __("Save Statistics in Admin Interface", 'lang_analytics');
		}

		$arr_settings['setting_analytics_tag_manager'] = "Google Tag Manager";

		show_settings_fields(array('area' => $options_area, 'object' => $this, 'settings' => $arr_settings));
	}

	function settings_analytics_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);

		echo settings_header($setting_key, __("Analytics", 'lang_analytics'));
	}

	function setting_analytics_clicky_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		$suffix = ($option == '' ? "<a href='//clicky.com/user/register'>".__("Get yours here", 'lang_analytics')."</a>" : "");

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'suffix' => $suffix));
	}

	function setting_analytics_facebook_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		$suffix = ($option == '' ? "<a href='//www.facebook.com/events_manager/pixel/'>".__("Get yours here", 'lang_analytics')."</a>" : "");

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'placeholder' => "1234", 'suffix' => $suffix));
	}

	function setting_analytics_fullstory_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		$suffix = ($option == '' ? "<a href='//fullstory.com/pricing/'>".__("Get yours here", 'lang_analytics')."</a>" : "");

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'placeholder' => "ABCD", 'suffix' => $suffix));
	}

	function setting_analytics_google_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		$suffix = ($option == '' ? "<a href='//analytics.google.com/analytics/web/'>".__("Get yours here", 'lang_analytics')."</a>" : "");

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'placeholder' => "UA-0000000-0", 'suffix' => $suffix));
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

	function setting_analytics_campaign_name_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'placeholder' => date("Ym")."_campaign_name"));
	}

	function setting_analytics_save_admin_stats_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		echo show_select(array('data' => get_yes_no_for_select(array('return_integer' => true)), 'name' => $setting_key, 'value' => $option));
	}

	function setting_analytics_tag_manager_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		$suffix = ($option == '' ? "<a href='//google.com/analytics/tag-manager/'>".__("Get yours here", 'lang_analytics')."</a>" : "");

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'placeholder' => "GTM-00000", 'suffix' => $suffix));
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

		if(get_option('setting_analytics_clicky') != '')
		{
			$arr_services[] = "Clicky";
		}

		if(get_option('setting_analytics_facebook') != '')
		{
			$arr_services[] = "Facebook Pixel";
		}

		if(get_option('setting_analytics_fullstory') != '')
		{
			$arr_services[] = "FullStory";
		}

		if(get_option('setting_analytics_google') != '')
		{
			$arr_services[] = "Google Analytics";
		}

		if(get_option('setting_analytics_tag_manager') != '')
		{
			$arr_services[] = "Google Tag Manager";
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
		$services_used = $this->gather_services_used();

		if($services_used != '')
		{
			$content .= "<h3>".__("Analytics", 'lang_analytics')."</h3>
			<p>"
				.sprintf(__("We use %s which stores aggregated data regarding your visit on this site to improve our website and evaluate our marketing efforts.", 'lang_analytics'), $services_used)
			."</p>";
		}

		return $content;
	}

	function has_do_not_track()
	{
		$out = (isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] == 1);

		if($out == true)
		{
			// We don't want a DNT visitor, which is not logged in, to set the cache, which then is used by all other visitors no matter what their preference is
			if(is_plugin_active("mf_cache/index.php") && get_option('setting_activate_cache') == 'yes')
			{
				$out = is_user_logged_in();
			}
		}

		return $out;
	}

	function wp_head()
	{
		if(!$this->has_do_not_track())
		{
			$setting_analytics_clicky = get_option('setting_analytics_clicky');
			$setting_analytics_facebook = get_option('setting_analytics_facebook');
			$setting_analytics_fullstory = get_option('setting_analytics_fullstory');
			$setting_analytics_google = get_option('setting_analytics_google');
			$setting_analytics_tag_manager = get_option('setting_analytics_tag_manager');

			$plugin_include_url = plugin_dir_url(__FILE__);
			$plugin_version = get_plugin_version(__FILE__);

			if($setting_analytics_clicky != '')
			{
				mf_enqueue_script('script_analytics_clicky_api', "//static.getclicky.com/js", $plugin_version);
				mf_enqueue_script('script_analytics_clicky', $plugin_include_url."script_clicky.js", array('api_key' => $setting_analytics_clicky), $plugin_version);
			}

			if($setting_analytics_facebook != '')
			{
				mf_enqueue_script('script_analytics_facebook', $plugin_include_url."script_facebook.js", array('api_key' => $setting_analytics_facebook), $plugin_version);
			}

			if($setting_analytics_fullstory != '')
			{
				mf_enqueue_script('script_analytics_fullstory', $plugin_include_url."script_fullstory.js", array('api_key' => $setting_analytics_fullstory), $plugin_version);
			}

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
		}
	}

	function wp_footer()
	{
		if(!$this->has_do_not_track())
		{
			$setting_analytics_facebook = get_option('setting_analytics_facebook');

			if($setting_analytics_facebook != '')
			{
				echo "<noscript>
					<img height='1' width='1' style='display:none' src='https://www.facebook.com/tr?id=".$setting_analytics_facebook."&ev=PageView&noscript=1'>
				</noscript>";
			}
		}
	}

	function login_redirect($redirect_to, $request, $user)
	{
		$setting_analytics_campaign_name = get_option('setting_analytics_campaign_name');

		if($setting_analytics_campaign_name != '')
		{
			$utm_source = check_var('utm_source');
			$utm_medium = check_var('utm_medium');

			$redirect_to .= (preg_match("/\?/", $redirect_to) ? "&" : "?")
				."utm_source=".$utm_source
				."&utm_medium=".$utm_medium
				."&utm_campaign=".$setting_analytics_campaign_name; //."&utm_term=".$user->user_login
		}

		return $redirect_to;
	}

	function filter_direct_link_url($url, $data)
	{
		$setting_analytics_campaign_name = get_option('setting_analytics_campaign_name');

		if($setting_analytics_campaign_name != '')
		{
			$url .= "&utm_source=".$data['type']."&utm_medium=directlink_".$data['user_data']->user_login."&utm_campaign=".$setting_analytics_campaign_name; //."&utm_term=".$data['user_data']->user_login
		}

		return $url;
	}
}