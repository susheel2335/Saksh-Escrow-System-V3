<?php


 add_shortcode('aistore_saksh_withdrawal_system', array(
    'Aistore_WithdrawalSystem',
    'aistore_saksh_withdrawal_system'
));
 
 
 
  add_shortcode('aistore_bank_account', array(
    'Aistore_WithdrawalSystem',
    'aistore_bank_account'
));

 include_once dirname(__FILE__) . '/menu.php';
 include_once dirname(__FILE__) . '/admin_setting.php';
 include_once dirname(__FILE__) . '/Aistore_WithdrawalSystem.class.php';
 include_once dirname(__FILE__) . '/Widthdrawal_requests.php';
 
 function aistore_withdraw_extension_function( $aistore_escrow_extensions ) {
   
        $aistore_escrow_extensions[] = 'withdraw';
  
    return $aistore_escrow_extensions;
}
add_filter( 'aistore_escrow_extension', 'aistore_withdraw_extension_function' );
 
  add_action('aistore_escrow_admin_tab_contents', 'aistore_withdraw_escrow_admin_tab_contents_withdraw' ); 
    

function  aistore_withdraw_escrow_admin_tab_contents_withdraw()

{
    ?>
      <div class="tab-pane fade" id="nav-withdraw" role="tabpanel" aria-labelledby="nav-withdraw-tab">
      
 
        <?php
        do_action('Aistore_withdraw');
           do_action('Aistore_withdraw_fee');
        
       
     submit_button(); ?>
    
  
  
  </div>
  
  
  <?php
    
    
}

    add_action('aistore_escrow_admin_tab', 'aistore_withdraw_tab' ); 
    

function  aistore_withdraw_tab()

{
 echo  '
    <button class="nav-link" id="nav-withdraw-tab" data-bs-toggle="tab" data-bs-target="#nav-withdraw" type="button" role="tab" aria-controls="nav-withdraw" aria-selected="false">Withdraw</button> 
     
     ';
    
 
}


 ?>