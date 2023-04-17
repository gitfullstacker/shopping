	function Save_Click() {
		if (ValidChk()==false) return;
		if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;
		document.frm.RetrieveFlag.value="INSERT"
		document.frm.target = "_self";
		document.frm.action = "good_option_name_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		if(chkSpace(f.str_oname.value)){
	       	alert("\n옵션명이 입력되지 않았습니다");
	   		f.str_oname.focus();
	        return false;
	   	}
		return true;
	}

	function Delete_Click(int_number) {

   		if (!confirm("한번 삭제한 데이터는 복구할 수 없습니다.\n정말로 삭제하시겠습니까?")) return
   		document.frm.str_no.value = int_number;
		document.frm.action = "good_option_name_proc.php";
		document.frm.RetrieveFlag.value="DELETE";
		document.frm.submit();

	}