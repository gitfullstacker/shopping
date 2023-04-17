	function Save_Click() {
		if (ValidChk()==false) return;
		
		if(!confirm("배송지를 저장하시겠습니까?")) return;		
		document.frm.RetrieveFlag.value="UPDATE";

		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';
		document.frm.target = "lbl_Iframe";
		document.frm.action = "membership02_proc.php";
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
	
