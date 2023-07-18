<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "");

$str_gubun = Fnc_Om_Conv_Default($_REQUEST['str_gubun'], "1");
$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$str_pass1 = Fnc_Om_Conv_Default($_REQUEST['str_pass1'], "0");
$str_cancel1 = Fnc_Om_Conv_Default($_REQUEST['str_cancel1'], "0");
$str_pass2 = Fnc_Om_Conv_Default($_REQUEST['str_pass2'], "0");
$str_cancel2 = Fnc_Om_Conv_Default($_REQUEST['str_cancel2'], "0");
$str_amemo = Fnc_Om_Conv_Default($_REQUEST['str_amemo'], "");
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], "");
$str_userid = Fnc_Om_Conv_Default($_REQUEST['str_userid'], "");

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST['chkItem1'], "");

switch ($RetrieveFlag) {
	case "UPDATE":
		//구독 멤버십의 결제정보얻기
        $SQL_QUERY =    "SELECT 
                            A.*
                        FROM 
                            `" . $Tname . "comm_member_pay_info` A
                        WHERE
							A.INT_TYPE=1
                            AND A.INT_NUMBER=" . $str_no;

		$arr_Rlt_Data = mysql_query($SQL_QUERY);
		$sub_pay_Data = mysql_fetch_assoc($arr_Rlt_Data);

		//렌트 멤버십의 결제정보얻기
        $SQL_QUERY =    "SELECT 
                            A.*
                        FROM 
                            `" . $Tname . "comm_member_pay_info` A
                        WHERE
							A.INT_TYPE=2
                            AND A.INT_NUMBER=" . $str_no;

		$arr_Rlt_Data = mysql_query($SQL_QUERY);
		$rent_pay_Data = mysql_fetch_assoc($arr_Rlt_Data);

		if ($int_type == 0) {
			// 카드에 반영
			$SQL_QUERY = 	"UPDATE 
							" . $Tname . "comm_member_pay 
							SET 
								STR_PASS1='$str_pass1',
								STR_CANCEL1='$str_cancel1',
								STR_PASS2='$str_pass2',
								STR_CANCEL2='$str_cancel2',
								STR_AMEMO='" . addslashes($str_amemo) . "' ";
			$SQL_QUERY .= " WHERE INT_NUMBER='$str_no' ";
			mysql_query($SQL_QUERY);

			// 멤버십에 반영
			$SQL_QUERY = 	"UPDATE 
								" . $Tname . "comm_membership 
							SET 
								STR_PASS='" . $str_pass1 . "',
								STR_CANCEL='" . $str_cancel1 . "'";
			$SQL_QUERY .= " WHERE STR_USERID='$str_userid' AND INT_TYPE=1 AND STR_ORDERIDX='" . $sub_pay_Data['STR_ORDERIDX'] . "'";
			mysql_query($SQL_QUERY);

			$SQL_QUERY = 	"UPDATE 
								" . $Tname . "comm_membership 
							SET 
								STR_PASS='" . $str_pass2 . "',
								STR_CANCEL='" . $str_cancel2 . "'";
			$SQL_QUERY .= " WHERE STR_USERID='$str_userid' AND INT_TYPE=2 AND STR_ORDERIDX='" . $rent_pay_Data['STR_ORDERIDX'] . "'";
			mysql_query($SQL_QUERY);
		} else {
			switch ($int_type) {
				case 1:
					$SET_QUERY = "STR_PASS1='$str_pass1', STR_CANCEL1='$str_cancel1'";
					break;
				case 2:
					$SET_QUERY = "STR_PASS2='$str_pass2', STR_CANCEL2='$str_cancel2'";
					break;
			}

			// 카드에 반영
			$SQL_QUERY = 	"UPDATE 
							" . $Tname . "comm_member_pay 
							SET 
								" . $SET_QUERY . ",
								STR_AMEMO='" . addslashes($str_amemo) . "' ";
			$SQL_QUERY .= " WHERE INT_NUMBER='$str_no' ";
			mysql_query($SQL_QUERY);

			// 멤버십에 반영
			$SQL_QUERY = 	"UPDATE 
								" . $Tname . "comm_membership 
							SET 
								STR_PASS='" . ($int_type == 1 ? $str_pass1 : $str_pass2) . "',
								STR_CANCEL='" . ($int_type == 1 ? $str_cancel1 : $str_cancel2) . "'";
			$SQL_QUERY .= " WHERE STR_USERID='$str_userid' AND INT_TYPE=" . $int_type . " AND STR_ORDERIDX='" . ($int_type == 1 ? $sub_pay_Data['STR_ORDERIDX'] : $rent_pay_Data['STR_ORDERIDX']) . "'";
			mysql_query($SQL_QUERY);
		}

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

			$SQL_QUERY =	" SELECT
								A.*
							FROM 
								" . $Tname . "comm_member_pay AS A
							WHERE
								A.INT_NUMBER='$chkItem1[$i]' ";

			$arr_Rlt_Data = mysql_query($SQL_QUERY);
			$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

			$SQL_QUERY =	"DELETE FROM " . $Tname . "comm_membership WHERE STR_USERID='" . $arr_Data['STR_USERID'] . "' ";
			mysql_query($SQL_QUERY);

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