<?php
/*
Plugin Name: Aistore Chat System
Version:  2.1
Stable tag: 2.1
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Aistore Chat System is a plateform allow parties to complete safe payments.  


*/


if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}

function aistore_st_scripts_method()
{
     wp_enqueue_script( 'bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js', array('jquery'), NULL, true );
     
   wp_enqueue_style( 'bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', false, NULL, 'all' );
   
    wp_enqueue_style('aistore_chat', plugins_url('/css/chat.css', __FILE__) , array());

    wp_enqueue_script('aistore_chat', plugins_url('/js/chat.js', __FILE__) , array(
        'jquery'
    ));
     wp_enqueue_script( 'ajax-script', plugins_url( '/js/chat.js', __FILE__ ), array('jquery') );

// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value

wp_localize_script( 'ajax-script', 'ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
}

add_action('wp_enqueue_scripts', 'aistore_st_scripts_method');


include_once dirname(__FILE__) . '/admin_setting.php';
include_once dirname(__FILE__) . '/Aistorechat.class.php';


add_shortcode('aistore_escrow_chat', array(
    'Aistorechat',
    'aistore_escrow_chat'
));

 