<?php

    add_action('Aistoreupload_file_type', 'AFU_type' ); 
    
    /**
       * This function is used to Upload file type
       * @pdf
       * @xlsx
       * @ppt
       * @doc
      */
      
    function AFU_type(){
        
        ?>
           <tr valign="top">
 <th scope="row"><?php _e('Upload File type', 'aistore') ?></th>
        <td>
            <?php $escrow_file_type = esc_attr(get_option('escrow_file_type')); ?>
            
            <select name="escrow_file_type" id="escrow_file_type">
                
               
            <option selected value="pdf" <?php selected($escrow_file_type, 'pdf'); ?>>pdf</option>
            <option value="xlsx" <?php selected($escrow_file_type, 'xlsx'); ?>>xlsx</option>
  
   <option value="ppt" <?php selected($escrow_file_type, 'ppt'); ?>>ppt</option>
      <option value="doc" <?php selected($escrow_file_type, 'doc'); ?>>doc</option>
</select>
	
</td>
        </tr>  
        
        <?php
    }
    
    