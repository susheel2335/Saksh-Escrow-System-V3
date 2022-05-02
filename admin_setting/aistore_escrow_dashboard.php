
<?php 

// function aistore_escrow_dashboard()

// {
    
    // echo "Fds";
    
  $wallet = new AistoreWallet();
 $user_id = get_current_user_id();
                     
 $escrow_user_id = get_option( 'escrow_user_id');
 
 
     $currencies = $wallet->aistore_wallet_currency();
    
            foreach ($currencies as $c)
            {
     $currency=$c->currency;
$balance = $wallet->aistore_balance($user_id, $currency);
$escrow_user_id_balance = $wallet->aistore_balance($escrow_user_id, $currency);


        
            }        

            
$users = get_users( );

echo  AistoregetSupportMsg() ;

 
        if ($users === null)
        {
            _e("No User Found", 'aistore');

        }
        else
        {
            
    
?>
    <h1> <?php _e('User List', 'aistore') ?> </h1>
<table id="example5" class="widefat striped fixed"  >
        <thead>
            <tr>
                   <th><?php _e('ID', 'aistore'); ?></th>
        <th><?php _e('Username', 'aistore'); ?></th>
		    <th><?php _e('Email', 'aistore'); ?></th>
          <th><?php _e('Balance', 'aistore'); ?></th> 
		  
	  
            </tr>
            
        </thead>
        
        <tbody>
            <?php
               $currencies = $wallet->aistore_wallet_currency();
               
               
            
  $i=0;
             foreach ($users as $row):
               //  print_r($users);
      $i++;         
      
     
       $bal="";
            foreach ($currencies as $c)
            {
     $currency=$c->currency;
 
    
       
  $balance = $wallet->aistore_balance($row->ID, $currency);
  
 if($balance <>  0 )
$bal .=  esc_attr($balance) ." ".$currency."<br />"; 

 
  }
  
  if(strlen($bal) >0 )
  {
  ?>
            <tr>
            	   <td>  <?php echo esc_attr($row->ID); ?></td>
		  		   <td> 		   <?php echo esc_attr($row->user_login); ?> </td>
		  
		   
		   <td> 		   <?php echo esc_attr($row->user_email); ?> </td>
		
		  <td>  <?php echo $bal; ?>
      </td>
		   
		 
		   </tr>
		   
		   <?php 
		   
  }
  
  
 // if($i>15) break;
        
            endforeach;
        ?>
    
        </tbody>
        
      
        
        <tfoot>
            <tr>
         <th><?php _e('ID', 'aistore'); ?></th>
        <th><?php _e('Username', 'aistore'); ?></th>
		    <th><?php _e('Email', 'aistore'); ?></th>
          <th><?php _e('Balance', 'aistore'); ?></th> 
            </tr>
        </tfoot>
    </table>
      <?php } ?>
    <br><br>
    
    
   
     <?php
      
 global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}escrow_system order by id desc limit 5");
      if ($results == null)
        {
  //     _e("No Escrow Found", 'aistore');

        }
        else
        {
    ?>
      <h1> <?php _e('Recent 5 Escrow', 'aistore') ?> </h1>
    <table id="example1" class="widefat striped fixed"  >
        <thead>
            <tr>
                   <th><?php _e('Id', 'aistore'); ?></th>
        <th><?php _e('Title', 'aistore'); ?></th>
		    <th><?php _e('Status', 'aistore'); ?></th>
          <th><?php _e('Amount', 'aistore'); ?></th> 
		  <th><?php _e('Sender', 'aistore'); ?></th>
		  <th><?php _e('Receiver', 'aistore'); ?></th>
		  	  <th><?php _e('Date', 'aistore'); ?></th>
	  
            </tr>
            
        </thead>
        
        <tbody>
            <?php
            
  
       
             foreach ($results as $row):
   $url = admin_url('admin.php?page=disputed_escrow_details&eid=' . $row->id . '', 'https');

?>
            <tr>
            	   <td> 	 
		  <a href="<?php echo esc_url($url); ?>">
		   
		   <?php echo esc_attr($row->id); ?> </a> </td>
		  
		   
		   <td> 		   <?php echo esc_attr($row->title); ?> </td>
		  
		   <td> 		   <?php echo esc_attr($row->status); ?> </td>
		   
		   <td> 		   <?php echo esc_attr($row->amount) . " " . $row->currency; ?> </td>
		   <td> 		   <?php echo esc_attr($row->sender_email); ?> </td>
		   <td> 		   <?php echo esc_attr($row->receiver_email); ?> </td>
		     <td> 		   <?php echo esc_attr($row->created_at); ?> </td>
		   </tr>
		   <?php
            endforeach;
        ?>
    
        </tbody>
        
        <?php ?>
        
        <tfoot>
            <tr>
                   <th><?php _e('Id', 'aistore'); ?></th>
        <th><?php _e('Title', 'aistore'); ?></th>
		    <th><?php _e('Status', 'aistore'); ?></th>
          <th><?php _e('Amount', 'aistore'); ?></th> 
		  <th><?php _e('Sender', 'aistore'); ?></th>
		  <th><?php _e('Receiver', 'aistore'); ?></th>
		  	  <th><?php _e('Date', 'aistore'); ?></th>
            </tr>
        </tfoot>
    </table>
    
    <?php } ?>
    
    <br><br>
    
   
     <?php
      
	global $wpdb;
           	
           	        $escrow_admin_user_id = get_option('escrow_user_id');
           	        
     	$sql = "SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions  INNER JOIN {$wpdb->prefix}users ON  {$wpdb->prefix}aistore_wallet_transactions.user_id={$wpdb->prefix}users.ID WHERE {$wpdb->prefix}users.ID= ".$escrow_admin_user_id." order by {$wpdb->prefix}aistore_wallet_transactions.transaction_id desc limit 15" ;
     	
     //	echo $sql;
     	
     	 $results = $wpdb->get_results($sql);
      if ($results == null)
        {
      //      _e("No transactions Found", 'aistore');

        }
        else
        {
    ?>
    <h1> <?php _e('Admin Top 15 Transaction', 'aistore') ?> </h1>
<table id="example2" class="widefat striped fixed"  >
        <thead>
            <tr>
                   <th><?php _e('ID', 'aistore'); ?></th>
      
		    <th><?php _e('Email', 'aistore'); ?></th>
          <th><?php _e('Balance', 'aistore'); ?></th> 
		  
	    <th><?php _e('Amount', 'aistore'); ?></th> 
	    <th><?php _e('Type', 'aistore'); ?></th> 
	    <th><?php _e('Description', 'aistore'); ?></th> 
	      <th><?php _e('Date', 'aistore'); ?></th> 
	      
	          <th><?php _e('Escrow/Reference No', 'aistore'); ?></th> 
	          
            </tr>
            
        </thead>
        
        <tbody>
            <?php
            
  
       
             foreach ($results as $row):
             
?>
            <tr>
            	   <td>  <?php
            //	   print_r($row);
            	   echo esc_attr($row->transaction_id); ?></td>
	
		  
		   
		   <td> 		   <?php echo esc_attr($row->user_email); ?> </td>
		  
		   <td> 		   <?php echo esc_attr($row->balance); ?> </td>
		   
		   <td> 		   <?php echo esc_attr($row->amount." ".$row->currency); ?> </td>
		   
		  <td> 		   <?php echo esc_attr($row->type); ?> </td>
		  
		   <td> 		   <?php echo esc_attr($row->description); ?> </td>
		   
		   	   <td> 		   <?php echo esc_attr($row->date); ?> </td>	   <td> 		   <?php echo esc_attr($row->reference); ?> </td>
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
    
      
    <br><br>
    
  
     <?php
      
	global $wpdb;
           	
 $escrow_admin_user_id = get_option('escrow_user_id');
   $user_email = get_the_author_meta('user_email', $escrow_admin_user_id);
   
 $sql = "SELECT * FROM {$wpdb->prefix}escrow_notification  order by id desc  limit 15";
     	
     	 $results = $wpdb->get_results($sql);
     

 	  if ($results == null)
        {
         _e("No Notification Found", 'aistore');

        }
        
        else
        {
        ?>
         <h1> <?php _e('Top 15 Notifications', 'aistore') ?> </h1>  <br>
          <table  id="example6" class="widefat striped fixed" >
      
        <thead>
     <tr>
         <th> <?php _e('Id', 'aistore') ?></th>
      <th> <?php _e('Email', 'aistore') ?></th>
     <th>  <?php _e('Message', 'aistore') ?></th>
        <th> <?php _e('Date', 'aistore') ?></th>
   
    
     </tr>
      </thead>
<tbody>
     <?php
 	foreach ($results as $row):
            
?> 
  
    <tr>
        <td> 	 
		   <?php echo esc_attr($row->id); ?></td>
           <td> <?php echo esc_attr($row->user_email); ?></td>
		   <td> <?php echo html_entity_decode($row->message); ?></td>
		     <td><?php echo esc_attr($row->created_at); ?></td>

    </tr>
            
            </tbody>
    <?php
        endforeach;
    ?>
    
      <tfoot>
            <tr>
     <th> <?php _e('Id', 'aistore') ?></th>
      <th> <?php _e('Email', 'aistore') ?></th>
     <th>  <?php _e('Message', 'aistore') ?></th>
        <th> <?php _e('Date', 'aistore') ?></th>
            </tr>
        </tfoot>
        </table>
     <br><br>
     
     <?php
     
        }
     
    
    
// }
    