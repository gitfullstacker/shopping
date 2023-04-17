	function Save_Pw() {
		if (ValidpChk()==false) return;

		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';

		document.frm.target = "lbl_Iframe";
		document.frm.RetrieveFlag.value = "PUPDATE";
		document.frm.action = "comm_passwd_proc.php";
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


	
	
	function str_userid_check() {
		if ( _valid_length_check(1) ) return false;
	    	if ( _is_hangle() ) {
	    		alert("\n한글은 사용하실수 없습니다."); 
			return false;
		}
		if(isnum(frm.str_userid.value)) { 
			alert("\n아이디는 영문과 혼용하셔야 합니다."); 
			return false;
		}
	        if (document.frm.str_userid.value.length<4 || document.frm.str_userid.value.length>12) {
	  	    	alert("아이디는 4-12byte 입니다.");
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
		        if (document.frm.str_passwd2.value.length<4 || document.frm.str_passwd2.value.length>12) {
		  	    	alert("비밀번호는 4-12 byte 입니다.");
		  	    	return 1;
		  	}
		}
		return 0;
	}
	
	function _is_hangle() {
	    var numMem = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	    var ch;
	    for (var i=0; i < frm.str_userid.value.length; i++)
	    {
	         ch = frm.str_userid.value.substr(i, 1) // i번째 위치의 1 char를 return
			 if (numMem.indexOf(ch) == -1) // numMem에서 ch값이 몇번째에 위치하는지 
	         {
	              return true;
	    	 }
		}
		return false;
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