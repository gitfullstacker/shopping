<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$login_type = Fnc_Om_Conv_Default($_REQUEST['login_type'], "default");
$str_email = Fnc_Om_Conv_Default($_REQUEST['str_email'], "");
$str_userid = Fnc_Om_Conv_Default($_REQUEST['str_userid'], $_REQUEST['str_userid2']);
$str_passwd = $_REQUEST['str_passwd'];
$idsave = Fnc_Om_Conv_Default($_REQUEST['idsave'], "0");
$idsession = Fnc_Om_Conv_Default($_REQUEST['idsession'], "0");

if ($login_type == "default") {
	$login_query = "";
	// $login_query = "AND OM.STR_PASSWD=password('$str_passwd')";
} else {
	$login_query = "AND OM.STR_EMAIL='$str_email'";
}

$SQL_QUERY =	" SELECT
					 OM.STR_USERID,
					 OM.INT_GUBUN,
					 OM.STR_NAME,
					 OM.STR_MENU_LEVEL,
					 OM.STR_HP,
					 OM.STR_TELEP,
					 OM.STR_EMAIL,
					 OM.STR_BIRTH,
					 OM.STR_GRADE,
					 '' AS STR_LEV
				 FROM ";
$SQL_QUERY .= $Tname;
$SQL_QUERY .= "comm_member AS OM
				 WHERE
					 OM.STR_USERID='$str_userid'
					 " . $login_query . "
					 AND
					 OM.STR_SERVICE='Y'
					 AND
					 OM.INT_GUBUN<=91";



$rel = mysql_query($SQL_QUERY);
$rcd_cnt = mysql_num_rows($rel);

if (!$rcd_cnt) { ?>
	<script language=javascript>
		{
			alert("\n회원아이디나 비밀번호가 틀립니다\n다시한번 확인해 주세요.")
			window.location = "javascript: history.go(-1)"
		}
	</script>
<?
	exit;
} else {
	$sTemp = base64_encode(mysql_result($rel, 0, 'STR_USERID')) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, 'INT_GUBUN')) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, 'STR_NAME')) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, 'STR_MENU_LEVEL')) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, 'STR_HP')) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, 'STR_TELEP')) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, 'STR_EMAIL')) . "~";
	$sTemp .= base64_encode(Fnc_Om_Select_Code("0000000", mysql_result($rel, 0, 'STR_MENU_LEVEL'))) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, 'STR_LEV')) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, 'STR_BIRTH')) . "~";
	$sTemp .= base64_encode(mysql_result($rel, 0, 'STR_GRADE')) . "~";

	$_SESSION['COK_USER_INFO_DATA'] = $sTemp;

	if ($idsave == "1") {
		setcookie("USER_INFO_DATA", mysql_result($rel, 0, 'STR_USERID'), time() + 360000, "/");
		setcookie("USER_FLAG_DATA", $idsave, time() + 360000, "/");
	} else {
		setcookie("USER_INFO_DATA", "", time() + 360000, "/");
		setcookie("USER_FLAG_DATA", $idsave, time() + 360000, "/");
	}
	if ($idsession == "1") {
		setcookie("USER_INFO_SESSION", mysql_result($rel, 0, 'STR_USERID'), time() + 3600000, "/");
		setcookie("USER_FLAG_SESSION", $idsession, time() + 3600000, "/");
	} else {
		setcookie("USER_INFO_SESSION", "", time() + 3600000, "/");
		setcookie("USER_FLAG_SESSION", $idsession, time() + 3600000, "/");
	}

	$SQL_QUERY =	"UPDATE " . $Tname . "comm_member SET INT_LOGIN=INT_LOGIN+1,DTM_ACDATE='" . date("Y-m-d H:i:s") . "' WHERE STR_USERID='$str_userid' ";
	$result = mysql_query($SQL_QUERY);

	// 등급 재설정
	$SQL_QUERY = 'SELECT A.DTM_GRADEDATE FROM `' . $Tname . 'comm_member` A WHERE A.STR_GRADE = "B" AND A.STR_USERID = "' . $str_userid . '"';
	$arr_Rlt_Data = mysql_query($SQL_QUERY);
	$user_Data = mysql_fetch_assoc($arr_Rlt_Data);

	if ($user_Data['DTM_GRADEDATE']) {
		$datetime = new DateTime($user_Data['DTM_GRADEDATE']);
		$currentDatetime = new DateTime();

		$interval = $currentDatetime->diff($datetime);

		if ($interval->y > 1) {
			$Sql_Query = "UPDATE `" . $Tname . "comm_member` SET STR_GRADE='G', DTM_GRADEDATE='" . date("Y-m-d H:i:s") . "' WHERE STR_USERID='" . $str_userid . "'";
			mysql_query($Sql_Query);
		}
	}

	// 생일쿠폰 자동발행
	if (substr(mysql_result($rel, 0, 'STR_BIRTH'), 4, 2) == date('m') && substr(mysql_result($rel, 0, 'STR_BIRTH'), 6, 2) == date('d')) {
		// 해당하는 생일쿠폰선택
		$int_coupon = mysql_result($rel, 0, 'STR_GRADE') == 'B' ? 4 : 2; // Black등급인가 체크하고 해당 쿠폰발행
		// 생일쿠폰 받았는지 먼저 체크
		$SQL_QUERY = 'SELECT COUNT(A.INT_NUMBER) AS NUM FROM `' . $Tname . 'comm_member_coupon` A WHERE A.STR_USERID="' . mysql_result($rel, 0, 'STR_USERID') . '" AND A.INT_COUPON=' . $int_coupon . ' AND YEAR(A.DTM_INDATE)=' . date('Y');
		$arr_Rlt_Data = mysql_query($SQL_QUERY);
		$coupon_Data = mysql_fetch_assoc($arr_Rlt_Data);

		if ($coupon_Data['NUM'] == 0) {
			// 생일쿠폰 자동발행
			$SQL_QUERY = 'SELECT A.* FROM `' . $Tname . 'comm_coupon` A WHERE INT_NUMBER=' . $int_coupon;
			$arr_Rlt_Data = mysql_query($SQL_QUERY);

			if (!$arr_Rlt_Data) {
				echo 'Could not run query: ' . mysql_error();
				exit;
			}
			$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

			if ($arr_Data) {
				$SQL_QUERY = 'INSERT INTO `' . $Tname . 'comm_member_coupon` (STR_USERID, INT_COUPON, DTM_INDATE, DTM_SDATE, DTM_EDATE) VALUES ("' . mysql_result($rel, 0, 'STR_USERID') . '", ' . $arr_Data['INT_NUMBER'] . ', "' . date("Y-m-d H:i:s") . '", "' . date("Y-m-d H:i:s") . '", "' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+' . $arr_Data['INT_MONTHS'] . ' months')) . '") ';
				mysql_query($SQL_QUERY);
			}
		}
	}
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