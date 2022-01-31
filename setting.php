<?php
add_action('admin_init', 'aistore_page_quiz_setting');

function aistore_page_quiz_setting()
{
    //register our settings
    register_setting('aistore_page', 'aistore_csv_data');
    register_setting('aistore_page', 'aistore_transaction_history');
    register_setting('aistore_page', 'aistore_transaction_report');
    register_setting('aistore_page', 'aistore_all_expenses_report');
    register_setting('aistore_page', 'aistore_all_sales_report');
    
     register_setting('aistore_page', 'aistore_add_account');
    register_setting('aistore_page', 'aistore_add_subaccount');
    register_setting('aistore_page', 'aistore_add_bank');
    register_setting('aistore_page', 'aistore_list_bank');
      register_setting('aistore_page', 'aistore_update_transaction');
      
     register_setting('aistore_page', 'aistore_add_vendor');
    register_setting('aistore_page', 'aistore_list_vendor');
    register_setting('aistore_page', 'aistore_edit_vendor');
    register_setting('aistore_page', 'aistore_transaction_by_vendor');
    
     register_setting('aistore_page', 'aistore_add_invoice');
    register_setting('aistore_page', 'aistore_list_invoice');
    register_setting('aistore_page', 'aistore_invoice_details');
    register_setting('aistore_page', 'aistore_add_product');
    
      register_setting('aistore_page', 'aistore_add_estimate');
    register_setting('aistore_page', 'aistore_list_estimate');
    register_setting('aistore_page', 'aistore_estimate_details');
     register_setting('aistore_page', 'aistore_add_customer');
    register_setting('aistore_page', 'aistore_list_customer');
    register_setting('aistore_page', 'aistore_edit_customer');
    
     register_setting('aistore_page', 'aistore_email_page');
    register_setting('aistore_page', 'aistore_estimate_email_page');

}

function wpdocs_register_quiz_setting_menu_page()
{
    add_menu_page(__('CSV Setting', 'aistore') , 'CSV Setting', 'manage_options', 'csv_setting', 'csv_setting_menu_page', plugins_url('myplugin/images/icon.png') , 6);
}
add_action('admin_menu', 'wpdocs_register_quiz_setting_menu_page');

/**
 * Display a custom menu page
 */
function csv_setting_menu_page()
{

?>
    	  <div class="wrap">
	  
	  <div class="card">
<?php
    if (isset($_POST['submit']) and $_POST['action'] == 'create_all_pages')
    {

        if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
        {
            return _e('Sorry, your nonce did not verify.', 'aistore');

            exit;
        }

        $my_post = array(
            'post_title' => 'CSV Data',
            'post_type' => 'page',
            'post_content' => '[aistore_csv_data]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_csv_data = wp_insert_post($my_post);

        update_option('aistore_csv_data', $aistore_csv_data);

        $my_post = array(
            'post_title' => 'Transaction History',
            'post_type' => 'page',
            'post_content' => '[aistore_transaction_history] ',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_transaction_history = wp_insert_post($my_post);

        update_option('aistore_transaction_history', $aistore_transaction_history);

        $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Transaction Report',
            'post_content' => '[aistore_transaction_report]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_transaction_report = wp_insert_post($my_post);

        update_option('aistore_transaction_report', $aistore_transaction_report);

        $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Expenses Report',
            'post_content' => '[aistore_all_expenses_report]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_all_expenses_report = wp_insert_post($my_post);

        update_option('aistore_all_expenses_report', $aistore_all_expenses_report);

        $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Sales Report',
            'post_content' => '[aistore_all_sales_report]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_all_sales_report = wp_insert_post($my_post);

        update_option('aistore_all_sales_report', $aistore_all_sales_report);
        
        
          $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Add Account',
            'post_content' => '[aistore_add_account]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_add_account = wp_insert_post($my_post);

        update_option('aistore_add_account', $aistore_add_account);


      
          $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Add Subaccount',
            'post_content' => '[aistore_add_subaccount]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_add_subaccount = wp_insert_post($my_post);

        update_option('aistore_add_subaccount', $aistore_add_subaccount);
        
        
          $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Add Bank',
            'post_content' => '[aistore_add_bank]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_add_bank = wp_insert_post($my_post);

        update_option('aistore_add_bank', $aistore_add_bank);
        
        
        
          $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Bank List',
            'post_content' => '[aistore_list_bank]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_list_bank = wp_insert_post($my_post);

        update_option('aistore_list_bank', $aistore_list_bank);
        
         $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Classified Transaction',
            'post_content' => '[aistore_update_transaction]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_update_transaction = wp_insert_post($my_post);

        update_option('aistore_update_transaction', $aistore_update_transaction);
        
        
        
        
         $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Add Vendor',
            'post_content' => '[aistore_add_vendor]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_add_vendor = wp_insert_post($my_post);

        update_option('aistore_add_vendor', $aistore_add_vendor);
        
        
         $my_post = array(
            'post_type' => 'page',
            'post_title' => ' Vendor List',
            'post_content' => '[aistore_list_vendor]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_list_vendor = wp_insert_post($my_post);

        update_option('aistore_list_vendor', $aistore_list_vendor);
        
         
         $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Edit Vendor',
            'post_content' => '[aistore_edit_vendor]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_edit_vendor = wp_insert_post($my_post);

        update_option('aistore_edit_vendor', $aistore_edit_vendor);
        
        
        $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Transaction',
            'post_content' => '[aistore_transaction_by_vendor]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_transaction_by_vendor = wp_insert_post($my_post);

        update_option('aistore_transaction_by_vendor', $aistore_transaction_by_vendor);
        
        // ...
         $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Invoice Details',
            'post_content' => '[aistore_invoice_details]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_invoice_details = wp_insert_post($my_post);

        update_option('aistore_invoice_details', $aistore_invoice_details);
        
         $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Invoice List',
            'post_content' => '[aistore_list_invoice]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_transaction_by_vendor = wp_insert_post($my_post);

        update_option('aistore_list_invoice', $aistore_list_invoice);
        
        
         $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Add Invoice',
            'post_content' => '[aistore_add_invoice]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_add_invoice = wp_insert_post($my_post);

        update_option('aistore_add_invoice', $aistore_add_invoice);
        
        
         $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Add Product',
            'post_content' => '[aistore_add_product]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_transaction_by_vendor = wp_insert_post($my_post);

        update_option('aistore_add_product', $aistore_add_product);
        
        
        
         
         $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Add Customer',
            'post_content' => '[aistore_add_customer]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_add_customer = wp_insert_post($my_post);

        update_option('aistore_add_customer', $aistore_add_customer);
        
        
         $my_post = array(
            'post_type' => 'page',
            'post_title' => ' Customer List',
            'post_content' => '[aistore_list_customer]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_list_customer = wp_insert_post($my_post);

        update_option('aistore_list_customer', $aistore_list_customer);
        
         
         $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Edit Customer',
            'post_content' => '[aistore_edit_customer]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_edit_customer = wp_insert_post($my_post);

        update_option('aistore_edit_customer', $aistore_edit_customer);
        
        
          $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Estimate Details',
            'post_content' => '[aistore_estimate_details]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_estimate_details = wp_insert_post($my_post);

        update_option('aistore_estimate_details', $aistore_estimate_details);
        
         $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Estimate List',
            'post_content' => '[aistore_list_estimate]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_list_estimate = wp_insert_post($my_post);

        update_option('aistore_list_estimate', $aistore_list_estimate);
        
        
         $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Add Estimate',
            'post_content' => '[aistore_add_estimate]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_add_estimate = wp_insert_post($my_post);

        update_option('aistore_add_estimate', $aistore_add_estimate);
        
        
        
        
           $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Add Invoice Email',
            'post_content' => '[aistore_email_page]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_email_page = wp_insert_post($my_post);

        update_option('aistore_email_page', $aistore_email_page);
        
        
        
           $my_post = array(
            'post_type' => 'page',
            'post_title' => 'Add Estimate Email',
            'post_content' => '[aistore_estimate_email_page]',
            'post_status' => 'publish',
            'post_author' => 1
        );

        // Insert the post into the database
        $aistore_estimate_email_pagee = wp_insert_post($my_post);

        update_option('aistore_estimate_email_page', $aistore_estimate_email_page);
        
        
    }
    else
    {

?>
    
    
    
 <form method="POST" action="" name="create_all_pages" enctype="multipart/form-data"> 
    <?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
    
<p><?php _e(' Create all pages with short codes automatically to ', 'aistore') ?>
<br><br>

<input class="input" type="submit" name="submit" value="<?php _e('Click Here', 'aistore') ?>"/>
<input type="hidden" name="action"  value="create_all_pages"/></td></tr>
    </form>
    
    
    </table>
    <hr>
    
    <?php
    }
    
    
    $pages = get_pages();
?>
<form method="post" action="options.php">
    <?php settings_fields('aistore_page'); ?>
    <?php do_settings_sections('aistore_page'); ?>
	
    <table class="form-table">
	
	 <tr valign="top">
        <th scope="row"><?php _e('CSV Data Page', 'aistore') ?></th>
        <td>
		<select name="aistore_csv_data"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_csv_data'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_csv_data] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>

</td>
        </tr>  
        
        
        
        	 <tr valign="top">
        <th scope="row"><?php _e('Transaction History Page', 'aistore') ?></th>
        <td>
		<select name="aistore_transaction_history"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_transaction_history'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>
<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_transaction_history] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>

</td>
        </tr>  
        
        
         <tr valign="top">
        <th scope="row"><?php _e('Update Transaction Page', 'aistore') ?></th>
        <td>
		<select name="aistore_update_transaction"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_update_transaction'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>
<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_update_transaction] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>

</td>
        </tr>  
        
        
        
        
         <tr valign="top">
        <th scope="row"><?php _e('Transaction Report', 'aistore') ?></th>
        <td>
		<select name="aistore_transaction_report"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_transaction_report'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_transaction_report] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr>  
        
        
        
         <tr valign="top">
        <th scope="row"><?php _e('Expenses Report', 'aistore') ?></th>
        <td>
		<select name="aistore_all_expenses_report"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_all_expenses_report'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>
<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_all_expenses_report] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>

</td>
        </tr>  
        
        
          <tr valign="top">
        <th scope="row"><?php _e('Sales Report', 'aistore') ?></th>
        <td>
		<select name="aistore_all_sales_report"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_all_sales_report'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_all_sales_report] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr>  
        
        
        
        
        <tr valign="top">
        <th scope="row"><?php _e('Add Account Page', 'aistore') ?></th>
        <td>
		<select name="aistore_add_account"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_add_account'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_add_account] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        <tr valign="top">
        <th scope="row"><?php _e('Add Subaccount Page', 'aistore') ?></th>
        <td>
		<select name="aistore_add_subaccount"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_add_subaccount'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_add_subaccount] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
        <tr valign="top">
        <th scope="row"><?php _e('Add Bank Page', 'aistore') ?></th>
        <td>
		<select name="aistore_add_bank"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_add_bank'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_add_bank] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
        <tr valign="top">
        <th scope="row"><?php _e('Bank List Page', 'aistore') ?></th>
        <td>
		<select name="aistore_list_bank"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_list_bank'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_list_bank] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
        
        
         <tr valign="top">
        <th scope="row"><?php _e('Add Vendor Page', 'aistore') ?></th>
        <td>
		<select name="aistore_add_vendor"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_add_vendor'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_add_vendor] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
         <tr valign="top">
        <th scope="row"><?php _e('Vendor List Page', 'aistore') ?></th>
        <td>
		<select name="aistore_list_vendor"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_list_vendor'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_list_vendor] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
         <tr valign="top">
        <th scope="row"><?php _e('Vendor Edit Page', 'aistore') ?></th>
        <td>
		<select name="aistore_edit_vendor"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_edit_vendor'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_edit_vendor] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
                 <tr valign="top">
        <th scope="row"><?php _e('Transaction', 'aistore') ?></th>
        <td>
		<select name="aistore_transaction_by_vendor"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_transaction_by_vendor'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_transaction_by_vendor] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        <!--//-->
        
        
                    <tr valign="top">
        <th scope="row"><?php _e('Add Product', 'aistore') ?></th>
        <td>
		<select name="aistore_add_product"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_add_product'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_add_product] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
        
                    <tr valign="top">
        <th scope="row"><?php _e('Add Invoice', 'aistore') ?></th>
        <td>
		<select name="aistore_add_invoice"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_add_invoice'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_add_invoice] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
                    <tr valign="top">
        <th scope="row"><?php _e('Invoice List', 'aistore') ?></th>
        <td>
		<select name="aistore_list_invoice"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_list_invoice'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_list_invoice] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
                    <tr valign="top">
        <th scope="row"><?php _e('Invoice Details', 'aistore') ?></th>
        <td>
		<select name="aistore_invoice_details"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_invoice_details'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_invoice_details] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
        
         <tr valign="top">
        <th scope="row"><?php _e('Add Customer Page', 'aistore') ?></th>
        <td>
		<select name="aistore_add_customer"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_add_customer'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_add_customer] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
         <tr valign="top">
        <th scope="row"><?php _e('Customer List Page', 'aistore') ?></th>
        <td>
		<select name="aistore_list_customer"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_list_customer'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_list_customer] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
         <tr valign="top">
        <th scope="row"><?php _e('Customer Edit Page', 'aistore') ?></th>
        <td>
		<select name="aistore_edit_customer"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_edit_customer'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_edit_customer] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
        
        
        
        
                    <tr valign="top">
        <th scope="row"><?php _e('Add Estimate', 'aistore') ?></th>
        <td>
		<select name="aistore_add_estimate"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_add_estimate'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_add_estimate] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
                    <tr valign="top">
        <th scope="row"><?php _e('Estimate List', 'aistore') ?></th>
        <td>
		<select name="aistore_list_estimate"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_list_estimate'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_list_estimate] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
                    <tr valign="top">
        <th scope="row"><?php _e('Estimate Details', 'aistore') ?></th>
        <td>
		<select name="aistore_estimate_details"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_estimate_details'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_estimate_details] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
        
        
                          <tr valign="top">
        <th scope="row"><?php _e('Add Invoice Email', 'aistore') ?></th>
        <td>
		<select name="aistore_email_page"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_email_page'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_email_page] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
                          <tr valign="top">
        <th scope="row"><?php _e('Add Estimate Email', 'aistore') ?></th>
        <td>
		<select name="aistore_estimate_email_page"  >
		 
		 
     <?php
    foreach ($pages as $page)
    {

        if ($page->ID == get_option('aistore_estimate_email_page'))
        {
            echo '	<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
        else
        {

            echo '	<option value="' . $page->ID . '">' . $page->post_title . '</option>';

        }
    } ?> 
	 
	 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_estimate_email_page] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>
</td>
        </tr> 
        
        
        
         </table>
    
    <?php submit_button(); ?>

</form>
</div></div>
<?php
}