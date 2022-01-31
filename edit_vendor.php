<?php

function aistore_edit_vendor(){
    if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
    
     global $wpdb;
      $vendor_id = sanitize_text_field($_REQUEST['vendor_id']);
        $user_id = get_current_user_id();
       $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
       
       $vendor = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}vendor where id=%s and user_id=%s and company_id=%s ", $vendor_id,$user_id,$company->company_id));
       
       if (isset($_POST['submit']) and $_POST['action'] == 'vendor_system')
        {
            
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
             
             global $wpdb;
              $user_id = get_current_user_id();
              $vendor_name = sanitize_text_field($_REQUEST['vendor_name']);
              $vendor_email = sanitize_text_field($_REQUEST['vendor_email']);
            // $type = sanitize_text_field($_REQUEST['type']);
            
             $vendor_type = sanitize_text_field($_REQUEST['vendor_type']);
             $mobile_no = sanitize_text_field($_REQUEST['mobile_no']);
              
              $first_name = sanitize_text_field($_REQUEST['first_name']);
             $last_name = sanitize_text_field($_REQUEST['last_name']);
             
             
            $country = sanitize_text_field($_REQUEST['country']);
             $address = sanitize_text_field($_REQUEST['address']);
              
              $city = sanitize_text_field($_REQUEST['city']);
             $state = sanitize_text_field($_REQUEST['state']);
             
            $zip_code = sanitize_text_field($_REQUEST['zip_code']);
            
            $pan_number = sanitize_text_field($_REQUEST['pan_number']);
            $gst_number = sanitize_text_field($_REQUEST['gst_number']);
            
        
         $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}vendor
    SET vendor_name = '%s', vendor_email = '%s', vendor_type =%s,mobile_no=%s,first_name=%s,last_name=%s,country=%s,address=%s,city=%s,state=%s ,
    zip_code=%s, pan_number =%s, gst_number=%s WHERE id = '%d' and user_id=%s", $vendor_name,$vendor_email,$vendor_type,$mobile_no,$first_name,$last_name,$country,$address,$city,$state,$zip_code,$pan_number,$gst_number,$vendor_id,$user_id));
        
}
else{
?>
    
    <form method="POST" action="" name="vendor_system" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

<?php 
//   global $wpdb;
//               $user_id = get_current_user_id();
//  $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}category where user_id=%s ", $user_id));
 

?>
<label for="title"><?php _e('Vendor Type', 'aistore'); ?></label><br>

 <input type="radio" id="Business" name="vendor_type" value="Business">
<label for="Business">Business</label><br>
<input type="radio" id="Individual" name="vendor_type" value="Individual">
<label for="Individual">Individual</label><br><br>
 
           
  <label for="title"><?php _e('Name', 'aistore'); ?></label><br>
  <input class="input" type="text" id="vendor_name" name="vendor_name" value="<?php echo $vendor->vendor_name;?>"><br>


  <label for="title"><?php _e('Email', 'aistore'); ?></label><br>
  <input class="input" type="text" id="vendor_email" name="vendor_email" value="<?php echo $vendor->vendor_email;?>"><br><br>
 
  
  <label for="title"><?php _e('First Name', 'aistore'); ?></label><br>
  <input class="input" type="text" id="first_name" name="first_name"><br><br>
   
  <label for="title"><?php _e('Last Name', 'aistore'); ?></label><br>
  <input class="input" type="text" id="last_name" name="last_name"><br><br>
  
    <label for="title"><?php _e('Mobile', 'aistore'); ?></label><br>
  <input class="input" type="text" id="mobile_no" name="mobile_no"><br><br>
  
   <label for="country"><?php _e('Country', 'aistore'); ?></label><br>
  <select name="country" id="country">
  <option value="India">India</option>
  <option value="UK">UK</option>
  </select><br><br>
  
     <label for="country"><?php _e('Address', 'aistore'); ?></label><br>
  <textarea id="address" name="address" rows="3" cols="40">
Street
</textarea>
  
  
  
   <label for="city"><?php _e('City', 'aistore'); ?></label><br>
  <input class="input" type="text" id="city" name="city"><br><br>
   
  <label for="state"><?php _e('State', 'aistore'); ?></label><br>
  <input class="input" type="text" id="state" name="state"><br><br>
  
  <label for="zip_code"><?php _e('Zip code', 'aistore'); ?></label><br>
  <input class="input" type="text" id="zip_code" name="zip_code"><br><br>
  
    <label for="pan_number"><?php _e('PAN Number' , 'aistore'); ?></label><br>
  <input class="input" type="text" id="pan_number" name="pan_number"><br><br>
  
  <label for="gst_number"><?php _e('GST Number' , 'aistore'); ?></label><br>
  <input class="input" type="text" id="gst_number" name="gst_number"><br><br>
  
  

         <input 
 type="submit" class="btn" name="submit" value="<?php _e('Submit', 'aistore') ?>"/>
<input type="hidden" name="action" value="vendor_system" />
</form>  
<?php
    
}   
    
    
}