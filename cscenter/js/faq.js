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
		document.frm.page.value=1;
		document.frm.action = "faq.php";
		document.frm.submit();
	}