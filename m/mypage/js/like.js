	function Click_Del(str_goodcode) {

		if(!confirm("삭제 하시겠습니까?")) return;
		window.location.href="like_proc.php?RetrieveFlag=LIKEDEL&str_goodcode="+str_goodcode;
		return;	

	}
	
	function fnc_more() {
		var f = document.frm;
		var Tpage = f.total_page.value ;
		var page = f.page.value;
		
		if ((parseInt(page)+1) <= parseInt(Tpage)) {
			f.page.value = (parseInt(page)+1);
			fnc_dataload(Tpage,f.page.value);
		} else {
			alert("마지막 화면입니다.");
		}		
	}
	function fnc_dataload(Tpage,page) {
		var mData =fuc_ajax('like_load.php?RetrieveFlag=Load&Tpage='+Tpage+'&page='+page);
		$("#labData").append(mData);
	}