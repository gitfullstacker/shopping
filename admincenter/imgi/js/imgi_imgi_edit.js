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
		document.frm.action = "imgi_imgi_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		if(f.RetrieveFlag.value=="INSERT") {
			if(chkSpace(f.str_Image1.value)){
		       	alert("\n이미지가 선택되지 않았습니다");
		       	f.str_Image1.focus();
		        return false;
		   	}
		}
		return true;
	}
