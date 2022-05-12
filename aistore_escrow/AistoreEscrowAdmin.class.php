<?php
if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

class AistoreEscrowAdmin extends  AistoreEscrowSystem
{
 
 
  
    
    
    public function admin_release_escrow_btn_visible($escrow )
    {
        if ($escrow->payment_status != "paid") {
            return false;
        }

       

        //  if (aistore_isadmin() == $user_email) return "";

        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        } elseif ($escrow->status == "pending") {
            return false;
        }

        return true;
    }


    function admin_cancel_escrow_btn_visible($escrow )
    {
        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        }

       
            if ($escrow->payment_status == "paid") {
                return false;
            }
        

        return true;
    }


    
    
    


 
    public function aistore_escrow_btn_admin_actions()
    {
        global $wpdb;
        $eid = sanitize_text_field($_REQUEST["eid"]);

        $escrow =$this->AistoreGetEscrow($eid );




        $escrow_admin_user_id = $this->get_escrow_admin_user_id();

        $user_id = get_current_user_id();

        $email_id = get_the_author_meta("user_email", $user_id);

      

        if (isset($_POST["submit"]) and $_POST["action"] == "released") {



            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
            }

            if(!$this->admin_release_escrow_btn_visible($escrow ))
return;

            $aistore_escrow_currency = $escrow->currency;
            $escrow_amount = $escrow->amount;
            $escrow_fee = $escrow->escrow_fee;
            $escrow_reciever_email_id = $escrow->receiver_email;

            $escrow_user = get_user_by("email", $escrow_reciever_email_id);

            $escrow_user_id = $escrow_user->ID; // change varibale name

            $escrow_details =Aistore_process_placeholder_Text (  get_option("release_escrow_message")  ,$escrow ) ;
         

            $escrow_fee_deducted = get_option("escrow_fee_deducted");
            $escrow_wallet = new AistoreWallet();

            if ($escrow_fee_deducted == "released") {
              
                 $escrow_wallet->  aistore_transfer($escrow_user_id,$escrow_admin_user_id,  $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);
               
                
            }



  $escrow_wallet->  aistore_transfer($escrow_admin_user_id,$escrow_user_id,  $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid);
              
            

           
            $email_id = get_user_by("email", $escrow_reciever_email_id);
            
            

            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET status = 'released'  WHERE  payment_status='paid' and  id = %d ",
                  
                    $eid
                )
            );

            $release_escrow_success_message =Aistore_process_placeholder_Text   ( get_option(
                "release_escrow_success_message"
            )  , $escrow );
            ?>
<div>
<strong> <?php echo esc_attr($release_escrow_success_message); ?></strong></div>
<?php
$escrow = $this->AistoreGetEscrow($eid);
do_action("AistoreEscrowReleased", $escrow);

        }

        // Sender Create escrow  to excute cancel button
        // Receiver  accept or cancel escrow
        if (isset($_POST["submit"]) and $_POST["action"] == "cancelled") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
            }




            if(!$this->admin_cancel_escrow_btn_visible($escrow ))
return;




            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET status = 'cancelled'  WHERE    id =  %d ",
                    
                    $eid
                )
            );

          $escrow = $this->AistoreGetEscrow($eid);

            if ($escrow->payment_status == "paid") {
                $escrow_amount = $escrow->amount;

                $sender_escrow_fee = $escrow->escrow_fee;

                $sender_email = $escrow->sender_email;

                $user = get_user_by("email", $sender_email);

                $sender_id = $user->ID;

                $aistore_escrow_currency = $escrow->currency;

                $escrow_details =Aistore_process_placeholder_Text( get_option("cancel_escrow_message"),  $escrow );
                 

                $escrow_wallet = new AistoreWallet();


   $escrow_wallet->  aistore_transfer($escrow_admin_user_id,$sender_id,  $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid);
               
                
                 
                 

                $cancel_escrow_fee = get_option("cancel_escrow_fee");

                if ($cancel_escrow_fee == "yes") {
                    
                    

   $escrow_wallet->  aistore_transfer($escrow_admin_user_id,$sender_id,  $sender_escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);
               
                
                
                 
                }
            }

            $cancel_escrow_success_message =Aistore_process_placeholder_Text( get_option(
                "cancel_escrow_success_message"
            ),$escrow);
            
            
            ?>
<div>
<strong><?php echo esc_attr($cancel_escrow_success_message); ?></strong></div>

<?php
$escrow = $this->AistoreGetEscrow($eid);
do_action("AistoreEscrowCancelled", $escrow);

        }
    }

    
    
    
     
    function admin_cancel_escrow_btn($escrow)
    {
   
            if(!$this->admin_cancel_escrow_btn_visible($escrow ))
return;

  ?>

 <form method="POST" action="" name="cancelled" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"  name="submit"   class="button button-primary  btn  btn-primary "    value="<?php _e(
      "Cancel Escrow",
      "aistore"
  ); ?>">
  <input type="hidden" name="action" value="cancelled" />
</form> <?php 
    
        
        
    }
    
    
       public function admin_release_escrow_btn($escrow)
    {
        if(!$this->admin_release_escrow_btn_visible($escrow ))
return;


       ?>

  
 <form method="POST" action="" name="released" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"    class="button button-primary  btn  btn-primary "    name="submit" value="<?php _e(
      "Release",
      "aistore"
  ); ?>">
  <input type="hidden" name="action" value="released" />
</form> <?php  
    }
    
    
    
    
    
    
    
    
     
    
}
