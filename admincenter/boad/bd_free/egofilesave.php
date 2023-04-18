<?include "inc/ego_comm.php";?>
<?
	$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd],"");
?>
<?include "inc/ego_bd_ini.php";?>
<?
	$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'].$str_Ini_File_Path;

	if (!is_dir($str_Add_Tag)){
		mkdir($str_Add_Tag,0777);
	}

	$arr_Forms = explode("|",Fnc_Om_Conv_Default($_REQUEST[txt_Forms],""));

	$int_Set_Seq = Fnc_Om_Conv_Default($_REQUEST[txt_File_Idx],"0");

	$bln_Flag = True;
	$bln_File = True;
	$arr_Get_Data= Array();
	$arr_Column_Name = Array();

	$obj_File=$_FILES['fil_File_Data']['tmp_name'];
	$obj_File_name=$_FILES['fil_File_Data']['name'];
	$obj_File_size=$_FILES['fil_File_Data']['size'];
	$full_name = explode(".", "$obj_File_name");

	$str_Temp=Fnc_Om_File_Save($obj_File,$obj_File_name,"",0,0,"",$str_Add_Tag);

	if ($str_Temp[0] == "0") {
		$bln_Flag = False;
		$bln_File = False;
	}
	$arr_Temp=$str_Temp[1];


	//확장자
	$arr_Get_Data[6] =  $arr_Temp[0];
	$arr_Get_Data[8] = $full_name[sizeof($full_name)-1];
	$arr_Get_Data[9] = $arr_Temp[4];
	$arr_Get_Data[10] = $obj_File_size;
	$arr_Get_Data[11] = date("Y-m-d H:i:s");
	$arr_Get_Data[12] = "0";
	$arr_Get_Data[13] = $arr_Temp[1];
	$arr_Get_Data[14] = $arr_Temp[2];
	$arr_Get_Data[15] = "0";

	$arr_Get_Data[7] =  $arr_Temp[0];

	// =======================================================
	//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 시작
	If ($arr_Temp[3]=="") {
		$str_Db_Type = "file";
	}Else {
		$str_Db_Type = "img";
	}
	//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 종료
	// =======================================================

	If ($int_Set_Seq=="0") {
		$Sql_Query = "SELECT IFNULL(MAX(".$str_Db_Type."_SEQ), 0)+1 AS SEQ FROM `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."`";
		$result = mysql_query($Sql_Query);
		if(!result){
		   error("QUERY_ERROR");
		   exit;
		}
		$int_Set_Seq = mysql_result($result,0,0);

		$Sql_Query = "INSERT INTO `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."`  (".$str_Db_Type."_SEQ) VALUES ('$int_Set_Seq') ";
		$result = mysql_query($Sql_Query);
	}

	$arr_Get_Data[0] = Fnc_Om_Conv_Default($_REQUEST[seq],"0");

	$arr_Get_Data[1] = $int_Ini_Board_Seq;

	$arr_Get_Data[2] = Fnc_Om_Conv_Default($_REQUEST[txt_Id_Key],"");

	If ($arr_Get_Data[0] == "0") {
		$Sql_Query = "SELECT IFNULL(MAX(".$str_Db_Type."_ALIGN), 0)+1 AS ALIGN FROM `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` WHERE ".$str_Db_Type."_ID_KEY='".$arr_Get_Data[2]."' ";
	}Else{
		$Sql_Query = "SELECT IFNULL(MAX(".$str_Db_Type."_ALIGN), 0)+1 AS ALIGN FROM `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` WHERE BD_SEQ=".$arr_Get_Data[0];
	}
	$result = mysql_query($Sql_Query);
	if(!result){
	   error("QUERY_ERROR");
	   exit;
	}
	$arr_Get_Data[3] = mysql_result($result,0,0);

	$arr_Get_Data[4] = Fnc_Om_Conv_Default($_REQUEST[txt_File_Subject],"");
	$arr_Get_Data[5] = Fnc_Om_Conv_Default($_REQUEST[mtx_File_Content],"");

	// =================================================================
	//	= 컬럼 설정시작
	$arr_Column_Name[0]	= "BD_SEQ";
	$arr_Column_Name[1]	= "CONF_SEQ";
	$arr_Column_Name[2]	= $str_Db_Type . "_ID_KEY";
	$arr_Column_Name[3]	= $str_Db_Type . "_ALIGN";
	$arr_Column_Name[4]	= $str_Db_Type . "_TITLE";
	$arr_Column_Name[5]	= $str_Db_Type . "_CONT";
	$arr_Column_Name[6]	= $str_Db_Type . "_F_NAME";
	$arr_Column_Name[7]	= $str_Db_Type . "_F_NICK";
	$arr_Column_Name[8]	= $str_Db_Type . "_F_TYPE"
;
	$arr_Column_Name[9]	= $str_Db_Type . "_F_MIME";
	$arr_Column_Name[10]	= $str_Db_Type . "_F_SIZE";
	$arr_Column_Name[11]	= $str_Db_Type . "_REG_DATE";
	$arr_Column_Name[12]	= $str_Db_Type . "_DOWN_CNT";

	If ($arr_Temp[3]!="") {
		$arr_Column_Name[13]	= $str_Db_Type . "_F_WIDTH";
		$arr_Column_Name[14]	= $str_Db_Type . "_F_HEIGHT";
		$arr_Column_Name[15]	= $str_Db_Type . "_VIEW_CNT";
	}
	//	= 컬럼 설정종료
	// =================================================================

	// =================================================================
	//	파일의 허용 저장한계 초과유무 검사 시작
	$int_Cur_File_Size = fnc_Use_File_Size($str_Ini_Group_Table, $arr_Get_Data[2]) + $arr_Get_Data[10];

	If ($int_Ini_Perm_File_Size<$int_Cur_File_Size && $bln_Flag) {
		$bln_Flag = False;
		$bln_File = False;
		Fnc_Om_File_Delete($str_Add_Tag, $arr_Get_Data[7]);
		echo "<Script Language='JavaScript'>alert('파일 저장 한계를 넘었으므로 저장할 수 없습니다.');</Script>";
	}
	//	파일의 허용 저장한계 초과유무 검사 종료
	// =================================================================

	If ($bln_Flag) {

		$arr_Sub = "";

		for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

			If  ($int_I != 0) {
				$arr_Sub .=  ",";
			}
			$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Get_Data[$int_I] . "' ";

		}


		$Sql_Query = "UPDATE `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` SET ";
		$Sql_Query .= $arr_Sub;
		$Sql_Query .= " WHERE ".$str_Db_Type."_SEQ=".$int_Set_Seq;

		$result = mysql_query($Sql_Query);

	}

	If ($bln_Flag==False) {
		$Sql_Query = "DELETE FROM `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` WHERE ".$str_Db_Type."_SEQ=".$int_Set_Seq;
		$result = mysql_query($Sql_Query);
	}

	fnc_Image_Cbo_Re_Set($arr_Forms, $arr_Get_Data[2], $str_Ini_Group_Table);

	If (!$bln_File) {
		$int_Cur_File_Size = $int_Cur_File_Size - $arr_Get_Data[10];
	}

	fnc_File_Use_Graph("lbl_File_Use_Graph", $int_Ini_Perm_File_Size, $int_Cur_File_Size);


?>