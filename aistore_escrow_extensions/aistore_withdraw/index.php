<?php


 add_shortcode('aistore_saksh_withdrawal_system', array(
    'Aistore_WithdrawalSystem',
    'aistore_saksh_withdrawal_system'
));
 
 
 
  add_shortcode('aistore_bank_account', array(
    'Aistore_WithdrawalSystem',
    'aistore_bank_account'
));

 include_once dirname(__FILE__) . '/menu.php';
 include_once dirname(__FILE__) . '/admin_setting.php';
 include_once dirname(__FILE__) . '/Aistore_WithdrawalSystem.class.php';
 include_once dirname(__FILE__) . '/Widthdrawal_requests.php';
 ?>