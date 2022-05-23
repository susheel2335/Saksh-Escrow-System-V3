<?php
  add_action('Aistorebank_makepayment', 'ABP_bank_makepayment' ); 
    
    // This function is used to make  payment with admin bank details
    function ABP_bank_makepayment(){

              global $wpdb;
          $eid = sanitize_text_field($_REQUEST['eid']);
                $user_id = get_current_user_id();
                
                
        $object_escrow = new AistoreEscrow();
             $escrow =    $object_escrow->AistoreGetEscrow($eid);
        // $escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE id=%s ", $eid));
                      
         $aistore_escrow_currency = $escrow->currency;
                      $escrow_amount = $escrow->amount;
                      $escrow_fee = $escrow->escrow_fee;
                      
                      $total_amount = $escrow_fee + $escrow_amount;
        ?>
        
       <table>
    <tr><td><?php _e('Bank Details ', 'aistore'); ?>:</td></tr>
    <tr><td><?php echo esc_attr(get_option('bank_details')); ?></td></tr>
    
    <tr><td><?php _e('Deposit Instructions', 'aistore'); ?> :</td></tr>
    <tr><td><?php echo esc_attr(get_option('deposit_instructions')); ?></td></tr>
      <tr><td><?php _e(' Amount', 'aistore'); ?> :</td></tr>
    <tr><td><?php echo esc_attr($escrow_amount).' '.esc_attr($aistore_escrow_currency); ?></td></tr>
    
      <tr><td><?php _e('Escrow Fee Amount', 'aistore'); ?> :</td></tr>
    <tr><td><?php echo esc_attr($escrow_fee).' '.esc_attr($aistore_escrow_currency); ?></td></tr>
    
     <tr><td><?php _e('Total Amount', 'aistore'); ?> :</td></tr>
    <tr><td><?php echo esc_attr($total_amount).' '.esc_attr($aistore_escrow_currency); ?></td></tr>


  <tr><td colspan="2">
      <?php
          

                if (isset($_POST['submit']) and $_POST['action'] == 'escrow_payment')
                {

                    if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
                    {
                        return _e('Sorry, your nonce did not verify', 'aistore');
                        exit;
                    }

                   
                    $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}escrow_system
    SET payment_status = 'processing'  WHERE id = '%d' ", $eid));
    
  $details_escrow_page_id_url = esc_url(add_query_arg(array(
                    'page_id' => get_option('details_escrow_page_id') ,
                    'eid' => $eid,
                ) , home_url()));
                   ?>
<meta http-equiv="refresh" content="0; URL=<?php echo esc_url($details_escrow_page_id_url); ?>" />
<?php
                }
                else
                {
?>
    <form method="POST" action="" name="escrow_payment" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>


<input type="submit"  class="button button-primary  btn  btn-primary "    name="submit" value="<?php _e('Make Payment', 'aistore') ?>"/>
 
 
<input type="hidden" name="action" value="escrow_payment" />
                </form><?php
                } ?>
  </td></tr>
</table><br>
<?php



    }