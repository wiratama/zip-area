<?php
/*
Plugin Name: Zip Area
Plugin URI: https://github.com/wiratama/zip-area
Description: Zip area palyja
Version: 0.1
Author: Arya Wiratama
Author URI: https://github.com/wiratama/
License: GPLv2 or later
Text Domain: 
Domain Path: 
*/

add_action('init', function() {
	include dirname( __FILE__ ).'/includes/class-ziparea-admin-menu.php';
	include dirname( __FILE__ ).'/includes/class-zip-list-table.php';
	include dirname( __FILE__ ).'/includes/class-form-handler.php';
	include dirname( __FILE__ ).'/includes/zip-functions.php';
	
	new Ziparea_Admin_Menu();
});