function Save_Click() {
	if (ValidChk() == false) return;
	if (document.frm.RetrieveFlag.value != "INSERT") {
		if (!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
		document.frm.RetrieveFlag.value = "UPDATE";
	} else {
		if (!confirm("작성하신 데이터를 저장하시겠습니까?")) return;
		document.frm.RetrieveFlag.value = "INSERT"
	}

	document.frm.target = "_self";
	document.frm.action = "calendar_edit_proc.php";
	document.frm.submit();
}
function ValidChk() {
	var f = document.frm;
	if (chkSpace(f.str_title.value)) {
		alert("\n제목이 입력되지 않았습니다");
		f.str_title.focus();
		return false;
	}
	return true;
}

function handleType(int_type) {
	switch (int_type) {
		case '1':
			document.getElementById("str_day").style.display = "block";
			document.getElementById("str_date").style.display = "none";
			document.getElementById("str_week").style.display = "none";
			break;
		case '2':
			document.getElementById("str_day").style.display = "none";
			document.getElementById("str_date").style.display = "block";
			document.getElementById("str_week").style.display = "none";
			break;
		case '3':
			document.getElementById("str_day").style.display = "none";
			document.getElementById("str_date").style.display = "none";
			document.getElementById("str_week").style.display = "block";
			break;
	}
}