
           <h1> <?php _e('Email Report', 'aistore') ?> </h1>  <br>
     <?php
      
        $escrow_admin_user_id =esc_attr( get_option('escrow_user_id'));
        $the_user = get_user_by( 'id', $escrow_admin_user_id );  
$admin_Email= $the_user->user_email;
    
      
	global $wpdb;
           	 
 $sql = "SELECT * FROM {$wpdb->prefix}escrow_email" ;
 
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
         <?php echo esc_attr($row->user_email); ?>
      </button>
    </h2>
    <div id="collapse<?php echo esc_attr($row->id); ?>" class="accordion-collapse collapse " aria-labelledby="heading<?php echo esc_attr($row->id); ?>" data-bs-parent="#accordionExample">
      <div class="accordion-body">
          To: <?php echo esc_attr($row->user_email); ?><br>
          From: <?php echo esc_attr($admin_Email); ?><br>
          Escrow Id: <?php echo esc_attr($row->reference_id); ?><br>
        <strong>Subject:  <?php echo esc_attr($row->subject); ?></strong> <br>Message: <?php echo html_entity_decode($row->message); ?><br><code><?php echo esc_attr($row->created_at); ?></code>
      </div>
    </div>
  </div>
  

    <?php
        endforeach;
    ?>
    
     </div>
        
        <?php } 