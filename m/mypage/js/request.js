	function Save_Click(int_gubun) {
		if (ValidChk(int_gubun)==false) return;

		if(!confirm("요청 하시겠습니까?")) return;
		document.frm.RetrieveFlag.value="INSERT";

		document.frm.int_gubun.value=int_gubun;
		document.frm.target = "_self";
		document.frm.action = "request_proc.php";
		document.frm.submit();
	}
	function ValidChk(int_gubun)	{
		var f = document.frm;
		
		if (int_gubun=="1") {
			if(f.int_brand.selectedIndex==0&&chkSpace(f.str_ebrand1.value)){
		       	alert("\n브랜드가 선택되지 않았습니다");
		       	f.int_brand.focus();
		        return false;
		   	}
		   	if (getRadioValue(f.int_reason) == "") {
		   		alert("가방 요청 이유가 선택되지 않았습니다.");
		   		f.int_reason[0].focus();
		   		return false;
		   	}
		   	if (f.int_reason[3].checked) {
				if(chkSpace(f.str_reason.value)){
			       	alert("\n기타 요청 사유가 입력되지 않았습니다");
			       	f.str_reason.focus();
			        return false;
			   	}
		   	}
		}else{
			var rowCnt = parseInt(document.getElementsByName('int_sbrand[]').length);
		  	var count =0;

			if (rowCnt >1){
	  				for (var i=0;i<rowCnt;i++) {
	  					if (document.getElementsByName('int_sbrand[]')[i].checked) {
	  						count++;
	  					}
	  				}
		  	}else {
	  			if (document.getElementsByName('int_sbrand[]')[0].checked) {
	  				count++;
	  			}
			}
			
	  		if (!count&&chkSpace(f.str_ebrand2.value)) {
				alert("브랜드를 선택하지 않았습니다.");
				return false;
	       	}
			
		}
		return true;
	}
	function getRadioValue(obj) {
			var len = obj.length;
			var result = "";
			if (!len && obj.checked) {
				result = obj.value;
			}
			for (var i=0, m=obj.length; i < m; i++ ) {
				if (obj[i].checked) {
						result = obj[i].value;
				}
			}
			return result;
	}
	
