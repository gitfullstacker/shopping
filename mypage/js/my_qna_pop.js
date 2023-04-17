	function Save_Click() {
		if (ValidChk()==false) return;

		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정 하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("문의 하시겠습니까?")) return;
			document.frm.RetrieveFlag.value="INSERT"
		}

		document.frm.target = "_self";
		document.frm.action = "my_qna_pop_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		if(chkSpace(f.str_cont.value)){
	       	alert("\n문의 내용이 입력되지 않았습니다");
	       	f.str_cont.focus();
	        return false;
	   	}
		return true;
	}

