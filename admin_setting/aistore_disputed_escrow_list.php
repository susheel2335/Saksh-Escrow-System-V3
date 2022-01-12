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
         <th>Id</th>
      <th>Title</th>
     <th> Status</th>
        <th>Amount</th>
      <th>Sender </th>
       <th>Receiver</th>  
  
    
     </tr>
      </thead>
<tbody>
      
<?php
            foreach ($results as $row):

                $url = admin_url('admin.php?page=disputed_escrow_details&eid=' . $row->id . '', 'https');

?>
      <tr>

		   
		   <td> 	 
		  <a href="<?php echo ($url); ?>">  <?php echo $row->id; ?></a></td>
		  
		   
		   <td> 		   <?php echo $row->title; ?> </td>
		  
		   <td> 		   <?php echo $row->status; ?> </td>
		  
		   
		   <td> 		   <?php echo $row->amount  . " " . $row->currency; ?> </td>
		   <td> 		   <?php echo $row->sender_email; ?> </td>
		   <td> 		   <?php echo $row->receiver_email; ?> </td>
		  
              
            </tr>
            
            </tbody>
    <?php
            endforeach;
        }
?>

	

    </table>
  
  