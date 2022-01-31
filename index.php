<?php
/*
Plugin Name: Saksh CSV Import Data System
Version:  2.1
Stable tag: 2.1
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Saksh Escrow System is a plateform allow parties to complete safe payments.  


*/

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}


function aistore_plugin_table_install()
{
    global $wpdb;

  

  $table_aistore_wallet_transactions = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "aistore_wallet_transactions  (
     	id  bigint(20)  NOT NULL AUTO_INCREMENT,
   	transaction_id  bigint(20)  NOT NULL,
  user_id bigint(20)  NOT NULL,
   reference bigint(20)   NULL,
   type   varchar(100)  NOT NULL,
   amount  double    NOT NULL,
  balance  double    NOT NULL,
    description  text  NOT NULL,
   currency  varchar(100)   NOT NULL,
    account  varchar(100)   NOT NULL,
from_account  varchar(100)   NOT NULL,
 received_via  varchar(100)   NOT NULL,
 tags  varchar(100)   NOT NULL,
 vendor  varchar(100)   NOT NULL,
  expense_account  varchar(100)   NOT NULL,
 status  varchar(100)   NOT NULL,
   bank_name  varchar(100)   NOT NULL,
  customer  varchar(100)   NOT NULL,
  created_by  int(100)   NOT NULL,
   date  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";



  $table_aistore_category = "CREATE TABLE IF NOT EXISTS  " . $wpdb->prefix . "aistore_account  (
   	id  bigint(20)  NOT NULL  AUTO_INCREMENT,
    user_id bigint(20)  NOT NULL,
     type   varchar(100)  NOT NULL,
   account  varchar(100)   NOT NULL,
   date  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";



  $table_aistore_subcategory = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "aistore_subaccount  (
   	id  bigint(20)  NOT NULL  AUTO_INCREMENT,
    user_id bigint(20)  NOT NULL,
     type   varchar(100)  NOT NULL,
   account  varchar(100)   NOT NULL,
    subaccount  varchar(100)   NOT NULL,
   date  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";


      $table_aistore_bank = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "bank  (
   	id  bigint(20)  NOT NULL  AUTO_INCREMENT,
    user_id bigint(20)   NULL,
     bank_name   varchar(100)  NOT NULL,
   ifsc_code  varchar(100)   NOT NULL,
    branch_name  varchar(100)   NOT NULL,
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";
    
    
      $table_aistore_vendor = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "vendor  (
   	id  bigint(20)  NOT NULL  AUTO_INCREMENT,
    user_id bigint(20)   NULL,
     vendor_name   varchar(100)  NOT NULL,
   vendor_email  varchar(100)   NOT NULL,
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";


     $table_aistore_invoice = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "invoice  (
   	id  bigint(20)  NOT NULL  AUTO_INCREMENT,
    user_id bigint(20)   NULL,
     product_id   int(100)  NOT NULL,
   vendor_id  int(100)   NOT NULL,
    bill_to   varchar(100)  NOT NULL,
   ship_to  varchar(100)   NOT NULL,
    description   varchar(100)  NOT NULL,
   amount  int(100)   NOT NULL,
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";


$table_aistore_customer = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "customer  (
   	id  bigint(20)  NOT NULL  AUTO_INCREMENT,
    user_id bigint(20)   NULL,
     customer_name   varchar(100)  NOT NULL,
   customer_email  varchar(100)   NOT NULL,
    alternate_email   varchar(100)  NOT NULL,
   cc  varchar(100)   NOT NULL,
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";


     $table_aistore_estimate = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "estimate  (
   	id  bigint(20)  NOT NULL  AUTO_INCREMENT,
    user_id bigint(20)   NULL,
     product_id   int(100)  NOT NULL,
   customer_id  int(100)   NOT NULL,
    bill_to   varchar(100)  NOT NULL,
   ship_to  varchar(100)   NOT NULL,
    description   varchar(100)  NOT NULL,
   amount  int(100)   NOT NULL,
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";


     $table_aistore_product = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "product  (
   	id  bigint(20)  NOT NULL  AUTO_INCREMENT,
    user_id bigint(20)   NULL,
     terms_condtion   varchar(100)  NOT NULL,
   category  int(100)   NOT NULL,
     name   varchar(100)  NOT NULL,
   short_description  varchar(100)   NOT NULL,
    full_description   varchar(100)  NOT NULL,
     tags  varchar(100)   NOT NULL,
    product_type   varchar(100)  NOT NULL,
   amount  int(100)   NOT NULL,
      price  int(100)   NOT NULL,
 
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

 
    
      dbDelta($table_aistore_wallet_transactions);
      dbDelta($table_aistore_category);
      dbDelta($table_aistore_subcategory);
      dbDelta($table_aistore_bank);
      dbDelta($table_aistore_vendor);
     dbDelta($table_aistore_invoice);
      dbDelta($table_aistore_customer);
     dbDelta($table_aistore_estimate);
       dbDelta($table_aistore_product);
     

}
register_activation_hook(__FILE__, 'aistore_plugin_table_install');

include_once dirname(__FILE__) . '/add_company.php';
include_once dirname(__FILE__) . '/all_function.php';
include_once dirname(__FILE__) . '/csv_data.php';
include_once dirname(__FILE__) . '/update_transaction.php';
include_once dirname(__FILE__) . '/transaction_list.php';
include_once dirname(__FILE__) . '/add_account.php';
include_once dirname(__FILE__) . '/add_subaccount.php';
include_once dirname(__FILE__) . '/report.php';
include_once dirname(__FILE__) . '/all_expenses_report.php';
include_once dirname(__FILE__) . '/all_sales_report.php';
include_once dirname(__FILE__) . '/add_bank.php';
include_once dirname(__FILE__) . '/bank_list.php';
include_once dirname(__FILE__) . '/add_vendor.php';
include_once dirname(__FILE__) . '/vendor_list.php';
include_once dirname(__FILE__) . '/edit_vendor.php';
include_once dirname(__FILE__) . '/setting.php';
include_once dirname(__FILE__) . '/add_product.php';
include_once dirname(__FILE__) . '/add_invoice.php';
include_once dirname(__FILE__) . '/invoice_details.php';
include_once dirname(__FILE__) . '/invoice_list.php';
include_once dirname(__FILE__) . '/add_customer.php';
include_once dirname(__FILE__) . '/customer_list.php';
include_once dirname(__FILE__) . '/edit_customer.php';
include_once dirname(__FILE__) . '/transaction_by_vendor.php';
include_once dirname(__FILE__) . '/add_estimate.php';
include_once dirname(__FILE__) . '/estimate_list.php';
include_once dirname(__FILE__) . '/estimate_details.php';
include_once dirname(__FILE__) . '/transaction_by_customer.php';
include_once dirname(__FILE__) . '/send_email.php';
include_once dirname(__FILE__) . '/estimate_send_email.php';

add_shortcode('aistore_csv_data',   'aistore_csv_data');
add_shortcode('aistore_transaction_history',   'aistore_transaction_history');
add_shortcode('aistore_update_transaction',   'aistore_update_transaction');
add_shortcode('aistore_add_account',   'aistore_add_account');
add_shortcode('aistore_add_subaccount',   'aistore_add_subaccount');
add_shortcode('aistore_all_expenses_report',   'aistore_all_expenses_report');
add_shortcode('aistore_all_sales_report',   'aistore_all_sales_report');
add_shortcode('aistore_transaction_report',   'aistore_transaction_report');

add_shortcode('aistore_add_estimate',   'aistore_add_estimate');
add_shortcode('aistore_list_estimate',   'aistore_list_estimate');
add_shortcode('aistore_estimate_details',   'aistore_estimate_details');

add_shortcode('aistore_add_bank',   'aistore_add_bank');
add_shortcode('aistore_list_bank',   'aistore_list_bank');
add_shortcode('aistore_add_vendor',   'aistore_add_vendor');
add_shortcode('aistore_list_vendor',   'aistore_list_vendor');
add_shortcode('aistore_edit_vendor',   'aistore_edit_vendor');
add_shortcode('aistore_add_product',   'aistore_add_product');
add_shortcode('aistore_add_invoice',   'aistore_add_invoice');
add_shortcode('aistore_add_customer',   'aistore_add_customer');
add_shortcode('aistore_list_customer',   'aistore_list_customer');
add_shortcode('aistore_edit_customer',   'aistore_edit_customer');
add_shortcode('aistore_list_invoice',   'aistore_list_invoice');
add_shortcode('aistore_invoice_details',   'aistore_invoice_details');
add_shortcode('aistore_transaction_by_vendor',   'aistore_transaction_by_vendor');
add_shortcode('aistore_transaction_by_customer',   'aistore_transaction_by_customer');

add_shortcode('aistore_email_page',   'aistore_email_page');
add_shortcode('aistore_estimate_email_page',   'aistore_estimate_email_page');
add_shortcode('aistore_add_company',   'aistore_add_company');

