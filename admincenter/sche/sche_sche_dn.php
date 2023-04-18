<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	header("Content-Type: text/html; charset=UTF-8");
?>
<?
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"0");
	$int_fnumber = Fnc_Om_Conv_Default($_REQUEST[int_fnumber],"0");
	
	$Sql_Query =	" SELECT
					A.STR_SIMAGE1
				FROM
					`".$Tname."comm_sche_file` AS A
				WHERE
					A.INT_NUMBER=".$str_no."
					AND
					A.INT_FNUMBER=".$int_fnumber;

	$arr_Rlt_Data=mysql_query($Sql_Query);
	$arr_Rlt_Data_Cnt=mysql_num_rows($arr_Rlt_Data);
	
	$str_Add_Tag = $_SERVER['DOCUMENT_ROOT']."/admincenter/files/sche/";
	
	$str_Real_File_Name=mysql_result($arr_Rlt_Data,0,STR_SIMAGE1);
	$str_File_Name=mysql_result($arr_Rlt_Data,0,STR_SIMAGE1);
	
	$str_Real_File_Name=iconv("UTF-8","EUC-KR",$str_Real_File_Name) ? iconv("UTF-8","EUC-KR",$str_Real_File_Name) : $str_Real_File_Name;
	$str_File_Name=iconv("UTF-8","EUC-KR",$str_File_Name) ? iconv("UTF-8","EUC-KR",$str_File_Name) : $str_File_Name;

	$ret = download_file( $str_Real_File_Name, $str_File_Name, $str_Add_Tag, $str_Content_Type);

	if( $ret == 1 ) {
		Fnc_Om_Move_Link("","","에러");
		exit;
		//Error("¶dȏ½àǄOL ¾�´׮");
	}
	if( $ret == 2 ) Error("에러");
	
?>