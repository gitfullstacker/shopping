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

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST['chkItem1'], "");

switch ($RetrieveFlag) {
	case "UPDATE":
		//멤버십정보얻기
		$SQL_QUERY =    "SELECT 
                            A.INT_NUMBER, A.INT_TYPE, D.INT_NUMBER AS CARD_INT_NUMBER
						FROM
							" . $Tname . "comm_membership A
						LEFT JOIN
							" . $Tname . "comm_member B
						ON
							A.STR_USERID=B.STR_USERID
						LEFT JOIN
							" . $Tname . "comm_member_pay_info C
						ON
							A.STR_ORDERIDX=C.STR_ORDERIDX
						LEFT JOIN
							" . $Tname . "comm_member_pay D
						ON
							C.INT_NUMBER=D.INT_NUMBER
						WHERE
							A.INT_NUMBER='$str_no' ";

		$arr_Rlt_Data = mysql_query($SQL_QUERY);
		$membership_Data = mysql_fetch_assoc($arr_Rlt_Data);

		switch ($membership_Data['INT_TYPE']) {
			case 1:
				$SET_QUERY = "STR_PASS1='$str_pass', STR_CANCEL1='$str_cancel'";
				break;
			case 2:
				$SET_QUERY = "STR_PASS2='$str_pass', STR_CANCEL2='$str_cancel'";
				break;
		}

		// 카드에 반영
		$SQL_QUERY = 	"UPDATE 
						" . $Tname . "comm_member_pay 
						SET 
							" . $SET_QUERY . ",
							STR_AMEMO='" . addslashes($str_amemo) . "' 
						WHERE INT_NUMBER=" . $membership_Data['CARD_INT_NUMBER'];
		mysql_query($SQL_QUERY);

		// 멤버십에 반영
		$SQL_QUERY = 	"UPDATE 
							" . $Tname . "comm_membership 
						SET 
							STR_PASS='$str_pass',
							STR_CANCEL='$str_cancel'
						WHERE INT_NUMBER=" . $membership_Data['INT_NUMBER'];
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