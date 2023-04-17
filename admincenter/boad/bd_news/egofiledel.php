<?include "inc/ego_comm.php";?>
<?
	$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd],"");
?>
<?include "inc/ego_bd_ini.php";?>
<?
	$arr_Forms = explode("|",Fnc_Om_Conv_Default($_REQUEST[txt_Forms],""));

	$str_Id_Key = Fnc_Om_Conv_Default($_REQUEST[txt_Id_Key],"");

	$int_Bd_Seq = Fnc_Om_Conv_Default($_REQUEST[seq],"0");

	$arr_Data = explode("|",Fnc_Om_Conv_Default($_REQUEST[sel_Att_File],""));


	// =======================================================
	//	= 이미지 파일구분 설정 시작
	$int_File_Type = 0;
	$int_File_Type =  unescape($arr_Data[6]);
	//	= 이미지 파일구분 설정 종료
	// =======================================================

	// =======================================================
	//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 시작
	If ($int_File_Type==0) {
		$str_Db_Type = "file";
	}Else{
		$str_Db_Type = "img";
	}
	//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 종료
	// =======================================================

	$Sql_Query = "SELECT ".$str_Db_Type."_F_NICK AS F_NICK, ".$str_Db_Type."_F_TYPE FROM `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` WHERE ".$str_Db_Type."_SEQ=".$arr_Data[0]." AND ".$str_Db_Type."_ID_KEY='".$str_Id_Key."' ";
	$arr_Tmp = mysql_query($Sql_Query);
	$arr_Tmp_Cnt=mysql_num_rows($arr_Tmp);

	// =======================================================
	//	= 파일 삭제 처리 시작
	//	기능설명 : 파일일때는 파일만 삭제하며
	//			  이미지일때는 이미지 파일과 Thumb Nail 파일까지 삭제 처리
	If ($arr_Tmp_Cnt) {
		$str_Add_Tag = $_SERVER[DOCUMENT_ROOT].$str_Ini_File_Path;
		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_Tmp,0,F_NICK));
	}
	//	= 파일 삭제 처리 종료
	// =======================================================

	$Sql_Query = "DELETE FROM `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` WHERE ".$str_Db_Type."_SEQ=".$arr_Data[0]." AND ".$str_Db_Type."_ID_KEY='".$str_Id_Key."' ";
	$result = mysql_query($Sql_Query);

	// ============================================================
	//	= 첫번째 순번이 삭제되었을때 가장 작은 순번 데이터를 1로 대체 시작
	If ($int_Bd_Seq=="0") {
		$str_Add_Query = $str_Db_Type."_ID_KEY='".$str_Id_Key."' ";
	}Else{
		$str_Add_Query = "BD_SEQ=".$int_Bd_Seq;
	}

	If ($arr_Data[2]=="1") {
		$Sql_Query = "SELECT IFNULL(MIN(".$str_Db_Type."_ALIGN), 0) AS ALIGN FROM `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` WHERE ".$str_Add_Query;
		$arr_Tmp = mysql_query($Sql_Query);
		$int_Align = mysql_result($arr_Tmp,0,ALIGN);

		If ($int_Align>0) {
			$Sql_Query = "UPDATE `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` SET ".$str_Db_Type."_ALIGN=1 WHERE ".$str_Add_Query." AND ".$str_Db_Type."_ALIGN='".$int_Align."'";
			echo $Sql_Query;
			$result = mysql_query($Sql_Query);
		}
	}
	//	= 첫번째 순번이 삭제되었을때 가장 작은 순번 데이터를 1로 대체 종료
	// ============================================================

	$int_Cur_File_Size = fnc_Use_File_Size($str_Ini_Group_Table, $str_Id_Key);
	fnc_Image_Cbo_Re_Set($arr_Forms, $str_Id_Key, $str_Ini_Group_Table);
	fnc_File_Use_Graph("lbl_File_Use_Graph", $int_Ini_Perm_File_Size, $int_Cur_File_Size);

?>