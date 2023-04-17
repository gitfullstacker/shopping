<?include "inc/ego_comm.php";?>
<?
	$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd],"");
?>
<?include "inc/ego_bd_ini.php";?>
<?
	$bln_Flag = True;

	$int_Bd_Seq = Fnc_Om_Conv_Default($_REQUEST[seq],"");

	$str_String = Fnc_Om_Conv_Default($_REQUEST[txt_String],"");
	If ($str_String=="?" || $str_String=="") {
		$str_String = "?bd=".$int_Ini_Board_Seq;
	}

	If ($bln_Flag && $int_Bd_Seq<1) {
		$str_Tmp = "잘못된 파일 접근입니다.";
		$bln_Flag = False;
	}

	If ($bln_Flag && $arr_Ini_Board_Info[0][10]<1) {
		$str_Tmp = "메모 글쓰기가 불가능한 게시판 입니다.";
		$bln_Flag = False;
	}

	// =========================================
	//	= 게시판 설정순번 변수에 저장 시작
	$Sql_Query = "SELECT CONF_SEQ FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."` WHERE BD_SEQ=".$int_Bd_Seq;
	$result = mysql_query($Sql_Query);
	if(!result){
	   error("QUERY_ERROR");
	   exit;
	}
	$int_Ini_Board_Seq = mysql_result($result,0,0);
	//	= 게시판 설정순번 변수에 저장 종료
	// =========================================

	$int_Tmp = Fnc_Om_Conv_Default($_REQUEST[Memo_Bd_Seq],"");

	$Sql_Query =	"SELECT IFNULL(MAX(MEMO_SEQ), 0)+1 AS SEQ FROM `".$Tname."b_memo_data".$str_Ini_Group_Table."`";
	$result = mysql_query($Sql_Query);
	if(!result){
	   error("QUERY_ERROR");
	   exit;
	}
	$arr_Column_Name = Array(	"MEMO_SEQ",		"BD_SEQ",			"CONF_SEQ",		"MEM_CODE",		"MEM_ID",
								"MEMO_ICON",	"MEMO_W_NAME",		"MEMO_W_EMAIL",	"MEMO_W_IP",	"MEMO_CONT",
								"MEMO_PWD",		"MEMO_REG_DATE"		);

	$arr_Set_Data= Array();

	$arr_Set_Data[0]		= mysql_result($result,0,0);
	$arr_Set_Data[1]		= $int_Bd_Seq;
	$arr_Set_Data[2]		= $int_Tmp;
	$arr_Set_Data[3]		= "";
	$arr_Set_Data[4]		= $arr_Auth[0];
	$arr_Set_Data[5]		= Fnc_Om_Conv_Default($_REQUEST[rdo_Memo_Icon],"");
	$arr_Set_Data[6]		= Fnc_Om_Conv_Default($_REQUEST[txt_Memo_Name],"");
	$arr_Set_Data[7]		= Fnc_Om_Conv_Default($_REQUEST[txt_Memo_Email],"");
	$arr_Set_Data[8]		= $_SERVER['REMOTE_ADDR'];
	$arr_Set_Data[9]		= addslashes(Fnc_Om_Conv_Default($_REQUEST[mtx_Memo_Cont],""));
	$arr_Set_Data[10]	= Fnc_Om_Conv_Default($_REQUEST[txt_Memo_Pwd],"");
	$arr_Set_Data[11]	= date("Y-m-d H:i:s");

	If ($arr_Auth[0]=="" && $arr_Set_Data[10]=="") {
		$str_Tmp = "글 암호를 입력하세요.";
		$bln_Flag = False;
	}

	If ($bln_Flag) {

		If ($arr_Set_Data[6]!="" && $arr_Set_Data[9]!="") {

				$arr_Sub1 = "";
				$arr_Sub1 = "";

				for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

					If  ($int_I != 0) {
						$arr_Sub1 .=  ",";
					}
					$arr_Sub1 .=  $arr_Column_Name[$int_I];
					If  ($int_I != 0) {
						$arr_Sub2 .=  ",";
					}
					$arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "' ";

				}
				$Sql_Query = "INSERT INTO `".$Tname."b_memo_data".$str_Ini_Group_Table."` (";
				$Sql_Query .= $arr_Sub1;
				$Sql_Query .= " ) VALUES ( ";
				$Sql_Query .= $arr_Sub2;
				$Sql_Query .= " ) ";
				$result = mysql_query($Sql_Query);

				$Sql_Query =	"UPDATE ".$Tname."b_bd_data".$str_Ini_Group_Table." SET BD_MEMO_CNT=IFNULL(BD_MEMO_CNT, 0)+1 WHERE CONF_SEQ=".$int_Tmp." AND BD_SEQ=".$int_Bd_Seq;
				$result = mysql_query($Sql_Query);
		}


	}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	document.location.replace("egoread.php<?=$str_String?>");
//-->
</SCRIPT>