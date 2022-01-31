<?php 

function aistore_list_customer(){

       if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
global $wpdb;
$user_id = get_current_user_id();
  $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
  
		      if (isset($_POST['submit']) and $_POST['action'] == 'delete_customer')
        {
            
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
              $customer_id = sanitize_text_field($_REQUEST['customer_id']);
          
   
    
      $table = $wpdb->prefix.'customer';
    $wpdb->delete( $table, array( 'id' => $customer_id,'user_id' =>$user_id) );
        }
        
        
       
// $sql = ($wpdb->prepare("SELECT * FROM {$wpdb->prefix}customer where user_id=%s ", $user_id));
//  $results=   $wpdb->get_results($sql);
 
 
$company = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}customer where user_id=%s and company_id=%s ",$user_id,$company->company_id));   


?></div>

<?php
        if ($results == null)
        {
            echo "<div class='no-result'>";

            _e('Customer List Not Found', 'aistore');
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
    
  $details_customer_page_id_url = esc_url(add_query_arg(array(
                    'page_id' =>get_option('aistore_edit_customer') ,
                    'customer_id' => $row->id,
                ) , home_url()));
                
$transaction_customer_page_id_url = esc_url(add_query_arg(array(
                    'page_id' =>105,//get_option('aistore_transaction_by_customer') ,
                    'customer_id' => $row->id,
                ) , home_url())); 
?>    <tr>
          
		   <td> <a href="<?php echo $details_customer_page_id_url; ?>"  ><?php echo $row->id; ?> </a></td>
		   
		    <td>  <a href="<?php echo $transaction_customer_page_id_url; ?>" >
		    <?php echo $row->customer_name; ?></a> </td>
    <td> 	
 
   <?php echo $row->customer_email ?>
		  </td>
		  
		    <td> 
		 
            
       
             
    <form method="POST" action="" name="delete_customer" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
  <input class="input" type="hidden" id="customer_id" name="customer_id" value="<?php echo $row->id; ?>"><br>
 
  <input 
 type="submit" class="btn" name="submit" value="<?php _e('Delete', 'aistore') ?>"/>
<input type="hidden" name="action" value="delete_customer" />

</form>


		  </td>
		  
            </tr>
    <?php
            endforeach;

        } ?>

    </table>
	
    
    <?php
}