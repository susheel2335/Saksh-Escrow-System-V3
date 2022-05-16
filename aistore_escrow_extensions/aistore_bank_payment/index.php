<?php

//include_once dirname(__FILE__) . '/admin_setting.php';
//include_once dirname(__FILE__) . '/make_payment.php';
//include_once dirname(__FILE__) . '/user_bank_details.php';



function aistore_escrow_extension_function( $aistore_escrow_extensions ) {
   
        $aistore_escrow_extensions[] = 'wporg-is-awesome';
  
    return $aistore_escrow_extensions;
}
add_filter( 'aistore_escrow_extension', 'aistore_escrow_extension_function' );




  add_action('aistore_escrow_admin_tab_contents', 'aistore_escrow_admin_tab_contents_banking_payment' ); 
    

function  aistore_escrow_admin_tab_contents_banking_payment()

{
    ?>
      <div class="tab-pane fade" id="nav-bank_payment" role="tabpanel" aria-labelledby="nav-bank_payment-tab">... 
      
 
        
        
   form will show here...
  
  
  </div>
  
  
  <?php
    
    
}

    add_action('aistore_escrow_admin_tab', 'aistore_bank_detailsg_tab' ); 
    

function  aistore_bank_detailsg_tab()

{
 echo  '
 
    
     
     <button class="nav-link" id="nav-bank_payment-tab" data-bs-toggle="tab" data-bs-target="#nav-bank_payment" type="button" role="tab" aria-controls="nav-bank_payment" aria-selected="false">Bank Payment</button> 
     
     ';
    
 
}

