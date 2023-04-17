<?
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//
	//		파일명	: om_info_page.php
	//		기  능	: 현재 출력중인 페이지 경로 및 URL 데이터 정보
	//
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//loc_I_Pg_Domain		' @@@ 현재 출력중인 도메인정보
	//loc_I_Pg_Ffile		' @@@ 도메인정보를 제외한 웹 파일 경로와 파일명
	//loc_I_Pg_Dstr		' @@@ 현 페이지에 전달된 웹 쿼리 문자열 정보
	//loc_I_Pg_Fol		' @@@ 현 페이지의 웹 디렉토리 경로
	//loc_I_Pg_File		' @@@ 현재 페이지의 파일명

	$loc_I_Pg_Domain		= $_SERVER["HTTP_HOST"];
	$loc_I_Pg_Ffile		=  $_SERVER["PHP_SELF"];
	$loc_I_Pg_Dstr		= $_SERVER["QUERY_STRING"];
	$gbl_Cur_Path_Page 		= $_SERVER["SCRIPT_NAME"];
	$loc_I_Pg_Fol		= substr($loc_I_Pg_Ffile, 0, strrpos($loc_I_Pg_Ffile, "/")+1);
	$loc_I_Pg_File		= substr($loc_I_Pg_Ffile, strrpos($loc_I_Pg_Ffile, "/")+1, strlen($loc_I_Pg_Ffile));

	// ====================== ADD
	//gbl_Om_Url			' @@@ 공통으로 사용할 웹주소
	//gbl_Om_Pub_Fol		' @@@ 공통으로 사용할 폴더

	$gbl_Om_Url			= "http://".$loc_I_Pg_Domain;
	$gbl_Om_Pub_Fol		= "/pub/";

	// ====================== ADD
	//s_Sys_Url		' @@@ 사이트 모듈파일 웹폴더 경로
	//s_Cur_Fol		' @@@ 현재 페이지의 폴더경로

	$s_Sys_Url	= $gbl_Om_Url . $gbl_Om_Pub_Fol;
	$s_Cur_Fol	= "http://".$loc_I_Pg_Domain . $loc_I_Pg_Fol;

	//str_Access_Pg_Url	' @@@ 인증 거부전 접근한 페이지 경로로 사용
	$str_Access_Pg_Url = URLEncode($loc_I_Pg_Ffile . "?" . $loc_I_Pg_Dstr) ;
?>