<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}

class AistoreEscrow
{
  
    // get escrow feecccc
    public function get_escrow_admin_user_id()
    {
        $escrow_admin_user_id = get_option('escrow_user_id');
        return $escrow_admin_user_id;

    }

    public function get_escrow_currency()
    {
        $aistore_escrow_currency = get_option('aistore_escrow_currency');
        return $aistore_escrow_currency;

    }

    public function create_escrow_fee($amount)
    {

        $escrow_create_fee = get_option('escrow_create_fee');

        $escrow_fee = ($escrow_create_fee / 100) * $amount;
        return $escrow_fee;

    }

    public function accept_escrow_fee($amount)
    {

        $escrow_accept_fee = get_option('escrow_accept_fee');

        $escrow_fee = ($escrow_accept_fee / 100) * $amount;
        return $escrow_fee;
    }




  
  function create_escrow($request)
  {
       
              global $wpdb;    

    
            

            $title = sanitize_text_field($request['title']);
            $amount = sanitize_text_field($request['amount']);

            $receiver_email = sanitize_email($request['receiver_email']);

            $term_condition = sanitize_textarea_field(htmlentities($request['term_condition']));

            $escrow_currency = sanitize_text_field($request['aistore_escrow_currency']);

          

            $sender_email = $request['user_email'];
            
       
         
            
            // add currency also   
         $qr=$wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_system ( title, amount, receiver_email,sender_email,term_condition  ,currency ) VALUES ( %s, %s, %s, %s ,%s , %s)", array(
                $title,
                $amount,
                $receiver_email,
                $sender_email,
                $term_condition,
                
                $escrow_currency
            ));
            
         
         
            
               $wpdb->query($qr);
            
    
 


            $eid = $wpdb->insert_id;
            
            
               $details_escrow_page_id_url = esc_url(add_query_arg(array('page_id' => get_option('details_escrow_page_id'), 'eid' => $eid,), home_url()));
               
                  $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET url = '%s'  WHERE id = '%d'", $details_escrow_page_id_url, $eid));
    
            $request['id'] =$eid;
            $request['currency'] =$escrow_currency;
            $request['sender_email'] = $sender_email ;
           
 
        //  $escrow=  (object)  $data ;

            
 $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE id=%s ", $eid));
      
    //   print_r($escrow);
      //       apply_filters( "AistorEscrowCreated" ,$escrow);
                
           do_action( 'AistorEscrowCreated',   $request);
          
        do_action( 'Aistore_Escrow_Created',   $escrow);
          
        return  $request;   

          
        return  $request;   

          
            
            
  }
  
  
  
  
    // Escrow List
    public   function AistoreEscrowList($emailId)
    {
      
 
        global $wpdb;

        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE receiver_email=%s or sender_email=%s order by id desc ", $emailId, $emailId));

                
	return      $results;
	
	
	
	
	 

    }
    
    
    public   function AistoreEscrowDetail($eid,$email)
    {
      
  
global $wpdb;
        
        
        
     $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system where id=%d and ( receiver_email=%s or sender_email=%s ) ", $eid,$email,$email));
     
  return $escrow;
  
  
    }
    
  
  function CancelEscrow____ReviewNeeded($escrow,$email_id)
    {
       
 if (cancel_escrow_btn_visible($escrow ,$email_id )  ) 
            
            { 
                
global $wpdb;
        
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = 'cancelled'  WHERE (  receiver_email = %s   or  sender_email = %s    )  and  id =  %d ", $email_id, $email_id, $eid));

           
                
  }             
  }
  
   function ReleaseEscrow____ReviewNeeded($escrow,$email_id)
    {
         
           
            if (accept_escrow_btn_visible($escrow ,$email_id )  ) 
            
            { 

global $wpdb;
        
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = 'released'  WHERE  payment_status='paid' and  sender_email =%s and id = %d ", $email_id, $escrow->id)); 
    
    
                 do_action( 'AistorEscrowReleased',$eid);
        }
        
        
}    
      
       
       
        
        
        
        
  
  
   function AcceptEscrow____ReviewNeeded($escrow,$email_id)
    {
         
            if (accept_escrow_btn_visible($escrow ,$email_id )  ) 
            
            {
                
                
   if (isset($_POST['submit']) and $_POST['action'] == 'accepted')
        {

            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');

            }
            
            
            
            
            
// did not trusted the passed escrow so re query
            $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE receiver_email = %s  and id=%s ", $email_id, $eid));

            $aistore_escrow_currency = $escrow->currency;
       
            $user_email = get_the_author_meta('user_email', get_current_user_id());

            

            $amount = $escrow->amount;

            $escrow_fee = $this->accept_escrow_fee($amount);

            // fee will be debited from both party once user accept the escrow
            
            // recheck the description message 
            
            $accept_escrow_message = get_option('accept_escrow_message');
            $escrow_details = $accept_escrow_message . $eid;
            $escrow_fee_deducted = get_option('escrow_fee_deducted');
            
        if($escrow_fee_deducted == 'accepted'){
            $escrow_wallet = new AistoreWallet();

            $escrow_wallet->aistore_debit($user_id, $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);

            $escrow_wallet->aistore_credit($escrow_admin_user_id, $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid); // change variable name
            
}





 
global $wpdb;
        
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = '%s'  WHERE  payment_status='paid' and  receiver_email = %s  and id = '%d'", 'accepted', $email_id, $eid));
    
    
 
 
            
                
            do_action( 'aistore_escrow_accepted',$eid);
                
            do_action( 'AistorEscrowAccepted',$eid);

        }
        
        
        }
        
    }
        
        
        
        
   function DisputeEscrow($escrow)
    {
        
           

            

            if ($this->dispute_escrow_btn_visible($escrow)  ) 
            
            {

global $wpdb;
        
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = '%s'  WHERE id = '%d' and payment_status='paid'", 'disputed', $escrow->id));
    
    
       
           
            do_action( 'AistorEscrowDisputed',$escrow->id);
            
           
            }
        
    }
  
  
   function dispute_escrow_btn_visible($escrow)
    {

        if ($escrow->payment_status <> "paid")   return false;

        if ($escrow->status == "closed")  return false;

        else

        if ($escrow->status == "released")  return false;

        else

        if ($escrow->status == "cancelled")  return false;

        else

        if ($escrow->status == "disputed")  return false;

        else

        if ($escrow->status == "pending")  return false;

 return true;
    }
    
    
    
   public function release_escrow_btn_visible($escrow,$user_email)
    {

  
   
        if ($escrow->payment_status <> "paid")  return false;


        if ($escrow->sender_email <> $user_email  and  !is_admin())  return false;

        
        //  if (aistore_isadmin() == $user_email) return "";
         

        if ($escrow->status == "closed")  return false;


        else

        if ($escrow->status == "released")  return false;


        else

        if ($escrow->status == "cancelled")  return false;

        else

        if ($escrow->status == "pending")  return false;



 return true;

 
    }
    
    
        function cancel_escrow_btn_visible($escrow,$user_email)
    {

        if ($escrow->status == "closed") return false;

        else

        if ($escrow->status == "released") return false;

        else

        if ($escrow->status == "cancelled") return false;

       
 
        if ($escrow->sender_email == $user_email)

        {
            if ($escrow->payment_status == "paid")  return false;

        }

      return true;
      
    }
    
        function accept_escrow_btn_visible($escrow,$user_email)
    {
 


        if ($escrow->payment_status <> "paid")  return false;

        if ($escrow->sender_email == $user_email) return false;

        if ($escrow->status == "closed") return false;

        else

        if ($escrow->status == "released")  return false;

        else

        if ($escrow->status == "cancelled")  return false;

        else

        if ($escrow->status == "disputed")  return false;

        else

        if ($escrow->status == "accepted")  return false;

 
return true;
  
    }
    
    
    
    // Accept Button

    


    function accept_escrow_btn($escrow)
    {

 

 $es = new AistoreEscrow();
  
   $user_email = get_the_author_meta('user_email', get_current_user_id());


if(  $es->accept_escrow_btn_visible($escrow,$user_email)   )


{
    
    
 
?>

 <form method="POST" action="" name="accepted" enctype="multipart/form-data"> 
 
<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
  <input type="submit"  class="button button-primary  btn  btn-primary "   name="submit" value="<?php _e('Accept', 'aistore') ?>">
  <input type="hidden" name="action" value="accepted" />
</form> <?php

}
    }



 // cancel button

    
    
    // cancel button
    function cancel_escrow_btn($escrow)
    {
        
        
        
        
        
         $es = new AistoreEscrow();
  
   $user_email = get_the_author_meta('user_email', get_current_user_id());


if(  $es->cancel_escrow_btn_visible($escrow,$user_email)   )


{
    
    
 
?>

 <form method="POST" action="" name="cancelled" enctype="multipart/form-data"> 
 
<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
  <input type="submit"  name="submit"   class="button button-primary  btn  btn-primary "    value="<?php _e('Cancel Escrow', 'aistore') ?>">
  <input type="hidden" name="action" value="cancelled" />
</form> <?php

}
    }






    // release button
   public function release_escrow_btn($escrow)
    {

        $user_email = get_the_author_meta('user_email', get_current_user_id());

  //  $es = new AistoreEscrow();
  
   $user_email = get_the_author_meta('user_email', get_current_user_id());


if(  $this->release_escrow_btn_visible($escrow,$user_email)   )


{

?>

  
 <form method="POST" action="" name="released" enctype="multipart/form-data"> 
 
<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
  <input type="submit"    class="button button-primary  btn  btn-primary "    name="submit" value="<?php _e('Release', 'aistore') ?>">
  <input type="hidden" name="action" value="released" />
</form> <?php
    }

}
    // dispute button
    
    



    function dispute_escrow_btn($escrow)
    {
//    $es = new AistoreEscrow();
  
   $user_email = get_the_author_meta('user_email', get_current_user_id());


if(  $this->dispute_escrow_btn_visible($escrow,$user_email)   )


{
    
         

?>

 <form method="POST" action="" name="disputed" enctype="multipart/form-data"> 
 
<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
  <input type="submit"   class="button button-primary  btn  btn-primary "    name="submit" value="<?php _e('Dispute', 'aistore') ?>">
  <input type="hidden" name="action" value="disputed" />
</form> <?php
    }


    }
     public   function aistore_escrow_btn_actions()
    {
      
      

   
  
        
global $wpdb;
        $eid = sanitize_text_field($_REQUEST['eid']);
        
        
     $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system where id=%s ", $eid));
   

        $escrow_admin_user_id = $this->get_escrow_admin_user_id();

        $user_id = get_current_user_id();

        $email_id = get_the_author_meta('user_email', $user_id);

    
    
    
     
        if (isset($_POST['submit']) and $_POST['action'] == 'disputed')
        {
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');

            }
             

$res= $this->DisputeEscrow($escrow)  ;  



 
    
      $dispute_escrow_success_message = get_option('dispute_escrow_success_message');


 
     
     
?>
<div>
<strong> <?php echo esc_attr($dispute_escrow_success_message); ?></strong></div>
<?php
           // sendNotificationDisputed($eid);
            
            
 do_action( 'AistorEscrowDisputed',$eid);
            do_action( 'aistore_escrow_disputed',$eid);
            
            

        }

    

       

        if (isset($_POST['submit']) and $_POST['action'] == 'accepted')
        {

            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');

            }
            
            
            
            
            

            $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE receiver_email = %s  and id=%s ", $email_id, $eid));

            $aistore_escrow_currency = $escrow->currency;
            $user_email = get_the_author_meta('user_email', get_current_user_id());

            if ($escrow->payment_status <> "paid") return "";

            if ($escrow->sender_email == $user_email) return "";

            if ($escrow->status == "closed") return "";

            else

            if ($escrow->status == "released") return "";

            else

            if ($escrow->status == "cancelled") return "";

            else

            if ($escrow->status == "disputed") return "";

            else

            if ($escrow->status == "accepted") return "";
 $es = new AistoreEscrow();
            $amount = $escrow->amount;

            $escrow_fee = $es->accept_escrow_fee($amount);

            // fee will be debited from both party once user accept the escrow
            
            $accept_escrow_message = get_option('accept_escrow_message');
            $escrow_details = $accept_escrow_message . $eid;
            $escrow_fee_deducted = get_option('escrow_fee_deducted');
            
        if($escrow_fee_deducted == 'accepted'){
            $escrow_wallet = new AistoreWallet();

            $escrow_wallet->aistore_debit($user_id, $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);

            $escrow_wallet->aistore_credit($escrow_admin_user_id, $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid); // change variable name
            
}
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = '%s'  WHERE  payment_status='paid' and  receiver_email = %s  and id = '%d'", 'accepted', $email_id, $eid));
 $accept_escrow_success_message = get_option('accept_escrow_success_message');
?>
<div>
    
<strong> <?php echo esc_attr($accept_escrow_success_message); ?></strong></div>
<?php

          //  sendNotificationAccepted($eid);
            
               //   do_action( 'aistore_escrow_email_accepted',$eid);
            do_action( 'aistore_escrow_accepted',$eid);

        }

        if (isset($_POST['submit']) and $_POST['action'] == 'released')
        {

            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');

            }






            $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE payment_status='paid' and sender_email = %s  and id=%s ", $email_id, $eid));

            $aistore_escrow_currency = $escrow->currency;
            $escrow_amount = $escrow->amount;
            $escrow_fee = $escrow->escrow_fee;
            $escrow_reciever_email_id = $escrow->receiver_email;

            $escrow_user = get_user_by('email', $escrow_reciever_email_id);

            $escrow_user_id = $escrow_user->ID; // change varibale name
            
             $release_escrow_message = get_option('release_escrow_message');
            $escrow_details = $release_escrow_message . $eid;
            
             $escrow_fee_deducted = get_option('escrow_fee_deducted');
                        $escrow_wallet = new AistoreWallet();

        if($escrow_fee_deducted == 'released'){

            $escrow_wallet->aistore_debit($escrow_user_id, $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);

            $escrow_wallet->aistore_credit($escrow_admin_user_id, $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid); // change variable name
            
}

          

            $escrow_wallet->aistore_debit($escrow_admin_user_id, $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid);

            $escrow_wallet->aistore_credit($escrow_user_id, $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid);

           
           
           // $es = new AistoreEscrow();
            $email_id = get_user_by('email', $escrow_reciever_email_id);
          // $res= $es-> release_escrow($escrow,$email_id)  ;  
global $wpdb;


            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = 'released'  WHERE  payment_status='paid' and  sender_email=%s and id = %d ", $email_id, $eid));
    
    
    
   $release_escrow_success_message = get_option('release_escrow_success_message');
            
?>
<div>
<strong> <?php echo esc_attr($release_escrow_success_message); ?></strong></div>
<?php
          //  sendNotificationReleased($eid);
              // do_action( 'aistore_escrow_email_released',$eid);
                 do_action( 'aistore_escrow_released',$eid);
              //      do_action( 'aistore_escrow_released',$eid);
                     
                  do_action( 'AistorEscrowReleased',$eid); 
        }

        // Sender Create escrow  to excute cancel button
        // Receiver  accept or cancel escrow
        if (isset($_POST['submit']) and $_POST['action'] == 'cancelled')
        {

            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');

            }

            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = 'cancelled'  WHERE (  receiver_email = %s   or  sender_email = %s    )  and  id =  %d ", $email_id, $email_id, $eid));

            $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system  WHERE (  receiver_email = %s   or  sender_email = %s    )  and  id =  %d ", $email_id, $email_id, $eid));

            if ($escrow->payment_status == "paid")
            {

                $escrow_amount = $escrow->amount;

                $sender_escrow_fee = $escrow->escrow_fee;

                $sender_email = $escrow->sender_email;

                $user = get_user_by('email', $sender_email);

                $sender_id = $user->ID;

                $aistore_escrow_currency = $escrow->currency;
                
                $cancel_escrow_message = get_option('cancel_escrow_message');
                $escrow_details = $cancel_escrow_message . $eid;

                $escrow_wallet = new AistoreWallet();

                $escrow_wallet->aistore_debit($escrow_admin_user_id, $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid);

                $escrow_wallet->aistore_credit($sender_id, $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid);

                $cancel_escrow_fee = get_option('cancel_escrow_fee');

                if ($cancel_escrow_fee == 'yes')
                {
                    $escrow_wallet->aistore_debit($escrow_admin_user_id, $sender_escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);

                    $escrow_wallet->aistore_credit($sender_id, $sender_escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);

                }
                
                

            }
            
             $cancel_escrow_success_message = get_option('cancel_escrow_success_message');

?>
<div>
<strong><?php echo esc_attr($cancel_escrow_success_message); ?></strong></div>

<?php
        //    sendNotificationCancelled($eid);
            // do_action( 'aistore_escrow_email_cancelled',$eid);
               do_action( 'aistore_escrow_cancelled',$eid);
               
               
                  do_action( 'AistorEscrowCancelled',$eid); 
               
               
        }



   
  
  
  
    }



      
 
function aistore_ipaddress(){
      $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR')) $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED')) $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR')) $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED')) $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR')) $ipaddress = getenv('REMOTE_ADDR');
    else $ipaddress = 'UNKNOWN';
    
    return $ipaddress;
}

}
add_action('AistorEscrowDetails', 'escrowDetails', 10, 3);


function escrowDetails($eid)
{
     $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%d ", $eid));
     
     return $eid;
}