	function Save_Click() {
		//if (ValidChk()==false) return;
		document.frm.RetrieveFlag.value ="UPDATE";
		
		document.frm.target = "_self";
		document.frm.action = "requ_requ_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		

	   	
		return true;
	}