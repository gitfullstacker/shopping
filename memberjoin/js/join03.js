	function Save_Click() {
		if (ValidChk()==false) return;
		document.frm.target = "_self";
		document.frm.RetrieveFlag.value = "INSERT";
		document.frm.action = "join03_proc.php";
		document.frm.submit();
	}

	function ValidChk()	{
		// 아이디, 비밀번호 입력체크, 이름, 주민번호, 전화번호
		var f = document.frm;

		if(chkSpace(f.str_name.value)){
        	alert("\n이름을 입력해 주세요..");
            f.str_name.focus();
            return false;
	    }
	    if(str_name_check()==false) {
            f.str_name.focus();
        	return false;
		}
		if(chkSpace(document.getElementById("str_userid").value)){
        	alert("\n아이디를 입력해 주세요..");
            f.str_userid.focus();
            return false;
	   	}
	   	 if(str_userid_check()==false) {
            f.str_userid.focus();
        	return false;
		}
	   	if(document.getElementById("str_userid_chk").value=="0"){
	       	alert("\n아이디가 조건에 맞지 않습니다.");
	        return false;
	   	}
		if(chkSpace(f.str_passwd1.value)){
        	alert("\n패스워드를 입력해 주세요..");
            f.str_passwd1.focus();
            return false;
		}
		if(isnum(frm.str_passwd1.value)) {
			alert("\n패스워드는 영문과 혼용하셔야 합니다.");
			return false;
		}
		if(chkSpace(f.str_passwd2.value)){
        	alert("\n패스워드를 입력해 주세요..");
            f.str_passwd2.focus();
            return false;
	    }
	    if(str_passwd_check()==false) {
            f.str_passwd1.focus();
        	return false;
		}
		/*
		if(f.str_hp1.selectedIndex==0){
	   		alert("\n휴대폰을 선택해 주세요..");
	        f.str_hp1.focus();
	        return false;
	    }
	    */
		if(chkSpace(f.str_hp1.value)){
	   		alert("\n휴대폰을 입력해 주세요..");
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
		/*
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
		*/


	}

	function str_userid_check() {
		if ( _valid_length_check(1) ) return false;
	    	if ( _is_hangle() ) {
	    		alert("\n한글은 사용하실수 없습니다.");
			return false;
		}
		if(isnum(document.getElementById("str_userid").value)) {
			alert("\n아이디는 영문과 혼용하셔야 합니다.");
			return false;
		}
	        if (document.getElementById("str_userid").value.length<6 || document.getElementById("str_userid").value.length>12) {
	  	    	alert("아이디는 6-12자 입니다.");
	  	    	return false;
	  	}
		return true;
	}
	
	function str_userid_check2() {
		if ( _valid_length_check(1) ) return false;
	    	if ( _is_hangle() ) {
	    	fuc_set('join03_proc.php?RetrieveFlag=IDCHECK&str_userid=','_Proc');
			return;
		}
		if(isnum(document.getElementById("str_userid").value)) {
			fuc_set('join03_proc.php?RetrieveFlag=IDCHECK&str_userid=','_Proc');
			return;
		}
        if (document.getElementById("str_userid").value.length<6 || document.getElementById("str_userid").value.length>12) {
        	fuc_set('join03_proc.php?RetrieveFlag=IDCHECK&str_userid=','_Proc');
  	    	return;
	  	}
		fuc_set('join03_proc.php?RetrieveFlag=IDCHECK&str_userid='+document.getElementById("str_userid").value,'_Proc');
		
	}

	// 비밀번호
	function str_passwd_check()
	{
	    //valid check
		if ( document.frm.str_passwd1.value.length <= 0 )
		{
			alert("\n패스워드를 입력하세요.");
			return false;
		}
		if ( document.frm.str_passwd2.value.length <= 0 )
		{
			alert("\n패스워드를 한번 더 입력하세요.");
			document.frm.str_passwd2.value="";
			return false;
		}

	    	if( document.frm.str_passwd1.value != document.frm.str_passwd2.value)
		{
			alert("\n패스워드를 정확히 입력하세요.");
			document.frm.str_passwd1.value="";
			document.frm.str_passwd2.value="";
			return false;
		}

		if ( _valid_length_check(2) ) return false;
		return true;
	}

	function str_name_check() {
	   	if ( _valid_value_check() )    return false;
		if (! isKorean(document.frm.str_name)) {
			alert("\n이름은 한글만 입력하세요.");
			frm.str_name.value="";
	        	return false;
		}
		return true;
	}

	function str_email_check() {
	   	if(!isValidEmail(document.frm.str_email1.value+"@"+document.frm.str_email2.value)){
	   		alert("\n정확한 이메일 주소를 입력하세요.");
			document.frm.str_email1.value="";
			return false;
		}
		return true;
	}


	function _valid_length_check(opt) {
		if ( opt == 1 || opt == 0 ) {
	        //==============영문, 한글 byle수 계산 logic=====================
			str = document.getElementById("str_userid").value;
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
		  	    	alert("패스워드는 4-12 byte 입니다.");
		  	    	return 1;
		  	}
		}
		return 0;
	}

	function LowChk(str) {
		if (str.length > 0) {
			frm.str_userid.value = str.toLowerCase()
		}
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

	function _valid_value_check() {
	    	str = document.frm.str_name.value;
		var strbyte = 0;
		for (i = 0; i < str.length; i++) {
			var code = str.charCodeAt(i);
			var ch   = str.substr(i,1).toUpperCase();
			code     = parseInt(code);
			if ( code >= 0 && code  <= 47 ) {
				document.frm.str_name.value="";
				alert("특수문자는 사용하실 수 없습니다.");
				return 1;
			}
		}
		return 0;
	}

	// 입력값이 한글로 되어있는지 체크 (추가)
	function isKorean(input) {
		for(i=0; i<input.value.length; i++){
			var CodeNum = input.value.charCodeAt(i);
			if (CodeNum < 128){
				flag = false;
			} else {
				//alert("한글 아님");
				flag = true;
			}
		}
		return flag;
	}

	function _is_hangle() {
	    var numMem = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	    var ch;
	    for (var i=0; i < document.getElementById("str_userid").value.length; i++)
	    {
	         ch = document.getElementById("str_userid").value.substr(i, 1) // i번째 위치의 1 char를 return
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

	function fnc_semail1(str_value) {
		if (str_value == "") {
			document.frm.str_email2.value = "";
		} else {
			document.frm.str_email2.value = str_value;
		}
	}

	function fnc_semail2(str_value) {
		if (str_value == "") {
			document.frm.str_email4.value = "";
		} else {
			document.frm.str_email4.value = str_value;
		}
	}

	function fnc_idcheck() {
		if ( _valid_length_check(1) ) return false;
	    	if ( _is_hangle() ) {
	    		alert("\n한글은 사용하실수 없습니다.");
	    		frm.str_userid.value = '';
				return false;
		}
	}

	function fnc_idchk(str_gubun) {

		if(str_gubun == '1') {
			if(chkSpace(frm.str_userid.value)){
		       	alert("\n아이디가 입력되지 않았습니다");
		   		frm.str_userid.focus();
		        return;
		   	}
	        if (document.frm.str_userid.value.length<4 || document.frm.str_userid.value.length>12) {
	  	    	alert("아이디는 4-12자 입니다.");
	  	    	frm.str_userid.focus();
	  	    	return;
	  		}
			if(isnum(frm.str_userid.value)) {
				alert("\n아이디는 영문과 혼용하셔야 합니다.");
				frm.str_userid.focus();
				return;
			}
			fuc_set('join_write_proc.php?RetrieveFlag=IDCHECK&str_userid='+frm.str_userid.value,'_Proc');
		} else {
			fuc_set('join_write_proc.php?RetrieveFlag=IDCHECK&str_userid=','_Proc');
		}
	}
	function fnc_cen() {
		var f = document.frm;
		if(f.int_gubun[1].checked) {
			document.getElementById("cen").style.display = "";
		} else {
			document.getElementById("cen").style.display = "none";
		}
	}