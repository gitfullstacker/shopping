<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag], "INSERT");

$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$str_userid = Fnc_Om_Conv_Default($_REQUEST['str_userid'], "");
$str_gubun = Fnc_Om_Conv_Default($_REQUEST['str_gubun'], "1");
$int_stamp = Fnc_Om_Conv_Default($_REQUEST['int_stamp'], "0");
$str_cont = Fnc_Om_Conv_Default($_REQUEST['str_cont'], "");

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST['chkItem1'], "");

switch ($RetrieveFlag) {

	case "DELETE":

		$SQL_QUERY =	"DELETE FROM " . $Tname . "comm_member_coupon WHERE INT_NUMBER='$str_no' ";
		$result = mysql_query($SQL_QUERY);
?>
		<script language="javascript">
			window.location.href = "memb_user_coupon_list.php?str_userid=<?= $str_userid ?>";
		</script>
<?
		exit;
		break;
}

?>