<?php
add_action('AistoreEscrowCreated', 'aistore_escrow_sendNotificationCreated', 10, 3);
add_action('AistoreEscrowAccepted', 'aistore_escrow_sendNotificationAccepted', 10, 3);
add_action('AistoreEscrowCancelled', 'aistore_escrow_sendNotificationCancelled', 10, 3);
add_action('AistoreEscrowDisputed', 'aistore_escrow_sendNotificationDisputed', 10, 3);
add_action('AistoreEscrowReleased', 'aistore_escrow_sendNotificationReleased', 10, 3);
 
add_action('AistoreEscrowPaymentRefund', 'aistore_escrow_sendNotificationPaymentRefund', 10, 3);


add_action('AistoreEscrowPaymentAccepted', 'aistore_escrow_sendNotificationPaymentAccepted', 10, 3);
 



function aistore_escrow_sendNotificationCreated($escrow) {
  
    $eid = $escrow->id;
  
    
    $details_escrow_page_id_url = $escrow->url;
    
    
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    
    
    $msg = get_option('created_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    
    
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
 
   
    
$email= $user_email;


    $n['email'] = $user_email;
    
    
   
    aistore_notification_new($n);
    $msg = get_option('partner_created_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    
    
    $n['message'] = $msg;
    $n['email'] = $party_email;
    aistore_notification_new($n);
    
    
}

function aistore_escrow_sendNotificationAccepted($escrow) {
   
    $eid = $escrow->id;
   
    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    $msg = get_option('accept_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    
    
    $user_id= get_current_user_id();
$email= get_the_author_meta('user_email', $user_id);


    $n['email'] = $email; 
    aistore_notification_new($n);
    
    
    $msg = get_option('partner_accept_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n['message'] = $msg;
      $n['email'] = aistore_escrow_getpartner($email,$escrow);
    aistore_notification_new($n);
}

function aistore_escrow_sendNotificationCancelled($escrow) {
    
    $eid = $escrow->id;
    
    $details_escrow_page_id_url = $escrow->url;
    
     
    $msg = get_option('cancel_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    
    
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    
    
$user_id= get_current_user_id();
$email= get_the_author_meta('user_email', $user_id);



    $n['email'] = $email;
    aistore_notification_new($n);
    
     
    
    $msg = get_option('partner_cancel_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    
    
    $n['message'] = $msg;
    $n['email'] = aistore_escrow_getpartner($email,$escrow);
    aistore_notification_new($n);
    
    
}

function aistore_escrow_sendNotificationDisputed($escrow) {
   
    $eid = $escrow->id;
    
    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    $msg = get_option('dispute_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    
    
$user_id= get_current_user_id();
$email= get_the_author_meta('user_email', $user_id);



    $n['email'] = $email;
    
    
    aistore_notification_new($n);
    
    
    
    
    
    $msg = get_option('partner_dispute_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n['message'] = $msg;
    
       $n['email'] = aistore_escrow_getpartner($email,$escrow);
       
       
       
    aistore_notification_new($n);
}

function aistore_escrow_sendNotificationReleased($escrow) {
   
    $eid = $escrow->id;
    
    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    $msg = get_option('release_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    
    
$user_id= get_current_user_id();
$email= get_the_author_meta('user_email', $user_id);


    $n['email'] = $email;
    
    
    
    aistore_notification_new($n);
    $msg = get_option('partner_release_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n['message'] = $msg;
     
       $n['email'] = aistore_escrow_getpartner($email,$escrow);
       
    aistore_notification_new($n);
}



function aistore_escrow_sendNotificationPaymentRefund($escrow) {
   
    $eid = $escrow->id;
    
    
    
    $details_escrow_page_id_url = $escrow->url;
     

  
    $msg =  get_option('PaymentRefund'); 
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    
    
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    
    
$user_id= get_current_user_id();
$email= get_the_author_meta('user_email', $user_id);


    $n['email'] = $email;
   
   
    aistore_notification_new($n);


 
    $msg =get_option('PaymentRefund'); 
    
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    
    
    $n['message'] = $msg;
  
        
       $n['email'] = aistore_escrow_getpartner($email,$escrow);
       
       
    aistore_notification_new($n);
    
    
}


function aistore_escrow_sendNotificationPaymentAccepted($escrow) {
    //global $wpdb;
    $eid = $escrow->id;
    //$escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%d ", $eid));
    
    
    $details_escrow_page_id_url = $escrow->url;
    
     
    
 
    $msg = get_option('PaymentAccepted'); 
    
    
    
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    
    
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    
    
$user_id= get_current_user_id();
$email= get_the_author_meta('user_email', $user_id);


    $n['email'] = $email;
   
   
    aistore_notification_new($n);
  
  
    $msg = get_option('PaymentAccepted'); 
    
    
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    
    
    $n['message'] = $msg;
 
 
 
        
       $n['email'] = aistore_escrow_getpartner($email,$escrow);
       
       
       
    aistore_notification_new($n);
    
    
}



function aistore_notification_new($n) {
    
    global $wpdb;
    $q1 = $wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_notification (  message,type, user_email,url ,reference_id) VALUES ( %s, %s, %s, %s, %s ) ", array($n['message'], $n['type'], $n['email'], $n['url'], $n['reference_id']));
    // qr_to_log($q1);
    $wpdb->query($q1);
}
