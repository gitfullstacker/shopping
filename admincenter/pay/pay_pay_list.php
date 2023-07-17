<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
$page = Fnc_Om_Conv_Default($_REQUEST[page], 1);
$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow], 20);
$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage], 10);
$Txt_ptype = Fnc_Om_Conv_Default($_REQUEST[Txt_ptype], "");

$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key], "all");
$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word], "");
$Txt_pass = Fnc_Om_Conv_Default($_REQUEST[Txt_pass], "");

$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate], "");
$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate], "");

if ($Txt_ptype != "") {
	if ($Txt_ptype == "0") {
		$Str_Query .= " and (c.int_number IS NULL and d.int_number IS NULL) ";
	}
	if ($Txt_ptype == "1") {
		$Str_Query .= " and c.int_number IS NOT NULL ";
	}
	if ($Txt_ptype == "2") {
		$Str_Query .= " and c.int_number IS NOT NULL ";
	}
	if ($Txt_ptype == "3") {
		$Str_Query .= " and (c.int_number IS NOT NULL and d.int_number IS NOT NULL) ";
	}
}

if ($Txt_word != "") {
	switch ($Txt_key) {
		case  "all":
			$Str_Query = " and (b.str_name like '%$Txt_word%' or b.str_userid like '%$Txt_word%' or replace(b.str_hp,'-','') like '%" . str_replace('-', '', $Txt_word) . "%' ) ";
			break;
		case  "str_name":
			$Str_Query = " and b.str_name like '%$Txt_word%' ";
			break;
		case  "str_userid":
			$Str_Query = " and b.str_userid like '%$Txt_word%' ";
			break;
		case  "str_hp":
			$Str_Query .= " and replace(b.str_hp,'-','') like '%" . str_replace('-', '', $Txt_word) . "%' ";
			break;
	}
}

if ($Txt_pass != "") {
	if ($Txt_pass == "0") {
		$Str_Query .= " and a.str_pass1 = '0' ";
	}
	if ($Txt_pass == "1") {
		$Str_Query .= " and a.str_pass1 = '1' ";
	}
	if ($Txt_pass == "2") {
		$Str_Query .= " and a.str_pass2 = '0' ";
	}
	if ($Txt_pass == "3") {
		$Str_Query .= " and a.str_pass2 = '1' ";
	}
}

if ($Txt_sindate != "") {
	$Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";
}
if ($Txt_eindate != "") {
	$Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";
}

$SQL_QUERY = "select count(a.int_number) from ";
$SQL_QUERY .= $Tname;
$SQL_QUERY .= "comm_member_pay a left join " . $Tname . "comm_member b on a.str_userid=b.str_userid ";
$SQL_QUERY .= 	"left join 
					" . $Tname . "comm_membership c 
				on
					a.str_userid = c.str_userid
					and now() between c.dtm_sdate and c.dtm_edate
					and c.int_type = 1
					and c.str_pass = '0'
				left join 
					" . $Tname . "comm_membership d 
				on
					a.str_userid = d.str_userid
					and now() between d.dtm_sdate and d.dtm_edate
					and d.int_type = 2
					and d.str_pass = '0' ";
$SQL_QUERY .= "where a.int_number is not null ";
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

$SQL_QUERY = "select a.*,b.str_name,b.str_hp, ifnull(c.int_number, 0) as sub_int, ifnull(d.int_number, 0) as ren_int from ";
$SQL_QUERY .= $Tname;
$SQL_QUERY .= "comm_member_pay a left join " . $Tname . "comm_member b on a.str_userid=b.str_userid ";
$SQL_QUERY .= 	"left join 
					" . $Tname . "comm_membership c 
				on
					a.str_userid = c.str_userid
					and now() between c.dtm_sdate and c.dtm_edate
					and c.int_type = 1
					and c.str_pass = '0'
				left join 
					" . $Tname . "comm_membership d 
				on
					a.str_userid = d.str_userid
					and now() between d.dtm_sdate and d.dtm_edate
					and d.int_type = 2
					and d.str_pass = '0' ";
$SQL_QUERY .= "where a.int_number is not null ";
$SQL_QUERY .= $Str_Query;
$SQL_QUERY .= "order by a.dtm_last_used desc ";
$SQL_QUERY .= "limit $f_limit,$l_limit";

$result = mysql_query($SQL_QUERY);
if (!$result) {
	error("QUERY_ERROR");
	exit;
}
$total_record_limit = mysql_num_rows($result);
?>
<html>

<head>
	<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php"; ?>
	<script language="javascript" src="js/pay_pay_list.js"></script>
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

							<form id="frm" name="frm" target="_self" method="POST" action="pay_pay_list.php">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="str_no">

								<table class=tb>
									<col class=cellC style="width:12%">
									<col class=cellL style="width:38%">
									<col class=cellC style="width:12%">
									<col class=cellL style="width:38%">
									<tr>
										<td>구분</td>
										<td colspan="3">
											<select name="Txt_ptype">
												<option value="" selected> 선택 </option>
												<option value="0" <? if ($Txt_ptype == "0") { ?>selected<? } ?>> 일반회원 </option>
												<option value="1" <? if ($Txt_ptype == "1") { ?>selected<? } ?>> 렌트멤버십 </option>
												<option value="2" <? if ($Txt_ptype == "2") { ?>selected<? } ?>> 구독멤버십 </option>
												<option value="3" <? if ($Txt_ptype == "3") { ?>selected<? } ?>> 렌트/구독멤버십 </option>
											</select>
										</td>
									</tr>
									<tr>
										<td>키워드검색</td>
										<td>
											<select name="Txt_key">
												<option value="all" <? if ($Txt_key == "all") { ?>selected<? } ?>> 통합검색 </option>
												<option value="str_name" <? if ($Txt_key == "str_name") { ?>selected<? } ?>> 이름 </option>
												<option value="str_userid" <? if ($Txt_key == "str_userid") { ?>selected<? } ?>> 아이디 </option>
											</select>
											<input type="text" NAME="Txt_word" value="<?= $Txt_word ?>" style="width:300px;" onkeydown="javascript: if (event.keyCode == 13) {fnc_search();}">
										</td>
										<td>상태</td>
										<td>
											<select name="Txt_pass">
												<option value="" selected> 선택 </option>
												<option value="0" <? if ($Txt_pass == "0") { ?>selected<? } ?>> 결제완료(구독) </option>
												<option value="1" <? if ($Txt_pass == "1") { ?>selected<? } ?>> 결제취소(구독) </option>
												<option value="2" <? if ($Txt_pass == "2") { ?>selected<? } ?>> 결제완료(렌트) </option>
												<option value="3" <? if ($Txt_pass == "3") { ?>selected<? } ?>> 결제취소(렌트) </option>
											</select>
										</td>
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
										<td class=pageInfo>총 <b><?= $total_record ?></b>건, <b><?= $page ?></b> of <?= $total_page ?> Pages</td>
										<td align=right>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="str_exceltype">
												<option value="1">선택한 자료
												<option value="2">현재 검색리스트의 자료
											</select>
											<img src="/admincenter/img/bt_04.gif" alt="엑셀다운" border=0 align=absmiddle style="cursor:pointer" onClick="fnc_Excel()">
											&nbsp;
											<select name=displayrow onchange="fnc_search()">
												<? for ($i = 10; $i <= 100; $i += 10) { ?>
													<option value="<?= $i ?>" <? if (Trim($i) == trim($displayrow)) { ?>selected<? } ?>><?= $i ?>개 출력
													<? } ?>
											</select>
										</td>
									</tr>
								</table>

								<table width=100% cellpadding=0 cellspacing=0 border=0>
									<tr>
										<td class=rnd colspan=13></td>
									</tr>
									<tr class=rndbg>
										<th>번호</th>
										<th>구분</th>
										<th>이름</th>
										<th>핸드폰</th>
										<th>유효상태</th>
										<th>카드종류</th>
										<th>취소신청(구독)</th>
										<th>상태(구독)</th>
										<th>취소신청(렌트)</th>
										<th>상태(렌트)</th>
										<th>등록일</th>
										<th>보기</th>
										<th>선택</th>
									</tr>
									<tr>
										<td class=rnd colspan=13></td>
									</tr>
									<col width=5% align=center>
									<col width=10% align=center>
									<col width=10% align=center>
									<col width=10% align=left>
									<col width=5% align=left>
									<col width=10% align=left>
									<col width=8% align=center>
									<col width=8% align=center>
									<col width=8% align=center>
									<col width=8% align=center>
									<col width=8% align=center>
									<col width=5% align=center>
									<col width=5% align=center>
									<? $count = 0; ?>
									<? if ($total_record_limit != 0) { ?>
										<? $article_num = $total_record - $displayrow * ($page - 1); ?>
										<? for ($i = 0; $i <= $displayrow - 1; $i++) { ?>
											<tr height=30 align="center">
												<td>
													<font class=ver81 color=616161><?= $article_num ?></font>
												</td>
												<td>
													<font color=616161>
														<?php
														if (mysql_result($result, $i, 'sub_int') == 0 && mysql_result($result, $i, 'ren_int') == 0) {
															echo "일반회원";
														} else {
															if (mysql_result($result, $i, 'sub_int') > 0) {
																echo "구독멤버십 |";
															}
															if (mysql_result($result, $i, 'ren_int') > 0) {
																echo "| 렌트멤버십";
															}
														}
														?>
													</font>
												</td>
												<td><span id="navig" name="navig" m_id="admin" m_no="1">
														<font color=0074BA><b><?= mysql_result($result, $i, str_name) ?></b></font>(<?= mysql_result($result, $i, str_userid) ?>)
													</span></td>
												<td align="text-align:center"><?= mysql_result($result, $i, str_hp) ?></td>
												<td><?= mysql_result($result, $i, 'str_using') == 'Y' ? '유효함' : '만료됨' ?></td>
												<td><?= fnc_card_kind(mysql_result($result, $i, 'str_cardcode')) ?></td>
												<td>
													<? switch (mysql_result($result, $i, 'str_cancel1')) {
														case  "0":
															echo "-";
															break;
														case  "1":
															echo "결제취소신청중";
															break;
													}
													?>
												</td>
												<td>
													<font color=616161>
														<? switch (mysql_result($result, $i, 'str_pass1')) {
															case  "0":
																echo "결제완료";
																break;
															case  "1":
																echo "결제취소";
																break;
														}
														?>
													</font>
												</td>
												<td>
													<? switch (mysql_result($result, $i, 'str_cancel2')) {
														case  "0":
															echo "-";
															break;
														case  "1":
															echo "결제취소신청중";
															break;
													}
													?>
												</td>
												<td>
													<font color=616161>
														<? switch (mysql_result($result, $i, 'str_pass2')) {
															case  "0":
																echo "결제완료";
																break;
															case  "1":
																echo "결제취소";
																break;
														}
														?>
													</font>
												</td>
												<td>
													<font class=ver81 color=616161><?= mysql_result($result, $i, dtm_indate) ?></font>
												</td>
												<td><a href="javascript:RowClick('<?= mysql_result($result, $i, 'int_number') ?>', '0');"><img src="/admincenter/img/btn_viewbbs.gif"></a></td>
												<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?= mysql_result($result, $i, int_number) ?>"></td>
											</tr>
											<tr>
												<td colspan=13 class=rndline></td>
											</tr>
											<tr>
												<td colspan="6" style="vertical-align: top;">
													<?
													$Sql_Query =	" SELECT
																		A.*
																	FROM 
																		`" . $Tname . "comm_member_pay_info` A
																	WHERE
																		A.INT_NUMBER='" . mysql_result($result, $i, 'int_number') . "'
																		AND A.INT_TYPE=1
																	ORDER BY
																		A.INT_SNUMBER DESC ";
													$arr_Data2 = mysql_query($Sql_Query);
													$arr_Data2_Cnt = mysql_num_rows($arr_Data2);
													?>
													<table width=100% cellpadding=0 cellspacing=0 border=0>
														<col width=10% align=center>
														<col width=10% align=center>
														<col width=10% align=center>
														<col width=20% align=center>
														<tr height=25 align="left">
															<td style="padding-left:100px;width:100%;">
																<font style="background-color: #e5e5e5;">구독멤버십결제정보</font>
																<?php
																if (mysql_result($result, $i, 'str_using') == "Y" && mysql_result($result, $i, 'str_pass1') == "0") {
																?>
																	<a href="javascript:popupLayer('pay_bill_edit.php?str_no=<?= mysql_result($result, $i, 'int_number') ?>&int_type=1',800,500);">
																		<font color="red">[빌링작업]</font>
																	</a>
																<?php
																}
																?>
															</td>
														</tr>
														<?
														for ($int_I = 0; $int_I < $arr_Data2_Cnt; $int_I++) {
														?>
															<tr height=25 align="left">
																<td style="padding-left:100px;width:100%;">
																	<font class=ver81 color=616161><?= $int_I + 1 ?></font>]
																	<?= number_format(mysql_result($arr_Data2, $int_I, 'int_sprice')) ?>원
																	/
																	<?= mysql_result($arr_Data2, $int_I, 'str_sdate') ?> ~ <?= mysql_result($arr_Data2, $int_I, 'str_edate') ?>
																	<a href="javascript:popupLayer('pay_date_edit.php?str_no=<?= mysql_result($arr_Data2, $int_I, 'int_snumber') ?>',500,230);"><img src="/admincenter/img/btn_viewbbs.gif" align="absmiddle"></a>
																	/
																	<?= mysql_result($arr_Data2, $int_I, 'dtm_indate') ?>
																	/
																	<?= mysql_result($arr_Data2, $int_I, 'str_oidxcode') ?>
																</td>
															</tr>
														<? } ?>
													</table>
												</td>
												<td colspan="7" style="vertical-align: top;">
													<?
													$Sql_Query =	" SELECT
																		A.*
																	FROM 
																		`" . $Tname . "comm_member_pay_info` A
																	WHERE
																		A.INT_NUMBER='" . mysql_result($result, $i, 'int_number') . "'
																		AND A.INT_TYPE=2
																	ORDER BY
																		A.INT_SNUMBER DESC ";
													$arr_Data2 = mysql_query($Sql_Query);
													$arr_Data2_Cnt = mysql_num_rows($arr_Data2);
													?>
													<table width=100% cellpadding=0 cellspacing=0 border=0>
														<col width=10% align=center>
														<col width=10% align=center>
														<col width=10% align=center>
														<col width=20% align=center>
														<tr height=25 align="left">
															<td style="padding-left:100px;width:100%;">
																<font style="background-color: #e5e5e5;">렌트멤버십결제정보</font>
																<?php
																if (mysql_result($result, $i, 'str_using') == "Y" && mysql_result($result, $i, 'str_pass2') == "0") {
																?>
																	<a href="javascript:popupLayer('pay_bill_edit.php?str_no=<?= mysql_result($result, $i, 'int_number') ?>&int_type=2',800,500);">
																		<font color="red">[빌링작업]</font>
																	</a>
																<?php
																}
																?>
															</td>
														</tr>
														<?
														for ($int_I = 0; $int_I < $arr_Data2_Cnt; $int_I++) {
														?>
															<tr height=25 align="left">
																<td style="padding-left:100px;width:100%;">
																	<font class=ver81 color=616161><?= $int_I + 1 ?></font>]
																	<?= number_format(mysql_result($arr_Data2, $int_I, 'int_sprice')) ?>원
																	/
																	<?= mysql_result($arr_Data2, $int_I, 'str_sdate') ?> ~ <?= mysql_result($arr_Data2, $int_I, 'str_edate') ?>
																	<a href="javascript:popupLayer('pay_date_edit.php?str_no=<?= mysql_result($arr_Data2, $int_I, 'int_snumber') ?>',500,230);"><img src="/admincenter/img/btn_viewbbs.gif" align="absmiddle"></a>
																	/
																	<?= mysql_result($arr_Data2, $int_I, 'dtm_indate') ?>
																	/
																	<?= mysql_result($arr_Data2, $int_I, 'str_oidxcode') ?>
																</td>
															</tr>
														<? } ?>
													</table>
												</td>
											</tr>
											<tr>
												<td colspan=13 style="padding-top:0px;padding-bottom:5px;">
													<table class=tb>
														<col class=cellC style="width:10%">
														<col class=cellL style="width:90%">
														<tr>
															<td>관리자메모</td>
															<td style="height:20px;" valign="top">
																<font class=def><?= str_replace(chr(13), "<br>", Fnc_Om_Conv_Default(mysql_result($result, $i, str_amemo), "")) ?>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td colspan=13 class=rndline></td>
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
										<a href="Javascript:MovePageA('1');" class=navi>◀◀</a>
									<? } else { ?>
										◀◀
									<? }

									if ($block > 1) {
										$my_page = $first_page;
									?>
										<a href="Javascript:MovePageA('<?= $my_page ?>');" class=navi>◀</a>
									<? } else { ?>
										◀
										<? }

									echo " | ";
									for ($direct_page = $first_page + 1; $direct_page <= $last_page; $direct_page++) {
										if ($page == $direct_page) { ?>
											<font color='cccccc'><b><?= $direct_page ?></b></font> |
										<? } else { ?>
											<a href="Javascript:MovePageA('<?= $direct_page ?>');" class=navi><?= $direct_page ?></a> |
										<? }
									}

									echo " ";

									if ($block < $total_block) {
										$my_page = $last_page + 1; ?>
										<a href="Javascript:MovePageA('<?= $my_page ?>');" class=navi>▶</a>
									<? } else { ?>
										▶
									<? }

									if ($page < $total_page) { ?>
										<a href="Javascript:MovePageA('<?= $total_page ?>');" class=navi>▶▶</a>
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