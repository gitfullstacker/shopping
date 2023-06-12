	function CheckValue(gbn) {
		if (ValidChk(gbn)==false) return;
		// fnc_Iframe();
		// document.frm.target = "lbl_Iframe";
		document.frm.gbn.value = gbn;
		if (gbn=="1") {
			document.frm.RetrieveFlag.value = "IDCHECK";
		}else{
			document.frm.RetrieveFlag.value = "PWCHECK";
		}
		document.frm.action = "idpw_search_proc.php";
		document.frm.submit();
	}
	function fnc_Iframe() {
		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';
	}

	function ValidChk(gbn)	{

		var f = document.frm;
		
		if (gbn=="1") {

			if(chkSpace(f.str_name.value)){
				alert("\n이름을 입력해 주세요.");
		        f.str_name.focus();
		        return false;
		    }
			if(f.str_hp1.selectedIndex==0){
				alert("\n휴대폰번호를 선택해 주세요.");
		        f.str_hp1.focus();
		        return false;
		    }
			if(chkSpace(f.str_hp2.value)){
				alert("\n휴대폰번호를 입력해 주세요.");
		        f.str_hp2.focus();
		        return false;
		    }
			if(chkSpace(f.str_hp3.value)){
				alert("\n휴대폰번호를 입력해 주세요.");
		        f.str_hp3.focus();
		        return false;
		    }
		
		} else {

			if(chkSpace(f.str_userid.value)){
				alert("\n아이디를 입력해 주세요.");
		        f.str_userid.focus();
		        return false;
		    }		
			if(chkSpace(f.str_rname.value)){
				alert("\n이름을 입력해 주세요.");
		        f.str_rname.focus();
		        return false;
		    }
			if(f.str_rhp1.selectedIndex==0){
				alert("\n휴대폰번호를 선택해 주세요.");
		        f.str_rhp1.focus();
		        return false;
		    }
			if(chkSpace(f.str_rhp2.value)){
				alert("\n휴대폰번호를 입력해 주세요.");
		        f.str_rhp2.focus();
		        return false;
		    }
			if(chkSpace(f.str_rhp3.value)){
				alert("\n휴대폰번호를 입력해 주세요.");
		        f.str_rhp3.focus();
		        return false;
		    }
		
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
