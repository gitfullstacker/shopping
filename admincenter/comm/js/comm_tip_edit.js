	function Save_Click() {
		if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;		
			document.frm.RetrieveFlag.value="INSERT"
		}
		
		/* ++++++++++++++++ *\
			웹에디터 시작
		\* ++++++++++++++++ */
		var obj_Form = document.frm;
		var pr_Mtx = 'str_contents';
		var str_Send_Html = '';
		obj_Form.elements[pr_Mtx].wrap = "soft";

		/*var regStyle = new RegExp("(<STYLE>.*)(margin:0;)(.*<\/STYLE>)","gi");
		if(int_Edit_Mode==9)
		{
			str_Send_Html = fncConvText(html_Editor.document.documentElement.outerHTML, 1);
			str_Send_Html = (str_Send_Html.indexOf(strIframeHeader)>-1)? str_Send_Html: strIframeHeader+str_Send_Html;
			str_Send_Html = str_Send_Html.replace(regStyle, "$1$3");
			obj_Form.elements[pr_Mtx].innerText = str_Send_Html;
		}*/
		if(int_Edit_Mode==9)
		{
			str_Send_Html = fncConvText(html_Editor.document.documentElement.outerHTML, 1);
			obj_Form.elements[pr_Mtx].innerText = str_Send_Html;
		}
		/* ++++++++++++++++ *\
			웹에디터 종료
		\* ++++++++++++++++ */
		
		document.frm.target = "_self";
		document.frm.action = "comm_tip_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		if(chkSpace(f.str_title.value)){  
	       	alert("\n제목이 입력되지 않았습니다");
	   		f.str_title.focus(); 
	        return false;
	   	}
		return true;		
	}
	
