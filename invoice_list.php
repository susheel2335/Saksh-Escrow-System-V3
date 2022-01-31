<?php 

function aistore_list_invoice(){

       if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
 global $wpdb;
 
 
    $user_id = get_current_user_id();
    
  $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id)); 
  
       
$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}invoice where user_id=%s and company_id = %s ", $user_id,$company->company_id));

//  $sql = "SELECT * FROM {$wpdb->prefix}invoice where user_id=".$user_id;

//   $results=   $wpdb->get_results($sql);


?></div>

<?php
        if ($results == null)
        {
            echo "<div class='no-result'>";

            _e('Invoice List Not Found', 'aistore');
            echo "</div>";
        }
        else
        {

            ob_start();

?>
  
    <table class="table">
     
        <tr>
      
    <th><?php _e('ID', 'aistore'); ?></th>
        <th><?php _e('User Id', 'aistore'); ?></th>
         <th><?php _e('Customer ID', 'aistore'); ?></th>
          <th><?php _e('Action', 'aistore'); ?></th>
       
</tr>

    <?php
            foreach ($results as $row):
    
  $aistore_invoice_details_url = esc_url(add_query_arg(array(
                    'page_id' =>get_option('aistore_invoice_details') ,
                    'invoice_id' => $row->id,
                ) , home_url()));
?>    <tr>
          
		   <td> <a href="<?php echo $aistore_invoice_details_url; ?>"  ><?php echo $row->id; ?> </a></td>
		    <td>   <?php echo $row->user_id; ?> </td>
    <td> 	
 
   <?php echo $row->customer_id ?>
		  </td>
		   
	  <td>  <?php  
		      if (isset($_POST['submit']) and $_POST['action'] == 'invoice_email')
        {
            
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
              $invoice_id = sanitize_text_field($_REQUEST['invoice_id']);
          
  $aistore_invoice_email_details_url = esc_url(add_query_arg(array(
                    'page_id' =>get_option('aistore_email_page') ,
                    'invoice_id' => $invoice_id,
                     'customer_id' => $row->customer_id,
                ) , home_url()));
                ?>
         <meta http-equiv="refresh" content="0; URL=<?php echo esc_html($aistore_invoice_email_details_url); ?>" />
                
                <?php
        }
        
        else{
            
        ?>
             
    <form method="POST" action="" name="invoice_email" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
  <input class="input" type="hidden" id="invoice_id" name="invoice_id" value="<?php echo $row->id; ?>"><br>
 
  <input 
 type="submit" class="btn" name="submit" value="<?php _e('Send Email', 'aistore') ?>"/>
<input type="hidden" name="action" value="invoice_email" />

</form>

<?php } ?>
		  </td>
	
 
            </tr>
    <?php
            endforeach;

        } ?>

    </table>
	
    
    <?php
}

?>