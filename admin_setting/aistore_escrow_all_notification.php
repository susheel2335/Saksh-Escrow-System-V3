<?php

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
  
	     
	     
   <h1> <?php _e('All Notification', 'aistore') ?> </h1>  <br>
     <?php
      
	global $wpdb;
           	

     	 $results = $wpdb->get_results($sql);
     	  if ($results == null)
        {
            _e("No Notification Found", 'aistore');

        }
        ?>
          <table  id="example" class="display nowrap" style="width:100%">
      
        <thead>
     <tr>
         <th>Id</th>
      <th>Email</th>
     <th> Message</th>
        <th>Date</th>
   
    
     </tr>
      </thead>
<tbody>
     <?php
 	foreach ($results as $row):
            
?> 
  
    <tr>
        <td> 	 
		   <?php echo $row->id; ?></td>
           <td> 	 
		   <?php echo $row->user_email; ?></td>
		   <td> <?php echo html_entity_decode($row->message); ?></td>
		     <td><?php echo $row->created_at; ?></td>

    </tr>
            
            </tbody>
    <?php
        endforeach;
    ?>
    
      <tfoot>
            <tr>
       <th>Id</th>
      <th>Email</th>
     <th> Message</th>
        <th>Date</th>
            </tr>
        </tfoot>
        </table>
     <br><br>
     
    
    