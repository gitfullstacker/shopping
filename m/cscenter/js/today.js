	function fnc_more() {
		var f = document.frm;
		var Tpage = f.total_page.value;
		var page = f.page.value;
		
		if ((parseInt(page)+1) <= parseInt(Tpage)) {
			f.page.value = (parseInt(page)+1);
			fnc_dataload(Tpage,f.page.value);
		} else {
			alert("마지막 화면입니다.");
		}		
	}
	function fnc_dataload(Tpage,page) {
		var mData =fuc_ajax('today_load.php?RetrieveFlag=Load&Tpage='+Tpage+'&page='+page);
		$("#labData").append(mData);
	}