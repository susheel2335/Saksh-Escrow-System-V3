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




function aistore_escrow_extension_email_extension_function( $aistore_escrow_extensions ) {
   
        $aistore_escrow_extensions[] = 'Email Extensions';
  
    return $aistore_escrow_extensions;
}
add_filter( 'aistore_escrow_extension', 'aistore_escrow_extension_email_extension_function' );


  
 
include_once dirname(__FILE__). '/aistore_email_install.php';


include_once dirname(__FILE__) . '/email_report.php';

include_once dirname(__FILE__) . '/send_email.php';
include_once dirname(__FILE__) . '/menu.php';