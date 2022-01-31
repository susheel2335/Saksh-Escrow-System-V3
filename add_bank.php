<?php

function aistore_add_bank(){
    
    if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
       if (isset($_POST['submit']) and $_POST['action'] == 'bank_system')
        {
            
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
               global $wpdb;
               $user_id = get_current_user_id();
            $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));
                  
              $bank_name = sanitize_text_field($_REQUEST['bank_name']);
              $ifsc_code = sanitize_text_field($_REQUEST['ifsc_code']);
              $branch_name = sanitize_text_field($_REQUEST['branch_name']);
            
             $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}bank ( bank_name, ifsc_code, branch_name,user_id,company_id ) VALUES (%s ,%s,%s,%s,%s)", array(
            $bank_name,
            $ifsc_code,
            $branch_name,
            $user_id,
            $company->company_id
           
        )));

           
}
else{
?>
    
    <form method="POST" action="" name="bank_system" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

  <label for="title"><?php _e('Bank Name', 'aistore'); ?></label><br>
  <input class="input" type="text" id="bank_name" name="bank_name"><br>

  <label for="title"><?php _e('IFSC Code', 'aistore'); ?></label><br>
  <input class="input" type="text" id="ifsc_code" name="ifsc_code"><br>
  
  <label for="title"><?php _e('Branch Name', 'aistore'); ?></label><br>
  <input class="input" type="text" id="branch_name" name="branch_name"><br>
  
  <br>
         <input 
 type="submit" class="btn" name="submit" value="<?php _e('Submit', 'aistore') ?>"/>
<input type="hidden" name="action" value="bank_system" />
</form>  
<?php
    
}   
    
    
}