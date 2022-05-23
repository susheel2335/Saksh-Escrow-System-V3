<?php




function ACS_extension_function( $aistore_escrow_extensions ) {
   
        $aistore_escrow_extensions[] = 'chat_system';
  
    return $aistore_escrow_extensions;
}
add_filter( 'aistore_escrow_extension', 'ACS_extension_function' );


  add_action('aistore_escrow_admin_tab_contents', 'ACS_admin_tab_contents_chat_system' ); 
    

function  ACS_admin_tab_contents_chat_system()

{
    ?>
      <div class="tab-pane fade" id="nav-chat" role="tabpanel" aria-labelledby="nav-chat-tab">
      
 
        
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
             submit_button(); ?>
    
        
    
  
  
  </div>
  
  
  <?php
    
    
}

    add_action('aistore_escrow_admin_tab', 'ACS_chat_details_tab' ); 
    

function  ACS_chat_details_tab()

{
 echo  '
    <button class="nav-link" id="nav-chat-tab" data-bs-toggle="tab" data-bs-target="#nav-chat" type="button" role="tab" aria-controls="nav-chat" aria-selected="false">Chat</button> 
     
     ';
    
 
}




 
 
  