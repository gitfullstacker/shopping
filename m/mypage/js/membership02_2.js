	function Save_Click() {
		if (ValidChk()==false) return;

		document.frm.target = "_self";
		document.frm.RetrieveFlag.value = "ESC";
		document.frm.action = "membership02_2_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		// 아이디, 비밀번호 입력체크, 이름, 주민번호, 전화번호
		var f = document.frm;

	    if (getRadioValue(document.frm.int_esce) == '') {
	    	alert('사유를 하나만 선택해 주세요.');
	    	document.frm.int_esce[0].focus();
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

