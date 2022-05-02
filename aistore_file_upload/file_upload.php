<?php
 add_filter( 'after_aistore_escrow_form', 'after_aistore_escrow_form_fields' );
  
     function  after_aistore_escrow_form_fields($eid){
         
         
         
         
         
         ?>
         <!--<label for="file_name"><?php _e('file_name', 'aistore'); ?>:</label><br>-->
 <!--<input class="input" type="file" id="file_name" name="file_name" required><br>-->
          
 <?php 
    $set_file =  get_option('escrow_file_type');
    ?>

	<label for="documents"><?php _e('Documents22', 'aistore') ?>: </label>
     <input type="file" name="file"    /><br>
     <div><p> <?php _e('Note : We accept only '.$set_file.' file and
	You can upload many pdf file then go to next escrow details page.', 'aistore') ?></p></div>
	
	<?php 
              
         
     }
     
     
     
     add_action('AistorEscrowFiles', 'aistore_escrow_files', 10, 3);

function aistore_escrow_files($escrow)
{
          $eid = $escrow->id;

        global $wpdb;

        $escrow_documents = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_documents WHERE eid=%d", $eid));

?> 
  
    <table class="table">
    <?php
        foreach ($escrow_documents as $row):

?> 
	
	<div class="document_list">
   


  <p><a href="<?php echo esc_url($row->documents); ?>" target="_blank">
	       <b><?php echo esc_attr($row->documents_name); ?></b></a></p>
  <h6 > <?php echo esc_attr($row->created_at); ?></h6>
</div>

<hr>
    
    <?php
        endforeach;

?>
    </table>
<br>
	 <?php
}
     add_action('AistorEscrowCreated', 'process_file_upload', 10, 3);

function process_file_upload($escrow)
{
   
     global $wpdb;
      $user_id = get_current_user_id();
    
      $set_file =  get_option('escrow_file_type');
                
            $fileType = $_FILES['file']['type'];

            if ($fileType == "application/".$set_file)
            {
                $upload_dir = wp_upload_dir();

                if (!empty($upload_dir['basedir']))
                {

                    $user_dirname = $upload_dir['basedir'] . '/documents/' . $escrow['id'];
                    if (!file_exists($user_dirname))
                    {
                        wp_mkdir_p($user_dirname);
                    }

                    $filename = wp_unique_filename($user_dirname, $_FILES['file']['name']);
                    move_uploaded_file(sanitize_text_field($_FILES['file']['tmp_name']) , $user_dirname . '/' . $filename);

                    $image = $upload_dir['baseurl'] . '/documents/' . $escrow['id'] . '/' . $filename;

                    // save into database  $image
                      $object_escrow = new AistoreEscrowSystem();
        $ipaddress = $object_escrow->aistore_ipaddress();



                    $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_documents ( eid, documents,user_id,documents_name,ipaddress) VALUES ( %d,%s,%d,%s,%s)", array(
                        $escrow['id'],
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