	function Save_Click() {
		if (ValidChk()==false) return;

		document.frm.target = "_self";
		document.frm.action = "join03.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;

		if(f.str_agree1.checked==false){
	       	alert("\n이용약관에 동의하셔야 합니다.");
	       	f.str_agree1.focus();
	        return false;
	   	}
		if(f.str_agree2.checked==false){
	       	alert("\n개인정보 수집 및 이용에 동의하셔야 합니다.");
	       	f.str_agree2.focus();
	        return false;
	   	}
		return true;
	}
	function fnc_agree(obj) {
		
		var f = document.frm;
		
		if (obj.checked) {
			f.str_agree1.checked=true;
			f.str_agree2.checked=true;
		} else {
			f.str_agree1.checked=false;
			f.str_agree2.checked=false;		
		}
	}