<?php
 


add_action('AistoreEscrowCreated', 'sendEmailCreated', 10, 3);
add_action('AistoreEscrowAccepted', 'sendEmailAccepted', 10, 3);
add_action('AistoreEscrowCancelled', 'sendEmailCancelled', 10, 3);
add_action('AistoreEscrowDisputed', 'sendEmailDisputed', 10, 3);
add_action('AistoreEscrowReleased', 'sendEmailReleased', 10, 3);
add_action('AistoreEscrowPaymentAccepted', 'sendEmailPaymentAccepted', 10, 3);


      /**
       * This function is used to created escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */
 
 
function sendEmailCreated($escrow )
{
    
     
     
    
    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
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
    $n['reference_id'] = $escrow->id;
  $n['url'] = $details_escrow_page_id_url;
    $n['email'] =  $user_email   ;
     $n['party_email'] = $party_email;
   
   

    aistore_send_email($n);

  

 
 
    $msg= get_option('email_body_partner_created_escrow') ;
   
    $subject  =get_option('email_partner_created_escrow') ;
    $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    

    
    $n['message'] = $msg;
  
     $n['subject'] = $subject;
  
    $n['email'] = $party_email;
     $n['party_email'] = $user_email;

    aistore_send_email($n);

}

    /**
       * This function is used to accept escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */
function sendEmailAccepted($escrow)
{
    
   
   
    
    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;



    
    
     $subject  =get_option('email_accept_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
    
   $msg= get_option('email_body_accept_escrow') ;
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    
    

    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['subject'] = $subject;
    $n['escrow'] = $escrow;
    $n['reference_id'] =  $escrow->id;
    $n['url'] = $details_escrow_page_id_url;
    $n['email'] = $party_email;
    $n['party_email'] = $user_email;

    aistore_send_email($n);

 

 
 
    $msg= get_option('email_body_partner_accept_escrow') ;
   
   
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
       $subject  =get_option('email_partner_accept_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;

    $n['message'] = $msg;
    $n['subject'] = $subject;
    $n['email'] = $user_email;
    $n['party_email'] = $party_email;

    aistore_send_email($n);

}


    /**
       * This function is used to cancel escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */
function sendEmailCancelled($escrow)
{
  
  
  
    
    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;


 


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
    $n['reference_id'] = $escrow->id;
    $n['url'] = $details_escrow_page_id_url;
    $n['email'] = $user_email;
    $n['party_email'] = $party_email;

    aistore_send_email($n);

 

 
 
    $msg= get_option('email_body_partner_cancel_escrow') ;
   
   
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
       $subject  =get_option('email_partner_cancel_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;

    $n['message'] = $msg;
    $n['subject'] = $subject;
    $n['email'] = aistore_escrow_getpartner($party_email,$escrow);  ;//$party_email;
    $n['party_email'] = $user_email;

    aistore_send_email($n);
}


    /**
       * This function is used to dispute escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */
function sendEmailDisputed($escrow)
{
  
  
    
    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    
    

    
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
    $n['reference_id'] = $escrow->id;
    $n['url'] = $details_escrow_page_id_url;
    
    
    
$user_id= get_current_user_id();
$email= get_the_author_meta('user_email', $user_id);


    $n['email'] = $email;
    
    $n['party_email'] = $party_email;

    aistore_send_email($n);

 

 
 
    $msg= get_option('email_body_partner_dispute_escrow') ;
   
   
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
       $subject  =get_option('email_partner_dispute_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;

    $n['message'] = $msg;
    $n['subject'] = $subject;
    //$n['email'] = $party_email;
        $n['email'] = aistore_escrow_getpartner($party_email,$escrow);
        
     $n['party_email'] = $user_email;

    aistore_send_email($n);

}


    /**
       * This function is used to release escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */
function sendEmailReleased($escrow)
{

   
   
    
    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    
    
    
     // send email to party
    
     $subject  =get_option('email_release_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
   $msg= get_option('email_body_release_escrow') ;
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    
    
$user_id= get_current_user_id();
$email= get_the_author_meta('user_email', $user_id);

    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['subject'] = $subject;
    $n['escrow'] = $escrow;
    $n['reference_id'] = $escrow->id;
    $n['url'] = $details_escrow_page_id_url;
    $n['email'] = $email;
    $n['party_email'] = $party_email;

    aistore_send_email($n);

    ob_start();

 
 
    $msg= get_option('email_body_partner_release_escrow') ;
   
   
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    
   $subject  =get_option('email_partner_release_escrow') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
    $n['message'] = $msg;
    $n['subject'] = $subject;
 //   $n['email'] = $party_email;
    
         $n['email'] = aistore_escrow_getpartner($party_email,$escrow);
        
        
    $n['party_email'] = $user_email;
 

    aistore_send_email($n);
}


    /**
       * This function is used to payment accepted escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */
function sendEmailPaymentAccepted($escrow){
    
    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    
    
    
     // send email to party
    
     $subject  =get_option('email_buyer_deposit') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;
     $msg= get_option('email_body_buyer_deposit') ;
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    
    

    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['subject'] = $subject;
    $n['escrow'] = $escrow;
    $n['reference_id'] = $escrow->id;
    $n['url'] = $details_escrow_page_id_url;
    $n['email'] = $user_email;
    $n['party_email'] = $party_email;

    aistore_send_email($n);

    ob_start();

 
 
    $msg= get_option('email_body_seller_deposit') ;
   
   
    
    $msg= Aistore_process_placeholder_Text($msg, $escrow)    ;
    
   $subject  =get_option('email_seller_deposit') ;
     $subject= Aistore_process_placeholder_Text($subject, $escrow)    ;

    $n['message'] = $msg;
    $n['subject'] = $subject;
    $n['email'] = $party_email;
    $n['party_email'] = $user_email;
 

    aistore_send_email($n);
}


    /**
       * This function is used to send an email
       * @param string message
       * @param string type
       * @param string user_email
       * @param string party_email
       * @param string url
       * @param string reference_id
       * @param string subject
       
      */
function aistore_send_email($n)
{
 
    global $wpdb;
    
     $headers = array(
        'Content-Type: text/html; charset=UTF-8'
    );
    
    
      ob_start();
        include dirname(__FILE__) . "/email_template.php";
    $message = ob_get_clean();
   
   
    $body = str_replace("[message]",$n['message'], $message);
    
    
    
    
    
       wp_mail($n['email'],  $n['subject'], $body, $headers);

    $q1 = $wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_email (message,type, user_email,party_email,url ,reference_id,subject) VALUES ( %s, %s, %s,%s, %s, %s ,%s) ", array(
       $n['message'],
        $n['type'],
        $n['email'],
        $n['party_email'],
        $n['url'],
        $n['reference_id'],
        $n['subject']
        
    ));

    // qr_to_log($q1);
    

    $wpdb->query($q1);

}


