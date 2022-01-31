<?php

function aistore_add_subaccount(){
    if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
       if (isset($_POST['submit']) and $_POST['action'] == 'subcategory_system')
        {
            
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
             global $wpdb;
              $user_id = get_current_user_id();
              $account = sanitize_text_field($_REQUEST['account']);
                  $subaccount = sanitize_text_field($_REQUEST['subaccount']);
                $type = sanitize_text_field($_REQUEST['type']);
           
           
           $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));
            
           $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}subaccount ( account,subaccount, type, user_id ,company_id) VALUES (%s ,%s,%s,%s,%s)", array(
            $account,
            $subaccount,
            $type,
            $user_id,
            $company->company_id
           
        )));   
        
}
else{
?>
    
    <form method="POST" action="" name="subcategory_system" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

<?php 
  global $wpdb;
              $user_id = get_current_user_id();
 $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}accounts where user_id=%s ", $user_id));
 
 
        
        
?>
<label for="title"><?php _e('Account', 'aistore'); ?></label><br>
       <select name="account" id="account" >
                <?php
            foreach ($results as $c)
            {

                echo '	<option  value="' . $c->id . '">' . $c->account . '</option>';

            }
?>
           
  
</select><br>

   
         
           
           
  <label for="title"><?php _e('Subaccount', 'aistore'); ?></label><br>
  <input class="input" type="text" id="subaccount" name="subaccount"><br>

        <label for="title"><?php _e('Type', 'aistore'); ?></label><br>
       <select name="type" id="type" >
	<option   value="debit">Debit</option>
	<option  value="credit">Credit</option>


           </select><br>    <br>   
         <input 
 type="submit" class="btn" name="submit" value="<?php _e('Submit', 'aistore') ?>"/>
<input type="hidden" name="action" value="subcategory_system" />
</form>  
<?php
    
}   
    
    
}