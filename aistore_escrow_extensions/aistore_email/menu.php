<?php
 
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
} 


 

add_action( 'admin_menu', 'register_my_email_menu_page' );



function register_my_email_menu_page() {
  
  
  add_menu_page( 'Email Setting', 'Email Setting', 'manage_options', 'aistore_email_setting');

    
  add_submenu_page( 'aistore_email_setting'  , 'Email Setting', 'Setting', 'manage_options', 'aistore_email_setting', 'aistore_email_setting',  90 );

     
   
  add_submenu_page( 'aistore_email_setting'  , 'Email Setting', 'Report', 'manage_options', 'aistore_all_email_report', 'aistore_all_email_report',  90 );

    
}

function aistore_email_setting(){

    include dirname(__FILE__) . "/admin/email_setting.php";

}
function aistore_all_email_report(){

    include dirname(__FILE__) . "/admin/all_email_report.php";

}
