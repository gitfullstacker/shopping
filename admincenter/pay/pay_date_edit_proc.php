<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/Snoopy.class.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag], "");
$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no], "");
$str_sdate = Fnc_Om_Conv_Default($_REQUEST[str_sdate], "");
$str_edate = Fnc_Om_Conv_Default($_REQUEST[str_edate], "");

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1], "");

switch ($RetrieveFlag) {
	case "UPDATE":
		$SQL_QUERY =	"SELECT
							A.*, B.STR_USERID
						FROM 
							" . $Tname . "comm_member_pay_info AS A
						LEFT JOIN
							" . $Tname . "comm_member_pay AS B
						ON
							A.INT_NUMBER = B.INT_NUMBER
						WHERE
							A.INT_SNUMBER='$str_no' ";

		$arr_Rlt_Data = mysql_query($SQL_QUERY);
		$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

		$SQL_QUERY = 	"UPDATE 
							" . $Tname . "comm_member_pay_info
						SET 
							STR_SDATE='$str_sdate',
							STR_EDATE='$str_edate' 
						WHERE INT_SNUMBER='$str_no' ";
		mysql_query($SQL_QUERY);

		// 멤버십에 반영
		$SQL_QUERY = 	"UPDATE 
							" . $Tname . "comm_membership 
						SET 
							DTM_SDATE='$str_sdate',
							DTM_EDATE='$str_edate'
						WHERE STR_USERID='" . $arr_Data['STR_USERID'] . "' AND INT_TYPE=" . $arr_Data['INT_TYPE'];
		mysql_query($SQL_QUERY);
?>
		<script language="javascript">
			alert("처리되었습니다.");
			parent.document.frm.submit();
		</script>
<?
		exit;
		break;
}

?>