<?include "inc/ego_comm.php";?>
<?
	$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd],"");
?>
<?include "inc/ego_bd_ini.php";?>
<?
	$arr_Forms = explode("|",Fnc_Om_Conv_Default($_REQUEST[txt_Forms],""));

	$str_Id_Key = Fnc_Om_Conv_Default($_REQUEST[txt_Id_Key],"");

	$int_Bd_Seq = Fnc_Om_Conv_Default($_REQUEST[seq],"0");

	$int_Set_Seq = Fnc_Om_Conv_Default($_REQUEST[txt_File_Idx],"");

	$int_File_Type = Fnc_Om_Conv_Default($_REQUEST[txt_File_Type],"");

	// =======================================================
	//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 시작
	If ($int_File_Type=="0") {
		$str_Db_Type = "file";
	}Else {
		$str_Db_Type = "img" ;
	}
	//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 종료
	// =======================================================

	$txt_File_Subject = Fnc_Om_Conv_Default($_REQUEST[txt_File_Subject],"");
	$mtx_File_Content = Fnc_Om_Conv_Default($_REQUEST[mtx_File_Content],"");


	$Sql_Query = "UPDATE `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` SET ".$str_Db_Type."_TITLE='$txt_File_Subject',".$str_Db_Type."_CONT='$mtx_File_Content' WHERE ".$str_Db_Type."_SEQ=".$int_Set_Seq." AND ".$str_Db_Type."_ID_KEY='".$str_Id_Key."' ";
	$result = mysql_query($Sql_Query);

	fnc_Image_Cbo_Re_Set($arr_Forms, $str_Id_Key, $str_Ini_Group_Table);
?>