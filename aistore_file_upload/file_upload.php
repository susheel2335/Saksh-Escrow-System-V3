<?php
 add_filter( 'after_aistore_escrow_form', 'after_aistore_escrow_form_fields' );
  
     function  after_aistore_escrow_form_fields($eid){
         
         
         
         
         
         ?>
         <label for="file_name"><?php _e('file_name', 'aistore'); ?>:</label><br>
 <input class="input" type="email" id="file_name" name="file_name" required><br>
          
 <?php 
    $set_file =  get_option('escrow_file_type');
    ?>

	<label for="documents"><?php _e('Documents', 'aistore') ?>: </label>
     <input type="file" name="file"    /><br>
     <div><p> <?php _e('Note : We accept only '.$set_file.' file and
	You can upload many pdf file then go to next escrow details page.', 'aistore') ?></p></div>
	
	<?php 
              
         
     }
     
     
     add_action('AistorEscrowCreated', 'process_file_upload', 10, 3);

function process_file_upload($escrow)
{
    
    
    
    
    
    
    // Create post object
$my_post = array(
  'post_title'    =>  __LINE__,
  'post_content'  =>  print_r($escrow,true),
  'post_status'   => 'publish',
  'post_author'   => 1 
);
 
// Insert the post into the database
wp_insert_post( $my_post );
    
    
}