<?php 

function aistore_list_vendor(){

       if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
 global $wpdb;
 
$user_id = get_current_user_id();
  if (isset($_POST['submit']) and $_POST['action'] == 'delete_vendor')
        {
            
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
              $vendor_id = sanitize_text_field($_REQUEST['vendor_id']);
           $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id)); 
    $table = $wpdb->prefix.'vendor';
    $wpdb->delete( $table, array( 'id' => $vendor_id,'user_id' =>$user_id, 'company_id' => $company->company_id) );
        }
        
     
            
        
        
$sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}vendor where user_id=%s ", $user_id);


 $results=   $wpdb->get_results($sql);


?></div>

<?php
        if ($results == null)
        {
            echo "<div class='no-result'>";

            _e('Vendor List Not Found', 'aistore');
            echo "</div>";
        }
        else
        {

            ob_start();

?>
  
    <table class="table">
     
        <tr>
      
    <th><?php _e('ID', 'aistore'); ?></th>
        <th><?php _e('Name', 'aistore'); ?></th>
         <th><?php _e('Email', 'aistore'); ?></th>
           <th><?php _e('Action', 'aistore'); ?></th>
         
</tr>

    <?php
            foreach ($results as $row):
    
  $details_vendor_page_id_url = esc_url(add_query_arg(array(
                    'page_id' =>get_option('aistore_edit_vendor') ,
                    'vendor_id' => $row->id,
                ) , home_url()));
                
$transaction_vendor_page_id_url = esc_url(add_query_arg(array(
                    'page_id' =>get_option('aistore_transaction_by_vendor') ,
                    'vendor_id' => $row->id,
                ) , home_url())); 
?>    <tr>
          
		   <td> <a href="<?php echo $details_vendor_page_id_url; ?>"  ><?php echo $row->id; ?> </a></td>
		   
		    <td>  <a href="<?php echo $transaction_vendor_page_id_url; ?>" >
		    <?php echo $row->vendor_name; ?></a> </td>
    <td> 	
 
   <?php echo $row->vendor_email ?>
		  </td>
		  
		    <td> 

             
    <form method="POST" action="" name="delete_vendor" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
  <input class="input" type="hidden" id="vendor_id" name="vendor_id" value="<?php echo $row->id; ?>"><br>
 
  <input 
 type="submit" class="btn" name="submit" value="<?php _e('Delete', 'aistore') ?>"/>
<input type="hidden" name="action" value="delete_vendor" />

</form>


		  </td>
		  
            </tr>
    <?php
            endforeach;

        } ?>

    </table>
	
    
    <?php
}