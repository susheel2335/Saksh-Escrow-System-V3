<?php


add_action('wp_ajax_custom_action', 'aistore_upload_file');

function aistore_upload_file()
{

    global $wpdb;
    $eid = sanitize_text_field($_REQUEST['eid']);

    $user_id = get_current_user_id();

  $object_escrow = new AistoreEscrowSystem();
        $ipaddress = $object_escrow->aistore_ipaddress();

    $email_id = get_the_author_meta('user_email', get_current_user_id());
    $escrow = $wpdb->get_row($wpdb->prepare("SELECT count(id) as count FROM {$wpdb->prefix}escrow_system WHERE ( sender_email = '" . $email_id . "' or receiver_email = '" . $email_id . "' ) and id=%s ", $eid));

    $c = (int)$escrow->count;
    if ($c > 0)
    {

        if (isset($_POST['aistore_nonce']))
        {
            $upload_dir = wp_upload_dir();

            if (!empty($upload_dir['basedir']))
            {
                $user_dirname = $upload_dir['basedir'] . '/documents/' . $eid;
                if (!file_exists($user_dirname))
                {
                    wp_mkdir_p($user_dirname);
                }
                $fileType = $_FILES['file']['type'];
                 $set_file =  get_option('escrow_file_type');
                if ($fileType == "application/".$set_file)
                {
                    $filename = wp_unique_filename($user_dirname, $_FILES['file']['name']);

                    
                    move_uploaded_file(sanitize_text_field($_FILES['file']['tmp_name']) , $user_dirname . '/' . $filename);

                    $image = $upload_dir['baseurl'] . '/documents/' . $eid . '/' . $filename;
                    //             // save into database $image;
                    

                    $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_documents ( eid, documents,user_id,documents_name,ipaddress) VALUES ( %d,%s,%d,%s,%s)", array(
                        $eid,
                        $image,
                        $user_id,
                        $filename,
                        $ipaddress
                    )));
                }

                else
                {
                    $set_file =  get_option('escrow_file_type');
                    echo "We accept only ".esc_attr($set_file)." file";
                }
            }
        }

        wp_die();
    }
    else
    {
 _e('Unauthorized user', 'aistore') ;
    }

}

add_action('wp_ajax_custom_action', 'aistore_chat_box');

function aistore_chat_box()
{

    global $wpdb;

    if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
    {
        return _e('Sorry, your nonce did not verify.', 'aistore');
    }

    $message = sanitize_text_field(htmlentities($_POST['message']));
    $escrow_id = sanitize_text_field($_POST['escrow_id']);

    $user_login = get_the_author_meta('user_login', get_current_user_id());

    //issue 1
    

    $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_discussion ( eid, message, user_login ) VALUES ( %d, %s, %s ) ", array(
        $escrow_id,
        $message,
        $user_login
    )));

    wp_die();

}

add_action('wp_ajax_escrow_discussion', 'aistore_escrow_discussion');

function aistore_escrow_discussion()
{

    global $wpdb;
    $id = sanitize_text_field($_REQUEST['id']);

    $user_email = get_the_author_meta('user_email', get_current_user_id());

    $discussions = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_discussion ed , {$wpdb->prefix}escrow_system es WHERE ed.eid= es.id and ed.eid=%s and (es.sender_email=%s or es.receiver_email=%s ) order by ed.id desc", $id, $user_email, $user_email));

    foreach ($discussions as $row):

?> 
	
	<div class="discussionmsg">
   
  <p><?php echo html_entity_decode($row->message); ?></p>
  
  <br /><br />
  <b><?php echo esc_attr($row->user_login); ?> </b>
  <h6 > <?php echo esc_attr($row->created_at); ?></h6>
</div>
 
<hr>
    
    <?php
    endforeach;

    wp_die();
}