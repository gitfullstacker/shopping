	var old='';
	function menu(name){
			
		submenu=eval("submenu_prodeval"+name+".style");

		if(old!=submenu)
		{
			if(old!='')
			{
				old.display='none';
			}
			submenu.display='block';
			old=submenu;
		}
		else
		{
			submenu.display='none';
			old='';
		}
	}
	function fnc_search() {
		var f = document.frm;
		var Txt_gubun = f.Txt_gubun.value;
		var Tpage = f.total_page.value ;
		var page = 1;
	
		$("#labData").empty();
		fnc_dataload(Txt_gubun,Tpage,page)
	}
	function fnc_more() {
		var f = document.frm;
		var Txt_gubun = f.Txt_gubun.value;
		var Tpage = f.total_page.value ;
		var page = f.page.value;
		
		if ((parseInt(page)+1) <= parseInt(Tpage)) {
			f.page.value = (parseInt(page)+1);
			fnc_dataload(Txt_gubun,Tpage,f.page.value);
		} else {
			alert("마지막 화면입니다.");
		}		
	}
	function fnc_dataload(Txt_gubun,Tpage,page) {
		var mData =fuc_ajax('faq_load.php?RetrieveFlag=Load&Txt_gubun='+Txt_gubun+'&Tpage='+Tpage+'&page='+page);
		$("#labData").append(mData);
	}