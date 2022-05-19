<?php
 


function saksh_wallet_currency_convert_scripts_method()
{
    
//    echo plugins_url('saksh_wallet_currency_convert_custom.js', __FILE__);
    
    
    

    // wp_enqueue_style('aistore', plugins_url('/aistore_assets/css/custom.css', __FILE__) , array());
    
    wp_enqueue_script('aistore_currency', plugins_url('/saksh_wallet_currency_convert_custom.js', __FILE__) , array(
        'jquery'
    ));
    
 wp_enqueue_script( 'ajax-script', plugins_url( '../../saksh_wallet_currency_convert_custom.js', __FILE__ ), array('jquery') );


wp_localize_script( 'ajax-script', 'ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
   
 wp_register_script( 'jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js', null, null, true );  
 
}

add_action('wp_enqueue_scripts', 'saksh_wallet_currency_convert_scripts_method');

include_once dirname(__FILE__) . '/saksh_wallet_currency_convert_exchange.php';
include_once dirname(__FILE__) . '/saksh_wallet_currency_convert_admin.php';




add_shortcode('saksh_wallet_currency_convert_currencyexchange', 
    'saksh_wallet_currency_convert_currencyexchange');

