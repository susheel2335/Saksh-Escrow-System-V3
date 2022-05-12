// 	alert("dddddddddddddddDfd");	
	
	jQuery(document).ready(function ($) {
// 	alert("Dfd");			    
  $("#amount1").keyup(function() {
      
  let amount1 = $(this).val();
  var coin1 = document.getElementById("coin1").value;
  var coin2 = document.getElementById("coin2").value;

// alert("Dfd");
  var $form = $(this);
// alert("Dfdxxxxxxxxxxxx");
	  $.ajax({
        type: "GET",
        url : ajax_object.ajax_url,
            data :{action: "getrate",  c1 :coin1,  c2 :coin2},
           
        success: function(data){
            // alert("Dfvvcbxx");
          	
console.log("rate",data);
var rate = data;
var amount2 = rate*amount1;
console.log("amount2",amount2);
  document.getElementById('amount2').value= amount2;
       


        }
    });
      	
  

  })
  
});