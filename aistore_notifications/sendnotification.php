<?php
add_action('Aistore_Escrow_Created', 'aistore_escrow_sendNotificationCreated', 10, 3);
add_action('AistorEscrowAccepted', 'aistore_escrow_sendNotificationAccepted', 10, 3);
add_action('AistorEscrowCancelled', 'aistore_escrow_sendNotificationCancelled', 10, 3);
add_action('AistorEscrowDisputed', 'aistore_escrow_sendNotificationDisputed', 10, 3);
add_action('AistorEscrowReleased', 'aistore_escrow_sendNotificationReleased', 10, 3);

function aistore_escrow_sendNotificationCreated($escrow) {
    //global $wpdb;
    $eid = $escrow->id;
    //$escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%d ", $eid));
    
    
    $details_escrow_page_id_url = $escrow->url;
    
    
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    
    
    $msg = get_option('created_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    
    
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    $n['user_email'] = $user_email;
   
   
    aistore_notification_new($n);
    $msg = get_option('partner_created_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    
    
    $n['message'] = $msg;
    $n['user_email'] = $party_email;
    aistore_notification_new($n);
    
    
}

function aistore_escrow_sendNotificationAccepted($escrow) {
    global $wpdb;
    $eid = $escrow->id;
   
    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    $msg = get_option('accept_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    $n['user_email'] = $user_email;
    aistore_notification_new($n);
    $msg = get_option('partner_accept_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n['message'] = $msg;
    $n['user_email'] = $party_email;
    aistore_notification_new($n);
}

function aistore_escrow_sendNotificationCancelled($escrow) {
    global $wpdb;
    $eid = $escrow->id;
    
    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    $msg = get_option('cancel_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    $n['user_email'] = $user_email;
    aistore_notification_new($n);
    $msg = get_option('partner_cancel_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n['message'] = $msg;
    $n['user_email'] = $party_email;
    aistore_notification_new($n);
}

function aistore_escrow_sendNotificationDisputed($escrow) {
    global $wpdb;
    $eid = $escrow->id;
    
    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    $msg = get_option('dispute_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    $n['user_email'] = $user_email;
    aistore_notification_new($n);
    $msg = get_option('partner_dispute_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n['message'] = $msg;
    $n['user_email'] = $party_email;
    aistore_notification_new($n);
}

function aistore_escrow_sendNotificationReleased($escrow) {
    global $wpdb;
    $eid = $escrow->id;
    
    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    $msg = get_option('release_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n = array();
    $n['message'] = $msg;
    $n['type'] = "success";
    $n['reference_id'] = $eid;
    $n['url'] = $details_escrow_page_id_url;
    $n['user_email'] = $user_email;
    aistore_notification_new($n);
    $msg = get_option('partner_release_escrow');
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n['message'] = $msg;
    $n['user_email'] = $party_email;
    aistore_notification_new($n);
}

function aistore_notification_new($n) {
    
    global $wpdb;
    $q1 = $wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_notification (  message,type, user_email,url ,reference_id) VALUES ( %s, %s, %s, %s, %s ) ", array($n['message'], $n['type'], $n['user_email'], $n['url'], $n['reference_id']));
    // qr_to_log($q1);
    $wpdb->query($q1);
}
