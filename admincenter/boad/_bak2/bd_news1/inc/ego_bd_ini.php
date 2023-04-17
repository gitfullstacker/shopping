<?
	// ==========================================================
	//	= 환경설정 변수 종료

	$arr_Ini_Board_Info = fnc_Board_Ini($int_Ini_Board_Seq);

	If (!(is_array($arr_Ini_Board_Info))) {
		echo "생성되지 않은 게시판 입니다.";
		exit;
	}

	$str_Ini_Group_Table = substr($arr_Ini_Board_Info[0][1], strrpos($arr_Ini_Board_Info[0][1], "@"));
	$int_Ini_Perm_File_Size = 1024 * 1024 * $arr_Ini_Board_Info[0][12];
	//$int_Ini_Table_Width = $arr_Ini_Board_Info[0][3];
	$int_Ini_Table_Width = "100%";
	$str_Ini_File_Path = $arr_Ini_Board_Info[0][5] . $int_Ini_Board_Seq . "/";
	$int_Ini_File_Att = $arr_Ini_Board_Info[0][11];
	$int_Ini_Img_Prev = $arr_Ini_Board_Info[0][16];

	//	= 환경설정 변수 종료
	// ==========================================================

	// ===========================================================
	//	= 페이지에서 사용할 공용변수 선언 및 초기화 시작

	$int_I=0; $int_J=0;
	$int_Tmp = 0;
	$str_Tmp = "";

	//	= 페이지에서 사용할 공용변수 선언 및 초기화 종료
	// ===========================================================

	$int_Ini_Bd_Type = $arr_Ini_Board_Info[0][4];
	$str_Board_Icon_Img = $arr_Ini_Board_Info[0][6] . "board/";

	// ===============================================================
	//	= 해당 게시물의 관리자와 작성자 유무 설정 시작
	$bln_Cur_Admin = False;
	$bln_Cur_Writer = False;

	$Sql_Query = "SELECT COUNT(*) AS CNT FROM ".$Tname."b_admin_bd WHERE CONF_SEQ='$int_Ini_Board_Seq' AND MEM_ID='".$arr_Auth[0]."' ";
	$Tmp=mysql_query($Sql_Query);
	$int_Tmp = mysql_result($Tmp,0,CNT);

	If ($arr_Auth[1]>90 || $int_Tmp>0 || ($arr_Auth[3]!=""||$arr_Auth[3]!="00")) {
		$bln_Cur_Admin = True;
		$bln_Cur_Writer = True ;
	}
	//	= 해당 게시물의 관리자와 작성자 유무 설정 종료
	// ===============================================================

	// ===============================================================
	//	= 전체 게시판 유무 확인 시작
	$int_Main_Bd = 0;
	$bln_Main_Bd = False;
	$Sql_Query =	" SELECT
					IFNULL(MIN(CONF_SEQ), 0) AS CONF_SEQ
				FROM "
					.$Tname."b_conf_bd
				WHERE
					CONF_TB_NAME='".$arr_Ini_Board_Info[0][1]."' ";

	$Tmp=mysql_query($Sql_Query);
	$int_Main_Bd=mysql_num_rows($Tmp);

	If ($arr_Ini_Board_Info[0][0]==$int_Main_Bd) {
		$bln_Main_Bd = True;
	}
	$bln_Main_Bd = False;
	//	= 전체 게시판 유무 확인 종료
	// ===============================================================
?>