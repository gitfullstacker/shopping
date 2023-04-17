	function Save_Click() {
		if (ValidChk()==false) return;
		if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;		
		document.frm.RetrieveFlag.value="INSERT"
		document.frm.target = "_self";
		document.frm.action = "memb_point_list_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		if(chkSpace(f.int_point.value)){  
	       	alert("\n포인트가 입력되지 않았습니다");
	   		f.int_point.focus(); 
	        return false;
	   	}
		if(chkSpace(f.str_contents.value)){  
	       	alert("\n이유가 입력되지 않았습니다");
	   		f.str_contents.focus(); 
	        return false;
	   	}
		return true;		
	}
	
	function Delete_Click(int_number) {

   		if (!confirm("한번 삭제한 데이터는 복구할 수 없습니다.\n정말로 삭제하시겠습니까?")) return
   		document.frm.str_no.value = int_number;
		document.frm.action = "memb_point_list_proc.php";
		document.frm.RetrieveFlag.value="DELETE";
		document.frm.submit();

	}