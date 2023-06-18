<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "INSERT");
$page = Fnc_Om_Conv_Default($_REQUEST['page'], 1);
$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], "1");

if ($RetrieveFlag == "UPDATE") {

	$SQL_QUERY =	'SELECT
						A.*
					FROM 
						' . $Tname . 'comm_event AS A
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
	<script language="javascript" src="js/event_edit.js"></script>
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

							<form id="frm" name="frm" target="_self" method="POST" action="event_edit.php" enctype="multipart/form-data">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="str_no" value="<?= $str_no ?>">
								<input type="hidden" name="int_type" value="<?= $int_type ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="str_dimage1" value="<?= $arr_Data['STR_IMAGE1'] ?>">
								<input type="hidden" name="str_dimage2" value="<?= $arr_Data['STR_IMAGE2'] ?>">
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
										<td>소제목(부제목)</td>
										<td colspan="3">
											<textarea name="str_stitle" rows="6" style="width:400px;"><?= $arr_Data['STR_STITLE'] ?></textarea>
										</td>
									</tr>
									<tr>
										<td>카테고리 배너</td>
										<td colspan=3>
											<table class=tb>
												<tr>
													<td width="100%" align="center" valign="middle" height="20"><?= $arr_Data['STR_IMAGE1'] ?>&nbsp;</td>
												</tr>
												<tr>
													<td align="center" valign="middle" height="150"><? if ($RetrieveFlag == "UPDATE") { ?><? if (!($arr_Data['STR_IMAGE1'] == "")) { ?><img src="/admincenter/files/event/<?= $arr_Data['STR_IMAGE1'] ?>" style="width: 250px" border="0"><? } else { ?>&nbsp;<? } ?><? } else { ?>&nbsp;<? } ?></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>카테고리 배너</td>
										<td colspan="3"><input type="file" name="str_Image1" style="width:200;" onChange="uploadImageCheck(this)"> <? if (!($arr_Data['STR_IMAGE1'] == "")) { ?>- 삭제시 <input type="checkbox" name="str_del_img1" value="Y" class="null"><? } ?></td>
									</tr>
									<tr>
										<td>홈배너</td>
										<td colspan=3>
											<table class=tb>
												<tr>
													<td width="100%" align="center" valign="middle" height="20"><?= $arr_Data['STR_IMAGE2'] ?>&nbsp;</td>
												</tr>
												<tr>
													<td align="center" valign="middle" height="150"><? if ($RetrieveFlag == "UPDATE") { ?><? if (!($arr_Data['STR_IMAGE2'] == "")) { ?><img src="/admincenter/files/event/<?= $arr_Data['STR_IMAGE2'] ?>" style="width: 250px" border="0"><? } else { ?>&nbsp;<? } ?><? } else { ?>&nbsp;<? } ?></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>홈배너</td>
										<td colspan="3"><input type="file" name="str_Image2" style="width:200;" onChange="uploadImageCheck(this)"> <? if (!($arr_Data['STR_IMAGE2'] == "")) { ?>- 삭제시 <input type="checkbox" name="str_del_img2" value="Y" class="null"><? } ?></td>
									</tr>
									<tr>
										<td>상세페이지</td>
										<td colspan="3" style="padding-top:5px;padding-bottom:5px;">
											<textarea name="str_cont" id="str_cont" rows="10" cols="100" style="width:100%; height:412px; display:none;"><?php echo stripslashes($arr_Data['STR_CONT']); ?></textarea>
											<script type="text/javascript">
												var oEditors = [];

												// 추가 글꼴 목록
												//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

												nhn.husky.EZCreator.createInIFrame({
													oAppRef: oEditors,
													elPlaceHolder: "str_cont",
													sSkinURI: "/_lib/smart/SmartEditor2Skin.html",
													htParams: {
														bUseToolbar: true, // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
														bUseVerticalResizer: true, // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
														bUseModeChanger: true, // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
														//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
														fOnBeforeUnload: function() {
															//alert("완료!");
														}
													}, //boolean
													fOnAppLoad: function() {

													},
													fCreator: "createSEditor2"
												});
											</script>
										</td>
									</tr>
									<tr>
										<td>비고</td>
										<td colspan="3">
											<textarea name="str_bigo" rows="6" style="width:400px;"><?= $arr_Data['STR_BIGO'] ?></textarea>
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
									<a href='event_list.php'><img src='/admincenter/img/btn_list.gif'></a>
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