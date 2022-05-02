<?php


if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}

function aistore_st_scripts_method()
{
    
    wp_enqueue_style('aistore', plugins_url('/css/chat.css', __FILE__) , array());
    // wp_enqueue_style('aistore', plugins_url('/css/custom.css', __FILE__) , array());
    wp_enqueue_script('aistore', plugins_url('/js/chat.js', __FILE__) , array(
        'jquery'
    ));
     wp_enqueue_script( 'ajax-script', plugins_url( '/js/chat.js', __FILE__ ), array('jquery') );

// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value

wp_localize_script( 'ajax-script', 'ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
}

add_action('wp_enqueue_scripts', 'aistore_st_scripts_method');

include_once dirname(__FILE__) . '/Aistorechat.class.php';


add_shortcode('aistore_escrow_chat', array(
    'Aistorechat',
    'aistore_escrow_chat'
));

 