	function Save_Click() {
		if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;		
			document.frm.RetrieveFlag.value="INSERT"
		}
		document.frm.action = "boad_board_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		if(chkSpace(f.conf_bd_path.value)){  
	       	alert("\n게시판URL이 입력되지 않았습니다");
	   		f.conf_bd_path.focus(); 
	        return false;
	   	}
		if(chkSpace(f.conf_title.value)){  
	       	alert("\n게시판명칭이 입력되지 않았습니다");
	   		f.conf_title.focus(); 
	        return false;
	   	}
		if(chkSpace(f.conf_width.value)){  
	        alert("\n게시판너비이 입력되지 않았습니다");
	        f.conf_width.focus(); 
	        return false;
		}
		if(chkSpace(f.conf_att_url.value)){  
	        alert("\n첨부파일경로이 입력되지 않았습니다");
	        f.conf_att_url.focus(); 
	        return false;
	    }
		if(chkSpace(f.conf_limit_size.value)){  
	        alert("\n파일제한용량이 입력되지 않았습니다");
	        f.conf_limit_size.focus(); 
	        return false;
		}

		return true;		
	}
	
