<?php

// currency need to be dynamic and  when user create entry need to select currency as well



function aistore_invoice_details(){
       $user_id = get_current_user_id();
    $invoice_id = sanitize_text_field($_REQUEST['invoice_id']);
     global $wpdb;
     
      $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id)); 
      
    $invoice = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}invoice where id=%s and company_id=%s ", $invoice_id,$company->company_id));
    
    $customer = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}customer where id=%s ", $invoice->customer_id));
    
 $total=   $invoice->amount + $invoice->fee ;  
    ?>
  
  <div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice  # <?php echo $invoice_id; ?></h2>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-left">
    				<address>
    				<strong>Billed To:</strong><br>
    					<?php echo $customer->customer_name; ?><br>
    						<?php echo $customer->customer_email; ?><br>
    				<?php echo $invoice->bill_to; ?>
    				</address><br>
    			</div>
    			<div class="col-right">
    				<address>
        			<strong>Shipped To:</strong><br>
        				<?php echo $customer->customer_name; ?><br>
        					<?php echo $customer->customer_email; ?><br>
    					<?php echo $invoice->ship_to; ?>
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
    					<?php echo $invoice->created_at; ?><br><br>
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
    						  $product = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}product where id=%s ", $invoice->product_id));
    							?>
    							<tr>
    								<td><?php echo esc_attr($product->name); ?></td>
    								<td class="text-center">	<?php echo $invoice->currency." " .$invoice->amount; ?></td>
    								<td class="text-center">1</td>
    								<td class="text-right">	<?php echo $invoice->currency." " .$invoice->amount; ?></td>
    							</tr>
        
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">	<?php echo $invoice->currency." " .$invoice->amount; ?></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Shipping</strong></td>
    								<td class="no-line text-right">	<?php echo $invoice->currency." " .$invoice->fee; ?></td>
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
