<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}

class AistoreEscrow
{
  
  
  function create_escrow($escrow)
  {
       
              global $wpdb;    

    
            

            $title = sanitize_text_field($escrow['title']);
            $amount = sanitize_text_field($escrow['amount']);

            $receiver_email = sanitize_email($escrow['receiver_email']);

            $term_condition = sanitize_textarea_field(htmlentities($escrow['term_condition']));

            $escrow_currency = sanitize_text_field($escrow['aistore_escrow_currency']);

          

            $sender_email = $escrow['user_email'];

       

            // add currency also
         $qr=$wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_system ( title, amount, receiver_email,sender_email,term_condition  ,currency ) VALUES ( %s, %s, %s, %s ,%s , %s)", array(
                $title,
                $amount,
                $receiver_email,
                $sender_email,
                $term_condition,
                
                $escrow_currency
            ));
            
         
            
               $wpdb->query($qr);
            
    

            $eid = $wpdb->insert_id;
   
            $escrow['id']=$eid;
            
            
                
            do_action( 'AistorEscrowCreated',  (object)$escrow);
            
           
        return  $escrow;   

          
            
            
  }
  
  
  
  
    // Escrow List
    public   function aistore_escrow_list($emailId)
    {
      
 
        global $wpdb;

        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE receiver_email=%s or sender_email=%s order by id desc ", $emailId, $emailId));
 
 

        

 
                
	return      $results;
	
	
	
	
	 

    }
    
    
    public   function aistore_escrow_detail($eid,$email)
    {
      
  
global $wpdb;
        
        
        
     $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system where id=%d and ( receiver_email=%s or sender_email=%s ) ", $eid,$email,$email));
     
  return $escrow;
  
  
    }
    
  
  function cancel_escrow($escrow,$email_id)
    {
       
 if (cancel_escrow_btn_visible($escrow ,$email_id )  ) 
            
            { 
                
global $wpdb;
        
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = 'cancelled'  WHERE (  receiver_email = %s   or  sender_email = %s    )  and  id =  %d ", $email_id, $email_id, $eid));

           
                
  }             
  }
  
   function release_escrow($escrow,$email_id)
    {
         
           
            if (accept_escrow_btn_visible($escrow ,$email_id )  ) 
            
            { 

global $wpdb;
        
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = 'released'  WHERE  payment_status='paid' and  sender_email =%s and id = %d ", $email_id, $escrow->id)); 
    
    
                 do_action( 'aistore_escrow_released',$eid);
        }
        
        
}    
        
        
        
        
  
  
   function accept_escrow($escrow,$email_id)
    {
         
            if (accept_escrow_btn_visible($escrow ,$email_id )  ) 
            
            { 
 
global $wpdb;
        
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = '%s'  WHERE  payment_status='paid' and  receiver_email = %s  and id = '%d'", 'accepted', $email_id, $eid));
    
    
 
 
            
                
            do_action( 'aistore_escrow_accepted',$eid);

        }
        
        
        }
        
        
        
        
   function dispute_escrow($escrow)
    {
        
           

            

            if (dispute_escrow_btn_visible($escrow)  ) 
            
            {

global $wpdb;
        
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET status = '%s'  WHERE id = '%d' and payment_status='paid'", 'disputed', $eid));
    
    
       
            do_action( 'aistore_escrow_disputed',$eid);
            
           
            }
        
    }
  
  
   function dispute_escrow_btn_visible($escrow)
    {

        if ($escrow->payment_status <> "paid")   return false;

        if ($escrow->status == "closed")  return false;

        else

        if ($escrow->status == "released")  return false;

        else

        if ($escrow->status == "cancelled")  return false;

        else

        if ($escrow->status == "disputed")  return false;

        else

        if ($escrow->status == "pending")  return false;

 return true;
    }
    
    
    
   public function release_escrow_btn_visible($escrow,$user_email)
    {

  
   
        if ($escrow->payment_status <> "paid")  return false;


        if ($escrow->sender_email <> $user_email  and  !is_admin())  return false;

        
        //  if (aistore_isadmin() == $user_email) return "";
         

        if ($escrow->status == "closed")  return false;


        else

        if ($escrow->status == "released")  return false;


        else

        if ($escrow->status == "cancelled")  return false;

        else

        if ($escrow->status == "pending")  return false;



 return true;

 
    }
    
    
        function cancel_escrow_btn_visible($escrow,$user_email)
    {

        if ($escrow->status == "closed") return false;

        else

        if ($escrow->status == "released") return false;

        else

        if ($escrow->status == "cancelled") return false;

       
 
        if ($escrow->sender_email == $user_email)

        {
            if ($escrow->payment_status == "paid")  return false;

        }

      return true;
      
    }
    
        function accept_escrow_btn_visible($escrow,$user_email)
    {
 


        if ($escrow->payment_status <> "paid")  return false;

        if ($escrow->sender_email == $user_email) return false;

        if ($escrow->status == "closed") return false;

        else

        if ($escrow->status == "released")  return false;

        else

        if ($escrow->status == "cancelled")  return false;

        else

        if ($escrow->status == "disputed")  return false;

        else

        if ($escrow->status == "accepted")  return false;

 
return true;
  
    }
    
    
}