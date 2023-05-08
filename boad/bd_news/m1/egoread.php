<? include "inc/inc_top.php"; ?>
<? include "inc/ego_comm.php"; ?>
<?
$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd], "");
?>
<? include "inc/ego_bd_ini.php"; ?>
<?
$int_Bd_Seq = Fnc_Om_Conv_Default($_REQUEST[seq], "0");

if ($int_Bd_Seq < 1) {
	echo "<Script Language='JavaScript'>document.location.replace('" . $arr_Ini_Board_Info[0][26] . "egolist.php?bd=" . $int_Ini_Board_Seq . "');</Script>";
	exit;
}

// ===============================
//	= 페이지관련 설정 시작
$str_Pg = Fnc_Om_Conv_Default($_REQUEST[pg], "0");

if ($str_Pg == "0") {
	$int_Cur_Page = 1;
} else {
	$int_Cur_Page = $str_Pg;
}
//	= 페이지관련 설정 종료
// ===============================

// =========================================
//	= 게시판 설정순번 변수에 저장 시작
$Sql_Query = "SELECT CONF_SEQ FROM `" . $Tname . "b_bd_data" . $str_Ini_Group_Table . "` WHERE BD_SEQ=" . $int_Bd_Seq;
$result = mysql_query($Sql_Query);
if (!result) {
	error("QUERY_ERROR");
	exit;
}
$int_Conf_Seq = mysql_result($result, 0, 0);
//	= 게시판 설정순번 변수에 저장 종료
// =========================================

$Sql_Query =	" SELECT
					A.BD_ID_KEY,
					A.BD_IDX,
					A.BD_NOTICE_YN,
					A.MEM_CODE,
					A.MEM_ID,
					A.BD_W_NAME,
					A.BD_W_EMAIL,
					A.BD_W_IP,
					A.BD_TITLE,
					A.BD_CONT,
					A.BD_FORMAT,
					A.BD_THUMB_YN,
					A.BD_OPEN_YN,
					A.BD_REG_DATE,
					A.BD_EDIT_DATE,
					A.BD_DEL_YN,
					A.BD_VIEW_CNT,
					A.BD_GOOD_CNT,
					A.BD_BAD_CNT
				FROM
					`" . $Tname . "b_bd_data" . $str_Ini_Group_Table . "` AS A
				WHERE ";
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//	= 전체 게시판이 아닐때
//	  해당 게시판 목록 출력
if ($bln_Main_Bd == False) {
	$Sql_Query .= " A.CONF_SEQ=" . $int_Conf_Seq . " AND ";
}
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
$Sql_Query .= " A.BD_SEQ=" . $int_Bd_Seq . " AND A.BD_ID_KEY IS NOT NULL ";

$obj_Rlt = mysql_query($Sql_Query);
$rcd_cnt = mysql_num_rows($obj_Rlt);

if ($rcd_cnt) {
	$arr_Get_Data = array();
	while ($row = mysql_fetch_array($obj_Rlt)) {
		array_push($arr_Get_Data, $row);
	}
}

if ($int_Bd_Seq == 0 || is_array($arr_Get_Data) == False) {
	echo "<Script Language='JavaScript'>document.location.replace('egolist.php?bd=" . $int_Conf_Seq . "');</Script>";
	exit;
}

// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//	= 비 공개글일때 관리자와 작성자만 조회 가능 시작
$bln_Flag = False;
if (is_array($arr_Get_Data)) {
	if ($arr_Get_Data[0][12] > 0) {
		if (($arr_Auth[0] == $arr_Get_Data[0][4]) && ($arr_Auth[0] != "")) {
			$bln_Flag = True;
		}

		if ($bln_Flag == False && $bln_Cur_Admin) {
			$bln_Flag = True;
		}

		if ($bln_Flag == False) {
			echo "<Script Language='JavaScript'>alert('비공개 게시물 입니다.');document.location.replace('egolist.php?bd=" . $int_Conf_Seq . "');</Script>";
			exit;
		}
	}
}
//	= 비 공개글일때 관리자와 작성자만 조회 가능 종료
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

// ======================================
//	= 조회수 무한증가 제한 시작
$Sql_Query =	"UPDATE `" . $Tname . "b_bd_data" . $str_Ini_Group_Table . "` SET BD_VIEW_CNT=BD_VIEW_CNT+1 WHERE CONF_SEQ=" . $int_Conf_Seq . " AND BD_SEQ=" . $int_Bd_Seq;
$result = mysql_query($Sql_Query);
$arr_Get_Data[0][16] = $arr_Get_Data[0][16] + 1;
//	= 조회수 무한증가 제한 종료
// ======================================

// ======================================
//	= 검색 시작
$Sql_Add_Query = "";

$int_Itm = Fnc_Om_Conv_Default($_REQUEST[itm], "");
$str_Txt = Fnc_Om_Conv_Default($_REQUEST[txt], "");

if (Is_numeric($int_Itm)) {
	switch ($int_Itm) {
		case 1:
			$str_Itm = "BD_W_NAME";
		case 2:
			$str_Itm = "MEM_ID";
		case 3:
			$str_Itm = "BD_W_EMAIL";
		case 4:
			$str_Itm = "BD_CONT";
		default:
			$str_Itm = "BD_TITLE";
			$int_Itm = "0";
	}

	$Sql_Add_Query =	" AND A." . $str_Itm . " LIKE '%" . $str_Txt . "%' ";
}
//	= 검색 종료
// ======================================

// ================================
//	= 첨부파일정보 배열에 저장 시작
$Sql_Query =	" SELECT
					1 AS TYPE,
					IMG_SEQ AS SEQ,
					IMG_ID_KEY AS SKEY,
					IMG_TITLE AS F_TITLE,
					IMG_CONT AS F_CONT,
					IMG_F_NAME AS F_NAME,
					IMG_F_TYPE AS F_TYPE,
					IMG_F_SIZE AS F_SIZE,
					IMG_DOWN_CNT,
					IMG_F_WIDTH,
					IMG_F_HEIGHT,
					IMG_VIEW_CNT
				FROM
					`" . $Tname . "b_img_data" . $str_Ini_Group_Table . "`
				WHERE
					CONF_SEQ=" . $int_Conf_Seq . "
					AND
					BD_SEQ=" . $int_Bd_Seq . "
				UNION ALL
				SELECT
					0 AS TYPE,
					FILE_SEQ AS SEQ,
					FILE_ID_KEY AS SKEY,
					FILE_TITLE AS F_TITLE,
					FILE_CONT AS F_CONT,
					FILE_F_NAME AS F_NAME,
					FILE_F_TYPE AS F_TYPE,
					FILE_F_SIZE AS F_SIZE,
					FILE_DOWN_CNT,
					0,
					0,
					-1
				FROM
					`" . $Tname . "b_file_data" . $str_Ini_Group_Table . "`
				WHERE
					CONF_SEQ=" . $int_Conf_Seq . "
					AND
					BD_SEQ=" . $int_Bd_Seq;

$arr_File_Data = mysql_query($Sql_Query);
$arr_File_Data_Cnt = mysql_num_rows($arr_File_Data);
//	= 첨부파일정보 배열에 저장 종료
// ================================

// ================================
//	= 메모정보 배열에 저장 시작
$Sql_Query =	" SELECT
					MEMO_SEQ,
					MEM_CODE,
					MEM_ID,
					MEMO_ICON,
					MEMO_W_NAME,
					MEMO_W_EMAIL,
					MEMO_W_IP,
					MEMO_CONT,
					MEMO_REG_DATE
				FROM
					`" . $Tname . "b_memo_data" . $str_Ini_Group_Table . "`
				WHERE
					CONF_SEQ=" . $int_Conf_Seq . "
					AND
					BD_SEQ=" . $int_Bd_Seq . "
				ORDER BY
					MEMO_SEQ DESC ";

$arr_Memo_Data = mysql_query($Sql_Query);
$arr_Memo_Data_Cnt = mysql_num_rows($arr_Memo_Data);
//	= 메모정보 배열에 저장 종료
// ================================

if (Is_Array($arr_Get_Data)) {
	// ================================
	//	= 관련글 배열에 저장 시작
	$Sql_Query =	" SELECT
						BD_SEQ,
						BD_LEVEL,
						BD_TITLE,
						BD_OPEN_YN,
						BD_DEL_YN,
						IFNULL(BD_MEMO_CNT, 0) AS BD_MEMO_CNT,
						BD_REG_DATE
					FROM
						`" . $Tname . "b_bd_data" . $str_Ini_Group_Table . "`
					WHERE
						CONF_SEQ=" . $int_Conf_Seq . "
						AND
						BD_IDX=" . $arr_Get_Data[0][1] . "
						AND
						BD_ID_KEY IS NOT NULL
					ORDER BY
						BD_ORDER DESC ";

	$arr_Reply_Data = mysql_query($Sql_Query);
	$arr_Reply_Data_Cnt = mysql_num_rows($arr_Reply_Data);
	//	= 관련글 배열에 저장 종료
	// ================================

	// ================================
	//	= 이전글 배열에 저장 시작
	$Sql_Query =	" SELECT
						A.BD_SEQ,
						A.BD_IDX,
						A.BD_TITLE,
						A.BD_OPEN_YN,
						A.BD_DEL_YN,
						IFNULL(A.BD_MEMO_CNT, 0) AS BD_MEMO_CNT,
						A.BD_REG_DATE
					FROM
						`" . $Tname . "b_bd_data" . $str_Ini_Group_Table . "` AS A
					WHERE ";

	// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	//	= 전체 게시판이 아닐때
	//	  해당 게시판 목록 출력
	if ($bln_Main_Bd == False) {
		$Sql_Query .= " A.CONF_SEQ=" . $int_Conf_Seq . " AND ";
	}
	// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	$Sql_Query .= " A.BD_IDX<" . $arr_Get_Data[0][1] . "
									AND
									A.BD_LEVEL=0
									AND
									A.BD_ID_KEY IS NOT NULL
									" . $Sql_Add_Query . "
									" . $Sql_Add_Class_Query . "
								ORDER BY
									A.BD_ORDER DESC LIMIT 1 ";

	$arr_Prev_Data = mysql_query($Sql_Query);
	$arr_Prev_Data_Cnt = mysql_num_rows($arr_Prev_Data);
	//	= 이전글 배열에 저장 종료
	// ================================

	// ================================
	//	= 다음글 배열에 저장 시작
	$Sql_Query =	" SELECT
						A.BD_SEQ,
						A.BD_IDX,
						A.BD_TITLE,
						A.BD_OPEN_YN,
						A.BD_DEL_YN,
						IFNULL(A.BD_MEMO_CNT, 0) AS BD_MEMO_CNT,
						A.BD_REG_DATE
					FROM
						`" . $Tname . "b_bd_data" . $str_Ini_Group_Table . "` AS A
					WHERE ";

	// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	//	= 전체 게시판이 아닐때
	//	  해당 게시판 목록 출력
	if ($bln_Main_Bd == False) {
		$Sql_Query .= " A.CONF_SEQ=" . $int_Conf_Seq . " AND ";
	}
	// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	$Sql_Query .= " A.BD_IDX>" . $arr_Get_Data[0][1] . "
									AND
									A.BD_LEVEL=0
									AND
									A.BD_ID_KEY IS NOT NULL
									" . $Sql_Add_Query . "
									" . $Sql_Add_Class_Query . "
								ORDER BY
									A.BD_ORDER ASC LIMIT 1 ";

	$arr_Next_Data = mysql_query($Sql_Query);
	$arr_Next_Data_Cnt = mysql_num_rows($arr_Next_Data);
	//	= 다음글 배열에 저장 종료
	// ================================
}

$str_String = "?bd=" . $int_Ini_Board_Seq . "&itm=" . $int_Itm . "&txt=" . $str_Txt . "&pg=" . $int_Cur_Page;
?>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<SCRIPT LANGUAGE="JavaScript" SRC="ego_ini.html"></SCRIPT>
<style>
	.link_uline {
		text-decoration: underline;
	}

	.link_none {
		text-decoration: none;
	}
</style>
<SCRIPT LANGUAGE="JavaScript">
	<!--
	var int_Doc_Width = '<?= $int_Ini_Table_Width ?>';
	document.write('<L' + 'I' + 'NK rel="stylesheet" HREF="' + gbl_Str_Comm_Path + 'css/egobd.css" TYPE="text/css">');
	document.write('<SCR' + 'I' + 'PT LANGUAGE="JavaScript" SRC="' + gbl_Str_Comm_Path + 'js/egobd/comm.js"><\/SCRIPT>');
	//
	-->
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
	<!--
	var obj_Blank = new Function("x", "return fncCheckBlank(x)");
	var obj_Alert = new Function("x", "y", "z", "return fncFocusAlert(x, y, z)");
	var obj_Byte = new Function("x", "y", "z", "return fncChkByte(x, y, z)");
	var obj_Digit = new Function("x", "return fncCheckDigit(x)");
	var obj_Email = new Function("x", "return fnc_Email_Conf(x)");

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 목록구분 점선으로 분리
		반환값 : str_Devide_Html[라인분리HTML태그]
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Line_Divide() {
		var str_Divide_Html = '';
		str_Divide_Html = '<tr>' +
			'<td colspan="2" style="background-image:url(' + gbl_Str_Comm_Image + 'board/line_dot.gif);">' +
			'</td>' +
			'</tr>';
		return str_Divide_Html;
	}

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 첨부파일 상세정보 출력
		상세설명 : 첨부파일 상세정보 레이어로 출력
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Att_File_Info(pr_Lbl, pr_Title, pr_Cont, pr_File_Name, pr_Down_Cnt, pr_Bd, pr_F_Type, pr_F_Seq, pr_F_Key, pr_F_Ext) {
		var obj_Lbl = eval(pr_Lbl);

		var str_Add_Html = "";
		if ((pr_Title == "") && (pr_Cont == "")) {} else {
			str_Add_Html = '<tr>' +
				'<td bgcolor="white">' +
				'<table border="0" cellpadding="3" cellspacing="0" width="100%">' +
				'<tr>' +
				'<td align="center">' +
				'<img src="' + gbl_Str_Comm_Image + 'board/ic_opinion.gif" align="absMiddle"> ' +
				'<b>' + unescape(pr_Title) + '</b>' +
				'</td>' +
				'</tr>' +
				'<tr>' +
				'<td valign="top">' +
				unescape(pr_Cont) + '<br><br>' +
				'</td>' +
				'</tr>' +
				'</table>' +
				'</td>' +
				'</tr>';
		}

		var str_Html = '<table border="0" cellpadding="0" cellspacing="1" bgcolor="gray" width="300">' +
			'<tr>' +
			'<td>' +
			'<table border="0" cellpadding="3" cellspacing="0" width="100%">' +
			'<tr bgcolor="#6385BC">' +
			'<td style="FONT-FAMILY:돋움;FONT-SIZE:9pt;font-weight:bold;color:white;">' +
			'<img src="' + gbl_Str_Comm_Image + 'board/ic_disk.gif" align="absMiddle"> ' +
			unescape(pr_File_Name) +
			'</td>' +
			'<td align="right">' +
			'<img src="' + gbl_Str_Comm_Image + 'board/ic_delete.gif" align="absMiddle" style="cursor:hand;" onclick="fnc_Close_Lbl(\'' + pr_Lbl + '\');" alt="close"> ' +
			'</td>' +
			'</tr>' +
			'</table>' +
			'</td>' +
			'</tr>' +
			'<tr>' +
			'<td><table border="0" cellpadding="3" cellspacing="0" width="100%"><tr bgcolor="#FFFFCC">' +
			'<td width="50%">' +
			'다운로드횟수 : ' + pr_Down_Cnt +
			'</td>' +
			'<td align="right" width="50%">' +
			'<b><a href="egofiledown.php?bd=' + pr_Bd + '&ftype=' + pr_F_Type + '&fseq=' + pr_F_Seq + '&key=' + pr_F_Key + '" class="lnk0"><img src="' + pr_F_Ext + '" align="absMiddle" border="0"> download</b>' +
			'</td>' +
			'</tr></table></td>' +
			'</tr>' +
			str_Add_Html +
			'</table>';
		with(obj_Lbl) {
			style.posTop = event.clientY + document.body.scrollTop;
			style.posLeft = event.clientX + document.body.scrollLeft;
			//style.posTop = 0+document.body.scrollTop;
			//style.posLeft = 0+document.body.scrollLeft;
			style.zIndex = 100;
			style.display = "";
			innerHTML = str_Html;
		}
	}

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 첨부파일 상세정보 출력창 닫기
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Close_Lbl(pr_Lbl) {
		var obj_Lbl = eval(pr_Lbl);
		var str_Html = "";
		with(obj_Lbl) {
			style.zIndex = 0;
			style.display = "none";
			innerHTML = str_Html;
		}
	}

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 해당 문서 수정, 삭제
		삭제 : mode=0
		수정 : mode=1
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Send_Data(pr_Form, int_Type) {
		var obj_Form = pr_Form;
		var str_Move_Page = "";

		if (!obj_Blank(obj_Form.txt_Mem_Id.value)) {
			if (typeof(obj_Form.txt_Pwd) == "object") {
				if (!obj_Blank(obj_Form.txt_Pwd.value))
					return obj_Alert(obj_Form.txt_Pwd, null, "글 암호를 입력하세요.");
			}
		}

		if (int_Type > 0)
			str_Move_Page = 'egowrite.php';
		else
			str_Move_Page = 'egodelete.php';

		if (int_Type == 0) {
			if (confirm("글을 삭제하시면 첨부파일과 메모글까지 삭제됩니다\n\n정말로 삭제하시겠습니까?") == false)
				return false;
		}

		obj_Form.mode.value = int_Type;

		obj_Form.method = "post";
		obj_Form.action = str_Move_Page;
		obj_Form.submit();
	}

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 메모글쓰기
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Save_Memo(pr_Form) {
		var obj_Form = pr_Form;
		var int_Byte = 0;

		if (!obj_Blank(obj_Form.txt_Memo_Name.value))
			return obj_Alert(obj_Form.txt_Memo_Name, null, "이름을 입력하세요.");

		int_Byte = obj_Byte(obj_Form.txt_Memo_Name, null, 20);
		if (int_Byte > 20)
			return obj_Alert(obj_Form.txt_Memo_Name, null, "이름은 20 Byte이상 입력할 수 없습니다.\n\n현재 : " + int_Byte + " Byte");

		if (obj_Blank(obj_Form.txt_Memo_Email.value)) {
			if (!obj_Email(obj_Form.txt_Memo_Email.value))
				return obj_Alert(obj_Form.txt_Memo_Email, null, "올바른 이메일 형식이 아닙니다.");
		}

		if (!obj_Blank(obj_Form.mtx_Memo_Cont.value))
			return obj_Alert(obj_Form.mtx_Memo_Cont, null, "글내용을 입력하세요");

		int_Byte = obj_Byte(obj_Form.mtx_Memo_Cont, null, 1000);
		if (int_Byte > 1000)
			return obj_Alert(obj_Form.mtx_Memo_Cont, null, "글내용은 1000 Byte이상 입력할 수 없습니다.\n\n현재 : " + int_Byte + " Byte");

		if (typeof(obj_Form.txt_Memo_Pwd) == "object") {
			if (!obj_Blank(obj_Form.txt_Memo_Pwd.value))
				return obj_Alert(obj_Form.txt_Memo_Pwd, null, "비밀번호를 입력하세요.");

			if ((obj_Form.txt_Memo_Pwd.value.length) < 4)
				return obj_Alert(obj_Form.txt_Memo_Pwd, null, "비밀번호는 4자 이상 입력하셔야 합니다.");
		}

		obj_Form.method = "post";
		obj_Form.action = "egomemo.php";
		obj_Form.submit();
	}


	function fnc_Memo_Del(pr_Form, pr_Id, pr_Idx) {
		var obj_Form = pr_Form;
		var str_Seq = "";
		var str_Pwd = "";

		if (typeof(obj_Form.txt_Memo_Del_Seq.length) != "undefined") {
			str_Seq = obj_Form.txt_Memo_Del_Seq[parseInt(pr_Idx)].value;
			if (pr_Id == "") {
				if (typeof(obj_Form.txt_Memo_Del_Pwd) == "object") {
					if (!obj_Blank(obj_Form.txt_Memo_Del_Pwd[parseInt(pr_Idx)].value))
						return obj_Alert(obj_Form.txt_Memo_Del_Pwd[parseInt(pr_Idx)], null, "글암호를 입력하세요.");

					str_Pwd = obj_Form.txt_Memo_Del_Pwd[parseInt(pr_Idx)].value;
				}
			}
		} else {
			str_Seq = obj_Form.txt_Memo_Del_Seq.value;
			if (pr_Id == "") {
				if (typeof(obj_Form.txt_Memo_Del_Pwd) == "object") {
					if (!obj_Blank(obj_Form.txt_Memo_Del_Pwd.value) && pr_Id == "")
						return obj_Alert(obj_Form.txt_Memo_Del_Pwd, null, "글암호를 입력하세요.");

					str_Pwd = obj_Form.txt_Memo_Del_Pwd.value;
				}
			}
		}

		obj_Form.txt_Memo_Real_Seq.value = str_Seq;
		obj_Form.txt_Memo_Real_Pwd.value = str_Pwd;

		if (confirm("선택한 메모를 삭제하시겠습니까?") == false) {
			return false;
		}

		obj_Form.method = "post";
		obj_Form.action = "egomemodel.php";
		obj_Form.submit();
	}

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 이미지 출력 브라우저
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Img_View(p_Bd, p_Seq, p_Key, p_Width, p_Height) {
		var int_Sys_Width = screen.width - 20;
		var int_Sys_Height = screen.height - 60;
		var int_View_Width = p_Width;
		var int_View_Height = p_Height;
		var str_Scrollbar = 'no';

		if (p_Width > int_Sys_Width) {
			int_View_Width = int_Sys_Width;
			str_Scrollbar = 'yes';

		}
		if (p_Height > int_Sys_Height) {
			int_View_Height = int_Sys_Height;
			str_Scrollbar = 'yes';
		}

		obj_Win = window.open('', 'imgviewer', 'top=0,left=0,width=' + int_View_Width + ',height=' + int_View_Height + ',location=no,scrollbars=' + str_Scrollbar);
		if (obj_Win != null) {
			obj_Win.document.write('<html><head>');
			obj_Win.document.write('<title>IMAGE</title>');
			obj_Win.document.write('</head><body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">');
			obj_Win.document.write('<a href="javascript:self.close();"><img src="egofiledata.php?bd=' + p_Bd + '&iseq=' + p_Seq + '&ikey=' + p_Key + '" border="0"></a>');
			obj_Win.document.write('</body></html>');
		}
	}

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 기술원 메인 게시물로 등록
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Add_Main(pr_Form, pr_Type) {
		var obj_Form = pr_Form;
		obj_Form.txt_Wait.value = pr_Type;
		var str_Tmp = '등록';
		if (parseInt(pr_Type) > 0)
			str_Tmp = '대기';


		if (confirm("\"" + str_Tmp + "\" 상태로 변경하시겠습니까?")) {
			obj_Form.method = "post";
			obj_Form.action = "egomainadd.php";
			obj_Form.submit();
		}
	}
	//
	-->
</SCRIPT>

<link href="css/detail.css" rel="stylesheet" type="text/css" id="cssLink" />

<!-- Header -->
<div class="header">
	<a href="javascript:history.back()" class="return-btn">
		<svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M6.41475 14.2576L0.202765 7.81002C0.129032 7.73327 0.0769276 7.65012 0.0464514 7.56057C0.0154837 7.47102 0 7.37507 0 7.27273C0 7.17038 0.0154837 7.07444 0.0464514 6.98489C0.0769276 6.89534 0.129032 6.81218 0.202765 6.73543L6.41475 0.268649C6.58679 0.0895498 6.80184 0 7.05991 0C7.31797 0 7.53917 0.0959463 7.7235 0.287839C7.90783 0.479731 8 0.703606 8 0.959463C8 1.21532 7.90783 1.43919 7.7235 1.63109L2.30415 7.27273L7.7235 12.9144C7.89555 13.0935 7.98157 13.314 7.98157 13.576C7.98157 13.8385 7.8894 14.0657 7.70507 14.2576C7.52074 14.4495 7.30568 14.5455 7.05991 14.5455C6.81413 14.5455 6.59908 14.4495 6.41475 14.2576Z" fill="#333333" />
		</svg>
	</a>
	<p class="title">NEWS LETTER</p>
</div>

<div class="body-section">
	<div class="header-section">
		<p class="title"><?= stripslashes($arr_Get_Data[0][8]) ?></p>
		<p class="description"><?= str_replace("-", ".", substr($arr_Get_Data[0][13], 0, 10)) ?></p>
	</div>

	<!-- 알람 -->
	<div class="content">
		<?
		$str_Tmp = Fnc_Conv_View(stripslashes($arr_Get_Data[0][9]), $arr_Get_Data[0][10]);

		$str_Tmp = js_escape($str_Tmp);
		?>
		<SCRIPT LANGUAGE="JavaScript">
			document.write(unescape('<?= $str_Tmp ?>'));
		</SCRIPT>
		<div class="notification-section">
			<div class="header-section">
				<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M7.5 0.000128502C9.48913 0.000128502 11.3967 0.790269 12.8033 2.19678C14.2099 3.6033 15 5.51105 15 7.50006C15 9.48908 14.2099 11.3968 12.8033 12.8033C11.3968 14.2099 9.48903 15 7.5 15C5.51097 15 3.60327 14.2099 2.19668 12.8033C0.790148 11.3968 2.52514e-07 9.48908 2.52514e-07 7.50006C0.00213476 5.5116 0.79304 3.60529 2.19905 2.19903C3.60519 0.793033 5.51142 0.00212144 7.50013 0L7.5 0.000128502ZM7.5 12.0001C7.69889 12.0001 7.88974 11.9211 8.03037 11.7804C8.17099 11.6397 8.24997 11.449 8.24997 11.2501C8.24997 11.0511 8.17099 10.8604 8.03037 10.7198C7.88974 10.5791 7.6989 10.5 7.5 10.5C7.3011 10.5 7.11026 10.5791 6.96964 10.7198C6.82901 10.8604 6.75003 11.0511 6.75003 11.2501C6.75003 11.449 6.82901 11.6397 6.96964 11.7804C7.11026 11.9211 7.3011 12.0001 7.5 12.0001ZM6.75003 9.00012C6.75003 9.26806 6.89292 9.51566 7.12495 9.64963C7.35699 9.7836 7.64301 9.7836 7.87505 9.64963C8.10709 9.51566 8.24997 9.26806 8.24997 9.00012V3.74987C8.24997 3.48193 8.10708 3.23433 7.87505 3.10036C7.64302 2.96638 7.357 2.96638 7.12495 3.10036C6.89291 3.23433 6.75003 3.48193 6.75003 3.74987V9.00012Z" fill="#333333" />
				</svg>
				<p class="title">꼭 확인해주세요</p>
			</div>
			<div class="notification-list">
				<?php
				for ($i = 0; $i < 5; $i++) {
				?>
					<p class="item">­­・본 이벤트는 2023.01부터 2023.02까지 진행됩니다.</p>
				<?php
				}
				?>
			</div>
		</div>
	</div>

	<!-- 관련 상품 -->
	<div class="relation-section">
		<p class="title">관련 상품</p>
		<div class="relation-product-list">
			<?php
			for ($i = 0; $i < 4; $i++) {
			?>
				<div class="global-product-item">
					<div class="image">
						<img src="../images/mockup/product1.png" alt="">
						<div class="tag discount">
							<p class="value">20%</p>
						</div>
					</div>
					<p class="brand">CHANEL</p>
					<p class="title">가브리엘 스몰 백팩</p>
					<div class="price-section">
						<p class="current-price">일 35,920원</p>
						<p class="origin-price">35,920원</p>
					</div>
				</div>
			<?php
			}
			?>
		</div>
	</div>
</div>

<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php"; ?>