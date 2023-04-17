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
		var mData =fuc_ajax('my_qna_load.php?RetrieveFlag=Load&Tpage='+Tpage+'&page='+page);
		$("#labData").append(mData);
	}
	
	function Click_Delete(str_no) {
		if(!confirm("삭제 하시겠습니까?")) return;
		
		fuc_ajax('my_qna_write_proc.php?RetrieveFlag=ADELETE&str_no='+str_no);
		
		document.frm.target = "_self";
		document.frm.submit();		
	}