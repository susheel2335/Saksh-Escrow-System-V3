<?php

// remove woocommerce use our own table 



function aistore_add_product(){
    
   $user_id = get_current_user_id();
   
        $user_role = get_user_meta($user_id, 'user_role', true);

            $editor = array(
                'tinymce' => array(
                    'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright, link,unlink,  ',
                    'toolbar2' => '',
                    'toolbar3' => ''

                ) ,
                'textarea_rows' => 1,
                'teeny' => true,
                'quicktags' => false,
                'media_buttons' => false
            );

?>
    
<h3><?php _e("Add a Product", "blank"); ?></h3>
<?php
            if (isset($_POST['submit']) and $_POST['action'] == 'product')
            {

                if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
                {
                    return _e('Sorry, your nonce did not verify', 'aistore');

                }
    global $wpdb;
                $name = sanitize_text_field($_REQUEST['product_name']);

                $short_description = sanitize_text_field($_REQUEST['short_description']);
                $amount = intval($_REQUEST['amount']);
                $price = intval($_REQUEST['price']);
                $full_description = sanitize_text_field($_REQUEST['full_description']);
                $category = sanitize_text_field($_REQUEST['category']);

                $terms_condtion = sanitize_text_field($_REQUEST['terms_condtion']);
                $tags = sanitize_text_field($_REQUEST['tags']);

                $product_type = sanitize_text_field($_REQUEST['product_type']);

                            
                $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}company where user_id=%s ",$user_id));
                 
           $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}product ( name,short_description, amount, price,full_description,user_id,category,terms_condtion,tags,product_type,company_id ) VALUES (%s ,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)", array(
            $name,
            $short_description,
            $amount,
            $price,
            $full_description,
            $user_id,
            $category,
            $terms_condtion,
            $tags,
            $product_type,
            $company->company_id
           
        )));   
        
     
                 $pid = $wpdb->insert_id;
           

         
                $upload_dir = wp_upload_dir();

                if (!empty($upload_dir['basedir']))
                {

                    $user_dirname = $upload_dir['basedir'] . '/documents/' . $pid;
                    if (!file_exists($user_dirname))
                    {
                        wp_mkdir_p($user_dirname);
                    }

                    $filename = wp_unique_filename($user_dirname, $_FILES['file']['name']);
                    move_uploaded_file(sanitize_text_field($_FILES['file']['tmp_name']) , $user_dirname . '/' . $filename);

                    $image = $upload_dir['baseurl'] . '/documents/' . $pid . '/' . $filename;


}
            
            
            }
            else
            {

?>
      <div >
      <form method="POST" action="" name="product" enctype="multipart/form-data"> 
 
<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>


    <br>      
        <div class="mb-3">   
<label><?php _e('Title', 'aistore'); ?></label><br/>
  <input class="input" type="text" id="product_name" name="product_name" required></div><br><br>
  
    
   <br>      
        <div class="mb-3">   
<label><?php _e('Regular price ($)', 'aistore'); ?></label><br/>
  <input class="input" type="text" id="price" name="price" required></div><br><br>
    <br>      
        <div class="mb-3">   
<label><?php _e('Sale price ($)', 'aistore'); ?></label><br/>
  <input class="input" type="text" id="amount" name="amount" required></div><br><br>


      <div class="mb-3">   
 <label for="downloadable">  <?php _e('Product Type', 'aistore'); ?> </label>
<br> <input  type="checkbox" id="virtual" name="product_type" value="Virtual">
  <?php _e('Virtual', 'aistore'); ?> 
 <input type="checkbox" id="downloadable" name="product_type" value="downloadable"  onclick="myFunction()">
   <?php _e('Downloadable', 'aistore'); ?></div><br><br>
   
 


<?php

                $categories = get_terms(array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => false

                ));
?>

    <div class="mb-3">   
<label><?php _e('Category', 'aistore'); ?></label><br>
  <select name="category" id="category">
      <?php

                foreach ($categories as $category)
                {

                    echo ' <option value="' . esc_attr($category->name) . '">' . esc_attr($category->name) . '   </option>';

                }

?>
  </select></div><br><br>
  
  
      <div class="mb-3">   
  <label><?php _e('Tags', 'aistore'); ?></label><br>
  <textarea id="tags" name="tags" rows="3" cols="50">
</textarea></div><br>


 <br>     <div class="mb-3">   <label><?php _e('Short Description', 'aistore'); ?></label><br/>

   <?php
                $content = '';
                $editor_id = 'short_description';

                $short_description = $editor;

                wp_editor($content, $editor_id, $short_description);

?></div>
   
 <br>     <div class="mb-3">   <label><?php _e('Full Description', 'aistore'); ?></label>
 <br/>
   <?php
                $content = '';
                $editor_id = 'full_description';

                $full_description = $editor;

                wp_editor($content, $editor_id, $full_description);

?></div>
 

  
  <br>    <div class="mb-3">   <label><?php _e('Terms and conditions', 'aistore'); ?></label><br/>

   <?php
                $content = '';
                $editor_id = 'terms_condtion';

                $terms_condtion = $editor;

                wp_editor($content, $editor_id, $terms_condtion);

?></div>
<br>

    <div class="mb-3">   
  <label><?php _e('Product Image', 'aistore'); ?></label><br/>
  <input class="input" type="file" id="file" name="file" ></div><br><br>
  

  
  

  
  <input  type="submit"  name="submit" value="<?php _e('Submit', 'aistore') ?>">
  <input type="hidden" name="action" value="product" />
</form></div>
  </div><br><br>

      <?php
            }
        
}