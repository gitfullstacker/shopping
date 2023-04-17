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
						//		5 : 이메일주소
						//		6 : 선택메뉴코드

	//int_A_Arr		' @@@ 로그인 배열 갯수
	//int_A			' @@@ 현재 페이지에 사용할 임시변수

	session_start();
	$bln_Auth	= True;
	//$str_Auth = Fnc_Om_Conv_Default(Trim($_COOKIE["COK_USER_INFO_DATA"]),"");
	$str_Auth = Fnc_Om_Conv_Default(Trim($_SESSION['COK_USER_INFO_DATA']),"");
	$int_A_Arr	= 7;

	$arr_U_Enc=explode("~", $str_Auth);


	If ($str_Auth=="") {
		$arr_U_Enc= Array();
		$arr_Auth= Array();

		$bln_Auth = False;

	}  else {
		//$arr_Auth= Array("","","","","","","","","");
		$arr_Auth= Array();

		for ($int_A = 0; $int_A < count($arr_U_Enc); $int_A++) {
			$arr_Auth[$int_A]	= base64_decode($arr_U_Enc[$int_A]);
		}
	}
	
	if ($_COOKIE['str_vsession']=="") {
		setcookie("str_vsession",Fnc_Om_Id_Key_Create(),0,"/");
	}
?>