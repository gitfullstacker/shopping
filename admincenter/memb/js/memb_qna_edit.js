	function Save_Click() {
		if (ValidChk()==false) return;

		if(!confirm("답글을 하시겠습니까?")) return;
		document.frm.RetrieveFlag.value="RINSERT";

		document.frm.target = "_self";
		document.frm.action = "memb_qna_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		if(chkSpace(f.str_cont.value)){
	       	alert("\n내용이 입력되지 않았습니다");
	       	f.str_cont.focus();
	        return false;
	   	}
		return true;
	}

