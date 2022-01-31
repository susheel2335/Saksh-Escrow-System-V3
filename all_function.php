<?php

function getVendors(){
    
 global $wpdb;
    $user_id = get_current_user_id();         
     $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
     
 $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}vendor where user_id=%s and company_id=%s", $user_id,$company->company_id));
 return $results;
 
}


function getSubaccountDebit(){
 global $wpdb;
    $user_id = get_current_user_id(); 
     $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
     
  $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}subaccounts where user_id=%s and type='debit' and company_id=%s", $user_id,$company->company_id));
 return $results;
 
}


function getAccountDebit(){
 global $wpdb;
    $user_id = get_current_user_id();       
     $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
 $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}accounts where user_id=%s and type='debit' and company_id=%s", $user_id,$company->company_id));
 return $results;
 
}



function getSubaccountCredit(){
 global $wpdb;
    $user_id = get_current_user_id();   
     $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
  $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}subaccounts where user_id=%s and type='credit' and company_id=%s", $user_id,$company->company_id));
 return $results;
 
}


function getAccountCredit(){
 global $wpdb;
    $user_id = get_current_user_id();         
 $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}accounts where user_id=%s and type='credit'  and company_id=%s", $user_id,$company->company_id));
 return $results;
 
}

function getProducts(){
     global $wpdb;
    $user_id = get_current_user_id();  
     $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
     
      $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}product where user_id=%s   and company_id=%s", $user_id,$company->company_id));

   return $results;
}

function getCustomer(){
     global $wpdb;
    $user_id = get_current_user_id();  
     $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
$sql = ($wpdb->prepare("SELECT * FROM {$wpdb->prefix}customer where user_id=%s  and company_id=%s", $user_id,$company->company_id));
 $results=   $wpdb->get_results($sql);
 
    return $results;
}

function getEstimates(){
     global $wpdb;
    $user_id = get_current_user_id();  
     $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));   
$sql = ($wpdb->prepare("SELECT * FROM {$wpdb->prefix}estimate where user_id=%s  and company_id=%s ", $user_id,$company->company_id));
 $results=   $wpdb->get_results($sql);
 
    return $results;
}


