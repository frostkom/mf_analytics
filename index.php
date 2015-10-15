<?php
/*
Plugin Name: MF Analytics
Plugin URI: http://github.com/frostkom/mf_analytics
Version: 1.0.1
Author: Martin Fors
Author URI: http://frostkom.se
*/

if(is_admin())
{
	add_action('admin_init', 'settings_analytics');
	add_action('admin_menu', 'menu_analytics');
}

else
{
	add_action('wp_footer', 'footer_analytics');
}

include("include/functions.php");