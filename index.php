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


// function find_all_files( $dir=__DIR__ )
// {
//     $root = scandir($dir);
//     foreach($root as $value)
//     {
//         if($value === '.' || $value === '..') {continue;}
//         if(is_file("$dir/$value")) {$result[]="$dir/$value";continue;}
//         foreach(find_all_files("$dir/$value") as $value)
//         {
//             $result[]=$value;
//         }
//     }
//     return $result;
// } 



// echo "<pre>";

// $f=find_all_files();


// foreach($f as $n)
// { 
    
//     echo $n;
 

// preg_match_all('/function (\w+)/', file_get_contents($n), $m);

// // print_r( "<li>".$m[1]."</li>");
// // var_dump($m[1]);
// echo "<ul>";
// foreach($m[1] as $n1)
// { 
//     echo "<li>".$n1."</li>";
// }
//  echo "</ul> ";
// }




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

   wp_enqueue_script( 'bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js', array('jquery'), NULL, true );
   

      
   wp_enqueue_style( 'bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', false, NULL, 'all' );
  
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
    aistore_message();
    global $wpdb;



    $table_escrow_system = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "escrow_system (
  id int(100) NOT NULL AUTO_INCREMENT, 
  title varchar(100)   NOT NULL,
  term_condition text ,
  amount double NOT NULL,
  currency  varchar(100)   NOT NULL,
  url  varchar(100)   NOT NULL,
  receiver_email varchar(100)  NOT NULL,
  sender_email varchar(100)   NOT NULL,
  escrow_fee double NOT NULL,
  status varchar(100)   NOT NULL DEFAULT 'pending',
  payment_status varchar(100)   NOT NULL DEFAULT 'Pending',
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  
  
  PRIMARY KEY (id)
)  ";




   
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');



    dbDelta($table_escrow_system);

    
     update_option('escrow_accept_fee', 5);
     update_option('escrow_create_fee', 5);

      update_option('escrow_fee_deducted', 'accepted');
    

}


    add_action('AistoreEscrow_Install', 'aistore_plugin_table_install' ); 
     
     
     
register_activation_hook(__FILE__, 'aistore_plugin_table_install');


//include_once dirname(__FILE__) . '/AistoreWallet.class.php';

include_once dirname(__FILE__) . '/aistore_escrow/Escrow_list.php';
//include_once dirname(__FILE__) . '/aistore_notifications/user_notification.php';
include_once dirname(__FILE__) . '/aistore_escrow/user_escrow.php';
//include_once dirname(__FILE__) . '/aistore_notifications/sendnotification.php';


// include_once dirname(__FILE__) . '/aistore_chat_system/index.php';
//include_once dirname(__FILE__) . '/aistore_wallet/index.php';
//include_once dirname(__FILE__) . '/aistore_notifications/index.php';
//include_once dirname(__FILE__) . '/aistore_email/index.php';

include_once dirname(__FILE__) . '/aistore_escrow_extensions/index.php';
include_once dirname(__FILE__) . '/aistore_escrow/AistoreEscrowSystem.class.php';

include_once dirname(__FILE__) . '/admin_setting/AistoreEscrowSettings.class.php';

include_once dirname(__FILE__) . '/aistore_escrow/AistoreEscrowSystemAdmin.class.php';


//include_once dirname(__FILE__) . '/aistore_file_upload/file_upload.php';

//include_once dirname(__FILE__) . '/aistore_payment_gateway/index.php';
//include_once dirname(__FILE__) . '/aistore_payment_gateway/crypto_deposit.php';



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

function aistore_message()
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
 $details_escrow_page_id_url =$escrow->url;
    
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
                
               
    $msg  ="<p> For support plz email wordpress@aistore2030.com or susheel2339@gmail.com or +91 8840574997 </p>";
    
    $msg   .="<p>Complete Escrow settings from this link  <a href='".esc_url($url)."'>Escrow Settings</a> </p>";
    
    
             
         
         
         
    return $msg;
    
 
}


 

 
 




