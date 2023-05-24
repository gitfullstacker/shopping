<? include "inc/inc_top.php"; ?>
<? include "inc/ego_comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd], "");
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode], "");
?>
<? include "inc/ego_bd_ini.php"; ?>
<?
$int_Bd_Seq = Fnc_Om_Conv_Default($_REQUEST[seq], "");	// --- 선택한 게시물 순번

// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//	= 읽기 전용 게시판이라면 관리자 이외의 글쓰기 거부 시작
if ($arr_Ini_Board_Info[0][8] < 2) {
	if ($bln_Cur_Writer == False) {
		echo "<Script Language='JavaScript'>alert('글 작성 권한이 없습니다.');document.location.replace('egolist.php?bd=$int_Ini_Board_Seq');</Script>";
		exit;
	}
}
//	= 읽기 전용 게시판이라면 관리자 이외의 글쓰기 거부 종료
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

// ==========================================
//	= 수정, 답글쓰기 관련 설정값 변수에 저장 시작
$int_Mode = Fnc_Om_Conv_Default($_REQUEST[mode], "0");  // --- int_Mode [0:신규글작성, 1:글수정, 2:답변글쓰기]
$str_String = Fnc_Om_Conv_Default($_REQUEST[txt_String], "");
$str_Doc_Pwd = Fnc_Om_Conv_Default($_REQUEST[txt_Pwd], "");

if ($str_String == "") {
	$str_String = "?" . $loc_I_Pg_Dstr;
}
//	= 수정, 답글쓰기 관련 설정값 변수에 저장 종료
// ==========================================

// ============================================================
//	= 답변 글쓰기가 불가능한 게시판이라면 답글쓰기 거부 시작
if ($int_Mode == 2 && $arr_Ini_Board_Info[0][9] == 0) {
	echo "<Script Language='JavaScript'>alert('답글쓰기가 불가능한 게시판 입니다.');document.location.replace('egolist.php?bd=$int_Ini_Board_Seq');</Script>";
	exit;
}
//	= 답변 글쓰기가 불가능한 게시판이라면 답글쓰기 거부 종료
// ============================================================

// ===============================
//	= 잘못 등록된 파일 및 데이터 삭제 시작

$Sql_Query = " SELECT
					1 AS TYPE,
					A.IMG_SEQ AS SEQ,
					A.IMG_F_NICK AS F_NICK,
					B.CONF_SEQ,
					B.CONF_TB_NAME,
					B.CONF_ATT_URL
				FROM
					`" . $Tname . "b_img_data" . $str_Ini_Group_Table . "` AS A
					LEFT JOIN
					" . $Tname . "b_conf_bd AS B
					ON
					A.CONF_SEQ=B.CONF_SEQ
				WHERE
					DATE_ADD(NOW(), INTERVAL -5 HOUR) > A.IMG_REG_DATE
					AND
					A.BD_SEQ=0
				UNION ALL
				SELECT
					0 AS TYPE,
					A.FILE_SEQ AS SEQ,
					A.FILE_F_NICK AS F_NICK,
					B.CONF_SEQ,
					B.CONF_TB_NAME,
					B.CONF_ATT_URL
				FROM
					`" . $Tname . "b_file_data" . $str_Ini_Group_Table . "` AS A
					LEFT JOIN
					" . $Tname . "b_conf_bd AS B
					ON
					A.CONF_SEQ=B.CONF_SEQ
				WHERE
					DATE_ADD(NOW(), INTERVAL -5 HOUR) > A.FILE_REG_DATE
					AND
					A.BD_SEQ=0 ";


$arr_Del_File = mysql_query($Sql_Query);
$arr_Del_File_Cnt = mysql_num_rows($arr_Del_File);

if ($arr_Del_File_Cnt) {
	for ($int_I = 0; $int_I < $arr_Del_File_Cnt; $int_I++) {
		// =======================================================
		//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 시작
		if (mysql_result($arr_Del_File, $int_I, TYPE) == "0") {
			$str_Db_Type = "FILE";
		} else {
			$str_Db_Type = "IMG";
		}
		//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 종료
		// =======================================================


		$Temp = mysql_result($arr_Del_File, $int_I, CONF_ATT_URL) . mysql_result($arr_Del_File, $int_I, CONF_SEQ) . "/";
		$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'] . $Temp;
		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_Del_File, $int_I, F_NICK));

		$Sql_Query = "DELETE FROM `" . $Tname . "b_" . $str_Db_Type . "_data" . $str_Ini_Group_Table . "` WHERE " . $str_Db_Type . "_SEQ=" . mysql_result($arr_Del_File, $int_I, SEQ);
		$result = mysql_query($Sql_Query);
	}
}
//	= 잘못 등록된 파일 및 데이터 삭제 종료
// ===============================

// ===============================
//	= 잘못 등록된 게시물 삭제 시작
$Sql_Query =	" DELETE FROM `" . $Tname . "b_bd_data" . $str_Ini_Group_Table . "` WHERE BD_ID_KEY IS NULL AND BD_IDX IS NULL AND DATE_ADD(NOW(), INTERVAL -1 HOUR) > BD_REG_DATE ";
$result = mysql_query($Sql_Query);
//	= 잘못 등록된 게시물 삭제 종료
// ===============================

// =========================================
//	유일키값 생성 시작
$str_Id_Key = Fnc_Om_Id_Key_Create();	//' --- 유일한 키값 생성
//	유일키값 생성 종료
// =========================================

// =========================================
//	= 전체 게시판 유무 확인 시작
if ($bln_Main_Bd) {
	if ($int_Bd_Seq > 0) {
		$Sql_Query = "SELECT CONF_SEQ FROM `" . $Tname . "b_bd_data" . $str_Ini_Group_Table . "` WHERE BD_SEQ=" . $int_Bd_Seq;
		$result = mysql_query($Sql_Query);
		$int_Ini_Board_Seq = mysql_result($result, 0, CONF_SEQ);
	} else {
		$int_Ini_Board_Seq = $int_Main_Bd;
	}
}
//	= 전체 게시판 유무 확인 종료
// =========================================

// =================================================
//	= 글수정일경우 배열에 데이터 저장 시작
if ($int_Bd_Seq > 0) {
	$Sql_Query =	" SELECT
						A.BD_SEQ,
						A.CONF_SEQ,
						A.BD_ID_KEY,
						A.BD_IDX,
						A.BD_ORDER,
						A.BD_LEVEL,
						A.BD_NOTICE_YN,
						A.MEM_CODE,
						A.MEM_ID,
						A.BD_W_NAME,
						A.BD_W_EMAIL,
						A.BD_W_IP,
						A.BD_TITLE,
						A.BD_CONT,
						A.BD_PWD,
						A.BD_FORMAT,
						A.BD_THUMB_YN,
						A.BD_OPEN_YN,
						A.BD_DEL_YN,
						A.BD_ITEM1,
						A.BD_ITEM2,
						B.STR_GOODNAME
					FROM `"
		. $Tname . "b_bd_data" . $str_Ini_Group_Table . "` AS A LEFT JOIN `" . $Tname . "comm_goods_master` AS B ON A.BD_ITEM1=B.STR_GOODCODE
					WHERE A.CONF_SEQ=" . $int_Ini_Board_Seq . " AND A.BD_SEQ=" . $int_Bd_Seq;

	$obj_Rlt = mysql_query($Sql_Query);
	$rcd_cnt = mysql_num_rows($obj_Rlt);

	if ($rcd_cnt) {
		$arr_Get_Data = array();
		while ($row = mysql_fetch_array($obj_Rlt)) {
			array_push($arr_Get_Data, $row);
		}
	}

	if (is_array($arr_Get_Data)) {
		$bln_Flag = True;
	}
}
//	= 글수정일경우 배열에 데이터 저장 종료
// =================================================

// ============================================
//	= 글 수정 및 답변 글쓰기 정보 변수에 저장 시작
$int_Re_Idx = 0;
$int_Re_Order = 0;
$int_Re_Level = 0;
$str_Title = "";
$str_Cont = "";
$int_Format = 0;

switch ($int_Mode) {
	case 1:	// @@@ 글수정
		if ($arr_Get_Data[0][8] == "" && $bln_Cur_Admin == False) {
			if ($arr_Get_Data[0][14] == $str_Doc_Pwd) {
				$bln_Cur_Writer = True;
			} else {
				echo "<Script Language='JavaScript'>alert('암호가 일치하지 않습니다.');document.location.replace(document.referrer);</Script>";
				$bln_Cur_Writer = False;
				exit;
			}
		} elseif ($arr_Get_Data[0][8] != "" && $bln_Cur_Admin == False) {
			if ($arr_Get_Data[0][8] == $arr_Auth[0]) {
				$bln_Cur_Writer = True;
			} else {
				echo "<Script Language='JavaScript'>alert('글 작성자만 글수정이 가능합니다.');document.location.replace(document.referrer);</Script>";
				$bln_Cur_Writer = False;
				exit;
			}
		}
		break;
	case 2:	// @@@ 답변글쓰기
		$int_Re_Idx = $arr_Get_Data[0][3];
		$int_Re_Order = $arr_Get_Data[0][4];
		$int_Re_Level = $arr_Get_Data[0][5];
		$str_Title = "[Re]" . stripslashes($arr_Get_Data[0][12]);
		$str_Cont = $arr_Get_Data[0][13];
		$int_Format = $arr_Get_Data[0][15];
		$bln_Flag = False;
		break;
	default:
		$bln_Flag = False;
		break;
}
//	= 글 수정 및 답변 글쓰기 정보 변수에 저장 종료
// ============================================

// ============================================
//	= 신규 글등록일때 배열에 값 설정 시작
if ($bln_Flag == False) {
	$arr_Get_Data[0][21] = array();
	$arr_Get_Data[0][0] = 0;
	$arr_Get_Data[0][1] = $int_Ini_Board_Seq;
	$arr_Get_Data[0][2] = $str_Id_Key;
	$arr_Get_Data[0][3] = $int_Re_Idx;
	$arr_Get_Data[0][4] = $int_Re_Order;
	$arr_Get_Data[0][5] = $int_Re_Level;
	$arr_Get_Data[0][6] = 0;
	$arr_Get_Data[0][7] = "";
	$arr_Get_Data[0][8] = "";
	$arr_Get_Data[0][9] = "";
	$arr_Get_Data[0][10] = "";
	$arr_Get_Data[0][11] = "";
	$arr_Get_Data[0][12] = $str_Title;
	$arr_Get_Data[0][13] = "";
	$arr_Get_Data[0][14] = "";
	$arr_Get_Data[0][15] = 0;
	$arr_Get_Data[0][16] = $int_Ini_Img_Prev;
	$arr_Get_Data[0][17] = 1;
	$arr_Get_Data[0][18] = 0;
	$arr_Get_Data[0][19] = $str_goodcode;
	$arr_Get_Data[0][20] = "1";
	$arr_Get_Data[0][21] = "";

	if ($arr_Auth[0] != "") {
		$arr_Get_Data[0][8] = $arr_Auth[0];
	}
	if ($arr_Auth[2] != "") {
		$str_Tmp = $arr_Auth[2];
		if ($gbl_U_Info_Nick != "") {
			$str_Tmp = $gbl_U_Info_Nick;
		}
		$arr_Get_Data[0][9] = $str_Tmp;
	}
	if ($arr_Auth[6] != "") {
		$arr_Get_Data[0][10] = $arr_Auth[6];
	}
}
//	= 신규 글등록일때 배열에 값 설정 종료
// ============================================
?>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<SCRIPT LANGUAGE="JavaScript" SRC="ego_ini.html"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
	var int_Doc_Width = '<?= $int_Ini_Table_Width ?>';
	var str_Deny_File = '<?= Trim($arr_Ini_Board_Info[0][13]) ?>';
	var str_String = '<?= $str_String ?>';
	var str_Cur_Path = '<?= substr($gbl_Cur_Path_Page, 0, strrpos($gbl_Cur_Path_Page, "/") + 1) ?>';
	document.write('<L' + 'I' + 'NK rel="stylesheet" HREF="' + gbl_Str_Comm_Path + 'css/egobd.css" TYPE="text/css">');
	document.write('<SCR' + 'I' + 'PT LANGUAGE="JavaScript" SRC="' + gbl_Str_Comm_Path + 'js/egobd/comm.js"><\/SCRIPT>');
	document.write('<SCR' + 'I' + 'PT LANGUAGE="JavaScript" SRC="' + gbl_Str_Comm_Path + 'editor/editor.js"><\/SCRIPT>');
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
	var obj_Blank = new Function("x", "return fncCheckBlank(x)");
	var obj_Alert = new Function("x", "y", "z", "return fncFocusAlert(x, y, z)");
	var obj_Byte = new Function("x", "y", "z", "return fncChkByte(x, y, z)");
	var obj_Digit = new Function("x", "return fncCheckDigit(x)");
	var obj_Email = new Function("x", "return fnc_Email_Conf(x)");

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 입력 라인 점선으로 분리
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
		기능설명 : 입력 취소
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Eb_Cancel(pr_Form) {
		var obj_Form = pr_Form;
		var int_Bd = obj_Form.bd.value;

		var str_Ref = document.referrer;
		var str_Move_Page = "";

		if (str_Ref == "")
			str_Move_Page = 'egolist.php';
		else
			str_Move_Page = str_Ref.substring(str_Ref.lastIndexOf("/") + 1, str_Ref.lastIndexOf(".php") + 4)

		if (str_Move_Page.indexOf("ego") < 0)
			str_Move_Page = 'egolist.php';

		var str_Param = "";
		try {
			if (str_String != "")
				str_Param = str_String;
			else
				str_Param = location.search;

			if (str_Param == "")
				str_Param = '?bd=' + obj_Form.bd.value;
		} catch (e) {}
		document.location.replace(str_Move_Page + str_Param);
	}

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 폼 전송
		반환값 : true | false[전송|거부]
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Eb_Send(pr_Form) {
		var tmpType = null;
		var str_Send_Html = "";
		var int_Byte = 0;
		var obj_Form = pr_Form;

		if (!obj_Blank(obj_Form.txt_Name.value))
			return obj_Alert(obj_Form.txt_Name, null, "이름을 입력하세요.");

		if (!obj_Blank(obj_Form.mtx_Content.value))
			return obj_Alert(obj_Form.txt_Name, null, "리뷰를 입력하세요.");

		obj_Form.method = "post";
		obj_Form.encoding = "multipart/form-data";
		obj_Form.target = "_self";
		obj_Form.action = "egosave.php";
		obj_Form.submit();
	}

	/* +++++++++++++++++++++++++++++++++++++++++++ *\
		기능 : 첨부 이미지 저장/수정/삭제
	\* +++++++++++++++++++++++++++++++++++++++++++ */
	function fnc_Image_Save(pr_Form, pr_Lbl, pr_Sel, pr_Type) {
		var obj_Form = document.forms[pr_Form];
		var obj_Sel = obj_Form.elements[pr_Sel];
		var int_Type = parseInt(pr_Type);

		if (pr_Type < 2) {
			//if((obj_Form.fil_File_Data.disabled==true) && (int_Type==0))
			if ((document.getElementById('fil_File_Data').disabled == true) && (int_Type == 0)) {
				alert("현재 편집모드 입니다.\n\n선택취소를 선택 하신 후 이미지를 등록하세요.");
				return false;
			}

			if ((int_Type == 1) && (obj_Form.txt_File_Idx.value == "")) {
				alert("수정할 파일이 선택되지 않았습니다.");
				return false;
			}

			var int_Byte = 0;
			int_Byte = obj_Byte(obj_Form.txt_File_Subject, null, 200);
			if (int_Byte > 200)
				return obj_Alert(obj_Form.txt_File_Subject, null, "이미지 제목은 200 Byte이상 입력할 수 없습니다.\n\n현재 : " + int_Byte + " Byte");

			int_Byte = obj_Byte(obj_Form.mtx_File_Content, null, 500);
			if (int_Byte > 500)
				return obj_Alert(obj_Form.mtx_File_Content, null, "이미지 설명은 500 Byte이상 입력할 수 없습니다.\n\n현재 : " + int_Byte + " Byte");

			//if(!obj_Blank(obj_Form.fil_File_Data.value) && (int_Type==0))
			if (!obj_Blank(document.getElementById('fil_File_Data').value) && (int_Type == 0))
				return obj_Alert(obj_Form.fil_File_Data, null, "이미지 파일이 선택되지 않았습니다.");

			//var str_File_Name = obj_Form.fil_File_Data.value;
			var str_File_Name = document.getElementById('fil_File_Data').value;
			str_File_Name = str_File_Name.substring(str_File_Name.lastIndexOf("\\") + 1, str_File_Name.length);

			// @@@@@@ 등록 거부 파일 등록거부 처리 시작
			var arr_Deny_File = str_Deny_File.split(",");
			var str_File_Ext = "";
			if (str_File_Name.indexOf('.') > -1) {
				var str_File_Ext = str_File_Name.substring(str_File_Name.lastIndexOf('.') + 1, str_File_Name.length);
			}

			try {
				for (var int_I = 0; i < arr_Deny_File.length; i++) {
					if ((str_File_Ext == arr_Deny_File[int_I]) && (arr_Deny_File[int_I] != "")) {
						alert(str_Deny_File + " 파일은 등록하실 수 없습니다.");
						return false;
					}
				}
			} catch (e) {}
			// 등록 거부 파일 등록거부 처리 종료 @@@@@@

			var str_Pattern = /[\\/:*?\"<>|%]/;
			if (str_Pattern.test(str_File_Name)) {
				alert("파일이름에 \\ / : * ? \" < > | % 문자는 올 수 없습니다.");
				return false;
			}
		} else {
			if (obj_Sel.options.selectedIndex < 0) {
				alert("삭제할 파일을 선택하세요.");
				return false;
			}

			if ((obj_Sel.options[obj_Sel.options.selectedIndex].value) == "") {
				alert("등록된 파일이 존재하지 않습니다.");
				return false;
			}

			var str_Img_Data = obj_Sel.options[obj_Sel.options.selectedIndex].text;

			if (confirm((obj_Sel.options.selectedIndex + 1) + " 번째 \"" + str_Img_Data + "\" 파일을 삭제하시겠습니까?") == false)
				return false;
		}

		obj_Form.txt_Forms.value = pr_Lbl + "|" + pr_Form + "|" + pr_Sel;

		var obj_Lbl = eval(pr_Lbl);
		with(obj_Lbl) {
			style.posTop = event.clientY + document.body.scrollTop;
			style.posLeft = event.clientX + document.body.scrollLeft;
			style.zIndex = 100;
			style.display = "";
		}

		var str_Url = '';
		var str_Enc_Type = '';
		switch (pr_Type) {
			case 0:
				intFrmWidth = 160;
				intFrmHeight = 80;
				str_Enc_Type = "multipart/form-data";
				str_Url = 'egofilesave.php';
				break
			case 1:
				intFrmWidth = 0;
				intFrmHeight = 0;
				str_Enc_Type = "application/x-www-form-urlencoded";
				str_Url = 'egofileedit.php';
				break
			case 2:
				intFrmWidth = 0;
				intFrmHeight = 0;
				str_Enc_Type = "application/x-www-form-urlencoded";
				str_Url = 'egofiledel.php';
				break;
			default:
				break;
		}

		var str_Add_Frame = '';
		if (parseInt(pr_Type) == 0) {
			str_Add_Frame = '<iframe src="egofileprogress.html" width="' + intFrmWidth + '" height="' + intFrmHeight + '" frameborder="0" scrolling="no"></iframe>';
			intFrmWidth = 0;
			intFrmHeight = 0;
		}

		obj_Lbl.innerHTML = '<iframe name="lbl_Image_Iframe" id="lbl_Image_Iframe_Id" src="about:blank" width="' + intFrmWidth + '" height="' + intFrmHeight + '" frameborder="0" scrolling="no"></iframe>' + str_Add_Frame;

		//obj_Lbl.innerHTML = '<iframe name="lbl_Image_Iframe" id="lbl_Image_Iframe_Id" src="about|blank" width="'+intFrmWidth+'" height="'+intFrmHeight+'" frameborder="0" scrolling="no"></iframe>';

		obj_Form.method = "post";
		obj_Form.encoding = str_Enc_Type;
		obj_Form.target = "lbl_Image_Iframe";
		obj_Form.action = str_Url;
		obj_Form.submit();

		document.frm_File.reset();
	}

	/* +++++++++++++++++++++++++++++++++++++++++++ *\
		기능 : 선택한 파일 수정모드로 변환 또는 취소
	\* +++++++++++++++++++++++++++++++++++++++++++ */
	function fnc_File_Edit_Mode(pr_Obj_Form_Name, pr_Str_Lbl_Name, pr_Int_Type) {
		var obj_Form = pr_Obj_Form_Name;
		var obj_Sel = obj_Form.sel_Att_File;
		var obj_Lbl = eval(pr_Str_Lbl_Name);
		var str_Value = "";
		var arr_Img_Info;

		if (pr_Int_Type > 0) {
			if (obj_Sel.selectedIndex < 0) {
				alert("수정할 파일을 선택하세요.");
				return false;
			}
			if (obj_Sel[obj_Sel.options.selectedIndex].value == "") {
				alert("첨부 파일을 등록하세요.");
				return false;
			}

			str_Value = obj_Sel.options[obj_Sel.options.selectedIndex].value;

			arr_Img_Info = str_Value.split("|");

			int_File_Type = arr_Img_Info[6];
			obj_Form.txt_File_Type.value = int_File_Type;

			obj_Form.txt_File_Idx.value = unescape(arr_Img_Info[0]);
			obj_Form.txt_File_Subject.value = unescape(arr_Img_Info[3]);
			obj_Form.mtx_File_Content.value = unescape(arr_Img_Info[4]);
			obj_Lbl.innerHTML = '<input type="hidden" name="fil_File_Data" id="fil_File_Data" size="0" disabled><img src="' + gbl_Str_Comm_Image + 'board/ic_file.gif" align="absMiddle">&nbsp;' + unescape(arr_Img_Info[5]);
		} else {
			obj_Form.txt_File_Idx.value = "";
			obj_Form.txt_File_Type.value = "";
			obj_Form.txt_File_Subject.value = "";
			obj_Form.mtx_File_Content.value = "";
			obj_Lbl.innerHTML = '<input type="file" class="input_basic" name="fil_File_Data" id="fil_File_Data" size="52">';
		}
	}

	function fnc_Edit_Append(pr_Obj_Form, pr_Sel_Name, pr_Txt_Desc) {
		var obj_Form = pr_Obj_Form;
		var obj_Sel = pr_Obj_Form.elements[pr_Sel_Name];

		if (obj_Sel.selectedIndex < 0) {
			alert("에디터에 등록할 파일을 선택하세요.");
			return false;
		}
		if (obj_Sel[obj_Sel.selectedIndex].value == "") {
			alert("파일을 등록하세요.");
			return false;
		}
		var str_Value = obj_Sel[obj_Sel.selectedIndex].value;
		var arr_Value = str_Value.split("|");
		var int_Img = parseInt(arr_Value[6]);

		if (int_Img > 0) {
			obj_Form.elements[pr_Txt_Desc].value = arr_Value[0] + "|" + arr_Value[1] + "|" + arr_Value[3] + "|" + arr_Value[5] + "|" + arr_Value[6] + "|" + arr_Value[8] + "|" + arr_Value[9] + "|" + str_Cur_Path;
			fncSetConvert(3, obj_Form, pr_Txt_Desc);
		} else
			alert("등록할 수 없는 파일입니다.");
	}

	function handleFileChange(event) {
		const image_input = event.target;
		const files = image_input.files;
		const image_names = document.getElementById('image_names');
		const image_preview = document.getElementById('image_preview');
		image_preview.innerHTML = '';

		if (files.length > 0) {
			for (let i = 0; i < files.length; i++) {
				const file = files[i];
				image_names.value += file.name + ', ';

				const reader = new FileReader();
				reader.onload = function(e) {
					const imageContainer = document.createElement('div');
					imageContainer.classList.add('image-container');

					const image = new Image();
					image.src = e.target.result;
					image.classList.add('preview-image');

					const deleteButton = document.createElement('button');
					deleteButton.innerHTML = `
                        <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.208 2.976L0 0.636001L0.648 0L2.856 2.34L5.064 0L5.712 0.636001L3.504 2.976L5.712 5.316L5.064 5.952L2.856 3.612L0.648 5.952L0 5.316L2.208 2.976Z" fill="white"/>
                        </svg>
                    `;
					deleteButton.classList.add('delete-button');
					deleteButton.addEventListener('click', function() {
						imageContainer.remove();
						const remainingFiles = [...image_input.files].filter((_, index) => index !== i);
						const newFileList = new DataTransfer();
						remainingFiles.forEach(file => newFileList.items.add(file));
						image_input.files = newFileList.files;
						image_names.value = [...image_input.files].map(file => file.name).join(', ');
					});

					imageContainer.appendChild(image);
					imageContainer.appendChild(deleteButton);
					image_preview.appendChild(imageContainer);
				};
				reader.readAsDataURL(file);
			}
		} else {
			image_names.value = '';
		}
	}
</SCRIPT>

<form name="frm_Send" class="mt-[30px] flex flex-col w-full px-[14px]">
	<input type="hidden" name="txt_Forms">
	<input type="hidden" name="mode" value="<?= $int_Mode ?>">
	<input type="hidden" name="txt_String" value="<?= $str_String ?>">
	<input type="hidden" name="seq" value="<?= $arr_Get_Data[0][0] ?>">
	<input type="hidden" name="bd" value="<?= $arr_Get_Data[0][1] ?>">
	<input type="hidden" name="txt_Id_Key" value="<?= $arr_Get_Data[0][2] ?>">
	<input type="hidden" name="txt_Idx" value="<?= $arr_Get_Data[0][3] ?>">
	<input type="hidden" name="txt_Order" value="<?= $arr_Get_Data[0][4] ?>">
	<input type="hidden" name="txt_Level" value="<?= $arr_Get_Data[0][5] ?>">
	<input type="hidden" name="txt_Mem_Code" value="<?= $arr_Get_Data[0][7] ?>">
	<input type="hidden" name="txt_Mem_Id" value="<?= $arr_Get_Data[0][8] ?>">
	<input type="hidden" name="str_goodcode" value="<?= $arr_Get_Data[0][19] ?>">
	<input type="hidden" name="chk_Pre_View" value="<?= $arr_Get_Data[0][16] ?>">

	<input type="hidden" name="txt_Name" value="<?= $arr_Get_Data[0][9] ?>">
	<input type="hidden" name="txt_Subject" value="This product review.">

	<?
	$SQL_QUERY = "SELECT
					A.*,B.STR_CODE AS STR_BRAND
				FROM 
				" . $Tname . "comm_goods_master AS A
				LEFT JOIN
					" . $Tname . "comm_com_code AS B
				ON
					A.INT_BRAND=B.INT_NUMBER
				WHERE
					A.STR_GOODCODE='" . $arr_Get_Data[0][19] . "' ";

	$arr_Rlt_Data = mysql_query($SQL_QUERY);

	if (!$arr_Rlt_Data) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	?>

	<div class="flex justify-center">
		<p class="font-extrabold text-lg leading-[20px] text-black">평점/리뷰 작성</p>
	</div>

	<div class="mt-[14px] flex gap-[11px]">
		<div class="flex justify-center items-center w-[120px] h-[120px] bg-[#F9F9F9] p-2.5">
			<img src="/admincenter/files/good/<?= $arr_Data['STR_IMAGE1'] ?>" alt="">
		</div>
		<div class="grow flex flex-col justify-center">
			<div class="w-[34px] h-[18px] flex justify-center items-center bg-[<?= ($arr_Data['INT_TYPE'] == 1 ? '#EEAC4C' : ($arr_Data['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
				<p class="font-normal text-[10px] leading-[10px] text-center text-white"><?= ($arr_Data['INT_TYPE'] == 1 ? '구독' : ($arr_Data['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?></p>
			</div>
			<p class="mt-1.5 font-bold text-[15px] leading-[17px] text-black"><?= $arr_Data['STR_BRAND'] ?></p>
			<p class="mt-[2px] font-bold text-xs leading-[14px] text-[#666666]"><?= $arr_Data['STR_GOODNAME'] ?></p>
			<p class="mt-[9px] font-bold text-xs leading-[14px] text-[#999999]">기간: 2023.02.10 ~ 2023.02.13</p>
			<p class="mt-[3px] font-bold text-xs leading-[14px] text-black"><?= number_format($arr_Data['INT_PRICE']) ?>원</p>
		</div>
	</div>

	<hr class="mt-[23px] border-t-[0.5px] border-[#E0E0E0]" />

	<div class="mt-[23px] flex flex-col items-center w-full gap-[23px]">
		<div class="flex flex-col items-center w-full gap-2">
			<p class="font-bold text-xs leading-[14px] text-black">별점을 선택해주세요.</p>
			<div x-data="{ star: 5 }" class="flex justify-center gap-2 items-center">
				<input type="hidden" name="txt_item2" x-bind:vaue="star">
				<svg width="162" height="27" viewBox="0 0 162 27" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M17.7482 10.19H28.0382L19.6682 16.4L22.8482 26.24L14.4482 20.33L5.89822 26.24L9.10822 16.4L0.678223 10.19H11.1782L14.4482 0.440002L17.7482 10.19Z" x-bind:fill="star >= 1 ? '#FFD748' : '#DDDDDD'" x-on:click="star = 1" />
					<path d="M51.0529 10.19H61.3429L52.9729 16.4L56.1529 26.24L47.7529 20.33L39.2029 26.24L42.4129 16.4L33.9829 10.19H44.4829L47.7529 0.440002L51.0529 10.19Z" x-bind:fill="star >= 2 ? '#FFD748' : '#DDDDDD'" x-on:click="star = 2" />
					<path d="M84.3576 10.19H94.6476L86.2776 16.4L89.4576 26.24L81.0576 20.33L72.5076 26.24L75.7176 16.4L67.2876 10.19H77.7876L81.0576 0.440002L84.3576 10.19Z" x-bind:fill="star >= 3 ? '#FFD748' : '#DDDDDD'" x-on:click="star = 3" />
					<path d="M117.662 10.19H127.952L119.582 16.4L122.762 26.24L114.362 20.33L105.812 26.24L109.022 16.4L100.592 10.19H111.092L114.362 0.440002L117.662 10.19Z" x-bind:fill="star >= 4 ? '#FFD748' : '#DDDDDD'" x-on:click="star = 4" />
					<path d="M150.967 10.19H161.257L152.887 16.4L156.067 26.24L147.667 20.33L139.117 26.24L142.327 16.4L133.897 10.19H144.397L147.667 0.440002L150.967 10.19Z" x-bind:fill="star >= 5 ? '#FFD748' : '#DDDDDD'" x-on:click="star = 5" />
				</svg>
			</div>
			<hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
		</div>
		<div class="flex flex-col items-center w-full">
			<p class="font-bold text-xs leading-[14px] text-black">이용하신 가방에 만족하시나요?</p>
			<div x-data="{ grade: 1 }" class="mt-[15px] flex gap-8 items-center justify-center">
				<div class="flex flex-col items-center gap-1.5" x-on:click="grade = 1">
					<div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 1 ? 'border-black': 'border-none'">
						<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 1 ? 'black' : 'white'" />
						</svg>
					</div>
					<p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
				</div>
				<div class="flex flex-col items-center gap-1.5" x-on:click="grade = 2">
					<div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 2 ? 'border-black': 'border-none'">
						<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 2 ? 'black' : 'white'" />
						</svg>
					</div>
					<p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
				</div>
				<div class="flex flex-col items-center gap-1.5" x-on:click="grade = 3">
					<div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 3 ? 'border-black': 'border-none'">
						<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 3 ? 'black' : 'white'" />
						</svg>
					</div>
					<p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
				</div>
			</div>
			<hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
		</div>
		<div class="flex flex-col items-center w-full">
			<p class="font-bold text-xs leading-[14px] text-black">상품의 포장상태에 만족하시나요?</p>
			<div x-data="{ grade: 1 }" class="mt-[15px] flex gap-8 items-center justify-center">
				<div class="flex flex-col items-center gap-1.5" x-on:click="grade = 1">
					<div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 1 ? 'border-black': 'border-none'">
						<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 1 ? 'black' : 'white'" />
						</svg>
					</div>
					<p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
				</div>
				<div class="flex flex-col items-center gap-1.5" x-on:click="grade = 2">
					<div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 2 ? 'border-black': 'border-none'">
						<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 2 ? 'black' : 'white'" />
						</svg>
					</div>
					<p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
				</div>
				<div class="flex flex-col items-center gap-1.5" x-on:click="grade = 3">
					<div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 3 ? 'border-black': 'border-none'">
						<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 3 ? 'black' : 'white'" />
						</svg>
					</div>
					<p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
				</div>
			</div>
			<hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
		</div>
		<div class="flex flex-col items-center w-full">
			<p class="font-bold text-xs leading-[14px] text-black">상품의 배송에 만족하시나요?</p>
			<div x-data="{ grade: 1 }" class="mt-[15px] flex gap-8 items-center justify-center">
				<div class="flex flex-col items-center gap-1.5" x-on:click="grade = 1">
					<div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 1 ? 'border-black': 'border-none'">
						<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 1 ? 'black' : 'white'" />
						</svg>
					</div>
					<p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
				</div>
				<div class="flex flex-col items-center gap-1.5" x-on:click="grade = 2">
					<div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 2 ? 'border-black': 'border-none'">
						<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 2 ? 'black' : 'white'" />
						</svg>
					</div>
					<p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
				</div>
				<div class="flex flex-col items-center gap-1.5" x-on:click="grade = 3">
					<div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 3 ? 'border-black': 'border-none'">
						<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 3 ? 'black' : 'white'" />
						</svg>
					</div>
					<p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
				</div>
			</div>
			<hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
		</div>

		<div class="mt-[23px] flex flex-col gap-[5px] w-full">
			<p class="font-bold text-xs leading-[14px] text-black">상품 리뷰를 남겨주세요</p>
			<textarea class="w-full h-[300px] border border-solid border-[#DDDDDD] px-4 py-5 font-bold text-xs leading-[19px] placeholder:text-[#999999]" name="mtx_Content" placeholder="꿀팁 가득, 상세한 리뷰를 작성해보세요!
도움수가 올라가면 탑리뷰어가 될 확률도 높아져요!
반품, 환불 관련 내용은 고객센터 1:1 문의로 별도 문의해주세요."></textarea>
		</div>

		<div class="flex flex-col gap-[5px] w-full">
			<div id="image_preview" class="grid grid-cols-3 w-full gap-1.5"></div>
			<p class="font-bold text-xs leading-[14px] text-black">이미지 첨부</p>
			<div class="flex gap-[5px]">
				<div class="grow flex flex-col gap-2.5">
					<input type="file" class="hidden" name="fil_File_Data[]" id="image_input" onchange="handleFileChange(event)" multiple />
					<input type="text" class="grow h-[45px] border border-solid border-[#DDDDDD] px-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" id="image_names" readonly>
					<p class="font-bold text-[10px] leading-[15px] text-[#999999]">이미지 파일(JPG, PNG, GIF)를 기준으로 최대 10MB이하,
						최대 3개까지 등록가능합니다.</p>
				</div>
				<div class="flex w-[97px]">
					<button type="button" class="flex justify-center items-center w-[97px] h-[45px] bg-[#EBEBEB] border border-solid border-[#DDDDDD]" onclick="document.getElementById('image_input').click();">
						<p class="font-bold text-xs leading-[14px] text-center text-[#666666]">사진첨부</p>
					</button>
				</div>
			</div>
		</div>

		<!-- 구분 -->
		<hr class="mt-1.5 border-t-[0.5] border-[#E0E0E0] w-full" />

		<div class="mt-1 flex w-full bg-[#F5F5F5] px-[9px] py-[15px]">
			<p class="font-bold text-[10px] leading-[14px] text-black"></p>
			<p class="font-bold text-[10px] leading-[16px] text-[#999999]">
				-사진 후기 100원, 글 후기 50원 적립금이 지급됩니다.<br />
				-작성 시 기준에 맞는 적립금이 자동으로 지급됩니다.<br />
				-등급에 따라 차등으로 적립 혜택이 달라질 수 있습니다.<br />
				-주간 베스트 후기로 선정 시 5,000원이 추가로 적립됩니다.<br />
				-후기 작성은 배송완료일로부터 30일 이내 가능합니다.<br />
			</p>
		</div>

		<div class="mt-[30px] flex gap-[5px] w-full">
			<button type="button" class="flex justify-center items-center border border-solid border-[#DDDDDD] bg-white w-full h-[45px]">
				<p class="font-bold text-xs leading-[14px] text-[#666666]" onclick="fnc_Eb_Cancel(document.frm_Send);">취소</p>
			</button>
			<button type="button" class="flex justify-center items-center border border-solid border-[#DDDDDD] bg-black w-full h-[45px]">
				<p class="font-bold text-xs leading-[14px] text-white" onclick="fnc_Eb_Send(document.frm_Send);">작성</p>
			</button>
		</div>
	</div>
</form>

<form name="frm_File">
	<input type="hidden" name="txt_Forms">
	<input type="hidden" name="mode" value="<?= $int_Mode ?>">
	<input type="hidden" name="txt_String" value="<?= $str_String ?>">
	<input type="hidden" name="seq" value="<?= $arr_Get_Data[0][0] ?>">
	<input type="hidden" name="bd" value="<?= $arr_Get_Data[0][1] ?>">
	<input type="hidden" name="txt_Id_Key" value="<?= $arr_Get_Data[0][2] ?>">
	<input type="hidden" name="txt_Idx" value="<?= $arr_Get_Data[0][3] ?>">
	<input type="hidden" name="txt_Order" value="<?= $arr_Get_Data[0][4] ?>">
	<input type="hidden" name="txt_Level" value="<?= $arr_Get_Data[0][5] ?>">
	<input type="hidden" name="txt_Mem_Code" value="<?= $arr_Get_Data[0][7] ?>">
	<input type="hidden" name="txt_Mem_Id" value="<?= $arr_Get_Data[0][8] ?>">
	<input type="hidden" name="str_goodcode" value="<?= $arr_Get_Data[0][19] ?>">
	<input type="hidden" name="chk_Pre_View" value="<?= $arr_Get_Data[0][16] ?>">

	<div class="t_cover01 mt10">
		<table class="t_type">
			<colgroup>
				<col />
				<col style="width:270px;" />
			</colgroup>
			<? if ($int_Ini_File_Att > 0) { ?>
				<div id="lbl_File_Add_Brow" style="display:none;position:absolute;"></div>
				<input type="hidden" name="txt_File_Idx" value="">
				<input type="hidden" name="txt_File_Type" value="">
				<input type="hidden" name="txt_File_Desc" value="">
				<tr>
					<th>파일선택</th>
					<td id="lbl_File_Re_Write">
						<div class="file_bx_add01">
							<div class="file_bx">
								<input type="file" class="inp w100p" name="fil_File_Data" id="fil_File_Data" />
							</div>
							<textarea class="textarea" name="mtx_File_Content" class="border_1" wrap="soft" cols="67" rows="2" style="display:none;"></textarea>
							<p>
								<span class="btn btn_bk btn_m w100p" align="absMiddle" style="cursor:pointer;" onclick="fnc_Image_Save('frm_File', 'lbl_File_Add_Brow', 'sel_Att_File', 0);">파일등록</span>
							</p>
						</div>
					</td>
				</tr>
				<tr style="display:none;">
					<th>file name</th>
					<td><input name="txt_File_Subject" type="text" style="width:265px;" class="board_input"></td>
				</tr>
				<tr>
					<th>첨부리스트</th>
					<td>
						<div class="add_file_bx">
							<select name="sel_Att_File" size="3" style="width:100%;">
								<option value="">== The attached file does not exist.</option>
							</select>
							<p><span class="btn btn_bk btn_m w100p" align="absMiddle" style="cursor:pointer; vertical-align:top;" onclick="fnc_Image_Save('frm_File', 'lbl_File_Add_Brow', 'sel_Att_File', 2);">파일삭제</span></p>
						</div>
					</td>
				</tr>
				<?
				// ==========================================
				//	= 이미지 멀티콤보박스 재 설정 시작
				$str_Tmp = "lbl_File_Add_Brow|frm_Send|sel_Att_File";
				$arr_Tmp = explode("|", $str_Tmp);
				fnc_Image_Cbo_Re_Set($arr_Tmp, $arr_Get_Data[0][2], $str_Ini_Group_Table);
				//	= 이미지 멀티콤보박스 재 설정 시작
				// ==========================================

				// ==========================================
				//	현재 파일 사용량 확인 시작
				$int_Cur_File_Size = fnc_Use_File_Size($str_Ini_Group_Table, $arr_Get_Data[0][2]);
				//	현재 파일 사용량 확인 종료
				// ==========================================
				?>
				<tr>
					<th>파일사용량</th>
					<td><span id="lbl_File_Use_Graph"></span></td>
				</tr>
				<?
				// ==========================================
				//	= 파일 사용량 출력 시작
				// fnc_File_Use_Graph("lbl_File_Use_Graph", $int_Ini_Perm_File_Size, $int_Cur_File_Size);
				fnc_File_Use_Graph("lbl_File_Use_Graph", 1024 * 1024 * 2, $int_Cur_File_Size);
				//	= 파일 사용량 출력 종료
				// ==========================================
				?>
			<? } ?>
			</tbody>
		</table>
	</div>
	<div class="btn_w mt15" style="padding-bottom:15px;">
		<p class="f_left"><a href="#;" class="btn btn_l btn_ylw f_bd w100p" style="cursor:pointer;" onclick="fnc_Eb_Send(document.frm_Send, 'mtx_Content');">확인</a></p>
		<p class="f_right"><a href="#;" class="btn btn_l btn_bk f_bd w100p" style="cursor:pointer;" onclick="fnc_Eb_Cancel(document.frm_Send);">취소</a></p>
	</div>
</form>

<? include "inc/inc_btm.php"; ?>

<link rel="stylesheet" href="/m/css/radio_style.css" type="text/css">
<script type="text/javascript" src="/m/js/custom.forms.jquery.js"></script>
<script type="text/javascript">
	$(function() {
		$('form').customForm();
	});
</script>

<link rel="styleSheet" href="/css/sumoselect.css">
<script type="text/javascript" src="/js/custominputfile.min.js"></script>
<script type="text/javascript">
	$('#fil_File_Data').custominputfile({
		theme: 'blue-grey',
		//icon : 'fa fa-upload'
	});
	$('#demo-2').custominputfile({
		theme: 'red',
		icon: 'fa fa-file'
	});
</script>

<style>
	.preview-image {
		max-width: 100%;
		max-height: 100%;
	}

	.delete-button {
		position: absolute;
		top: 0;
		right: 0;
		width: 14px;
		height: 14px;
		background-color: black;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.image-container {
		position: relative;
		display: flex;
		justify-content: center;
		align-items: center;
		border: 0.72px solid #DDDDDD;
	}
</style>