  

$(function(){   
	 
	       
        $('.flash').fadeOut(3000);
       
 

         //$(document).pjax('a', '#page', { fragment: ('#page'), timeout: 10000 });



	 
});

 


 

function autocomplate(ele,url){
	$(ele).autocomplete({
		source: function( request, response ) {
	        $.ajax({
	          url: url,
	          dataType: "jsonp",
	          data: {
	            q: request.term
	          },
	          success: function( data ) {
	            response(data);
	          }
	        });
	      },
	      minLength: 1,
	      select: function( event, ui ) {
		      $('#user2').val(ui.item.key);
	      }
	});
}
