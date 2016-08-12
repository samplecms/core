 

$(function(){   
	
       ajax_form();   

       captcha_refresh();
	 
	       
        $('.flash').fadeOut(3000);
       

         ui_sort();


         // $(document).pjax('a', '#page', { fragment: ('#page'), timeout: 10000 });



	 
});

function ui_sort(){


         var fixHelper = function(e, ui) {  
            //console.log(ui)   
            ui.children().each(function() {  
                $(this).width($(this).width());     //在拖动时，拖动行的cell（单元格）宽度会发生改变。在这里做了处理就没问题了   
            });  
            return ui;  
        };  
           
          
    
        jQuery(".sort_table tbody").sortable({                //这里是talbe tbody，绑定 了sortable   
            cursor: "move",
            helper: fixHelper,                  //调用fixHelper   
            axis:"y",  
            start:function(e, ui){  
                ui.item.addClass("ui-state-highlight");
                
                return ui;  
            },  
            stop:function(e, ui){ 
              console.log(ui.offset);
              console.log(ui.originalPosition);
                $('#submit').show(); 
                
                ui.item.removeClass("ui-state-highlight"); //释放鼠标时，要用ui.item才是释放的行   
                return ui;  
            }  
        }).disableSelection();  
        
}
function captcha_refresh(){

  $('img.captcha').click(function(){

        var src = $(this).attr('src')+"?="+Math.random();

        $(this).attr('src',src);
  });
}

 

function ajax_form(){
  $(".ajax_form").each(function(e){
    $(this).unbind("submit").bind("submit",function(){
      $("button").attr({"disabled":"disabled"});
      return simple_ajax_form(this);
    })
  });
}

function simple_ajax_form(form){
  var options={
    dataType:'json',
    success:function(data){
      if(data.status){
        if(data.fun != undefined && data.fun!=''){
          eval(data.fun);
        }
        if(data.msg != undefined && data.msg!=''){
          alert(data.msg);
        }
        if(data.page_goto != undefined && data.page_goto!=''){
          window.location.href=data.page_goto;
        }
      }
      else{
        show_error($(form),data.msg);
        $("button").attr("disabled",false);
        if(data.page_goto != undefined && data.page_goto!=''){
          window.location.href=data.page_goto;
        }
      }

      $("button").removeAttr("disabled");
    },
    error:function(e){
      alert('错误：'+e.status);
      console.log(e);
      $("button").removeAttr("disabled");
    }
  };

  $(form).ajaxSubmit(options);
  return false;
}

function show_error(form,msg){
  $('.error',form).html('').hide();
  console.log(msg);
  for(var i in msg){
    console.log(i);
    
    var find = $('.error_'+i,form);
    if(find){
    	if(msg[i].indexOf('成功')!=-1){
    		find.html(msg[i]).removeClass('alert-danger').addClass('alert alert-success').show();
    	}else{
    		find.html(msg[i]).removeClass('alert-success').addClass('alert alert-danger').show();
    	}
    	
    	$('*[name="'+i+'"]',form).one('focus',function(){
            find.html('').hide();
        });
    }
    $('.info',form).html(msg).addClass('alert alert-success').fadeOut(3000);
    
    
     
  }
  
}


 

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
