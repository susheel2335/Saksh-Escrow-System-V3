<?php

    add_action('Aistorechat_system', 'aistore_chat_publish' ); 
    
    
    function aistore_chat_publish(){
        
        ?>
            <tr valign="top">
 <th scope="row"><?php _e('Chat system public people show or not', 'aistore') ?></th>
        <td>
            <?php $escrow_message_page = get_option('escrow_message_page'); ?>
            
            <select name="escrow_message_page" id="escrow_message_page">
               
            <option selected value="yes" <?php selected($escrow_message_page, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($escrow_message_page, 'no'); ?>>No</option>
  
</select>
	
</td>
        </tr>  
        <?php
    }