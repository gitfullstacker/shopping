	function Save_Click() {
		if (ValidChk()==false) return;
		if (document.frm.RetrieveFlag.value!="INSERT") {
			if(!confirm("수정하신 데이터를 저장하시겠습니까?")) return;
			document.frm.RetrieveFlag.value ="UPDATE";
		} else {
			if(!confirm("작성하신 데이터를 저장하시겠습니까?")) return;		
			document.frm.RetrieveFlag.value="INSERT"
		}
		document.frm.target = "_self";
		document.frm.action = "sms_contents_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm; 
		if(chkSpace(f.str_shp1.value)){  
	       	alert("\n발신자번호가 입력되지 않았습니다");
	       	f.str_shp1.focus();
	        return false;
	   	}
		if(chkSpace(f.str_shp2.value)){  
	       	alert("\n발신자번호가 입력되지 않았습니다");
	       	f.str_shp2.focus();
	        return false;
	   	}
		if(chkSpace(f.str_shp3.value)){  
	       	alert("\n발신자번호가 입력되지 않았습니다");
	       	f.str_shp3.focus();
	        return false;
	   	}
		if(chkSpace(f.str_contents.value)){  
	       	alert("\n내용이 입력되지 않았습니다");
	       	f.str_contents.focus();
	        return false;
	   	}
		return true;		
	}
	
	function chkMsgLength(intMax,objMsg,st,st2)  {
		intMax1 = eval("document.frm."+intMax).value;
		var length = lengthMsg(objMsg.value);
        st.innerHTML = length;//현재 byte수를 넣는다

        if (length > 80) {

           		alert("문자가 80byte 이상이므로 초과된 글자수는 자동으로 삭제됩니다.\n");
            	objMsg.value = objMsg.value.replace(/\r\n$/, "");
            	objMsg.value = assertMsg(80,objMsg.value, st);

//        	st2.innerHTML = 2000;
//        	eval("document.frm."+intMax).value=2000;
//        	//alert("문자가 80byte 이상이므로 LMS모드로 변경됩니다.\n");
//        	if (length > 2000) {
//           		alert("문자가 2000byte 이상이므로 초과된 글자수는 자동으로 삭제됩니다.\n");
//            	objMsg.value = objMsg.value.replace(/\r\n$/, "");
//            	objMsg.value = assertMsg(2000,objMsg.value, st);
//            }
//       	} else {
//       		st2.innerHTML = 80;
//       		eval("document.frm."+intMax).value=80;
       	}
	}   
    function TempNull() {
		return false;
	} 
    function lengthMsg(objMsg) {
		var nbytes = 0;
        for (i=0; i<objMsg.length; i++) {
			var ch = objMsg.charAt(i);
			if(escape(ch).length > 4) {
            	nbytes += 2;
           	} else if (ch == '\n') {
            	if (objMsg.charAt(i-1) != '\r') {
                   	nbytes += 1;
              	}
           	} else if (ch == '<' || ch == '>') {
               	nbytes += 4;
			} else {
               	nbytes += 1;
			}
		}
        return nbytes;
  	}
	function assertMsg(intMax, objMsg, st) {
		var inc = 0;
        var nbytes = 0;
        var msg = "";
        
        var msglen = objMsg.length;
        for (i=0; i < msglen; i++) {
			var ch = objMsg.charAt(i);
            
            if (escape(ch).length > 4) {
             	inc = 2;
           	} else if (ch == '\n') {
               	if (objMsg.charAt(i-1) != '\r') {
                  	inc = 1;
				}
			} else if (ch == '<' || ch == '>') {
              	inc = 4;
			} else {
              	inc = 1;
			}
            
            if ((nbytes + inc) > intMax) {
              	break;
			}
            
            nbytes += inc;
            msg += ch;
        }
            
        st.innerHTML = nbytes; //현재 byte수를 넣는다
        return msg;
	}