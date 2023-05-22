<? include "inc/ego_comm.php"; ?>
<?
$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd], "");
?>
<? include "inc/ego_bd_ini.php"; ?>
<?
$int_Bd_Seq = Fnc_Om_Conv_Default($_REQUEST[seq], "");

if ($int_Ini_Board_Seq > 0 && $int_Bd_Seq == 0) {
	$Sql_Query = "SELECT IFNULL(MAX(BD_SEQ), 0)+1 AS SEQ FROM `" . $Tname . "b_bd_data" . $str_Ini_Group_Table . "`";
	$result = mysql_query($Sql_Query);
	if (!result) {
		error("QUERY_ERROR");
		exit;
	}
	$mTemp = mysql_result($result, 0, 0);

	$arr_Set_Data = array();
	$arr_Column_Name = array();

	$arr_Column_Name = array(
		"BD_SEQ", 		"CONF_SEQ", 		"BD_ID_KEY",	"BD_IDX",		"BD_ORDER",
		"BD_LEVEL",		"BD_NOTICE_YN",		"MEM_CODE",		"MEM_ID",		"BD_W_NAME",
		"BD_W_EMAIL",	"BD_W_IP",			"BD_TITLE",		"BD_CONT",		"BD_PWD",
		"BD_FORMAT",	"BD_THUMB_YN",		"BD_OPEN_YN",	"BD_REG_DATE",	"BD_EDIT_DATE",
		"BD_DEL_YN",	"BD_VIEW_CNT",		"BD_GOOD_CNT",	"BD_BAD_CNT",	"BD_MEMO_CNT",	"BD_ITEM1",	"BD_ITEM2"
	);

	$arr_Set_Data[0]		= $mTemp;
	$arr_Set_Data[1]		= $int_Ini_Board_Seq;
	$arr_Set_Data[2]		= Fnc_Om_Conv_Default($_REQUEST[txt_Id_Key], "");
	$arr_Set_Data[3]		= Fnc_Om_Conv_Default($_REQUEST[txt_Idx], "");
	$arr_Set_Data[4]		= Fnc_Om_Conv_Default($_REQUEST[txt_Order], "");
	$arr_Set_Data[5]		= Fnc_Om_Conv_Default($_REQUEST[txt_Level], "");
	$arr_Set_Data[6]		= Fnc_Om_Conv_Default($_REQUEST[chk_Notice_Yn], "0");
	$arr_Set_Data[7]		= Fnc_Om_Conv_Default($_REQUEST[txt_Mem_Code], "");
	$arr_Set_Data[8]		= Fnc_Om_Conv_Default($_REQUEST[txt_Mem_Id], "");
	$arr_Set_Data[9]		= Fnc_Om_Conv_Default($_REQUEST[txt_Name], "");
	$arr_Set_Data[10]		= Fnc_Om_Conv_Default($_REQUEST[txt_Email], "");
	$arr_Set_Data[11]		= $_SERVER['REMOTE_ADDR'];
	$arr_Set_Data[12]		= addslashes(Fnc_Om_Conv_Default($_REQUEST[txt_Subject], ""));
	$arr_Set_Data[13]		= addslashes(Fnc_Om_Conv_Default($_REQUEST[mtx_Content], ""));
	$arr_Set_Data[14]		= Fnc_Om_Conv_Default($_REQUEST[txt_Pwd], "");
	$arr_Set_Data[15]		= "9";
	$arr_Set_Data[16]		= Fnc_Om_Conv_Default($_REQUEST[chk_Pre_View], "0");
	$arr_Set_Data[17]		= Fnc_Om_Conv_Default($_REQUEST[chk_Open_Yn], "0");
	$arr_Set_Data[18]		= date("Y-m-d H:i:s");
	$arr_Set_Data[19]		= date("Y-m-d H:i:s");

	if ($arr_Auth[1] > 90) {
		$arr_Set_Data[20] = 0;
	} else {
		$arr_Set_Data[20]	= 1;
	}

	$arr_Set_Data[21]	= 0;
	$arr_Set_Data[22]	= 0;
	$arr_Set_Data[23]	= 0;
	$arr_Set_Data[24]	= 0;
	$arr_Set_Data[25]	= Fnc_Om_Conv_Default($_REQUEST[str_goodcode], "");
	$arr_Set_Data[26]	= Fnc_Om_Conv_Default($_REQUEST[txt_item2], "");

	$arr_Sub1 = "";
	$arr_Sub2 = "";

	for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

		if ($int_I != 0) {
			$arr_Sub1 .=  ",";
			$arr_Sub2 .=  ",";
		}
		$arr_Sub1 .=  $arr_Column_Name[$int_I];
		$arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";
	}

	$Sql_Query = "INSERT INTO `" . $Tname . "b_bd_data" . $str_Ini_Group_Table . "` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
	mysql_query($Sql_Query);
	$int_Set_Seq = $mTemp;

	$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'] . $str_Ini_File_Path;

	// 이미지 업로드
	if (!is_dir($str_Add_Tag)) {
		mkdir($str_Add_Tag, 0777);
	}

	$bln_Flag = True;
	$bln_File = True;
	$arr_Get_Data = array();
	$arr_Column_Name = array();

	// 이미지 테이블에서 마지막 아이디 얻기
	$Sql_Query = "SELECT IFNULL(MAX(IMG_SEQ), 0)+1 AS SEQ FROM `" . $Tname . "b_img_data" . $str_Ini_Group_Table . "`";

	$result = mysql_query($Sql_Query);
	if (!result) {
		error("QUERY_ERROR");
		exit;
	}
	$int_Set_Seq1 = mysql_result($result, 0, 0);

	for ($i = 0; $i < count($_FILES['fil_File_Data']['tmp_name']); $i++) {
		$obj_File = $_FILES['fil_File_Data']['tmp_name'][$i];
		$obj_File_name = $_FILES['fil_File_Data']['name'][$i];
		$obj_File_size = $_FILES['fil_File_Data']['size'][$i];

		$full_name = explode(".", "$obj_File_name");

		$str_Temp = Fnc_Om_File_Save($obj_File, $obj_File_name, "", 0, 0, "", $str_Add_Tag);

		if ($str_Temp[0] == "0") {
			$bln_Flag = False;
			$bln_File = False;
		}
		$arr_Temp = $str_Temp[1];

		//확장자
		$arr_Column_Name[0]		= 	"IMG_SEQ";
		$arr_Column_Name[1]		= 	"BD_SEQ";
		$arr_Column_Name[2]		= 	"CONF_SEQ";
		$arr_Column_Name[3]		= 	"IMG_ID_KEY";
		$arr_Column_Name[4]		= 	"IMG_ALIGN";
		$arr_Column_Name[5]		= 	"IMG_TITLE";
		$arr_Column_Name[6]		= 	"IMG_CONT";
		$arr_Column_Name[7]		= 	"IMG_F_NAME";
		$arr_Column_Name[8]		= 	"IMG_F_NICK";
		$arr_Column_Name[9]		= 	"IMG_F_TYPE";
		$arr_Column_Name[10]	= 	"IMG_F_MIME";
		$arr_Column_Name[11]	= 	"IMG_F_SIZE";
		$arr_Column_Name[12]	= 	"IMG_REG_DATE";
		$arr_Column_Name[13]	= 	"IMG_DOWN_CNT";
		$arr_Column_Name[14]	= 	"IMG_F_WIDTH";
		$arr_Column_Name[15]	= 	"IMG_F_HEIGHT";
		$arr_Column_Name[16]	= 	"IMG_VIEW_CNT";

		$arr_Set_Data[0]		= $int_Set_Seq1;
		$arr_Set_Data[1]		= $int_Set_Seq;
		$arr_Set_Data[2]		= $int_Ini_Board_Seq;
		$arr_Set_Data[3]		= Fnc_Om_Conv_Default($_REQUEST['txt_Id_Key'], "");

		$Sql_Query = "SELECT IFNULL(MAX(IMG_ALIGN), 0)+1 AS ALIGN FROM `".$Tname."b_img_data".$str_Ini_Group_Table."` WHERE BD_SEQ=".$int_Set_Seq;

		$result = mysql_query($Sql_Query);
		if(!result){
		   error("QUERY_ERROR");
		   exit;
		}
		$arr_Set_Data[4]		= mysql_result($result,0,0);
		$arr_Set_Data[5]		= Fnc_Om_Conv_Default($_REQUEST['txt_File_Subject'],"");
		$arr_Set_Data[6]		= Fnc_Om_Conv_Default($_REQUEST['mtx_File_Content'],"");
		$arr_Set_Data[7] 		= $arr_Temp[0];
		$arr_Set_Data[8] 		= $arr_Temp[0];
		$arr_Set_Data[9] 		= $full_name[sizeof($full_name) - 1];
		$arr_Set_Data[10] 		= $arr_Temp[4];
		$arr_Set_Data[11] 		= $obj_File_size;
		$arr_Set_Data[12] 		= date("Y-m-d H:i:s");
		$arr_Set_Data[13] 		= "0";
		$arr_Set_Data[14] 		= $arr_Temp[1];
		$arr_Set_Data[15] 		= $arr_Temp[2];
		$arr_Set_Data[16] 		= "0";

		$arr_Sub1 = "";
		$arr_Sub2 = "";
		for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {
			if ($int_I != 0) {
				$arr_Sub1 .=  ",";
				$arr_Sub2 .=  ",";
			}
			$arr_Sub1 .=  $arr_Column_Name[$int_I];
			$arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";
		}

		$Sql_Query = "INSERT INTO `" . $Tname . "b_img_data" . $str_Ini_Group_Table . "` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
		mysql_query($Sql_Query);

		$int_Set_Seq1++;
	}
} else {

	$arr_Tmp =	array(
		"BD_NOTICE_YN",		"BD_W_NAME",
		"BD_W_EMAIL",		"BD_TITLE",			"BD_CONT",		"BD_PWD",
		"BD_FORMAT",		"BD_THUMB_YN",		"BD_OPEN_YN",	"BD_EDIT_DATE",	"BD_ITEM2"
	);

	$arr_Tmp2[0] = $arr_Set_Data[4];
	$arr_Tmp2[1] = $arr_Set_Data[7];
	$arr_Tmp2[2] = $arr_Set_Data[8];
	$arr_Tmp2[3] = $arr_Set_Data[10];
	$arr_Tmp2[4] = $arr_Set_Data[11];
	$arr_Tmp2[5] = $arr_Set_Data[12];
	$arr_Tmp2[6] = $arr_Set_Data[13];
	$arr_Tmp2[7] = $arr_Set_Data[14];
	$arr_Tmp2[8] = $arr_Set_Data[15];
	$arr_Tmp2[9] = $arr_Set_Data[17];
	$arr_Tmp2[10] = $arr_Set_Data[24];

	$arr_Sub = "";
	for ($int_I = 0; $int_I < count($arr_Tmp); $int_I++) {

		if ($int_I != 0) {
			$arr_Sub .=  ",";
		}
		$arr_Sub .=  $arr_Tmp[$int_I] . "=" . "'" . $arr_Tmp2[$int_I] . "' ";
	}

	$Sql_Query = "UPDATE `" . $Tname . "b_bd_data" . $str_Ini_Group_Table . "` SET ";
	$Sql_Query .= $arr_Sub;
	$Sql_Query .= " WHERE BD_SEQ=" . $int_Bd_Seq;
	$result = mysql_query($Sql_Query);
}
?>
<SCRIPT LANGUAGE="JavaScript">
	<? if ($int_Ini_Board_Seq > 0 && $int_Bd_Seq == 0 && strlen($arr_Set_Data[0]) == 21) { ?>
		document.location.replace("/m/review/index.php?bd=<?= $int_Ini_Board_Seq ?>&seq=<?= $int_Set_Seq ?>");
	<? } else { ?>
		document.location.replace("/m/review/index.php<?= $str_String ?>");
	<? } ?>
</SCRIPT>