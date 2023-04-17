<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	//setcookie("COK_USER_INFO_DATA","",0,"/");
	
	setcookie("USER_INFO_DATA","",time()+360000,"/");
	setcookie("USER_FLAG_DATA","",time()+360000,"/");
	
	setcookie("USER_INFO_SESSION","",time()+360000,"/");
	setcookie("USER_FLAG_SESSION","",time()+360000,"/");
	
	session_destroy();
	Header( "Location: "."/m/main/index.php" );
?>
