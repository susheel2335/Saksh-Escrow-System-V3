<?php

// currency need to be dynamic and  when user create entry need to select currency as well



function aistore_estimate_details(){
          $user_id = get_current_user_id();
    $estimate_id = sanitize_text_field($_REQUEST['estimate_id']);
     global $wpdb;
     
        $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
        
    $estimate = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}estimate where id=%s and user_id=%s and company_id= %s", $estimate_id,$user_id,$company->company_id));
    
      $customer = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}customer where id=%s and user_id=%s ", $estimate->customer_id,$user_id));
      
       $total=   $estimate->amount + $estimate->fee ;  
       
    ?>
  
  <div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Estimate  # <?php echo $estimate_id; ?></h2>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-left">
    				<address>
    				<strong>Billed To:</strong><br>
    					<?php echo $customer->customer_name; ?><br>
    						<?php echo $customer->customer_email; ?><br>
    				<?php echo $estimate->bill_to; ?>
    				</address><br>
    			</div>
    			<div class="col-right">
    				<address>
        			<strong>Shipped To:</strong><br>
        				<?php echo $customer->customer_name; ?><br>
        					<?php echo $customer->customer_email; ?><br>
    					<?php echo $estimate->ship_to; ?>
    				</address><br>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    				Cash On Delivery<br>
    					<?php echo $customer->customer_email; ?><br>
    				</address><br>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong> Date:</strong><br>
    					<?php echo $estimate->created_at; ?><br><br>
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
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
    							
    							<?php 
    					
    							
    							    $product = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}product where id=%s and user_id=%s ", $estimate->product_id,$user_id));
    							?>
    							<tr>
    								<td><?php echo esc_attr($product->name); ?></td>
    								<td class="text-center">	<?php echo $estimate->currency." ". $estimate->amount; ?></td>
    								<td class="text-center">1</td>
    								<td class="text-right">	<?php echo $estimate->currency." ". $estimate->amount; ?></td>
    							</tr>
         
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">	<?php echo $estimate->currency." ". $estimate->amount; ?></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Shipping</strong></td>
    								<td class="no-line text-right">	<?php echo $estimate->currency." ". $estimate->fee; ?></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">	<?php echo $total; ?></td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
    <?php
}
?>
