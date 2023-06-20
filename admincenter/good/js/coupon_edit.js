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
		document.frm.action = "coupon_edit_proc.php";
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
		if(chkSpace(f.str_title.value)){
	       	alert("\n쿠폰명이 입력되지 않았습니다");
	       	f.str_title.focus();
	        return false;
	   	}
		return true;
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
