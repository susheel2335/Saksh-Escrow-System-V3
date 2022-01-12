<?php

     $wallet = new AistoreWallet();
      $pages = get_pages(); 
    
       
if(isset($_POST['submit']) and $_POST['action']=='deposit_type' )
{

if ( ! isset( $_POST['aistore_nonce'] ) 
    || ! wp_verify_nonce( $_POST['aistore_nonce'], 'aistore_nonce_action' ) 
) {
   return  _e( 'Sorry, your nonce did not verify.', 'aistore' );

   exit;
}

 
 $amount= sanitize_text_field($_POST['amount']);
 $type= sanitize_text_field($_POST['type']);
  $currency= sanitize_text_field($_POST['currency']);
   $description= sanitize_text_field($_POST['description']);

   $user_id=sanitize_text_field($_POST['user_id']);
 //  echo $user_id;
   if ($user_id==0 ){
return _e( 'Please select an user.', 'aistore' );
}
   
     $current_user_id=get_current_user_id();
     
if($type=='debit'){
 $res=$wallet->aistore_credit($current_user_id, $amount, $currency, $description,$current_user_id);
 $res=$wallet->aistore_debit($user_id, $amount, $currency, $description,$user_id);
}

else{
  $res=$wallet->aistore_credit($user_id, $amount, $currency, $description,$user_id);
   $res=$wallet->aistore_debit($current_user_id, $amount, $currency, $description,$current_user_id);
}




 $wallet = new AistoreWallet();
        $results = $wallet->aistore_wallet_transaction_history($user_id);

?>

<?php
        if ($results == null)
        {
            echo "<div class='no-result'>";

           // _e('Transactions List Not Found', 'aistore');
            echo "</div>";
        }
        else
        {

            ob_start();

?>

    
          
<h3><?php  _e( 'Transaction Report', 'aistore' ) ?></h3>

  <table  id="example" class="display nowrap" style="width:100%">
         <thead>
        <tr>
      
    <th><?php _e('ID', 'aistore'); ?></th>
        <th><?php _e('Reference Id', 'aistore'); ?></th>
        <th><?php _e('Type', 'aistore'); ?></th>
         <th><?php _e('Balance', 'aistore'); ?></th>
          <th><?php _e('Amount', 'aistore'); ?></th> 
 
		  <th><?php _e('Currency', 'aistore'); ?></th>
		   <th><?php _e('Description', 'aistore'); ?></th> 
		    <th><?php _e('Date', 'aistore'); ?></th> 
		    

		 
</tr>
  </thead>
  <tbody>
    <?php
            foreach ($results as $row):

?>    <tr>
          
		   <td>   <?php echo esc_attr($row->transaction_id); ?> </td>
		    <td>   <?php echo esc_attr($row->reference); ?> </td>
  <td> 	   <?php echo esc_attr($row->type); ?> </td>
    <td> 	
 
   <?php echo esc_attr($row->balance) ?>
		  </td>
		   
		  	   <td> 		   <?php echo esc_attr($row->amount) ?>  </td>
		  
		    <td> 		   <?php echo esc_attr($row->currency); ?> </td>
		     <td> 		   <?php echo esc_attr($row->description); ?> </td>
 <td> 		   <?php echo esc_attr($row->date); ?> </td>
            </tr>
    <?php
            endforeach;

        } ?>

</tbody>
    </table>
	
	
	<?php
}
else{
    
   
?>
      
<h3><?php  _e( 'Debit/ Credit', 'aistore' ) ?></h3>

 <form method="POST" action="" name="deposit_type" enctype="multipart/form-data"> 
    <?php wp_nonce_field( 'aistore_nonce_action', 'aistore_nonce' ); ?>
    


<?php 
     $user_id=get_current_user_id();
      $currency="USD";

    $balance = $wallet->aistore_balance($user_id, $currency);
 
if (isset($_REQUEST['id']))
        {
$id=sanitize_text_field($_REQUEST['id']);
}
else{
    $id=0;
}
// printf(__( 'Account Balance %s.', 'aistore'),$balance); 


 ?>
  <table class="form-table">
      	 <tr valign="top">  <th scope="row">
  <label><?php _e( 'Users:', 'aistore' ) ;?></label></th>
  <td>
	<select name="user_id" >
		 
		 
		  <option selected value="0">Selected User</option>
		  <?php
        $blogusers = get_users();

        foreach ($blogusers as $user)
        {
                echo '	<option  value="' . $user->ID . '">' . $user->display_name . '</option>';
        } ?> 
 
</select></td></tr><br><br>


	 <tr valign="top">  <th scope="row">
  <label><?php _e( 'Account Type:', 'aistore' ) ;?></label></th>
  <td>
<select name="type" id="type">
  <option value="debit"><?php _e( 'Debit', 'aistore' ) ;?></option>
  <option value="credit"><?php _e( 'Credit', 'aistore' ) ;?></option>

</select></td></tr><br><br>



 <tr valign="top">  <th scope="row">
  <label><?php _e( 'Currency:', 'aistore' ) ;?></label></th>

<td>
<select name="currency" id="currency">
    
     <?php
            global $wpdb;
            $wallet = new AistoreWallet();
        $results = $wallet->aistore_wallet_currency();
    
            foreach ($results as $c)
            {

                echo '	<option  value="' . $c->symbol . '">' . $c->currency . '</option>';

            }
?>
           
  
</select></td><br><br>


 <tr valign="top">  <th scope="row">
  <label><?php _e( 'Amount:', 'aistore' ) ;?></label></th>

<td><input class="input" type="text" name="amount" /></td></tr><br><br>

 <tr valign="top">  <th scope="row">
  <label><?php _e( 'Description:', 'aistore' ) ;?></label></th>
  

<td>
<textarea id="description" name="description" rows="4" cols="30">
</textarea></td></tr> <br><br>

<tr>
<td>

<input class="input" type="submit" name="submit" value="<?php  _e( 'Submit', 'aistore' ) ?>"/>
<input type="hidden" name="action"  value="deposit_type"/>
</tr></td>
 </table>
    </form>
   
<?php
}


?>


 <?php
     
