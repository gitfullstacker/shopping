	function CheckValue1() {
		if (document.frm.str_userid.value=="") {
			alert('사용자 아이디를 입력해 주십시오!');
			document.frm.str_userid.focus();
			return false;
		}else if (chkSpace(document.frm.str_userid.value)){
			alert('사용자 아이디를 입력해 주십시오!');
			document.frm.str_userid.focus();
			return false;
		}else if (document.frm.str_passwd.value=="") {
			alert("비밀번호를 입력하세요");
			document.frm.str_passwd.focus();
			return false;
		}else if (chkSpace(document.frm.str_passwd.value)){
			alert("비밀번호를 입력하세요");
			document.frm.str_passwd.focus();
			return false;
		}
		return true;
	}
	function CheckValue2() {
		if (chkSpace(document.frm2.str_name.value)){
			alert('이름 입력해 주십시오!');
			document.frm2.str_name.focus();
			return false;
		}else if (chkSpace(document.frm2.str_email.value)){
			alert("이메일을 입력하세요");
			document.frm2.str_email.focus();
			return false;
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

