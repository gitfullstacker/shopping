	function Save_Click() {
		if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;		
			document.frm.RetrieveFlag.value="INSERT"
		}
		oEditors.getById["str_contents"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
		document.frm.target = "_self";
		document.frm.action = "mail_contents_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		if(chkSpace(f.str_name.value)){  
	       	alert("\n보내는이가 입력되지 않았습니다");
	       	f.str_name.focus();
	        return false;
	   	}
		if(chkSpace(f.str_email.value)){  
	       	alert("\n보내는이메일이 입력되지 않았습니다");
	       	f.str_email.focus();
	        return false;
	   	}
		if(chkSpace(f.str_title.value)){  
	       	alert("\n제목이 입력되지 않았습니다");
	       	f.str_title.focus();
	        return false;
	   	}
		return true;		
	}
	
