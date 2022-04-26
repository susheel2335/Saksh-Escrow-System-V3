<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}

class AistoreEscrowST
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

 


    
    
    // create escrow System
    public static function aistore_escrow_system()
    {

        if (!is_user_logged_in())
        {
            return "<div class='no-login'>Kindly login and then visit this page </div>";
        }

    ob_start();
            
        $object_escrow = new AistoreEscrowSystem();
        $aistore_escrow_currency = $object_escrow->get_escrow_currency();

        $escrow_admin_user_id = $object_escrow->get_escrow_admin_user_id(); // change variable name
        

        echo "<div>";

        $wallet = new AistoreWallet();

        $user_id = get_current_user_id();

        
        
        if (isset($_POST['submit']) and $_POST['action'] == 'escrow_system')
        {
            
            
                       

            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }

            $title = sanitize_text_field($_REQUEST['title']);
            $amount = sanitize_text_field($_REQUEST['amount']);

            $receiver_email = sanitize_email($_REQUEST['receiver_email']);

            $term_condition = sanitize_textarea_field(htmlentities($_REQUEST['term_condition']));

            $escrow_currency = sanitize_text_field($_REQUEST['aistore_escrow_currency']);

            $escrow_fee = $object_escrow->create_escrow_fee($amount);

            $sender_email = get_the_author_meta('user_email', get_current_user_id());

            global $wpdb;

            // add currency also
         $qr=$wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_system ( title, amount, receiver_email,sender_email,term_condition,escrow_fee ,currency ) VALUES ( %s, %s, %s, %s ,%s ,%s,%s)", array(
                $title,
                $amount,
                $receiver_email,
                $sender_email,
                $term_condition,
                $escrow_fee,
                $escrow_currency
            ));
            
         
            
               $wpdb->query($qr);
            
    

            $eid = $wpdb->insert_id;

  $escrow_wallet = new AistoreWallet();
 $user_balance=$escrow_wallet->aistore_balance($user_id,$escrow_currency);

$sender_email = get_the_author_meta( 'user_email', $user_id );

$new_amount = $escrow_fee + $amount;

if($user_balance>$new_amount){
     $object_escrow = new AistoreEscrowSystem();
      $escrow_admin_user_id = $object_escrow->get_escrow_admin_user_id();
      
             $created_escrow_message = get_option('created_escrow_message');
        $escrow_details =$created_escrow_message .$eid;
                    
      $escrow_wallet->aistore_debit($user_id, $amount, $escrow_currency, $escrow_details,$eid);

        $escrow_wallet->aistore_credit($escrow_admin_user_id, $amount, $escrow_currency, $escrow_details,$eid); 
            
            
              $escrow_details = 'Escrow Fee for the created escrow with escrow id '.$eid;
         $escrow_wallet->aistore_debit($user_id, $escrow_fee, $escrow_currency, $escrow_details,$eid);

     $escrow_wallet->aistore_credit($escrow_admin_user_id, $escrow_fee, $escrow_currency, $escrow_details,$eid); 
            
            
              $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET payment_status = 'paid'  WHERE id = '%d' ", $eid));
    

}
            // check if user have uploaded file or not  then do this
            
              $set_file =  get_option('escrow_file_type');
                
            $fileType = $_FILES['file']['type'];

            if ($fileType == "application/".$set_file)
            {
                $upload_dir = wp_upload_dir();

                if (!empty($upload_dir['basedir']))
                {

                    $user_dirname = $upload_dir['basedir'] . '/documents/' . $eid;
                    if (!file_exists($user_dirname))
                    {
                        wp_mkdir_p($user_dirname);
                    }

                    $filename = wp_unique_filename($user_dirname, $_FILES['file']['name']);
                    move_uploaded_file(sanitize_text_field($_FILES['file']['tmp_name']) , $user_dirname . '/' . $filename);

                    $image = $upload_dir['baseurl'] . '/documents/' . $eid . '/' . $filename;

                    // save into database  $image
                      $object_escrow = new AistoreEscrowSystem();
        $ipaddress = $object_escrow->aistore_ipaddress();



                    $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_documents ( eid, documents,user_id,documents_name,ipaddress) VALUES ( %d,%s,%d,%s,%s)", array(
                        $eid,
                        $image,
                        $user_id,
                        $filename,
                        $ipaddress
                    )));
                  



                }
            }
            
            
            
           
           

            sendNotificationCreated($eid);
            
            $bank_details_page_id_url = esc_url(add_query_arg(array(
                'page_id' => get_option('bank_details_page_id') ,
                'eid' => $eid,
            ) , home_url()));
            
          

 
 

?>
<meta http-equiv="refresh" content="0; URL=<?php echo esc_url($bank_details_page_id_url); ?>" />


<?php

 
        }
        else
        {
?>
    
    <form method="POST" action="" name="escrow_system" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

                
                 
<label for="title"><?php _e('Title', 'aistore'); ?></label><br>
  <input class="input" type="text" id="title" name="title" required><br>

  <label for="title"><?php _e('Currency', 'aistore'); ?></label><br>
  <?php
            global $wpdb;
            $escrow_wallet = new AistoreWallet();
        $results = $escrow_wallet->aistore_wallet_currency();
        
        
?>
       <select name="aistore_escrow_currency" id="aistore_escrow_currency" >
                <?php
            foreach ($results as $c)
            {

                echo '	<option  value="' . esc_attr($c->symbol) . '">' . esc_attr($c->currency) . '</option>';

            }
?>
           
  
</select><br>
  <?php

?>

  <label for="amount"><?php _e('Amount', 'aistore'); ?></label><br>
  <input class="input" type="text" id="amount" name="amount"   required><br>
 
   <input class="input" type="hidden" id="escrow_create_fee" name="escrow_create_fee" value= "<?php echo esc_attr( get_option('escrow_create_fee')); ?>">
    <div class="feeblock hide" >
  <?php

?>
<br>
      <?php _e('Amount', 'aistore'); ?> :
      <b id="escrow_amount"></b>/- <span id="escrow_currency"></span><br>
 
  <?php _e('Escrow Fee', 'aistore'); ?>
  
  :  <b id="escrow_fee" ></b>/- <span id="escrow_currency"></span> (<?php echo esc_attr(get_option('escrow_create_fee')); ?> %)<br>
  
    
     
   <?php _e('Total Escrow Amount', 'aistore'); ?> :   <b id="total"></b>/- <span id="escrow_currency"></span>
   
   
   
  
  
  </div>
  <br>
  
<label for="receiver_email"><?php _e('Receiver Email', 'aistore'); ?>:</label><br>
  <input class="input" type="email" id="receiver_email" name="receiver_email" required><br>
  
   <label for="term_condition"> <?php _e('Term And Condition', 'aistore') ?></label><br>
   
   



  
  <?php
            $content = '';
            $editor_id = 'term_condition';

            $settings = array(
                'tinymce' => array(
                    'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright   ',
                    'toolbar2' => '',
                    'toolbar3' => ''

                ) ,
                'textarea_rows' => 1,
                'teeny' => true,
                'quicktags' => false,
                'media_buttons' => false
            );

            wp_editor($content, $editor_id, $settings);
?>
  



<br><br><?php 
    $set_file =  get_option('escrow_file_type');
    ?>

	<label for="documents"><?php _e('Documents', 'aistore') ?>: </label>
     <input type="file" name="file"    /><br>
     <div><p> <?php _e('Note : We accept only '.$set_file.' file and
	You can upload many pdf file then go to next escrow details page.', 'aistore') ?></p></div>
<input 
 type="submit" class="button button-primary  btn  btn-primary "   name="submit" value="<?php _e('Create Escrow', 'aistore') ?>"/>
<input type="hidden" name="action" value="escrow_system" />
</form> 
<?php
        }

?>
</div>
<?php

 return ob_get_clean();
 
 
    }

    // Escrow List
    public static function aistore_escrow_list()
    {
        if (!is_user_logged_in())
        {
            return "<div class='loginerror'>Kindly login and then visit this page</div>";
        }

        $object_escrow_currency = new AistoreEscrowSystem();
        $aistore_escrow_currency = $object_escrow_currency->get_escrow_currency();
        $user_id= get_current_user_id();
        $current_user_email_id = get_the_author_meta('user_email', $user_id);

        global $wpdb;

        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE receiver_email=%s or sender_email=%s order by id desc ", $current_user_email_id, $current_user_email_id));
    ob_start();
?>
<h3><u><?php _e('Top  Escrow', 'aistore'); ?></u> </h3>
<?php
        if ($results == null)
        {
            echo "<div class='no-result'>";

            _e('No Escrow Found', 'aistore');
            echo "</div>";
        }
        else
        {

        

?>
  
    <table class="table">
     
        <tr>
      
    <th><?php _e('Id', 'aistore'); ?></th>
        <th><?php _e('Title', 'aistore'); ?></th>
         <th><?php _e('Role', 'aistore'); ?></th>
          <th><?php _e('Amount', 'aistore'); ?></th> 
		  <th><?php _e('Sender', 'aistore'); ?></th>
		  <th><?php _e('Receiver', 'aistore'); ?></th>
		    <th><?php _e('Payment Status', 'aistore'); ?></th>
		 	    <th><?php _e('Status', 'aistore'); ?></th>
</tr>

    <?php
            foreach ($results as $row):

                $details_escrow_page_id_url = esc_url(add_query_arg(array(
                    'page_id' => get_option('details_escrow_page_id') ,
                    'eid' => $row->id,
                ) , home_url()));

?>
 
 
      
    
      <tr>
           
		 
		   
		   
		   <td> 	<a href="<?php echo esc_url($details_escrow_page_id_url); ?>" >

		   <?php echo esc_attr($row->id); ?> </a> </td>
  <td> 		   <?php echo esc_attr($row->title); ?> </td>
    <td> 	

  <?php
                if ($row->sender_email == $current_user_email_id)
                {
                    $role = "Sender";
                    $email = $row->receiver_email;
                }
                else
                {
                    $role = "Receiver";
                    $email = $row->sender_email;
                }
                echo esc_attr($role);

?>

		  </td>
		   
		  	   <td> 		   <?php echo esc_attr($row->amount) . " " . esc_attr($row->currency) ?> </td>
		   <td> 		   <?php echo esc_attr($row->sender_email); ?> </td>
		   <td> 		   <?php echo esc_attr($row->receiver_email); ?> </td>
		    <td> 		   <?php echo esc_attr($row->payment_status); ?> </td>
   <td> 		   <?php echo esc_attr($row->status); ?> </td>
            </tr>
    <?php
            endforeach;

        } ?>

    </table>
	
	
	
	
	

    <?php
        return ob_get_clean();

    }

    // Escrow Details
    public static function aistore_escrow_detail()
    {
        if (!is_user_logged_in())
        {
            return;
        }


 ob_start();
 
 
 
        if (!sanitize_text_field($_REQUEST['eid']))
        {

            $add_escrow_page_url = esc_url(add_query_arg(array(
                'page_id' => get_option('add_escrow_page_id') ,
            ) , home_url()));




?>
    
   
<meta http-equiv="refresh" content="0; URL=<?php echo esc_url($add_escrow_page_url); ?>" /> 
  
 <?php
        }
global $wpdb;
        $eid = sanitize_text_field($_REQUEST['eid']);
        
        
     $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system where id=%s ", $eid));
     
  
     
        if (isset($_POST['submit']) and $_POST['action'] == 'disputed')
        {
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');

            }

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
      $dispute_escrow_success_message = get_option('dispute_escrow_success_message');

?>
<div>
<strong> <?php echo esc_attr($dispute_escrow_success_message); ?></strong></div>
<?php
            sendNotificationDisputed($eid);

        }

        $object_escrow = new AistoreEscrowSystem();

        $escrow_admin_user_id = $object_escrow->get_escrow_admin_user_id();

        $user_id = get_current_user_id();

        $email_id = get_the_author_meta('user_email', $user_id);

    

       

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

            sendNotificationAccepted($eid);

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

            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = 'released'  WHERE  payment_status='paid' and  sender_email =%s and id = %d ", $email_id, $eid));
   $release_escrow_success_message = get_option('release_escrow_success_message');
            
?>
<div>
<strong> <?php echo esc_attr($release_escrow_success_message); ?></strong></div>
<?php
            sendNotificationReleased($eid);
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
            sendNotificationCancelled($eid);
        }



        $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system  WHERE (  receiver_email = %s   or  sender_email = %s    )  and  id =  %d ", $email_id, $email_id, $eid));

 
?>
	  <div>
	       <div class="alert alert-success" role="alert">
 <strong>  <?php _e('Status ', 'aistore'); ?>   <?php echo esc_attr($escrow->status); ?></strong>
  </div>
	  
	  
	    <div class="alert alert-success" role="alert">
 <strong><?php _e('Payment Status ', 'aistore'); ?>   <?php echo esc_attr($escrow->payment_status); ?></strong>
  </div>
  
	      <?php
        if ($escrow->payment_status == "Pending")
        {
?>
<div>
  <p>Don't ship the product.</p>
  </div><br>
  
  
  <?php
            $user_email = get_the_author_meta('user_email', get_current_user_id());
            if ($escrow->sender_email == $user_email)
            {



            $bank_details_page_id_url = esc_url(add_query_arg(array(
                'page_id' => get_option('bank_details_page_id') ,
                'eid' => $eid,
            ) , home_url()));
            
            ?>

<a href="<?php echo esc_url($bank_details_page_id_url); ?>"><input  class="button button-primary  btn  btn-primary "  type="submit" name="submit" value="<?php _e('Make Payment', 'aistore') ?>"/></a>
 
 
<?php
                } ?>
 <br>


  <?php
            

        }

        echo "<h1>#" . esc_attr($escrow->id) . " " . esc_attr($escrow->title) . "</h1><br>";
    
        printf(__("Sender :  %s", 'aistore') , $escrow->sender_email . "<br>");
        printf(__("Receiver : %s", 'aistore') , $escrow->receiver_email . "<br>");
        printf(__("Status : %s", 'aistore') , $escrow->status . "<br>");
         printf(__("Amount : %s", 'aistore') , $escrow->amount ." ". $escrow->currency."<br><hr />");
        
        printf(__("Term Condition : %s", 'aistore') , html_entity_decode($escrow->term_condition) . "<br>");
        
        
        
        
      
      
?>
</div>

<?php
        return ob_get_clean();
    }
    
    
      
      
      

}



