<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/Snoopy.class.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$str_org_passwd = Fnc_Om_Conv_Default($_REQUEST['str_passwd0'], "");
$str_passwd = Fnc_Om_Conv_Default($_REQUEST['str_passwd1'], "");
$str_name = Fnc_Om_Conv_Default($_REQUEST['str_name'], "");
$str_hp = Fnc_Om_Conv_Default($_REQUEST['str_hp1'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_hp2'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_hp3'], "");
$str_telep = Fnc_Om_Conv_Default($_REQUEST['str_telep1'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_telep2'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_telep3'], "");
$str_post = Fnc_Om_Conv_Default($_REQUEST['str_post'], "");
$str_addr1 = Fnc_Om_Conv_Default($_REQUEST['str_addr1'], "");
$str_addr2 = Fnc_Om_Conv_Default($_REQUEST['str_addr2'], "");
$str_email = Fnc_Om_Conv_Default($_REQUEST['str_email'], "");
$str_tuserid = Fnc_Om_Conv_Default($_REQUEST['str_tuserid'], "");
$str_mail_f = Fnc_Om_Conv_Default($_REQUEST['str_mail_f'], "N");
$str_sms_f = Fnc_Om_Conv_Default($_REQUEST['str_sms_f'], "N");
$str_spost = Fnc_Om_Conv_Default($_REQUEST['str_spost'], "");
$str_saddr1 = Fnc_Om_Conv_Default($_REQUEST['str_saddr1'], "");
$str_saddr2 = Fnc_Om_Conv_Default($_REQUEST['str_saddr2'], "");
$str_sex = Fnc_Om_Conv_Default($_REQUEST['str_sex'], "");
$str_shp = Fnc_Om_Conv_Default($_REQUEST['str_shp1'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_shp2'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_shp3'], "");

// 현재 비밀번호 체크
$SQL_QUERY = 'SELECT COUNT(STR_USERID) AS NUM FROM `' . $Tname . 'comm_member` WHERE STR_PASSWD=password("' . $str_org_passwd . '") AND STR_USERID="' . $arr_Auth[0] . '"';
$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
	echo 'Could not run query: ' . mysql_error();
	exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

if ($arr_Data['NUM'] == 0) {
?>
	<script language="javascript">
		alert("현재 입력한 비밀번호가 맞지 않습니다.");
		window.location.href = "edit.php";
	</script>

<?php
	exit;
}

$arr_Set_Data = array();
$arr_Column_Name = array();

$arr_Column_Name[0]		= "STR_PASSWD";
$arr_Column_Name[1]		= "STR_NAME";
$arr_Column_Name[2]		= "STR_TELEP";
$arr_Column_Name[3]		= "STR_HP";
$arr_Column_Name[4]		= "STR_POST";
$arr_Column_Name[5]		= "STR_ADDR1";
$arr_Column_Name[6]		= "STR_ADDR2";
$arr_Column_Name[7]		= "STR_EMAIL";
$arr_Column_Name[8]		= "STR_MAIL_F";
$arr_Column_Name[9]		= "STR_SMS_F";
$arr_Column_Name[10]	= "STR_TUSERID";
$arr_Column_Name[11]	= "DTM_ACDATE";
$arr_Column_Name[12]	= "STR_SPOST";
$arr_Column_Name[13]	= "STR_SADDR1";
$arr_Column_Name[14]	= "STR_SADDR2";
$arr_Column_Name[15]	= "STR_SEX";
$arr_Column_Name[16]	= "STR_SHP";

$arr_Set_Data[0]		= $str_passwd;
$arr_Set_Data[1]		= $str_name;
$arr_Set_Data[2]		= $str_telep;
$arr_Set_Data[3]		= $str_hp;
$arr_Set_Data[4]		= $str_post;
$arr_Set_Data[5]		= $str_addr1;
$arr_Set_Data[6]		= $str_addr2;
$arr_Set_Data[7]		= $str_email;
$arr_Set_Data[8]		= $str_mail_f;
$arr_Set_Data[9]		= $str_sms_f;
$arr_Set_Data[10]		= $str_tuserid;
$arr_Set_Data[11]		= date("Y-m-d H:i:s");
$arr_Set_Data[12]		= $str_spost;
$arr_Set_Data[13]		= $str_saddr1;
$arr_Set_Data[14]		= $str_saddr2;
$arr_Set_Data[15]		= $str_sex;
$arr_Set_Data[16]		= $str_shp;

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

$Sql_Query = "UPDATE `" . $Tname . "comm_member` SET STR_PASSWD=password('$str_passwd') WHERE STR_USERID='$arr_Auth[0]' ";
mysql_query($Sql_Query);

?>
<script language="javascript">
	alert("회원정보가 수정되였습니다.");
	window.location.href = "edit.php";
</script>

<?php
exit;
