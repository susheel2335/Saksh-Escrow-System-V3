<?php

 function aistore_email_page(){
     if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
    
      global $wpdb;
      $customer_id = sanitize_text_field($_REQUEST['customer_id']);
       $invoice_id = sanitize_text_field($_REQUEST['invoice_id']);
        global $wpdb;
    $invoice = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}invoice where id=%s ", $invoice_id));
    
       $customer = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}customer where id=%s ", $customer_id));
       
       if (isset($_POST['submit']) and $_POST['action'] == 'email_system')
        {
            
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
             
             global $wpdb;
              $user_id = get_current_user_id();
              $alternate_email = sanitize_text_field($_REQUEST['alternate_email']);
              $cc = sanitize_text_field($_REQUEST['cc']);
              
              $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}customer
    SET alternate_email = '%s' , cc = '%s'  WHERE id = '%d' and user_id=%s", $alternate_email,$cc,$customer_id,$user_id));
    
     $product = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}product where id=%s ", $invoice->product_id));
     $amount = $invoice->amount;
    $fee =15;
    $total = $amount+$fee;
 $headers = array('Content-Type: text/html; charset=UTF-8');
   $subject = 'Invoice';
   
   $message =' <div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice  # '. $invoice_id.'</h2>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-left">
    				<address>
    				<strong>Billed To:</strong><br>
    				'. $customer->customer_name.'<br>
    					'. $customer->customer_email.'<br>
    			'.$invoice->bill_to.'
    				</address><br>
    			</div>
    			<div class="col-right">
    				<address>
        			<strong>Shipped To:</strong><br>
        				'. $customer->customer_name.'<br>
        				'.$customer->customer_email.'<br>
    				'.$invoice->ship_to.'
    				</address><br>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    				Cash On Delivery<br>
    				'. $customer->customer_email.'<br>
    				</address><br>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong> Date:</strong><br>
    				'.$invoice->created_at.'<br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Description</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Product</strong></td>
        							<td class="text-center"><strong> Price</strong></td>
        							<td class="text-center"><strong> Quantity</strong></td>
        							<td class="text-right"><strong> Total</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    				
    							
    						 
    							<tr>
    								<td>'.$product->name.'</td>
    								<td class="text-center">$
    							'. $invoice->amount.'</td>
    								<td class="text-center">1</td>
    								<td class="text-right">$
    								'. $invoice->amount.'</td>
    							</tr>
          
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">$	
    							'.$invoice->amount.'</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Shipping</strong></td>
    								<td class="no-line text-right">$15</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">$
    								'.$total.'</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>';
     wp_mail($alternate_email, $subject, $message ,$headers  );
     
        
}
else{
?>
    
    <form method="POST" action="" name="email_system" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>


          
           
  <label for="title"><?php _e('Email', 'aistore'); ?></label><br>
  <input class="input" type="text" id="alternate_email" name="alternate_email" value="<?php echo $customer->alternate_email; ?>"><br>


  <label for="title"><?php _e('Cc', 'aistore'); ?></label><br>
  <input class="input" type="text" id="cc" name="cc" value="<?php echo $customer->cc; ?>"><br><br>
 
         <input 
 type="submit" class="btn" name="submit" value="<?php _e('Submit', 'aistore') ?>"/>
<input type="hidden" name="action" value="email_system" />
</form>  
<?php
    
}   
}