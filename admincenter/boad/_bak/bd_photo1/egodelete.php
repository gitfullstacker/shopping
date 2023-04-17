<?include "inc/ego_comm.php";?>
<?
	$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd],"");
?>
<?include "inc/ego_bd_ini.php";?>
<?
	$bln_Flag = True;

	$int_Bd_Seq = Fnc_Om_Conv_Default($_REQUEST[seq],"");

	$arr_Bd_Seq = Array();

	If (is_Array($int_Bd_Seq )) {
		$arr_Bd_Seq = $int_Bd_Seq;
	}else{
		$arr_Bd_Seq[0] = $int_Bd_Seq;
	}

	// ==========================================
	//	= 수정, 답글쓰기 관련 설정값 변수에 저장 시작
	$int_Mode = Fnc_Om_Conv_Default($_REQUEST[mode],"0");
	$str_String = Fnc_Om_Conv_Default($_REQUEST[txt_String],"");
	$str_Doc_Pwd = Fnc_Om_Conv_Default($_REQUEST[txt_Pwd],"");

	If ($str_String=="") {
		$str_String = "?bd=".$int_Ini_Board_Seq;
	}
	//	= 수정, 답글쓰기 관련 설정값 변수에 저장 종료
	// ==========================================

	If (count($arr_Bd_Seq)==1 && $int_Mode==0) {
		$Sql_Query =	"SELECT BD_IDX, BD_LEVEL, MEM_ID, BD_PWD FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."` WHERE CONF_SEQ=".$int_Ini_Board_Seq." AND BD_SEQ=".$arr_Bd_Seq[0];
		$arr_Get_Data=mysql_query($Sql_Query);
		$arr_Get_Data_Cnt=mysql_num_rows($arr_Get_Data);

		If (mysql_result($arr_Get_Data,0,MEM_ID)=="" && $bln_Cur_Admin==False) {
			If (mysql_result($arr_Get_Data,0,BD_PWD)!=$str_Doc_Pwd) {
				echo "<Script Language='JavaScript'>alert('암호가 일치하지 않습니다.');document.location.replace(document.referrer);</Script>";
				$bln_Flag = False;
				exit;
			}
		}ElseIf (mysql_result($arr_Get_Data,0,MEM_ID)!="" && $bln_Cur_Admin==False) {
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
	$int_Conf_Seq = 0;
	If ($bln_Flag) {

		for($int_I = 0 ;$int_I < count($arr_Bd_Seq); $int_I++) {

			$Sql_Query =	"SELECT COUNT(*) AS CNT FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."` WHERE BD_SEQ=".$arr_Bd_Seq[$int_I];
			$arr_Temp=mysql_query($Sql_Query);
			$arr_Temp_Cnt=mysql_num_rows($arr_Temp);

			// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//	= 삭제할 데이터가 존재한다면 데이터 삭제 시작
			If ($arr_Temp_Cnt>0) {

				$Sql_Query =	" SELECT
								A.CONF_SEQ,
								B.CONF_ATT_URL
							FROM
								`".$Tname."b_bd_data".$str_Ini_Group_Table."` AS A
								LEFT JOIN
								".$Tname."b_conf_bd AS B
								ON
								A.CONF_SEQ=B.CONF_SEQ
							WHERE
								BD_SEQ=".$arr_Bd_Seq[$int_I];

				$arr_Conf_Data=mysql_query($Sql_Query);
				$int_Conf_Seq = mysql_result($arr_Conf_Data,0,CONF_SEQ);

				// ===================================
				//	= 관련 첨부 파일 삭제 시작
				$Sql_Query =	" SELECT IMG_F_NICK AS F_NICK FROM `".$Tname."b_img_data".$str_Ini_Group_Table."` WHERE CONF_SEQ=".$int_Conf_Seq." AND BD_SEQ=".$arr_Bd_Seq[$int_I].
							" UNION ALL ".
							" SELECT FILE_F_NICK AS F_NICK FROM `".$Tname."b_file_data".$str_Ini_Group_Table."` WHERE CONF_SEQ=".$int_Conf_Seq." AND BD_SEQ=".$arr_Bd_Seq[$int_I];
				$arr_File_Data=mysql_query($Sql_Query);
				$arr_File_Data_Cnt=mysql_num_rows($arr_File_Data);

				If ($arr_File_Data_Cnt) {
					for($int_J = 0 ;$int_J < $arr_File_Data_Cnt; $int_J++) {
						$str_Add_Tag = $_SERVER[DOCUMENT_ROOT].mysql_result($arr_Conf_Data,0,CONF_ATT_URL).$int_Conf_Seq."/";
						Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_File_Data,$int_J,F_NICK));
					}
				}
				//	= 관련 첨부 파일 삭제 종료
				// ===================================

				// ===========================================
				//	= 답변글이 존재할때 답변글을 원글로 수정 시작
				$Sql_Query =	"SELECT BD_IDX, BD_LEVEL, MEM_ID FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."` WHERE CONF_SEQ=".$int_Conf_Seq." AND BD_SEQ=".$arr_Bd_Seq[$int_I];
				$arr_Reply_Data=mysql_query($Sql_Query);
				$arr_Reply_Data_Cnt=mysql_num_rows($arr_Reply_Data);

				If (mysql_result($arr_Reply_Data,0,BD_LEVEL)==0) {
					$Sql_Query =	"SELECT BD_SEQ FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."` WHERE CONF_SEQ=".$int_Conf_Seq." AND BD_IDX=".mysql_result($arr_Reply_Data,0,BD_IDX)." AND BD_LEVEL>0 ORDER BY BD_ORDER DESC LIMIT 1";
					$int_Tmp=mysql_query($Sql_Query);
					$int_Tmp_Cnt=mysql_num_rows($int_Tmp);

					If ($int_Tmp_Cnt) {
						$Sql_Query =	"UPDATE `".$Tname."b_bd_data".$str_Ini_Group_Table."` SET BD_ORDER='".(mysql_result($arr_Reply_Data,0,BD_IDX)*100)."', BD_LEVEL=0 WHERE CONF_SEQ=".$int_Conf_Seq." AND BD_SEQ=".mysql_result($int_Tmp,0,BD_SEQ);
						$result = mysql_query($Sql_Query);
					}
				}
				//	= 답변글이 존재할때 답변글을 원글로 수정 종료
				// ===========================================

				$Sql_Query =	" DELETE FROM `".$Tname."b_memo_data".$str_Ini_Group_Table."` WHERE CONF_SEQ=".$int_Conf_Seq." AND BD_SEQ=".$arr_Bd_Seq[$int_I];
				$result = mysql_query($Sql_Query);
				$Sql_Query =	" DELETE FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."` WHERE CONF_SEQ=".$int_Conf_Seq." AND BD_SEQ=".$arr_Bd_Seq[$int_I];
				$result = mysql_query($Sql_Query);
				$Sql_Query =	" DELETE FROM `".$Tname."b_img_data".$str_Ini_Group_Table."` WHERE CONF_SEQ=".$int_Conf_Seq." AND BD_SEQ=".$arr_Bd_Seq[$int_I];
				$result = mysql_query($Sql_Query);
				$Sql_Query =	" DELETE FROM `".$Tname."b_file_data".$str_Ini_Group_Table."` WHERE CONF_SEQ=".$int_Conf_Seq." AND BD_SEQ=".$arr_Bd_Seq[$int_I];
				$result = mysql_query($Sql_Query);


				//echo $Sql_Query."<br>";

			}
			//	= 삭제할 데이터가 존재한다면 데이터 삭제 종료
			// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

		}

	}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	document.location.replace("egolist.php<?=$str_String?>");
//-->
</SCRIPT>