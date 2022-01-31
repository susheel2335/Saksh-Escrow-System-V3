<?php


function aistore_add_estimate(){
    
   $user_id = get_current_user_id();
        $user_role = get_user_meta($user_id, 'user_role', true);
    if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
            $editor = array(
                'tinymce' => array(
                    'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright, link,unlink,  ',
                    'toolbar2' => '',
                    'toolbar3' => ''

                ) ,
                'textarea_rows' => 1,
                'teeny' => true,
                'quicktags' => false,
                'media_buttons' => false
            );

?>
    
<h3><?php _e("Add Estimate", "blank"); ?></h3>
<?php
            if (isset($_POST['submit']) and $_POST['action'] == 'product')
            {

                if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
                {
                    return _e('Sorry, your nonce did not verify', 'aistore');

                }
   $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
       

                $ship_to = sanitize_text_field($_REQUEST['ship_to']);
                $amount = intval($_REQUEST['amount']);
                
                $description = sanitize_text_field($_REQUEST['description']);
                $product_id = sanitize_text_field($_REQUEST['product_id']);

                $customer_id = sanitize_text_field($_REQUEST['customer_id']);
                $bill_to = sanitize_text_field($_REQUEST['bill_to']);
                 $currency = sanitize_text_field($_REQUEST['currency']);
                $fee = sanitize_text_field($_REQUEST['fee']);
        
               
 global $wpdb;
$wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}estimate ( ship_to,amount, user_id ,description,product_id,customer_id,bill_to,currency,fee,company_id) VALUES ( %s,%s,%s,%s,%s,%s,%s,%s,%s,%s)", array(
            $ship_to,
            $amount,
            $user_id,
            $description,
            $product_id,
            $customer_id,
            $bill_to,
            $currency,
            $fee,
            $company->$company_id
            
           
        )));   
               


               

                
            }
            else
            {

?>
      <div >
      <form method="POST" action="" name="product" enctype="multipart/form-data"> 
 
<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>


   
    
   <br>      
        <div class="mb-3">   
<label><?php _e('Amount', 'aistore'); ?></label><br/>
  <input class="input" type="text" id="amount" name="amount" required></div><br><br>
    <br>      



   <div class="mb-3">   
<label><?php _e('Fee', 'aistore'); ?></label><br/>
  <input class="input" type="text" id="fee" name="fee" required></div><br><br>
    <br>      
   
    <div class="mb-3">   
<label><?php _e('Currency', 'aistore'); ?></label><br/>
  <select name="currency" id="currency">
<option value="USD">USD </option>
<option value="INR">INR </option>
</select>
 </div><br><br>
    <br> 
   
 



    <div class="mb-3">   
<label><?php _e('Products', 'aistore'); ?></label><br>
  <select name="product_id" id="product_id">
      <?php
        global $wpdb;
      

// $sql = "SELECT * FROM {$wpdb->prefix}product where user_id=".$user_id;

//   $results_product=   $wpdb->get_results($sql);
   $results_product=  getProducts();
                foreach ($results_product as $product)
                {

                    echo ' <option value="' . esc_attr($product->id) . '">' . esc_attr($product->name) . '   </option>';

                }

?>
  </select></div><br><br>
  
  <?php 
   global $wpdb;

// $sql = ($wpdb->prepare("SELECT * FROM {$wpdb->prefix}customer where user_id=%s ", $user_id));
//  $results=   $wpdb->get_results($sql);
    $results= getCustomer();
   ?>
    
    <div class="mb-3">   
<label><?php _e('Customer', 'aistore'); ?></label><br>
  <select name="customer_id" id="customer_id">
      <?php

                foreach ($results as $row)
                {

                    echo ' <option value="' . esc_attr($row->id) . '">' . esc_attr($row->customer_name) . '   </option>';

                }

?>
  </select></div><br><br>



 <br>     <div class="mb-3">   <label><?php _e('Bill To', 'aistore'); ?></label>
 <br/>
   <?php
                $content = '';
                $editor_id = 'bill_to';

                $bill_to = $editor;

                wp_editor($content, $editor_id, $bill_to);

?></div>
 

  
  <br>    <div class="mb-3">   <label><?php _e('Ship To', 'aistore'); ?></label><br/>

   <?php
                $content = '';
                $editor_id = 'ship_to';

                $ship_to = $editor;

                wp_editor($content, $editor_id, $ship_to);

?></div>

 
  <br>    <div class="mb-3">   <label><?php _e('Description', 'aistore'); ?></label><br/>

   <?php
                $content = '';
                $editor_id = 'description';

                $description = $editor;

                wp_editor($content, $editor_id, $description);

?></div>
<br>


  

  
  

  
  <input  type="submit"  name="submit" value="<?php _e('Submit', 'aistore') ?>">
  <input type="hidden" name="action" value="product" />
</form></div>
  </div><br><br>

      <?php
            }
        
}