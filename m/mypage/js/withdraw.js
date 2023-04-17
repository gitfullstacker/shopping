	function Save_Click() {
		if (ValidChk()==false) return;

		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';

		document.frm.target = "lbl_Iframe";
		document.frm.RetrieveFlag.value = "ESC";
		document.frm.action = "withdraw_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		// 아이디, 비밀번호 입력체크, 이름, 주민번호, 전화번호
		var f = document.frm;

		if(chkSpace(f.str_passwd.value)){
	   		alert("\n비밀번호를 입력해 주세요..");
	        f.str_passwd.focus();
	        return false;
	    }
	    if (getRadioValue(document.frm.str_escecode) == '') {
	    	alert('탈퇴 사유를 하나만 선택해 주세요.');
	    	document.frm.str_escecode[0].focus();
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
	
	function getRadioValue(obj) {
			var len = obj.length;
			var result = "";
			if (!len && obj.checked) {
				result = obj.value;
			}
			for (var i=0, m=obj.length; i < m; i++ ) {
				if (obj[i].checked) {
						result = obj[i].value;
				}
			}
			return result;
	}

