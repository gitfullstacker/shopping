	function Save_Pw() {
		if (ValidpChk()==false) return;

		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';

		document.frm.target = "lbl_Iframe";
		document.frm.RetrieveFlag.value = "PUPDATE";
		document.frm.action = "user_info_proc.php";
		document.frm.submit();
	}

	function ValidpChk()	{
		// 아이디, 비밀번호 입력체크, 이름, 주민번호, 전화번호
		var f = document.frm;


		if(chkSpace(f.str_opasswd.value)){
        	alert("\n기존비밀번호를 입력해 주세요..");
            f.str_opasswd.focus();
            return false;
		}
		if(chkSpace(f.str_passwd1.value)){
        	alert("\n비밀번호를 입력해 주세요..");
            f.str_passwd1.focus();
            return false;
		}
		if(chkSpace(f.str_passwd2.value)){
        	alert("\n비밀번호를 입력해 주세요..");
            f.str_passwd2.focus();
            return false;
	    }
	    if(str_passwd_check()==false) {
            f.str_passwd1.focus();
        	return false;
		}
	}

	function Save_Click() {
		if (ValidChk()==false) return;

		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';

		document.frm.target = "lbl_Iframe";
		document.frm.RetrieveFlag.value = "UPDATE";
		document.frm.action = "user_info_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		// 아이디, 비밀번호 입력체크, 이름, 주민번호, 전화번호
		var f = document.frm;

		/*
		if(f.str_hp1.selectedIndex==0){
	   		alert("\n휴대폰을 선택해 주세요..");
	        f.str_hp1.focus();
	        return false;
	    }
		if(chkSpace(f.str_hp2.value)){
	   		alert("\n휴대폰을 입력해 주세요..");
	        f.str_hp2.focus();
	        return false;
	    }
		if(chkSpace(f.str_hp3.value)){
	   		alert("\n휴대폰을 입력해 주세요..");
	        f.str_hp3.focus();
	        return false;
	    }	
	    */	
		if(chkSpace(f.str_post.value)){
	   		alert("\n주소를 입력해 주세요..");
	        f.str_post.focus();
	        return false;
	    }
		if(chkSpace(f.str_addr1.value)){
	   		alert("\n주소를 입력해 주세요..");
	        f.str_addr1.focus();
	        return false;
	    }
		if(chkSpace(f.str_addr2.value)){
	   		alert("\n주소를 입력해 주세요..");
	        f.str_addr2.focus();
	        return false;
	    }
		if(chkSpace(f.str_email1.value)){
	   		alert("\n이메일를 입력해 주세요..");
	        f.str_email1.focus();
	        return false;
	    }
		if(chkSpace(f.str_email2.value)){
	   		alert("\n이메일를 입력해 주세요..");
	        f.str_email2.focus();
	        return false;
	    }
	    if(str_email_check()==false) {
	        f.str_email1.focus();
	        return false;
		}
		return true;
	}

	function str_passwd_check()
	{
	    //valid check
		if ( document.frm.str_passwd1.value.length <= 0 )
		{
			alert("\n비밀번호를 입력하세요.");
			return false;
		}
		if ( document.frm.str_passwd2.value.length <= 0 )
		{
			alert("\n비밀번호를 한번 더 입력하세요.");
			document.frm.str_passwd2.value="";
			return false;
		}

	    	if( document.frm.str_passwd1.value != document.frm.str_passwd2.value)
		{
			alert("\n비밀번호를 정확히 입력하세요.");
			document.frm.str_passwd1.value="";
			document.frm.str_passwd2.value="";
			return false;
		}

		if ( _valid_length_check(2) ) return false;
		return true;
	}

	function _valid_length_check(opt) {
		if ( opt == 1 || opt == 0 ) {
	        //==============영문, 한글 byle수 계산 logic=====================
			str = document.frm.str_userid.value;
			var strbyte = 0;
			for (i = 0; i < str.length; i++) {
				var code = str.charCodeAt(i);
				var ch   = str.substr(i,1).toUpperCase();
				code = parseInt(code);
				if ( (ch<"0" || ch>"9") && (ch < "A" || ch > "Z") && ( (code>255) || code<0 ) )
					strbyte = strbyte + 2; //한글인경우 2byte로 계산
				else
					strbyte = strbyte + 1; //숫자,문자의 경우 1byte로 계산
			}
		}
		if ( opt == 2 || opt == 0 ) {
		        if (document.frm.str_passwd2.value.length<6 || document.frm.str_passwd2.value.length>12) {
		  	    	alert("비밀번호는 6-12 byte 입니다.");
		  	    	return 1;
		  	}
		}
		return 0;
	}

	//숫자체크
	function isnum(NUM) {
		for(var i=0;i<NUM.length;i++){
			achar = NUM.substring(i,i+1);
			if( achar < "0" || achar > "9" ){
				return false;
			}
		}
		return true;
	}

	function str_email_check() {
	   	if(!isValidEmail(document.frm.str_email1.value+'@'+document.frm.str_email2.value)){
	   		alert("\n정확한 이메일 주소를 입력하세요.");
			document.frm.str_email1.value="";
			return false;
		}
		return true;
	}

	// 입력값이 이메일 형식인지 체크
	function isValidEmail(input) {
	//    var format = /^(\S+)@(\S+)\.([A-Za-z]+)$/;
	    var format = /^((\w|[\-\.])+)@((\w|[\-\.])+)\.([A-Za-z]+)$/;
	    return isValidFormat(input,format);
	}

	// 입력값이 사용자가 정의한 포맷 형식인지 체크
	function isValidFormat(input,format) {
		  if (input.search(format) != -1) {
	        return true; //올바른 포맷 형식
	    }
	    return false;
	}

	function Check_jumin (it)  // 주민등록번호를 check하는 함수
	{
		IDtot = 0;
		IDAdd="234567892345";
		for(i=0;i<12;i++) {
			IDtot=IDtot + parseInt(it.substring(i,i+1))*parseInt(IDAdd.substring(i,i+1));
		}
		IDtot=11-(IDtot%11);
		if(IDtot==10) {
			IDtot=0;
		} else if(IDtot==11) {
			IDtot=1;
		}
		if(parseInt(it.substring(12,13))!=IDtot) {
			return true;
		} else {
			return(false)
		}
	}

	function fnc_semail(str_value) {
		if (str_value == "") {
			document.frm.str_email2.value = "";
		} else {
			document.frm.str_email2.value = str_value;
		}
	}

	// 입력값이 NULL 인지 체크
	function chkSpace(strValue){
		var flag=true;
		if (strValue!=""){
			for (var i=0; i < strValue.length; i++){
				if (strValue.charAt(i) != " "){
					flag=false;
					break;
				}
			}
		}
		return flag;
	}
	
	function fnc_semail1(str_value) {
		if (str_value == "") {
			document.frm.str_email2.value = "";
		} else {
			document.frm.str_email2.value = str_value;
		}
	}
	
	function fnc_Auth() {
		document.form_chk.EncodeData.value = fuc_ajax('user_info_proc.php?RetrieveFlag=CERT');
		fnPopup();
	}
	
	window.name ="Parent_window";
	
	function fnPopup(){
		window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
		document.form_chk.target = "popupChk";
		document.form_chk.submit();
	}