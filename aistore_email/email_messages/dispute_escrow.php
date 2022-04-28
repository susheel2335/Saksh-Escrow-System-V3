Hi, 
<br /><br />


<?php 
     $escrow = $wpdb->get_row($wpdb->prepare( "SELECT * FROM {$wpdb->prefix}escrow_system WHERE  id=%d ",$eid ));



$html = esc_attr( get_option('email_dispute_escrow'));


$html.='<h1>Escrow Details </h1><br>
    <table><tr><td>Escrow Id :</td><td>'.$eid.'</td></tr>
      <tr><td>Title :</td><td>'.$escrow->title.'</td></tr>
    <tr><td>Amount :</td><td>'.$escrow->amount.'</td></tr>
      <tr><td>Escrow Fee :</td><td>'.$escrow->escrow_fee.'</td></tr>
          <tr><td>Sender :</td><td>'.$escrow->sender_email.'</td></tr>
              <tr><td>Receiver :</td><td>'.$escrow->receiver_email.'</td></tr>
               <tr><td>Status :</td><td>'.$escrow->status.'</td></tr>
        <tr><td>Date :</td><td>'.$escrow->created_at.'</td></tr></table><br>';
        
            $html.='<h1>Sender Details </h1><br>
    <table><tr><td>Email :</td><td>'.$escrow->sender_email.'</td></tr>
      <tr><td>Name :</td><td>'.$escrow->sender_email.'</td></tr>
   </table><br>';
        
        
        $html.='<h1>Receiver Details </h1><br>
    <table><tr><td>Email :</td><td>'.$escrow->receiver_email.'</td></tr>
      <tr><td>Name :</td><td>'.$escrow->receiver_email.'</td></tr></table><br>
    ';
    echo Aistore_process_placeholder_Text( $html,$escrow );

?>
 <br />
 
<br />

With Regards

