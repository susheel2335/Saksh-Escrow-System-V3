 <?php
//  function aistore_escrow_user_list()
//  {
     
 
 global $wpdb;
              $page_id = get_option('details_escrow_page_id');
            if (isset($_REQUEST['id']))
        {
$id=sanitize_text_field($_REQUEST['id']);

//echo $id;
      //  $id = sanitize_text_field($_REQUEST['id']);

        $user_email = get_the_author_meta('user_email', $id);

      

        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE (sender_email=%s or receiver_email=%s ) order by id desc", $user_email, $user_email));
        }  
        else{
   
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}escrow_system");
}

?>
  <h1> <?php _e('Escrow List', 'aistore') ?> </h1>
   
   
   
    

            <?php
            
  
        if ($results == null)
        {
           // _e("No Escrow Found", 'aistore');

        }
        else
        {
            
            ?>
<table id="example" class="display nowrap" style="width:100%">
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
   
  
    $user = get_user_by('email', $row->sender_email);
    
  //  print_r($user);
            $sender_id = $user->ID;
           // echo $sender_id;
    $user = get_user_by('email', $row->receiver_email);
            $receiver_id = $user->ID;
            
   $urlbyid = admin_url('admin.php?page=aistore_user_escrow_list&id='. $sender_id . '', 'https');
   
    $urlbyidreciver = admin_url('admin.php?page=aistore_user_escrow_list&id=' . $receiver_id . '', 'https');
   
        
// https://www.blogentry.in/est/wp-admin/admin.php?page=aistore_user_escrow_list
?>
            <tr>
            	   <td> 	 
		  <a href="<?php echo esc_url($url); ?>">
		   
		   <?php echo esc_attr($row->id); ?> </a> </td>
		  
		   
		    <td> 	 
		  <a href="<?php echo esc_url($url); ?>">
		   
		   <?php echo esc_attr($row->title); ?> </a> </td>

		  
		   <td> 		   <?php echo esc_attr($row->status); ?> </td>
		   
		   <td> 		   <?php echo esc_attr($row->amount) . " " . $row->currency; ?> </td>
		   
		  <td> <a href="<?php echo esc_url($urlbyid); ?>">
		   
		   <?php echo esc_attr($row->sender_email); ?> </a> </td>
		   
		   	  <td> <a href="<?php echo esc_url($urlbyidreciver); ?>">
		   
		   <?php echo esc_attr($row->receiver_email); ?> </a> </td>

		  
		     <td> 		   <?php echo esc_attr($row->created_at); ?> </td>
		   </tr>
		   <?php
        
            endforeach;
        ?>
    
        </tbody>
        
    
        
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
        <?php }   
        
        // }  
        ?>
      
      
    