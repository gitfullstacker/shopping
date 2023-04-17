	function Save_Click() {
		if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;		
			document.frm.RetrieveFlag.value="INSERT"
		}
		document.frm.action = "code_pw_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		if(chkSpace(f.str_idxword.value)){  
	       	alert("\n비번힌트가 입력되지 않았습니다");
	   		f.str_idxword.focus(); 
	        return false;
	   	}
		return true;		
	}
