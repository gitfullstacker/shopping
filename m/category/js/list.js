	function fnc_open(str_url,str_target) {
		if (str_target=="1") {
			location.href=str_url
		}else{
			var newWindow = window.open("about:blank"); 
			newWindow.location.href=str_url;
		}
	}
	function fnc_gbn(gbn) {
		document.frm.page.value=1;
		document.frm.Txt_rent.value = gbn;
		document.frm.action = "list.php";
		document.frm.submit();
	}
	
	function fnc_more() {
		var f = document.frm;
		var Txt_bcode= f.Txt_bcode.value;
		var Txt_rent = f.Txt_rent.value;
		var Tpage = f.total_page.value ;
		var page = f.page.value;
		
		if ((parseInt(page)+1) <= parseInt(Tpage)) {
			f.page.value = (parseInt(page)+1);
			fnc_dataload(Txt_bcode,Txt_rent,Tpage,f.page.value);
		} else {
			alert("마지막 화면입니다.");
		}		
	}
	function fnc_dataload(Txt_bcode,Txt_rent,Tpage,page) {
		var mData =fuc_ajax('list_load.php?RetrieveFlag=Load&Txt_bcode='+Txt_bcode+'&Txt_rent='+Txt_rent+'&Tpage='+Tpage+'&page='+page);
		$("#labData").append(mData);
	}