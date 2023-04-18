<?include "inc/ego_comm.php";?>
<?
	header("Content-Type: text/html; charset=UTF-8");
?>
<?
	$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd],"");
?>
<?include "inc/ego_bd_ini.php";?>
<?
	$int_File_Type = Fnc_Om_Conv_Default($_REQUEST[ftype],"0");

	$int_File_Seq = Fnc_Om_Conv_Default($_REQUEST[fseq],"0");

	// =======================================================
	//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 시작
	If ($int_File_Type=="0") {
		$str_Db_Type = "file";
	}Else{
		$str_Db_Type = "img";
	}
	//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 종료
	// =======================================================

	$Sql_Query =	" SELECT
					A.".$str_Db_Type."_F_NAME AS F_NAME,
					A.".$str_Db_Type."_F_NICK AS F_NICK,
					A.".$str_Db_Type."_F_MIME AS F_MIME,
					IFNULL(B.BD_OPEN_YN, 1) AS OPEN_YN,
					IFNULL(B.BD_DEL_YN, 1) AS DEL_YN
				FROM
					`".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` AS A
					LEFT JOIN
					`".$Tname."b_bd_data".$str_Ini_Group_Table."` AS B
					ON
					A.BD_SEQ=B.BD_SEQ
					AND
					A.CONF_SEQ=B.CONF_SEQ
				WHERE
					A.CONF_SEQ=".$int_Ini_Board_Seq."
					AND
					A.".$str_Db_Type."_SEQ=".$int_File_Seq;

	$arr_Rlt_Data=mysql_query($Sql_Query);
	$arr_Rlt_Data_Cnt=mysql_num_rows($arr_Rlt_Data);

	// =========================================
	//	= 다운로드 횟수 증가 시작
	$Sql_Query =	" UPDATE `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` SET ".$str_Db_Type."_DOWN_CNT=(".$str_Db_Type."_DOWN_CNT+1) WHERE ".$str_Db_Type."_SEQ=".$int_File_Seq;
	$result = mysql_query($Sql_Query);
	//	= 다운로드 횟수 증가 종료
	// =========================================

	$str_Real_File_Name =  mysql_result($arr_Rlt_Data,0,F_NICK);
	$str_File_Name = mysql_result($arr_Rlt_Data,0,F_NAME);
	$str_Content_Type  = mysql_result($arr_Rlt_Data,0,F_MIME);
	$str_Content_Type = "application/x-msdownload";
	$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'].$str_Ini_File_Path;

	$str_Real_File_Name=iconv("UTF-8","EUC-KR",$str_Real_File_Name) ? iconv("UTF-8","EUC-KR",$str_Real_File_Name) : $str_Real_File_Name;
	$str_File_Name=iconv("UTF-8","EUC-KR",$str_File_Name) ? iconv("UTF-8","EUC-KR",$str_File_Name) : $str_File_Name;

	$ret = download_file( $str_Real_File_Name, $str_File_Name, $str_Add_Tag, $str_Content_Type);

	if( $ret == 1 ) {
		Fnc_Om_Move_Link("","","지정하신 파일이 없습니다.");
		exit;
		//Error("지정하신 파일이 없습니다.");
	}
	if( $ret == 2 ) Error("접근불가능 파일입니다. 정상 접근 하시기 바랍니다.");

?>