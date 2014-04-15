// JavaScript Document

$(function(){
	$('#dataTable > tbody > tr:odd ').addClass('tr_odd');			   
	contentResize();
	$(window).resize(function(){
		contentResize();
	})	
	
	$('.btn').append('<div></div>');	
})

/**/
function contentResize(){
	var h=$(window).height()-$('#header').height()-$('#footer').height()-53;
	var secondaryHeight=$('#secondary').height();
	if(h>secondaryHeight){		
		$('#container').css('min-height',h);		
	}else{		
		$('#container').css('min-height',secondaryHeight);		
	}
}

/*launch Ajax*/

function ajax_launch(element,url){
		$(element).click(function(){
			var thisObj=$(this);
			var launch=1
			if(thisObj.hasClass('this')){
				launch=0;	
			}	
			
			var sn=thisObj.attr('sn');
			$.ajax({
				url: url,
				type: "POST",
				cache:false,
				data: { sn : sn,launch:launch},
				dataType: "json",
				beforeSend:function(){
					thisObj.attr("disabled", true);
				},
				success:function(data){
					if(data.success){
						if(launch){
							thisObj.addClass('this');	
						}else{							
							thisObj.removeClass('this');
						}
					}else{
						alert('ajax Error');
					}			
				},
				complete:function(){
					thisObj.attr("disabled", false);						
				}
			});			
			return false;
		})
	}