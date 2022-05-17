<?php

 
    add_action('AistoreNotification_setting', 'aistore_notification_setting' ); 
    
    
    function aistore_notification_setting(){
        
        ?>
              	 <tr valign="top">
        <th scope="row"><?php _e('Notification Page', 'aistore') ?></th>
        <td>
		<select name="notification_page_id" >
		 
		 
		  <?php
		    $pages = get_pages();
        foreach ($pages as $page)
        {

            if ($page->ID == get_option('notification_page_id'))
            {
                echo '	<option selected value="' .esc_attr( $page->ID) . '">' . esc_attr($page->post_title) . '</option>';

            }
            else
            {

                echo '	<option  value="' . esc_attr($page->ID) . '">' . esc_attr($page->post_title ). '</option>';

            }
        } ?> 

</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_notification] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>

</td>
        </tr>
        
        <?php
    }