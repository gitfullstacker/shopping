if (window.console == undefined) {console={log:function(){} };}

$(document).ready(function(){

	// ipt-type-1 입력내용 삭제 버튼 노출
	$('.ipt-type-1 > input').on('keyup focusin focusout',function(e){
		var $this = $(this);
		if (e.target.value == '') {
			$this.parent().removeClass('active');
		}else{
			$this.parent().addClass('active');
		};
	});

	// 입력내용 삭제
	$('input + .btn-clear').on('click',function(e){
		var $this = $(this);
		$this.prev().val('').focus();
		e.preventDefault();
	});

});
