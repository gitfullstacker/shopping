<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "");

$str_gubun = Fnc_Om_Conv_Default($_REQUEST['str_gubun'], "1");
$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$str_pass = Fnc_Om_Conv_Default($_REQUEST['str_pass'], "0");
$str_cancel = Fnc_Om_Conv_Default($_REQUEST['str_cancel'], "0");
$str_amemo = Fnc_Om_Conv_Default($_REQUEST['str_amemo'], "");
$str_refund = Fnc_Om_Conv_Default($_REQUEST['str_refund'], "");
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], "");

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST['chkItem1'], "");

switch ($RetrieveFlag) {
	case "UPDATE":

		$SQL_QUERY = 	"UPDATE 
							" . $Tname . "comm_good_pay 
						SET STR_AMEMO='" . addslashes($str_amemo) . "' ";
		$SQL_QUERY .= " WHERE INT_NUMBER='$str_no' ";

		$result = mysql_query($SQL_QUERY);
?>
		<script language="javascript">
			alert("처리되었습니다.");
			parent.document.frm.submit();
		</script>
	<?
		exit;
		break;


	case "REFUND":

		$SQL_QUERY = 	"UPDATE 
							" . $Tname . "comm_good_pay 
						SET STR_REFUND='" . addslashes($str_refund) . "' ";
		$SQL_QUERY .= " WHERE INT_NUMBER='$str_no' ";

		$result = mysql_query($SQL_QUERY);
	?>
		<script language="javascript">
			alert("처리되었습니다.");
			parent.document.frm.submit();
		</script>
	<?
		exit;
		break;


	case "ADELETE":

		for ($i = 0; $i < count($chkItem1); $i++) {
			$SQL_QUERY =	"DELETE FROM " . $Tname . "comm_good_pay WHERE INT_NUMBER='$chkItem1[$i]' ";
			$result = mysql_query($SQL_QUERY);
		}
	?>
		<script language="javascript">
			window.location.href = "good_pay_list.php";
		</script>
<?
		exit;
		break;
}

?>