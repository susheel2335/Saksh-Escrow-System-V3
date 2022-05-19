<?php

function escrow_extension($extension_name){
    

global $wpdb;

$results = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_extension where name=%s", $extension_name)
);


 
    return  $results ;
 
 

}

         
include_once dirname(__FILE__) . '/aistore_chat_system/index.php';
  
include_once dirname(__FILE__) . '/aistore_email/index.php';
   
include_once dirname(__FILE__) . '/aistore_file_upload/index.php';
 
include_once dirname(__FILE__) . '/aistore_notifications/index.php';
 
 include_once dirname(__FILE__) . '/aistore_payment_gateway/index.php';
 

include_once dirname(__FILE__) . '/aistore_wallet/index.php';
 
include_once dirname(__FILE__) . '/saksh_wallet_currency_convert/index.php';
  
 include_once dirname(__FILE__) . '/aistore_bank_payment/index.php';
 
include_once dirname(__FILE__) . '/aistore_withdraw/index.php';
 











