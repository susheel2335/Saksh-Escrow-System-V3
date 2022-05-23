<?php



add_action('AistoreEscrow_Install', 'aistore_set_defualt_value_widthdraw');

function aistore_set_defualt_value_widthdraw()
{

 
 
aistore_withdraw_plugin_table_install();
}



register_activation_hook(__FILE__, 'aistore_withdraw_plugin_table_install');


function aistore_withdraw_plugin_table_install()
{
    update_option('withdraw_fee', 15);
    
    
    global $wpdb;

        $table_withdrawal_requests = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "widthdrawal_requests  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  amount double NOT NULL,
 
   method  varchar(100)   NOT NULL,   charges  varchar(100)   NOT NULL,
   username  varchar(100)   NOT NULL,
   currency  varchar(100)   NOT NULL,
  status  varchar(100)   NOT NULL DEFAULT 'pending',
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";


   require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($table_withdrawal_requests);
    
}


 
  add_shortcode('aistore_bank_account', array(
    'Aistore_WithdrawalSystem',
    'aistore_bank_account'
));

 add_shortcode('aistore_saksh_withdrawal_system', array(
    'Aistore_WithdrawalSystem',
    'aistore_saksh_withdrawal_system'
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
 



 ?>