	function RowClick(str_no) {
		document.frm.str_no.value = str_no;
		document.frm.RetrieveFlag.value="UPDATE";
		document.frm.action = "cate_larg_edit.php"
		document.frm.submit();
	}
	function AddNew() {
		document.frm.RetrieveFlag.value="INSERT";
		document.frm.action = "cate_larg_edit.php";
		document.frm.submit();
	}
	function fnc_search() {
		document.frm.page.value=1;
		document.frm.action = "cate_larg_list.php";
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
	       		document.frm.encoding="multipart/form-data";
				document.frm.action = "cate_larg_edit_proc.php";
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


	function fnc_sort(str_goodcode,Txt_bcode,int_sort,str_way) {
		fnc_Iframe()
		lbl_Iframe.window.location.href="cate_larg_list_proc.php?str_goodcode="+str_goodcode+"&Txt_bcode="+Txt_bcode+"&int_sort="+int_sort+"&RetrieveFlag="+str_way;
		//window.location.href="cate_larg_list_proc.php?str_goodcode="+str_goodcode+"&Txt_bcode="+Txt_bcode+"&int_sort="+int_sort+"&RetrieveFlag="+str_way;
	}


	function fnc_Iframe() {
		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';
	}

	function Sort_Click() {
		if (frm.txtRows.value==0) {
			alert("데이터가 존재하지 않습니다.");
			return;
		} else {

			var rowCnt = parseInt(document.getElementsByName('chkItem2[]').length);
		  	var count =0;

			if (rowCnt >1){
	  			for (var i=0;i<rowCnt;i++) {
	  				if (document.getElementsByName('int_sort[]')[i].value=="") {
	  					alert("소트키가 등록되지 않았습니다.");
	  					document.getElementsByName('int_sort[]')[i].focus();
	  					return;
	  				}
	  			}
		  	}else {
	  			if (document.getElementsByName('int_sort[]')[0].value=="") {
  					alert("소트키가 등록되지 않았습니다.");
  					document.getElementsByName('int_sort[]')[0].focus();
  					return;
	  			}
			}

			//fnc_Iframe()
			//document.frm.target="lbl_Iframe";
       		document.frm.encoding="multipart/form-data";
			document.frm.action = "cate_larg_edit_proc.php";
			document.frm.RetrieveFlag.value="SORT";
			document.frm.submit();

		}
	}
	