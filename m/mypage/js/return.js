	function Click_Change(str_no) {
		var sTemp = fuc_ajax('return_proc.php?RetrieveFlag=LOG');

		if (sTemp == "0") {
			alert("로그인이 필요합니다.");
		}
		
		if (ValidChk()==false) return;

		if(!confirm("교환확정 하시겠습니까?")) return;
		
		document.frm.RetrieveFlag.value="EXCHANGE";

		document.frm.target = "_self";
		document.frm.action = "return_proc.php";
		document.frm.submit();	
	
	}
	
	function Click_Return(str_no) {
		var sTemp = fuc_ajax('return_proc.php?RetrieveFlag=LOG');

		if (sTemp == "0") {
			alert("로그인이 필요합니다.");
		}
		
		if (ValidChk()==false) return;

		if(!confirm("반납확정 하시겠습니까?")) return;
		
		document.frm.RetrieveFlag.value="EXRETURN";

		document.frm.target = "_self";
		document.frm.action = "return_proc.php";
		document.frm.submit();	
	
	}
	
	function ValidChk()	{
		var f = document.frm;
		if(chkSpace(f.str_addr1.value)){
	       	alert("\n주소가 입력되지 않았습니다");
	       	f.str_addr1.focus();
	        return false;
	   	}
		if(chkSpace(f.str_addr2.value)){
	       	alert("\n주소가 입력되지 않았습니다");
	       	f.str_addr2.focus();
	        return false;
	   	}
		if(f.str_method[0].checked==false&&f.str_method[1].checked==false&&f.str_method[2].checked==false){
	       	alert("\n반납방법이 선택되지 않았습니다");
	       	f.str_method[0].focus();
	        return false;
	   	}
		if(f.str_rdate.selectedIndex==0){
	       	alert("\n반납 날짜/시간이 선택되지 않았습니다");
	       	f.str_rdate.focus();
	        return false;
	   	}
		if(f.str_agree.checked==false){
	       	alert("\n주문 확인 여부를 체크하셔야 합니다.");
	       	f.str_agree.focus();
	        return false;
	   	}
		return true;
	}