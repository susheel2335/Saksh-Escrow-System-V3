<?php 

add_shortcode('aistore_notification', 'aistore_echo_all_notification');


function aistore_echo_all_notification()
{
	 
ob_start();
 if ( !is_user_logged_in() ) {
    return "Please login to see your notifications" ;
}

$user_email = get_the_author_meta('user_email', get_current_user_id());
  

    global $wpdb;

    $sql = "SELECT * FROM {$wpdb->prefix}escrow_notification WHERE user_email='$user_email'   order by id desc limit 10";
	
	 

  $v1= $wpdb->get_results($sql );
	 
	foreach ($v1 as $row):
            
?> 
  
  <div class="discussionmsg">
   
  <p><a href="<?php echo esc_url($row->url); ?>"> <?php echo html_entity_decode($row->message); ?> </a> </p>
  
  
  <h6 > <?php echo esc_attr($row->created_at); ?></h6>
</div>
 
<hr>
    
    <?php
        endforeach;  
	
 return ob_get_clean();	

}




      
    function  aistore_echo_notification_of_escrow($eid){
  
           	global $wpdb;
            
 $sql = "SELECT * FROM {$wpdb->prefix}escrow_notification WHERE  {$wpdb->prefix}escrow_notification.reference_id=".$eid." order by id desc";
 
     	 $results = $wpdb->get_results($sql);
     	  if ($results == null)
        {
            _e("No Notification Found", 'aistore');

        }
        else
        {
            ?>
               <h1> <?php _e('System Notifications', 'aistore') ?> </h1>
   
          <table  id="example1" class="widefat striped fixed"  >
      
        <thead>
     <tr>
            <th><?php _e('ID', 'aistore'); ?></th>
          <th><?php _e('Email', 'aistore'); ?></th>
     <th><?php _e('Message', 'aistore'); ?></th>
      <th><?php _e('Date', 'aistore'); ?></th>
   
    
     </tr>
      </thead>
<tbody>
     <?php
 	foreach ($results as $row):
            
?> 
  
    <tr>
        <td> 	 
		   <?php echo esc_attr($row->id); ?></td>
           <td> 	 
		   <?php echo esc_attr($row->user_email); ?></td>
		   <td> <?php echo html_entity_decode($row->message); ?></td>
		     <td><?php echo esc_attr($row->created_at); ?></td>

    </tr>
            
            </tbody>
    <?php
        endforeach;
    ?>
    
   
        </table>    <?php } ?>
     <br><br>
    
    
    <?php
    }
    
    
    
    
    
    
    
    




 function aistore_echo_notification( ){
	 if ( !is_user_logged_in() ) {
    return "Please login to see your notifications" ;
}
$user_email = get_the_author_meta('user_email', get_current_user_id());
    global $wpdb;
	
	
$notification = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}escrow_notification WHERE   user_email = '".   $user_email."' and status =0 order by id   desc  limit 1"   );
 
 
 
 

	
	
	 if(isset($notification->type))
	 {
		  $qr=$wpdb->prepare("UPDATE {$wpdb->prefix}escrow_notification
    SET  status =  status+1   WHERE id =  %d ", $notification->id);
	
    $wpdb->query($qr);
	
	
return ' <div class="alert alert-'.esc_attr($notification->type) .'" role="alert"> '.esc_attr( $notification->message).'</div>';
	 }

else
return "";

 			
}
 
function aistore_notification($notification,$type="success",$user_login="" ){
	 if ( !is_user_logged_in() ) {
    return "Please login to see your notifications" ;
}
	 if($user_login=="")
	 {
 	$user_login = get_the_author_meta('user_login', get_current_user_id());
	 }
	
   global $wpdb;
 
 
  

   $q1=$wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_notification (  message,type, user_email ) VALUES ( %s, %s, %s ) ", array(  $notification,$type, $user_login));
     $wpdb->query($q1);
   
   
}


function aistore_notification_new($n  ){
	 if ( !is_user_logged_in() ) {
    return "" ;
}/*
	$n=array();
	$n['message']="test notification msg";
	
	$n['type']="success";
	$n['url']="localhost";
	
	$n['user_login']=$login_email;
	*/
	
	 
	//$n['user_email']=$n['user_login'];
	
   global $wpdb;
 
 
   
   $q1=$wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_notification (  message,type, user_email,url ,reference_id) VALUES ( %s, %s, %s, %s, %s ) ", array( $n['message'],$n['type'], $n['user_email'], $n['url'], $n['reference_id']));
   
   // qr_to_log($q1);
	
	
     $wpdb->query($q1);
    
   
}




 