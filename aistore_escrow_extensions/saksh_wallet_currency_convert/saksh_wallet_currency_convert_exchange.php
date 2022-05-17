<?php

function saksh_wallet_currency_convert_currencyexchange(){
    ob_start();
?>
    <div>
          <h2>Currency Exchange</h2>
          
          
        <?php
        
        if (isset($_POST['submit']) and $_POST['action'] == 'currencyexchangestep3')
                {

                    if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
                    {
                        return _e('Sorry, your nonce did not verify', 'aistore');
                        exit;
                    }
                    ?>
                      <h2><?php _e( ' Step 3', 'aistore' ) ;?></h2><br>
                 <?php
                
                 $amount1= sanitize_text_field($_REQUEST['amount1']);
                $amount2= sanitize_text_field($_REQUEST['amount2']);
                
                 $coin1= sanitize_text_field($_REQUEST['coin1']);
                $coin2= sanitize_text_field($_REQUEST['coin2']);
                
                ?>
                 <?php _e( 'Amount 1:', 'aistore' ) ;?> <?php echo esc_attr($amount1).' '.esc_attr($coin1); ?>
                 <br><?php _e( 'Amount 2:', 'aistore' ) ;?> <?php echo esc_attr($amount2).' '.esc_attr($coin2); ?>
                 <br>
                 
                <?php
                
                
                 $wallet = new AistoreWallet();
                 $current_user_id=get_current_user_id();
                 
  $description = 'Currency Convert '.$coin1.' to '.$coin2;
$res=$wallet->aistore_debit($current_user_id, $amount1, $coin1, $description,$current_user_id);
$res=$wallet->aistore_credit(1, $amount1, $coin1, $description,$current_user_id);


$res=$wallet->aistore_credit($current_user_id, $amount2, $coin2, $description,$current_user_id);
$res=$wallet->aistore_debit(1, $amount2, $coin2, $description,$current_user_id);

  $user_id = get_current_user_id();
        _e( '<br><br>Available balance is:', 'aistore' ) ;
       
        
 global $wpdb;

        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}escrow_currency  order by id desc"
);
 foreach ($results as $row):
$currency=  $row->currency; 
 $wallet = new AistoreWallet();

        $balance = $wallet->aistore_balance($user_id, $currency);

         echo "<br>".esc_attr($balance) . " " . esc_attr($currency);
       
   endforeach;

_e( '<br><br>Currency Exchange Successfully', 'aistore' );
          
                }
                
   else if (isset($_POST['submit']) and $_POST['action'] == 'currencyexchange')
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
                
                ?>
                 <form method="POST" action="" name="currencyexchangestep3" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

                <h2><?php _e( ' Step 2', 'aistore' ) ;?></h2><br>
                <?php _e( 'Amount 1:', 'aistore' ) ;?> <?php echo esc_attr($amount1).' '.esc_attr($coin1); ?>
                 <br><?php _e( 'Amount 2:', 'aistore' ) ;?> <?php echo esc_attr($amount2).' '.esc_attr($coin2); ?>
                 <br>
                 <?php
  $user_id = get_current_user_id();
        _e( '<br><br>Available balance is:', 'aistore' ) ;
       
        
 global $wpdb;

        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}escrow_currency  order by id desc"
);
 foreach ($results as $row):
$currency=  $row->currency; 
 $wallet = new AistoreWallet();

        $balance = $wallet->aistore_balance($user_id, $currency);

         echo "<br>".esc_attr($balance) . " " . esc_attr($currency);
       
   endforeach;
   



          
             ?>    
                  <input type="hidden" class="form-control" name="amount1" id="amount1" value="<?php echo esc_attr($amount1); ?>">
     <input type="hidden" class="form-control" name="amount2" id="amount2 " value="<?php echo esc_attr($amount2); ?>"><br>
     
      <input type="hidden" class="form-control" name="coin1" id="coin1" value="<?php echo esc_attr($coin1); ?>"> 
     <input type="hidden" class="form-control" name="coin2" id="coin2" value="<?php echo esc_attr($coin2); ?>"><br>
     
     
                 
<input type="submit"  class="button button-primary  btn btn-primary "    name="submit" value="<?php _e('Next', 'aistore') ?>"/>
 
 
<input type="hidden" name="action" value="currencyexchangestep3" />
                </form>   
                
                 <br>
                 
                 
<?php
}

else{
                    ?>

  
    
  <h2><?php _e( ' Step 1', 'aistore' ) ;?></h2><br>
    <form method="POST" action="" name="currencyexchange" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

    <input type="text" class="form-control" name="amount1" id="amount1"> = 
     <input type="text" class="form-control" name="amount2" id="amount2"><br>
     
     
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
  
     &nbsp;   &nbsp;
   


 
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
  
    <br>
 

<input type="submit"  class="button button-primary  btn btn-primary "    name="submit" value="<?php _e('Next', 'aistore') ?>"/>
 
 
<input type="hidden" name="action" value="currencyexchange" />
                </form>   
                
 
 			


                <br></div>
                
               
    <?php
    
}
    return ob_get_clean();
    
}
    
 
 
 
 
 
 add_action('wp_ajax_getrate', 'saksh_wallet_currency_convert_getrate');
   
    function saksh_wallet_currency_convert_getrate(){
        
        // echo "Fdg";
        
          $c1= sanitize_text_field($_REQUEST['c1']);
        $c2= sanitize_text_field($_REQUEST['c2']);
        
         $call=  "/saksh_wallet_currency_convert_api.php";
         
      $str = @file_get_contents($call);
    if ($str === FALSE) {
        return "0";
        
    } else {
    
         $response =json_decode($str);
          
        foreach($response as $key => $val) {
            
            if($key == $c1.$c2){
                echo  esc_attr($val);
            }
            
        
}  
       
    }
    
    
     wp_die();
    }
