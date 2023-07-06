<?php

class mf_analytics
{
	function __construct(){}

	function settings_analytics()
	{
		$options_area_orig = $options_area = __FUNCTION__;

		// Generic
		############################
		add_settings_section($options_area, "", array($this, $options_area."_callback"), BASE_OPTIONS_PAGE);

		$arr_settings = array();
		$arr_settings['setting_analytics_albacross'] = "Albacross";
		$arr_settings['setting_analytics_clicky'] = "Clicky";
		$arr_settings['setting_analytics_facebook'] = "Facebook Pixel";
		$arr_settings['setting_analytics_fullstory'] = "FullStory";

		if(get_option('setting_analytics_google') == '')
		{
			$arr_settings['setting_analytics_google'] = "Google Analytics";
		}

		$arr_settings['setting_analytics_tag_manager'] = "Google Tag Manager";
		$arr_settings['setting_google_search_console'] = "Google Search Console";

		show_settings_fields(array('area' => $options_area, 'object' => $this, 'settings' => $arr_settings));
		############################

		// Google
		############################
		if(get_option('setting_analytics_google') != '')
		{
			$options_area = $options_area_orig."_google";

			add_settings_section($options_area, "", array($this, $options_area."_callback"), BASE_OPTIONS_PAGE);

			$arr_settings = array();
			$arr_settings['setting_analytics_google'] = __("Tracking ID", 'lang_analytics');
			$arr_settings['setting_analytics_event_tracking'] = __("Track Events", 'lang_analytics');
			$arr_settings['setting_analytics_campaign_name'] = __("Campaign Name", 'lang_analytics');
			$arr_settings['setting_analytics_save_admin_stats'] = __("Save Statistics in Admin Interface", 'lang_analytics');

			show_settings_fields(array('area' => $options_area, 'object' => $this, 'settings' => $arr_settings));
		}
		############################
	}

	function settings_analytics_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);

		echo settings_header($setting_key, __("Analytics", 'lang_analytics'));
	}

		function setting_analytics_albacross_callback()
		{
			$setting_key = get_setting_key(__FUNCTION__);
			$option = get_option($setting_key);

			$suffix = ($option == '' ? "<a href='//albacross.com'>".__("Get yours here", 'lang_analytics')."</a>" : "");

			echo show_textfield(array('name' => $setting_key, 'value' => $option, 'suffix' => $suffix));
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

		function setting_analytics_tag_manager_callback()
		{
			$setting_key = get_setting_key(__FUNCTION__);
			$option = get_option($setting_key);

			$suffix = ($option == '' ? "<a href='//google.com/analytics/tag-manager/'>".__("Get yours here", 'lang_analytics')."</a>" : "");

			echo show_textfield(array('name' => $setting_key, 'value' => $option, 'placeholder' => "G-012ABC", 'suffix' => $suffix));
		}

		function setting_google_search_console_callback()
		{
			$setting_key = get_setting_key(__FUNCTION__);
			$option = get_option($setting_key);

			$suffix = ($option == '' ? "<a href='//search.google.com/search-console'>".__("Get yours here", 'lang_analytics')."</a>" : "");

			echo show_textfield(array('name' => $setting_key, 'value' => $option, 'placeholder' => sprintf(__("%s or %s", 'lang_analytics'), "google0e4fd57ef13448cd.html", "abcABC"), 'suffix' => $suffix));
		}

	function settings_analytics_google_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);

		echo settings_header($setting_key, __("Analytics", 'lang_analytics')." - "."Google Analytics");
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

			echo show_select(array('data' => get_yes_no_for_select(), 'name' => $setting_key, 'value' => $option));
		}

	function admin_init()
	{
		if(get_option('setting_analytics_save_admin_stats') == 'yes' && is_user_logged_in())
		{
			$this->wp_head();
		}

		if(function_exists('wp_add_privacy_policy_content'))
		{
			$services_used = $this->gather_services_used();

			if($services_used != '')
			{
				$content = sprintf(__("We use %s which stores aggregated data regarding your visit on this site to improve our website and evaluate our marketing efforts.", 'lang_analytics'), $services_used);

				wp_add_privacy_policy_content(__("Analytics", 'lang_analytics'), $content);
			}
		}
	}

	function filter_sites_table_settings($arr_settings)
	{
		$arr_settings['settings_analytics'] = array(
			'setting_analytics_albacross' => array(
				'type' => 'string',
				'global' => false,
				'icon' => "fas fa-dove",
				'name' => "Albacross",
			),
			'setting_analytics_clicky' => array(
				'type' => 'string',
				'global' => false,
				//'icon' => "fab fa-cuttlefish",
				'icon' => "fas fa-mouse-pointer",
				'name' => "Clicky",
			),
			'setting_analytics_facebook' => array(
				'type' => 'string',
				'global' => false,
				'icon' => "fab fa-facebook",
				'name' => "Facebook Pixel",
			),
			'setting_analytics_fullstory' => array(
				'type' => 'string',
				'global' => false,
				'icon' => "fas fa-book",
				'name' => "FullStory",
			),
			'setting_analytics_google' => array(
				'type' => 'string',
				'global' => false,
				'icon' => "fab fa-google",
				'name' => "Google Analytics",
			),
			'setting_analytics_tag_manager' => array(
				'type' => 'string',
				'global' => false,
				'icon' => "fab fa-google",
				'name' => "Google Tag Manager",
			),
			'setting_google_search_console' => array(
				'type' => 'string',
				'global' => false,
				'icon' => "fab fa-google",
				'name' => "Google Search Console",
			),
		);

		return $arr_settings;
	}

	function filter_cookie_types($array)
	{
		if(get_option('setting_analytics_albacross') != '')
		{
			$array['public']['nQ_cookieId'] = array('label' => sprintf(__("Identify %s User", 'lang_analytics'), "Albacross"), 'used' => false, 'lifetime' => "1 year");
		}

		if(get_option('setting_analytics_clicky') != '')
		{
			//$array['public']['cookie_key_...'] = array('label' => __("Cookie Explanation...", 'lang_analytics'), 'used' => false, 'lifetime' => "");
		}

		if(get_option('setting_analytics_facebook') != '')
		{
			//$array['public']['cookie_key_...'] = array('label' => __("Cookie Explanation...", 'lang_analytics'), 'used' => false, 'lifetime' => "");
		}

		if(get_option('setting_analytics_fullstory') != '')
		{
			//$array['public']['cookie_key_...'] = array('label' => __("Cookie Explanation...", 'lang_analytics'), 'used' => false, 'lifetime' => "");
		}

		if(get_option('setting_analytics_google') != '')
		{
			$array['public']['_ga'] = array('label' => sprintf(__("Used to distinguish %s users", 'lang_analytics'), "Analytics"), 'used' => false, 'lifetime' => "2 year"); // 2 years
			//$array['public']['_gid'] = array('label' => sprintf(__("Used to distinguish %s users", 'lang_analytics'), "Analytics"), 'used' => false, 'lifetime' => "24 hour");
		}

		if(get_option('setting_analytics_tag_manager') != '')
		{
			//$array['public']['cookie_key_...'] = array('label' => __("Cookie Explanation...", 'lang_analytics'), 'used' => false, 'lifetime' => "");
		}

		if(get_option('setting_google_search_console') != '')
		{
			//$array['public']['cookie_key_...'] = array('label' => __("Cookie Explanation...", 'lang_analytics'), 'used' => false, 'lifetime' => "");
		}

		return $array;
	}

	function gather_services_used()
	{
		$out = "";
		$arr_services = array();

		if(get_option('setting_analytics_albacross') != '')
		{
			$arr_services[] = "Albacross";
		}

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

		if(get_option('setting_google_search_console') != '')
		{
			$arr_services[] = "Google Search Console";
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

	function template_redirect()
	{
		global $wp_query;

		if(isset($wp_query->query['name']))
		{
			$setting_google_search_console = get_option('setting_google_search_console');

			if($setting_google_search_console != '' && substr($setting_google_search_console, 0, 6) == 'google' && $wp_query->query['name'] == $setting_google_search_console)
			{
				header("Content-type: text/html; charset=".get_option('blog_charset'));

				echo "google-site-verification: ".$setting_google_search_console;
				exit;
			}
		}
	}

	function wp_head()
	{
		$allow_sensitive_data = apply_filters('get_allow_cookies', true);

		$setting_analytics_albacross = get_option('setting_analytics_albacross');
		$setting_analytics_clicky = get_option('setting_analytics_clicky');
		$setting_analytics_facebook = get_option('setting_analytics_facebook');
		$setting_analytics_fullstory = get_option('setting_analytics_fullstory');
		$setting_analytics_google = get_option('setting_analytics_google');
		$setting_analytics_tag_manager = get_option('setting_analytics_tag_manager');
		$setting_google_search_console = get_option('setting_google_search_console');

		$plugin_include_url = plugin_dir_url(__FILE__);
		$plugin_version = get_plugin_version(__FILE__);

		if($setting_analytics_albacross != '')
		{
			mf_enqueue_script('script_analytics_albacross', $plugin_include_url."script_albacross.js", array('api_key' => $setting_analytics_albacross, 'allow_cookies' => $allow_sensitive_data, 'version' => $plugin_version), $plugin_version);
		}

		if($setting_analytics_clicky != '')
		{
			//mf_enqueue_script('script_analytics_clicky_api', "//static.getclicky.com/js", $plugin_version);
			mf_enqueue_script('script_analytics_clicky', $plugin_include_url."script_clicky.js", array('api_key' => $setting_analytics_clicky, 'allow_cookies' => $allow_sensitive_data, 'version' => $plugin_version), $plugin_version);
		}

		if($setting_analytics_facebook != '')
		{
			mf_enqueue_script('script_analytics_facebook', $plugin_include_url."script_facebook.js", array('api_key' => $setting_analytics_facebook, 'allow_cookies' => $allow_sensitive_data), $plugin_version);
		}

		if($setting_analytics_fullstory != '')
		{
			mf_enqueue_script('script_analytics_fullstory', $plugin_include_url."script_fullstory.js", array('api_key' => $setting_analytics_fullstory, 'allow_cookies' => $allow_sensitive_data), $plugin_version);
		}

		if($setting_analytics_google != '')
		{
			//wp_enqueue_script('script_analytics_google_api', "https://google-analytics.com/analytics.js", array(), $plugin_version);
			//mf_enqueue_script('script_analytics_google', $plugin_include_url."script_google.js", array('api_key' => $setting_analytics_google, 'allow_cookies' => $allow_sensitive_data, 'version' => $plugin_version), $plugin_version);
			mf_enqueue_script('script_analytics_tag_manager', $plugin_include_url."script_tag_manager.js", array('api_key' => $setting_analytics_google, 'allow_cookies' => $allow_sensitive_data, 'version' => $plugin_version), $plugin_version);

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
			//wp_enqueue_script('script_analytics_tag_manager_api', "https://www.googletagmanager.com/gtm.js?id=".$setting_analytics_tag_manager, $plugin_version);
			mf_enqueue_script('script_analytics_tag_manager', $plugin_include_url."script_tag_manager.js", array('api_key' => $setting_analytics_tag_manager, 'allow_cookies' => $allow_sensitive_data, 'version' => $plugin_version), $plugin_version);
		}

		if($setting_google_search_console != '' && substr($setting_google_search_console, 0, 6) != 'google')
		{
			echo "<meta name='google-site-verification' content='".$setting_google_search_console."'>";
		}
	}

	function wp_footer()
	{
		if(apply_filters('get_allow_cookies', true) == true)
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