<?php
 
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
} 


 

add_action( 'admin_menu', 'register_my_withdraw_menu_page' );



function register_my_withdraw_menu_page() {
  
  
 add_menu_page( 'Withdraw', 'Withdraw', 'manage_options', 'withdrawal' );

 add_submenu_page( 'withdrawal'  , 'Withdraw', 'Withdrawal', 'manage_options', 'withdrawal', 'withdrawal',  90 );

    
  add_submenu_page( 'withdrawal'  ,'Withdraw', 'Withdrawal List', 'manage_options', 'withdrawal_list', 'withdrawal_list',  90 );

    
}


function withdrawal(){

include_once dirname(__FILE__) . '/Withdrawal.php';
}

function withdrawal_list(){
include_once dirname(__FILE__) . '/Widthdrawal_requests.php';
}