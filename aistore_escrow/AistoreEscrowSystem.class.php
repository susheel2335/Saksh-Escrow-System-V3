<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}
 

include_once "AistoreEscrow.class.php";


class AistoreEscrowSystem extends  AistoreEscrow
{



    
      public static function aistore_bank_details()
    {

       do_action("Aistorebank_makepayment");
   
        
    }
    
    // create escrow System
    public  function aistore_escrow_system()
    {

      
    ob_start();
            
 
 
        $aistore_escrow_currency = $this->get_escrow_currency();

        $escrow_admin_user_id = $this->get_escrow_admin_user_id(); // change variable name
        

        echo "<div>";

        $wallet = new AistoreWallet();

        $user_id = get_current_user_id();

        
        
        if (isset($_POST['submit']) and $_POST['action'] == 'escrow_system')
        {
            
   
            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
            
            
              
  $_REQUEST['user_email']= get_the_author_meta('user_email',$user_id);
              
            $escrow=     $this->create_escrow($_REQUEST)  ;
            
            
 
         
           $bank_details_page_id_url = esc_url(add_query_arg(array(
                'page_id' => get_option('bank_details_page_id') ,
                'eid' => $escrow->id,
            ) , home_url()));
    
            
          $data=array();
       $data['escrow']=$escrow;
       $data['files']=$_FILES;
       $data['request']=$_REQUEST;
       $data['get']=$_GET;
       $data['post']=$_POST;
          $data['server']=$_SERVER;
        do_action("AistoreEscrowCreatedafter", $data);     
         
 
?>
<meta http-equiv="refresh" content="0; URL=<?php echo esc_url($bank_details_page_id_url); ?>" />


<?php
 
    
        }
        else
        {
?>
    
    <form method="POST" action="" name="escrow_system" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

                
                 
<label for="title"><?php _e('Title', 'aistore'); ?></label><br>
  <input class="input" type="text" id="title" name="title" required><br>

  <label for="title"><?php _e('Currency', 'aistore'); ?></label><br>
  <?php
            global $wpdb;
            $escrow_wallet = new AistoreWallet();
        $results = $escrow_wallet->aistore_wallet_currency();
        
        
?>
       <select name="aistore_escrow_currency" id="aistore_escrow_currency" >
                <?php
            foreach ($results as $c)
            {

                echo '	<option  value="' . esc_attr($c->symbol) . '">' . esc_attr($c->currency) . '</option>';

            }
?>
           
  
</select><br>
 

  <label for="amount"><?php _e('Amount', 'aistore'); ?></label><br>
  <input class="input" type="text" id="amount" name="amount"   required><br>
 
 
 
  
<label for="receiver_email"><?php _e('Receiver Email', 'aistore'); ?>:</label><br>
  <input class="input" type="email" id="receiver_email" name="receiver_email" required><br>
  
   <label for="term_condition"> <?php _e('Term And Condition', 'aistore') ?></label><br>
   
  <?php
            $content = '';
            $editor_id = 'term_condition';

            $settings = array(
                'tinymce' => array(
                    'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright   ',
                    'toolbar2' => '',
                    'toolbar3' => ''

                ) ,
                'textarea_rows' => 1,
                'teeny' => true,
                'quicktags' => false,
                'media_buttons' => false,
                'remove_linebreaks' => false
            );

            wp_editor($content, $editor_id, $settings);


  
  do_action( "after_aistore_escrow_form" ,$_REQUEST);
  
  ?>
	
<input 
 type="submit" class="button button-primary  btn  btn-primary "   name="submit" value="<?php _e('Create Escrow', 'aistore') ?>"/>
 
 
<input type="hidden" name="action" value="escrow_system" />
</form> 
<?php
        }

?>
</div>
<?php

 return ob_get_clean();
 
 
    }

    // Escrow List
    public   function aistore_escrow_list()
    {
      
        
        
        

$object_escrow_currency = new AistoreEscrowSystem();

$aistore_escrow_currency = $object_escrow_currency->get_escrow_currency();


$user_id= get_current_user_id();
$current_user_email_id = get_the_author_meta('user_email', $user_id);



        global $wpdb;


  $results=$this->AistoreEscrowList($current_user_email_id);
               
               
    ob_start();
    
  
 
  
  do_action( "aistore_escrow_list_top" ,$current_user_email_id);
  
  ?>
     
<h3><u><?php _e('Top  Escrow', 'aistore'); ?></u> </h3>
<?php
        if ($results == null)
        {
            echo "<div class='no-result'>";

            _e('No Escrow Found', 'aistore');
            echo "</div>";
        }
        else
        {

        
            
               
               

?>
  
    <table class="table">
     
        <tr>
      
    <th><?php _e('Id', 'aistore'); ?></th>
        <th><?php _e('Title', 'aistore'); ?></th>
         <th><?php _e('Role', 'aistore'); ?></th>
          <th><?php _e('Amount', 'aistore'); ?></th> 
		  <th><?php _e('Sender', 'aistore'); ?></th>
		  <th><?php _e('Receiver', 'aistore'); ?></th>
		    <th><?php _e('Payment Status', 'aistore'); ?></th>
		 	    <th><?php _e('Status', 'aistore'); ?></th>
</tr>

    <?php
            foreach ($results as $row):




            
            $details_escrow_page_id_url = esc_url( $row->url);
            
            
              

?>
 
 
      
    
      <tr>
           
		 
		   
	
	  <td> 	<a href="<?php echo esc_url($details_escrow_page_id_url); ?>" >

		   <?php echo esc_attr($row->id); ?> </a> </td>
  <td> 		   <?php echo esc_attr($row->title); ?> </td>
    <td> 	

  <?php
                if ($row->sender_email == $current_user_email_id)
                {
                    $role = "Sender";
                    $email = $row->receiver_email;
                }
                else
                {
                    $role = "Receiver";
                    $email = $row->sender_email;
                }
                echo esc_attr($role);

?>
</td>
		   

  <td> 		   <?php echo esc_attr($row->amount) . " " . esc_attr($row->currency) ?> </td>
		   <td> 		   <?php echo esc_attr($row->sender_email); ?> </td>
		   <td> 		   <?php echo esc_attr($row->receiver_email); ?> </td>
		    <td> 		   <?php echo esc_attr($row->payment_status); ?> </td>
   <td> 		   <?php echo esc_attr($row->status); ?> </td>
            </tr>
    <?php
            endforeach;

        } ?>

    </table>
	
	
	
	
	

    <?php
    
    
  
  do_action( "aistore_escrow_list_bottom" ,$current_user_email_id);
  
  
  
        return ob_get_clean();

    }




    // Escrow Details
    public   function aistore_escrow_detail()
    {
        

 ob_start();
 
 
 
        if (!sanitize_text_field($_REQUEST['eid']))
        {

            $add_escrow_page_url = esc_url(add_query_arg(array(
                'page_id' => get_option('add_escrow_page_id') ,
            ) , home_url()));


echo    $add_escrow_page_url;

?>
    
   
<meta http-equiv="refresh" content="0; URL=<?php echo esc_url($add_escrow_page_url); ?>" /> 
  
 <?php
        }
global $wpdb;
        $eid = sanitize_text_field($_REQUEST['eid']);
        
 
        
   do_action( "before_aistore_escrow", $eid );

        
//    $aistore_escrow_btns = new AistoreEscrowBTN();
  
   $this->aistore_escrow_btn_actions();
      
      

    //    $object_escrow = new AistoreEscrowSystem();

        $escrow_admin_user_id = $this->get_escrow_admin_user_id();

        $user_id = get_current_user_id();

        $email_id = get_the_author_meta('user_email', $user_id);

               
$escrow=$this->AistoreEscrowDetail($eid,$email_id) ;
               
     $user_email =$email_id;;
      
    
?>
<div>
	       <div class="alert alert-success" role="alert">
 <strong>  <?php _e('Status ', 'aistore'); ?>   <?php echo esc_attr($escrow->status); ?></strong>
  </div>
	  
	  
	    <div class="alert alert-success" role="alert">
 <strong><?php _e('Payment Status ', 'aistore'); ?>   <?php echo esc_attr($escrow->payment_status); ?></strong>
  </div>
  
<?php
	      if ($escrow->payment_status == "Pending")
        // if ($this->make_payment_btn_visible($escrow, $user_email))
        {
            
?>

<div>  <p>Don't ship the product.</p>  </div><br>
  
  
  <?php
      
            
            if ($escrow->sender_email == $user_email)
            {


 $bank_details_page_id_url = esc_url(add_query_arg(array(
                'page_id' => get_option('bank_details_page_id') ,
                'eid' => $eid,) , home_url()));
            
            
            
            ?>

<a href="<?php echo esc_url($bank_details_page_id_url); ?>"><input  class="button button-primary  btn  btn-primary "  type="submit" name="submit" value="<?php _e('Make Payment', 'aistore') ?>"/></a>
 
 
<?php
                } ?>
 <br>


  <?php
            

        }

        echo "<h1>#" . esc_attr($escrow->id) . " " . esc_attr($escrow->title) . "</h1><br>";
        
        
        
        
        printf(__("Sender :  %s", 'aistore') , $escrow->sender_email . "<br>");
        printf(__("Receiver : %s", 'aistore') , $escrow->receiver_email . "<br>");
        printf(__("Status : %s", 'aistore') , $escrow->status . "<br>");
         printf(__("Amount : %s", 'aistore') , $escrow->amount ." ". $escrow->currency."<br><hr />");
         
          

        $this->accept_escrow_btn($escrow);
        $this->cancel_escrow_btn($escrow);
        $this->release_escrow_btn($escrow);
        $this->dispute_escrow_btn($escrow);

 


 echo $this->aistore_escrow_detail_tabs($escrow); 
  

   do_action( "after_aistore_escrow", $escrow  );
 
  
  do_action( "aistore_details_bottom_section", $escrow  );
  
 
  
  
$eschat = new Aistorechat();
$eschat->ACS_escrow_chat();
 
  
 
 
        return ob_get_clean();
    }
  
   

      
     public   function aistore_escrow_detail_tabs($escrow)
    {
        

 ob_start();
  

?>

<br><br>




<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
   
   
    
    
    
     <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-term" type="button" role="tab" aria-controls="nav-term" aria-selected="false">Term and Condition</button>
     
     
     <?php
  
  do_action( "aistore_escrow_tab_button", $escrow  );
  
  ?>
  
  
  </div>
</nav>

<br>
<div class="tab-content" id="nav-tabContent">
   
  
    <div class="tab-pane fade" id="nav-term" role="tabpanel" aria-labelledby="nav-term-tab"> <?php
  
   printf(__("<br>Term Condition : %s", 'aistore') , html_entity_decode($escrow->term_condition) . "<br><br>");
  
 
  
  ?></div>
  
   
    <?php
  
  do_action( "aistore_escrow_tab_contents", $escrow  );
  
  ?>
  
  
</div>


      

  
  <?php
  
 
 
        return ob_get_clean();
    }
   


 

}


