	function fnc_search() {
		document.frm.page.value=1;
		document.frm.target = "_self";
		document.frm.action = "sms_process_list.php";
		document.frm.submit();
	}
	function Adelete_Click() {
		if (frm.txtRows.value==0) {
			alert("데이터가 존재하지 않습니다.");	
			return;
		} else {
		  	var chkObj  = document.frm.chkItem1
		  	var count =0;
		
		   	if (chkObj.checked) {
		   		count++;   
		  	}
		  	else for (var i=0;i<chkObj.length;i++) if (chkObj[i].checked) count++;
		  		if (!count) {
					alert("데이타를 선택하지 않았습니다.");
		            return;
		       	}else{
		       		if (!confirm("한번 삭제한 데이터는 복구할 수 없습니다.\n정말로 삭제하시겠습니까?")) return
					document.frm.target = "_self";
					document.frm.action = "sms_process_edit_proc.php";
					document.frm.RetrieveFlag.value="ADELETE";
					document.frm.submit();
		 	}
		}
	}
	function selectItem(str_gubun) {
		if (frm.txtRows.value==0) {
			alert("\n데이터가 존재하지 않습니다.");	
			return;
		} else {
			var rowCnt = parseInt(document.frm.chkItem1.length);
			 if (rowCnt >1){
			 	if (str_gubun == '1') {
	  				for (var i=0;i<rowCnt;i++)	document.frm.chkItem1[i].checked = true;
	  			} else {
	  				for (var i=0;i<rowCnt;i++)	document.frm.chkItem1[i].checked = false;
	  			}
		  	}else {
		  		if (str_gubun == '1') {
		  			document.frm.chkItem1.checked = true;
	  			} else {
	  				document.frm.chkItem1.checked = false;
	  			}		  		
			}
		}	  	
	}
	
	function fnc_Read_Cont(str_url, str_view) {

		fuc_set(str_url,str_view);

		var lbl_Layer = eval("lbl_Pwd");
		var int_Y = event.clientY;
		var int_X = event.clientX;

		lbl_Layer.style.top=int_Y+document.body.scrollTop;
		lbl_Layer.style.left=int_X+document.body.scrollLeft-300 ;
		lbl_Layer.style.visibility="visible";

	}
	
	function fnc_sendAmail() {
		
		if (document.frm.str_mailcode.value=="") {
				alert("발송할 문자컨텐츠를 선택하지 않습니다.");	
				return;		
		}
		
		if (document.frm.str_mailtype.value=="1") {
			if (frm.txtRows.value==0) {
				alert("고객이 존재하지 않습니다.");	
				return;
			} else {
			  	var chkObj  = document.frm.chkItem1;
			  	var count =0;
			
			   	if (chkObj.checked) {
			   		count++;   
			  	}
			  	else for (var i=0;i<chkObj.length;i++) if (chkObj[i].checked) count++;
			  		if (!count) {
						alert("고객을 선택하지 않았습니다.");
			            return;
			  	 	}
			}
		} else {
			if (frm.txtRows.value==0) {
				alert("고객이 존재하지 않습니다.");	
				return;
			}
		}
		fnc_Iframe()
		document.frm.target = "lbl_Iframe";
		document.frm.RetrieveFlag.value="SMAIL";
		document.frm.action = "sms_process_edit_proc.php";
		document.frm.submit();		
	}
	
	
	function fnc_Iframe() {
		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="100%" height="1000" frameborder="0" scrolling="no"></iframe>';
	}

	function fnc_sendDelete() {
		fnc_Iframe()
		document.frm.target = "lbl_Iframe";
		document.frm.RetrieveFlag.value="ADEL";
		document.frm.action = "sms_process_edit_proc.php";
		document.frm.submit();			
	}