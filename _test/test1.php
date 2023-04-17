<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/Snoopy.class.php";?>
<?
	$snoopy = new snoopy; 
	$str_userid="aaa";
	$str_name="홍길동";
	$snoopy->fetch("http://".$loc_I_Pg_Domain."/mailing/mailing_join.html?str_name=".urlencode($str_name)."&str_userid=".urlencode($str_userid)); 
	$body = $snoopy->results; 

	$str1="joilya@naver.com";	
	$str2="joilya@nate.com";
	Fnc_Om_Sendmail("테스트",$body,$str1,$str2);
?>