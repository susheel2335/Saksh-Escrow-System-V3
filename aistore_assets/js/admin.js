jQuery(document).ready(function( $){
  
    
    
 
 
  jQuery('input[type="checkbox"]').change(function(){
        
         
      
   
var id=$(this).attr('id');
var status = $(this).val();

alert(status);


if(status == 1) {
    status = 0; 
} else {
    status = 1; 
}
alert(id);

/*
$.ajax({
        type:'POST',
        url:'updateustaus.php',
        data:'id= ' + id + '&status='+status
    });
    
    */
 });

});