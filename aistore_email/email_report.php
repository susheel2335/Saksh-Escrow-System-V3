<?php
 add_filter( 'after_aistore_escrow', 'aistore_email_report' );
  
     function  aistore_email_report($eid){
         
         ?>
   
           <h1> <?php _e('Email Notification', 'aistore') ?> </h1>  <br>
     <?php
      
	global $wpdb;
           	 
//  $sql = "SELECT * FROM {$wpdb->prefix}escrow_email " ;
  $sql = "SELECT * FROM {$wpdb->prefix}escrow_email WHERE   reference_id=".$eid;
 
     	 $results = $wpdb->get_results($sql);
     	  if ($results == null)
        {
            _e("No Email Found", 'aistore');

        }
        else{
        ?>
         <div class="accordion" id="accordionExample">
         
     <?php
 	foreach ($results as $row):
            
?> 

  <div class="accordion-item">
    <h2 class="accordion-header" id="heading<?php echo esc_attr($row->id); ?>">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo esc_attr($row->id); ?>" aria-expanded="true" aria-controls="collapseOne">
         <?php 
     
    echo esc_attr($row->user_email) . " --- ". esc_attr($row->created_at). "     --- ". esc_attr($row->subject)  ; ?>
      </button>
    </h2>
    <div id="collapse<?php echo esc_attr($row->id); ?>" class="accordion-collapse collapse " aria-labelledby="heading<?php echo esc_attr($row->id); ?>" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>Subject:  <?php echo esc_attr($row->subject); ?></strong> <br>Message: <?php echo html_entity_decode($row->message); ?><br><code><?php echo esc_attr($row->created_at); ?></code>
      </div>
    </div>
  </div>
  

    <?php
        endforeach;
    ?>
    
     </div>
        
        <?php } 
     }
     