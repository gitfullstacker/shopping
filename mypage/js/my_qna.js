	function Click_Delete(str_no) {
		if(!confirm("삭제 하시겠습니까?")) return;
		
		fuc_ajax('my_qna_pop_proc.php?RetrieveFlag=ADELETE&str_no='+str_no);
		
		document.frm.target = "_self";
		document.frm.submit();		
	}