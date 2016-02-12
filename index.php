<?php
/*
Plugin Name: MF Analytics
Plugin URI: http://github.com/frostkom/mf_analytics
Description: 
Version: 1.1.8
Author: Martin Fors
Author URI: http://frostkom.se
*/

include_once("include/functions.php");

add_action('init', 'init_analytics');

if(is_admin())
{
	add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'add_action_analytics');
	add_filter('network_admin_plugin_action_links_'.plugin_basename(__FILE__), 'add_action_analytics');
	add_action('admin_init', 'settings_analytics');

	load_plugin_textdomain('lang_analytics', false, dirname(plugin_basename(__FILE__)).'/lang/');
}

else
{
	add_action('wp_footer', 'footer_analytics');
}