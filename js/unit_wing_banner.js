 (function($){
	
	$(function(){
		//공통
		funcEvt.commonEvt.event();


		var sfixrt  = localStorage.getItem('fixrt');
		var _cuRcss = $('.fix_rt_menu').css('right');
		
		if(sfixrt == null || sfixrt != "actvz"){
			$('.fix_rt_menu').css('right', 0+"px");
		}else{
			$('.fix_rt_menu').css('right', -125+"px");
		}	
/*
		if(_loc[0] > 0 ){
			funcEvt.mainEvt.event();
		}
*/
	});

	funcEvt = {
		commonEvt : {
			event:function(){
				$('.rt_btn, .fixclose_bt').on('click',function(){
					var _cuRcss = $('.fix_rt_menu').css('right');
					if(_cuRcss == '-125px'){
						$('.rt_btn img').attr("src","/images/common/close_btn.gif");
						$('.fix_rt_menu').stop().animate({
							'right' : 0
						});
						localStorage.removeItem('fixrt');
					}else{
						$('.rt_btn img').attr("src","/images/common/open_btn.gif");
						$('.fix_rt_menu').stop().animate({
							'right' : '-125px'
						});	
						localStorage.setItem('fixrt', 'actvz');
					}			
				});
			}
		}
		
	}
})(jQuery);










				$('.rbanner_topbt').on('click',function(){
					$('html, body').animate({
						scrollTop : 0
					});
				});