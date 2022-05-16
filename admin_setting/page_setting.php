<?php

  $pages = get_pages();

?>
	  <div class="wrap">
	  
	  <div class="card">
	   <?php echo AistoregetSupportMsg(); ?>
<h3><?php _e('Escrow Setting', 'aistore') ?></h3>
 
	                

 
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
      
     
     
     <button class="nav-link active" id="nav-home1-tab" data-bs-toggle="tab" data-bs-target="#nav-home1" type="button" role="tab" aria-controls="nav-home1" aria-selected="true">Step 1</button>
        
        
    <button class="nav-link " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="false">Step 2</button>
    
    
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Step 3</button>
    
    
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Step 4</button>
    
    
    
     <button class="nav-link" id="nav-contact1-tab" data-bs-toggle="tab" data-bs-target="#nav-contact1" type="button" role="tab" aria-controls="nav-contact1" aria-selected="false">Step 5</button>
     
     
    
     <?php
   
  do_action( "aistore_escrow_admin_tab"  );
  
  ?> 
     
  </div>
</nav>


<br>
<br>
<br>
<div class="tab-content" id="nav-tabContent">
    
    <div class="tab-pane fade show active" id="nav-home1" role="tabpanel" aria-labelledby="nav-home1-tab">
        

<p><?php _e('Step 1', 'aistore') ?></p>


<?php
        if (isset($_POST['submit']) and $_POST['action'] == 'create_all_pages')
        {

            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify.', 'aistore');

                exit;
            }
           

            $my_post = array(
                'post_title' => 'Create Escrow',
                'post_type' => 'page',
                'post_content' => '[aistore_escrow_system]',
                'post_status' => 'publish' 
            );

            // Insert the post into the database
            $add_escrow_page_id = wp_insert_post($my_post);

            update_option('add_escrow_page_id', $add_escrow_page_id);

            $my_post = array(
                'post_title' => 'Escrow List',
                'post_type' => 'page',
                'post_content' => '[aistore_escrow_list] ',
                'post_status' => 'publish' 
            );

            // Insert the post into the database
            $list_escrow_page_id = wp_insert_post($my_post);

            update_option('list_escrow_page_id', $list_escrow_page_id);

            $my_post = array(
                'post_type' => 'page',
                'post_title' => 'Escrow Detail',
                'post_content' => '[aistore_escrow_detail]',
                'post_status' => 'publish' 
            );

            // Insert the post into the database
            $details_escrow_page_id = wp_insert_post($my_post);

            update_option('details_escrow_page_id', $details_escrow_page_id);
            
  //       $my_post = array(
  //              'post_type' => 'page',
  //              'post_title' => 'Bank Detail',
   //             'post_content' => '[aistore_bank_details]',
  //              'post_status' => 'publish' 
   //         );

            // Insert the post into the database
   //         $details_bank_page_id = wp_insert_post($my_post);

   //         update_option('bank_details_page_id', $details_bank_page_id);
            
   //         $my_post = array(
     //           'post_type' => 'page',
    //            'post_title' => 'Escrow Notification',
      //          'post_content' => '[aistore_notification]',
      //          'post_status' => 'publish' 
       //     );

            // Insert the post into the database
        //    $notification_page_id = wp_insert_post($my_post);

       //     update_option('notification_page_id', $notification_page_id);
            
     //          $my_post = array(
     //           'post_type' => 'page',
    //            'post_title' => 'Transaction History',
    //            'post_content' => '[aistore_transaction_history]',
     //           'post_status' => 'publish' 
    //        );

            // Insert the post into the database
   //         $aistore_transaction_history_page_id = wp_insert_post($my_post);

  //          update_option('aistore_transaction_history_page_id', //$aistore_transaction_history_page_id);
            
            
    //          $my_post = array(
   //             'post_type' => 'page',
   //             'post_title' => 'Withdrawal',
     //           'post_content' => '[aistore_saksh_withdrawal_system]',
   //             'post_status' => 'publish' 
     //       );

            // Insert the post into the database
    //        $aistore_saksh_withdrawal_system = wp_insert_post($my_post);

       //     update_option('aistore_saksh_withdrawal_system', $aistore_saksh_withdrawal_system);
            
    //         $my_post = array(
     //           'post_type' => 'page',
   //             'post_title' => 'Bank Account',
     //           'post_content' => '[aistore_bank_account]',
   //             'post_status' => 'publish' 
    //        );

            // Insert the post into the database
            $aistore_bank_account = wp_insert_post($my_post);

         //   update_option('aistore_bank_account', $aistore_bank_account);
            
            $escrow_user_id=sanitize_text_field($_REQUEST['escrow_user_id']);
             $user_id = username_exists( $escrow_user_id );
   
        if ( ! $user_id ) {
        $user_id = wp_insert_user( array(
          'user_login' => $escrow_user_id,
          'user_pass' => $escrow_user_id,
          'user_email' => $escrow_user_id,
          'first_name' => $escrow_user_id,
          'last_name' => $escrow_user_id,
          'display_name' => $escrow_user_id,
          'role' => 'administrator'
        ));
        
        update_option( 'escrow_user_id', $user_id);
        update_option( 'escrow_user_name', $escrow_user_id);
   //      update_option( 'escrow_file_type', 'pdf');
           update_option('escrow_fee_deducted', 'accepted');
        }  
            //add currency
             global $wpdb;

            // add currency also
      //      $wpdb->query("INSERT INTO {$wpdb->prefix}escrow_currency ( currency, symbol  ) VALUES ( 'USD' ,'USD')");


         //    email_notification_message();
             
             
        do_action("AistoreEscrow_Install");
        
        
        

echo "<strong>If no error then task completed successfully.</strong>";
        }
     
     
  $pages = get_pages();

?>
<table class="form-table">
 <form method="POST" action="" name="create_all_pages" enctype="multipart/form-data"> 
    <?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>
    
<p><?php _e(' Create all pages with short codes automatically to ', 'aistore')?>
<br><br>
<?php  _e( 'Escrow Admin Email ID: ', 'aistore' ) ?>
<input type="email" name="escrow_user_id" value="<?php echo esc_attr( get_option('escrow_user_name') ); ?>" required />

<input class="input" type="submit" name="submit" value="<?php _e('Click Here', 'aistore') ?>"/>
<input type="hidden" name="action"  value="create_all_pages"/></td></tr>
    </form>
    </table>
    <hr>



 

<p><?php _e('Create 8 pages with short codes and select here  ', 'aistore') ?></p>


<form method="post" action="options.php">
    <?php settings_fields('aistore_page'); ?>
    <?php do_settings_sections('aistore_page'); ?>
	
    <table class="form-table">
	
	 <tr valign="top">
        <th scope="row"><?php _e('Create Escrow form', 'aistore') ?></th>
        <td>
		<select name="add_escrow_page_id"  >
		 
		 
     <?php
        foreach ($pages as $page)
        {

            if ($page->ID == get_option('add_escrow_page_id'))
            {
                echo '	<option selected value="' .esc_attr( $page->ID ). '">' .esc_attr( $page->post_title) . '</option>';

            }
            else
            {

                echo '	<option value="' . esc_attr($page->ID ). '">' .esc_attr( $page->post_title) . '</option>';

            }
        } ?> 
	 
	 
</select>


<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_escrow_system] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>

</td>
        </tr>  
        
        	
	
	
		
		  <tr valign="top">
        <th scope="row"><?php _e('Escrow List page', 'aistore') ?></th>
        <td>
		<select name="list_escrow_page_id">
		  
		   <?php
        foreach ($pages as $page)
        {

            if ($page->ID == get_option('list_escrow_page_id'))
            {
                echo '	<option selected value="' . esc_attr($page->ID) . '">' .esc_attr( $page->post_title) . '</option>';

            }
            else
            {

                echo '	<option  value="' .esc_attr( $page->ID) . '">' .esc_attr( $page->post_title) . '</option>';

            }
        } ?> 

		   
		   
		   
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_escrow_list] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>




</td>
        </tr>  
		
		
		 <tr valign="top">
        <th scope="row"><?php _e('Escrow Details Page', 'aistore') ?></th>
        <td>
		<select name="details_escrow_page_id" >
		 
		 
		  <?php
        foreach ($pages as $page)
        {

            if ($page->ID == get_option('details_escrow_page_id'))
            {
                echo '	<option selected value="' .esc_attr( $page->ID) . '">' . esc_attr($page->post_title) . '</option>';

            }
            else
            {

                echo '	<option  value="' .esc_attr( $page->ID) . '">' . esc_attr($page->post_title) . '</option>';

            }
        } ?> 
	 
	 
		 
					  
					
 
</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_escrow_detail] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>





</td>
        </tr> 
        
        
    
        
    
        
        
        
        	 <tr valign="top">
        <th scope="row"><?php _e('Transaction History Page', 'aistore') ?></th>
        <td>
		<select name="aistore_transaction_history_page_id" >
		 
		 
		  <?php
        foreach ($pages as $page)
        {

            if ($page->ID == get_option('aistore_transaction_history_page_id'))
            {
                echo '	<option selected value="' .esc_attr( $page->ID) . '">' . esc_attr($page->post_title) . '</option>';

            }
            else
            {

                echo '	<option  value="' . esc_attr($page->ID ). '">' . esc_attr($page->post_title) . '</option>';

            }
        } ?> 

</select>

<p><?php _e('Create a page add this shortcode ', 'aistore') ?> <strong> [aistore_transaction_history] </strong> <?php _e('and then select that page here.', 'aistore') ?> </p>

</td>
        </tr>
        
       

        
         
        
        
        
        </table>
        
       
       
        	
  </div>
  
  
  
   
  
    <div class="tab-pane fade show  " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        
<p><?php _e('Step 2', 'aistore') ?></p>


<p><?php _e('Create an admin account and set its ID this will be used to hold payments ', 'aistore') ?></p>

        	
        <table class="form-table">
        
        <h3><?php _e('Admin Escrow Setting', 'aistore') ?></h3>
        
		 <tr valign="top">
        <th scope="row"><?php _e('Escrow Admin ID ', 'aistore') ?></th>
        <td>
		<select name="escrow_user_id" >
		 
		 
		  <?php
        $escrow_admin_user_id =esc_attr( get_option('escrow_user_id'));
        $blogusers = get_users(['role__in' => ['administrator']]);

        foreach ($blogusers as $user)
        {

            if ($user->ID == $escrow_admin_user_id)
            {
                echo '	<option selected value="' .esc_attr( $user->ID ). '">' . esc_attr($user->display_name ). '</option>';

            }
            else
            {

                echo '	<option  value="' . esc_attr($user->ID) . '">' . esc_attr($user->display_name) . '</option>';

            }
        } ?> 
  </tr>  
</select>

<?php 
 $_new_user_url = admin_url('user-new.php', 'https'); ?>
<p><?php _e('Add a new admin user with admin roll and then  ', 'aistore') ?><a href="<?php echo esc_url($_new_user_url); ?>">Click Here</a></p>

<p><?php _e('Add an user with admin roll and then select its ID here', 'aistore') ?></p>



        
        <?php   do_action("Aistorechat_system");
        ?>
 
        

 <tr valign="top">
 <th scope="row"><?php _e('Cancel Escrow fee refund or not ', 'aistore') ?></th>
        <td>
            <?php $cancel_escrow_fee =esc_attr( get_option('cancel_escrow_fee')); ?>
            
            <select name="cancel_escrow_fee" id="cancel_escrow_fee">
               
            <option selected value="yes" <?php selected($cancel_escrow_fee, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($cancel_escrow_fee, 'no'); ?>>No</option>
  
</select>
	
</td>
        </tr>  
       
      
              
  
    </table>
    
    <?php _e('  [ Admin who will manage escrow fee/disputes etc ]', 'aistore') ?>
  

    	<hr/>
        	 
  </div>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  <!----step 3 -->
   <div class="tab-pane fade show  " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        	
<p><?php _e('Step 3', 'aistore') ?></p>


<p><?php _e('Set fee here for the profits percentage ', 'aistore') ?></p>


        <table class="form-table">
        
        <h3><?php _e('Escrow Fee Setting', 'aistore') ?></h3>
         
         <tr valign="top">
 <th scope="row"><?php _e('when will the escrow fee be deducted  ', 'aistore') ?></th>
        <td>
            <?php $escrow_fee_deducted = esc_attr(get_option('escrow_fee_deducted')); ?>
            
            <select name="escrow_fee_deducted" id="escrow_fee_deducted">
                
               
            <option selected value="release" <?php selected($escrow_fee_deducted, 'release'); ?>>In Release</option>
            <option value="accepted" <?php selected($escrow_fee_deducted, 'accepted'); ?>>In Accepted</option>
  

</select>
	
</td>
        </tr>  
        
	 <tr valign="top">
        <th scope="row"><?php _e('Escrow Create Fee', 'aistore') ?></th>
        <td><input type="number" name="escrow_create_fee" value="<?php echo esc_attr(get_option('escrow_create_fee')); ?>" />%</td>
        </tr>
        
      <tr valign="top">
        <th scope="row"><?php _e('Escrow Accept Fee', 'aistore') ?></th>
        <td><input type="number" name="escrow_accept_fee" value="<?php echo esc_attr(get_option('escrow_accept_fee')); ?>" />%</td>
        </tr>
 
 
  
    </table>
    
 
    
  </div>
  
  
   
   
  
  
  <!--step 5 -->
  
  
    <div class="tab-pane fade show  " id="nav-contact1" role="tabpanel" aria-labelledby="nav-extension-tab">
        
        
          
    <p><?php _e('Step 5', 'aistore') ?></p>
    
<p><?php _e('Enable and Disable Extension ', 'aistore') ?></p>

        <?php
        $aistore_escrow_extensions=array();
          $aistore_escrow_extensions[] = 'wporg-is-awesome';
          
          
        $aistore_escrow_extensions = apply_filters( "aistore_escrow_extension",$aistore_escrow_extensions);
        
        
        var_dump($aistore_escrow_extensions);
        
        
        
        /*
        <table class="form-table">
        
      

      
        
 <tr valign="top">
 <th scope="row"><?php _e('Wallet', 'aistore') ?></th>
        <td>
            <?php $wallet_system = get_option('wallet_system'); ?>
            
            <select name="wallet_system" id="wallet_system">
               
            <option selected value="yes" <?php selected($wallet_system, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($wallet_system, 'no'); ?>>No</option>
  
</select>
	
</td>
        </tr>  
        
         <tr valign="top">
 <th scope="row"><?php _e('Chat', 'aistore') ?></th>
        <td>
            <?php $chat_system = get_option('chat_system'); ?>
            
            <select name="chat_system" id="chat_system">
               
            <option selected value="yes" <?php selected($chat_system, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($chat_system, 'no'); ?>>No</option>
  
</select>
	
</td>
        </tr> 
        
          <tr valign="top">
 <th scope="row"><?php _e('File Upload', 'aistore') ?></th>
        <td>
            <?php $file_upload_system = get_option('file_upload_system'); ?>
            
            <select name="file_upload_system" id="file_upload_system">
               
            <option selected value="yes" <?php selected($file_upload_system, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($file_upload_system, 'no'); ?>>No</option>
  
</select>
	
</td>
        </tr> 
        
        
         <tr valign="top">
 <th scope="row"><?php _e('Notification', 'aistore') ?></th>
        <td>
            <?php $notification_system = get_option('notification_system'); ?>
            
            <select name="notification_system" id="notification_system">
               
            <option selected value="yes" <?php selected($notification_system, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($notification_system, 'no'); ?>>No</option>
  
</select>
	
</td>
        </tr> 
        
        
         <tr valign="top">
 <th scope="row"><?php _e('Email', 'aistore') ?></th>
        <td>
            <?php $email_system = get_option('email_system'); ?>
            
            <select name="email_system" id="email_system">
               
            <option selected value="yes" <?php selected($email_system, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($email_system, 'no'); ?>>No</option>
  
</select>
	
</td>
        </tr> 
        
        
        
        
         <tr valign="top">
 <th scope="row"><?php _e('Currency Convert', 'aistore') ?></th>
        <td>
            <?php $currency_convert_system = get_option('currency_convert_system'); ?>
            
            <select name="currency_convert_system" id="currency_convert_system">
               
            <option selected value="yes" <?php selected($currency_convert_system, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($currency_convert_system, 'no'); ?>>No</option>
  
</select>
	
</td>
        </tr> 
        
        
        
         <tr valign="top">
 <th scope="row"><?php _e('Payment Gateway', 'aistore') ?></th>
        <td>
            <?php $payment_gateway_system = get_option('payment_gateway_system'); ?>
            
            <select name="payment_gateway_system" id="payment_gateway_system">
               
            <option selected value="yes" <?php selected($payment_gateway_system, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($payment_gateway_system, 'no'); ?>>No</option>
  
</select>
	
</td>
        </tr> 
        
         
         <tr valign="top">
 <th scope="row"><?php _e('Bank Payment', 'aistore') ?></th>
        <td>
            <?php $bank_payment_system = get_option('bank_payment_system'); ?>
            
            <select name="bank_payment_system" id="bank_payment_system">
               
            <option selected value="yes" <?php selected($bank_payment_system, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($bank_payment_system, 'no'); ?>>No</option>
  
</select>
	
</td>
        </tr> 
        
         <tr valign="top">
 <th scope="row"><?php _e('Withdraw', 'aistore') ?></th>
        <td>
            <?php $withdraw_system = get_option('withdraw_system'); ?>
            
            <select name="withdraw_system" id="withdraw_system">
               
            <option selected value="yes" <?php selected($withdraw_system, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($withdraw_system, 'no'); ?>>No</option>
  
</select>
	
</td>
        </tr> 
        
        
        </table>
    */
    
    ?>
        </div>
        
        
        
            
     <?php
   
  do_action( "aistore_escrow_admin_tab_contents"  );
  
  ?> 
     
  
  
        
  </div>



  
      
</div>
</div>

