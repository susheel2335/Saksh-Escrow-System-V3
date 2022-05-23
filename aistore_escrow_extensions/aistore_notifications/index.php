<?php
/*
Plugin Name: Saksh Escrow Notification System
Version:  2.1
Stable tag: 2.1
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Saksh Escrow System is a plateform allow parties to complete safe payments.  


*/

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}


 add_action('AistoreEscrow_Install', 'aistore_notification_escrow_plugin_table_install' ); 
      
      
      
       /**
       * 
       * This function is used to create escrow notification table
       * @params id
       * @params type
       * @params message
       * @params user_email
       * @params url
       * @params reference_id
       * @params created_at
       * 
       */ 
      
function aistore_notification_escrow_plugin_table_install()
{
    
    
    aistore_notification_escrow_message();
    
    
    global $wpdb;

    $table_escrow_notification = "CREATE TABLE  IF NOT EXISTS  " . $wpdb->prefix . "escrow_notification  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  type varchar(100) NOT NULL,
   message  text  NOT NULL,
   user_email  varchar(100)   NOT NULL,
  url varchar(100)   NOT NULL,
  reference_id bigint(20)   NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($table_escrow_notification);

}

register_activation_hook(__FILE__, 'aistore_escrow_plugin_notification_table_install');

include_once dirname(__FILE__) . '/Notificationmenu.class.php';



    
    
function aistore_notification_escrow_message() 
{  
     /**
       * This function is used to set notification message register setting.
       * Created Escrow
       * Accept Escrow
       * Dispute Escrow
       * Release Escrow
       * Cancel Escrow
       * Created Partner Escrow
       * Accept Partner Escrow
       * Dispute Partner Escrow
       * Release Partner Escrow
       * Cancel Partner Escrow
      */
      

    update_option('created_escrow', 'You have successfully created the escrow # [EID]');
    update_option('partner_created_escrow', 'Your partner have successfully created the escrow # [EID]');
    update_option('accept_escrow', 'You have successfully  accepted the escrow # [EID]');
    update_option('partner_accept_escrow', 'Your partner have successfully accepted the escrow # [EID]');

    update_option('dispute_escrow', 'You have successfully  disputed the escrow # [EID]');
    update_option('partner_dispute_escrow', 'Your partner have successfully disputed the escrow # [EID]');
    update_option('release_escrow', 'You have successfully  released the escrow # [EID]');
    update_option('partner_release_escrow', 'Your partner have successfully released the escrow # [EID]');

    update_option('cancel_escrow', 'You have successfully  cancelled the escrow # [EID]');
    update_option('partner_cancel_escrow', 'Your partner have successfully cancelled the escrow # [EID]');
    update_option('shipping_escrow', 'you have updated the shipping details for the escrow# [EID]');
    update_option('partner_shipping_escrow', 'Your partner has updated the shipping details for the escrow# [EID]');

    update_option('buyer_deposit', 'Your payment  has been accepted for the escrow  # [EID]');
    update_option('seller_deposit', 'You have deposited the payment into  the escrow for  the transaction  escrow # [EID]');
    update_option('Buyer_Mark_Paid', 'You have successfully  marked escrow # [EID]');
     update_option('PaymentRefund', 'Payment for the escrow #[EID] has been  refunded/cancelled/denied by admin');
    update_option('PaymentAccepted', 'Payment for the escrow #[EID] has been approved by admin');

} 





 
     /**
       * This function is used to set notification tabs
      
       
      */
     
     add_action('aistore_escrow_tab_button', 'aistore_notifications_escrow_tab_button' ); 
     
     function aistore_notifications_escrow_tab_button($escrow)
{
   
    ?>
      <button class="nav-link" id="nav-notifications-tab" data-bs-toggle="tab" data-bs-target="#nav-notifications" type="button" role="tab" aria-controls="nav-notifications" aria-selected="false">   Notifications</button>
      
      <?php
      
      
}




    add_action('aistore_escrow_tab_contents', 'aistore_notifications_escrow_tab_contents' ); 
     
     function aistore_notifications_escrow_tab_contents($escrow)
{
   
    
    
    ?> 
     
   <div class="tab-pane fade show active" id="nav-notifications" role="tabpanel" aria-labelledby="nav-notifications-tab">
         
 <?php  aistore_notification_report($escrow); ?>
 
 
  </div>
      
      <?php
      
       
}





include_once dirname(__FILE__) . '/user_notification.php';


include_once dirname(__FILE__) . '/sendnotification.php';

include_once dirname(__FILE__) . '/notification_api.php';

include_once dirname(__FILE__) . '/admin/page_setting.php';


 function aistore_notification_escrow_extension_function( $aistore_escrow_extensions ) {
   
        $aistore_escrow_extensions[] = 'notification';
  
    return $aistore_escrow_extensions;
}
add_filter( 'aistore_escrow_extension', 'aistore_notification_escrow_extension_function' );

  add_action('aistore_escrow_admin_tab_contents', 'aistore_notification_escrow_admin_tab_contents' ); 
    

function  aistore_notification_escrow_admin_tab_contents()

{
    ?>
      <div class="tab-pane fade" id="nav-notification" role="tabpanel" aria-labelledby="nav-notification-tab">
      
 
        <?php
        do_action('AistoreNotification_setting');
         submit_button(); ?>
  
  
  </div>
  
  
  <?php
    
    
}

    add_action('aistore_escrow_admin_tab', 'aistore_notification_details_tab' ); 
    

function  aistore_notification_details_tab()

{
 echo  '
    <button class="nav-link" id="nav-notification-tab" data-bs-toggle="tab" data-bs-target="#nav-notification" type="button" role="tab" aria-controls="nav-notification" aria-selected="false">Notification</button> 
     
     ';
    
 
}





    