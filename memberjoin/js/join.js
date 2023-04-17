	function Save_Click() {
		if (ValidChk()==false) return;

		//document.frm.target = "_self";
		fnPopup();
		//document.frm.action = "join02.php";
		//document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;

		if(f.str_agree1.checked==false){
	       	alert("\n개인정보처리방침에 동의하셔야 합니다.");
	       	f.str_agree1.focus();
	        return false;
	   	}
		return true;
	}
	window.name ="Parent_window";
	
	function fnPopup(){
		window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
		document.form_chk.target = "popupChk";
		document.form_chk.submit();
	}