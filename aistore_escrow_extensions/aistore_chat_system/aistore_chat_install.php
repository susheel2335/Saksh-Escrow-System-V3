<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}
 
 add_action('AistoreEscrow_Install', 'ACS_plugin_email_table_install' ); 
     
 

function ACS_chat_plugin_table_install()
{
    global $wpdb;

    $table_chat_discussion = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "escrow_discussion  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  eid int(100) NOT NULL,
   message  text  NOT NULL,
   user_login  varchar(100)   NOT NULL,
  status  varchar(100)   NOT NULL,
  ipaddress varchar(100)   NOT NULL,
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";


 require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($table_chat_discussion);

}

register_activation_hook(__FILE__, 'ACS_chat_plugin_table_install');
