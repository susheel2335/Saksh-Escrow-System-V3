<?php
class Emailmenu{
    
    
  private $options;


  public function __construct()
    {
        
           add_action('admin_menu', array(
            $this,
            'aistore_email_register_menu_page'
        ));
      
      
       add_action('admin_init', array(
            $this,
            'aistore_email_register_setting'
        ));
        
    }



  

function aistore_email_register_menu_page() {
    
   add_options_page('Email Setting', __('Email Setting', 'aistore') , 'administrator', 'Email-setting-admin', array(
            $this,
            'aistore_email_setting'
        ));
        
          
          add_menu_page(__('Email', 'aistore') , __('Email', 'aistore') , 'administrator', 'aistore_email_setting');
          
          
        add_submenu_page('aistore_email_setting', __('Email Setting', 'aistore') , __('Setting', 'aistore') , 'administrator', 'aistore_email_setting', array(
            $this,
            'aistore_email_setting'
        ));


     add_submenu_page('aistore_email_setting', __('Report', 'aistore') , __('Report', 'aistore') , 'administrator', 'aistore_all_email_report', array(
            $this,
            'aistore_all_email_report'
        ));

    
}

function aistore_email_setting(){

    include dirname(__FILE__) . "/admin/email_setting.php";

}
function aistore_all_email_report(){

    include dirname(__FILE__) . "/admin/all_email_report.php";

}



//   This function is used to set email register setting.
    function aistore_email_register_setting()
    {
        register_setting('aistore_email_page', 'email_created_escrow');
        register_setting('aistore_email_page', 'email_partner_created_escrow');
        register_setting('aistore_email_page', 'email_accept_escrow');
        register_setting('aistore_email_page', 'email_partner_accept_escrow');

        register_setting('aistore_email_page', 'email_dispute_escrow');
        register_setting('aistore_email_page', 'email_partner_dispute_escrow');
        register_setting('aistore_email_page', 'email_release_escrow');
        register_setting('aistore_email_page', 'email_partner_release_escrow');

        register_setting('aistore_email_page', 'email_cancel_escrow');
        register_setting('aistore_email_page', 'email_partner_cancel_escrow');
        register_setting('aistore_email_page', 'email_shipping_escrow');
        register_setting('aistore_email_page', 'email_partner_shipping_escrow');

        register_setting('aistore_email_page', 'email_buyer_deposit');
        register_setting('aistore_email_page', 'email_seller_deposit');
        register_setting('aistore_email_page', 'email_Buyer_Mark_Paid');
        
        
        
         register_setting('aistore_email_page', 'email_body_created_escrow');
        register_setting('aistore_email_page', 'email_body_partner_created_escrow');
        register_setting('aistore_email_page', 'email_body_accept_escrow');
        register_setting('aistore_email_page', 'email_body_partner_accept_escrow');

        register_setting('aistore_email_page', 'email_body_dispute_escrow');
        register_setting('aistore_email_page', 'email_body_partner_dispute_escrow');
        register_setting('aistore_email_page', 'email_body_release_escrow');
        register_setting('aistore_email_page', 'email_body_partner_release_escrow');

        register_setting('aistore_email_page', 'email_body_cancel_escrow');
        register_setting('aistore_email_page', 'email_body_partner_cancel_escrow');
        register_setting('aistore_email_page', 'email_body_shipping_escrow');
        register_setting('aistore_email_page', 'email_body_partner_shipping_escrow');

        register_setting('aistore_email_page', 'email_body_buyer_deposit');
        register_setting('aistore_email_page', 'email_body_seller_deposit');
        register_setting('aistore_email_page', 'email_body_Buyer_Mark_Paid');
    }
    

}
if (is_admin()) $Emailmenu = new Emailmenu();