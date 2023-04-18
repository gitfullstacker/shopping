<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");
	

	switch($RetrieveFlag){
		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_member_alarm WHERE STR_GOODCODE='$str_no' AND INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="good_master_like.php?str_no=<?=$str_no?>";
			</script>
			<?
			exit;
			break;

	}

?>
