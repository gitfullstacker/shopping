<?
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//
//		파일명	: om_info_auth.asp
//		기  능	: 회원 로그인정보 복호화 후 배열에 저장
//
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// ==================================================
//		인증회원 여부 검사 후
//		사용자정보배열에 저장 시작

//bln_Auth		' @@@ 인증여부값 [true : 인증사용자 , false : 비인증사용자]
//str_Auth		' @@@ 로그인 쿠키값
//arr_U_Enc		' @@@ 암호화된 인증값
//arr_Auth		' @@@ 인증결과값 복호화 후 배열에 저장
//		0 : 회원아이디
//		1 : 회원구분 [0-비인증회원, 1-일반, 91-관리자]
//		2 : 회원이름
//		3 : 회원메뉴접근권한
//		4 : 전화번호
//		5 : 전화번호1
//		6 : 이메일주소
//		7 : 선택메뉴코드
//		8 : 회원생일
//		9 : 회원등급

//int_A_Arr		' @@@ 로그인 배열 갯수
//int_A			' @@@ 현재 페이지에 사용할 임시변수

session_start();
$bln_Auth	= True;
//$str_Auth = Fnc_Om_Conv_Default(Trim($_COOKIE["COK_USER_INFO_DATA"]),"");
$str_Auth = Fnc_Om_Conv_Default(Trim($_SESSION['COK_USER_INFO_DATA']), "");
$int_A_Arr	= 11;

$arr_U_Enc = explode("~", $str_Auth);


if ($str_Auth == "") {
	$arr_U_Enc = array();
	$arr_Auth = array();

	$bln_Auth = False;
} else {
	//$arr_Auth= Array("","","","","","","","","");
	$arr_Auth = array();

	for ($int_A = 0; $int_A < count($arr_U_Enc); $int_A++) {
		$arr_Auth[$int_A]	= base64_decode($arr_U_Enc[$int_A]);
	}

	$SQL_QUERY = 'SELECT A.* FROM `' . $Tname . 'comm_member` A WHERE A.STR_USERID = "' . $arr_Auth[0] . '"';
	$arr_Rlt_Data = mysql_query($SQL_QUERY);
	$user_Data = mysql_fetch_assoc($arr_Rlt_Data);

	// 생일쿠폰 자동발행
	if (intval(substr($user_Data['STR_BIRTH'], 4, 2)) == date('m')) {
		// 해당하는 생일쿠폰선택
		$int_coupon = $user_Data['STR_GRADE'] == 'B' ? 4 : 2; // Black등급인가 체크하고 해당 쿠폰발행
		// 생일쿠폰 받았는지 먼저 체크
		$SQL_QUERY = 'SELECT COUNT(A.INT_NUMBER) AS NUM FROM `' . $Tname . 'comm_member_coupon` A WHERE A.STR_USERID="' . $user_Data['STR_USERID'] . '" AND A.INT_COUPON=' . $int_coupon . ' AND YEAR(A.DTM_INDATE)=' . date('Y');
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
				$SQL_QUERY = 'INSERT INTO `' . $Tname . 'comm_member_coupon` (STR_USERID, INT_COUPON, DTM_INDATE, DTM_SDATE, DTM_EDATE) VALUES ("' . $user_Data['STR_USERID'] . '", ' . $arr_Data['INT_NUMBER'] . ', "' . date("Y-m-d H:i:s") . '", "' . date("Y-m-d H:i:s") . '", "' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+' . $arr_Data['INT_MONTHS'] . ' months')) . '") ';
				mysql_query($SQL_QUERY);
?>
				<script>
					alert('축하합니다. 생일쿠폰이 지급되였습니다.');
				</script>
<?php
			}
		}
	}
}

if ($_COOKIE['str_vsession'] == "") {
	setcookie("str_vsession", Fnc_Om_Id_Key_Create(), 0, "/");
}
