	function Save_Click() {
		if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value="INSERT"
		}
		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';

		document.frm.target = "lbl_Iframe";
		document.frm.action = "code_input_road_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		if(chkSpace(f.str_idxword.value)){
	       	alert("\n분류명이 입력되지 않았습니다");
	   		f.str_idxword.focus();
	        return false;
	   	}
	   	if(chkSpace(f.str_sort.value)){
			alert("\n메뉴순번이 입력되지 않았습니다");
     		frm.str_sort.focus();
     		return false;
  		}
  		/*
  		if(chkSpace(f.str_itemcode.value)==false){
	        if (f.str_itemcode.value.length<3) {
	  	    	alert("품목코드는 3자리 입니다.");
	  	    	frm.str_itemcode.focus();
	  	    	return false;
	  		}
	  		if (f.str_itemchk.value == 0) {
	  			alert("품목코드 중복확인을 하여주십시요.");
	  			return false;
	  		}
  		}
  		*/
		return true;
	}
	function Delete_Click(str_url) {
		if(!confirm("삭제 하시겠습니까?")) return;
		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';
		document.lbl_Iframe.location.href = str_url;
		//document.location.href = str_url;
	}
	function Fnc_Message(str) {
		alert(str);
	}

	function fnc_itemchk(str_gubun) {
		if(str_gubun == '1') {
	  		if(chkSpace(frm.str_itemcode.value)==false){
		        if (frm.str_itemcode.value.length<3) {
		  	    	alert("품목코드는 3자리 입니다.");
		  	    	frm.str_itemcode.focus();
		  	    	return;
		  		}
	  		}
			fuc_set('/admin/code/code_input_road_proc.asp?RetrieveFlag=ITEMCHECK&str_itemcode='+frm.str_itemcode.value,'_Proc');
		} else {
			fuc_set('/admin/code/code_input_road_proc.asp?RetrieveFlag=ITEMCHECK&str_itemcode=','_Proc');
		}
	}
