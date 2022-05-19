<?php
/*
Plugin Name: Saksh Escrow Email System
Version:  2.1
Stable tag: 2.1
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Saksh Escrow System is a plateform allow parties to complete safe payments.  


*/

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}

function aistore_scripts_method_email()
{

   wp_enqueue_script( 'bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js', array('jquery'), NULL, true );
   

      
   wp_enqueue_style( 'bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', false, NULL, 'all' );
  
    
}

add_action('admin_enqueue_scripts', 'aistore_scripts_method_email');


function aistore_escrow_extension_email_extension_function( $aistore_escrow_extensions ) {
   
        $aistore_escrow_extensions[] = 'Email_Extensions';
  
    return $aistore_escrow_extensions;
}
add_filter( 'aistore_escrow_extension', 'aistore_escrow_extension_email_extension_function' );


  
 
include_once dirname(__FILE__). '/aistore_email_install.php';


include_once dirname(__FILE__) . '/email_report.php';

include_once dirname(__FILE__) . '/send_email.php';
include_once dirname(__FILE__) . '/menu.php';