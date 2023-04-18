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
	//	= �̹��� ���ϱ��� ���� ����
	$int_File_Type = 0;
	$int_File_Type =  unescape($arr_Data[6]);
	//	= �̹��� ���ϱ��� ���� ����
	// =======================================================

	// =======================================================
	//	= �̹��� �����϶� �̹��� ���̺� �ƴҶ� �������̺� ���� ����
	If ($int_File_Type==0) {
		$str_Db_Type = "file";
	}Else{
		$str_Db_Type = "img";
	}
	//	= �̹��� �����϶� �̹��� ���̺� �ƴҶ� �������̺� ���� ����
	// =======================================================

	$Sql_Query = "SELECT ".$str_Db_Type."_F_NICK AS F_NICK, ".$str_Db_Type."_F_TYPE FROM `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` WHERE ".$str_Db_Type."_SEQ=".$arr_Data[0]." AND ".$str_Db_Type."_ID_KEY='".$str_Id_Key."' ";
	$arr_Tmp = mysql_query($Sql_Query);
	$arr_Tmp_Cnt=mysql_num_rows($arr_Tmp);

	// =======================================================
	//	= ���� ���� ó�� ����
	//	��ɼ��� : �����϶��� ���ϸ� �����ϸ�
	//			  �̹����϶��� �̹��� ���ϰ� Thumb Nail ���ϱ��� ���� ó��
	If ($arr_Tmp_Cnt) {
		$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'].$str_Ini_File_Path;
		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_Tmp,0,F_NICK));
	}
	//	= ���� ���� ó�� ����
	// =======================================================

	$Sql_Query = "DELETE FROM `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` WHERE ".$str_Db_Type."_SEQ=".$arr_Data[0]." AND ".$str_Db_Type."_ID_KEY='".$str_Id_Key."' ";
	$result = mysql_query($Sql_Query);

	// ============================================================
	//	= ù��° ������ �����Ǿ����� ���� ���� ���� �����͸� 1�� ��ü ����
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
	//	= ù��° ������ �����Ǿ����� ���� ���� ���� �����͸� 1�� ��ü ����
	// ============================================================

	$int_Cur_File_Size = fnc_Use_File_Size($str_Ini_Group_Table, $str_Id_Key);
	fnc_Image_Cbo_Re_Set($arr_Forms, $str_Id_Key, $str_Ini_Group_Table);
	fnc_File_Use_Graph("lbl_File_Use_Graph", $int_Ini_Perm_File_Size, $int_Cur_File_Size);

?>