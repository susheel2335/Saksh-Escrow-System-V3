<?php
if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

class AistoreEscrow
{
    // This function is used to get escrow admin user id
    public function get_escrow_admin_user_id()
    {
        $escrow_admin_user_id = get_option("escrow_user_id");
        return $escrow_admin_user_id;
    }
    
    //This function is used to get escrow currency
    public function get_escrow_currency()
    {
        $aistore_escrow_currency = get_option("aistore_escrow_currency");
        return $aistore_escrow_currency;
    }

//This function is used to create escrow fee
    public function create_escrow_fee($amount)
    {
        $escrow_create_fee = get_option("escrow_create_fee");

        $escrow_fee = ($escrow_create_fee / 100) * $amount;
        return $escrow_fee;
    }
    
    //This function is used to accept escrow fee
    public function accept_escrow_fee($amount)
    {
        $escrow_accept_fee = get_option("escrow_accept_fee");

        $escrow_fee = ($escrow_accept_fee / 100) * $amount;
        return $escrow_fee;
    }
    
    
     //This function is used to create escrow 
    function create_escrow($request)
    {
        global $wpdb;

        $title = sanitize_text_field($request["title"]);
        $amount = sanitize_text_field($request["amount"]);
        $escrow_fee = $this->create_escrow_fee($amount);

        $receiver_email = sanitize_email($request["receiver_email"]);

        $term_condition = sanitize_textarea_field(
            htmlentities($request["term_condition"])
        );

        $escrow_currency = sanitize_text_field(
            $request["aistore_escrow_currency"]
        );

        $sender_email = $request["user_email"];

        $qr = $wpdb->prepare(
            "INSERT INTO {$wpdb->prefix}escrow_system ( title, amount, receiver_email,sender_email,term_condition ,escrow_fee ,currency ) VALUES ( %s, %s, %s, %s ,%s , %s,%s)",
            [
                $title,
                $amount,
                $receiver_email,
                $sender_email,
                $term_condition,
                $escrow_fee,
                $escrow_currency,
            ]
        );

        $wpdb->query($qr);

        $eid = $wpdb->insert_id;

        $details_escrow_page_id_url = esc_url(
            add_query_arg(
                [
                    "page_id" => get_option("details_escrow_page_id"),
                    "eid" => $eid,
                ],
                home_url()
            )
        );

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->prefix}escrow_system
    SET url = '%s'  WHERE id = '%d'",
                $details_escrow_page_id_url,
                $eid
            )
        );

        $request["id"] = $eid;
        $request["currency"] = $escrow_currency;
        $request["sender_email"] = $sender_email;

        $escrow = $this->AistoreGetEscrow($eid);

        $request["escrow"] = $escrow;

        do_action("AistoreEscrowCreatedRequest", $request);

        do_action("AistoreEscrowCreated", $escrow);

        return $escrow;
    }

    // This function is used to  escrow list by user email id
    public function AistoreEscrowList($emailId)
    {
        global $wpdb;

        $results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}escrow_system WHERE receiver_email=%s or sender_email=%s order by id desc ",
                $emailId,
                $emailId
            )
        );

        return $results;
    }
    
    
    
      // This function is used to escrow details by escrow id and an email
 public function AistoreEscrowDetail($eid, $email)
    {
        global $wpdb;

        $escrow = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}escrow_system where id=%d and ( receiver_email=%s or sender_email=%s ) ",
                $eid,
                $email,
                $email
            )
        );

        return $escrow;
    }
    
    
    // This function is used to get escrow details by escrow id
    public function AistoreGetEscrow($eid )
    {
        global $wpdb;

        $escrow = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}escrow_system where id=%d   ",
                $eid 
            )
        );

        return $escrow;
    }
    
    
      // This function is used to send payment to user account with escrow id and payment status are paid
       public function AistoreEscrowMarkPaid($escrow )
    {
        global $wpdb;

         $escrow_admin_user_id = $this->get_escrow_admin_user_id();
                    
         $aistore_escrow_currency = $escrow->currency;
                     
     $escrow_amount = $escrow->amount;
                     
       $escrow_fee = $escrow->escrow_fee;
                     
                     $eid=$escrow->id;
                     
                     
        $sender_email = $escrow->sender_email;
          
            $user = get_user_by('email', $sender_email);
           
            $sender_id = $user->ID;
                    
    $escrow_payment_credit_by_gateway = 'Send Payment To User Account  with escrow id # '.$eid;
                      
        
   $escrow_wallet = new AistoreWallet();
                       
   
        
        
        
 $description_amount_transfer = 'Escrow amount for the created escrow with id #'.$eid;
        
        
        
  
   $escrow_wallet->aistore_transfer($sender_id,$escrow_admin_user_id,  $escrow_amount, $aistore_escrow_currency, $description_amount_transfer,$eid);
               
               
   
                    
 $description_fee_transfer = 'Escrow Fee for the created escrow with id #'.$eid;
        
        
        $escrow_wallet->aistore_transfer($sender_id,$escrow_admin_user_id,  $escrow_fee, $aistore_escrow_currency, $description_fee_transfer,$eid);
               
         
            
            
       global  $wpdb;
       
 $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET payment_status = 'paid'  WHERE id = '%d' ", $eid));
    
    
   
      $escrow = $this->AistoreGetEscrow($eid); // make sure we get updated escrow before pushing data to anyone
      
      
     do_action("AistoreEscrowPaymentAccepted", $escrow);

        return $escrow;
    }




// This function is used to cancel escrow with escrow id and status are cancelled

    function CancelEscrow____ReviewNeeded($escrow, $email_id)
    {
        if (cancel_escrow_btn_visible($escrow, $email_id)) {
            global $wpdb;

            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET status = 'cancelled'  WHERE (  receiver_email = %s   or  sender_email = %s    )  and  id =  %d ",
                    $email_id,
                    $email_id,
                    $eid
                )
            );
        }
    }


// This function is used to release escrow with escrow id and status are released
    function ReleaseEscrow____ReviewNeeded($escrow, $email_id)
    {
        if (accept_escrow_btn_visible($escrow, $email_id)) {
            global $wpdb;

            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET status = 'released'  WHERE  payment_status='paid' and  sender_email =%s and id = %d ",
                    $email_id,
                    $escrow->id
                )
            );

            $escrow = $this->escrowDetails($escrow->id);
            do_action("AistoreEscrowReleased", $escrow);
        }
    }

// This function is used to accept escrow with escrow id and status are accepted and payment status are paid
    function AcceptEscrow____ReviewNeeded($escrow, $email_id)
    {
        if (accept_escrow_btn_visible($escrow, $email_id)) {
            if (isset($_POST["submit"]) and $_POST["action"] == "accepted") {
                if (
                    !isset($_POST["aistore_nonce"]) ||
                    !wp_verify_nonce(
                        $_POST["aistore_nonce"],
                        "aistore_nonce_action"
                    )
                ) {
                    return _e("Sorry, your nonce did not verify", "aistore");
                }

                // did not trusted the passed escrow so re query
                $escrow = $wpdb->get_row(
                    $wpdb->prepare(
                        "SELECT * FROM {$wpdb->prefix}escrow_system WHERE receiver_email = %s  and id=%s ",
                        $email_id,
                        $eid
                    )
                );

                $aistore_escrow_currency = $escrow->currency;

                $user_email = get_the_author_meta(
                    "user_email",
                    get_current_user_id()
                );

                $amount = $escrow->amount;

                $escrow_fee = $this->accept_escrow_fee($amount);

                // fee will be debited from both party once user accept the escrow

                // recheck the description message

                $escrow_details =Aistore_process_placeholder_Text(    get_option("accept_escrow_message") ,$escrow);
             //   $escrow_details = $accept_escrow_message . $eid;
                $escrow_fee_deducted = get_option("escrow_fee_deducted");

                if ($escrow_fee_deducted == "accepted") {
                    $escrow_wallet = new AistoreWallet();



        
        $escrow_wallet->aistore_transfer($user_id,$escrow_admin_user_id,  $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);
        
        
      
                    
                    
                }

                global $wpdb;

                $wpdb->query(
                    $wpdb->prepare(
                        "UPDATE {$wpdb->prefix}escrow_system
    SET status = '%s'  WHERE  payment_status='paid' and  receiver_email = %s  and id = '%d'",
                        "accepted",
                        $email_id,
                        $eid
                    )
                );

                $escrow = $this->AistoreGetEscrow($eid);
                do_action("AistoreEscrowAccepted", $escrow);
            }
        }
    }


//  This function is used to dispute escrow with escrow id and status are disputed 
    function DisputeEscrow($escrow)
    {
        if ($this->dispute_escrow_btn_visible($escrow)) {
            global $wpdb;

            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET status = '%s'  WHERE id = '%d' and payment_status='paid'",
                    "disputed",
                    $escrow->id
                )
            );

            $escrow = $this->AistoreGetEscrow($escrow->id);

            do_action("AistoreEscrowDisputed", $escrow);
        }
    }


//  This function is used to dispute escrow button visible or not
    function dispute_escrow_btn_visible($escrow)
    {
        if ($escrow->payment_status != "paid") {
            return false;
        }

        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        } elseif ($escrow->status == "disputed") {
            return false;
        } elseif ($escrow->status == "pending") {
            return false;
        }

        return true;
    }


// This function is used to release escrow button visible or not
    public function release_escrow_btn_visible($escrow, $user_email)
    {
        if ($escrow->payment_status != "paid") {
            return false;
        }

        if ($escrow->sender_email != $user_email and !is_admin()) {
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
    
    
    //   This function is used to cancel escrow button visible or not
    function cancel_escrow_btn_visible($escrow, $user_email)
    {
        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        }
        
 
        if ($escrow->sender_email == $user_email) {
            
            
        if ($escrow->status  <> "pending") {
         
            if ($escrow->payment_status == "paid") {
                return false;
            }
        }
        }

        return true;
    }

    //   This function is used to accept escrow button visible or not
    function accept_escrow_btn_visible($escrow, $user_email)
    {
        if ($escrow->payment_status != "paid") {
            return false;
        }

        if ($escrow->sender_email == $user_email) {
            return false;
        }

        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        } elseif ($escrow->status == "disputed") {
            return false;
        } elseif ($escrow->status == "accepted") {
            return false;
        }

        return true;
    }
    
    
    // This function is used to make_payment escrow button visible or not
    function make_payment_btn_visible($escrow, $user_email)
    {
        if ($escrow->payment_status != "paid") {
            return false;
        } 
        
        if ($escrow->payment_status != "cancelled") {
            return false;
        }

       
        if ($escrow->sender_email != $user_email) {
            return false;
        }

     
     


        return true;
    }



    // This function is used to  Accept Button

    function accept_escrow_btn($escrow)
    {
        $es = new AistoreEscrow();

        $user_email = get_the_author_meta("user_email", get_current_user_id());

        if ($es->accept_escrow_btn_visible($escrow, $user_email)) { ?>

 <form method="POST" action="" name="accepted" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"  class="button button-primary  btn  btn-primary "   name="submit" value="<?php _e(
      "Accept",
      "aistore"
  ); ?>">
  <input type="hidden" name="action" value="accepted" />
</form> <?php }
    }



    // cancel button

//   This function is used to  Cancel Button
    function cancel_escrow_btn($escrow)
    {
        $es = new AistoreEscrow();

        $user_email = get_the_author_meta("user_email", get_current_user_id());

        if ($es->cancel_escrow_btn_visible($escrow, $user_email)) { ?>

 <form method="POST" action="" name="cancelled" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"  name="submit"   class="button button-primary  btn  btn-primary "    value="<?php _e(
      "Cancel Escrow",
      "aistore"
  ); ?>">
  <input type="hidden" name="action" value="cancelled" />
</form> <?php }
 
    }
    
    
    
//  This function is used to  Release Button
    // release button
    public function release_escrow_btn($escrow)
    {
        $user_email = get_the_author_meta("user_email", get_current_user_id());

        //  $es = new AistoreEscrow();

        $user_email = get_the_author_meta("user_email", get_current_user_id());

        if ($this->release_escrow_btn_visible($escrow, $user_email)) { ?>

  
 <form method="POST" action="" name="released" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"    class="button button-primary  btn  btn-primary "    name="submit" value="<?php _e(
      "Release",
      "aistore"
  ); ?>">
  <input type="hidden" name="action" value="released" />
</form> <?php }
    }
    
    
    
    // dispute button
//  This function is used to  Dispute Button
    function dispute_escrow_btn($escrow)
    {
        //    $es = new AistoreEscrow();

        $user_email = get_the_author_meta("user_email", get_current_user_id());

        if ($this->dispute_escrow_btn_visible($escrow, $user_email)) { ?>

 <form method="POST" action="" name="disputed" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"   class="button button-primary  btn  btn-primary "    name="submit" value="<?php _e(
      "Dispute",
      "aistore"
  ); ?>">
  <input type="hidden" name="action" value="disputed" />
</form> <?php }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //This function is to escrow button action 
    // like disputed, accepted,released,cancelled
    public function aistore_escrow_btn_actions()
    {
        global $wpdb;
        $eid = sanitize_text_field($_REQUEST["eid"]);
 $escrow_wallet = new AistoreWallet();
 
 
    $escrow =$this->AistoreGetEscrow($eid );
 
 
 
  

        $escrow_admin_user_id = $this->get_escrow_admin_user_id();

        $user_id = get_current_user_id();

        $email_id = get_the_author_meta("user_email", $user_id);

        if (isset($_POST["submit"]) and $_POST["action"] == "disputed") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
            }

            $res = $this->DisputeEscrow($escrow);

            $dispute_escrow_success_message = Aistore_process_placeholder_Text  (  get_option(
                "dispute_escrow_success_message"
            ) ,$escrow) ;
            ?>
<div>
<strong> <?php echo esc_attr($dispute_escrow_success_message); ?></strong></div>
<?php
$escrow = $this->AistoreGetEscrow($eid);
do_action("AistoreEscrowDisputed", $escrow);

        }

        if (isset($_POST["submit"]) and $_POST["action"] == "accepted") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
            }



    $escrow =$this->AistoreEscrowDetail($eid,$email_id );
    
    
     

            $aistore_escrow_currency = $escrow->currency;
            $user_email = get_the_author_meta(
                "user_email",
                get_current_user_id()
            );

            if ($escrow->payment_status != "paid") {
                return "";
            }

            if ($escrow->sender_email == $user_email) {
                return "";
            }

            if ($escrow->status == "closed") {
                return "";
            } elseif ($escrow->status == "released") {
                return "";
            } elseif ($escrow->status == "cancelled") {
                return "";
            } elseif ($escrow->status == "disputed") {
                return "";
            } elseif ($escrow->status == "accepted") {
                return "";
            }
            
             
     
          
            $amount = $escrow->amount;

            $escrow_fee = $this->accept_escrow_fee($amount);

            // fee will be debited from both party once user accept the escrow

            $escrow_details = Aistore_process_placeholder_Text  (  get_option("accept_escrow_message") ,$escrow);
         
            $escrow_fee_deducted = get_option("escrow_fee_deducted");

            if ($escrow_fee_deducted == "accepted") {
               


   
        $escrow_wallet->aistore_transfer($user_id,$escrow_admin_user_id,  $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);
        
        
      
           
      
              
            }
            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET status = '%s'  WHERE  payment_status='paid' and  receiver_email = %s  and id = '%d'",
                    "accepted",
                    $email_id,
                    $eid
                )
            );
            
             
     
     
            $accept_escrow_success_message =Aistore_process_placeholder_Text (  get_option(
                "accept_escrow_success_message"
            ) ,$escrow) ;
            ?>
<div>
    
<strong> <?php echo esc_attr($accept_escrow_success_message); ?></strong></div>
<?php
$escrow = $this->AistoreGetEscrow($eid);
do_action("AistoreEscrowAccepted", $escrow);

        }

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

            $escrow = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}escrow_system WHERE payment_status='paid' and sender_email = %s  and id=%s ",
                    $email_id,
                    $eid
                )
            );





             $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET status = 'released'  WHERE  payment_status='paid' and  sender_email=%s and id = %d ",
                    $email_id,
                    $eid
                )
            );
            
             
            
            
            
            $aistore_escrow_currency = $escrow->currency;
            $escrow_amount = $escrow->amount;
            $escrow_fee = $escrow->escrow_fee;
            $escrow_reciever_email_id = $escrow->receiver_email;

            $escrow_user = get_user_by("email", $escrow_reciever_email_id);

            $escrow_user_id = $escrow_user->ID; // change varibale name

            $escrow_details =Aistore_process_placeholder_Text (  get_option("release_escrow_message")  ,$escrow ) ;
         

            $escrow_fee_deducted = get_option("escrow_fee_deducted");
            

            if ($escrow_fee_deducted == "released") {
                
                
        $escrow_wallet->aistore_transfer($escrow_user_id,$escrow_admin_user_id,  $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);
        
        
      
      
       
            }
            
            
               $escrow_wallet->aistore_transfer($escrow_admin_user_id,$escrow_user_id,  $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid);
        
        
       
 
            $email_id = get_user_by("email", $escrow_reciever_email_id);
           

           

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
            
            
            
          if(!$this->cancel_escrow_btn_visible($escrow,$email_id) )
          return "";
          
          
            
            
               if($escrow->status == "cancelled"){
                return "";
            }

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
            }
            
            

            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET status = 'cancelled'  WHERE (  receiver_email = %s   or  sender_email = %s    )  and  id =  %d ",
                    $email_id,
                    $email_id,
                    $eid
                )
            );

            $escrow = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}escrow_system  WHERE (  receiver_email = %s   or  sender_email = %s    )  and  id =  %d ",
                    $email_id,
                    $email_id,
                    $eid
                )
            );


        // if($escrow->status == "cancelled"){
        //         return ;
        //     }
            
            if ($escrow->payment_status == "paid") {
                $escrow_amount = $escrow->amount;

                $sender_escrow_fee = $escrow->escrow_fee;

                $sender_email = $escrow->sender_email;

                $user = get_user_by("email", $sender_email);

                $sender_id = $user->ID;

                $aistore_escrow_currency = $escrow->currency;

                $escrow_details =Aistore_process_placeholder_Text( get_option("cancel_escrow_message"),  $escrow );
                 

                $escrow_wallet = new AistoreWallet();



            
               $escrow_wallet->aistore_transfer($escrow_admin_user_id,$sender_id,  $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid);
        
        
        
         

                $cancel_escrow_fee = get_option("cancel_escrow_fee");

                if ($cancel_escrow_fee == "yes") {
                    
                    
            
               $escrow_wallet->aistore_transfer($escrow_admin_user_id,$sender_id,  $sender_escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);
        
        
        
        
                    
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



// This function is to get ip address 
    function aistore_ipaddress()
    {
        $ipaddress = "";
        if (getenv("HTTP_CLIENT_IP")) {
            $ipaddress = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ipaddress = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_X_FORWARDED")) {
            $ipaddress = getenv("HTTP_X_FORWARDED");
        } elseif (getenv("HTTP_FORWARDED_FOR")) {
            $ipaddress = getenv("HTTP_FORWARDED_FOR");
        } elseif (getenv("HTTP_FORWARDED")) {
            $ipaddress = getenv("HTTP_FORWARDED");
        } elseif (getenv("REMOTE_ADDR")) {
            $ipaddress = getenv("REMOTE_ADDR");
        } else {
            $ipaddress = "UNKNOWN";
        }

        return $ipaddress;
    }
}
