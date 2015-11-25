<?php
/*
Plugin Name: MF Analytics
Plugin URI: http://github.com/frostkom/mf_analytics
Version: 1.1.3
Author: Martin Fors
Author URI: http://frostkom.se
*/

add_action('init', 'include_analytics');

function include_analytics()
{
	include_once("include/functions.php");
}

add_action('init', 'init_analytics');

if(is_admin())
{
	add_action('admin_init', 'settings_analytics');

	load_plugin_textdomain('lang_analytics', false, dirname(plugin_basename(__FILE__)).'/lang/');
}

else
{
	add_action('wp_footer', 'footer_analytics');
}