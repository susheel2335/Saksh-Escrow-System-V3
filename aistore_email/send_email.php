<?php
add_action('AistorEscrowCreated', 'sendEmailCreated', 10, 3);
add_action('AistorEscrowAccepted', 'sendEmailAccepted', 10, 3);
add_action('AistorEscrowCancelled', 'sendEmailCancelled', 10, 3);
add_action('AistorEscrowDisputed', 'sendEmailDisputed', 10, 3);
add_action('AistorEscrowReleased', 'sendEmailReleased', 10, 3);


//   why we bring eid why not full escrow
function sendEmailCreated($request)
{
    
     


  global $wpdb;
  $eid= $request['id'] ;
   
 
    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);
 
  
    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%d ", $eid));
    
     



    $details_escrow_page_id_url = esc_url(add_query_arg(array(
        'page_id' => get_option('details_escrow_page_id') ,
        'eid' => $eid,
    ) , home_url()));
    
      

     $party_email = $escrow->receiver_email;
    
 
    
    $subject  =get_option('email_created_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
    
   $msg= get_option('email_body_created_escrow') ;
    
  $msg=  Aistore_process_placeholder_Text($msg, $escrow)    ;
    
    

    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['subject'] = $subject;
    $n['escrow'] = $escrow;
    $n['reference_id'] = $eid;
  $n['url'] = $details_escrow_page_id_url;
    $n['email'] =  $user_email   ;
   
   

    aistore_send_email($n);

  

 
 
    $msg= get_option('email_body_partner_created_escrow') ;
   
    $subject  =get_option('email_partner_created_escrow') ;
    $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    

    
    $n['message'] = $msg;
  
     $n['subject'] = $subject;
  
    $n['email'] = $party_email;

    aistore_send_email($n);

}

function sendEmailAccepted($eid)
{
    
    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

    global $wpdb;
    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));

    $details_escrow_page_id_url = esc_url(add_query_arg(array(
        'page_id' => get_option('details_escrow_page_id') ,
        'eid' => $eid,
    ) , home_url()));

    if ($user_email == $escrow->sender_email)
    {
        $party_email = $escrow->receiver_email;
    }
    else
    {
        $party_email = $escrow->sender_email;
    }


   // send email to party
    
     $subject  =get_option('email_accept_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
    
   $msg= get_option('email_body_accept_escrow') ;
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    
    

    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['subject'] = $subject;
    $n['escrow'] = $escrow;
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    $n['email'] = $party_email;
    //$n['party_email'] = $user_email;

    aistore_send_email($n);

 

 
 
    $msg= get_option('email_body_partner_accept_escrow') ;
   
   
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
       $subject  =get_option('email_partner_accept_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;

  //  $n = array();
    $n['message'] = $msg;
   // $n['reference_id'] = $eid;
   // $n['escrow'] = $escrow;
   // $n['type'] = "success";
   // $n['url'] = $details_escrow_page_id_url;
    $n['subject'] = $subject;
    $n['email'] = $party_email;
    //$n['party_email'] = $party_email;

    aistore_send_email($n);

}

function sendEmailCancelled($eid)
{
  
    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

    global $wpdb;
    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));

    $details_escrow_page_id_url = esc_url(add_query_arg(array(
        'page_id' => get_option('details_escrow_page_id') ,
        'eid' => $eid,
    ) , home_url()));

    if ($user_email == $escrow->sender_email)
    {
        $party_email = $escrow->receiver_email;
    }
    else
    {
        $party_email = $escrow->sender_email;
    }


    // send email to party
    
     $subject  =get_option('email_cancel_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
    
   $msg= get_option('email_body_cancel_escrow') ;
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    
    

    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['subject'] = $subject;
    $n['escrow'] = $escrow;
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    $n['email'] = $party_email;
    $n['party_email'] = $user_email;

    aistore_send_email($n);

 

 
 
    $msg= get_option('email_body_partner_cancel_escrow') ;
   
   
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
       $subject  =get_option('email_partner_cancel_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;

  //  $n = array();
    $n['message'] = $msg;
   // $n['reference_id'] = $eid;
  //  $n['escrow'] = $escrow;
  //  $n['type'] = "success";
  //  $n['url'] = $details_escrow_page_id_url;
    $n['subject'] = $subject;
    $n['email'] = $party_email;
  //  $n['party_email'] = $party_email;

    aistore_send_email($n);
}

function sendEmailDisputed($eid)
{
    
    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

    global $wpdb;
    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));

    $details_escrow_page_id_url = esc_url(add_query_arg(array(
        'page_id' => get_option('details_escrow_page_id') ,
        'eid' => $eid,
    ) , home_url()));

    if ($user_email == $escrow->sender_email)
    {
        $party_email = $escrow->receiver_email;
    }
    else
    {
        $party_email = $escrow->sender_email;
    }

    // send email to party
    
     $subject  =get_option('email_dispute_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
    
   $msg= get_option('email_body_dispute_escrow') ;
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    
    

    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['subject'] = $subject;
    $n['escrow'] = $escrow;
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    $n['email'] = $party_email;
    $n['party_email'] = $user_email;

    aistore_send_email($n);

 

 
 
    $msg= get_option('email_body_partner_dispute_escrow') ;
   
   
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
       $subject  =get_option('email_partner_dispute_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;

  //  $n = array();
    $n['message'] = $msg;
  //  $n['reference_id'] = $eid;
  //  $n['escrow'] = $escrow;
  //  $n['type'] = "success";
  //  $n['url'] = $details_escrow_page_id_url;
    $n['subject'] = $subject;
    $n['email'] = $party_email;
  //  $n['party_email'] = $party_email;

    aistore_send_email($n);

}

function sendEmailReleased($eid)
{

   
    $user_id = get_current_user_id();
    $user_email = get_the_author_meta('user_email', $user_id);

    global $wpdb;
    $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%s ", $eid));

    $details_escrow_page_id_url = esc_url(add_query_arg(array(
        'page_id' => get_option('details_escrow_page_id') ,
        'eid' => $eid,
    ) , home_url()));

    if ($user_email == $escrow->sender_email)
    {
        $party_email = $escrow->receiver_email;
    }
    else
    {
        $party_email = $escrow->sender_email;
    }

     // send email to party
    
     $subject  =get_option('email_release_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
   $msg= get_option('email_body_release_escrow') ;
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    
    

    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['subject'] = $subject;
    $n['escrow'] = $escrow;
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    $n['email'] = $party_email;
    $n['party_email'] = $user_email;

    aistore_send_email($n);

    ob_start();

 
 
    $msg= get_option('email_body_partner_release_escrow') ;
   
   
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    
   $subject  =get_option('email_partner_release_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
   // $n = array();
    $n['message'] = $msg;
  //  $n['reference_id'] = $eid;
  //  $n['escrow'] = $escrow;
  //  $n['type'] = "success";
  //  $n['url'] = $details_escrow_page_id_url;
    $n['subject'] = $subject;
    $n['email'] = $user_email;
 

    aistore_send_email($n);
}

function aistore_send_email($n)
{

    if (!is_user_logged_in())
    {
        return "";
    }

    global $wpdb;
    
     $headers = array(
        'Content-Type: text/html; charset=UTF-8'
    );
    
    
      ob_start();
        include dirname(__FILE__) . "/email_template.php";
    $message = ob_get_clean();
   
   
    $body = str_replace("[message]",$n['message'], $message);
    
    
    
    
    
       wp_mail($n['email'],  $n['subject'], $body, $headers);

    $q1 = $wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_email (message,type, user_email,url ,reference_id,subject) VALUES ( %s, %s, %s, %s, %s ,%s) ", array(
       $n['message'],
        $n['type'],
        $n['email'],
        $n['url'],
        $n['reference_id'],
        $n['subject']
    ));

    // qr_to_log($q1);
    

    $wpdb->query($q1);

}

?>
