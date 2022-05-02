<?php


	global $wpdb;
           	
           	        $escrow_admin_user_id = get_option('escrow_user_id');
           	        
     	$sql = "SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions  INNER JOIN {$wpdb->prefix}users ON  {$wpdb->prefix}aistore_wallet_transactions.user_id={$wpdb->prefix}users.ID WHERE {$wpdb->prefix}users.ID= ".$escrow_admin_user_id." order by aistore_wallet_transactions.id desc ";
     	
     echo $sql;
     	
     	 $results = $wpdb->get_results($sql);
           ?>
       <h1> <?php _e('Escrow Admin Report', 'aistore') ?> </h1>
   
   <?php echo AistoregetSupportMsg(); ?>
   
    

            <?php
            
  
        if ($results == null)
        {
            _e("No transactions Found", 'aistore');

        }
        else
        {
            ?>
            
  <table  id="example" class="widefat striped fixed" style="width:100%">
        <thead>
            <tr>
                   <th><?php _e('ID', 'aistore'); ?></th>
      
		    <th><?php _e('Email', 'aistore'); ?></th>
          <th><?php _e('Balance', 'aistore'); ?></th> 
		  
	    <th><?php _e('Amount', 'aistore'); ?></th> 
	    <th><?php _e('Type', 'aistore'); ?></th> 
	    <th><?php _e('Description', 'aistore'); ?></th> 
	      <th><?php _e('Date', 'aistore'); ?></th> 
            </tr>
            
        </thead>
        
        <tbody>
            <?php
             foreach ($results as $row):
             
?>
            <tr>
            	   <td>  <?php echo esc_attr($row->transaction_id); ?></td>
	
		  
		   
		   <td> 		   <?php echo esc_attr($row->user_email); ?> </td>
		  
		   <td> 		   <?php echo esc_attr($row->balance); ?> </td>
		   
		   <td> 		   <?php echo esc_attr($row->amount." ".$row->currency); ?> </td>
		   
		  <td> 		   <?php echo esc_attr($row->type); ?> </td>
		  
		   <td> 		   <?php echo esc_attr($row->description); ?> </td>
		   
		   	   <td> 		   <?php echo esc_attr($row->date); ?> </td>
		   </tr>
		   <?php
            endforeach;
        ?>
    
        </tbody>
        
       
        
        <tfoot>
            <tr>
         <th><?php _e('ID', 'aistore'); ?></th>
        <th><?php _e('Username', 'aistore'); ?></th>
		    <th><?php _e('Email', 'aistore'); ?></th>
          <th><?php _e('Balance', 'aistore'); ?></th> 
          	  
	    <th><?php _e('Amount', 'aistore'); ?></th> 
	    <th><?php _e('Type', 'aistore'); ?></th> 
	    <th><?php _e('Description', 'aistore'); ?></th> 
            </tr>
        </tfoot>
    </table>
    
       <?php } ?>
      
