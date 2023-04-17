<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	//setcookie("COK_USER_INFO_DATA","",0,"/");
	
	setcookie("USER_INFO_DATA","",time()+360000,"/");
	setcookie("USER_FLAG_DATA",$idsave,time()+360000,"/");
	
	session_destroy();
	Header( "Location: "."/main/index.php" );
?>
