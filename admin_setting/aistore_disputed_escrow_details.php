<?php


        if (!isset($eid))
        {

            $url = admin_url('admin.php?page=disputed_escrow_list', 'https');

?>
	<div><a href="<?php echo esc_url($url); ?>" >
	    <?php _e('Go To Escrow List Page', 'aistore'); ?> 
	     </a></div>
<?php
           
        }

 

        $eid = sanitize_text_field($_REQUEST['eid']);

        $object_escrow = new AistoreEscrowSystemAdmin();
        
         
      
        
     echo  $object_escrow->aistore_admin_escrow_detail( );
      
     
    // do_action('Aistorebank_makepayment');
     
            ?>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"    >
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"  ></script>
 
 