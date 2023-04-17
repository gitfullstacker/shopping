<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();

	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");

	switch($RetrieveFlag){
     	case "ALARMDEL" :
     	
			$Sql_Query = "DELETE FROM `".$Tname."comm_member_alarm` WHERE STR_USERID='$arr_Auth[0]' AND STR_GOODCODE='$str_goodcode' ";
			mysql_query($Sql_Query);
		
			?>
			<script language="javascript">
				window.location.href="stocked.php";
			</script>
			<?	
		
			exit;
			break;
	}
?>
