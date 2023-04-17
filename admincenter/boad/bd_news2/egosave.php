<?include "inc/ego_comm.php";?>
<?
	$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd],"");
?>
<?include "inc/ego_bd_ini.php";?>
<?
	$int_Bd_Seq = Fnc_Om_Conv_Default($_REQUEST[seq],"");

	// ==========================================
	//	= 수정, 답글쓰기 관련 설정값 변수에 저장 시작
	$int_Mode = Fnc_Om_Conv_Default($_REQUEST[mode],"0");
	$str_String = Fnc_Om_Conv_Default($_REQUEST[txt_String],"");
	If ($str_String=="") {
		$str_String = "?bd=".$int_Ini_Board_Seq;
	}
	//	= 수정, 답글쓰기 관련 설정값 변수에 저장 종료
	// ==========================================

	// ============================================================
	//	= 답변 글쓰기가 불가능한 게시판이라면 답글쓰기 거부 시작
	If ($int_Mode=="2" && $arr_Ini_Board_Info[0][9]=="0") {
		echo "<Script Language='JavaScript'>alert('답글쓰기가 불가능한 게시판 입니다.');document.location.replace('egolist.asp?bd=".$int_Ini_Board_Seq."');</Script>";
		exit;
	}
	//	= 답변 글쓰기가 불가능한 게시판이라면 답글쓰기 거부 종료
	// ============================================================

	$arr_Set_Data= Array();
	$arr_Column_Name = Array();

	$arr_Column_Name = Array(	"BD_ID_KEY",	"BD_IDX",			"BD_ORDER",
								"BD_LEVEL",		"BD_NOTICE_YN",		"MEM_CODE",		"MEM_ID",		"BD_W_NAME",
								"BD_W_EMAIL",	"BD_W_IP",			"BD_TITLE",		"BD_CONT",		"BD_PWD",
								"BD_FORMAT",	"BD_THUMB_YN",		"BD_OPEN_YN",	"BD_REG_DATE",	"BD_EDIT_DATE",
								"BD_DEL_YN",	"BD_VIEW_CNT",		"BD_GOOD_CNT",	"BD_BAD_CNT",	"BD_MEMO_CNT",	"BD_ITEM1",	"BD_ITEM2",	"BD_ITEM3"	);

	$arr_Set_Data[0]		= Fnc_Om_Conv_Default($_REQUEST[txt_Id_Key],"");
	$arr_Set_Data[1]		= Fnc_Om_Conv_Default($_REQUEST[txt_Idx],"");
	$arr_Set_Data[2]		= Fnc_Om_Conv_Default($_REQUEST[txt_Order],"");
	$arr_Set_Data[3]		= Fnc_Om_Conv_Default($_REQUEST[txt_Level],"");
	$arr_Set_Data[4]		= Fnc_Om_Conv_Default($_REQUEST[chk_Notice_Yn],"0");
	$arr_Set_Data[5]		= Fnc_Om_Conv_Default($_REQUEST[txt_Mem_Code],"");
	$arr_Set_Data[6]		= Fnc_Om_Conv_Default($_REQUEST[txt_Mem_Id],"");
	$arr_Set_Data[7]		= Fnc_Om_Conv_Default($_REQUEST[txt_Name],"");

	$arr_Set_Data[8]		= Fnc_Om_Conv_Default($_REQUEST[txt_Email],"");
	$arr_Set_Data[9]		= $_SERVER['REMOTE_ADDR'];
	$arr_Set_Data[10]	= addslashes(Fnc_Om_Conv_Default($_REQUEST[txt_Subject],""));
	$arr_Set_Data[11]	= addslashes(Fnc_Om_Conv_Default($_REQUEST[mtx_Content],""));
	$arr_Set_Data[12]	= Fnc_Om_Conv_Default($_REQUEST[txt_Pwd],"");
	//$arr_Set_Data[13]	= Fnc_Om_Conv_Default($_REQUEST[txt_Format],"");
	$arr_Set_Data[13]	= "9";
	$arr_Set_Data[14]	= Fnc_Om_Conv_Default($_REQUEST[chk_Pre_View],"0");
	$arr_Set_Data[15]	= Fnc_Om_Conv_Default($_REQUEST[chk_Open_Yn],"0");
	$arr_Set_Data[16]	= date("Y-m-d H:i:s");
	$arr_Set_Data[17]	= date("Y-m-d H:i:s");

	If ($arr_Auth[1]>90) {
		$arr_Set_Data[18]= 0;
	}Else{
		$arr_Set_Data[18]	= 1;
	}

	$arr_Set_Data[19]	= 0;
	$arr_Set_Data[20]	= 0;
	$arr_Set_Data[21]	= 0;
	$arr_Set_Data[22]	= 0;
	$arr_Set_Data[23]		= Fnc_Om_Conv_Default($_REQUEST[txt_item1],"");
	$arr_Set_Data[24]		= Fnc_Om_Conv_Default($_REQUEST[txt_item2],"");
	$arr_Set_Data[25]		= Fnc_Om_Conv_Default($_REQUEST[txt_item3],"");

	// ==================================
	//	= IDKEY 값 존재여부 점검 시작
	If ($arr_Set_Data[10]!="" && strlen($arr_Set_Data[0])==21) {
		$bln_Flag = True;
	}
	//	= IDKEY 값 존재여부 점검 종료
	// ==================================

	If ($arr_Set_Data[7]=="" || $arr_Set_Data[10]=="") {
		$bln_Flag = False;
	}

	If ($bln_Flag) {

		If ($int_Ini_Board_Seq>0 && $int_Bd_Seq==0 && strlen($arr_Set_Data[0])==21) {

			$Sql_Query =	"SELECT COUNT(*) AS CNT FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."` WHERE BD_ID_KEY='".$arr_Set_Data[0]."'";
			$result = mysql_query($Sql_Query);
			if(!result){
			   error("QUERY_ERROR");
			   exit;
			}
			$Temp = mysql_result($result,0,0);

			If ($Temp==0) {

				// =========================================
				//	= 임시저장 시작
				$Sql_Query = "SELECT IFNULL(MAX(BD_SEQ), 0)+1 AS SEQ FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."`";
				$result = mysql_query($Sql_Query);
				if(!result){
				   error("QUERY_ERROR");
				   exit;
				}
				$mTemp = mysql_result($result,0,0);

				$Sql_Query = "INSERT INTO `".$Tname."b_bd_data".$str_Ini_Group_Table."` (BD_SEQ, CONF_SEQ, BD_REG_DATE) VALUES ('$mTemp','$int_Ini_Board_Seq', '".date("Y-m-d H:i:s")."')";
				$result = mysql_query($Sql_Query);
				$int_Set_Seq=$mTemp;
				//	= 임시저장 종료
				// =========================================

				// =========================================
				// = 답변글쓰기 설정 시작
				If ($int_Mode=="2") {
					$Sql_Query =	"SELECT IFNULL(MIN(BD_ORDER), 0) AS BD_ORDER FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."` WHERE CONF_SEQ=".$int_Ini_Board_Seq." AND BD_IDX=".$arr_Set_Data[1];
					$result = mysql_query($Sql_Query);
					if(!result){
					   error("QUERY_ERROR");
					   exit;
					}
					$int_Tmp = mysql_result($result,0,0);

					If (((($arr_Set_Data[1]-1)*100)+1)>=($int_Tmp-1)) {
						echo "<Script Language='JavaScript'>alert('더이상 답글을 등록할 수 없습니다.');document.location.replace('egolist.asp".$str_String."');</Script>";
					}

					$Sql_Query = "UPDATE ".$Tname."b_bd_data".$str_Ini_Group_Table." SET BD_ORDER=BD_ORDER-1 WHERE CONF_SEQ=".$int_Ini_Board_Seq." AND BD_IDX=".$arr_Set_Data[1]." AND BD_ORDER<".$arr_Set_Data[2];
					$arr_Set_Data[2] = $arr_Set_Data[2]-1;
					$arr_Set_Data[3] = $arr_Set_Data[3]+1;

					$result = mysql_query($Sql_Query);
				} Else {
					// =========================================
					//	= 순번 설정 시작
					$arr_Set_Data[1] = $int_Set_Seq;
					$arr_Set_Data[2] = $int_Set_Seq * 100;
					//	= 순번 설정 종료
					// =========================================
				}
				//	= 답변글쓰기 설정 종료
				// =========================================


				$arr_Sub = "";

				for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

					If  ($int_I != 0) {
						$arr_Sub .=  ",";
					}
					$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";

				}

				$Sql_Query = "UPDATE `".$Tname."b_bd_data".$str_Ini_Group_Table."` SET ";
				$Sql_Query .= $arr_Sub;
				$Sql_Query .= " WHERE BD_SEQ=".$int_Set_Seq;
				$result = mysql_query($Sql_Query);


				$Sql_Query =	" UPDATE `".$Tname."b_file_data".$str_Ini_Group_Table."` SET BD_SEQ=".$int_Set_Seq." WHERE FILE_ID_KEY='".$arr_Set_Data[0]."' ";
				$result = mysql_query($Sql_Query);
				$Sql_Query =	" UPDATE `".$Tname."b_img_data".$str_Ini_Group_Table."` SET BD_SEQ=".$int_Set_Seq." WHERE IMG_ID_KEY='".$arr_Set_Data[0]."' ";
				$result = mysql_query($Sql_Query);
			}

		}else{

			$arr_Tmp =	Array(	"BD_NOTICE_YN",		"BD_W_NAME",
								"BD_W_EMAIL",		"BD_TITLE",			"BD_CONT",		"BD_PWD",
								"BD_FORMAT",		"BD_THUMB_YN",		"BD_OPEN_YN",	"BD_EDIT_DATE",	"BD_ITEM1",	"BD_ITEM2",	"BD_ITEM3"	);

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
			$arr_Tmp2[10] = $arr_Set_Data[23];
			$arr_Tmp2[11] = $arr_Set_Data[24];
			$arr_Tmp2[12] = $arr_Set_Data[25];

			for($int_I=0;$int_I<count($arr_Tmp);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Tmp[$int_I]. "=" . "'" . $arr_Tmp2[$int_I] . "' ";

			}

			$Sql_Query = "UPDATE `".$Tname."b_bd_data".$str_Ini_Group_Table."` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE BD_SEQ=".$int_Bd_Seq;
			$result = mysql_query($Sql_Query);

		}

	}

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	document.location.replace("egolist.php<?=$str_String?>");
//-->
</SCRIPT>