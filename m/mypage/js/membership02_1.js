	function Save_Click() {
		if (ValidChk()==false) return;
		
		if(!confirm("배송지를 저장하시겠습니까?")) return;		
		document.frm.RetrieveFlag.value="UPDATE";

		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';
		document.frm.target = "lbl_Iframe";
		document.frm.action = "membership02_1_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		if(chkSpace(f.str_saddr1.value)){  
	       	alert("\n배송지가 입력되지 않았습니다");
	       	f.str_saddr1.focus();
	        return false;
	   	}
		if(chkSpace(f.str_saddr2.value)){  
	       	alert("\n배송지가 입력되지 않았습니다");
	       	f.str_saddr2.focus();
	        return false;
	   	}
		if(f.str_splace1[0].checked==false&&f.str_splace1[1].checked==false){  
	       	alert("\n경비실 보관장소 유무가 선택되지 않았습니다");
	       	f.str_splace1[0].focus();
	        return false;
	   	}
		if(f.str_splace2[0].checked==false&&f.str_splace2[1].checked==false){  
	       	alert("\n무인택배함 유무가 선택되지 않았습니다");
	       	f.str_splace2[0].focus();
	        return false;
	   	}
		return true;		
	}
	
	function MovePage4(PageNo2) {
		frm.page.value = PageNo2;
		document.frm.action = "membership02_1.php";
		document.frm.target = "_self";
		document.frm.submit();
	}
	
	function fnc_es(str_no) {
	
		if(!confirm("취소 신청을 하시겠습니까?")) return;
	
		document.frm.RetrieveFlag.value="ES1";
		document.frm.str_no.value=str_no;

		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';
		document.frm.target = "lbl_Iframe";
		document.frm.action = "membership02_1_proc.php";
		document.frm.submit();
	
	}
	
	function fnc_mse(str_no) {
	
		if(!confirm("정기권 해지 신청을 하시면 \n이용중인 가방은 만료일까지 사용가능하며 \n반납신청은 별도로 해주셔야합니다. \n지금 해지하시겠습니까?")) return;
	
		window.location.href = "membership02_2.php?str_no="+str_no;
	
	}
	
	function fnc_cancel(str_no) {
	
		if(!confirm("해지 신청중인 것을 취소 하시겠습니까?")) return;
	
		window.location.href = "membership02_2_proc.php?RetrieveFlag=CESC&str_no="+str_no;
	
	}
	
	function fnc_mpay() {
	
		if(!confirm("지금 정기권으로 연장 신청하시면 \n기존 1개월권 멤버십 종료일부터 매월 \n10% 할인된 89,000원이 정기결제 됩니다.")) return;
		window.location.href = "membership01.php?int_gubun=1";
		
	}