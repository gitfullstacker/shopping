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
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], "");
$str_userid = Fnc_Om_Conv_Default($_REQUEST['str_userid'], "");

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST['chkItem1'], "");

switch ($RetrieveFlag) {
	case "UPDATE":

		$SQL_QUERY = 	"UPDATE 
							" . $Tname . "comm_member_pay 
						SET STR_PASS='$str_pass',
							" . ($int_type == 1 ? "STR_CANCEL1" : "STR_CANCEL2") . "='$str_cancel',
							STR_AMEMO='" . addslashes($str_amemo) . "' ";
		$SQL_QUERY .= " WHERE INT_NUMBER='$str_no' ";
		mysql_query($SQL_QUERY);

		// 멤버십에 반영
		$SQL_QUERY = 	"UPDATE 
							" . $Tname . "comm_membership 
						SET STR_PASS='$str_pass',
							STR_CANCEL='$str_cancel'";
		$SQL_QUERY .= " WHERE STR_USERID='$str_userid' AND INT_TYPE=" . $int_type;
		mysql_query($SQL_QUERY);
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

			$SQL_QUERY =	"DELETE FROM " . $Tname . "comm_member_pay_info WHERE INT_NUMBER='$chkItem1[$i]' ";
			mysql_query($SQL_QUERY);

			$SQL_QUERY =	"DELETE FROM " . $Tname . "comm_member_pay WHERE INT_NUMBER='$chkItem1[$i]' ";
			mysql_query($SQL_QUERY);
		}
	?>
		<script language="javascript">
			window.location.href = "pay_pay_list.php";
		</script>
<?
		exit;
		break;
}

?>