<?php


class Aistorechat {
    
    public static function ACS_escrow_chat(){
        
        ?>


<div class="container">
<h3 class=" text-center">Messaging</h3>
<div class="messaging">
      <div class="inbox_msg">
          <?php
      global $wpdb;

       $eid= sanitize_text_field($_REQUEST['eid']);
       
       $user_id = get_current_user_id();

        
              ?>
         <div class="inbox_people" >
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Recent</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <input type="text" class="search-bar"  placeholder="Search" >
                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
            </div>
          </div>
             <div class="inbox_chat">
                  <div id="items-container" class="row"></div>
        
        
         </div>
	</div>
        <div class="mesgs">
      <div class="msg_history"> 
       <div id="items-container_message"></div>
         </div>

          Type your message
          <form class="wordpress-ajax-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>"  >
<?php
 
        wp_nonce_field('aistore_nonce_action', 'aistore_nonce');
?>
          <div class="type_msg">
            <div class="input_msg_write">
                <input type="hidden" name="action" value="custom_action" />
                
 <input type="hidden" name="eid"  id="eid"  value="<?php echo $eid; ?>"/>
  
 <?php      $user_id= get_current_user_id();
 ?>
  <input type="hidden" name="user_id" id="user_id"  value="<?php echo $user_id; ?>"/>
  
              <input type="text" class="write_msg" placeholder="Type a message" name="message"/>
              
              <button class="msg_send_btn" type="submit" name="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
          
          </form> 
        </div>
      </div>
      
      
    </div></div>
     
<?php
    }
    
}


add_action('wp_ajax_custom_action', 'ACS_chat_box');

function ACS_chat_box()
{

    global $wpdb;

    if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
    {
        return _e('Sorry, your nonce did not verify.', 'aistore');
    }

    $message = sanitize_text_field(htmlentities($_POST['message']));
    $eid = sanitize_text_field($_POST['eid']);

     $user_login = get_the_author_meta('user_login', get_current_user_id());


   $user_id=  get_current_user_id();

$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}escrow_discussion ( message, eid,user_login,user_id ) VALUES (  %s, %s, %s ,%s)", 
array( $message, $eid,$user_login ,$user_id) ) );


    wp_die();

}

add_action('wp_ajax_ACS_message_discussion_list', 'ACS_message_discussion_list');

function ACS_message_discussion_list()
{
    

    global $wpdb;
    $eid= sanitize_text_field($_REQUEST['eid']);

    
   $results = $wpdb->get_results( 
                     $wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_discussion WHERE eid=%d  order by id asc limit 100",$eid) 

                 );   

 
 echo json_encode($results);
 

    wp_die();
}



add_action('wp_ajax_ACS_list_chat', 'ACS_list_chat');

function ACS_list_chat()
{
           $user_id= get_current_user_id();
 $current_user_email_id = get_the_author_meta('user_email', $user_id);

        global $wpdb;

        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE receiver_email=%s or sender_email=%s order by id desc ", $current_user_email_id, $current_user_email_id));



 echo json_encode($results);
  wp_die();
}