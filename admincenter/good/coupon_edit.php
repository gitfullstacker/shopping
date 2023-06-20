<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
//Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag], "INSERT");
$page = Fnc_Om_Conv_Default($_REQUEST[page], 1);
$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no], "");

$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow], 10);

$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key], "all");
$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word], "");
$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service], "");

$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate], "");
$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate], "");

if ($RetrieveFlag == "UPDATE") {

	$SQL_QUERY =	" SELECT
						A.*
					FROM "
		. $Tname . "comm_coupon AS A
					WHERE
						A.INT_NUMBER='$str_no' ";

	$arr_Rlt_Data = mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
}

$str_String = "?Page=" . $page . "&displayrow=" . urlencode($displayrow) . "&Txt_key=" . urlencode($Txt_key) . "&Txt_word=" . urlencode($Txt_word) . "&Txt_service=" . urlencode($Txt_service) . "&Txt_sindate=" . urlencode($Txt_sindate) . "&Txt_eindate=" . urlencode($Txt_eindate);
?>
<html>

<head>
	<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php"; ?>
	<script type="text/javascript" src="/_lib/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
	<script language="javascript" src="js/coupon_edit.js"></script>
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

							<form id="frm" name="frm" target="_self" method="POST" action="coupon_edit.php" enctype="multipart/form-data">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="str_no" value="<?= $str_no ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="str_String" value="<?= $str_String ?>">
								<input type="hidden" name="Obj">

								<table width=100% border=0>
									<tr>
										<td valign=top width=100% style="padding-left:10px">

											<table class=tb>
												<col class=cellC style="width:12%;">
												<col style="padding-left:10px;width:88%;">
												<tr>
													<td>쿠폰명</td>
													<td colspan="3"><input type=text name="str_title" value="<?= $arr_Data['STR_TITLE'] ?>" style="width:350px;"></td>
												</tr>
												<tr>
													<td>쿠폰상세</td>
													<td colspan="3"><input type=text name="str_desc" value="<?= $arr_Data['STR_DESC'] ?>" style="width:350px;"></td>
												</tr>
												<tr>
													<td>쿠폰값</td>
													<td colspan="3">
														<input type="number" name="int_value" value="<?= $arr_Data['INT_VALUE'] ?>">
														<input type="radio" name="str_percent" value="N" <?= ($arr_Data['STR_PERCENT'] ?: 'N') == 'N' ? 'checked' : '' ?>>원
														<input type="radio" name="str_percent" value="Y" <?= ($arr_Data['STR_PERCENT']) == 'Y' ? 'checked' : '' ?>>%
													</td>
												</tr>
												<tr>
													<td>자동지급(수정불가)</td>
													<td colspan="3">
														<input type="text" name="str_auto" value="<?= ($arr_Data['STR_AUTO'] ?: 'N') == 'Y' ? '자동지급' : '관리자지급' ?>" readonly>
													</td>
												</tr>
												<tr>
													<td>사용기간</td>
													<td colspan="3">
														<input type="number" name="int_months" value="<?= $arr_Data['INT_MONTHS'] ?: 3 ?>">개월
													</td>
												</tr>
												<tr>
													<td>쿠폰번호</td>
													<td colspan="3">
														<input type="text" name="str_code" value="<?= $arr_Data['STR_CODE'] ?>">
													</td>
												</tr>
												<tr>
													<td>출력여부</td>
													<td colspan="3">
														<input type="radio" value="Y" name="str_service" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'], 'Y') == 'Y') { ?>checked<? } ?>> 출력
														<input type="radio" value="N" name="str_service" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'], 'Y') == 'N') { ?>checked<? } ?>> 미출력
													</td>
												</tr>
												<? if ($RetrieveFlag == "UPDATE") { ?>
													<tr>
														<td>등록일자</td>
														<td colspan="3">
															<font class=ver8><?= $arr_Data['DTM_INDATE'] ?>
														</td>
													</tr>
												<? } ?>
											</table>
										</td>
									</tr>
								</table>

								<div class=button>
									<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<? if ($RetrieveFlag == "INSERT") { ?>register<? } else { ?>modify<? } ?>.gif"></a>
									<a href='coupon_list.php<?= $str_String ?>'><img src='/admincenter/img/btn_list.gif'></a>
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