<?php


class Aistorechat {
    
    public static function aistore_escrow_chat(){
        
        ?>
           <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


 

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
 <style>
     
.container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%;
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
 </style>
 
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


add_action('wp_ajax_custom_action', 'aistore_st_chat_box');

function aistore_st_chat_box()
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

add_action('wp_ajax_aistore_st_ticket_message_discussion_list', 'aistore_st_ticket_message_discussion_list');

function aistore_st_ticket_message_discussion_list()
{
    

    global $wpdb;
    $eid= sanitize_text_field($_REQUEST['eid']);

    
   $results = $wpdb->get_results( 
                     $wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_discussion WHERE eid=%d  order by id asc limit 100",$eid) 

                 );   

 
 echo json_encode($results);
 

    wp_die();
}



add_action('wp_ajax_aistore_st_ticket_list_chat', 'aistore_escrow_list_chat');

function aistore_escrow_list_chat()
{
           $user_id= get_current_user_id();
 $current_user_email_id = get_the_author_meta('user_email', $user_id);

        global $wpdb;

        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE receiver_email=%s or sender_email=%s order by id desc ", $current_user_email_id, $current_user_email_id));



 echo json_encode($results);
  wp_die();
}