<? include "inc/inc_top.php"; ?>
<? include "inc/ego_comm.php"; ?>
<?
$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd], "");
?>
<? include "inc/ego_bd_ini.php"; ?>
<?
// ==================================================
//	= 새글표시를 위한 날짜값 설정 시작

$Sql_Query = " SELECT IFNULL(MAX(DTM_REG_DATE), NOW()) AS MAX_DATE FROM `" . $Tname . "comm_review`";
$obj_Rlt = mysql_query($Sql_Query);

$arr_New_Date = array();
while ($row = mysql_fetch_array($obj_Rlt)) {
	array_push($arr_New_Date, $row);
}
//	= 새글표시를 위한 날짜값 설정 종료
// ==================================================

// ===============================
//	= 페이지관련 설정 시작
$int_Page_Size		= $arr_Ini_Board_Info[0][17];					// @@@@@@ 한 페이지에 출력될 목록수 설정
$int_Page_Size		= 20;
$int_Out_Page_Cnt	= $arr_Ini_Board_Info[0][18];					// @@@@@@ 출력할 페이지 갯수 설정

$int_Total_Page = 0;
$int_Total_Cnt = 0;

$str_Pg = Fnc_Om_Conv_Default($_REQUEST[pg], "1");

//	= 페이지관련 설정 종료
// ===============================

// ======================================
//	= 검색 시작
$int_Itm = Fnc_Om_Conv_Default($_REQUEST[itm], "");
$str_Txt = Fnc_Om_Conv_Default($_REQUEST[txt], "");

if (Is_Numeric($int_Itm)) {
	switch ($int_Itm) {
		case "1":
			$str_Itm = "A.STR_CONTENT";
			break;
		case "2":
			$str_Itm = "A.STR_USERID";
			break;
		case "3":
			$str_Itm = "B.STR_EMAIL";
			break;
		case "4":
			$str_Itm = "A.STR_CONTENT";
			break;
		default:
			$str_Itm = "A.STR_CONTENT";
			$int_Itm = "0";
			break;;
	}

	$Sql_Add_Query = "AND " . $str_Itm . " LIKE '%" . $str_Txt . "%' ";
}
//	= 검색 종료
// ======================================

$Sql_Query =	" SELECT
					COUNT(A.INT_NUMBER)
				FROM 
					`" . $Tname . "comm_review` AS A
				LEFT JOIN 
					`" . $Tname . "comm_member` AS B
				ON
					A.STR_USERID=B.STR_USERID
				LEFT JOIN 
					`" . $Tname . "comm_goods_master` AS C
				ON
					A.STR_GOODCODE=C.STR_GOODCODE
				WHERE ";

$Sql_Query .= " A.INT_NUMBER IS NOT NULL ";
$Sql_Query .= $Sql_Add_Query;

$arr_Get_Data = mysql_query($Sql_Query);

$int_Total_Cnt = mysql_result($arr_Get_Data, 0, 0);

if (!$int_Total_Cnt) {
	$first = 1;
	$last = 0;
} else {
	$first = $int_Page_Size * ($str_Pg - 1);
	$last = $int_Page_Size * $str_Pg;

	$IsNext = $int_Total_Cnt - $last;
	if ($IsNext > 0) {
		$last -= 1;
	} else {
		$last = $int_Total_Cnt - 1;
	}
}
$int_Total_Page = ceil($int_Total_Cnt / $int_Page_Size);

$f_limit = $first;
$l_limit = $last + 1;

$Sql_Query =	"SELECT
					A.*, B.STR_NAME, C.STR_GOODNAME
				FROM 
					`" . $Tname . "comm_review` AS A
				LEFT JOIN 
					`" . $Tname . "comm_member` AS B
				ON
					A.STR_USERID=B.STR_USERID
				LEFT JOIN 
					`" . $Tname . "comm_goods_master` AS C
				ON
					A.STR_GOODCODE=C.STR_GOODCODE
				WHERE ";

$Sql_Query .= " A.INT_NUMBER IS NOT NULL ";
$Sql_Query .= $Sql_Add_Query;
$Sql_Query .= " ORDER BY A.DTM_EDIT_DATE DESC ";
$Sql_Query .= "limit $f_limit,$l_limit";

$arr_Get_Data = mysql_query($Sql_Query);
if (!$arr_Get_Data) {
	error("QUERY_ERROR");
	exit;
}
$arr_Get_Data_Cnt = mysql_num_rows($arr_Get_Data);

$int_St_Num = (($str_Pg - 1) / $int_Out_Page_Cnt * $int_Out_Page_Cnt) + 1;		//' @@@@@@ 페이지 리스트 출력 초기 페이지 값 설정
$str_String = "?bd=" . $int_Ini_Board_Seq . "&itm=" . $int_Itm . "&txt=" . urlencode($str_Txt) . "&pg=";
$str_Url = "egolist.php" . $str_String;
?>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<SCRIPT LANGUAGE="JavaScript" SRC="ego_ini.html"></SCRIPT>
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

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 목록구분 점선으로 분리
		반환값 : str_Devide_Html[라인분리HTML태그]
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Line_Divide() {
		var str_Divide_Html = '';
		str_Divide_Html = '<tr>' +
			'<td colspan="20" style="background-image:url(' + gbl_Str_Comm_Image + 'board/line_dot.gif);">' +
			'</td>' +
			'</tr>';
		return str_Divide_Html;
	}

	function fnc_Send_Data(pr_Form) {
		var obj_Form = pr_Form;
		var obj_Txt = obj_Form.txt;
		var regSchChk = /[^\w@\s.ㄱ-힣]/;

		if (!obj_Blank(obj_Txt.value))
			return obj_Alert(obj_Txt, null, "검색어를 입력하세요.");

		if (regSchChk.test(obj_Txt.value))
			return obj_Alert(obj_Txt, null, "@ . 이외의 기호는 사용하실 수 없습니다.");
	}

	function fnc_Del_Bd(pr_Form) {
		var obj_Form = pr_Form;

		var int_I = 0;
		var obj = document.getElementsByName("seq[]");

		if (typeof(obj.length) != "undefined") {
			for (var i = 0; i < obj.length; i++) {
				if (obj[i].checked == true)
					int_I += 1;
			}
		} else {
			if (obj.checked == true)
				int_I += 1;
		}

		if (int_I == 0) {
			alert("삭제할 데이터를 선택해 주세요");
		} else {
			if (confirm("선택한 데이터를 삭제하시겠습니까?")) {
				obj_Form.method = "post";
				obj_Form.action = "egodelete.php";
				obj_Form.submit();
			}
		}
	}

	function fnc_All_Chk(pr_Form) {
		var obj_Form = pr_Form;
		try {
			var obj = document.getElementsByName("seq[]");

			if (typeof(obj.length) != "undefined") {
				for (var i = 0; i < obj.length; i++) {
					if (obj[i].checked == false)
						obj[i].checked = true;
					else
						obj[i].checked = false;
				}
			} else {
				if (obj.checked == false)
					obj.checked = true;
				else
					obj.checked = false;
			}
		} catch (e) {}
	}

	function fnc_stamp(str_userid) {
		if (!confirm("스탬프를 지급하시겠습니까?")) return;

		fuc_ajax('egostamp.php?str_userid=' + str_userid);
		alert("지급되었습니다.")
	}
	//
	-->
</SCRIPT>
<? include "inc/inc_mid.php"; ?>
<table border="0" cellpadding="0" cellspacing="0" width="<?= $int_Ini_Table_Width ?>">
	<tr>
		<td>
			<table width=100%>
				<tr>
					<td class=pageInfo>페이지 : <b><?= $int_Total_Page ?></b> / <?= $str_Pg ?>&nbsp;&nbsp;&nbsp;글수 : <?= $int_Total_Cnt ?></td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="td150" style="table-layout:fixed">
				<tr>
					<td class=rnd colspan=9></td>
				</tr>
				<tr class=rndbg>
					<th><a href="javascript:fnc_All_Chk(document.frm_List);"><img src="<?= $str_Board_Icon_Img ?>ic_chk.gif" align="absMiddle" border="0"></a></th>
					<th>번호</th>
					<th>상품</th>
					<th>내용</th>
					<th>만족도</th>
					<th>작성자</th>
					<th>작성일자</th>
					<th>조회수</th>
				</tr>
				<tr>
					<td class=rnd colspan=9></td>
				</tr>
				<col width=5% align=center>
				<col width=5% align=center>
				<col width=20% align=center>
				<col width=41% align=center>
				<col width=10% align=center>
				<col width=10% align=center>
				<col width=10% align=center>
				<col width=10% align=center>

				<?
				for ($int_I = 0; $int_I < $arr_Get_Data_Cnt; $int_I++) {
				?>
					<tr height=30 align="center">
						<td align="center">
							<input type="checkbox" name="seq" value="<?= mysql_result($arr_Get_Data, $int_I, 'INT_NUMBER') ?>" style="border:0px;">
						</td>
						<td align="center">
							<b>
								<font color="#000000" style="font-size:8pt;"><?= $int_I + 1 ?></font>
							</b>
						</td>
						<td align="center">
							<?= mysql_result($arr_Get_Data, $int_I, 'STR_GOODNAME') ?>
						</td>
						<td style="word-break:break-all; overflow: hidden;white-space: nowrap;text-overflow: ellipsis;" nowrap align="left">
							<?= strip_tags(mysql_result($arr_Get_Data, $int_I, 'STR_CONTENT')) ?>
						</td>
						<td align="center">
							<?= mysql_result($arr_Get_Data, $int_I, 'INT_STAR') ?>
						</td>
						<td align="center" nowrap>
							<?= mysql_result($arr_Get_Data, $int_I, 'STR_NAME') ?>
						</td>
						<td align="center">
							<?= mysql_result($arr_Get_Data, $int_I, 'DTM_REG_DATE') ?>
						</td>
						<td align="center">
							<?= mysql_result($arr_Get_Data, $int_I, 'INT_VIEW') ?>
						</td>
					</tr>
					<tr><td colspan=9 class=rndline></td></tr>
				<?php
				}
				?>
			</table>

			<table border="0" cellpadding="3" cellspacing="0" width="100%">
				<form name="frm_List">
					<input type="hidden" name="bd" value="<?= $int_Ini_Board_Seq ?>">
					<input type="hidden" name="mode" value="99">
					<tr height="32">
						<td align="right">
							<a href="egolist.php?bd=<?= $int_Ini_Board_Seq ?>"><img src="<?= $str_Board_Icon_Img ?>btn_list.gif" border="0" align="absMiddle" alt="reload"></a>
							<?= Fnc_Output_Page_Num($int_Total_Page, $str_Pg, $int_Out_Page_Cnt, $int_St_Num, $str_Url) ?>
						</td>
					</tr>
					<tr height="32">
						<td align="right">
							<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<? if ($int_Total_Cnt != 0 && $bln_Cur_Admin) { ?>
											<a href="javascript:fnc_Del_Bd(document.frm_List);"><img src="<?= $str_Board_Icon_Img ?>btn_delete.gif" align="absMiddle" border="0"></a>
										<? } ?>
										&nbsp;
									</td>
									<td valign="bottom">
										<select name="itm" size="1" style="font-size:8pt;">
											<option value="0" <? if ($int_Itm == "0") { ?> selected<? } ?>>글제목</option>
											<option value="1" <? if ($int_Itm == "1") { ?> selected<? } ?>>작성자</option>
											<option value="2" <? if ($int_Itm == "2") { ?> selected<? } ?>>아이디</option>
											<option value="3" <? if ($int_Itm == "3") { ?> selected<? } ?>>이메일</option>
											<option value="4" <? if ($int_Itm == "4") { ?> selected<? } ?>>글내용</option>
										</select>
									</td>
									<td valign="bottom"><input type="text" class="input_basic" name="txt" size="10" maxlength="20" value="<?= $str_Txt ?>"></td>
									<td valign="middle"><input type="image" src="<?= $str_Board_Icon_Img ?>btn_search.gif" align="absMiddle" border="0" style="border:0px;"></td>
								</tr>
							</table>
						</td>
					</tr>
				</form>
			</table>
		</td>
	</tr>
</table>
<? include "inc/inc_btm.php"; ?>