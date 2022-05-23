<?php

add_action('aistore_escrow_admin_tab_contents', 'aistore_withdraw_escrow_admin_tab_contents_withdraw' ); 
    
 /**
       * 
       * This function is used to withdraw escrow admin tab contents withdraw
       * Create an admin withdraw page with page id
      
       * 
       */ 
function  aistore_withdraw_escrow_admin_tab_contents_withdraw()

{
    ?>
      <div class="tab-pane fade" id="nav-withdraw" role="tabpanel" aria-labelledby="nav-withdraw-tab">
      
 <?php
         $pages = get_pages();
        ?>
               	 
        	 <tr valign="top">
        <th scope="row"><?php _e('Withdraw Page', 'aistore') ?></th>
        <td>
		<select name="aistore_saksh_withdrawal_system" >
		 
		 
		  <?php
        foreach ($pages as $page)
        {

            if ($page->ID == get_option('aistore_saksh_withdrawal_system'))
            {
                echo '	<option selected value="' . esc_attr($page->ID ). '">' . esc_attr($page->post_title) . '</option>';

            }
            else
            {

                echo '	<option  value="' .esc_attr( $page->ID) . '">' . esc_attr($page->post_title) . '</option>';

            }
        } ?> 

</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?>  [aistore_saksh_withdrawal_system]  <?php _e('and then select that page here.', 'aistore') ?> </p>

</td>
        </tr>
        
        
           <tr valign="top">
        <th scope="row"><?php _e('Withdraw Fee', 'aistore') ?></th>
        <td><input type="number" name="withdraw_fee" value="<?php echo esc_attr(get_option('withdraw_fee')); ?>" />%</td>
        </tr>
  
        <?php
        
       
     submit_button(); ?>
    
  
  
  </div>
  
   
        
        <?php
}

    add_action('aistore_escrow_admin_tab', 'aistore_withdraw_tab' ); 
    
 /**
       * 
       * This function is used to withdraw escrow admin tabs
      
       * 
       */ 
function  aistore_withdraw_tab()

{
 echo  '
    <button class="nav-link" id="nav-withdraw-tab" data-bs-toggle="tab" data-bs-target="#nav-withdraw" type="button" role="tab" aria-controls="nav-withdraw" aria-selected="false">Withdraw</button> 
     
     ';
    
 
}