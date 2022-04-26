<?php


function aistore_send_email($n  ){
    
	 if ( !is_user_logged_in() ) {
    return "" ;
}
	
   global $wpdb;
 
   $q1=$wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_email (message,type, user_email,url ,reference_id,subject) VALUES ( %s, %s, %s, %s, %s ,%s) ", array( $n['message'],$n['type'], $n['user_email'], $n['url'], $n['reference_id'],$n['subject']));
   
   // qr_to_log($q1);
	
	
     $wpdb->query($q1);
    
   
}
?>