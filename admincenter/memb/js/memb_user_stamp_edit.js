	function Save_Click() {
		if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value="INSERT"
		}
		document.frm.target = "_self";
		document.frm.action = "memb_user_stamp_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		if(chkSpace(f.int_stamp.value)){
	       	alert("\n사용스템프수가 입력되지 않았습니다");
	       	f.int_stamp.focus();
	        return false;
	   	}
		return true;
	}

