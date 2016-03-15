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
	include dirname( __FILE__ ).'/includes/class-form-handler-ziparea.php';
	include dirname( __FILE__ ).'/includes/zip-functions.php';
	
	new Ziparea_Admin_Menu();
});

add_action('wp_ajax_get_all_zip_ajax', 'get_all_zip_ajax');
function get_all_zip_ajax() {
    global $wpdb;
    
    $kode_pos=(isset($_POST['b_kode_pos'])) ? sanitize_text_field($_POST['b_kode_pos']) :sanitize_text_field($_POST['f_kode_pos']);
    $area=(isset($_POST['b_area'])) ? sanitize_text_field($_POST['b_area']) :sanitize_text_field($_POST['f_area']);

    if ( $kode_pos ) {
        $items = $wpdb->get_results( "SELECT DISTINCT kecamatan, kelurahan, zip FROM " . $wpdb->prefix . "z WHERE zip like '".$kode_pos."%' and area_id='".$area."'");
    }
    $json=array();
    if(is_array($items) and $items) {
    	foreach ($items as $key => $value) {
    		$json[$key]=array(
                'kecamatan'=>$value->kecamatan,
    			'kelurahan'=>$value->kelurahan,
    			'zip'=>$value->zip,
    		);
    	}
    }

    header('Content-Type: application/json');
    echo json_encode($json);
    exit;
}

add_action('wp_ajax_get_all_street_ajax', 'get_all_street_ajax');
function get_all_street_ajax() {
    global $wpdb;
    
    $kode_post=(isset($_POST['b_kode_post'])) ? sanitize_text_field($_POST['b_kode_post']) : sanitize_text_field($_POST['f_kode_post']);
    $street=(isset($_POST['b_street'])) ? sanitize_text_field($_POST['b_street']) : sanitize_text_field($_POST['f_street']);
    $area=(isset($_POST['b_area'])) ? sanitize_text_field($_POST['b_area']) : sanitize_text_field($_POST['f_area']);

    if ( $street ) {
        $items = $wpdb->get_results( "SELECT DISTINCT street_name FROM " . $wpdb->prefix . "z WHERE zip = '".$kode_post."' AND street_name like '".$street."%'");
    }
    $json=array();
    if(is_array($items) and $items) {
    	foreach ($items as $key => $value) {
    		$json[$key]=array(
    			'street_name'=>$value->street_name,
    		);
    	}
    }

    header('Content-Type: application/json');
    echo json_encode($json);
    exit;
}

if (isset($_POST['b_kode_pos']) and isset($_POST['b_area'])) {
    do_action( 'wp_ajax_get_all_zip_ajax' );
}

if (isset($_POST['b_street']) and isset($_POST['b_kode_post']) and isset($_POST['b_area'])) {
	do_action( 'wp_ajax_get_all_street_ajax' );
}