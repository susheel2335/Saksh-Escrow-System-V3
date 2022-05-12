<?php

    add_action('Aistore_withdraw', 'aistore_withdraw' ); 
    
    
    function aistore_withdraw(){
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

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_saksh_withdrawal_system] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>

</td>
        </tr>
        
        
  
        <?php
    }
    
    
    
      add_action('Aistore_withdraw_fee', 'aistore_withdraw_fee' ); 
    
    
    function aistore_withdraw_fee(){
        ?>
           <tr valign="top">
        <th scope="row"><?php _e('Withdraw Fee', 'aistore') ?></th>
        <td><input type="number" name="withdraw_fee" value="<?php echo esc_attr(get_option('withdraw_fee')); ?>" />%</td>
        </tr>
        
        <?php
    }
    
    
    
    