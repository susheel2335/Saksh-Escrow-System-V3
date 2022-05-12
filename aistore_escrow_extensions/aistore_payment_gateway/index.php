<?php
/*
Plugin Name: Saksh Escrow Payment Gatway System
Version:  2.1
Stable tag: 2.1
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Saksh Escrow System is a plateform allow parties to complete safe payments.  


*/

include "crypto_deposit.php";
 
add_action( 'rest_api_init', function () {
  register_rest_route( 'aistore_escrow_payment/v1', '/notify_url', array(
    'methods' => 'post',
    'callback' => 'aistore_escrow_payment_nofity_url',
  ) );
} );

function aistore_escrow_payment_nofity_url()

{
    ob_start();
    
    header("Content-Type: text/html");
    
    $aep=new AistoreEscrowPayment();
    
    
       $aep->webhook();
}



