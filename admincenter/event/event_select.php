<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no], "");
$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun], "1");

$SQL_QUERY = "SELECT
					FC.*
				FROM "
	. $Tname . "comm_com_code AS FC
				WHERE
					FC.INT_NUMBER='$str_no' ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
if (!$arr_Rlt_Data) {
	echo 'Could not run query: ' . mysql_error();
	exit;
}
$brand_Info = mysql_fetch_assoc($arr_Rlt_Data);
?>
<html>

<head>
	<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php"; ?>
	<script type="text/javascript" src="/_lib/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
	<script language="javascript" src="js/event_select.js"></script>
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

							<form id="frm" name="frm" target="_self" method="POST" action="event_select.php" enctype="multipart/form-data">
								<input type="hidden" name="int_gubun" value="<?= $int_gubun ?>">
								<input type="hidden" name="str_no" value="<?= $str_no ?>">

								<table class=tb>
									<col class=cellC style="width:12%">
									<col class=cellL style="padding-left:10px;width:88%">
									<tr>
										<td>구독용 가방선택 (3개까지만 가능)</td>
										<td colspan="3">
											<?php
											$SQL_QUERY = "SELECT a.* FROM " . $Tname . "comm_goods_master a WHERE a.str_goodcode IS NOT NULL ";
											$SQL_QUERY .= "AND a.int_brand=" . $brand_Info['INT_NUMBER'] . " ";
											$SQL_QUERY .= "AND a.int_type=1 ";
											$SQL_QUERY .= "ORDER BY a.int_sort DESC";

											$result = mysql_query($SQL_QUERY);
											?>
											<div style="display: flex; flex-direction: column; width: 500px; height: 200px; overflow-y: auto; border: solid 1px black;">
												<?php
												while ($row = mysql_fetch_assoc($result)) {
												?>
													<div style="display: flex; flex-direction: row; gap: 2px; align-items: center;">
														<input type="checkbox" name="sub_goods[]" id="sub_goods_<?= $row['STR_GOODCODE'] ?>" value="<?= $row['STR_GOODCODE'] ?>" onclick="handleCheckboxClick('sub_goods')" <?= ($brand_Info['STR_SUB_GOOD1'] == $row['STR_GOODCODE'] || $brand_Info['STR_SUB_GOOD2'] == $row['STR_GOODCODE'] || $brand_Info['STR_SUB_GOOD3'] == $row['STR_GOODCODE']) ? 'checked' : '' ?>>
														<img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" width="40" height="40" border="0">
														<label for="sub_goods_<?= $row['STR_GOODCODE'] ?>"><?= $row['STR_GOODNAME'] ?></label>
													</div>
												<?php
												}
												?>
											</div>
										</td>
									</tr>
									<tr>
										<td>렌트용 가방선택 (3개까지만 가능)</td>
										<td colspan="3">
											<?php
											$SQL_QUERY = "SELECT a.* FROM " . $Tname . "comm_goods_master a WHERE a.str_goodcode IS NOT NULL ";
											$SQL_QUERY .= "AND a.int_brand=" . $brand_Info['INT_NUMBER'] . " ";
											$SQL_QUERY .= "AND a.int_type=2 ";
											$SQL_QUERY .= "ORDER BY a.int_sort DESC";

											$result = mysql_query($SQL_QUERY);
											?>
											<div style="display: flex; flex-direction: column; width: 500px; height: 200px; overflow-y: auto; border: solid 1px black;">
												<?php
												while ($row = mysql_fetch_assoc($result)) {
												?>
													<div style="display: flex; flex-direction: row; gap: 2px; align-items: center;">
														<input type="checkbox" name="ren_goods[]" value="<?= $row['STR_GOODCODE'] ?>" id="ren_goods_<?= $row['STR_GOODCODE'] ?>" onclick="handleCheckboxClick('ren_goods')" <?= ($brand_Info['STR_REN_GOOD1'] == $row['STR_GOODCODE'] || $brand_Info['STR_REN_GOOD2'] == $row['STR_GOODCODE'] || $brand_Info['STR_REN_GOOD3'] == $row['STR_GOODCODE']) ? 'checked' : '' ?>>
														<img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" width="40" height="40" border="0">
														<label for="ren_goods_<?= $row['STR_GOODCODE'] ?>"><?= $row['STR_GOODNAME'] ?></label>
													</div>
												<?php
												}
												?>
											</div>
										</td>
									</tr>
									<tr>
										<td>빈티지용 가방선택 (3개까지만 가능)</td>
										<td colspan="3">
											<?php
											$SQL_QUERY = "SELECT a.* FROM " . $Tname . "comm_goods_master a WHERE a.str_goodcode IS NOT NULL ";
											$SQL_QUERY .= "AND a.int_brand=" . $brand_Info['INT_NUMBER'] . " ";
											$SQL_QUERY .= "AND a.int_type=3 ";
											$SQL_QUERY .= "ORDER BY a.int_sort DESC";

											$result = mysql_query($SQL_QUERY);
											?>
											<div style="display: flex; flex-direction: column; width: 500px; height: 200px; overflow-y: auto; border: solid 1px black;">
												<?php
												while ($row = mysql_fetch_assoc($result)) {
												?>
													<div style="display: flex; flex-direction: row; gap: 2px; align-items: center;">
														<input type="checkbox" name="vin_goods[]" value="<?= $row['STR_GOODCODE'] ?>" id="vin_goods_<?= $row['STR_GOODCODE'] ?>" onclick="handleCheckboxClick('vin_goods')" <?= ($brand_Info['STR_VIN_GOOD1'] == $row['STR_GOODCODE'] || $brand_Info['STR_VIN_GOOD2'] == $row['STR_GOODCODE'] || $brand_Info['STR_VIN_GOOD3'] == $row['STR_GOODCODE']) ? 'checked' : '' ?>>
														<img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" width="40" height="40" border="0">
														<label for="vin_goods_<?= $row['STR_GOODCODE'] ?>"><?= $row['STR_GOODNAME'] ?></label>
													</div>
												<?php
												}
												?>
											</div>
										</td>
									</tr>
								</table>


								<div class=button>
									<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_modify.gif"></a>
									<a href='event_list.php?int_gubun=<?= $int_gubun ?>'><img src='/admincenter/img/btn_list.gif'></a>
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

		// JavaScript code to restrict checkbox selection
		var maxChecked = 3; // Maximum number of items to check

		function handleCheckboxClick(name) {
			var checkboxes = document.getElementsByName(name);
			var checkedCount = 0;

			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].checked) {
					checkedCount++;
				}
			}

			if (checkedCount >= maxChecked) {
				// Disable unchecked checkboxes when the limit is reached
				for (var i = 0; i < checkboxes.length; i++) {
					if (!checkboxes[i].checked) {
						checkboxes[i].disabled = true;
					}
				}
			} else {
				// Enable all checkboxes when the limit is not reached
				for (var i = 0; i < checkboxes.length; i++) {
					checkboxes[i].disabled = false;
				}
			}
		}
	</script>
</body>

</html>