 

     
jQuery(document).ready(function($) {

 

	  $.ajax({
        type: "GET",
     url : ajax_object.ajax_url,
     dataType: 'JSON',
      data :{action: "ACS_list_chat"},
        success: function(data){
         console.log("data44444",data);
        
        
         
          var html_to_append = '';
          $.each(data, function(i, item) {
              
               
            html_to_append +=
            '<a href="'+item.url+'"><div class="chat_list active_chat"><div class="chat_people"><div class="chat_img"><img src="/assets/user-profile.png" alt="sunil"></div> <div class="chat_ib"><h5> ' +
            item.sender_email + 
            '<br>(#'+ item.id+" "+ item.title+')</h5> </div></div></div></a>';
            
          });
          $("#items-container").html(html_to_append);
          

        }
    });
    

 var eid = document.getElementById('eid').value;
  var user_id = document.getElementById('user_id').value;
		//alert(eid);
   var $form = $(this);
	  $.ajax({
        type: "GET",
     url : ajax_object.ajax_url,
      dataType: 'JSON',
            data :{action: "ACS_message_discussion_list",  eid :eid},
        success: function(data){
         console.log("data33",data);
           var html_to_append_message = '';
          $.each(data, function(i, item1) {
  
                     if(item1.user_id == user_id){



            html_to_append_message +=
            '<div class="outgoing_msg"> <div class="sent_msg"> <p>'+item1.message+'</p><span class="time_date">'+item1.created_at+'</span></div></div>';
            
          
                     }
                     
                      else{
          
            html_to_append_message +=
            '<div class="incoming_msg"><div class="incoming_msg_img"><img src="/assets/user-profile.png" alt="sunil"></div><div class="received_msg"><div class="received_withd_msg"> <p>'+item1.message+'</p><span class="time_date">'+item1.created_at+'</span></div></div>';
            
                      }
                     
            
  });
     $("#items-container_message").html(html_to_append_message);
  
  

        }
    });
      	
      	
      	
      	
      	
 
	$('.wordpress-ajax-form').on('submit', function(e) {
		e.preventDefault();
		var $form = $(this);
		$.post($form.attr('action'), $form.serialize()+
        '&my_nonce=' + 'aistore_nonce' +
        '&action=custom_action', function(data) {
			console.log('This is data returned from the server ' + data);
		}, 'json');
		
	

		console.log("Your ticket_id id is ::"+eid);
		
		
		  $.ajax({
        type: "GET",
     url : ajax_object.ajax_url,
      dataType: 'JSON',
            data : {action: "ACS_message_discussion_list",  eid :eid},
        success: function(data){
           var html_to_append_message = '';
          $.each(data, function(i, item1) {
  
                    if(item1.user_id == user_id){


            html_to_append_message +=
            '<div class="outgoing_msg"> <div class="sent_msg"> <p>'+item1.message+'</p><span class="time_date">'+item1.created_at+'</span></div></div>';
            
          
                     }
                     
                      else{
          
            html_to_append_message +=
            '<div class="incoming_msg"><div class="incoming_msg_img"><img src="/assets/user-profile.png" alt="sunil"></div><div class="received_msg"><div class="received_withd_msg"> <p>'+item1.message+'</p><span class="time_date">'+item1.created_at+'</span></div></div>';
            
                      }
                     
            
  });
     $("#items-container_message").html(html_to_append_message);

        }
    });
    

		
	});
	
	
   
});
