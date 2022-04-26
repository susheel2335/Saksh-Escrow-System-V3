<?php


// function aistore_escrow_admin_notification()
// {

global $wpdb;
        
            if (isset($_REQUEST['id']))
        {
$id=sanitize_text_field($_REQUEST['id']);




        $user_email = get_the_author_meta('user_email', $id);
        
         $sql = "SELECT * FROM {$wpdb->prefix}escrow_notification   where user_email ='".$user_email."' order by id desc";
         
        //echo $sql;
        }  
        else{
   
    $sql = "SELECT * FROM {$wpdb->prefix}escrow_notification  order by id desc";

}

?>

  <br>
  
	     
	     
   <h1> <?php _e('System Notifications', 'aistore') ?> </h1>  
   
   
    <?php echo AistoregetSupportMsg(); ?>
    
    
     <?php
      
	global $wpdb;
           	

     	 $results = $wpdb->get_results($sql);
     	  if ($results == null)
        {
            _e("Notifications list is stil empty", 'aistore');

        }
        else
        {
        ?>
          <table  id="example" class="table" style="width:100%">
      
        <thead>
     <tr>
         <th> <?php _e('Id', 'aistore') ?></th>
      <th> <?php _e('Email', 'aistore') ?></th>
     <th> <?php _e('Message', 'aistore') ?> </th>
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
           <td> 	 
		   <?php echo esc_attr($row->user_email); ?></td>
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
     <th> <?php _e('Message', 'aistore') ?> </th>
        <th> <?php _e('Date', 'aistore') ?></th>
   
            </tr>
        </tfoot>
        </table>
     <br><br>
     
    <?php
    
        }
// } 
        
    