<?php
// This is function is used to  set bank details page
    add_action('Aistorebank_payment', 'ABP_page' ); 
    
    
    function ABP_page(){
          $pages = get_pages();
        ?>
               	 <tr valign="top">
        <th scope="row"><?php _e('Bank Details Page', 'aistore') ?></th>
        <td>
		<select name="bank_details_page_id" >
		 
		 
		  <?php
		 
        foreach ($pages as $page)
        {

            if ($page->ID == get_option('bank_details_page_id'))
            {
                echo '	<option selected value="' . esc_attr($page->ID) . '">' . esc_attr($page->post_title) . '</option>';

            }
            else
            {

                echo '	<option  value="' .esc_attr( $page->ID ). '">' . esc_attr($page->post_title ). '</option>';

            }
        } ?> 
	 
	 
		 
					  
					
 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_bank_details] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>





</td>
        </tr>
        
        
        	 <tr valign="top">
        <th scope="row"><?php _e('Bank Account Page', 'aistore') ?></th>
        <td>
		<select name="aistore_bank_account" >
		 
		 
		  <?php
        foreach ($pages as $page)
        {

            if ($page->ID == get_option('aistore_bank_account'))
            {
                echo '	<option selected value="' .esc_attr( $page->ID ). '">' .esc_attr( $page->post_title) . '</option>';

            }
            else
            {

                echo '	<option  value="' .esc_attr( $page->ID ). '">' . esc_attr($page->post_title) . '</option>';

            }
        } ?> 

</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_bank_account] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>

</td>
        </tr>
        
        
        
  
        <?php
    }
    
        add_action('Aistorebank_payment_details', 'ABP_details' ); 
    
    // This is function is used to  add admin  bank details 
    function ABP_details(){
        ?>
                   <table class="form-table">
        
        <h3><?php _e('Bank Account Details', 'aistore') ?></h3>
        

           <tr valign="top">
        <th scope="row"><?php _e('Bank Details', 'aistore') ?></th>
        <td>
             <textarea id="bank_details" name="bank_details" rows="2" cols="50">
<?php echo esc_attr(get_option('bank_details')); ?>
</textarea>
        </td>
        </tr>
        
           <tr valign="top">
        <th scope="row"><?php _e('Deposit Instructions', 'aistore') ?></th>
        <td>
             <textarea id="deposit_instructions" name="deposit_instructions" rows="2" cols="50">
<?php echo esc_attr(get_option('deposit_instructions')); ?>
</textarea>
        </td>
        </tr>
       
  
  
    </table>
        <?php
    }
    
    
    