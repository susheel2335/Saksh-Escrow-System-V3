<?php
 
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
} 


 

add_action( 'admin_menu', 'aistore_escrow_register_my_notification_menu_page' );

function aistore_escrow_register_my_notification_menu_page() {
  
  
  add_menu_page( 'Notification Setting', 'Notification Setting', 'manage_options', 'aistore_escrow_notification_setting');

    
  add_submenu_page( 'aistore_escrow_notification_setting'  , 'Notification Setting', 'Setting', 'manage_options', 'aistore_escrow_notification_setting', 'aistore_escrow_notification_setting',  90 );

     
   
  add_submenu_page( 'aistore_escrow_notification_setting'  , 'Notification Setting', 'Report', 'manage_options', 'aistore_escrow_notification_report', 'aistore_escrow_notification_report',  90 );

    
}

function aistore_escrow_notification_setting(){

    include dirname(__FILE__) . "/admin/notification_setting.php";

}

function aistore_escrow_notification_report(){

    include dirname(__FILE__) . "/admin/notification_report.php";

}