<?php
 add_filter( 'after_aistore_escrow', 'aistore_email_report' );
  
     function  aistore_email_report($eid){
         
         ?>
           <h1> <?php _e('Email Notification', 'aistore') ?> </h1>  <br>
     <?php
      
	global $wpdb;
           	 
//  $sql = "SELECT * FROM {$wpdb->prefix}escrow_email " ;
  $sql = "SELECT * FROM {$wpdb->prefix}escrow_email WHERE   reference_id=".$eid;
 
     	 $results = $wpdb->get_results($sql);
     	  if ($results == null)
        {
            _e("No Email Found", 'aistore');

        }
        else{
        ?>
          <table  id="example2" class="widefat striped fixed" >
      
        <thead>
     <tr>
         
           <th><?php _e('ID', 'aistore'); ?></th>
          <th><?php _e('Email', 'aistore'); ?></th>
            <th><?php _e('Subject', 'aistore'); ?></th>
     <th><?php _e('Message', 'aistore'); ?></th>
      <th><?php _e('Date', 'aistore'); ?></th>
      
   
   
    
     </tr>
      </thead>
<tbody>
     <?php
 	foreach ($results as $row):
            
?> 
  
    <tr>
        <td> 	 
		   <?php echo esc_attr($row->id); ?></td>
           <td> 	 
		   <?php echo esc_attr($row->user_email); ?></td>
		    <td> 	 
		   <?php echo esc_attr($row->subject); ?></td>
		   <td> <?php echo html_entity_decode($row->message); ?></td>
		     <td><?php echo esc_attr($row->created_at); ?></td>

    </tr>
            
            </tbody>
    <?php
        endforeach;
    ?>
    
     
        </table>
        
        <?php } 
     }
     