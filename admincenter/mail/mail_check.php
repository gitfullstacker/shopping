<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	$str_mailcode = Fnc_Om_Conv_Default($_REQUEST[str_mailcode],"");
	$str_userid = Fnc_Om_Conv_Default($_REQUEST[str_userid],"");

	$SQL_QUERY = "update ".$Tname."comm_mail_history set str_read_f='Y',dtm_rdate='".date("Y-m-d H:i:s")."' where int_number='".$str_mailcode."' and str_userid='".$str_userid."' ";
	$result = mysql_query($SQL_QUERY);
?>