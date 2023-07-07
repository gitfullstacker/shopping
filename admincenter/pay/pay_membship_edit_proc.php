<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag], "");

$str_gubun = Fnc_Om_Conv_Default($_REQUEST[str_gubun], "1");
$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no], "");
$str_pass = Fnc_Om_Conv_Default($_REQUEST[str_pass], "0");

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1], "");

switch ($RetrieveFlag) {
	case "ADELETE":

		for ($i = 0; $i < count($chkItem1); $i++) {
			$SQL_QUERY =	"DELETE FROM " . $Tname . "comm_member_pay_info WHERE INT_SNUMBER='$chkItem1[$i]' ";
			$result = mysql_query($SQL_QUERY);
		}
?>
		<script language="javascript">
			window.location.href = "pay_membship_list.php";
		</script>
<?
		exit;
		break;
}

?>