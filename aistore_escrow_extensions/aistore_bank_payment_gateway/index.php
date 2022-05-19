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
 
 
 function aistore_escrow_at_rest_init()
{
  
    $namespace = 'aistore_escrow_payment/v1';
    $route     = 'notify_url';

    register_rest_route($namespace, $route, array(
        'methods'   => WP_REST_Server::READABLE,
        'callback'  => 'aistore_escrow_payment_nofity_url'
    ));
}

add_action('rest_api_init', 'aistore_escrow_at_rest_init');


add_action( 'rest_api_init', function () {
    
    
     
     
        
  register_rest_route( 'aistore_escrow_payment/v1', '/notify_url/', array(
    'methods' => 'get',
    'callback' => 'aistore_escrow_payment_nofity_url',
    
    'permission_callback' => '__return_true',
                
                
  ) );
} );

function aistore_escrow_payment_nofity_url()

{
     return "ss";
    
   // $aep=new AistoreEscrowPayment();
    
    
    //   $aep->webhook();
}



