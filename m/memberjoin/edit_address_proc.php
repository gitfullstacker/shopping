<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$str_spost = Fnc_Om_Conv_Default($_REQUEST['str_spost'], "");
$str_saddr1 = Fnc_Om_Conv_Default($_REQUEST['str_saddr1'], "");
$str_saddr2 = Fnc_Om_Conv_Default($_REQUEST['str_saddr2'], "");

$arr_Set_Data = array();
$arr_Column_Name = array();

$arr_Column_Name[0]	= "STR_SPOST";
$arr_Column_Name[1]	= "STR_SADDR1";
$arr_Column_Name[2]	= "STR_SADDR2";

$arr_Set_Data[0]		= $str_spost;
$arr_Set_Data[1]		= $str_saddr1;
$arr_Set_Data[2]		= $str_saddr2;

$arr_Sub = "";

for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

	if ($int_I != 0) {
		$arr_Sub .=  ",";
	}
	$arr_Sub .=  $arr_Column_Name[$int_I] . "=" . "'" . $arr_Set_Data[$int_I] . "' ";
}

$Sql_Query = "UPDATE `" . $Tname . "comm_member` SET ";
$Sql_Query .= $arr_Sub;
$Sql_Query .= " WHERE STR_USERID='" . $arr_Auth[0] . "' ";
mysql_query($Sql_Query);

echo "successful";

exit;
