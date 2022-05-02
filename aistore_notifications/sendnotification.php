<?php


add_action('AistorEscrowCreated', 'sendNotificationCreated', 10, 3);
add_action('AistorEscrowAccepted', 'sendNotificationPaymentAccepted', 10, 3);
add_action('AistorEscrowCancelled', 'sendNotificationCancelled', 10, 3);
add_action('AistorEscrowDisputed', 'sendNotificationDisputed', 10, 3);
add_action('AistorEscrowReleased', 'sendNotificationReleased', 10, 3);


 


 
add_filter( 'after_aistore_escrow_notification', 'aistore_echo_notification_of_escrow' );


 
     
     

  function sendNotificationPaymentRefund($eid){

    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

    global $wpdb;

     

    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));
    
    $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 


    
    include_once dirname(__FILE__) . '/notification.php';

    $sender_email= $escrow->sender_email;

 
    $subject = $Seller_Deposit;

    $n = array();
    $n['message'] = $Seller_Deposit;
     $n['reference_id'] = $eid;
    $n['type'] = "success";
    
    $n['url'] = $details_escrow_page_id_url ;

    $n['user_email'] = $user_email;
    
     $n['subject'] = $subject;
    aistore_notification_new($n);
    
    
      $subject = $Seller_Deposit;

   // $n = array();
    $n['message'] = $Buyer_Deposit;
  //  $n['reference_id'] = $eid;
  //  $n['type'] = "success";
    
   // $n['url'] = $details_escrow_page_id_url ;
     $n['subject'] = $subject;
    $n['user_email'] = $sender_email;
    
    
    aistore_notification_new($n);

  }
  
  
 function sendNotificationPaymentAccepted($eid)
{


    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

    global $wpdb;

     

    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));
    
    $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 


    
    include_once dirname(__FILE__) . '/notification.php';

    $sender_email= $escrow->sender_email;

 
    $subject = $Seller_Deposit;

    $n = array();
    $n['message'] = $Seller_Deposit;
     $n['subject'] = $subject;
    $n['type'] = "success";
      $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url ;

    $n['user_email'] = $user_email;
    
    
    aistore_notification_new($n);
 
    
    
      $subject = $Seller_Deposit;

  //  $n = array();
    $n['message'] = $Buyer_Deposit;
    $n['subject'] = $subject;
  //  $n['type'] = "success";
  //    $n['reference_id'] = $eid;
  //  $n['url'] = $details_escrow_page_id_url ;

    $n['user_email'] = $sender_email;
    
    
    aistore_notification_new($n);
   
 
}


function sendNotificationCreated($request)
{

  $eid= $request['id'] ;

    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

    global $wpdb;

     
// use get escrow function istead of this
    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));
    
    
    
    
    $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 


    
    include_once dirname(__FILE__) . '/notification.php';

    if ($user_email == $escrow->sender_email)
    {

        $party_email = $escrow->receiver_email;

    }
    else
    {
        $party_email = $escrow->sender_email;

    }

    // send email llto party
  

     
    
    $n = array();
      $n['message'] = $partner_created_escrow;

    $n['type'] = "success";
    $n['reference_id'] = $eid;

    $n['url'] = $details_escrow_page_id_url ;
     $n['user_email'] = $party_email; 
    
    aistore_notification_new($n);
   

   

    $message = $created_escrow;
   
 
      
    
    //$n = array();
    $n['message'] = $message;
  //$n['reference_id'] = $eid;
   
   // $n['type'] = "success";
   // $n['url'] = $details_escrow_page_id_url ;
 
    $n['user_email'] = $user_email;
     
    
    aistore_notification_new($n);
    
    
  
 
}





function sendNotificationPaymentDepositSuccess($eid)
{


    $user_email = "";
    global $wpdb;
   
    $q = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%d ", $eid);

    $escrow = $wpdb->get_row($q);

    include_once dirname(__FILE__) . '/notification.php';
 
 
 
    // send email to party
    $message = $Buyer_Deposit;

    $subject = $Buyer_Deposit;

    ob_start();

    include dirname(__FILE__) . "/notification/buyer_admin_accept_payment.php";

    $message = ob_get_clean();



    $n = array();
    $n['message'] = $Buyer_Deposit;
  $n['reference_id'] = $eid;
    $n['type'] = "success";
  $n['subject'] = $subject;
 
	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 



    $n['url'] = $details_escrow_page_id_url ;
    
    
    $n['user_email'] = $escrow->sender_email;
    aistore_notification_new($n);
  
    //send email to seller
    

    // send email to seller
    $subject = $Seller_Deposit;
     $n['subject'] = $subject;
    

    $message = $escrow->sender_email . " has deposited the payment " . $escrow->total_buyer . " into  the escrow for  the transaction   #" . $eid;

    //aistore_notification($message);
    $seller_name = getFullName($escrow->receiver_email);
    $sender_email = $escrow->sender_email;

    $a = $escrow->amount + $escrow->total_fee;

    $deposit_amount = number_format($a) . " " . $escrow->currency_amount; // need to review as total fee to be set here
    

    ob_start();

    include dirname(__FILE__) . "/notification/seller_admin_accept_payment.php";

    $message = ob_get_clean();

  //  $n = array();
    $n['message'] = $Seller_Deposit;
 // $n['reference_id'] = $eid;
  //  $n['type'] = "success";
     $n['subject'] = $subject;


	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 



  //  $n['url'] = $details_escrow_page_id_url ;
    
    
    $n['user_email'] = $escrow->receiver_email;
    aistore_notification_new($n);
   
}

function sendNotificationMarkPaid($eid)
{   



    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);
 

    // ''include_once dirname(__FILE__) . '/email/notification.php';
    

    $n = array();
    $n['message'] = "You have marked escrow #" . $eid . " as payed";
  $n['reference_id'] = $eid;
    $n['type'] = "success";
    $n['subject'] = $subject;
   
	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 



    $n['url'] = $details_escrow_page_id_url ;
  
    $n['user_email'] = $user_email;
    aistore_notification_new($n);

}
function sendNotificationAccepted($eid)
{
    $user_email = "";

    //$attachments = getInvoiceLocation($eid);
    // get invoice attachment
    global $wpdb;
   
    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));
    include_once dirname(__FILE__) . '/notification.php';

    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

    if ($user_email == $escrow->sender_email)
    {

        $party_email = $escrow->receiver_email;

    }
    else
    {
        $party_email = $escrow->sender_email;

    }
    
    
    
    $n = array();
    $n['message'] = $partner_accept_escrow;
      $n['reference_id'] = $eid;
    $n['type'] = "success";
     $n['subject'] = $partner_accept_escrow;
 
	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 



    $n['url'] = $details_escrow_page_id_url ;
    
    
    
    $n['user_email'] = $party_email;
    aistore_notification_new($n);


    $subject = $partner_accept_escrow;

    ob_start();

    include dirname(__FILE__) . "/notification/partner_accept_escrow.php";

    $message = ob_get_clean();

 
 

    //send email to self
    

    ob_start();

    include dirname(__FILE__) . "/notification/self_accept_escrow.php";

    $message = ob_get_clean();

    $subject = "You have successfully accepted the escrow ";

     

    $n = array();
    $n['message'] = $accept_escrow;

    $n['type'] = "success";
  
   $n['subject'] = $subject;
  
	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 


  $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url ;
    
    
    
    $n['user_email'] = $user_email;
    aistore_notification_new($n);

}

function sendNotificationDisputed($eid)
{
   


    $user_email = "";
    $partner_dispute_escrow = "";
    $dispute_escrow = "";
    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

    global $wpdb;
    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));

    include_once dirname(__FILE__) . '/notification.php';

    if ($user_email == $escrow->sender_email)
    {

        $party_email = $escrow->receiver_email;

    }
    else
    {
        $party_email = $escrow->sender_email;

    }

    // send email to party
    $message = "Your partner " . $user_email . " has disputed the escrow #";
    $subject = $partner_dispute_escrow;

    ob_start();

    include dirname(__FILE__) . "/notification/partner_dispute_escrow.php";

    $message = ob_get_clean();

      
    wp_mail($party_email, $subject, $message ,$headers);

    $n = array();
    $n['message'] = $partner_dispute_escrow;

    $n['type'] = "warning";
     $n['subject'] = $subject;

  $n['reference_id'] = $eid;
	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 



    $n['url'] = $details_escrow_page_id_url ;
    
    
    
    $n['user_email'] = $party_email;
    aistore_notification_new($n);
 

    //send email to self
    $message = $dispute_escrow;
    $subject = $dispute_escrow;

    ob_start();

    include dirname(__FILE__) . "/notification/dispute_escrow.php";

    $message = ob_get_clean();

 

    $n = array();
    $n['message'] = $dispute_escrow;
 $n['subject'] = $subject;
    $n['type'] = "success";
  $n['reference_id'] = $eid;


	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 



    $n['url'] = $details_escrow_page_id_url ;
    
    
    
    $n['user_email'] = $user_email;
    aistore_notification_new($n);
 

}

function sendNotificationReleased($eid)
{


    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

  
    global $wpdb;
    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));

    require_once dirname(__FILE__) . '/notification.php';

    if ($user_email == $escrow->sender_email)
    {

        $party_email = $escrow->receiver_email;

    }
    else
    {
        $party_email = $escrow->sender_email;

    }

    // send email to party
    $message = $partner_release_escrow;
    $subject = $partner_release_escrow;

    ob_start();

    include dirname(__FILE__) . "/notification/partner_release_escrow.php";

    $message = ob_get_clean();

    $n = array();
    $n['message'] = $partner_release_escrow;

    $n['type'] = "success";
  $n['reference_id'] = $eid;

 $n['subject'] = $subject;
	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 



    $n['url'] = $details_escrow_page_id_url ;
    
    
    
    
    $n['user_email'] = $party_email;
    
    
    aistore_notification_new($n);


    //send email to self
    $message = $release_escrow;
    $subject = $release_escrow;

    ob_start();

    include dirname(__FILE__) . "/notification/release_escrow.php";

    $message = ob_get_clean();

    $n = array();
    $n['message'] = $release_escrow;
 $n['subject'] = $subject;
    $n['type'] = "success";
   $n['reference_id'] = $eid;
 
 
	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 



    $n['url'] = $details_escrow_page_id_url ;
    
    
    
    $n['user_email'] = $user_email;
    aistore_notification_new($n);

}

function sendNotificationCancelled($eid)
{



    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

    global $wpdb;

    
    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));
   
   
    include_once dirname(__FILE__) . '/notification.php';

    if ($user_email == $escrow->sender_email)
    {

        $party_email = $escrow->receiver_email;

    }
    else
    {
        $party_email = $escrow->sender_email;

    }

    // send email to party
    $message = "Your partner " . $user_email . " has cancelled the escrow " . $eid;
    
    
    
    $subject = $partner_cancel_escrow;

    $n = array();
    $n['message'] = $partner_cancel_escrow;
     $n['subject'] = $subject;
    $n['type'] = "warning";
  $n['reference_id'] = $eid;


	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 



    $n['url'] = $details_escrow_page_id_url ;
    
    
    
    $n['user_email'] = $party_email;
    aistore_notification_new($n);
 

  
       $message = $partner_cancel_escrow;
   


    //send email to self
    $message = "You have successfully cancelled the escrow #" . $eid;
    $subject = $cancel_escrow;

$headers = array('Content-Type: text/html; charset=UTF-8');


    $n = array();
    $n['message'] = $cancel_escrow;
     $n['subject'] = $subject;

    $n['type'] = "success";
  $n['reference_id'] = $eid;


	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 



    $n['url'] = $details_escrow_page_id_url ;
    
    
    $n['user_email'] = $user_email;
    aistore_notification_new($n);

}

function sendNotificationShippingDetailsUpdated($eid)
{

    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

    global $wpdb;

    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));

    include_once dirname(__FILE__) . '/notification.php';

    if ($user_email == $escrow->sender_email)
    {

        $party_email = $escrow->receiver_email;

    }
    else
    {
        $party_email = $escrow->sender_email;

    }

    // send email to party
    $message = "Your partner " . $user_email . " has updated the shipping details for the escrow " . $eid;
    $subject = $partner_shipping_escrow;

    $n = array();
    $n['message'] = $partner_shipping_escrow;
     $n['subject'] = $subject;
    $n['type'] = "success";
  $n['reference_id'] = $eid;


	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 



    $n['url'] = $details_escrow_page_id_url ;
    
    
    
    $n['user_email'] = $party_email;
    aistore_notification_new($n);
    ob_start();

    include dirname(__FILE__) . "/notification/partner_shipping_escrow.php";

    $message = ob_get_clean();

  

    //send email to self
    $message = "You have updated the shipping details for the escrow #" . $eid;
    $subject = $shipping_escrow;

    ob_start();

    include dirname(__FILE__) . "/notification/shipping_escrow.php";
  $message = ob_get_clean();
  

    $n = array();
    $n['message'] = $shipping_escrow;
  $n['reference_id'] = $eid;
    $n['type'] = "success";
    $n['subject'] = $subject;

	 $details_escrow_page_id_url =  esc_url( add_query_arg( array(
    'page_id' => get_option('details_escrow_page_id'),
    'eid' => $eid,
), home_url() ) ); 

    $n['url'] = $details_escrow_page_id_url ;
      $n['user_email'] = $user_email;
    aistore_notification_new($n);

}

