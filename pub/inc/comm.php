<?
//header("Pragma: no-cache");
//header("Cache-Control: no-cache,must-revalidate");
header("content-type:text/html; charset=utf-8");
ini_set("url_rewriter.tags", "");
session_cache_limiter("no-cache");
session_start();
ini_set("session.cookie_lifetime", "86400");
ini_set("session.cache_expire", "86400");
ini_set("session.gc_maxlifetime", "86400");

?>
<? include $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/om_info_table.php"; ?>
<? include $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/om_info_page.php"; ?>
<? include $_SERVER['DOCUMENT_ROOT'] . "/pub/db/om_db_connect.php"; ?>
<? include $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/om_mod_fnc.php"; ?>
<? include $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/om_info_auth.php"; ?>
<?

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$sitecode = "AC430";				// NICE로부터 부여받은 사이트 코드
$sitepasswd = "Gj9tUHSzgRBx";			// NICE로부터 부여받은 사이트 패스워드
// $cb_encode_path = $_SERVER['DOCUMENT_ROOT'] . "/nice/mo/CPClient";		// NICE로부터 받은 암호화 프로그램의 위치 (절대경로+모듈명)
$cb_encode_path = $_SERVER['DOCUMENT_ROOT'] . "/nice/mo/linux/CPClient_linux_x64";		// NICE로부터 받은 암호화 프로그램의 위치 (절대경로+모듈명)
// $cb_encode_path = $_SERVER['DOCUMENT_ROOT'] . "/nice/mo/window/CPClient_x64.exe";		// NICE로부터 받은 암호화 프로그램의 위치 (절대경로+모듈명)

if ($_COOKIE["USER_FLAG_SESSION"] == "1") { //셰션을 유지한다.

	$SQL_QUERY =	" SELECT
						 A.STR_USERID,
						 A.INT_GUBUN,
						 A.STR_NAME,
						 A.STR_MENU_LEVEL,
						 A.STR_HP,
						 A.STR_TELEP,
						 A.STR_EMAIL,
						 A.STR_BIRTH,
						 A.STR_GRADE,
						 '' AS STR_LEV
					 FROM 
					 	" . $Tname . "comm_member AS A
					 WHERE
						 A.STR_USERID='" . $_COOKIE["USER_INFO_SESSION"] . "'
						 AND
						 A.STR_SERVICE='Y'
						 AND
						 A.INT_GUBUN<=91";

	$Log_Info = mysql_query($SQL_QUERY);
	$Log_cnt = mysql_num_rows($Log_Info);

	if ($Log_cnt) {

		$sTemp = base64_encode(mysql_result($Log_Info, 0, STR_USERID)) . "~";
		$sTemp .= base64_encode(mysql_result($Log_Info, 0, INT_GUBUN)) . "~";
		$sTemp .= base64_encode(mysql_result($Log_Info, 0, STR_NAME)) . "~";
		$sTemp .= base64_encode(mysql_result($Log_Info, 0, STR_MENU_LEVEL)) . "~";
		$sTemp .= base64_encode(mysql_result($Log_Info, 0, STR_HP)) . "~";
		$sTemp .= base64_encode(mysql_result($Log_Info, 0, STR_TELEP)) . "~";
		$sTemp .= base64_encode(mysql_result($Log_Info, 0, STR_EMAIL)) . "~";
		$sTemp .= base64_encode(Fnc_Om_Select_Code("0000000", mysql_result($Log_Info, 0, STR_MENU_LEVEL))) . "~";
		$sTemp .= base64_encode(mysql_result($Log_Info, 0, STR_LEV)) . "~";
		$sTemp .= base64_encode(mysql_result($Log_Info, 0, STR_BIRTH)) . "~";
		$sTemp .= base64_encode(mysql_result($Log_Info, 0, STR_GRADE)) . "~";

		$_SESSION['COK_USER_INFO_DATA'] = $sTemp;
	}

	// 생일쿠폰 자동발행
	if (substr(mysql_result($Log_Info, 0, 'STR_BIRTH'), 4, 2) == date('m')) {
		// 해당하는 생일쿠폰선택
		$int_coupon = mysql_result($Log_Info, 0, 'STR_GRADE') == 'B' ? 4 : 2; // Black등급인가 체크하고 해당 쿠폰발행
		// 생일쿠폰 받았는지 먼저 체크
		$SQL_QUERY = 'SELECT COUNT(A.INT_NUMBER) AS NUM FROM `' . $Tname . 'comm_member_coupon` A WHERE A.STR_USERID="' . mysql_result($Log_Info, 0, 'STR_USERID') . '" AND A.INT_COUPON=' . $int_coupon . ' AND YEAR(A.DTM_INDATE)=' . date('Y');
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
				$SQL_QUERY = 'INSERT INTO `' . $Tname . 'comm_member_coupon` (STR_USERID, INT_COUPON, DTM_INDATE, DTM_SDATE, DTM_EDATE) VALUES ("' . mysql_result($Log_Info, 0, 'STR_USERID') . '", ' . $arr_Data['INT_NUMBER'] . ', "' . date("Y-m-d H:i:s") . '", "' . date("Y-m-d H:i:s") . '", "' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+' . $arr_Data['INT_MONTHS'] . ' months')) . '") ';
				mysql_query($SQL_QUERY);

				alert('축하합니다. 생일쿠폰이 지급되였습니다.');
			}
		}
	}
}
?>
