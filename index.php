<?php
/*
Plugin Name: MF Analytics
Plugin URI: https://github.com/frostkom/mf_analytics
Description: 
Version: 3.0.4
Licence: GPLv2 or later
Author: Martin Fors
Author URI: http://frostkom.se
Text Domain: lang_analytics
Domain Path: /lang

Depends: MF Base
GitHub Plugin URI: frostkom/mf_analytics
*/

include_once("include/classes.php");

$obj_analytics = new mf_analytics();

if(is_admin())
{
	register_uninstall_hook(__FILE__, 'uninstall_analytics');

	add_action('admin_init', array($obj_analytics, 'settings_analytics'));
	add_action('admin_init', array($obj_analytics, 'admin_init'), 0);

	load_plugin_textdomain('lang_analytics', false, dirname(plugin_basename(__FILE__)).'/lang/');
}

else
{
	add_action('wp_head', array($obj_analytics, 'wp_head'), 0);
}

function uninstall_analytics()
{
	mf_uninstall_plugin(array(
		'options' => array('setting_analytics_google', 'setting_analytics_tag_manager', 'setting_analytics_clicky', 'setting_analytics_save_admin_stats'),
	));
}