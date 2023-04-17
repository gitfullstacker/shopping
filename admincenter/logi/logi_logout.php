<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	//setcookie("COK_USER_INFO_DATA","",0,"/");
	session_destroy();	
	Header( "Location: "."/admincenter/logi/logi_login.php" ); 
?>