	function Save_Click() {
		if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value="INSERT"
		}
		oEditors.getById["str_answer"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
		document.frm.action = "faq_faq_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		if(f.int_gubun.selectedIndex==0){
	       	alert("\n분류가 선택되지 않았습니다");
	   		f.int_gubun.focus();
	        return false;
	   	}
		if(chkSpace(f.str_quest.value)){
	       	alert("\n질문이 입력되지 않았습니다");
	   		f.str_quest.focus();
	        return false;
	   	}
		return true;
	}
