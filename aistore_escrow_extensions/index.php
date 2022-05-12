<?php

$wallet_system = get_option('wallet_system');
$chat_system = get_option('chat_system');
$file_upload_system = get_option('file_upload_system');
$notification_system = get_option('notification_system'); 
$email_system = get_option('email_system'); 
$currency_convert_system = get_option('currency_convert_system');
$payment_gateway_system = get_option('payment_gateway_system');
$bank_payment_system = get_option('bank_payment_system');
$withdraw_system = get_option('withdraw_system');


 if($chat_system == 'yes'){            
include_once dirname(__FILE__) . '/aistore_chat_system/index.php';
}

 if($email_system == 'yes'){   
include_once dirname(__FILE__) . '/aistore_email/index.php';
}

 if($file_upload_system == 'yes'){   
include_once dirname(__FILE__) . '/aistore_file_upload/index.php';
}

 if($notification_system == 'yes'){ 
include_once dirname(__FILE__) . '/aistore_notifications/index.php';
}

 if($payment_gateway_system == 'yes'){ 
 include_once dirname(__FILE__) . '/aistore_payment_gateway/index.php';
}
 //include_once dirname(__FILE__) . '/aistore_bank_payment_gateway/index.php';
 
// wallet plugin is mandatory so we can not allow to exclude so no if else for this

//if($wallet_system == 'yes'){
include_once dirname(__FILE__) . '/aistore_wallet/index.php';
//}

 if($currency_convert_system == 'yes'){
include_once dirname(__FILE__) . '/saksh_wallet_currency_convert/index.php';
}


 if($bank_payment_system == 'yes'){ 
 include_once dirname(__FILE__) . '/aistore_bank_payment/index.php';
}


if($withdraw_system == 'yes'){
include_once dirname(__FILE__) . '/aistore_withdraw/index.php';
}

