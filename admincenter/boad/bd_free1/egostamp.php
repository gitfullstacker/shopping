<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$str_userid = Fnc_Om_Conv_Default($_REQUEST['str_userid'], "");
$int_cart = Fnc_Om_Conv_Default($_REQUEST['int_cart'], "");

// 금액정보 얻기
$SQL_QUERY =    " SELECT
					*
				FROM 
					" . $Tname . "comm_site_info
				WHERE
					INT_NUMBER=1 ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);

// 적립금 지급
$mileage = 0;
$str_gubun = '4';
$mileage = $site_Data['INT_STAMP4'];

if ($mileage > 0) {
	$SQL_QUERY =    "UPDATE `" . $Tname . "comm_member` SET INT_MILEAGE = INT_MILEAGE+" . $mileage . " WHERE STR_USERID='" . $str_userid . "'";
	$arr_Rlt_Data = mysql_query($SQL_QUERY);

	$arr_Get_Data = array();
	$arr_Column_Name = array();

	$arr_Column_Name[0]     =     "STR_USERID";
	$arr_Column_Name[1]     =     "STR_INCOME";
	$arr_Column_Name[2]     =     "DTM_INDATE";
	$arr_Column_Name[3]     =     "STR_ORDERIDX";
	$arr_Column_Name[4]     =     "INT_VALUE";
	$arr_Column_Name[5]     =     "INT_CART";
	$arr_Column_Name[6]     =     "STR_GUBUN";

	$arr_Set_Data[0]        = $str_userid;
	$arr_Set_Data[1]        = "Y";
	$arr_Set_Data[2]        = date("Y-m-d H:i:s");
	$arr_Set_Data[3]        = $int_cart;
	$arr_Set_Data[4]        = $mileage;
	$arr_Set_Data[5]        = "";
	$arr_Set_Data[6]        = $str_gubun;

	$arr_Sub1 = "";
	$arr_Sub2 = "";
	for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {
		if ($int_I != 0) {
			$arr_Sub1 .=  ",";
			$arr_Sub2 .=  ",";
		}
		$arr_Sub1 .=  $arr_Column_Name[$int_I];
		$arr_Sub2 .=  $arr_Set_Data[$int_I] ? "'" . $arr_Set_Data[$int_I] . "'" : "null";
	}

	$Sql_Query = "INSERT INTO `" . $Tname . "comm_mileage_history` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
	mysql_query($Sql_Query);
}
?>