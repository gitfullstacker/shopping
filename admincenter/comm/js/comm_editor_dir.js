	function Save_Click() {
		if (ValidChk()==false) return;
		document.frm.RetrieveFlag.value="INSERT"
		document.frm.action = "comm_editor_list_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		if(chkSpace(f.str_dir.value)){  
	       	alert('\n폴더명이 입력되지 않았습니다.');
	   		f.str_dir.focus(); 
	        return false;
	   	}
		return true;		
	}
