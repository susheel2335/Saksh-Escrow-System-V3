<?php

// add user id in the fetching data 


function aistore_csv_data(){
    
    
    //  $file_path = 'https://csvdata.blogentry.in/wp-content/uploads/documents/csvdata/wpcs_aistore_wallet_transactions.csv';
                    
    //                 echo $file_path;
                   
           
  global $wpdb;
  $bank_id = sanitize_text_field($_REQUEST['id']);
   $user_id = get_current_user_id();
 
 $results = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bank where id=%s ", $bank_id));
            
  $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));          
            // echo $results->bank_name;
            
            
      if (isset($_POST['submit']) and $_POST['action'] == 'escrow_system')
        {
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
         //   echo "ghgh";
            
            
              
                 $bank_name = sanitize_text_field($_REQUEST['bank_name']);
            $fileType = $_FILES['file']['type'];
// echo $fileType;
            // if ($fileType == "application/csv")
            // {
                $upload_dir = wp_upload_dir();
// echo "upload_dir".$upload_dir;

                if (!empty($upload_dir['basedir']))
                {

                    $user_dirname = $upload_dir['basedir'] . '/documents/csvdata/';
                    if (!file_exists($user_dirname))
                    {
                        wp_mkdir_p($user_dirname);
                    }
                    // echo "user_dirname".$user_dirname;

                    $filename = wp_unique_filename($user_dirname, $_FILES['file']['name']);
                    move_uploaded_file(sanitize_text_field($_FILES['file']['tmp_name']) , $user_dirname . '/' . $filename);

                    $file_path = $upload_dir['baseurl'] . '/documents/csvdata/' . $filename;
                    
                  //  echo $file_path;
                    
                    //   $filedata = file_get_contents($file_path);
       
        if (($open = fopen($file_path, "r")) !== FALSE) 
  {
  
    while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
    {        
      $array[] = $data; 
    }
  
    fclose($open);
  }

            foreach ($array as $c)
            {
print_r($c);
  global $wpdb;
 $q1 = $wpdb->prepare("INSERT INTO {$wpdb->prefix}aistore_wallet_transactions  (transaction_id,amount, description,type, balance, user_id, currency ,date,bank_name,created_by,comapny_id) VALUES (%s,%s, %s,%s,%s,%s,%s ,%s,%s ,%s,%s)", array(
            $c[0],
            $c[4],
            $c[6],
            $c[3],
            $c[5],
            $c[1],
            $c[7],
            $c[9],
            $bank_name,
            $user_id,
            $company->company_id
        ));

        $wpdb->query($q1);
      //  echo $q1;
            }
 
                }
            
        }
        else{
            
        
   ?>
   <div>

  <form method="POST" action="" name="escrow_system" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>


 <input type="hidden" name="bank_name" value="<?php echo $results->bank_name;?> ">
 
	<label for="documents"> <?php _e('CSV Documents', 'aistore'); ?> : </label><br>
 <input type="file" name="file"    /><br>
     <div><p> <?php _e('Note : We accept only csv file.', 'aistore') ?></p></div>

<input 
 type="submit" class="btn" name="submit" value="<?php _e('Submit', 'aistore') ?>"/>
<input type="hidden" name="action" value="escrow_system" />
</form></div>
   <?php
        }
}



