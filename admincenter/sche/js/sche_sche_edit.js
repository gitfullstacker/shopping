	function Save_Click() {
		if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value="INSERT"
		}
		oEditors.getById["str_contents"].exec("UPDATE_CONTENTS_FIELD", []);
		document.frm.target = "_self";
		document.frm.action = "sche_sche_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		if(chkSpace(f.str_date.value)){
	       	alert("\n일자가 선택되지 않았습니다");
	       	f.str_date.focus();
	        return false;
	   	}
		if(f.str_time1.selectedIndex==0){
	       	alert("\n시간이 선택되지 않았습니다");
	       	f.str_time1.focus();
	        return false;
	   	}
		if(f.str_time2.selectedIndex==0){
	       	alert("\n시간이 선택되지 않았습니다");
	       	f.str_time2.focus();
	        return false;
	   	}
		if(chkSpace(f.str_title.value)){
	       	alert("\n제목이 입력되지 않았습니다");
	       	f.str_title.focus();
	        return false;
	   	}
		   	iCnt = $('input[name="str_source[]"]').length;
			if(iCnt>0){
				for(i=1; i<iCnt; i++) {
				
					obj = $('input[name="str_source[]"]').eq(i);
					if(chkSpace(obj.val())){
				       	alert("\n출처가 입력되지 않았습니다");
				   		obj.focus();
				        return false;
				   	}
		   	
		   		}
		   	}
		return true;
	}
	
	function fnc_del(int_number,int_fnumber) {
		if(!confirm("삭제 하시겠습니까?")) return;
		fuc_ajax('sche_sche_edit_proc.php?RetrieveFlag=FDELETE&str_no='+int_number+'&int_fnumber='+int_fnumber);
		fuc_set('sche_sche_edit_proc.php?RetrieveFlag=Load&&str_no='+int_number+'&int_fnumber='+int_fnumber,'_File');
		table_design_load();
	}

	