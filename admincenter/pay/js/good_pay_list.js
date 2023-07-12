	function RowClick(str_no, int_type) {
		popupLayer("good_pay_edit.php?RetrieveFlag=UPDATE&str_no="+str_no+"&int_type="+int_type,800,500);
	}
	function AddNew() {
		document.frm.RetrieveFlag.value="INSERT";
		document.frm.action = "good_pay_edit.php";
		document.frm.submit();
	}
	function fnc_search() {
		document.frm.page.value=1;
		document.frm.action = "good_pay_list.php";
		document.frm.submit();
	}
	function Adelete_Click() {

		if (frm.txtRows.value==0) {
			alert("데이터가 존재하지 않습니다.");
			return;
		} else {

			var rowCnt = parseInt(document.getElementsByName('chkItem1[]').length);
		  	var count =0;

			if (rowCnt >1){
	  				for (var i=0;i<rowCnt;i++) {
	  					if (document.getElementsByName('chkItem1[]')[i].checked) {
	  						count++;
	  					}
	  				}
		  	}else {
	  			if (document.getElementsByName('chkItem1[]')[0].checked) {
	  				count++;
	  			}
			}

	  		if (!count) {
				alert("데이타를 선택하지 않았습니다.");
				return;
	       	}else{
	       		if (!confirm("한번 삭제한 데이터는 복구할 수 없습니다.\n정말로 삭제하시겠습니까?")) return
				document.frm.action = "good_pay_edit_proc.php";
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

			var rowCnt = parseInt(document.getElementsByName('chkItem1[]').length);

			 if (rowCnt >1){
			 	if (str_gubun == '1') {
	  				for (var i=0;i<rowCnt;i++)	document.getElementsByName('chkItem1[]')[i].checked = true;
	  			} else {
	  				for (var i=0;i<rowCnt;i++)	document.getElementsByName('chkItem1[]')[i].checked = false;
	  			}
		  	}else {
		  		if (str_gubun == '1') {
		  			document.getElementsByName('chkItem1[]')[0].checked = true;
	  			} else {
	  				document.getElementsByName('chkItem1[]')[0].checked = false;
	  			}
			}
		}
	}

	function fnc_Excel() {
		
		if (document.frm.str_exceltype.value=="1") {
			if (frm.txtRows.value==0) {
				alert("회원이 존재하지 않습니다.");	
				return;
			} else {
			  	var chkObj  = document.frm.chkItem1
			  	var count =0;
			
			   	if (chkObj.checked) {
			   		count++;   
			  	}
			  	else for (var i=0;i<chkObj.length;i++) if (chkObj[i].checked) count++;
			  		if (!count) {
						alert("자료를 선택하지 않았습니다.");
			            return;
			  	 	}
			}
		} else {
			if (frm.txtRows.value==0) {
				alert("자료가 존재하지 않습니다.");	
				return;
			}
		}
		document.frm.RetrieveFlag.value="EXCEL";
		document.frm.action = "good_pay_excel.php";
		document.frm.submit();
	}


	function MovePageA(PageNo) {
		document.frm.target = "_self";
		document.frm.action = "good_pay_list.php";
		frm.page.value = PageNo;
		document.frm.target = "_self";
		document.frm.submit();
	}