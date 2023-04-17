	function fncSendData() {
		if (ValidChk()==false) return false;

		document.frm.action = "logi_login_chk.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		if(chkSpace(f.str_userid.value)){  
	       	alert("\n아이디가 입력되지 않았습니다");
	   		f.str_userid.focus(); 
	        return false;
	   	}
		if(chkSpace(f.str_passwd.value)){  
	       	alert("\n비밀번호가 입력되지 않았습니다");
	   		f.str_passwd.focus(); 
	        return false;
	   	}
	   	 return true;
	}