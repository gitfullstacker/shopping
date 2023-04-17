	function fnc_open(str_url,str_target) {
		if (str_target=="1") {
			location.href=str_url
		}else{
			var newWindow = window.open("about:blank"); 
			newWindow.location.href=str_url;
		}
	}
	function fnc_search() {
		document.frm.page.value=1;
		document.frm.action = "search.php";
		document.frm.submit();
	}
	function fnc_gbn(gbn) {
		document.frm.page.value=1;
		document.frm.Txt_rent.value = gbn;
		document.frm.action = "search.php";
		document.frm.submit();
	}