<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	$SQL_QUERY =	" SELECT
					A.*
				FROM "
					.$Tname."comm_member_requ AS A
				WHERE
					A.INT_NUMBER='$str_no' ";

	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	//echo $SQL_QUERY;
	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

	$str_Real_File_Name =  $arr_Data["STR_IMAGE1"];
	$str_File_Name = $arr_Data["STR_IMAGE1"];
	$str_Content_Type = "application/x-msdownload";
	$str_Ini_File_Path = "/admincenter/files/requ/";
	$str_Add_Tag = $_SERVER[DOCUMENT_ROOT].$str_Ini_File_Path;

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