=== Saksh Escrow System ===
Contributors: susheelhbti
Tags: Escrow System 
License: GPLv2 or later
Requires at least:  5.6
Tested up to: 5.8.3
Stable tag: 2.1


Saksh Escrow System is a plateform allow parties to complete safe payments.


== Description ==

1   Escrow System

This involve in two steps in first step it ask to provide contract title , 
escrow amount and email ID of your partner once submit it will take you another page and ask to upload any document and details about the escrow and concerned terms and conditions. In second step user can submit one document but in the escrow details page user can submit many documents.

After creating escrow it will take user to details page where user can submit more informtion about escrow and documents as much he want. 

When user create escrow it ask to submit the email of partner and when submit email it send email to the partner with details of the escrow and ask user to create account [ or login] and then the partner visit the escrow details page and ACCEPT escrow.


The partner will have option to ACCEPT/REJECT escrow if accept then the contract will start if not then contract will be cancelled.

In the escrow detail page both partner can upload/download files shared by uploadings. Both partners can also do discussion about the project. It include a wordpress editor so easy to format texts.

2  Dispute Handling:

Some time agreement don't reach either party can start dispute by clicking on a 
give dispute button. When user start dispute the admin will join and discuss
with user and try to short out the problems and then can release or cancel the
payment.



3 File shareing

Both partners can share document each other they can share pdf/zip files vai simple uploads.

4 Discussion boards

It is provide a complete message board where user can post message and check other message.


5 Fee 

Admin can set fee from both parties and earn money.
	

For demo please visit https://escrowsystem.sakshdemo.xyz/
 

Remember 

After enableing the plugin you need to create pages with following shortcodes

[aistore_escrow_system]  This will show form for user to create escrow
 


[escrow_system_part2]  This will show form for user to create escrow form step 2

[aistore_escrow_list] This will lists all escrow created via user or invited by its partner

[aistore_escrow_detail]  Escrow details page where user do trades.


How a user can add/edit bank details 

[aistore_bank_account] user can add/edit bank details.



After creating pages please admin and in the form set the pages so that system know which pages is used for which purpose and  
you need to create extenstion with following extenstion name

1.  aistore_bank_payment
2.  aistore_bank_payment_gateway
3.  aistore_chat_system
4.  aistore_email
5.  aistore_file_upload
6.  aistore_notifications
7.  aistore_payment_gateway
8.  aistore_wallet
9.  aistore_withdraw
10. saksh_wallet_currency_convert



saksh-escrow-system/admin_setting/AistoreEscrowSettings.class.php

    __construct
    aistore_add_plugin_page
    aistore_escrow_all_notification
    aistore_escrow_admin_report
    aistore_escrow_dashboard
    aistore_message_setting
    aistore_user_escrow_list
    aistore_disputed_escrow_details
    aistore_disputed_escrow_list
    aistore_page_setting
    aistore_notification_setting
    aistore_email_setting
    aistore_payment_process
    aistore_page_register_setting
    aistore_notification_register_setting
    aistore_email_register_setting
    aistore_message_register_setting

 saksh-escrow-system/admin_setting/aistore_disputed_escrow_details.php

 saksh-escrow-system/admin_setting/aistore_disputed_escrow_list.php

    tssss

 saksh-escrow-system/admin_setting/aistore_escrow_dashboard.php

 saksh-escrow-system/admin_setting/aistore_payment_process.php

    aistore_escrow_admin_process_payment

 saksh-escrow-system/admin_setting/aistore_user_escrow_list.php

    get_user_by_email1

 saksh-escrow-system/admin_setting/escrow_message_setting.php

saksh-escrow-system/admin_setting/page_setting.php

saksh-escrow-system/aistore_assets/css/custom.css

saksh-escrow-system/aistore_assets/js/custom.css

saksh-escrow-system/aistore_assets/js/custom.js

    ajaxSubmit

saksh-escrow-system/aistore_assets/js/error_log

    admin_url
    admin_url
    admin_url
    admin_url
    admin_url
    admin_url

saksh-escrow-system/aistore_escrow/AistoreEscrow.class.php

    get_escrow_admin_user_id
    get_escrow_currency
    create_escrow_fee
    accept_escrow_fee
    create_escrow
    AistoreEscrowList
    AistoreEscrowDetail
    AistoreGetEscrow
    AistoreEscrowMarkPaid
    CancelEscrow____ReviewNeeded
    ReleaseEscrow____ReviewNeeded
    AcceptEscrow____ReviewNeeded
    DisputeEscrow
    dispute_escrow_btn_visible
    release_escrow_btn_visible
    cancel_escrow_btn_visible
    accept_escrow_btn_visible
    make_payment_btn_visible
    accept_escrow_btn
    cancel_escrow_btn
    release_escrow_btn
    dispute_escrow_btn
    aistore_escrow_btn_actions
    aistore_ipaddress

 saksh-escrow-system/aistore_escrow/AistoreEscrowAdmin.class.php

    admin_release_escrow_btn_visible
    admin_cancel_escrow_btn_visible
    aistore_escrow_btn_admin_actions
    admin_cancel_escrow_btn
    admin_release_escrow_btn

 /saksh-escrow-system/aistore_escrow/AistoreEscrowSystem.class.php

    aistore_bank_details
    aistore_escrow_system
    aistore_escrow_list
    aistore_escrow_detail
    aistore_escrow_detail_tabs

 saksh-escrow-system/aistore_escrow/AistoreEscrowSystemAdmin.class.php

    aistore_admin_escrow_detail
/saksh-escrow-system/aistore_escrow/Escrow_list.php

    __construct
    status_filter
    date_filter
    search_box
    get_escrow
    prepareWhereClouse
    delete_escrow
    remove_payment_escrow
    record_count
    no_items
    column_default
    column_cb
    column_name
    get_columns
    get_sortable_columns
    get_bulk_actions
    form
    prepare_items
    process_bulk_action
    __construct
    set_screen
    plugin_menu
    plugin_settings_page
    screen_option
    get_instance

saksh-escrow-system/aistore_escrow/user_escrow.php

    aistore_users
    aistore_user_escrow
    aistore_user_escrow_list

 saksh-escrow-system/aistore_escrow_extensions/aistore_bank_payment/admin_setting.php

    ABP_page
    ABP_details

 saksh-escrow-system/aistore_escrow_extensions/aistore_bank_payment/index.php

    ABP_extension_function

 saksh-escrow-system/aistore_escrow_extensions/aistore_bank_payment/make_payment.php

    ABP_bank_makepayment

 saksh-escrow-system/aistore_escrow_extensions/aistore_bank_payment/user_bank_details.php

    ABP_userbank_details

 /saksh-escrow-system/aistore_escrow_extensions/aistore_bank_payment_gateway/crypto_deposit.php

    aistore_escrow_payment_method_list
    payment_form
    webhook

 saksh-escrow-system/aistore_escrow_extensions/aistore_bank_payment_gateway/index.php

    aistore_escrow_payment_nofity_url

 saksh-escrow-system/aistore_escrow_extensions/aistore_chat_system/Aistorechat.class.php

    ACS_escrow_chat
    ACS_chat_box
    ACS_message_discussion_list
    ACS_list_chat

 saksh-escrow-system/aistore_escrow_extensions/aistore_chat_system/admin_setting.php

    ACS_chat_publish

 saksh-escrow-system/aistore_escrow_extensions/aistore_chat_system/aistore_chat_install.php

    ACS_chat_plugin_table_install

 saksh-escrow-system/aistore_escrow_extensions/aistore_chat_system/css/chat.css

 saksh-escrow-system/aistore_escrow_extensions/aistore_chat_system/index.php

    ACS_scripts_method
    ACS_extension_function

 saksh-escrow-system/aistore_escrow_extensions/aistore_chat_system/js/chat.js

 saksh-escrow-system/aistore_escrow_extensions/aistore_chat_system/readme.txt

 saksh-escrow-system/aistore_escrow_extensions/aistore_email/admin/all_email_report.php

 saksh-escrow-system/aistore_escrow_extensions/aistore_email/admin/email_setting.php

 saksh-escrow-system/aistore_escrow_extensions/aistore_email/aistore_email_install.php

    aistore_email_plugin_table_install
    aistore_email_message

 saksh-escrow-system/aistore_escrow_extensions/aistore_email/email_report.php

    aistore_escrow_emails_tab_button
    aistore_escrow_emails_tab_contents
    aistore_email_report

 saksh-escrow-system/aistore_escrow_extensions/aistore_email/email_template.php

 saksh-escrow-system/aistore_escrow_extensions/aistore_email/index.php

    aistore_scripts_method_email
    aistore_escrow_extension_email_extension_function

 saksh-escrow-system/aistore_escrow_extensions/aistore_email/menu.php

    aistore_email_register_menu_page
    aistore_email_setting
    aistore_all_email_report

 saksh-escrow-system/aistore_escrow_extensions/aistore_email/send_email.php

    sendEmailCreated
    sendEmailAccepted
    sendEmailCancelled
    sendEmailDisputed
    sendEmailReleased
    sendEmailPaymentAccepted
    aistore_send_email

 saksh-escrow-system/aistore_escrow_extensions/aistore_file_upload/admin_setting.php

    AFU_type

 saksh-escrow-system/aistore_escrow_extensions/aistore_file_upload/aistore_escrow_file_upload.php

    AFU_files_tab_button
    aistore_escrow_files_tab_contents
    AFU_files
    AFU_process_file_upload

 saksh-escrow-system/aistore_escrow_extensions/aistore_file_upload/index.php

    AFU_extension_function

 saksh-escrow-system/aistore_escrow_extensions/aistore_notifications/admin/notification_report.php

 saksh-escrow-system/aistore_escrow_extensions/aistore_notifications/admin/notification_setting.php

 saksh-escrow-system/aistore_escrow_extensions/aistore_notifications/admin/page_setting.php

    aistore_notification_setting

 saksh-escrow-system/aistore_escrow_extensions/aistore_notifications/index.php

    aistore_notification_escrow_plugin_table_install
    aistore_notification_escrow_message
    aistore_notifications_escrow_tab_button
    aistore_notifications_escrow_tab_contents
    aistore_notification_escrow_extension_function

 saksh-escrow-system/aistore_escrow_extensions/aistore_notifications/menu.php

    aistore_escrow_register_my_notification_menu_page
    aistore_escrow_notification_setting
    aistore_escrow_notification_report

 saksh-escrow-system/aistore_escrow_extensions/aistore_notifications/notification_api.php

    aistore_escrow_echo_all_notification
    aistore_escrow_echo_notification

 saksh-escrow-system/aistore_escrow_extensions/aistore_notifications/sendnotification.php

    aistore_escrow_sendNotificationCreated
    aistore_escrow_sendNotificationAccepted
    aistore_escrow_sendNotificationCancelled
    aistore_escrow_sendNotificationDisputed
    aistore_escrow_sendNotificationReleased
    aistore_escrow_sendNotificationPaymentRefund
    aistore_escrow_sendNotificationPaymentAccepted
    aistore_notification_new

 saksh-escrow-system/aistore_escrow_extensions/aistore_notifications/user_notification.php

    aistore_escrow_all_notification
    aistore_escrow_user_notification
    aistore_escrow_user_notification_list

 saksh-escrow-system/aistore_escrow_extensions/aistore_payment_gateway/crypto_deposit.php

    aistore_escrow_payment_method_list
    payment_form
    webhook

 saksh-escrow-system/aistore_escrow_extensions/aistore_payment_gateway/index.php

    aistore_escrow_payment_nofity_url

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/AistoreWallet.class.php

    aistore_transfer
    aistore_balance
    aistore_debit
    aistore_credit
    aistore_transaction_history
    aistore_wallet_transaction_history
    aistore_wallet_currency

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/Aistore_escrow_hook.php

    aistore_escrow_transactions_tab_button
    aistore_escrow_transactions_tab_contents

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/admin/all_wallet_balance.php

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/admin/balance_list.php

    __construct
    status_filter
    date_filter
    search_box
    get_balance
    prepareWhereClouse
    record_count
    no_items
    column_default
    column_cb
    get_columns
    get_sortable_columns
    form
    aistore_prepare_items
    process_bulk_action
    __construct
    set_screen
    plugin_menu
    plugin_settings_page
    screen_option
    get_instance

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/admin/currency_setting.php

    getCurrency

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/admin/debit_credit.php

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/admin/transaction_list.php

    __construct
    status_filter
    date_filter
    search_box
    get_transactions
    prepareWhereClouse
    record_count
    no_items
    column_default
    column_cb
    get_columns
    get_sortable_columns
    get_bulk_actions
    form
    prepare_items
    process_bulk_action
    __construct
    set_screen
    plugin_menu
    plugin_settings_page
    screen_option
    get_instance

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/admin/user_balance.php

    aistore_new_modify_user_table_balance
    aistore_new_modify_user_table_row_balance

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/admin/user_transaction.php

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/admin/user_transaction_list.php

    aistore_transaction
    aistore_user_transaction
    aistore_user_transaction_list

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/index.php

    aistore_escrow_transactions_tab_button
    aistore_escrow_transactions_tab_contents

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/languages/aistore.pot

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/menu.php

    register_my_custom_menu_page
    aistore_debit_credit
    currency_setting
    balance_list

saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/transactions/aistore_transaction_report.php

 saksh-escrow-system/aistore_escrow_extensions/aistore_wallet/user_bank_details.php

    aistore_extra_user_profile_fields
    aistore_save_extra_user_profile_fields

 saksh-escrow-system/aistore_escrow_extensions/aistore_withdraw/Aistore_WithdrawalSystem.class.php

    aistore_bank_account
    aistore_saksh_withdrawal_system

 saksh-escrow-system/aistore_escrow_extensions/aistore_withdraw/Widthdrawal_requests.php

    __construct
    status_filter
    date_filter
    search_box
    get_withdrawal
    prepareWhereClouse
    delete_withdrawal
    record_count
    no_items
    column_default
    column_cb
    column_name
    get_columns
    get_sortable_columns
    get_bulk_actions
    form
    prepare_items
    process_bulk_action
    __construct
    set_screen
    plugin_menu
    plugin_settings_page
    screen_option
    get_instance

 saksh-escrow-system/aistore_escrow_extensions/aistore_withdraw/Withdrawal.php

 saksh-escrow-system/aistore_escrow_extensions/aistore_withdraw/admin_setting.php

    aistore_withdraw
    aistore_withdraw_fee

 saksh-escrow-system/aistore_escrow_extensions/aistore_withdraw/index.php

    aistore_withdraw_extension_function

 saksh-escrow-system/aistore_escrow_extensions/aistore_withdraw/menu.php

    aistore_withdraw_register_menu_page
    withdrawal
    withdrawal_list

saksh-escrow-system/aistore_escrow_extensions/index.php

    escrow_extension

 saksh-escrow-system/aistore_escrow_extensions/saksh_wallet_currency_convert/index.php

    saksh_wallet_currency_convert_scripts_method

 saksh-escrow-system/aistore_escrow_extensions/saksh_wallet_currency_convert/saksh_wallet_currency_convert_admin.php

    saksh_wallet_currency_convert_admin_menu
    saksh_wallet_currency_convert_page_currencyexchange

 saksh-escrow-system/aistore_escrow_extensions/saksh_wallet_currency_convert/saksh_wallet_currency_convert_api.php

 saksh-escrow-system/aistore_escrow_extensions/saksh_wallet_currency_convert/saksh_wallet_currency_convert_custom.js

 saksh-escrow-system/aistore_escrow_extensions/saksh_wallet_currency_convert/saksh_wallet_currency_convert_exchange.php

    saksh_wallet_currency_convert_currencyexchange
    saksh_wallet_currency_convert_getrate

saksh-escrow-system/index.php

    find_all_files
    aistore_wpdocs_load_textdomain
    aistore_scripts_method
    saksh_escrow_system_css
    aistore_isadmin
    aistore_plugin_table_install
    aistore_escrow_list
    aistore_bank_details
    aistore_escrow_detail
    aistore_escrow_system
    email_notification_message
    Aistore_process_placeholder_EID
    Aistore_process_placeholder_Text

saksh-escrow-system/languages/aistore.pot

saksh-escrow-system/languages/hi_IN.mo

    can
    instead
	
saksh-escrow-system/languages/hi_IN.po

saksh-escrow-system/readme.txt

    aistore_escrow_extension_email_extension_function
    
    
    
    
How to add an extension

<code>


function aistore_escrow_extension_email_extension_function( $aistore_escrow_extensions ) {
   
        $aistore_escrow_extensions[] = 'Email Extensions';
  
    return $aistore_escrow_extensions;
}
add_filter( 'aistore_escrow_extension', 'aistore_escrow_extension_email_extension_function' );
</code>


How to add admin tab in the setting section

<code>


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

</code>



== Installation ==

1. Download and extract   to `wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. "Dashboard"->"Settings"->"Saksh Escrow System"
4. There are some examples on the settings page,  


== Changelog ==

= 1.0.0 =
 

* First release. 

