function fnc_Iframe() {
	obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';
}

function ValidChk(gbn) {

	var f = document.frm;

	if (gbn == "1") {
		if (chkSpace(f.str_name.value)) {
			alert("\n이름을 입력해 주세요.");
			f.str_name.focus();
			return false;
		}
	} else {
		if (chkSpace(f.str_userid.value)) {
			alert("\n아이디를 입력해 주세요.");
			f.str_userid.focus();
			return false;
		}
		if (chkSpace(f.str_rname.value)) {
			alert("\n이름을 입력해 주세요.");
			f.str_rname.focus();
			return false;
		}
	}

}

// 입력값이 NULL 인지 체크
function chkSpace(strValue) {
	var flag = true;
	if (strValue != "") {
		for (var i = 0; i < strValue.length; i++) {
			if (strValue.charAt(i) != " ") {
				flag = false;
				break;
			}
		}
	}
	return flag;
}

function verifyPhone(gbn) {
	if (ValidChk(gbn) == false) return;
	fnPopup(gbn);
}

function fnPopup(gbn) {
	var enc_data = document.form_chk.EncodeData.value;
	var gubun = '';
	switch (gbn) {
		case '1':
			gubun = 'IDCHECK';
			break;
		case '2':
			gubun = 'PWCHECK';
			break;
	}
	window.open('nice.php?enc_data=' + enc_data + '&gubun=' + gubun, 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
}

function setVerifyPhoneNumber(phoneNumber, birthday) {
	var phone_array = phoneNumber.split("-");
	console.log(phoneNumber)
	$('#str_hp1').val(phone_array[0]);
	$('#str_hp2').val(phone_array[1]);
	$('#str_hp3').val(phone_array[2]);

	document.frm.gbn.value = gbn;
	if (gbn == "1") {
		document.frm.RetrieveFlag.value = "IDCHECK";
	} else {
		document.frm.RetrieveFlag.value = "PWCHECK";
	}
	document.frm.action = "idpw_search_proc.php";
	document.frm.submit();
}