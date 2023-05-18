	function Save_Click() {
		if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value="INSERT"
		}
		// oEditors.getById["str_contents"].exec("UPDATE_CONTENTS_FIELD", []);
		document.frm.target = "_self";
		document.frm.action = "good_master_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		/*
		if(chkSpace(f.str_bcode.value)){
	       	alert("\n카테고리가 선택되지 않았습니다");
	        return false;
	   	}
	   	*/
		if(chkSpace(f.str_goodname.value)){
	       	alert("\n상품명이 입력되지 않았습니다");
	       	f.str_goodname.focus();
	        return false;
	   	}
		return true;
	}
	
	function fnc_addprod(str_no) {
		fuc_ajax('good_master_edit_proc.php?RetrieveFlag=PINSERT&str_no='+str_no);
		fuc_set('good_master_edit_proc.php?RetrieveFlag=PRODCODE&str_no='+str_no,'_Prodcode');
		table_design_load();
	}
	function fnc_delprod(str_no,str_sgoodcode) {
		if(!confirm("삭제 하시겠습니까?")) return;
		
		fuc_ajax('good_master_edit_proc.php?RetrieveFlag=PDELETE&str_no='+str_no+'&str_sgoodcode='+str_sgoodcode);
		fuc_set('good_master_edit_proc.php?RetrieveFlag=PRODCODE&str_no='+str_no,'_Prodcode');	
		table_design_load();
	}
	function fnc_sservice(str_no,str_sgoodcode,str_sservice) {
		fuc_ajax('good_master_edit_proc.php?RetrieveFlag=PUPDATE&str_no='+str_no+'&str_sgoodcode='+str_sgoodcode+'&str_sservice='+str_sservice);
		fuc_set('good_master_edit_proc.php?RetrieveFlag=PRODCODE&str_no='+str_no,'_Prodcode');	
		table_design_load();
		alert("수정되었습니다.");
	}
	
	function Fnc_Esecpe() {
		if (frm.txtRows3.value!=0) {
			var chkObj1  = document.frm.str_value;
			var chkObj2  = document.frm.str_gubun3;

			if (frm.txtRows3.value==1) {
				if (chkObj2.checked) {
					//chkObj1.value = "";
					document.getElementsByName('str_value[]')[0].disabled  = false;
				}else{
					//chkObj1.value = escape(chkObj1.value);
					//chkObj1.value=chkObj1.value;
					//chkObj1.disabled  = true;
					document.getElementsByName('str_value[]')[0].disabled  = true;
				}
			}  else {

				for (var i=0;i<chkObj1.length;i++) {
					if (document.getElementsByName('str_gubun3[]')[i].checked) {
						//chkObj1[i].value = "";
						document.getElementsByName('str_value[]')[i].disabled  = false;
					}else{
						//chkObj1[i].value = chkObj1[i].value;
						document.getElementsByName('str_value[]')[i].disabled  = true;
					}
				}
			}

		}
	}

	function addRow() {
	  	var oRow = dyntbl1.insertRow();
	  	oRow.onmouseover=function(){dyntbl1.clickedRowIndex=this.rowIndex};
	  	var oCell1 = oRow.insertCell();
	  	oCell1.innerHTML = "<input type=file name=str_sImage1[] style='width:200;' onChange='uploadImageCheck(this)'> 제목 : <input type=text name=str_title[] style='width:250px;'> <img src=/admincenter/img/i_del.gif style=cursor:hand onClick=\"delRow()\">";
	  	document.recalc();
	}
	function delRow() {
	  	dyntbl1.deleteRow(dyntbl1.clickedRowIndex);
	}
	function fnc_Iframe() {
		obj_Lbl.innerHTML = '<iframe name="lbl_Iframe" id="lbl_Iframe_Id" src="about:blank" width="0" height="0" frameborder="0" scrolling="no"></iframe>';
	}

	function fnc_fdelete(str_no,str_fno) {
		fnc_Iframe()
		lbl_Iframe.window.location.href="good_master_edit_proc.php?RetrieveFlag=FDELETE&str_no="+str_no+"&str_fno="+str_fno;
	}
	
	
	function addRow2() {
	  	var oRow = dyntbl2.insertRow();
	  	oRow.onmouseover=function(){dyntbl2.clickedRowIndex=this.rowIndex};
	  	var oCell2 = oRow.insertCell();
	  	oCell2.innerHTML = "<input type=file name=str_Image2[] style='width:200;' onChange='uploadImageCheck(this)'> <img src=/admincenter/img/i_del.gif style=cursor:hand onClick=\"delRow2()\">";
	  	document.recalc();
	}
	function delRow2() {
	  	dyntbl2.deleteRow(dyntbl2.clickedRowIndex);
	}
	function fnc_fdelete2(str_no,str_fno) {
		fnc_Iframe()
		lbl_Iframe.window.location.href="good_master_edit_proc.php?RetrieveFlag=FDELETE2&str_no="+str_no+"&str_fno="+str_fno;
	}
	function fnc_usercode(str_sgoodcode,obj) {
		fuc_ajax('good_master_edit_proc.php?RetrieveFlag=USERCODE&str_sgoodcode='+str_sgoodcode+'&str_usercode='+encodeURIComponent(document.getElementById(obj).value));
		alert("수정되었습니다.");
	}