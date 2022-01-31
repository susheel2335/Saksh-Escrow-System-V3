<?php
  // transaction List
  function aistore_transaction_by_vendor()
    {
if (!is_user_logged_in())
    {
        return "<div class='no-login'>Kindly login and then visit this page </div>";
    }
    ?>
   

    <?php
    
 global $wpdb;
     $user_id = get_current_user_id(); 
       $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
    
       if (isset($_POST['submit']) and $_POST['action'] == 'upload_document')
        {
            
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
          $vendor_id = sanitize_text_field($_REQUEST['vendor_id']);
                
            $fileType = $_FILES['file']['type'];
         $upload_dir = wp_upload_dir();

                if (!empty($upload_dir['basedir']))
                {

                    $user_dirname = $upload_dir['basedir'] . '/documents/' . $vendor_id;
                    if (!file_exists($user_dirname))
                    {
                        wp_mkdir_p($user_dirname);
                    }

                    $filename = wp_unique_filename($user_dirname, $_FILES['file']['name']);
                    move_uploaded_file(sanitize_text_field($_FILES['file']['tmp_name']) , $user_dirname . '/' . $filename);

                    $image = $upload_dir['baseurl'] . '/documents/' . $vendor_id . '/' . $filename;
                    
                     
         $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}vendor
    SET image = '%s' WHERE id = '%d' and user_id=%s  and company_id=%s", $image,$vendor_id,$user_id,$company->company_id));
                    
     
}

}
 if( empty( $_REQUEST['vendor_id'] ) ){
     
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions where user_id=%s and company_id=%s  order by transaction_id desc ", $user_id,$company->company_id));
    
//  $sql = "SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions order by transaction_id desc";
			}
		
		else{
		  
$vendor_id=sanitize_text_field($_REQUEST['vendor_id']);

 $vendors = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}vendor where id=%s and user_id=%s and company_id=%s ", $vendor_id,$user_id,$company->company_id));
 
  $invoice = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}invoice where id=%s and user_id=%s and company_id=%s ", $vendor_id,$user_id,$company->company_id));
  
  $estimate = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}estimate where id=%s and user_id=%s and company_id=%s  ", $vendor_id,$user_id,$company->company_id));
   
   
  
 $totalcredit = $wpdb->get_var($wpdb->prepare("SELECT SUM(amount) as totalamount FROM {$wpdb->prefix}aistore_wallet_transactions where  type = 'credit' and vendor=%s and user_id=%s and company_id=%s  ",$vendors->vendor_name,$user_id,$company->company_id));
 
  $totaldebit = $wpdb->get_var($wpdb->prepare("SELECT SUM(amount) as totalamount FROM {$wpdb->prefix}aistore_wallet_transactions where  type = 'debit' and vendor=%s and user_id=%s and company_id=%s ",$vendors->vendor_name,$user_id,$company->company_id));
 
$totalsum=    $totalcredit - $totaldebit  ;
 
 $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions where user_id=%s and vendor=%s and company_id=%s  order by transaction_id desc ", $user_id,$vendors->vendor_name,$company->company_id));
     
// $sql = ($wpdb->prepare("SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions where vendor=%s ", $vendors->vendor_name));

}
//   $results=   $wpdb->get_results($sql);


?></div>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"> Profile</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"> Invoice</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"> Estimate</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab" aria-controls="transactions" aria-selected="false">Transactions</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <h2>Profile</h2>
  Name: <?php echo $vendors->vendor_name; ?><br>
  Email: <?php echo $vendors->vendor_email; ?><br>
   <img src="<?php echo $vendors->image; ?>">
  <form method="POST" action="" name="upload_document" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

<input class="input" type="hidden" id="vendor_id" name="vendor_id" value="<?php echo $vendor_id; ?>"><br><br>

<label for="title"><?php _e('Upload Documents', 'aistore'); ?></label><br>
<input class="input" type="file" id="file" name="file" ><br><br>
  <input 
 type="submit" class="btn" name="submit" value="<?php _e('Upload', 'aistore') ?>"/>
<input type="hidden" name="action" value="upload_document" />
</form> 
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      
      
      <h2>No Invoice</h2></div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">  <h2>No Estimate</h2></div>
  
    <div class="tab-pane fade" id="transactions" role="tabpanel" aria-labelledby="transactions-tab"> <br><br>
<h3><u><?php _e('Transactions', 'aistore'); ?></u> </h3>
<?php
        if ($results == null)
        {
            echo "<div class='no-result'>";

            _e('Transactions List Not Found', 'aistore');
            echo "</div>";
        }
        else
        {

            ob_start();

?>
  
    <table class="table">
     
<tr><td  colspan="4">Total Sum : </td><td colspan="4"><?php echo $totalsum; ?>/-</td></tr>
    </table>
	
    <?php
}

?></div>
    
</div></div>
<?php
    }