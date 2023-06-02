<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag], "INSERT");
$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun], "1");
$page = Fnc_Om_Conv_Default($_REQUEST[page], 1);
$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no], "");

if ($RetrieveFlag == "UPDATE") {

	$SQL_QUERY =	" SELECT
						A.*
					FROM "
		. $Tname . "comm_banner AS A
					WHERE
						A.INT_GUBUN='$int_gubun'
						AND
						A.INT_NUMBER='$str_no' ";

	$arr_Rlt_Data = mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
}

switch ($int_gubun) {
	case  "1":
		$int_w1 = "800";
		$int_h1 = "380";
		$int_w2 = "1600";
		$int_h2 = "764";
		break;
	case "4":
		$int_w1 = "640";
		$int_h1 = "480";
		$int_w2 = "640";
		$int_h2 = "480";
		break;
	case "5":
		$int_w1 = "590";
		$int_h1 = "180";
		$int_w2 = "590";
		$int_h2 = "180";
		break;
	case  "6":
		$int_w1 = "800";
		$int_h1 = "380";
		$int_w2 = "1600";
		$int_h2 = "764";
}
?>
<html>

<head>
	<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php"; ?>
	<script type="text/javascript" src="/_lib/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
	<script language="javascript" src="js/bann_main_edit.js"></script>
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

							<form id="frm" name="frm" target="_self" method="POST" action="bann_main_edit.php" enctype="multipart/form-data">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="str_no" value="<?= $str_no ?>">
								<input type="hidden" name="int_gubun" value="<?= $int_gubun ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="Obj">
								<input type="hidden" name="str_dimage1" value="<?= $arr_Data['STR_IMAGE1'] ?>">

								<table class=tb>
									<col class=cellC style="width:12%">
									<col style="padding-left:10px;width:88%">
									<tr>
										<td>배너이미지</td>
										<td colspan=3>

											<table class=tb>
												<tr>
													<td width="100%" align="center" valign="middle" height="20"><?= $arr_Data['STR_IMAGE1'] ?>&nbsp;</td>
												</tr>
												<tr>
													<td width="100%" align="center" valign="middle" height="400"><? if ($RetrieveFlag == "UPDATE") { ?><? if (!($arr_Data['STR_IMAGE1'] == "")) { ?><img src="/admincenter/files/bann/<?= $arr_Data['STR_IMAGE1'] ?>" width="<?= $int_w1 ?>" height="<?= $int_h1 ?>" border="1"><? } else { ?>등록된 사진이<br>없습니다.<? } ?><? } else { ?>이미지 등록이<br>필요합니다.<? } ?></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>이미지선택</td>
										<td colspan=3><input type=file name=str_image1 style="width:300px;"> (<?= $int_w2 ?>*<?= $int_h2 ?>) <? if (!($arr_Data['STR_IMAGE1'] == "")) { ?> 삭제시 <input type="checkbox" name="str_del_img1" value="Y" class="null"><? } ?></td>
									</tr>
									<tr>
										<td>링크</td>
										<td colspan="3">
											<font class=def>
												<select name="str_target1">
													<option value="1" <? if ($arr_Data['STR_TARGET1'] == "1") { ?>selected<? } ?>>현재창
													<option value="2" <? if ($arr_Data['STR_TARGET1'] == "2") { ?>selected<? } ?>>새창
												</select>
												<input type=text name=str_url1 value="<?= $arr_Data['STR_URL1'] ?>" size=80> (http://부터 기재)
										</td>
									</tr>
									<!-- START -- 카테고리 픽인 경우 -->
									<?php
									if ($int_gubun == 10) {
									?>
										<tr>
											<td>카테고리</td>
											<td colspan="3">
												<select name="int_type">
													<option value="1" <? if ($arr_Data['INT_TYPE'] == 1) { ?>selected<? } ?>>구독</option>
													<option value="2" <? if ($arr_Data['INT_TYPE'] == 2) { ?>selected<? } ?>>렌트</option>
													<option value="3" <? if ($arr_Data['INT_TYPE'] == 3) { ?>selected<? } ?>>빈티지</option>
												</select>
											</td>
										</tr>
									<?php
									}

									if ($int_gubun == 11) {
									?>
										<tr>
											<td>분류</td>
											<td colspan="3">
												<select name="int_type">
													<option value="1" <? if ($arr_Data['INT_TYPE'] == 1) { ?>selected<? } ?>>렌트 신규 입고</option>
													<option value="2" <? if ($arr_Data['INT_TYPE'] == 2) { ?>selected<? } ?>>구독 신규 입고</option>
												</select>
											</td>
										</tr>
									<?php
									}
									?>
									<tr>
										<td>출력여부</td>
										<td colspan=3>
											<input type="radio" value="Y" name="str_service" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'], "Y") == "Y") { ?>checked<? } ?>> 출력
											<input type="radio" value="N" name="str_service" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'], "Y") == "N") { ?>checked<? } ?>> 미출력
										</td>
									</tr>
									<? if ($RetrieveFlag == "UPDATE") { ?>
										<tr>
											<td>등록일자</td>
											<td class=noline>
												<font class=def>
													<?= $arr_Data['DTM_INDATE'] ?>
											</td>
										</tr>
									<? } ?>
								</table>


								<div class=button>
									<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<? if ($RetrieveFlag == "INSERT") { ?>register<? } else { ?>modify<? } ?>.gif"></a>
									<a href='bann_main_list.php?int_gubun=<?= $int_gubun ?>'><img src='/admincenter/img/btn_list.gif'></a>
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