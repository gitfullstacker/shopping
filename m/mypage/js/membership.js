	function Pay_Click(int_gubun) {
		//document.frm.target = "_self";
		//document.frm.action = "membership.php";
		window.location.href = "membership.php?int_gubun="+int_gubun;
		//document.frm.submit();
	}
	function Save_Click(int_gubun) {
		document.frm.target = "_self";
		if (int_gubun=="1") {
			document.frm.action = "membership01.php";
		}else{
			document.frm.action = "membership02.php";
		}
		document.frm.submit();	
	}
	
