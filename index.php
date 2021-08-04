<?php
/*
Plugin Name: MF Analytics
Plugin URI: https://github.com/frostkom/mf_analytics
Description: 
Version: 3.3.1
Licence: GPLv2 or later
Author: Martin Fors
Author URI: https://frostkom.se
Text Domain: lang_analytics
Domain Path: /lang

Depends: MF Base
GitHub Plugin URI: frostkom/mf_analytics

API Documentation: https://developers.google.com/analytics/devguides/collection/analyticsjs/cookies-user-id
*/

if(function_exists('is_plugin_active') && is_plugin_active("mf_base/index.php"))
{
	include_once("include/classes.php");

	$obj_analytics = new mf_analytics();

	if(is_admin())
	{
		register_uninstall_hook(__FILE__, 'uninstall_analytics');

		add_action('admin_init', array($obj_analytics, 'settings_analytics'));
		add_action('admin_init', array($obj_analytics, 'admin_init'), 0);

		load_plugin_textdomain('lang_analytics', false, dirname(plugin_basename(__FILE__))."/lang/");
	}

	else
	{
		add_filter('template_redirect', array($obj_analytics, 'template_redirect'), 1, 0);

		add_action('wp_head', array($obj_analytics, 'wp_head'), 0);
		add_action('wp_footer', array($obj_analytics, 'wp_footer'));

		add_filter('login_redirect', array($obj_analytics, 'login_redirect'), 11, 3); // Has to be triggered last
	}

	add_filter('filter_direct_link_url', array($obj_analytics, 'filter_direct_link_url'), 10, 2);

	function uninstall_analytics()
	{
		mf_uninstall_plugin(array(
			'options' => array('setting_analytics_albacross', 'setting_analytics_clicky', 'setting_analytics_facebook', 'setting_analytics_fullstory', 'setting_analytics_tag_manager', 'setting_google_search_console', 'setting_analytics_google', 'setting_analytics_event_tracking', 'setting_analytics_campaign_name', 'setting_analytics_save_admin_stats'),
		));
	}
}