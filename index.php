<?php
/*
Plugin Name: Saksh Escrow System
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

add_action('init', 'aistore_wpdocs_load_textdomain');

function aistore_wpdocs_load_textdomain()
{
    load_plugin_textdomain('aistore', false, basename(dirname(__FILE__)) . '/languages/');
}

function aistore_scripts_method()
{

  
  
    wp_enqueue_style('aistore', plugins_url('/aistore_assets/css/custom.css', __FILE__) , array());
    wp_enqueue_script('aistore', plugins_url('/aistore_assets/js/custom.js', __FILE__) , array(
        'jquery'
    ));
}

add_action('wp_enqueue_scripts', 'aistore_scripts_method');


add_action('admin_head', 'saksh_escrow_system_css');

function saksh_escrow_system_css() {  


 wp_enqueue_style( 'saksh_escrow_system', plugin_dir_url( __FILE__ ) . 'css/custom.css' );
 
 
  
}



function aistore_isadmin()
{

    $user = wp_get_current_user();
    $allowed_roles = array(
        'administrator'
    );
    if (array_intersect($allowed_roles, $user->roles))
    {
        return true;
    }
    else
    {

        return false;

    }
}

function aistore_plugin_table_install()
{
    global $wpdb;

    $table_escrow_discussion = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "escrow_discussion  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  eid int(100) NOT NULL,
   message  text  NOT NULL,
   user_login  varchar(100)   NOT NULL,
  status  varchar(100)   NOT NULL,
  ipaddress varchar(100)   NOT NULL,
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

    $table_escrow_documents = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "escrow_documents (
  id int(100) NOT NULL  AUTO_INCREMENT,
  eid  int(100) NOT NULL,
  documents  varchar(100)  NOT NULL,
   ipaddress varchar(100)   NOT NULL,
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
   user_id  int(100) NOT NULL,
  documents_name  varchar(100)  DEFAULT NULL,
  PRIMARY KEY (id)
)  ";

    $table_escrow_system = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "escrow_system (
  id int(100) NOT NULL AUTO_INCREMENT, 
  title varchar(100)   NOT NULL,
  term_condition text ,
  amount double NOT NULL,
  currency  varchar(100)   NOT NULL,
  receiver_email varchar(100)  NOT NULL,
  sender_email varchar(100)   NOT NULL,
  escrow_fee double NOT NULL,
  status varchar(100)   NOT NULL DEFAULT 'pending',
  payment_status varchar(100)   NOT NULL DEFAULT 'Pending',
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  
  
  PRIMARY KEY (id)
)  ";



  $table_aistore_wallet_transactions = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "aistore_wallet_transactions  (
   	transaction_id  bigint(20)  NOT NULL  AUTO_INCREMENT,
  user_id bigint(20)  NOT NULL,
   reference bigint(20)   NULL,
   type   varchar(100)  NOT NULL,
   amount  double    NOT NULL,
  balance  double    NOT NULL,
    description  text  NOT NULL,
   currency  varchar(100)   NOT NULL,
   created_by  	bigint(20) NOT NULL,
   date  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (transaction_id)
) ";

    $table_aistore_wallet_balance = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "aistore_wallet_balance  (
     	id  bigint(20)  NOT NULL  AUTO_INCREMENT,
   	transaction_id  bigint(20)  NOT NULL,
  user_id bigint(20)  NOT NULL,
  balance  double    NOT NULL,
   currency  varchar(100)   NOT NULL,
   created_by  	bigint(20) NOT NULL,
   date  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

  
    $table_withdrawal_requests = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "widthdrawal_requests  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  amount double NOT NULL,
 
   method  varchar(100)   NOT NULL,   charges  varchar(100)   NOT NULL,
   username  varchar(100)   NOT NULL,
   currency  varchar(100)   NOT NULL,
  status  varchar(100)   NOT NULL DEFAULT 'pending',
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

  $table_escrow_currency = "CREATE TABLE  IF NOT EXISTS  " . $wpdb->prefix . "escrow_currency  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  currency varchar(100) NOT NULL,
   symbol  varchar(100)   NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";
   
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($table_escrow_discussion);

    dbDelta($table_escrow_system);

    dbDelta($table_escrow_documents);


    
    dbDelta($table_escrow_email);
    
    
      dbDelta($table_aistore_wallet_transactions);

    dbDelta($table_aistore_wallet_balance);
    
    dbDelta($table_withdrawal_requests);
    
    dbDelta($table_escrow_currency);




    email_notification_message();
    
    
    
    
     update_option('escrow_accept_fee', 5);
     update_option('escrow_create_fee', 5);
     update_option('withdraw_fee', 5);
      update_option('escrow_fee_deducted', 'accepted');
    

}
register_activation_hook(__FILE__, 'aistore_plugin_table_install');



include_once dirname(__FILE__) . '/aistore_escrow/Escrow_list.php';
include_once dirname(__FILE__) . '/aistore_notifications/user_notification.php';
include_once dirname(__FILE__) . '/aistore_escrow/user_escrow.php';
include_once dirname(__FILE__) . '/aistore_notifications/sendnotification.php';


include_once dirname(__FILE__) . '/aistore_chat_system/index.php';
include_once dirname(__FILE__) . '/aistore_wallet/index.php';
include_once dirname(__FILE__) . '/aistore_notifications/index.php';
include_once dirname(__FILE__) . '/aistore_email/index.php';

include_once dirname(__FILE__) . '/aistore_notifications/notification_api.php';
include_once dirname(__FILE__) . '/aistore_escrow/AistoreEscrowSystem.class.php';

include_once dirname(__FILE__) . '/aistore_escrow/AistoreEscrowSettings.class.php';


include_once dirname(__FILE__) . '/aistore_file_upload/file_upload.php';



add_shortcode('aistore_escrow_system', 'aistore_escrow_system');

add_shortcode('aistore_escrow_list',  'aistore_escrow_list');

add_shortcode('aistore_escrow_detail', 'aistore_escrow_detail');

add_shortcode('aistore_bank_details',  'aistore_bank_details');

 
function aistore_escrow_list()
{
      if (!is_user_logged_in())
        {
            return "<div class='loginerror'>Kindly login and then visit this page</div>";
        }
        
        
   $cl=new AistoreEscrowSystem();
   
return    $cl->aistore_escrow_list();
   
} 
function aistore_bank_details()
{
      if (!is_user_logged_in())
        {
            return "<div class='loginerror'>Kindly login and then visit this page</div>";
        }
        
   $cl=new AistoreEscrowSystem();
   
return    $cl->aistore_bank_details();
   
}


function aistore_escrow_detail()
{
      if (!is_user_logged_in())
        {
            return "<div class='loginerror'>Kindly login and then visit this page</div>";
        }
        
   $cl=new AistoreEscrowSystem();
   
return    $cl->aistore_escrow_detail();
   
}
function aistore_escrow_system()
{
      if (!is_user_logged_in())
        {
            return "<div class='loginerror'>Kindly login and then visit this page</div>";
        }
        
   $cl=new AistoreEscrowSystem();
   
return    $cl->aistore_escrow_system();
   
}

function email_notification_message()
{
    
    //messages
     update_option('created_escrow_message', 'Payment transaction for the created escrow with escrow id  # [EID]');
    
    update_option('created_escrow_success_message', 'Created Successfully escrow id  # [EID]');
    
    
    update_option('accept_escrow_message', 'Payment transaction for the accepted escrow with escrow id  # [EID]');
    
    update_option('accept_escrow_success_message', 'Accepted Successfully escrow id  # [EID]');

    update_option('dispute_escrow_message', 'Payment transaction for the disputed escrow with escrow id  # [EID]');

    update_option('dispute_escrow_success_message', 'Disputed Successfully escrow id  # [EID]');
    
    update_option('release_escrow_message', 'Payment transaction for the released escrow with escrow id  # [EID]');
    
    
    update_option('release_escrow_success_message', 'Released Successfully escrow id  # [EID]');

 update_option('cancel_escrow_message', 'Payment transaction for the cancelled escrow with escrow id  # [EID]');
 
 
    update_option('cancel_escrow_success_message', 'Cancelled Successfully escrow id  # [EID]');
    
  
  

}
function Aistore_process_placeholder_EID($str, $eid)
{
  
 
 
    
    $str = str_replace("[EID]", $eid, $str);
     
    return ($str);
}



function Aistore_process_placeholder_Text($str, $escrow)
{
 $details_escrow_page_id_url = esc_url(add_query_arg(array(
        'page_id' => get_option('details_escrow_page_id') ,
        'eid' => $escrow->id,
    ) , home_url()));
    
    $date = $escrow->created_at;
date_default_timezone_set('America/Los_Angeles');
$datetime= date('l F j Y g:i:s A I', strtotime($date));
    
 
$html ='<h1>Escrow Details </h1><br>
    <table><tr><td>Escrow Id :</td><td>'.$escrow->id.'</td></tr>
      <tr><td>Title :</td><td>'.$escrow->title.'</td></tr>
    <tr><td>Amount :</td><td>'.$escrow->amount.' '.$escrow->currency.'</td></tr>
      <tr><td>Escrow Fee :</td><td>'.$escrow->escrow_fee.'</td></tr>
          <tr><td>Sender :</td><td>'.$escrow->sender_email.'</td></tr>
              <tr><td>Receiver :</td><td>'.$escrow->receiver_email.'</td></tr>
               <tr><td>Status :</td><td>'.$escrow->status.'</td></tr>
        <tr><td>Date :</td><td>'.$datetime.'</td></tr></table><br>';
        
            $html.='<h1>Sender Details </h1><br>
    <table><tr><td>Email :</td><td>'.$escrow->sender_email.'</td></tr>
      <tr><td>Name :</td><td>'.$escrow->sender_email.'</td></tr>
   </table><br>';
        
        
        $html.='<h1>Receiver Details </h1><br>
    <table><tr><td>Email :</td><td>'.$escrow->receiver_email.'</td></tr>
      <tr><td>Name :</td><td>'.$escrow->receiver_email.'</td></tr></table><br>
    ';
    
     $html.='Escrow Details Page to <a href='.$details_escrow_page_id_url.'> Click here</a><br><br>
    ';
    
    $str = str_replace("[EID]", $escrow->id, $str);
      $str = str_replace("[ESCROWDATA]", $html, $str);
    return ($str);
}



function  AistoregetSupportMsg()

{
    $url = admin_url('admin.php?page=aistore_page_escrow_setting', 'https');
                
               
    $msg  ="<p> For support plz email wordpress@aistore2030.com </p>";
    
    $msg   .="<p>Complete Escrow settings from this link  <a href='".esc_url($url)."'>Escrow Settings</a> </p>";
    
    
             
         
         
         
    return $msg;
    
 
}


 

 
 




