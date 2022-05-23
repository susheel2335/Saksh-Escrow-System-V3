<?php
class AistoreEscrowSettings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', array(
            $this,
            'aistore_add_plugin_page'
        ));
        add_action('admin_init', array(
            $this,
            'aistore_page_register_setting'
        ));
      
        
        
        
         add_action('admin_init', array(
            $this,
            'aistore_message_register_setting'
        ));
        
        
 
     
    }

    /**
     * Add options page
     */
    public function aistore_add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page('Settings Admin', __('Escrow Setting', 'aistore') , 'administrator', 'Escrow-setting-admin', array(
            $this,
            'aistore_page_setting'
        ));

        add_menu_page(__('Escrow System', 'aistore') , __('Escrow System', 'aistore') , 'administrator', 'aistore_escrow_dashboard');



     add_submenu_page('aistore_escrow_dashboard', __('Dashboard', 'aistore') , __('Dashboard', 'aistore') , 'administrator', 'aistore_escrow_dashboard', array(
            $this,
            'aistore_escrow_dashboard'
        ));
        
        add_submenu_page('aistore_escrow_dashboard', __('Escrow List', 'aistore') , __('Escrow List', 'aistore') , 'administrator', 'aistore_user_escrow_list', array(
            $this,
            'aistore_user_escrow_list'
        ));

        add_submenu_page('aistore_escrow_dashboard', __('Disputed Escrow List', 'aistore') , __('Disputed Escrow', 'aistore') , 'administrator', 'disputed_escrow_list', array(
            $this,
            'aistore_disputed_escrow_list'
        ));

        add_submenu_page('aistore_escrow_dashboard', __('Disputed Escrow Details', 'aistore') , __('', 'aistore') , 'administrator', 'disputed_escrow_details', array(
            $this,
            'aistore_disputed_escrow_details'
        ));

     
      
        add_submenu_page('aistore_escrow_dashboard', __('Escrow Message Setting', 'aistore') , __('Escrow Message Setting', 'aistore') , 'administrator', 'message_setting', array(
            $this,
            'aistore_message_setting'
        ));
        
       
        
           add_submenu_page('aistore_escrow_dashboard', __('Escrow Setting', 'aistore') , __('Escrow Setting', 'aistore') , 'administrator', 'aistore_page_escrow_setting', array(
            $this,
            'aistore_page_setting'
        ));

  

    }
    
   
    
        // This function is used to admin dashboard and show all escrow list
    function aistore_escrow_dashboard(){
 include_once dirname(__FILE__) . '../../admin_setting/aistore_escrow_dashboard.php';
              }
    
    
        // This function is used to  messages set to the wallet (debit/credit) payment transaction message details for the escrow with escrow id
    function aistore_message_setting(){
        
 include_once dirname(__FILE__) . '../../admin_setting/escrow_message_setting.php';
    }

    // This function is used to show all user escrow list
    function aistore_user_escrow_list()
    {
     include_once dirname(__FILE__) . '../../admin_setting/aistore_user_escrow_list.php';

    }
    
    // This function is used to show disputed escrow details page.
    function aistore_disputed_escrow_details()
    {
     include_once dirname(__FILE__) . '../../admin_setting/aistore_disputed_escrow_details.php';
    }

 // This function is used to show all user disputed escrow list
    function aistore_disputed_escrow_list()
    {
      include_once dirname(__FILE__) . '../../admin_setting/aistore_disputed_escrow_list.php';
    }
    
    
        // This function is used to add page setting 
    function aistore_page_setting()
    {
    include_once dirname(__FILE__) . '../../admin_setting/page_setting.php';
    }

 
        
    // page Setting
    function aistore_page_register_setting()
    {
        //register our settings
        register_setting('aistore_page', 'add_escrow_page_id');
        register_setting('aistore_page', 'list_escrow_page_id');
        register_setting('aistore_page', 'details_escrow_page_id');
        register_setting('aistore_page', 'bank_details_page_id');
        register_setting('aistore_page', 'notification_page_id');
         register_setting('aistore_page', 'aistore_transaction_history_page_id');
        register_setting('aistore_page', 'aistore_saksh_withdrawal_system');
        register_setting('aistore_page', 'aistore_bank_account');
        register_setting('aistore_page', 'escrow_file_type');
         register_setting('aistore_page', 'withdraw_fee');

        register_setting('aistore_page', 'escrow_user_id');
        register_setting('aistore_page', 'escrow_create_fee');
        register_setting('aistore_page', 'escrow_accept_fee');
        register_setting('aistore_page', 'escrow_message_page');
        register_setting('aistore_page', 'cancel_escrow_fee');
        register_setting('aistore_page', 'escrow_fee_deducted');
        
        register_setting('aistore_page', 'wallet_system');
        register_setting('aistore_page', 'chat_system');
        register_setting('aistore_page', 'file_upload_system');
        register_setting('aistore_page', 'notification_system');
        register_setting('aistore_page', 'email_system');
        register_setting('aistore_page', 'currency_convert_system');
        register_setting('aistore_page', 'payment_gateway_system');
        register_setting('aistore_page', 'bank_payment_system');
        register_setting('aistore_page', 'withdraw_system');
        
        
        
        
        register_setting('aistore_page', 'bank_details');
        register_setting('aistore_page', 'deposit_instructions');
        
    }



    
    //   This function is used to set message register setting.
    function aistore_message_register_setting()
    {
        register_setting('aistore_message_page', 'created_escrow_message');
     
        register_setting('aistore_message_page', 'accept_escrow_message');

        register_setting('aistore_message_page', 'dispute_escrow_message');
        register_setting('aistore_message_page', 'release_escrow_message');

        register_setting('aistore_message_page', 'cancel_escrow_message');
        
         register_setting('aistore_message_page', 'created_escrow_success_message');
         register_setting('aistore_message_page', 'accept_escrow_success_message');
         register_setting('aistore_message_page', 'dispute_escrow_success_message');
         register_setting('aistore_message_page', 'release_escrow_success_message');
         register_setting('aistore_message_page', 'cancel_escrow_success_message');
        
      
    }
    

 
  
  
        
}

if (is_admin()) $AistoreEscrowSettings = new AistoreEscrowSettings();

