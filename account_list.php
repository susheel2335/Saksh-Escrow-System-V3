<?php
function aistore_list_account(){

       if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
    
 global $wpdb;
 
   $user_id = get_current_user_id();
   
 $sql = "SELECT * FROM {$wpdb->prefix}account where user_id= ".$user_id;

   $results=   $wpdb->get_results($sql);


?></div>

<?php
        if ($results == null)
        {
            echo "<div class='no-result'>";

            _e('Account List Not Found', 'aistore');
            echo "</div>";
        }
        else
        {

            ob_start();

?>
  
    <table class="table">
     
        <tr>
      
    <th><?php _e('ID', 'aistore'); ?></th>
        <th><?php _e('Bank Name', 'aistore'); ?></th>
         <th><?php _e('Branch Name', 'aistore'); ?></th>
          <th><?php _e('IFSC Code', 'aistore'); ?></th> 
</tr>

    <?php
            foreach ($results as $row):
    
  $details_csv_page_id_url = esc_url(add_query_arg(array(
                    'page_id' =>get_option('aistore_csv_data') ,
                    'id' => $row->id,
                ) , home_url()));
?>    <tr>
          
		   <td> <a href="<?php echo $details_csv_page_id_url; ?>"  ><?php echo $row->id; ?> </a></td>
		    <td>   <?php echo $row->bank_name; ?> </td>
    <td> 	
 
   <?php echo $row->branch_name ?>
		  </td>
		   
		  	   <td> 		   <?php echo $row->ifsc_code ?>  </td>
		  
	
 
            </tr>
    <?php
            endforeach;

        } ?>

    </table>
	
    
<?php }

?>