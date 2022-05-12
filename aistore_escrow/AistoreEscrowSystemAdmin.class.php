<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}
 
 

include_once "AistoreEscrowAdmin.class.php";


class AistoreEscrowSystemAdmin extends  AistoreEscrowAdmin
{


 


    // Escrow Details
    public   function aistore_admin_escrow_detail()
    {
        

 ob_start();
 
 
 
 
global $wpdb;
        $eid = sanitize_text_field($_REQUEST['eid']);
         

      
     echo      $this->aistore_escrow_btn_admin_actions( );
        
 
      
      
 

               
$escrow= $this->AistoreGetEscrow($eid) ;
               
    
    
 
     

    echo "<h1>#" . esc_attr($escrow->id) . " " . esc_attr($escrow->title) . "</h1><br>";
        
        
        
        
        printf(__("Sender :  %s", 'aistore') , $escrow->sender_email . "<br>");
        printf(__("Receiver : %s", 'aistore') , $escrow->receiver_email . "<br>");
        printf(__("Status : %s", 'aistore') , $escrow->status . "<br>");
         printf(__("Amount : %s", 'aistore') , $escrow->amount ." ". $escrow->currency."<br><hr />");
         
          

        
        $this->admin_cancel_escrow_btn($escrow);
        $this->admin_release_escrow_btn($escrow);
     

  
 
echo $this-> aistore_escrow_detail_tabs($escrow);
 
 
        return ob_get_clean();
    }
  
   

      
  


 

}


