<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/Snoopy.class.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag], "");
$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no], "");
$int_delicode = Fnc_Om_Conv_Default($_REQUEST[int_delicode], "0");
$str_delicode = Fnc_Om_Conv_Default($_REQUEST[str_delicode], "");
$int_state = Fnc_Om_Conv_Default($_REQUEST[int_state], "");
$str_rdate = Fnc_Om_Conv_Default($_REQUEST[str_rdate], "");
$str_email = Fnc_Om_Conv_Default($_REQUEST[str_email], "");

$str_sdate = Fnc_Om_Conv_Default($_REQUEST[str_sdate], "");
$str_edate = Fnc_Om_Conv_Default($_REQUEST[str_edate], "");
$str_amemo = Fnc_Om_Conv_Default($_REQUEST[str_amemo], "");

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1], "");

switch ($RetrieveFlag) {
	case "UPDATE":

		$SET_SQL = "";
		if ($int_state == 4) {
			$SET_SQL = ",DTM_EDIT_DATE='" . date("Y-m-d H:i:s") . "' ";
		}

		$SQL_QUERY = " UPDATE " . $Tname . "comm_goods_cart SET ";
		$SQL_QUERY .= "STR_SDATE='$str_sdate',STR_EDATE='$str_edate',INT_STATE='$int_state',INT_DELICODE='$int_delicode',STR_DELICODE='$str_delicode',STR_RDATE='$str_rdate',STR_AMEMO='" . addslashes($str_amemo) . "'" . $SET_SQL;
		$SQL_QUERY .= " WHERE INT_NUMBER='$str_no' ";

		mysql_query($SQL_QUERY);

		if ($int_state == "3") {

			$snoopy = new snoopy;
			$snoopy->fetch("http://" . $loc_I_Pg_Domain . "/mailing/mailing02.html?str_ocode=" . urlencode($str_no));
			$body = $snoopy->results;

			Fnc_Om_Sendmail("신청하신 가방이 발송되었습니다.", $body, Fnc_Om_Store_Info(2), $str_email);
		}

?>
		<script language="javascript">
			alert("처리되었습니다.");
			parent.document.frm.submit();
		</script>
	<?
		exit;
		break;

	case "STATE":

		$SQL_QUERY = " UPDATE " . $Tname . "comm_goods_cart SET INT_STATE='$int_state', DTM_EDIT_DATE='" . date("Y-m-d H:i:s") . "' WHERE INT_NUMBER='$str_no'";

		mysql_query($SQL_QUERY);

		if ($int_state == "3") {

			$snoopy = new snoopy;
			$snoopy->fetch("http://" . $loc_I_Pg_Domain . "/mailing/mailing02.html?str_ocode=" . urlencode($str_no));
			$body = $snoopy->results;

			Fnc_Om_Sendmail("신청하신 가방이 발송되었습니다.", $body, Fnc_Om_Store_Info(2), $str_email);
		}

		exit;
		break;

	case "ADELETE":

		for ($i = 0; $i < count($chkItem1); $i++) {

			$SQL_QUERY =	"DELETE FROM " . $Tname . "comm_goods_cart WHERE INT_NUMBER='$chkItem1[$i]' ";
			$result = mysql_query($SQL_QUERY);
		}
	?>
		<script language="javascript">
			window.location.href = "orde_orde_list.php";
		</script>
<?
		exit;
		break;
}

?>