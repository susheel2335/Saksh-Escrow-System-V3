<?php

include_once dirname(__FILE__) . '/admin_setting.php';
include_once dirname(__FILE__) . '/make_payment.php';
include_once dirname(__FILE__) . '/user_bank_details.php';

include_once dirname(__FILE__) . '/menu.php';


// This function is used to bank payment  details

function ABP_extension_function( $aistore_escrow_extensions ) {
   
        $aistore_escrow_extensions[] = 'bank_details';
        
        
  
    return $aistore_escrow_extensions;
}
add_filter( 'aistore_escrow_extension', 'ABP_extension_function' );




  add_action('aistore_escrow_admin_tab_contents', 'ABP_admin_tab_contents_banking_payment' ); 
    

function  ABP_admin_tab_contents_banking_payment()

{
    ?>
      <div class="tab-pane fade" id="nav-bank_payment" role="tabpanel" aria-labelledby="nav-bank_payment-tab">
      
 
        <?php
        do_action('Aistorebank_payment');
          do_action('Aistorebank_payment_details');
     submit_button(); ?>
        
  
  
  </div>
  
  
  <?php
    
    
}

    add_action('aistore_escrow_admin_tab', 'ABP_bank_details_tab' ); 
    

function  ABP_bank_details_tab()

{
 echo  '
    <button class="nav-link" id="nav-bank_payment-tab" data-bs-toggle="tab" data-bs-target="#nav-bank_payment" type="button" role="tab" aria-controls="nav-bank_payment" aria-selected="false">Bank Payment</button> 
     
     ';
    
 
}

