<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], 1);

$page = Fnc_Om_Conv_Default($_REQUEST[page], 1);
$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow], 20);
$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage], 10);
$displayorder = Fnc_Om_Conv_Default($_REQUEST[displayorder], '');

$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key], "all");
$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word], "");
$Txt_brand = Fnc_Om_Conv_Default($_REQUEST[Txt_brand], "");
$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service], "");

$Txt_bname = Fnc_Om_Conv_Default($_REQUEST[Txt_bname], "");
$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode], "");

$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate], "");
$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate], "");

if ($Txt_word != "") {
	switch ($Txt_key) {
		case  "all":
			$Str_Query = " and (a.str_goodname like '%$Txt_word%' or a.str_goodcode in (select e.str_goodcode from `" . $Tname . "comm_goods_master_sub` as e where e.str_usercode like '%$Txt_word%')) ";
			break;
		case  "str_goodname":
			$Str_Query = " and a.str_goodname like '%$Txt_word%' ";
			break;
		case "str_usercode":
			$Str_Query = " and a.str_goodcode in (select e.str_goodcode from `" . $Tname . "comm_goods_master_sub` as e where e.str_usercode like '%$Txt_word%') ";
			break;
	}
}
if ($Txt_brand != "") {
	$Str_Query .= " and a.int_brand = '$Txt_brand' ";
}

if ($Txt_service != "") {
	$Str_Query .= " and a.str_service = '$Txt_service' ";
}
//If ($Txt_bcode!="") { $Str_Query .= " and a.str_bcode = '$Txt_bcode' ";}

if ($Txt_bcode != "") {
	$Str_Query .= " and a.str_goodcode in (select d.str_goodcode from " . $Tname . "comm_goods_master_category d where d.str_bcode in (select concat(c.str_menutype,c.str_chocode,c.str_btmuni) from " . $Tname . "comm_menu_btm c where c.str_menutype='" . substr($Txt_bcode, 0, 2) . "' and c.str_chocode='" . substr($Txt_bcode, 2, 2) . "' and c.str_unicode='" . substr($Txt_bcode, 4, 5) . "')) ";
}

$Str_Query .= " and a.int_type = '$int_type' ";

$SQL_QUERY = "select count(a.str_goodcode) from ";
$SQL_QUERY .= $Tname;
$SQL_QUERY .= "comm_goods_master a where a.str_goodcode is not null ";
$SQL_QUERY .= $Str_Query;
$result = mysql_query($SQL_QUERY);

if (!result) {
	error("QUERY_ERROR");
	exit;
}
$total_record = mysql_result($result, 0, 0);

if (!$total_record) {
	$first = 1;
	$last = 0;
} else {
	$first = $displayrow * ($page - 1);
	$last = $displayrow * $page;

	$IsNext = $total_record - $last;
	if ($IsNext > 0) {
		$last -= 1;
	} else {
		$last = $total_record - 1;
	}
}
$total_page = ceil($total_record / $displayrow);

$f_limit = $first;
$l_limit = $last + 1;

$order_by = "int_sort desc";
switch ($displayorder) {
	case 'favorite':
		$order_by = 'int_like desc';
		break;
	case 'new':
		$order_by = 'dtm_indate desc';
		break;
	case 'recommend':
		$order_by = 'int_like desc';
		break;
	case 'lowprice':
		$order_by = 'int_price asc';
		break;
}

$SQL_QUERY = "select a.*,(select count(b.str_sgoodcode) from " . $Tname . "comm_goods_master_link b where b.str_goodcode=a.str_goodcode) as cnt2,(select count(b.str_userid) from " . $Tname . "comm_member_alarm b where b.str_goodcode=a.str_goodcode) as cnt3  ";
$SQL_QUERY .= " from ";
$SQL_QUERY .= $Tname;
$SQL_QUERY .= "comm_goods_master a ";
$SQL_QUERY .= "where a.str_goodcode is not null ";
$SQL_QUERY .= $Str_Query;
$SQL_QUERY .= "order by a." . $order_by . " ";
$SQL_QUERY .= "limit $f_limit,$l_limit";

$result = mysql_query($SQL_QUERY);
if (!$result) {
	error("QUERY_ERROR");
	exit;
}
$total_record_limit = mysql_num_rows($result);

$str_String = "?int_type=" . $int_type . "&Page=" . $page . "&displayrow=" . urlencode($displayrow) . "&Txt_key=" . urlencode($Txt_key) . "&Txt_word=" . urlencode($Txt_word) . "&Txt_brand=" . urlencode($Txt_brand) . "&Txt_service=" . urlencode($Txt_service) . "&Txt_bname=" . urlencode($Txt_bname) . "&Txt_bcode=" . urlencode($Txt_bcode) . "&Txt_sindate=" . urlencode($Txt_sindate) . "&Txt_eindate=" . urlencode($Txt_eindate);
?>
<html>

<head>
	<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php"; ?>
	<script language="javascript" src="js/good_master_list.js"></script>
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

							<form id="frm" name="frm" target="_self" method="POST" action="good_master_list.php">
								<input type="hidden" name="int_type" value="<?= $int_type ?>">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="str_no">
								<input type="hidden" name="str_String" value="<?= $str_String ?>">

								<table class=tb>
									<col class=cellC style="width:12%;">
									<col style="padding-left:10px;width:38%;">
									<col class=cellC style="width:12%;">
									<col style="padding-left:10px;width:38%;">
									<tr>
										<td>키워드검색</td>
										<td>
											<select name="Txt_key">
												<option value="all" <? if ($Txt_key == "all") { ?>selected<? } ?>> 통합검색 </option>
												<option value="str_goodname" <? if ($Txt_key == "str_goodname") { ?>selected<? } ?>> 상품명 </option>
												<option value="str_usercode" <? if ($Txt_key == "str_usercode") { ?>selected<? } ?>> 서브상품코드 </option>
											</select>
											<input type="text" NAME="Txt_word" value="<?= $Txt_word ?>" style="width:300px;" onkeydown="javascript: if (event.keyCode == 13) {fnc_search();}">
										</td>
										<td>브랜드</td>
										<td>
											<?
											$SQL_QUERY = "SELECT
												A.*
											FROM 
												" . $Tname . "comm_com_code A
											WHERE
												A.INT_GUBUN='2'
												AND
												A.STR_SERVICE='Y'
											ORDER BY
												A.DTM_INDATE ASC ";

											$arr_menu_Data = mysql_query($SQL_QUERY);
											?>
											<select name="Txt_brand">
												<option value="" <? if ($Txt_brand == "") { ?>selected<? } ?>> 전체 </option>
												<? while ($row = mysql_fetch_array($arr_menu_Data)) { ?>
													<option value="<?= $row[INT_NUMBER] ?>" <? if ($Txt_brand == $row[INT_NUMBER]) { ?>selected<? } ?>><?= $row[STR_CODE] ?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>출력여부</td>
										<td>
											<input type="radio" value="" name="Txt_service" class=null <? if ($Txt_service == "") { ?>checked<? } ?>> 전체
											<input type="radio" value="Y" name="Txt_service" class=null <? if ($Txt_service == "Y") { ?>checked<? } ?>> 출력
											<input type="radio" value="N" name="Txt_service" class=null <? if ($Txt_service == "N") { ?>checked<? } ?>> 미출력
											<!--<input type="radio" value="R" name="Txt_service" class=null <? if ($Txt_service == "R") { ?>checked<? } ?>> 품절//-->
										</td>
										<td>사이즈</td>
										<td>
											<input type=text name=Txt_bname value="<?= $Txt_bname ?>" style="width:180px;" style="background-Color:#eeeded;" readonly> <a href="javascript:popupLayer('/admincenter/comm/comm_bcode.php?obj1=frm&obj2=Txt_bcode&obj3=Txt_bname&str_menutype=03',400,450)"><img src="/admincenter/img/i_search.gif" align=absmiddle></a>
											<a href="javascript:fnc_blank('Txt_bname','Txt_bcode')"><img src="/admincenter/img/i_del.gif" align=absmiddle></a>
										</td>
										<input type="hidden" name="Txt_bcode" value="<?= $Txt_bcode ?>">
									</tr>
									<tr>
										<td>등록일</td>
										<td colspan="3">
											<input type=text name=Txt_sindate value="<?= $Txt_sindate ?>" id="Txt_sindate" onclick="displayCalendar(document.frm.Txt_sindate ,'yyyy-mm-dd',this)">
											<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:hand" onclick="displayCalendar(document.frm.Txt_sindate ,'yyyy-mm-dd',document.frm.Txt_sindate)">
											<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:hand" onclick="document.frm.Txt_sindate.value=''" ;>
											-
											<input type=text name=Txt_eindate value="<?= $Txt_eindate ?>" id="Txt_eindate" onclick="displayCalendar(document.frm.Txt_eindate ,'yyyy-mm-dd',this)">
											<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:hand" onclick="displayCalendar(document.frm.Txt_eindate ,'yyyy-mm-dd',document.frm.Txt_eindate)">
											<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:hand" onclick="document.frm.Txt_eindate.value=''" ;>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?= date("Y-m-d") ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_today.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?= date("Y-m-d", strtotime($day . "-7day")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_week.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?= date("Y-m-d", strtotime($day . "-15day")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_twoweek.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?= date("Y-m-d", strtotime($month . "-1month")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_month.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?= date("Y-m-d", strtotime($month . "-2month")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_twomonth.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','','')"><img src="/admincenter/img/sicon_all.gif" align=absmiddle></a>
										</td>
									</tr>
								</table>

								<div class=button_top><img src="/admincenter/img/btn_search2.gif" style="cursor:hand" onClick="fnc_search();"></div>

								<table width=100%>
									<tr>
										<td>
											<img src="/admincenter/img/btn_regist_s.gif" alt="등록" border=0 align=absmiddle style="cursor:hand" onClick="AddNew(<?= $int_type ?>);">
										</td>
										<td>
											<select name="to_int_type" id="to_int_type">
												<option value=""></option>
												<option value="1" <?= $int_type == 1 ? 'hidden' : '' ?>>구독용 상품</option>
												<option value="2" <?= $int_type == 2 ? 'hidden' : '' ?>>렌트용 상품</option>
												<option value="3" <?= $int_type == 3 ? 'hidden' : '' ?>>빈티지용 상품</option>
											</select>
											<button type="button" style="height: 20px; font-size: smaller;" onClick="Aaction_Click(1);">이동</button>
											<button type="button" style="height: 20px; font-size: smaller;" onClick="Aaction_Click(2);">복사</button>
										</td>
									</tr>
								</table>

								<table width=100%>
									<tr>
										<td class=pageInfo>총 <b><?= $total_record ?></b>건, <b><?= $page ?></b> of <?= $total_page ?> Pages
										</td>
										<td align=right>
											<select name="displayorder" onchange="fnc_search()">
												<option value="" <?= $displayorder == '' ? 'selected' : '' ?>></option>
												<option value="favorite" <?= $displayorder == 'favorite' ? 'selected' : '' ?>>인기순</option>
												<option value="new" <?= $displayorder == 'new' ? 'selected' : '' ?>>신상순</option>
												<option value="recommend" <?= $displayorder == 'recommend' ? 'selected' : '' ?>>추천순</option>
												<option value="lowprice" <?= $displayorder == 'lowprice' ? 'selected' : '' ?>>낮은가격순</option>
											</select>
											<select name=displayrow onchange="fnc_search()">
												<? for ($i = 50; $i <= 600; $i += 50) { ?>
													<option value="<?= $i ?>" <? if (Trim($i) == trim($displayrow)) { ?>selected<? } ?>><?= $i ?>개 출력</option>
												<? } ?>
											</select>
										</td>
									</tr>
								</table>

								<table width=100% cellpadding=0 cellspacing=0 border=0>
									<tr>
										<td class=rnd colspan=18></td>
									</tr>
									<tr class=rndbg>
										<th>번호</th>
										<th>상품코드</th>
										<th>이미지</th>
										<th>상품명</th>
										<th>정가</th>
										<th>할인</th>
										<th>사이즈</th>
										<th>서브상품</th>
										<th>입고알림</th>
										<th>소트</th>
										<th>태그</th>
										<th>관련상품</th>
										<th>메인출력</th>
										<th>조회수</th>
										<th>등록일</th>
										<th>출력유무</th>
										<th>수정</th>
										<th>삭제</th>
									</tr>
									<tr>
										<td class=rnd colspan=18></td>
									</tr>
									<col width=4% align=center>
									<col width=6% align=center>
									<col width=6% align=center>
									<col width=6% align=left>
									<col width=5% align=center>
									<col width=5% align=center>
									<col width=6% align=center>
									<col width=15% align=center>
									<col width=4% align=center>
									<col width=4% align=center>
									<col width=4% align=center>
									<col width=6% align=center>
									<col width=4% align=center>
									<col width=5% align=center>
									<col width=4% align=center>
									<col width=5% align=center>
									<col width=5% align=center>
									<col width=3% align=center>
									<? $count = 0; ?>
									<? if ($total_record_limit != 0) { ?>
										<? $article_num = $total_record - $displayrow * ($page - 1); ?>
										<? for ($i = 0; $i <= $displayrow - 1; $i++) { ?>
											<tr height=30 align="center">
												<td>
													<font class=ver81 color=616161><?= $article_num ?></font>
												</td>
												<td>
													<span id="navig" name="navig" m_id="admin" m_no="1">
														<font color=0074BA><b><?= mysql_result($result, $i, str_goodcode) ?></b></font>
													</span>
												</td>
												<td height="100" align="center" valign="middle">
													<? if (mysql_result($result, $i, str_image1) != "") { ?><img src="/admincenter/files/good/<?= mysql_result($result, $i, str_image1) ?>" width="80" height="80" border="0"><? } else { ?>&nbsp;<? } ?>
												</td>
												<td>
													<span id="navig" name="navig" m_id="admin" m_no="1">
														<font class=ver81 color=0074BA><b><?= mysql_result($result, $i, str_goodname) ?></b></font>
													</span>
													<br>
													<? if (fnc_cart_info(mysql_result($result, $i, str_goodcode)) == 0) { ?><font color="red"><b></i>RENTED</b></font><? } ?>
												</td>
												<td><?= number_format(mysql_result($result, $i, int_price)) ?>원</td>
												<td>
													<span>
														<?= number_format(mysql_result($result, $i, int_discount)) ?>%
													</span>
													<br />
													<?= mysql_result($result, $i, int_discount) ? number_format(mysql_result($result, $i, int_price) * mysql_result($result, $i, int_discount) / 100.0) . '원' : '' ?>
												</td>
												<td>
													<div style="display: flex; flex-direction: column; align-items: center;">
														<?php
														foreach (explode(",", mysql_result($result, $i, str_tsize)) as $value) {
														?>
															<span><?= $value ?></span>
														<?php
														}
														?>
													</div>
												</td>
												<td style="padding:3px;padding-right:15px;text-align:left;" valign="top">
													<?
													$Sql_Query =	" SELECT
																		A.*,B.INT_STATE
																	FROM 
																		`" . $Tname . "comm_goods_master_sub` AS A
																		left join " . $Tname . "comm_goods_cart AS B 
																		ON 
																		A.STR_SGOODCODE=B.STR_SGOODCODE 
																		AND
																		B.STR_GOODCODE='" . mysql_result($result, $i, 'str_goodcode') . "'
																		AND
																		B.INT_STATE IN ('1','2','3','4','5')
																	WHERE
																		A.STR_GOODCODE='" . mysql_result($result, $i, 'str_goodcode') . "'
																	ORDER BY
																		A.STR_SGOODCODE ASC ";

													$arr_Data = mysql_query($Sql_Query);
													$arr_Data_Cnt = mysql_num_rows($arr_Data);
													?>
													<table class=tb>
														<col style="padding-left:0px;width:50%;">
														<col style="padding-left:0px;width:50%;">
														<?
														for ($int_I = 0; $int_I < $arr_Data_Cnt; $int_I++) {
														?>
															<tr>
																<td><?= mysql_result($arr_Data, $int_I, str_sgoodcode) ?></td>
																<td rowspan="2">
																	<? switch (mysql_result($arr_Data, $int_I, str_service)) {
																		case  "Y":
																			echo "[<font color='blue'>출력</font>]";
																			break;
																		case  "N":
																			echo "[<font color='red'>미출력</font>]";
																			break;
																	}
																	?>
																	-
																	<? switch (mysql_result($arr_Data, $int_I, 'int_state')) {
																		case  "1":
																			echo "[접수]";
																			break;
																		case  "2":
																			echo "[관리자확인]";
																			break;
																		case  "3":
																			echo "[발송]";
																			break;
																		case  "4":
																			echo "[배송완료]";
																			break;
																		case  "5":
																			echo "[반납접수]";
																			break;
																	}
																	?>
																</td>
															</tr>
															<tr>
																<td>
																	<? if (mysql_result($arr_Data, $int_I, 'str_usercode') != "") { ?>
																		[<?= mysql_result($arr_Data, $int_I, 'str_usercode') ?>]
																	<? } else { ?>
																		&nbsp;
																	<? } ?>
																</td>
															</tr>
														<?
														}
														?>
													</table>
												</td>
												<td><?= mysql_result($result, $i, cnt3) ?>건 <a href="javascript:RowClick2('<?= mysql_result($result, $i, str_goodcode) ?>');"><img src="/admincenter/img/btn_viewbbs.gif" align="absmiddle"></a></td>
												<td>
													<input type=text name="int_sort[]" id="int_sort" value="<?= mysql_result($result, $i, int_sort) ?>" style="width:50px;background-Color:#eeeded;text-align:center;ime-mode:inactive" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()">
													<input type=hidden name="chkItem2[]" id="chkItem2" value="<?= mysql_result($result, $i, str_goodcode) ?>">
												</td>
												<td>
													<a href="javascript:popupLayer('good_tag_list.php?str_goodcode=<?= mysql_result($result, $i, str_goodcode) ?>',1000,500)"><img src="/admincenter/img/i_add.gif" border=0 align=absmiddle align="right"></a>
												</td>
												<td>
													<font class=ver81 color=616161>
														자동(<input type="checkbox" name="str_re_f<?= mysql_result($result, $i, str_goodcode) ?>" value="Y" <? if (mysql_result($result, $i, str_re_f) == "Y") { ?>checked<? } ?> class="null" onClick="fnc_re_f(this,'<?= mysql_result($result, $i, str_goodcode) ?>');" />)
														<span id="idView_Re<?= mysql_result($result, $i, str_goodcode) ?>" style="display:<? if (mysql_result($result, $i, str_re_f) == "Y") { ?>none<? } ?>">
															<span id="idView_Link<?= mysql_result($result, $i, str_goodcode) ?>"><?= mysql_result($result, $i, cnt2) ?>건</span>
													</font> <a href="javascript:popupLayer('good_connect_list.php?str_goodcode=<?= mysql_result($result, $i, str_goodcode) ?>',1000,500)"><img src="/admincenter/img/i_add.gif" border=0 align=absmiddle align="right"></a>
													</span>
												</td>
												<td>
													<table class=tb style="border:0px;">
														<col style="padding-left:0px;width:20%;">
														<col style="padding-left:0px;width:80%;">
														<tr>
															<td style="border:0px;">PC </td>
															<td style="border:0px;">
																<select name="str_myn" onchange="fnc_myn('<?= mysql_result($result, $i, str_goodcode) ?>',this.value)">
																	<option value="Y" <? if (mysql_result($result, $i, str_myn) == "Y") { ?> selected<? } ?>> 출력
																	<option value="N" <? if (mysql_result($result, $i, str_myn) == "N") { ?> selected<? } ?>> 미출력
																</select>
															</td>
														</tr>
														<tr>
															<td style="border:0px;">MOBILE</td>
															<td style="border:0px;">
																<select name="str_mmyn" onchange="fnc_mmyn('<?= mysql_result($result, $i, str_goodcode) ?>',this.value)">
																	<option value="Y" <? if (mysql_result($result, $i, str_mmyn) == "Y") { ?> selected<? } ?>> 출력
																	<option value="N" <? if (mysql_result($result, $i, str_mmyn) == "N") { ?> selected<? } ?>> 미출력
																</select>
															</td>
														</tr>
													</table>
												</td>
												<td>
													<?= number_format(mysql_result($result, $i, int_view)) ?>
												</td>
												<td>
													<font class=ver81 color=616161><?= substr(mysql_result($result, $i, dtm_indate), 0, 10) ?></font>
												</td>
												<td>
													<font class=small color=616161>
														<? switch (mysql_result($result, $i, str_service)) {
															case  "Y":
																echo "출력";
																break;
															case  "N":
																echo "미출력";
																break;
															case  "R":
																echo "품절";
																break;
														}
														?>
													</font>
												</td>
												<td><a href="javascript:RowClick('<?= mysql_result($result, $i, str_goodcode) ?>');"><img src="/admincenter/img/i_edit.gif"></a></td>
												<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?= mysql_result($result, $i, str_goodcode) ?>"></td>
											</tr>
											<tr>
												<td colspan=18 class=rndline></td>
											</tr>
											<? $count++; ?>
											<?
											$article_num--;
											if ($article_num == 0) {
												break;
											}
											?>
										<? } ?>
									<? } ?>
									<input type="hidden" name="txtRows" value="<?= $count ?>">
								</table>

								<div align=center class=pageNavi>
									<?
									$total_block = ceil($total_page / $displaypage);
									$block = ceil($page / $displaypage);

									$first_page = ($block - 1) * $displaypage;
									$last_page = $block * $displaypage;

									if ($total_block <= $block) {
										$last_page = $total_page;
									}

									$file_link = basename($PHP_SELF);
									$link = "$file_link?$param";

									if ($page > 1) { ?>
										<a href="Javascript:MovePage('1');" class=navi>◀◀</a>
									<? } else { ?>
										◀◀
									<? }

									if ($block > 1) {
										$my_page = $first_page;
									?>
										<a href="Javascript:MovePage('<?= $my_page ?>');" class=navi>◀</a>
									<? } else { ?>
										◀
										<? }

									echo " | ";
									for ($direct_page = $first_page + 1; $direct_page <= $last_page; $direct_page++) {
										if ($page == $direct_page) { ?>
											<font color='cccccc'><b><?= $direct_page ?></b></font> |
										<? } else { ?>
											<a href="Javascript:MovePage('<?= $direct_page ?>');" class=navi><?= $direct_page ?></a> |
										<? }
									}

									echo " ";

									if ($block < $total_block) {
										$my_page = $last_page + 1; ?>
										<a href="Javascript:MovePage('<?= $my_page ?>');" class=navi>▶</a>
									<? } else { ?>
										▶
									<? }

									if ($page < $total_page) { ?>
										<a href="Javascript:MovePage('<?= $total_page ?>');" class=navi>▶▶</a>
									<? } else { ?>
										▶▶
									<? }
									?>
								</div>

								<div style="float:left;">
									<img src="/admincenter/img/btn_allselect_s.gif" alt="전체선택" border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('1');">
									<img src="/admincenter/img/btn_alldeselect_s.gif" alt="선택해제" border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('2');">
									<img src="/admincenter/img/btn_alldelet_s.gif" alt="선택삭제" border="0" align='absmiddle' style="cursor:hand" onclick="javaScript:Adelete_Click();">
								</div>

								<div style="float:right;">
									[소트 : <img src="/admincenter/img/btn_allmodify_s.gif" align="absmiddle" style="cursor:hand" onclick="javaScript:Sort_Click();">]
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

									<img src="/admincenter/img/btn_regist_s.gif" alt="등록" border=0 align=absmiddle style="cursor:hand" onClick="AddNew(<?= $int_type ?>);">
								</div>
							</form>
							<table border="0" style="display:none;">
								<tr>
									<td id="obj_Lbl" colspan="2" height="0"></td>
								</tr>
							</table>
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