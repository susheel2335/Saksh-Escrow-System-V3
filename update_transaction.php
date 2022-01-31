<?php

function aistore_update_transaction(){
       global $wpdb;
       $user_id = get_current_user_id();
       
      $transaction_id = sanitize_text_field($_REQUEST['transaction_id']);
      $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id)); 
      
       $transaction = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions where transaction_id=%s and created_by=%s and company_id=%s", $transaction_id,$user_id,$company->company_id));
       
    if (isset($_POST['submit']) and $_POST['action'] == 'transaction_system')
        {
            
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }

            $account = sanitize_text_field($_REQUEST['account']);
         $vendor = sanitize_text_field($_REQUEST['vendor_name']);
            $date = sanitize_text_field($_REQUEST['date']);
            $amount = sanitize_text_field($_REQUEST['amount']);
            $reference = sanitize_text_field($_REQUEST['reference']);
           
            $description = sanitize_text_field($_REQUEST['description']);
            $tags = sanitize_text_field($_REQUEST['tags']);
            
            if($transaction->type=='debit'){
             $expense_account = sanitize_text_field($_REQUEST['expense_account']);
          
            
 $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}aistore_wallet_transactions
    SET account = '%s', tags = '%s' ,date='%s'  ,description= '%s',expense_account  = '%s' ,vendor  = '%s' , reference = '%s' ,status='Completed' WHERE transaction_id = '%d' and created_by='%d' and company_id=%s", $account,$tags,$date,$description,$expense_account,$vendor,$reference,$transaction_id,$user_id,$company->company_id));
            }
     if($transaction->type=='credit'){
   $from_account = sanitize_text_field($_REQUEST['from_account']);
    $received_via = sanitize_text_field($_REQUEST['received_via']);
    
     
       $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}aistore_wallet_transactions
    SET account = '%s', from_account  = '%s' , tags = '%s' ,date='%s' ,received_via ='%s' , reference = '%s' ,description= '%s' ,vendor  = '%s',status='Completed' WHERE transaction_id = '%d' and created_by='%d' and company_id=%s", $account,$from_account,$tags,$date,$received_via,$reference,$description,$vendor,$transaction_id,$user_id,$company->company_id));
     }
        }
        
        else{
            
 
  
        
    
    //  print_r($transaction);
     
    ?>
    
      
    <form method="POST" action="" name="transaction_system" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

<?php 
if( $transaction->type == 'credit'){

  global $wpdb;
         $results=getAccountCredit();       
//  $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}category where user_id=%s and type='credit'", $user_id));
        
?>
<label for="title"><?php _e('Accounts', 'aistore'); ?></label><br>
       <select name="account" id="account" >
                <?php
            foreach ($results as $c)
            {
    if ($c->account == $transaction->account)
            {
                echo '	<option selected value="' . $c->account . '">' . $c->category . '</option>';

            }
            else
            {

                echo '	<option value="' . $c->account . '">' . $c->account . '</option>';

            }
        } ?> 
              
</select><br>
<?php
global $wpdb;
           $results=getSubaccountCredit();      
//  $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}subcategory where user_id=%s and type='credit'", $user_id));
        
?>
<label for="title"><?php _e('From Account', 'aistore'); ?></label><br>
       <select name="from_account" id="from_account" >
                <?php
            foreach ($results as $c)
            {
 if ($c->subaccount == $transaction->from_account)
            {
                echo '	<option selected value="' . $c->subaccount . '">' . $c->subaccount . '</option>';
            }
            else
            {

                echo '	<option value="' . $c->subaccount . '">' . $c->subaccount . '</option>';
            }
            
            }
?>
           
  
</select><br>

        
<?php } ?>  


<?php 
if( $transaction->type == 'debit'){


 global $wpdb;
      $results=getAccountDebit();   
//  $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}category where user_id=%s and type='debit'", $user_id));
        
?>
<label for="title"><?php _e('Account', 'aistore'); ?></label><br>
       <select name="account" id="account" >
                <?php
            foreach ($results as $c)
            {

               if ($c->account == $transaction->account)
            {
                echo '	<option selected value="' . $c->account . '">' . $c->account . '</option>';
            }
            else
            {

                echo '	<option value="' . $c->account . '">' . $c->account . '</option>';
            }
                }
?>

           </select><br>        
       
       
       
       <?php
global $wpdb;
   $results=getSubaccountDebit();   
//  $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}subcategory where user_id=%s and type='debit'", $user_id));
        
?>
<label for="title"><?php _e('Expense Account', 'aistore'); ?></label><br>
       <select name="expense_account" id="expense_account" >
                <?php
            foreach ($results as $c)
            {

   if ($c->subaccount == $transaction->expense_account)
            {
                echo '	<option selected value="' . $c->subaccount . '">' . $c->subaccount . '</option>';
            }
            else
            {
                echo '	<option value="' . $c->subaccount . '">' . $c->subaccount . '</option>';
            }
               

            }
?>
</select><br>
  <!--         <label for="title"><?php _e('Vendor', 'aistore'); ?></label><br>-->
  <!--<input class="input" type="text" id="vendor" name="vendor" value="<?php echo $transaction->vendor; ?>"><br>-->
<?php } ?>          
          
          
   <label for="title"><?php _e('Date', 'aistore'); ?></label><br>
  <input class="input" type="text" id="date" name="date" value="<?php echo $transaction->date; ?>"><br>
  
  
     <label for="title"><?php _e('Amount', 'aistore'); ?></label><br>
      <input class="input" type="text" readonly="true" id="amount" name="amount" value="<?php echo $transaction->amount." ". $transaction->currency; ?>"><br>
  
          <?php 
if( $transaction->type == 'credit'){
?>
             
<label for="title"><?php _e('Received Via', 'aistore'); ?></label><br>
<select name="received_via" id="received_via" >
    
 <option selected value="<?php echo $transaction->received_via; ?>">	<?php echo $transaction->received_via; ?></option>
<option  value="Cash">Cash</option>
           </select><br>     

  <?php } ?>
  
  
             
<label for="title"><?php _e('Reference', 'aistore'); ?></label><br>
  <input class="input" type="text" id="reference" name="reference" value="<?php echo $transaction->reference; ?>"><br>
  
  
   <label for="term_condition"> <?php _e('Description', 'aistore') ?></label><br>
 
  <?php
            $content =  $transaction->description;
            $editor_id = 'description';

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

 global $wpdb;
             
//  $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}vendor where user_id=%s ", $user_id));
        
       $results= getVendors();
?>
<label for="title"><?php _e('Vendor', 'aistore'); ?></label><br>
       <select name="vendor_name" id="vendor_name" >
                <?php
            foreach ($results as $c)
            {
    if ($c->vendor_name == $transaction->category)
            {
                echo '	<option selected value="' . $c->vendor_name . '">' . $c->vendor_name . '</option>';

            }
            else
            {

                echo '	<option value="' . $c->vendor_name . '">' . $c->vendor_name . '</option>';

            }
        } ?> 
              
</select><br>

           
<label for="title"><?php _e('Reporting Tags', 'aistore'); ?></label><br>
  <input class="input" type="text" id="tags" name="tags" value="<?php echo $transaction->tags; ?>"><br><br>
  
  
  <input 
 type="submit" class="btn" name="submit" value="<?php _e('Update', 'aistore') ?>"/>
<input type="hidden" name="action" value="transaction_system" />
</form>
  <?php
}
}