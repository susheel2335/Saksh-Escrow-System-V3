<?php

// function aistore_escrow_admin_process_payment()
// {


    ?>
    
    <div id="row ">
<div id="col-md-6"   >
    
    <?php
    global $wpdb;
                if (isset($_POST['submit']) and $_POST['action'] == 'escrow_payment')
                {

                    if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
                    {
                        return _e('Sorry, your nonce did not verify', 'aistore');
                        exit;
                    }
                    
                    
                    

                    $eid =   sanitize_text_field($_REQUEST['ecsrow_id']);
                    
                    
                     $object_escrow = new AistoreEscrowSystem();
                     

                       $escrow_admin_user_id = $object_escrow->get_escrow_admin_user_id();
                    
                      $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE id=%s ", $eid));
                      
                      
                       $aistore_escrow_currency = $escrow->currency;
                      $escrow_amount = $escrow->amount;
                      $escrow_fee = $escrow->escrow_fee;
                       $sender_email = $escrow->sender_email;
            $user = get_user_by('email', $sender_email);
            $sender_id = $user->ID;
                      $escrow_details = 'Send Payment To User Account  with escrow id # '.$eid;
                      
                       $escrow_wallet = new AistoreWallet();
                       
                    $new_amount = $escrow_fee+$escrow_amount;
                    
  
            

            $escrow_wallet->aistore_credit($sender_id, $new_amount, $aistore_escrow_currency, $escrow_details,$eid); 
                    
                    
                     $created_escrow_message = get_option('created_escrow_message');
        $escrow_details =$created_escrow_message .$eid;
                
                    
                        $escrow_wallet->aistore_debit($sender_id, $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid);

            $escrow_wallet->aistore_credit($escrow_admin_user_id, $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid); 
                    
                    
                     $escrow_details = 'Escrow Fee for the created escrow with escrow id #'.$eid;
                    
          $escrow_wallet->aistore_debit($sender_id, $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);

            $escrow_wallet->aistore_credit($escrow_admin_user_id, $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid); 
            
                    $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET payment_status = 'paid'  WHERE id = '%d' ", $eid));
    
    
    
     sendNotificationPaymentAccepted($eid);

                }
                
                
                
                      if (isset($_POST['submit']) and $_POST['action'] == 'reject_payment')
                {

                    if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
                    {
                        return _e('Sorry, your nonce did not verify', 'aistore');
                        exit;
                    }

                           $eid =   sanitize_text_field($_REQUEST['reject_ecsrow_id']);
                    $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET payment_status = 'Rejected'  WHERE id = '%d' ", $eid));

                    
                }
                
                if (isset($_POST['submit']) and $_POST['action'] == 'remove_escrow_payment')
                {

                    if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
                    {
                        return _e('Sorry, your nonce did not verify', 'aistore');
                        exit;
                    }

                           $eid =   sanitize_text_field($_REQUEST['ecsrow_id']);
                           
                        $escrow_wallet = new AistoreWallet();
                        $object_escrow = new AistoreEscrowSystem();
                        
                          $escrow_admin_user_id = $object_escrow->get_escrow_admin_user_id();
                    
                      $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE id=%s ", $eid));
                      
                      
                       $aistore_escrow_currency = $escrow->currency;
                      $escrow_amount = $escrow->amount;
                      $escrow_fee = $escrow->escrow_fee;
                       $sender_email = $escrow->sender_email;
            $user = get_user_by('email', $sender_email);
            $sender_id = $user->ID;
            
              $created_escrow_message = get_option('cancel_escrow_message');
        $escrow_details =$created_escrow_message .$eid;
                
                    
            $escrow_wallet->aistore_debit($escrow_admin_user_id, $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid);

            $escrow_wallet->aistore_credit($sender_id, $escrow_amount, $aistore_escrow_currency, $escrow_details,$eid); 
                    
                    
            $escrow_details = 'Escrow Fee for the cancelled escrow with escrow id # '.$eid;
                    
          $escrow_wallet->aistore_debit($escrow_admin_user_id, $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid);

            $escrow_wallet->aistore_credit($sender_id, $escrow_fee, $aistore_escrow_currency, $escrow_details,$eid); 
            
            
                    $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET payment_status = 'Pending'  WHERE id = '%d' ", $eid));

                     sendNotificationPaymentRefund($eid);

                }
             
?>


<?php
        global $wpdb;

        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}escrow_system  order by id desc");

?>


  <h1> <?php _e('Escrow Payment', 'aistore') ?> </h1>
  
  <br>
  <p> <?php _e('<strong>Note : </strong>  To approve  or reject an escrow payment , in the escrow payment to click Approve button or Reject button', 'aistore') ?></p><br>
     
      
      
  
    <?php

        if ($results == null)
        {
           // _e("No Escrow Found", 'aistore');

        }
        else
        {
            
            
            ?>
              
  <table  id="example" class="display nowrap" style="width:100%">
         <thead>
     <tr>
         <th> <?php _e('Id', 'aistore') ?> </th>
      <th> <?php _e('Title', 'aistore') ?> </th>
    
        <th> <?php _e('Amount', 'aistore') ?> </th>
      <th> <?php _e('Sender', 'aistore') ?>  </th>
       <th> <?php _e('Receiver', 'aistore') ?> </th>  
        <th> <?php _e('Payment Status', 'aistore') ?></th>
       <th> <?php _e('Datet', 'aistore') ?> </th>
       <th> <?php _e('Action', 'aistore') ?> </th>
     </tr>
      </thead>
<tbody>
    
    <?php
            foreach ($results as $row):
  $url = admin_url('admin.php?page=disputed_escrow_details&eid=' . $row->id . '', 'https');
?> 
      <tr>
 
		   <td> 	 
		  <a href="<?php echo esc_url($url); ?>">  <?php echo esc_attr($row->id); ?></a></td>
		  
		  
		   
		   <td> 		   <?php echo esc_attr($row->title); ?> </td>
		  
		   <!--<td> 		   <?php echo esc_attr($row->status); ?> </td>-->
		   
		   <td> 		   <?php echo esc_attr($row->amount) . " " . esc_attr($row->currency); ?> </td>
		   <td> 		   <?php echo esc_attr($row->sender_email); ?> </td>
		   <td> 		   <?php echo esc_attr($row->receiver_email); ?> </td>
		      <td> 		   <?php echo esc_attr($row->payment_status); ?> </td>
		     <td> 		   <?php echo esc_attr($row->created_at); ?> </td>
       
                <td>

<?php

// echo $row->payment_status;
if($row->payment_status=='processing'){
    ?>
    <form method="POST" action="" name="escrow_payment" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
	<input type="hidden" name="ecsrow_id" value="<?php echo esc_attr($row->id); ?>" />
<input 
 type="submit" name="submit" value="<?php _e('Approve Payment', 'aistore') ?>"/>
<input type="hidden" name="action" value="escrow_payment" />
                </form>
             
                
                 <form method="POST" action="" name="reject_payment" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
		<input type="hidden" name="reject_ecsrow_id" value="<?php echo esc_attr($row->id); ?>" />
<input 
 type="submit" name="submit" value="<?php _e('Reject Payment', 'aistore') ?>"/>
<input type="hidden" name="action" value="reject_payment" />
                </form>
                   <?php
                   
    
} 
                   
                   if($row->payment_status=='paid' && $row->status=='pending' ){
    ?>
                   
                 <form method="POST" action="" name="remove_escrow_payment" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
		<input type="hidden" name="ecsrow_id" value="<?php echo esc_attr($row->id); ?>" />
<input 
 type="submit" name="submit" value="<?php _e('Remove Payment', 'aistore') ?>"/>
<input type="hidden" name="action" value="remove_escrow_payment" />
                </form>
              
           
    <?php
            
        } 
        
        ?>  
        
        </td>
        </tr>
        
        
        <?php 
endforeach;
?>


</tbody>
    <tfoot>
             <tr>
        <th> <?php _e('Id', 'aistore') ?> </th>
      <th> <?php _e('Title', 'aistore') ?> </th>
    
        <th> <?php _e('Amount', 'aistore') ?> </th>
      <th> <?php _e('Sender', 'aistore') ?>  </th>
       <th> <?php _e('Receiver', 'aistore') ?> </th>  
        <th> <?php _e('Payment Status', 'aistore') ?></th>
       <th> <?php _e('Datet', 'aistore') ?> </th>
       <th> <?php _e('Action', 'aistore') ?> </th>
     </tr>
        </tfoot>
    </table>
    
    </div>
  
    </div>
  
  
	<?php
    }
// }

