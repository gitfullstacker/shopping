<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/Snoopy.class.php"; ?>
<?php
$join_type = Fnc_Om_Conv_Default($_REQUEST['join_type'], "default");

if ($join_type == "default") {
	$str_hp = Fnc_Om_Conv_Default($_REQUEST['str_hp1'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_hp2'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_hp3'], "");
	$str_birth = Fnc_Om_Conv_Default($_REQUEST['str_birth_year'], "") . Fnc_Om_Conv_Default($_REQUEST['str_birth_month'], "") . Fnc_Om_Conv_Default($_REQUEST['str_birth_day'], "");
} else {
	$str_hp = Fnc_Om_Conv_Default($_REQUEST['str_hp'], "");
	$str_birth = Fnc_Om_Conv_Default($_REQUEST['str_birth'], "");
}

$str_userid = Fnc_Om_Conv_Default($_REQUEST['str_userid'], "");
$str_menu_level = Fnc_Om_Conv_Default($_REQUEST['str_menu_level'], "00");
$str_passwd = Fnc_Om_Conv_Default($_REQUEST['str_passwd1'], "");
$str_name = Fnc_Om_Conv_Default($_REQUEST['str_name'], "");
$str_telep = Fnc_Om_Conv_Default($_REQUEST['str_telep1'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_telep2'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_telep3'], "");
$str_post = Fnc_Om_Conv_Default($_REQUEST['str_post'], "");
$str_addr1 = Fnc_Om_Conv_Default($_REQUEST['str_addr1'], "");
$str_addr2 = Fnc_Om_Conv_Default($_REQUEST['str_addr2'], "");
$str_email = Fnc_Om_Conv_Default($_REQUEST['str_email'], "");
$str_tuserid = Fnc_Om_Conv_Default($_REQUEST['str_tuserid'], "");
$str_mail_f = Fnc_Om_Conv_Default($_REQUEST['str_mail_f'], "N");
$str_sms_f = Fnc_Om_Conv_Default($_REQUEST['str_sms_f'], "N");
$str_service = Fnc_Om_Conv_Default($_REQUEST['str_service'], "Y");
$str_escecode = Fnc_Om_Conv_Default($_REQUEST['str_escecode'], "");
$str_drcontents = Fnc_Om_Conv_Default($_REQUEST['str_drcontents'], "");
$str_same_account = Fnc_Om_Conv_Default($_REQUEST['same_account'], "");
$str_spost = Fnc_Om_Conv_Default($_REQUEST['str_spost'], "");
$str_saddr1 = Fnc_Om_Conv_Default($_REQUEST['str_saddr1'], "");
$str_saddr2 = Fnc_Om_Conv_Default($_REQUEST['str_saddr2'], "");
$str_sex = Fnc_Om_Conv_Default($_REQUEST['str_sex'], "");
$str_cert = Fnc_Om_Conv_Default($_REQUEST['str_cert'], "");
$str_shp = Fnc_Om_Conv_Default($_REQUEST['str_shp1'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_shp2'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_shp3'], "");

if (!$str_userid) {
?>
	<script language="javascript">
		alert("입력정보가 정확하지 않습니다.");
		window.location.href = "login.php";
	</script>
<?php
	exit;
}

$arr_Set_Data = array();
$arr_Column_Name = array();

$arr_Column_Name[0]		= "STR_USERID";
$arr_Column_Name[1]		= "INT_GUBUN";
$arr_Column_Name[2]		= "STR_MENU_LEVEL";
$arr_Column_Name[3]		= "STR_PASSWD";
$arr_Column_Name[4]		= "STR_NAME";
$arr_Column_Name[5]		= "STR_TELEP";
$arr_Column_Name[6]		= "STR_HP";
$arr_Column_Name[7]		= "STR_POST";
$arr_Column_Name[8]		= "STR_ADDR1";
$arr_Column_Name[9]		= "STR_ADDR2";
$arr_Column_Name[10]		= "STR_EMAIL";
$arr_Column_Name[11]		= "STR_MAIL_F";
$arr_Column_Name[12]		= "STR_SMS_F";
$arr_Column_Name[13]		= "STR_TUSERID";
$arr_Column_Name[14]		= "DTM_INDATE";
$arr_Column_Name[15]		= "DTM_ACDATE";
$arr_Column_Name[16]		= "INT_LOGIN";
$arr_Column_Name[17]		= "STR_SERVICE";
$arr_Column_Name[18]		= "STR_ESCECODE";
$arr_Column_Name[19]		= "STR_DRCONTENTS";
$arr_Column_Name[20]		= "STR_SPOST";
$arr_Column_Name[21]		= "STR_SADDR1";
$arr_Column_Name[22]		= "STR_SADDR2";
$arr_Column_Name[23]		= "STR_CERT";
$arr_Column_Name[24]		= "STR_BIRTH";
$arr_Column_Name[25]		= "STR_SEX";
$arr_Column_Name[26]		= "STR_SHP";

$arr_Set_Data[0]		= $str_userid;
$arr_Set_Data[1]		= "1";
$arr_Set_Data[2]		= $str_menu_level;
$arr_Set_Data[3]		= $str_passwd;
$arr_Set_Data[4]		= $str_name;
$arr_Set_Data[5]		= $str_telep;
$arr_Set_Data[6]		= $str_hp;
$arr_Set_Data[7]		= $str_post;
$arr_Set_Data[8]		= $str_addr1;
$arr_Set_Data[9]		= $str_addr2;
$arr_Set_Data[10]		= $str_email;
$arr_Set_Data[11]		= $str_mail_f;
$arr_Set_Data[12]		= $str_sms_f;
$arr_Set_Data[13]		= $str_tuserid;
$arr_Set_Data[14]		= date("Y-m-d H:i:s");
$arr_Set_Data[15]		= date("Y-m-d H:i:s");
$arr_Set_Data[16]		= "0";
$arr_Set_Data[17]		= $str_service;
$arr_Set_Data[18]		= $str_escecode;
$arr_Set_Data[19]		= $str_drcontents;
$arr_Set_Data[20]		= $str_spost;
$arr_Set_Data[21]		= $str_saddr1;
$arr_Set_Data[22]		= $str_saddr2;
$arr_Set_Data[23]		= $str_cert;
$arr_Set_Data[24]		= $str_birth;
$arr_Set_Data[25]		= $str_sex;
$arr_Set_Data[26]		= $str_shp;

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

$Sql_Query = "INSERT INTO `" . $Tname . "comm_member` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
mysql_query($Sql_Query);

if ($str_passwd) {
	$Sql_Query = "UPDATE `" . $Tname . "comm_member` SET STR_PASSWD=password('$str_passwd') WHERE STR_USERID='$str_userid' ";
	mysql_query($Sql_Query);
}

// 신규가입쿠폰 가입시 자동발행
$SQL_QUERY = 'SELECT A.* FROM `' . $Tname . 'comm_coupon` A WHERE INT_NUMBER=1';
$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
	echo 'Could not run query: ' . mysql_error();
	exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

if ($arr_Data) {
	$SQL_QUERY = 'INSERT INTO `' . $Tname . 'comm_member_coupon` (STR_USERID, INT_COUPON, DTM_INDATE, DTM_SDATE, DTM_EDATE) VALUES ("' . $str_userid . '", ' . $arr_Data['INT_NUMBER'] . ', "' . date("Y-m-d H:i:s") . '", "' . date("Y-m-d H:i:s") . '", "' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+' . $arr_Data['INT_MONTHS'] . ' months')) . '") ';
	mysql_query($SQL_QUERY);
}

//========스탬프 지급
// if (Fnc_Om_Store_Info(11) > 0) {

// 	$SQL_QUERY = "select ifnull(count(str_userid),0) as lastnumber from " . $Tname . "comm_member where str_userid='$str_tuserid' ";
// 	$arr_max_Data = mysql_query($SQL_QUERY);
// 	$mTcnt = mysql_result($arr_max_Data, 0, lastnumber);

// 	if ($mTcnt > 0) {
// 		Fnc_Om_Stamp_In($str_tuserid, "2", Fnc_Om_Store_Info(11), "");
// 	}
// }

// $snoopy = new snoopy;
// $snoopy->fetch("http://" . $loc_I_Pg_Domain . "/mailing/mailing_join.html?str_name=" . urlencode($str_name) . "&str_userid=" . urlencode($str_userid));
// $body = $snoopy->results;

// Fnc_Om_Sendmail("에이블랑에 회원이 되신 것을 환영합니다.", $body, Fnc_Om_Store_Info(2), $str_email);
?>
<script language="javascript">
	alert("회원가입을 축하드립니다.");
	window.location.href = "login.php";
</script>

<?php
exit;
