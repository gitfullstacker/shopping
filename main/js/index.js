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
	function fnc_open(str_url,str_target) {
		if (str_target=="1") {
			location.href=str_url
		}else{
			var newWindow = window.open("about:blank"); 
			newWindow.location.href=str_url;
		}
	}