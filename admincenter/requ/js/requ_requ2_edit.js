	function Save_Click() {
		//if (ValidChk()==false) return;
		document.frm.RetrieveFlag.value ="UPDATE";
		
		document.frm.target = "_self";
		document.frm.action = "requ_requ2_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		

	   	
		return true;
	}
	
	function Cal_Click() {
		if (ValidChk2()==false) return;
		
		var f = document.frm; 

		sTemp = fuc_ajax('requ_requ2_edit_proc.php?RetrieveFlag=CAL&str_sdate='+f.str_sdate.value+'&str_edate='+f.str_edate.value+'&int_price='+f.int_price.value+'&int_rate='+f.int_rate.value);
		alert(sTemp);
	}
	
	function ValidChk2()	{
		var f = document.frm; 
		
		if(chkSpace(f.str_sdate.value)){
	       	alert("\n대출기간이 입력되지 않았습니다");
	       	f.str_sdate.focus();
	        return false;
	   	}
		if(chkSpace(f.str_edate.value)){
	       	alert("\n대출기간이 입력되지 않았습니다");
	       	f.str_edate.focus();
	        return false;
	   	}
		if(chkSpace(f.int_price.value)){
	       	alert("\n대출금액이 입력되지 않았습니다");
	       	f.int_price.focus();
	        return false;
	   	}
		if(chkSpace(f.int_rate.value)){
	       	alert("\n대출이율이 입력되지 않았습니다");
	       	f.int_rate.focus();
	        return false;
	   	}
		return true;
	}