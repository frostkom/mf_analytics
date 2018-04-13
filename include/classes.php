<?php

class mf_analytics
{
	function __construct()
	{

	}

	function wp_head()
	{
		$setting_analytics_google = get_option('setting_analytics_google');
		$setting_analytics_clicky = get_option('setting_analytics_clicky');
		$setting_analytics_fullstory = get_option('setting_analytics_fullstory');

		if($setting_analytics_google != '')
		{
			$plugin_include_url = plugin_dir_url(__FILE__);
			$plugin_version = get_plugin_version(__FILE__);

			mf_enqueue_script('script_analytics_google_api', "https://google-analytics.com/analytics.js", $plugin_version);
			mf_enqueue_script('script_analytics_google', $plugin_include_url."script_google.js", array('api_key' => $setting_analytics_google), $plugin_version);

			/*echo "<script>
				window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
				ga('create', '".$setting_analytics_google."', 'auto');
				ga('send', 'pageview');
			</script>
			<script async src='https://google-analytics.com/analytics.js'></script>";*/

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