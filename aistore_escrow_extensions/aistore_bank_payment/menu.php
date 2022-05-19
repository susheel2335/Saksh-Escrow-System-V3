<?php
 
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
} 


 

add_action( 'admin_menu', 'aistore_bank_register_menu_page' );



function aistore_bank_register_menu_page() {
  
  
  add_menu_page( 'Bank Payment', 'Bank Payment', 'manage_options', 'aistore_bank_payment');

    
  add_submenu_page( 'aistore_bank_payment'  , 'Bank Payment', 'Bank Payment', 'manage_options', 'aistore_bank_payment', 'aistore_bank_payment',  90 );

     
   
//   add_submenu_page( 'aistore_bank_payment'  , 'Bank Payment', 'Bank Payment', 'manage_options', 'aistore_bank_payment', 'aistore_bank_payment',  90 );

    
}

function aistore_bank_payment(){

    include dirname(__FILE__) . "/aistore_payment_process.php";

}
// function aistore_all_email_report(){

//     include dirname(__FILE__) . "/admin/all_email_report.php";

// }
