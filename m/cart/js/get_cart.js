	function Save_Click() {
		if (ValidChk()==false) return;

		if(!confirm("GET 확정 하시겠습니까?")) return;
		document.frm.RetrieveFlag.value="UPDATE";

		document.frm.target = "_self";
		document.frm.action = "get_cart_proc.php";
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
	   	//if (getRadioValue(f.str_place1) == '') {
	   	if((f.str_place1[0].checked==false)&&(f.str_place1[1].checked==false)){
	       	alert("\n경비실 유무가 선택되지 않았습니다");
	       	//f.str_place1[0].focus();
	        return false;
	   	}
		if(f.str_place2[0].checked==false&&f.str_place2[1].checked==false){
	       	alert("\n무인택배함 유무가 선택되지 않았습니다");
	       	//f.str_place2[0].focus();
	        return false;
	   	}
		if(f.str_agree.checked==false){
	       	alert("\n주문 확인 여부를 체크하셔야 합니다.");
	       	//f.str_agree.focus();
	        return false;
	   	}
		return true;
	}