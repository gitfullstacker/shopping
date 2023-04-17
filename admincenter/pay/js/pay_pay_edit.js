	function Save_Click() {
		//if (ValidChk()==false) return;

		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value="INSERT"
		}

		document.frm.target = "_self";
		document.frm.action = "pay_pay_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		if(chkSpace(f.str_bcode.value)){
	       	alert("\n카테고리가 선택되지 않았습니다");
	       	//f.str_bcode.focus();
	        return false;
	   	}
		if(chkSpace(f.str_goodname.value)){
	       	alert("\n상품명이 입력되지 않았습니다");
	       	f.str_goodname.focus();
	        return false;
	   	}
		return true;
	}