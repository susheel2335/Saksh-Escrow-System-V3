<?php


  add_action('Aistoreuserbank_details', 'userbank_details' ); 
    
    
    function userbank_details(){
// echo "SD";
// ob_start();
    
    $user_id=get_current_user_id();

   
      $user = get_user_by( 'id', $user_id);

$lock_bank_details=get_the_author_meta('lock_bank_details', $user->ID);

 


if($lock_bank_details==1 )
{
    
 ?>
    
    
<label for="user_bank_details"><?php _e("Bank Account Details"); ?></label><br>
        
        
 <?php echo esc_attr(get_the_author_meta('user_bank_detail', $user->ID)); ?>
  
  
         
          
            
            <br>
            
      <label for="bank_account"><?php _e("Deposit Instructions"); ?></label><br>
        
     
 <?php echo esc_attr(get_the_author_meta('user_deposit_instruction', $user->ID)); ?>
   
   
  
  <?php 
  return "";
  
}
   
   
     if(isset($_POST['submit']) and $_POST['action']=='bank_account_details' )
{

if ( ! isset( $_POST['aistore_nonce'] ) 
    || ! wp_verify_nonce( $_POST['aistore_nonce'], 'aistore_nonce_action' ) 
) {
   return  _e( 'Sorry, your nonce did not verify', 'aistore' );
   exit;
} 


    
   // echo sanitize_text_field($_POST['user_bank_detail']);
 update_user_meta( $user_id, 'user_bank_detail', sanitize_text_field($_POST['user_bank_detail']) );
 update_user_meta( $user_id, 'user_deposit_instruction', sanitize_text_field($_POST['user_deposit_instruction']) );


if(isset($_POST['lock_bank_details']) && 
   $_POST['lock_bank_details'] == '1') 
{
      update_user_meta( $user_id, 'lock_bank_details', 1 );
}
else
{
       update_user_meta( $user_id, 'lock_bank_details', 0);
}	 
    
}
   

    

      


    ?>
 

 <form method="POST" action="" name="bank_account_details" enctype="multipart/form-data"> 

<?php wp_nonce_field( 'aistore_nonce_action', 'aistore_nonce' ); ?>




<label for="user_bank_details"><?php _e("Bank Account Details"); ?></label><br>
        
        
         
<textarea id="user_bank_detail" name="user_bank_detail" rows="2" cols="50">
<?php echo esc_attr(get_the_author_meta('user_bank_detail', $user->ID)); ?>
</textarea>
  <br />
            
  
  
         
          
            
            <br>
            
      <label for="bank_account"><?php _e("Deposit Instructions"); ?></label><br>
        
     

<textarea id="user_deposit_instruction" name="user_deposit_instruction" rows="2" cols="50" >
<?php echo esc_attr(get_the_author_meta('user_deposit_instruction', $user->ID)); ?>
</textarea><br />
            
   
   
  
<input type="checkbox"  name="lock_bank_details" value="1">


<label for="lock_bank_details"> <?php _e( 'Lock Bank Details', 'aistore' ); ?> </label><br><br>
    
   
   <input 
 type="submit"  name="submit" value="<?php  _e( 'Submit', 'aistore' ) ?>"/>
 
 
<input type="hidden" name="action" value="bank_account_details" />

 

    </form>
    
    
    
<?php

//  return ob_get_clean();
 
 }