<?php
 class Notificationmenu
{


  private $options;


  public function __construct()
    {
        
           add_action('admin_menu', array(
            $this,
            'aistore_escrow_register_my_notification_menu_page'
        ));
      
      
        
           add_action('admin_init', array(
            $this,
            'aistore_notification_register_setting'
        ));
    }


function aistore_escrow_register_my_notification_menu_page() {
  
     add_options_page('Notification Setting', __('Notification Setting', 'aistore') , 'administrator', 'Notification-setting-admin', array(
            $this,
            'aistore_escrow_notification_setting'
        ));
        
        
          add_menu_page(__('Notification', 'aistore') , __('Notification', 'aistore') , 'administrator', 'aistore_escrow_notification_setting');
          
          
        add_submenu_page('aistore_escrow_notification_setting', __('Notification Setting', 'aistore') , __('Setting', 'aistore') , 'administrator', 'aistore_escrow_notification_setting', array(
            $this,
            'aistore_escrow_notification_setting'
        ));


     add_submenu_page('aistore_escrow_notification_setting', __('Report', 'aistore') , __('Report', 'aistore') , 'administrator', 'aistore_escrow_notification_report', array(
            $this,
            'aistore_escrow_notification_report'
        ));



        
 
    
}

function aistore_escrow_notification_setting(){

    include dirname(__FILE__) . "/admin/notification_setting.php";

}

function aistore_escrow_notification_report(){

    include dirname(__FILE__) . "/admin/notification_report.php";

}

  //This function is used to set notification register setting.
    function aistore_notification_register_setting()
    {
        register_setting('aistore_notification_page', 'created_escrow');
        register_setting('aistore_notification_page', 'partner_created_escrow');
        register_setting('aistore_notification_page', 'accept_escrow');
        register_setting('aistore_notification_page', 'partner_accept_escrow');

        register_setting('aistore_notification_page', 'dispute_escrow');
        register_setting('aistore_notification_page', 'partner_dispute_escrow');
        register_setting('aistore_notification_page', 'release_escrow');
        register_setting('aistore_notification_page', 'partner_release_escrow');

        register_setting('aistore_notification_page', 'cancel_escrow');
        register_setting('aistore_notification_page', 'partner_cancel_escrow');
        register_setting('aistore_notification_page', 'shipping_escrow');
        register_setting('aistore_notification_page', 'partner_shipping_escrow');

        register_setting('aistore_notification_page', 'buyer_deposit');
        register_setting('aistore_notification_page', 'seller_deposit');
        register_setting('aistore_notification_page', 'Buyer_Mark_Paid');
        
        
         register_setting('aistore_notification_page', 'PaymentRefund');
        register_setting('aistore_notification_page', 'PaymentAccepted');
     

    }

}

if (is_admin()) $Notificationmenu = new Notificationmenu();