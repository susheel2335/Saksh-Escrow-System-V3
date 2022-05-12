<?php
function saksh_wallet_currency_convert_admin_menu() {
    add_menu_page(
        __( 'Currency Exchange', 'aistore' ),
        __( 'Currency Exchange', 'aistore' ),
        'manage_options',
        'sample-page',
        'saksh_wallet_currency_convert_page_currencyexchange',
        'dashicons-schedule',
        3
    );
}


add_action( 'admin_menu', 'saksh_wallet_currency_convert_admin_menu' );


function saksh_wallet_currency_convert_page_currencyexchange() {
    ?>
    <h1>
        <?php esc_html_e( 'Welcome to exchange currency.', 'aistore' ); ?>
    </h1>
    <?php
    //  ob_start();
?>
    <div>
        <?php
            if (isset($_POST['submit']) and $_POST['action'] == 'currencyexchange')
                {

                    if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
                    {
                        return _e('Sorry, your nonce did not verify', 'aistore');
                        exit;
                    }
                    
             
                
                
               $amount1= sanitize_text_field($_REQUEST['amount1']);
                $amount2= sanitize_text_field($_REQUEST['amount2']);
                
                 $coin1= sanitize_text_field($_REQUEST['coin1']);
                $coin2= sanitize_text_field($_REQUEST['coin2']);
                
                 $wallet = new AistoreWallet();
                 $current_user_id=get_current_user_id();
                 
                $description = 'Currency Convert '.$coin1.' to '.$coin2;
$res=$wallet->aistore_debit($current_user_id, $amount1, $coin1, $description,$current_user_id);
$res=$wallet->aistore_credit(1, $amount1, $coin1, $description,$current_user_id);


$res=$wallet->aistore_credit($current_user_id, $amount2, $coin2, $description,$current_user_id);
$res=$wallet->aistore_debit(1, $amount2, $coin2, $description,$current_user_id);



_e( 'Successfully', 'aistore' );

}
                    ?>
 <?php esc_html_e( 'Currency Exchange', 'aistore' ); ?>
    
    
     <form method="POST" action="" name="currencyexchange" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

    <input type="text" class="form-control" name="amount1" id="amount1"> = 
     <input type="text" class="form-control" name="amount2" id="amount2"><br>
     <br><br>
     
     <select name="coin1" id="coin1">
      <option selected><?php _e( 'Select your Currency', 'aistore' ) ;?></option>
     <?php
            global $wpdb;
            $wallet = new AistoreWallet();
        $results = $wallet->aistore_wallet_currency();
    
            foreach ($results as $c)
            {

                echo '	<option  value="' .esc_attr( $c->symbol) . '">' . esc_attr($c->currency) . '</option>';

            }
?>
           
  
</select>
  
     &nbsp;   
   


 
     <select name="coin2" id="coin2">
      <option selected><?php _e( 'Select your Currency', 'aistore' ) ;?></option>
     <?php
            global $wpdb;
            $wallet = new AistoreWallet();
        $results = $wallet->aistore_wallet_currency();
    
            foreach ($results as $c)
            {

                echo '	<option  value="' .esc_attr( $c->symbol) . '">' . esc_attr($c->currency) . '</option>';

            }
?>
           
  
</select>
  
    <br><br>
 

<input type="submit"  class="button button-primary  btn btn-primary "    name="submit" value="<?php _e('Submit', 'aistore') ?>"/>
 
 
<input type="hidden" name="action" value="currencyexchange" />
                </form>   
   


                <br></div>
    <?php
    // return ob_get_clean();
    
}
    



