<?php

function aistore_add_account(){
    
    if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
      

       if (isset($_POST['submit']) and $_POST['action'] == 'transaction_system')
        {
            
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
               global $wpdb;
               $user_id = get_current_user_id();
                $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));
                  
             $account = sanitize_text_field($_REQUEST['account']);
            $type = sanitize_text_field($_REQUEST['type']);
            
             $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}accounts ( account, type, user_id,company_id ) VALUES (%s ,%s,%s,%s)", array(
            $account,
            $type,
            $user_id,
            $company->company_id
           
        )));

           
}
else{
?>
    
    <form method="POST" action="" name="transaction_system" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

  <label for="title"><?php _e('Account', 'aistore'); ?></label><br>
  <input class="input" type="text" id="account" name="account"><br>

        <label for="title"><?php _e('Type', 'aistore'); ?></label><br>
       <select name="type" id="type" >
	<option   value="debit">Debit</option>
	<option  value="credit">Credit</option>


           </select><br>    <br>   
         <input 
 type="submit" class="btn" name="submit" value="<?php _e('Submit', 'aistore') ?>"/>
<input type="hidden" name="action" value="transaction_system" />
</form>  
<?php
    
}   
    
    
}