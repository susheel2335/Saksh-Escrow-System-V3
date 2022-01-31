<?php
  // transaction List
  function aistore_transaction_history()
    {
if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
    
    
 global $wpdb;
    $user_id = get_current_user_id();
     $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id)); 
     
 $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions where created_by=%s and company_id=%s order by transaction_id desc", $user_id,$company->company_id));
 
//  $sql = "SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions  order by transaction_id desc";

//   $results=   $wpdb->get_results($sql);


?></div>
<h3><u><?php _e('Transactions', 'aistore'); ?></u> </h3>
<?php
        if ($results == null)
        {
            echo "<div class='no-result'>";

            _e('Transactions List Not Found', 'aistore');
            echo "</div>";
        }
        else
        {

            ob_start();

?>
  
    <table class="table">
     
        <tr>
      
    <th><?php _e('ID', 'aistore'); ?></th>

   
        <th><?php _e('Type', 'aistore'); ?></th>
         <th><?php _e('Balance', 'aistore'); ?></th>
          <th><?php _e('Amount', 'aistore'); ?></th> 
 
		  <th><?php _e('Currency', 'aistore'); ?></th>
		  
		   <th><?php _e('Description', 'aistore'); ?></th> 
		    <th><?php _e('Date', 'aistore'); ?></th> 
		     <th><?php _e('Action', 'aistore'); ?></th> 
		    

		 
</tr>

    <?php
            foreach ($results as $row):
    
  $details_transaction_page_id_url = esc_url(add_query_arg(array(
                     'page_id' =>get_option('aistore_update_transaction') ,
                    'transaction_id' => $row->transaction_id,
                ) , home_url()));
?>    <tr>
          
		   <td>   <?php echo $row->transaction_id; ?> </td>
		 
  <td> 	   <?php echo $row->type; ?> </td>
    <td> 	
 
   <?php echo $row->balance ?>
		  </td>
		   
		  	   <td> 		   <?php echo $row->amount ?>  </td>
		  
		    <td> 		   <?php echo $row->currency; ?> </td>
		     <td> 		   <?php echo $row->description; ?> </td>
 <td> 		   <?php echo $row->date; ?> </td>
   <td> 	<a href="<?php echo esc_url($details_transaction_page_id_url); ?>" >Update </a> </td>
            </tr>
    <?php
            endforeach;

        } ?>

    </table>
	
    <?php

    }