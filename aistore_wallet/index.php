<?php


if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}





include_once dirname(__FILE__) . '/admin/user_transaction_list.php';
include_once dirname(__FILE__) . '/admin/transaction_list.php';
include_once dirname(__FILE__) . '/admin/user_balance.php';
include_once dirname(__FILE__) . '/AistoreWallet.class.php';
include_once dirname(__FILE__) . '/Aistore_WithdrawalSystem.class.php';
include_once dirname(__FILE__) . '/Widthdrawal_requests.php';
include_once dirname(__FILE__) . '/user_bank_details.php';
include_once dirname(__FILE__) . '/menu.php';


add_shortcode('aistore_transaction_history', array(
    'AistoreWallet',
    'aistore_transaction_history'
));

 add_shortcode('aistore_saksh_withdrawal_system', array(
    'Aistore_WithdrawalSystem',
    'aistore_saksh_withdrawal_system'
));
 
 
  add_shortcode('aistore_bank_account', array(
    'Aistore_WithdrawalSystem',
    'aistore_bank_account'
));


