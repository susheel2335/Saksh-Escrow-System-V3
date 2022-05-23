<?php
 
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
} 


 

add_action( 'admin_menu', 'aistore_withdraw_register_menu_page' );

      
     /**
       * This function is used to withdraw register menu page
       * Withdraw
       * Withdrawal List
      */

function aistore_withdraw_register_menu_page() {
  
  
 add_menu_page( 'Withdraw', 'Withdraw', 'manage_options', 'withdrawal' );

 add_submenu_page( 'withdrawal'  , 'Withdraw', 'Withdrawal', 'manage_options', 'withdrawal', 'withdrawal',  90 );

    
  add_submenu_page( 'withdrawal'  ,'Withdraw', 'Withdrawal List', 'manage_options', 'withdrawal_list', 'withdrawal_list',  90 );

    
}

  /**
       * This function is used to withdraw details 
       * Apprive Withdraw
       * Reject Withdrawa
       * Usernane
       * Amount
       * Status
       * Date
      */

function withdrawal(){

include_once dirname(__FILE__) . '/Withdrawal.php';
}


  /**
       * This function is used to withdraw list menu page
       * Withdrawal List
       *  Usernane
       * Amount
       * Status
       * Date
      */

function withdrawal_list(){
include_once dirname(__FILE__) . '/Widthdrawal_requests.php';
}