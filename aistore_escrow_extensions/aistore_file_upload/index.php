<?php
/*
Plugin Name: Saksh Escrow File upload option
Version:  2.1
Stable tag: 2.1
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Saksh Escrow System is a plateform allow parties to complete safe payments.  


*/

$status=  escrow_extension('file_upload');
// echo "status".$status;
 if($status == 'Disable'){
    exit();
 }


include "aistore_escrow_file_upload.php";
include "admin_setting.php";

function AFU_extension_function( $aistore_escrow_extensions ) {
   
        $aistore_escrow_extensions[] = 'file_upload';
  
    return $aistore_escrow_extensions;
}
add_filter( 'aistore_escrow_extension', 'AFU_extension_function' );

  add_action('aistore_escrow_admin_tab_contents', 'AFU_admin_tab_contents_file_upload' ); 
    

function  AFU_admin_tab_contents_file_upload()

{
    ?>
      <div class="tab-pane fade" id="nav-fileupload" role="tabpanel" aria-labelledby="nav-fileupload-tab">
      
 
        <?php
        do_action('Aistoreupload_file_type');
         submit_button(); ?>
        
  
  
  
  </div>
  
  
  <?php
    
    
}

    add_action('aistore_escrow_admin_tab', 'AFU_tab' ); 
    

function  AFU_tab()

{
 echo  '
    <button class="nav-link" id="nav-fileupload-tab" data-bs-toggle="tab" data-bs-target="#nav-fileupload" type="button" role="tab" aria-controls="nav-fileupload" aria-selected="false">File Upload</button> 
     
     ';
    
 
}
