<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<? 
	
	$str_menu = $_REQUEST[str_menu];
	$str_path = $_REQUEST[str_path];
	
	Fnc_Om_Set_Code(7,$str_menu);

	If (Trim($str_path)=="") {
		Header( "Location: ".Fnc_Om_Select_Url($str_menu)); 
		//echo Fnc_Om_Select_Url($str_menu);
		exit;
	}else{
		Header( "Location: ".$str_path ); 
		exit;
	}
?>