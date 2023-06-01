<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/Snoopy.class.php"; ?>
<?
// retrieve encoded user information from URL parameter
$type = $_GET['type'];
$user_info = $_GET['user_info'];

// decode user information from JSON format
$user = json_decode($user_info, true);

$str_userid = '';
$str_email = '';
$str_photo = '';
$str_sex = '0';
$str_hp = '';
$str_name = '';
$str_birth = '';

switch ($type) {
	case 'naver':
		$str_userid = $user['response']['nickname'];
		$str_email = $user['response']['email'];
		$str_photo = $user['response']['profile_image'];
		$str_sex = $user['response']['gender'] == "M" ? "1" : ($user['response']['gender'] == "F" ? "2" : "0");
		$str_hp = $user['response']['mobile'];
		$str_name = $user['response']['name'];
		$str_birth = $user['response']['birthyear'] . str_replace('-', '', $user['response']['birthday']);
		break;
	case 'kakao':
		$str_userid = $user['kakao_account']['profile']['nickname'];
		$str_email = $user['kakao_account']['email'];
		$str_photo = $user['kakao_account']['profile']['thumbnail_image_url'];
		$str_sex = $user['kakao_account']['gender'] == "male" ? "1" : ($user['kakao_account']['gender'] == "female" ? "2" : "0");
		// $str_hp = $user['kakao_account']['profile']['mobile'];
		// $str_name = $user['kakao_account']['profile']['name'];
		// $str_birth = $user['kakao_account']['birthday'];
		break;
}

$idsave = "0";
$idsession = "0";

$SQL_QUERY =	" SELECT
					 OM.STR_USERID,
					 OM.INT_GUBUN,
					 OM.STR_NAME,
					 OM.STR_MENU_LEVEL,
					 OM.STR_HP,
					 OM.STR_TELEP,
					 OM.STR_EMAIL,
					 '' AS STR_LEV
				 FROM ";
$SQL_QUERY .= $Tname;
$SQL_QUERY .= "comm_member AS OM
				 WHERE
					 OM.STR_EMAIL='$str_email'
					 AND
					 OM.STR_USERID='$str_userid'
					 AND
					 OM.STR_SERVICE='Y'
					 AND
					 OM.INT_GUBUN<=91";

$rel = mysql_query($SQL_QUERY);
$rcd_cnt = mysql_num_rows($rel);

if (!$rcd_cnt) {
	$str_userid = Fnc_Om_Conv_Default($str_userid, "");
	$str_menu_level = "00";
	$str_passwd = "";
	$str_name = Fnc_Om_Conv_Default($str_name, "");
	$str_hp = Fnc_Om_Conv_Default($str_hp, "");
	$str_telep = Fnc_Om_Conv_Default($str_hp, "");
	$str_post = Fnc_Om_Conv_Default($_REQUEST[str_post], "");
	$str_addr1 = Fnc_Om_Conv_Default($_REQUEST[str_addr1], "");
	$str_addr2 = Fnc_Om_Conv_Default($_REQUEST[str_addr2], "");
	$str_email = Fnc_Om_Conv_Default($str_email, "");
	$str_tuserid = Fnc_Om_Conv_Default($str_userid, "");
	$str_mail_f = "N";
	$str_sms_f = "N";
	$str_service = "Y";
	$str_escecode = "";
	$str_drcontents = "";
	$str_birth = Fnc_Om_Conv_Default($str_birth, "");
	$str_sex = Fnc_Om_Conv_Default($str_sex, "");
	$str_cert = "";

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
	$arr_Column_Name[20]		= "STR_CERT";
	$arr_Column_Name[21]		= "STR_BIRTH";
	$arr_Column_Name[22]		= "STR_SEX";

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
	$arr_Set_Data[20]		= $str_cert;
	$arr_Set_Data[21]		= $str_birth;
	$arr_Set_Data[22]		= $str_sex;

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

	$Sql_Query = "UPDATE `" . $Tname . "comm_member` SET STR_PASSWD=password('$str_passwd') WHERE STR_USERID='$str_userid' ";
	mysql_query($Sql_Query);

	// 신규가입쿠폰 가입시 자동발행
	$SQL_QUERY = 'SELECT A.* FROM `' . $Tname . 'comm_stamp_prod` A WHERE INT_PROD=2';
	$arr_Rlt_Data = mysql_query($SQL_QUERY);

	if (!$arr_Rlt_Data) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

	if ($arr_Data) {
		$SQL_QUERY = 'INSERT INTO `' . $Tname . 'comm_member_stamp` (STR_USERID, INT_STAMP, DTM_INDATE, DTM_SDATE, DTM_EDATE) VALUES ("' . $str_userid . '", 2, "' . date("Y-m-d H:i:s") . '", "' . date("Y-m-d H:i:s") . '", "' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+' . $arr_Data['INT_MONTHS'] . ' months')) . '") ';
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


	Fnc_Om_Sendmail("에이블랑에 회원이 되신 것을 환영합니다.", $body, Fnc_Om_Store_Info(2), $str_email);


?>
	<script language="javascript">
		alert("회원가입을 축하드립니다.");
		window.location.href = window.location.pathname + window.location.search;
	</script>
<?
} else {

	$sTemp = base64_encode(mysql_result($rel, 0, STR_USERID)) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, INT_GUBUN)) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, STR_NAME)) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, STR_MENU_LEVEL)) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, STR_HP)) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, STR_TELEP)) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, STR_EMAIL)) . "~";
	$sTemp .= base64_encode(Fnc_Om_Select_Code("0000000", mysql_result($rel, 0, STR_MENU_LEVEL))) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, STR_LEV)) . "~";

	$_SESSION['COK_USER_INFO_DATA'] = $sTemp;

	if ($idsave == "1") {
		setcookie("USER_INFO_DATA", mysql_result($rel, 0, STR_USERID), time() + 360000, "/");
		setcookie("USER_FLAG_DATA", $idsave, time() + 360000, "/");
	} else {
		setcookie("USER_INFO_DATA", "", time() + 360000, "/");
		setcookie("USER_FLAG_DATA", $idsave, time() + 360000, "/");
	}
	if ($idsession == "1") {
		setcookie("USER_INFO_SESSION", mysql_result($rel, 0, STR_USERID), time() + 3600000, "/");
		setcookie("USER_FLAG_SESSION", $idsession, time() + 3600000, "/");
	} else {
		setcookie("USER_INFO_SESSION", "", time() + 3600000, "/");
		setcookie("USER_FLAG_SESSION", $idsession, time() + 3600000, "/");
	}

	$SQL_QUERY = "UPDATE " . $Tname . "comm_member SET INT_LOGIN=INT_LOGIN+1,DTM_ACDATE='" . date("Y-m-d H:i:s") . "' WHERE STR_USERID='$str_userid' ";
	$result = mysql_query($SQL_QUERY);

?>
	<script language=javascript>
		{
			window.location = "/m/main/index.php"
		}
	</script>
<?
	exit;
}
?>