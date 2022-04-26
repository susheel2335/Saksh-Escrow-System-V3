<?php

    
/*

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
*/