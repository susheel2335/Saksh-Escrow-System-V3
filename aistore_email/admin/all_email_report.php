<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
           <h1> <?php _e('Email Report', 'aistore') ?> </h1>  <br>
     <?php
      
	global $wpdb;
           	 
 $sql = "SELECT * FROM {$wpdb->prefix}escrow_email " ;
//   $sql = "SELECT * FROM {$wpdb->prefix}escrow_email WHERE   reference_id=".$eid;
 
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
          From: admin@blogentry.in<br>
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