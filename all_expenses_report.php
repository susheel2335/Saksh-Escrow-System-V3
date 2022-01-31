<?php 


// add user when fetch data 


function aistore_all_expenses_report(){
   if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
    
 global $wpdb;
    $user_id = get_current_user_id();
    
      $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));
      
 $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions where type='debit' and created_by=%s and company_id=%s group by account order by transaction_id desc", $user_id,$company->company_id));
 
 
//  $sql = "SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions where type='debit' and created_by = %s group by category order by transaction_id desc",$user_id;

//   $results=   $wpdb->get_results($sql);


?></div>

<?php
        if ($results == null)
        {
            echo "<div class='no-result'>";

            _e('Expenses List Not Found', 'aistore');
            echo "</div>";
        }
        else
        {

            ob_start();

?>
  
    <table class="table">
     
        <tr>
      
    <th><?php _e('ID', 'aistore'); ?></th>

   
        <th><?php _e('Account', 'aistore'); ?></th>
         <th><?php _e('Subaccount', 'aistore'); ?></th>
          <th><?php _e('Amount', 'aistore'); ?></th> 
 
		  <th><?php _e('Vendor', 'aistore'); ?></th>
		  
		   <th><?php _e('Reference Number', 'aistore'); ?></th> 
		        <th><?php _e('Status', 'aistore'); ?></th> 
		    <th><?php _e('Date', 'aistore'); ?></th> 
		
		    

		 
</tr>

    <?php
            foreach ($results as $row):
    
  $details_transaction_page_id_url = esc_url(add_query_arg(array(
                  'page_id' =>get_option('aistore_update_transaction') ,
                    'transaction_id' => $row->transaction_id,
                ) , home_url()));
?>    <tr>
          
		   <td>   <?php echo $row->transaction_id; ?> </td>
		 
  <td> 	   <?php echo $row->account; ?> </td>
    <td> 	
 
   <?php echo $row->expense_account ?>
		  </td>
		   
		  	   <td> 		   <?php echo $row->amount." ".$row->currency ?>  </td>
		  
		    <td> 		   <?php echo $row->vendor; ?> </td>
		     <td> 		   <?php echo $row->reference; ?> </td>
		     	     <td> 		   <?php echo $row->status; ?> </td>
 <td> 		   <?php echo $row->date; ?> </td>
 
            </tr>
    <?php
            endforeach;

        } ?>

    </table>
	
    <?php

}