<?php

global $wpdb;
        $page_id = get_option('details_escrow_page_id');

        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}escrow_system WHERE status = 'disputed'");

?>
    <h1> <?php _e('All disputed escrows', 'aistore') ?> </h1>
	
	   
	   
  

    <?php
        if ($results == null)
        {

          //  _e("No Escrow Found", 'aistore');

        }
        else
        {
            ?>
              
  <table  id="example" class="display nowrap" style="width:100%">
      
        <thead>
     <tr>
         
         
         <th> <?php _e('Id', 'aistore') ?></th>
      <th> <?php _e('Title', 'aistore') ?></th>
     <th>  <?php _e('Status', 'aistore') ?></th>
        <th> <?php _e('Amount', 'aistore') ?></th>
      <th> <?php _e('Sender', 'aistore') ?> </th>
       <th> <?php _e('Receiver', 'aistore') ?></th>  
  
    
     </tr>
      </thead>
<tbody>
      
<?php
            foreach ($results as $row):

                $url = admin_url('admin.php?page=disputed_escrow_details&eid=' . $row->id . '', 'https');

?>
      <tr>

		   
		   <td> 	 
		  <a href="<?php echo esc_html($url); ?>">  <?php echo esc_attr($row->id); ?></a></td>
		  
		   
		   <td> 		   <?php echo esc_attr($row->title); ?> </td>
		  
		   <td> 		   <?php echo esc_attr($row->status); ?> </td>
		  
		   
		   <td> 		   <?php echo esc_attr($row->amount)  . " " . esc_attr($row->currency); ?> </td>
		   <td> 		   <?php echo esc_attr($row->sender_email); ?> </td>
		   <td> 		   <?php echo esc_attr($row->receiver_email); ?> </td>
		  
              
            </tr>
            
            </tbody>
    <?php
            endforeach;
        }
?>

	

    </table>
  
  