	function Save_Click() {
		if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;		
			document.frm.RetrieveFlag.value="INSERT"
		}
		document.frm.action = "code_proc_right.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		if(chkSpace(f.str_idxword.value)){  
	       	alert("\n권한등급명이 입력되지 않았습니다");
	   		f.str_idxword.focus(); 
	        return false;
	   	}
		return true;		
	}
	function fnc_service(chkObj,str_menutype,str_chocode,str_unicode,str_idxcode,str_idxnum) {
	 	param = "RetrieveFlag=SERVICE&str_menutype="+chkObj.value.substring(1,3)+"&str_chocode="+chkObj.value.substring(3,5)+"&str_unicode="+chkObj.value.substring(5,10)+"&str_idxcode="+str_idxcode+"&str_idxnum="+str_idxnum+"&chkSvcFlag="+((chkObj.checked) ? "Y" : "N")
	 	param="code_proc_right.php?"+param
	 	fuc_set(param,'_Proc');
	}