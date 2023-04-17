	function fnc_search() {
		document.frm.page.value=1;
		document.frm.action = "search.php";
		document.frm.submit();
	}
	
	function fnc_more() {
		var f = document.frm;
//		var Txt_bcode= f.Txt_bcode.value;
//		var Txt_rent = f.Txt_rent.value;
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
		var sTemp = compFormPost(frm);

		var mData =fuc_ajax('search_load.php?RetrieveFlag=Load&'+sTemp);
		$("#labData").append(mData);
	}
	
	function fnc_gbn(gbn) {
		document.frm.page.value=1;
		document.frm.Txt_rent.value = gbn;
		document.frm.action = "search.php";
		document.frm.submit();
	}