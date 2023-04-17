<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	$str_userid = Fnc_Om_Conv_Default($_REQUEST[str_userid],"");

	if (Fnc_Om_Store_Info(12) > 0) {
	
		$SQL_QUERY = "select ifnull(count(str_userid),0) as lastnumber from ".$Tname."comm_member where str_userid='$str_userid' " ;
		$arr_max_Data=mysql_query($SQL_QUERY);
		$mTcnt = mysql_result($arr_max_Data,0,lastnumber);
		
		If ($mTcnt > 0) {
			Fnc_Om_Stamp_In($str_userid,"3",Fnc_Om_Store_Info(12),"");
		}
	}
?>