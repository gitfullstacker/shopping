<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "INSERT");

$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$str_String = Fnc_Om_Conv_Default($_REQUEST['str_String'], "");
$str_title = Fnc_Om_Conv_Default($_REQUEST['str_title'], "");
$str_desc = Fnc_Om_Conv_Default($_REQUEST['str_desc'], "");
$int_value = Fnc_Om_Conv_Default($_REQUEST['int_value'], "0");
$str_percent = Fnc_Om_Conv_Default($_REQUEST['str_percent'], "N");
$str_service = Fnc_Om_Conv_Default($_REQUEST['str_service'], "Y");
$int_months = Fnc_Om_Conv_Default($_REQUEST['int_months'], "3");
$str_code = Fnc_Om_Conv_Default($_REQUEST['str_code'], "");
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], "0");

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST['chkItem1'], "");

switch ($RetrieveFlag) {
	case "INSERT":

		$arr_Set_Data = array();
		$arr_Column_Name = array();

		$arr_Column_Name[0]		= "STR_TITLE";
		$arr_Column_Name[1]		= "STR_DESC";
		$arr_Column_Name[2]		= "DTM_INDATE";
		$arr_Column_Name[3]		= "STR_SERVICE";
		$arr_Column_Name[4]		= "INT_VALUE";
		$arr_Column_Name[5]		= "STR_PERCENT";
		$arr_Column_Name[6]		= "INT_MONTHS";
		$arr_Column_Name[7]		= "STR_CODE";
		$arr_Column_Name[8]		= "INT_TYPE";

		$arr_Set_Data[0]		= $str_title;
		$arr_Set_Data[1]		= $str_desc;
		$arr_Set_Data[2]		= date("Y-m-d H:i:s");
		$arr_Set_Data[3]		= $str_service;
		$arr_Set_Data[4]		= $int_value;
		$arr_Set_Data[5]		= $str_percent;
		$arr_Set_Data[6]		= $int_months;
		$arr_Set_Data[7]		= $str_code;
		$arr_Set_Data[8]		= $int_type;

		$arr_Sub1 = "";
		$arr_Sub2 = "";

		for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

			if ($int_I != 0) {
				$arr_Sub1 .=  ",";
				$arr_Sub2 .=  ",";
			}
			$arr_Sub1 .=  $arr_Column_Name[$int_I];
			$arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";
		}

		$Sql_Query = "INSERT INTO `" . $Tname . "comm_coupon` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
		mysql_query($Sql_Query);

		$SQL_QUERY = "SELECT ifnull(max(INT_NUMBER),0) AS lastnumber FROM " . $Tname . "comm_coupon";
		$last_Data = mysql_query($SQL_QUERY);
		$lastnumber = mysql_result($last_Data, 0, 'lastnumber');
?>
		<script language="javascript">
			window.location.href = "coupon_edit.php<?= $str_String ?>&RetrieveFlag=UPDATE&str_no=<?= $lastnumber ?>";
		</script>
	<?
		exit;
		break;

	case "UPDATE":

		$arr_Set_Data = array();
		$arr_Column_Name = array();

		$arr_Column_Name[0]		= "STR_TITLE";
		$arr_Column_Name[1]		= "STR_DESC";
		$arr_Column_Name[2]		= "STR_SERVICE";
		$arr_Column_Name[3]		= "INT_VALUE";
		$arr_Column_Name[4]		= "STR_PERCENT";
		$arr_Column_Name[5]		= "INT_MONTHS";
		$arr_Column_Name[6]		= "STR_CODE";
		$arr_Column_Name[7]		= "INT_TYPE";

		$arr_Set_Data[0]		= $str_title;
		$arr_Set_Data[1]		= $str_desc;
		$arr_Set_Data[2]		= $str_service;
		$arr_Set_Data[3]		= $int_value;
		$arr_Set_Data[4]		= $str_percent;
		$arr_Set_Data[5]		= $int_months;
		$arr_Set_Data[6]		= $str_code;
		$arr_Set_Data[7]		= $int_type;

		$arr_Sub = "";

		for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

			if ($int_I != 0) {
				$arr_Sub .=  ",";
			}
			$arr_Sub .=  $arr_Column_Name[$int_I] . "=" . "'" . $arr_Set_Data[$int_I] . "' ";
		}

		$Sql_Query = "UPDATE `" . $Tname . "comm_coupon` SET ";
		$Sql_Query .= $arr_Sub;
		$Sql_Query .= " WHERE INT_NUMBER='" . $str_no . "' ";
		mysql_query($Sql_Query);

	?>
		<script language="javascript">
			window.location.href = "coupon_edit.php<?= $str_String ?>&RetrieveFlag=UPDATE&str_no=<?= $str_no ?>";
		</script>
	<?
		exit;
		break;

	case "ADELETE":

		for ($i = 0; $i < count($chkItem1); $i++) {
			$SQL_QUERY = "DELETE FROM " . $Tname . "comm_coupon WHERE INT_NUMBER='$chkItem1[$i]' ";
			$result = mysql_query($SQL_QUERY);
		}
	?>
		<script language="javascript">
			window.location.href = "coupon_list.php<?= $str_String ?>";
		</script>
<?
		exit;
		break;
}

?>