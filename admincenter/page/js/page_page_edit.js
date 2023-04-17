	function Save_Click() {
		//if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value="INSERT"
		}
		oEditors.getById["str_contents"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
		document.frm.target = "_self";
		document.frm.action = "page_page_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		if(chkSpace(f.str_sdate.value)){
	       	alert("\n일시가 입력되지 않았습니다");
	       	f.str_sdate.focus();
	        return false;
	   	}
		if(chkSpace(f.str_edate.value)){
	       	alert("\n일시가 입력되지 않았습니다");
	       	f.str_edate.focus();
	        return false;
	   	}
		if(chkSpace(f.str_title.value)){
	       	alert("\n제목이 입력되지 않았습니다");
	       	f.str_title.focus();
	        return false;
	   	}
		return true;
	}

