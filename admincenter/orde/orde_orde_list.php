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

$Txt_gbn = Fnc_Om_Conv_Default($_REQUEST[Txt_gbn], "1");
$Txt_state = Fnc_Om_Conv_Default($_REQUEST[Txt_state], "");

$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key], "all");
$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word], "");

$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate], "");
$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate], "");

if ($Txt_gbn == "1") {
	$Str_Query .= " and a.int_state in ('1','2','3','4') ";
} else {
	$Str_Query .= " and a.int_state in ('5','10','11') ";
}

if ($int_type) {
	$Str_Query .= " and c.int_type=" . $int_type . " ";
}

if ($Txt_state != "") {
	$Str_Query .= " and a.int_state = '$Txt_state' ";
}

if ($Txt_word != "") {
	switch ($Txt_key) {
		case  "all":
			$Str_Query .= " and (a.str_userid like '%$Txt_word%' or a.str_name like '%$Txt_word%' or c.str_goodname like '%$Txt_word%' or replace(b.str_hp,'-','') like '%" . str_replace('-', '', $Txt_word) . "%' or e.str_usercode like '%$Txt_word%' ) ";
			break;
		case  "str_userid":
			$Str_Query .= " and a.str_userid like '%$Txt_word%' ";
			break;
		case  "str_name":
			$Str_Query .= " and a.str_name like '%$Txt_word%' ";
			break;
		case  "str_goodname":
			$Str_Query .= " and a.str_goodname like '%$Txt_word%' ";
			break;
		case  "str_hp":
			$Str_Query .= " and replace(b.str_hp,'-','') like '%" . str_replace('-', '', $Txt_word) . "%' ";
			break;
		case  "str_usercode":
			$Str_Query .= " and e.str_usercode like '%$Txt_word%' ";
			break;
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
$SQL_QUERY .= 	"comm_goods_cart a 
				left join 
					" . $Tname . "comm_member b 
				on 
					a.str_userid=b.str_userid 
				left join 
					" . $Tname . "comm_goods_master c 
				on 
					a.str_goodcode=c.str_goodcode 
				left join 
					" . $Tname . "comm_goods_master_sub e 
				on 
					a.str_sgoodcode=e.str_sgoodcode 
				where a.int_number is not null and a.int_state not in ('0') ";
$SQL_QUERY .= $Str_Query;
$result = mysql_query($SQL_QUERY);

if (!$result) {
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

$SQL_QUERY = "select a.*,b.str_name,b.str_hp as member_hp,c.str_goodname,e.str_usercode,(select count(d.str_userid) from " . $Tname . "comm_member_alarm d where d.str_goodcode=a.str_goodcode) as cnt3, ifnull(f.int_number, 0) as sub_int, ifnull(g.int_number, 0) as ren_int from ";
$SQL_QUERY .= $Tname;
$SQL_QUERY .= "comm_goods_cart a left join " . $Tname . "comm_member b on a.str_userid=b.str_userid left join " . $Tname . "comm_goods_master c on a.str_goodcode=c.str_goodcode left join " . $Tname . "comm_goods_master_sub e on a.str_sgoodcode=e.str_sgoodcode  ";
$SQL_QUERY .= 	"LEFT JOIN 
					" . $Tname . "comm_membership f 
				ON
					b.str_userid = f.str_userid
					AND NOW() BETWEEN f.dtm_sdate AND f.dtm_edate
					AND f.int_type = 1
					AND f.str_pass = '0'
				LEFT JOIN 
					" . $Tname . "comm_membership g 
				ON
					b.str_userid = g.str_userid
					AND NOW() BETWEEN g.dtm_sdate AND g.dtm_edate
					AND g.int_type = 2
					AND g.str_pass = '0'";
$SQL_QUERY .= "where a.int_number is not null and a.int_state not in ('0') ";
$SQL_QUERY .= $Str_Query;
if ($Txt_gbn == "1") {
	$SQL_QUERY .= "order by a.dtm_indate desc ";
} else {
	$SQL_QUERY .= "order by a.str_rdate desc ";
}
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
	<script language="javascript" src="js/orde_orde_list.js"></script>
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

							<form id="frm" name="frm" target="_self" method="POST" action="orde_orde_list.php">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="Txt_gbn" value="<?= $Txt_gbn ?>">
								<input type="hidden" name="str_no">
								<input type="hidden" name="int_type" value="<?= $int_type ?>">

								<table class=tb>
									<col class=cellC style="width:12%">
									<col class=cellL style="width:88%">
									<tr>
										<td>상태</td>
										<td colspan="3">
											<select name="Txt_state">
												<option value="" selected> 선택 </option>
												<? if ($Txt_gbn == "1") { ?>
													<option value="1" <? if ($Txt_state == "1") { ?>selected<? } ?>> 접수 </option>
													<option value="2" <? if ($Txt_state == "2") { ?>selected<? } ?>> 관리자확인 </option>
													<option value="3" <? if ($Txt_state == "3") { ?>selected<? } ?>> 발송 </option>
													<option value="4" <? if ($Txt_state == "4") { ?>selected<? } ?>> 배송완료 </option>
												<? } else { ?>
													<option value="5" <? if ($Txt_state == "5") { ?>selected<? } ?>> 반납접수 </option>
													<option value="10" <? if ($Txt_state == "10") { ?>selected<? } ?>> 반납완료 </option>
													<option value="11" <? if ($Txt_state == "11") { ?>selected<? } ?>> 취소 </option>
												<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>키워드검색</td>
										<td colspan="3">
											<select name="Txt_key">
												<option value="all" <? if ($Txt_key == "all") { ?>selected<? } ?>> 통합검색 </option>
												<option value="str_userid" <? if ($Txt_key == "str_userid") { ?>selected<? } ?>> 아이디 </option>
												<option value="str_name" <? if ($Txt_key == "str_name") { ?>selected<? } ?>> 이름 </option>
												<option value="str_goodname" <? if ($Txt_key == "str_goodname") { ?>selected<? } ?>> 상품명 </option>
												<option value="str_hp" <? if ($Txt_key == "str_hp") { ?>selected<? } ?>> 핸드폰 </option>
												<option value="str_usercode" <? if ($Txt_key == "str_usercode") { ?>selected<? } ?>> 서브상품코드 </option>
											</select>
											<input type="text" NAME="Txt_word" value="<?= $Txt_word ?>" style="width:300px;" onkeydown="javascript: if (event.keyCode == 13) {fnc_search();}">
										</td </tr>
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
										<td class=rnd colspan="<?= $int_type != 3 ? '12' : '10' ?>"></td>
									</tr>
									<tr class=rndbg>
										<th>번호</th>
										<th>아이디</th>
										<th>이름</th>
										<th>상품</th>
										<?php
										if ($int_type != 3) {
										?>
											<th>기간</th>
										<?php
										}
										?>
										<th>핸드폰</th>
										<?php
										if ($int_type != 3) {
										?>
											<th>반납일자</th>
										<?php
										}
										?>
										<th>상태</th>
										<th>입고알림</th>
										<th>등록일</th>
										<th>보기</th>
										<th>선택</th>
									</tr>
									<tr>
										<td class=rnd colspan="<?= $int_type != 3 ? '12' : '10' ?>"></td>
									</tr>
									<col width=4% align=center>
									<col width=7% align=center>
									<col width=11% align=center>
									<col width=16% align=left>
									<?php
									if ($int_type != 3) {
									?>
										<col width=15% align=left>
									<?php
									}
									?>
									<col width=5% align=center>
									<?php
									if ($int_type != 3) {
									?>
										<col width=8% align=center>
									<?php
									}
									?>
									<col width=8% align=center>
									<col width=8% align=center>
									<col width=10% align=center>
									<col width=4% align=center>
									<col width=4% align=center>
									<? $count = 0; ?>
									<? if ($total_record_limit != 0) { ?>
										<? $article_num = $total_record - $displayrow * ($page - 1); ?>
										<? for ($i = 0; $i <= $displayrow - 1; $i++) { ?>
											<tr height=30 align="center">
												<td>
													<font class=ver81 color=616161><?= $article_num ?></font>
												</td>
												<td>
													<font color=616161><?= mysql_result($result, $i, str_userid) ?></font>
												</td>
												<td><span id="navig" name="navig" m_id="admin" m_no="1">
														<font color=0074BA><b><?= mysql_result($result, $i, 'str_name') ?>
																(
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
																)
															</b></font>
													</span></td>
												<td style="text-align:left;">[<?= mysql_result($result, $i, str_usercode) ?>] <?= mysql_result($result, $i, str_goodname) ?></td>
												<?php
												if ($int_type != 3) {
												?>
													<td><?= mysql_result($result, $i, str_sdate) ?>~<?= mysql_result($result, $i, str_edate) ?></td>
												<?php
												}
												?>
												<td><?= mysql_result($result, $i, member_hp) ?></td>
												<?php
												if ($int_type != 3) {
												?>
													<td><?= mysql_result($result, $i, str_rdate) ?></td>
												<?php
												}
												?>
												<td>
													<select name="int_state" onchange="fnc_state('<?= mysql_result($result, $i, int_number) ?>',this.value)">
														<option value="1" <? if (mysql_result($result, $i, int_state) == "1") { ?>selected<? } ?>> 접수 </option>
														<option value="2" <? if (mysql_result($result, $i, int_state) == "2") { ?>selected<? } ?>> 관리자확인 </option>
														<option value="3" <? if (mysql_result($result, $i, int_state) == "3") { ?>selected<? } ?>> 발송 </option>
														<option value="4" <? if (mysql_result($result, $i, int_state) == "4") { ?>selected<? } ?>> 배송완료 </option>
														<option value="5" <? if (mysql_result($result, $i, int_state) == "5") { ?>selected<? } ?>> 반납접수 </option>
														<option value="10" <? if (mysql_result($result, $i, int_state) == "10") { ?>selected<? } ?>> 반납완료 </option>
														<option value="11" <? if (mysql_result($result, $i, int_state) == "11") { ?>selected<? } ?>> 취소 </option>
													</select>

													<!--
									<? switch (mysql_result($result, $i, int_state)) {
												case  "1":
													echo "접수";
													break;
												case  "2":
													echo "관리자확인";
													break;
												case  "3":
													echo "발송";
													break;
												case  "4":
													echo "배송완료";
													break;
												case  "5":
													echo "반납신청";
													break;
												case  "10":
													echo "반납완료";
													break;
												case  "11":
													echo "취소";
													break;
											}
									?>
									//-->
												</td>
												<td><?= mysql_result($result, $i, cnt3) ?>건 <a href="javascript:RowClick2('<?= mysql_result($result, $i, str_goodcode) ?>');"><img src="/admincenter/img/btn_viewbbs.gif" align="absmiddle"></a></td>
												<td>
													<font class=ver81 color=616161><?= mysql_result($result, $i, dtm_indate) ?></font>
												</td>
												<td>
													<? if ($Txt_gbn != "1") { ?>
														<? if (trim(mysql_result($result, $i, str_addr1)) == trim(mysql_result($result, $i, str_raddr1)) && trim(mysql_result($result, $i, str_addr2)) == trim(mysql_result($result, $i, str_raddr2))) { ?>
															<img src="/pub/img/icons/lightbulb_off.gif" align="absmiddle">
														<? } else { ?>
															<img src="/pub/img/icons/lightbulb.gif" align="absmiddle">
														<? } ?>
													<? } ?>
													<a href="javascript:RowClick('<?= mysql_result($result, $i, int_number) ?>');"><img src="/admincenter/img/btn_viewbbs.gif"></a>
												</td>
												<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?= mysql_result($result, $i, int_number) ?>"></td>
											</tr>
											<tr>
												<td colspan="<?= $int_type != 3 ? '12' : '10' ?>" style="padding-top:0px;padding-bottom:5px;">
													<table class=tb>
														<col class=cellC style="width:10%">
														<col class=cellL style="width:40%">
														<col class=cellC style="width:10%">
														<col class=cellL style="width:40%">
														<tr>
															<td>사용자메모</td>
															<td style="height:20px;" valign="top">
																<font class=def><?= str_replace(chr(13), "<br>", Fnc_Om_Conv_Default(mysql_result($result, $i, str_memo), "")) ?>
															</td>
															<td>관리자메모</td>
															<td style="height:20px;" valign="top">
																<font class=def><?= str_replace(chr(13), "<br>", Fnc_Om_Conv_Default(mysql_result($result, $i, str_amemo), "")) ?>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td colspan="<?= $int_type != 3 ? '12' : '10' ?>" class=rndline></td>
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