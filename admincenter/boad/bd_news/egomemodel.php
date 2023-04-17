<?include "inc/ego_comm.php";?>
<?
	$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd],"");
?>
<?include "inc/ego_bd_ini.php";?>
<?
	$bln_Flag = True;

	$int_Bd_Seq = Fnc_Om_Conv_Default($_REQUEST[seq],"");

	// ==========================================
	//	= 수정, 답글쓰기 관련 설정값 변수에 저장 시작
	$str_String = Fnc_Om_Conv_Default($_REQUEST[txt_String],"");
	$str_Memo_Seq = Fnc_Om_Conv_Default($_REQUEST[txt_Memo_Real_Seq],"0");
	$str_Memo_Pwd = Trim(Fnc_Om_Conv_Default($_REQUEST[txt_Memo_Real_Pwd],""));

	If ($str_String=="") {
		$str_String = "?bd=".$int_Ini_Board_Seq;
	}
	//	= 수정, 답글쓰기 관련 설정값 변수에 저장 종료
	// ==========================================

	$int_Tmp = Fnc_Om_Conv_Default($_REQUEST[Memo_Bd_Seq],"");


	If ($str_Memo_Seq>0) {
		$Sql_Query =	" SELECT
						MEM_ID,
						MEMO_PWD
					FROM
						`".$Tname."b_memo_data".$str_Ini_Group_Table."`
					WHERE
						CONF_SEQ=".$int_Tmp."
						AND
						BD_SEQ=".$int_Bd_Seq."
						AND
						MEMO_SEQ=".$str_Memo_Seq;
		$arr_Get_Data=mysql_query($Sql_Query);
		$arr_Get_Data_Cnt=mysql_num_rows($arr_Get_Data);



		If (mysql_result($arr_Get_Data,0,MEM_ID)=="" && $bln_Cur_Admin==False) {
			If (mysql_result($arr_Get_Data,0,MEMO_PWD)!=$str_Memo_Pwd) {
				echo "<Script Language='JavaScript'>alert('암호가 일치하지 않습니다.');document.location.replace(document.referrer);</Script>";
				$bln_Flag = False;
				exit;
			}
		} ElseIf (mysql_result($arr_Get_Data,0,MEM_ID)!="" && $bln_Cur_Admin==False) {
			If (mysql_result($arr_Get_Data,0,MEM_ID)==$arr_Auth[0]) {
			}Else{
				echo "<Script Language='JavaScript'>alert('글 작성자만 삭제가 가능합니다.');document.location.replace(document.referrer);</Script>";
				$bln_Flag = False;
				exit;
			}
		}
	}

	// =======================================
	//	= 글 삭제 처리 시작
	If ($bln_Flag) {
		$Sql_Query =	" DELETE
					FROM
						`".$Tname."b_memo_data".$str_Ini_Group_Table."`
					WHERE
						CONF_SEQ=".$int_Tmp."
						AND
						BD_SEQ=".$int_Bd_Seq."
						AND
						MEMO_SEQ=".$str_Memo_Seq;
		$result = mysql_query($Sql_Query);

		$Sql_Query =	" UPDATE ".$Tname."b_bd_data".$str_Ini_Group_Table." SET BD_MEMO_CNT=BD_MEMO_CNT-1
					WHERE
						CONF_SEQ=".$int_Tmp."
						AND
						BD_SEQ=".$int_Bd_Seq;
		$result = mysql_query($Sql_Query);
	}
	//	= 글 삭제 처리 종료
	// =======================================
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	document.location.replace("egoread.php<?=$str_String?>");
//-->
</SCRIPT>