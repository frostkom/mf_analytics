<?php
/*
Plugin Name: MF Analytics
Plugin URI: https://github.com/frostkom/mf_analytics
Description: 
Version: 2.0.3
Author: Martin Fors
Author URI: http://frostkom.se
Text Domain: lang_analytics
Domain Path: /lang

GitHub Plugin URI: frostkom/mf_analytics
*/

include_once("include/functions.php");

add_action('init', 'init_analytics');

if(is_admin())
{
	register_uninstall_hook(__FILE__, 'uninstall_analytics');

	add_action('admin_init', 'settings_analytics');

	load_plugin_textdomain('lang_analytics', false, dirname(plugin_basename(__FILE__)).'/lang/');
}

else
{
	add_action('wp_footer', 'footer_analytics');
}

function uninstall_analytics()
{
	mf_uninstall_plugin(array(
		'options' => array('setting_analytics_google', 'setting_analytics_clicky', 'setting_analytics_save_admin_stats'),
	));
}