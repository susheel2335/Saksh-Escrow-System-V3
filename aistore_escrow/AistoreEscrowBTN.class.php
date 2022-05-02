<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}


this file to be deleted

include_once "AistoreEscrow.class.php";


class AistoreEscrowBTN2222222222222222
{
  
    // Escrow Details
    public   function aistore_escrow_btn_actions()
    {
      
      

     $es = new AistoreEscrow();
 
  
        
global $wpdb;
        $eid = sanitize_text_field($_REQUEST['eid']);
        
        
     $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system where id=%s ", $eid));
     
         $object_escrow = new AistoreEscrowSystem();

        $escrow_admin_user_id = $object_escrow->get_escrow_admin_user_id();

        $user_id = get_current_user_id();

        $email_id = get_the_author_meta('user_email', $user_id);

    
    
    
  
     
        if (isset($_POST['submit']) and $_POST['action'] == 'disputed')
        {
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');

            }
            
            
            
    
  



$res= $es-> dispute_escrow($escrow)  ;  




           /* 

            if ($escrow->payment_status <>  "paid") return "";

            if ($escrow->status == "closed") return "";

            else

            if ($escrow->status == "released") return "";

            else

            if ($escrow->status == "cancelled") return "";

            else

            if ($escrow->status == "disputed") return "";

            else

            if ($escrow->status == "pending") return "";

            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = '%s'  WHERE id = '%d' and payment_status='paid'", 'disputed', $eid));
    
    */
    
    
      $dispute_escrow_success_message = get_option('dispute_escrow_success_message');


 
     
     
?>
<div>
<strong> <?php echo esc_attr($dispute_escrow_success_message); ?></strong></div>
<?php
           // sendNotificationDisputed($eid);
            
            
           do_action( 'aistore_escrow_email_created',$eid);
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

            $amount = $escrow->amount;

            $escrow_fee = $object_escrow->accept_escrow_fee($amount);

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
            
                  do_action( 'aistore_escrow_email_accepted',$eid);
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

           
           
           
            $email_id = get_user_by('email', $escrow_reciever_email_id);
           $res= $es-> release_escrow($escrow,$email_id)  ;  



           // $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    //SET status = 'released'  WHERE  payment_status='paid' and  sender_email //=%s and id = %d ", $email_id, $eid));
    
    
    
   $release_escrow_success_message = get_option('release_escrow_success_message');
            
?>
<div>
<strong> <?php echo esc_attr($release_escrow_success_message); ?></strong></div>
<?php
          //  sendNotificationReleased($eid);
               do_action( 'aistore_escrow_email_released',$eid);
                 do_action( 'aistore_escrow_released',$eid);
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
             do_action( 'aistore_escrow_email_cancelled',$eid);
               do_action( 'aistore_escrow_cancelled',$eid);
        }



   
  
  
  
    }



      
      
      

    // Escrow Discussion
    

  
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

    $es = new AistoreEscrow();
  
   $user_email = get_the_author_meta('user_email', get_current_user_id());


if(  $es->release_escrow_btn_visible($escrow,$user_email)   )


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
    $es = new AistoreEscrow();
  
   $user_email = get_the_author_meta('user_email', get_current_user_id());


if(  $es->dispute_escrow_btn_visible($escrow,$user_email)   )


{
    
         

?>

 <form method="POST" action="" name="disputed" enctype="multipart/form-data"> 
 
<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
  <input type="submit"   class="button button-primary  btn  btn-primary "    name="submit" value="<?php _e('Dispute', 'aistore') ?>">
  <input type="hidden" name="action" value="disputed" />
</form> <?php
    }


    }

}

 
