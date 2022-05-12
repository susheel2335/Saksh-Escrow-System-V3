<?php
 add_filter( 'after_aistore_escrow_form', 'after_aistore_escrow_form_fields' );
  
     function  after_aistore_escrow_form_fields($eid){
         
      
    $set_file =  get_option('escrow_file_type');
    ?>

	<label for="documents"><?php _e('File to attach', 'aistore') ?>: </label>
     <input type="file" name="file"    /><br>
     <div><p> <?php _e('Note : We accept only '.$set_file.' file and
	You can upload many pdf file then go to next escrow details page.', 'aistore') ?></p></div>
	
	<?php 
              
         
     }
     
   //  aistore_escrow_tab_button
     
     add_filter('aistore_escrow_tab_button', 'aistore_escrow_files_tab_button', 10); 
     
     function aistore_escrow_files_tab_button($escrow)
{
    
    ?>
      <button class="nav-link" id="nav-files-tab" data-bs-toggle="tab" data-bs-target="#nav-files" type="button" role="tab" aria-controls="nav-files" aria-selected="false">Files and documents</button>
      
      <?php
      
    
}




    add_filter('aistore_escrow_tab_contents', 'aistore_escrow_files_tab_contents' ); 
     
     function aistore_escrow_files_tab_contents($escrow)
{
     
    ?>
     
   <div class="tab-pane fade show active" id="nav-files" role="tabpanel" aria-labelledby="nav-files-tab">
        
 <?php   aistore_escrow_files($escrow); ?>
 
 
  </div>
     
      <?php
     
   
}








 

function aistore_escrow_files($escrow)
{
    
     
    
    
          $eid = $escrow->id;

        global $wpdb;

        $escrow_documents = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_documents WHERE eid=%d", $eid));


        foreach ($escrow_documents as $row):

?> 
	
	<div class="aistore_document_list">
   



<a href="<?php echo esc_url($row->documents); ?>" target="_blank">
	       <b><?php echo esc_attr($row->documents_name); ?></b></a>
	       <br />
  <h6 > <?php echo esc_attr($row->created_at); ?></h6>
  
<hr>
</div>

    
    <?php
        endforeach;



}
     
     
     
     
add_action('AistoreEscrowCreatedafter', 'process_file_upload', 10, 3);

function process_file_upload($data)
{
   /*
   
   // Create post object
$my_post = array(
  'post_title'    => __LINE__,
  'post_content'  => print_r($data ,true),
  'post_status'   => 'publish' 
);
 
// Insert the post into the database
wp_insert_post( $my_post );  // Create post object
$my_post = array(
  'post_title'    => __LINE__,
  'post_content'  => print_r($data['escrow'],true),
  'post_status'   => 'publish' 
);
 
// Insert the post into the database
wp_insert_post( $my_post );


   // Create post object
$my_post = array(
  'post_title'    => __LINE__,
  'post_content'  => print_r($data['files'],true),
  'post_status'   => 'publish' 
);
 
// Insert the post into the database
wp_insert_post( $my_post );
*/


$files=$data['files'];
$escrow=$data['escrow'];

$eid= $escrow->id;

     global $wpdb;
      $user_id = get_current_user_id();
    
      $set_file =  get_option('escrow_file_type');
                
            $fileType = $files['file']['type'];

             if ($fileType == "application/".$set_file)
            {
                $upload_dir = wp_upload_dir();

                if (!empty($upload_dir['basedir']))
                {

                    $user_dirname = $upload_dir['basedir'] . '/documents/' . $eid;
                    
                    
                    
                    if (!file_exists($user_dirname))
                    {
                        wp_mkdir_p($user_dirname);
                    }

                    $filename = wp_unique_filename($user_dirname, $files['file']['name']);
                    move_uploaded_file(sanitize_text_field($files['file']['tmp_name']) , $user_dirname . '/' . $filename);

                    $image = $upload_dir['baseurl'] . '/documents/' . $eid . '/' . $filename;

                    // save into database  $image
                      $object_escrow = new AistoreEscrowSystem();
        $ipaddress = $object_escrow->aistore_ipaddress();



                    $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_documents ( eid, documents,user_id,documents_name,ipaddress) VALUES ( %d,%s,%d,%s,%s)", array(
                        $eid,
                        $image,
                        $user_id,
                        $filename,
                        $ipaddress
                    )));
    
                
    

            }
            
            }
            
             
            else
            {
                                
?>
            <p> <?php _e('Note : We accept only '.$set_file.' file', 'aistore') ?></p><?php
            }

    
}