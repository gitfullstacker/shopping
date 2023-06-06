<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "INSERT");
$page = Fnc_Om_Conv_Default($_REQUEST['page'], 1);
$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");

if ($RetrieveFlag == "UPDATE") {

	$SQL_QUERY =	'SELECT
						A.*
					FROM 
						' . $Tname . 'comm_cal AS A
					WHERE
						A.INT_NUMBER=' . $str_no;

	$arr_Rlt_Data = mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
}
?>
<html>

<head>
	<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php"; ?>
	<script type="text/javascript" src="/_lib/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
	<script language="javascript" src="js/calendar_edit.js"></script>
</head>

<body class=scroll>
	<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
		<tr>
			<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_logo_info.php"; ?>
			<td width=100%>
				<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu_info.php"; ?>
			</td>
		</tr>
		<tr>
			<td colspan="3"><? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu.php"; ?></td>
		</tr>
		<tr>
			<td valign=top id=leftMenu>
				<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_lmenu_info.php"; ?>
			</td>
			<td colspan=2 valign=top height=100%>
				<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_stitle_info.php"; ?>
				<table width=100%>
					<tr>
						<td style="padding:10px">
							<div class="title title_top"><?= Fnc_Om_Loc_Name("01" . $arr_Auth[7]); ?></div>

							<form id="frm" name="frm" target="_self" method="POST" action="calendar_edit.php">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="str_no" value="<?= $str_no ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="str_dimage" value="<?= $arr_Data['STR_IMAGE'] ?>">
								<input type="hidden" name="Obj">

								<table class=tb>
									<col class=cellC style="width:12%">
									<col class=cellL style="padding-left:10px;width:88%">
									<tr>
										<td>제목</td>
										<td colspan="3">
											<input type="text" name="str_title" value="<?= $arr_Data['STR_TITLE'] ?>" style="width:400px;">
										</td>
									</tr>
									<tr>
										<td>기간</td>
										<td colspan="3">
											<select name="int_period">
												<option value="1" <?= $arr_Data['INT_PERIOD'] == 1 ? 'selected' : '' ?>>한번</option>
												<option value="2" <?= $arr_Data['INT_PERIOD'] == 2 ? 'selected' : '' ?>>매주/매월</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>형식</td>
										<td colspan="3">
											<select name="int_type" onchange="handleType(this.value)">
												<option value="1" <?= $arr_Data['INT_TYPE'] == 1 ? 'selected' : '' ?>>일</option>
												<option value="2" <?= $arr_Data['INT_TYPE'] == 2 ? 'selected' : '' ?>>날짜</option>
												<option value="3" <?= $arr_Data['INT_TYPE'] == 3 ? 'selected' : '' ?>>요일</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>해당일</td>
										<td colspan="3">
											<input type="number" name="str_day" id="str_day" value="$arr_Data['STR_DAY']" style="display: <?= ($arr_Data['INT_TYPE'] ?: 1) == 1 ? 'block' : 'none' ?>;">
											<input type="date" name="str_date" id="str_date" value="$arr_Data['STR_DATE']" style="display: <?= $arr_Data['INT_TYPE'] == 2 ? 'block' : 'none' ?>;">
											<select name="str_week" id="str_week" style="display: <?= $arr_Data['INT_TYPE'] == 3 ? 'block' : 'none' ?>;">
												<option value="0" <?= $arr_Data['STR_WEEK'] == 0 ? 'selected' : '' ?>>일요일</option>
												<option value="1" <?= $arr_Data['STR_WEEK'] == 1 ? 'selected' : '' ?>>월요일</option>
												<option value="2" <?= $arr_Data['STR_WEEK'] == 2 ? 'selected' : '' ?>>화요일</option>
												<option value="3" <?= $arr_Data['STR_WEEK'] == 3 ? 'selected' : '' ?>>수요일</option>
												<option value="4" <?= $arr_Data['STR_WEEK'] == 4 ? 'selected' : '' ?>>목요일</option>
												<option value="5" <?= $arr_Data['STR_WEEK'] == 5 ? 'selected' : '' ?>>금요일</option>
												<option value="6" <?= $arr_Data['STR_WEEK'] == 6 ? 'selected' : '' ?>>토요일</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>선택불가형식</td>
										<td colspan="3">
											<select name="int_dtype">
												<option value="1" <?= $arr_Data['INT_DTYPE'] == 1 ? 'selected' : '' ?>>시작불가</option>
												<option value="2" <?= $arr_Data['INT_DTYPE'] == 2 ? 'selected' : '' ?>>반납불가</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>출력유무</td>
										<td colspan=3>
											<input type="radio" value="Y" name="str_service" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_SHOW_MAIN'], "Y") == "Y") { ?>checked<? } ?>> 출력
											<input type="radio" value="N" name="str_service" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_SHOW_MAIN'], "Y") == "N") { ?>checked<? } ?>> 미출력
										</td>
									</tr>
									<? if ($RetrieveFlag == "UPDATE") { ?>
										<tr>
											<td>등록일자</td>
											<td colspan=3 class=noline>
												<?= $arr_Data['DTM_INDATE'] ?>
											</td>
										</tr>
									<? } ?>
								</table>

								<div class=button>
									<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<? if ($RetrieveFlag == "INSERT") { ?>register<? } else { ?>modify<? } ?>.gif"></a>
									<a href='calendar_list.php'><img src='/admincenter/img/btn_list.gif'></a>
								</div>
							</form>

							<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_btip_info.php"; ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td height=3 bgcolor="#E6E6E6" colspan=2></td>
		</tr>
		<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_copyright_info.php"; ?>
	</table>
	<script>
		table_design_load();
	</script>
</body>

</html>