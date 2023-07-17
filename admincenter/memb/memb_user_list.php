<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
$page = Fnc_Om_Conv_Default($_REQUEST[page], 1);
$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow], 20);
$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage], 10);

$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key], "all");
$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word], "");
$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service], "");
$Txt_gubun = Fnc_Om_Conv_Default($_REQUEST[Txt_gubun], "");
$Txt_sms_f = Fnc_Om_Conv_Default($_REQUEST[Txt_sms_f], "");
$Txt_mail_f = Fnc_Om_Conv_Default($_REQUEST[Txt_mail_f], "");
$Txt_grade = Fnc_Om_Conv_Default($_REQUEST[Txt_grade], "");

$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate], "");
$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate], "");
$Txt_sacdate = Fnc_Om_Conv_Default($_REQUEST[Txt_sacdate], "");
$Txt_eacdate = Fnc_Om_Conv_Default($_REQUEST[Txt_eacdate], "");

if ($Txt_word != "") {
	switch ($Txt_key) {
		case  "all":
			$Str_Query = " and (a.str_userid like '%$Txt_word%' or a.str_name like '%$Txt_word%' or a.str_email like '%$Txt_word%' or replace(a.str_telep,'-','') like '%" . str_replace('-', '', $Txt_word) . "%' or replace(a.str_hp,'-','') like '%" . str_replace('-', '', $Txt_word) . "%') ";
			break;
		case  "str_userid":
			$Str_Query = " and a.str_userid like '%$Txt_word%' ";
			break;
		case  "str_name":
			$Str_Query = " and a.str_name like '%$Txt_word%' ";
			break;
		case  "str_email":
			$Str_Query = " and a.str_email like '%$Txt_word%' ";
			break;
		case  "str_telep":
			$Str_Query = " and a.str_telep like '%$Txt_word%' ";
			break;
		case  "str_hp":
			$Str_Query = " and a.str_hp like '%$Txt_word%' ";
			break;
	}
}

if ($Txt_service != "") {
	$Str_Query .= " and a.str_service = '$Txt_service' ";
}
if ($Txt_gubun != "") {
	if ($Txt_gubun == "0") {
		$Str_Query .= " and (b.int_number IS NULL and c.int_number IS NULL) ";
	}
	if ($Txt_gubun == "1") {
		$Str_Query .= " and c.int_number IS NOT NULL ";
	}
	if ($Txt_gubun == "2") {
		$Str_Query .= " and b.int_number IS NOT NULL ";
	}
	if ($Txt_gubun == "3") {
		$Str_Query .= " and (b.int_number IS NOT NULL and c.int_number IS NOT NULL) ";
	}
}
if ($Txt_sms_f != "") {
	$Str_Query .= " and a.str_sms_f = '$Txt_sms_f' ";
}
if ($Txt_mail_f != "") {
	$Str_Query .= " and a.str_mail_f = '$Txt_mail_f' ";
}

if ($Txt_grade) {
	$Str_Query .= " and a.str_grade = '$Txt_grade' ";
}

if ($Txt_sindate != "") {
	$Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";
}
if ($Txt_eindate != "") {
	$Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";
}

if ($Txt_sacdate != "") {
	$Str_Query .= " and date_format(a.dtm_acdate, '%Y-%m-%d') >= '$Txt_sacdate' ";
}
if ($Txt_eacdate != "") {
	$Str_Query .= " and date_format(a.dtm_acdate, '%Y-%m-%d') <= '$Txt_eacdate' ";
}

$SQL_QUERY = 	"select 
					count(a.str_userid) 
				from 
					" . $Tname . "comm_member a 
				LEFT JOIN 
					" . $Tname . "comm_membership b 
				ON
					a.str_userid = b.str_userid
					AND NOW() BETWEEN b.dtm_sdate AND b.dtm_edate
					AND b.int_type = 1
					AND b.str_pass = '0'
				LEFT JOIN 
					" . $Tname . "comm_membership c 
				ON
					a.str_userid = c.str_userid
					AND NOW() BETWEEN c.dtm_sdate AND c.dtm_edate
					AND c.int_type = 2
					AND c.str_pass = '0'
				where a.int_gubun<=2 ";
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

$SQL_QUERY = 	"SELECT a.*, ifnull(b.int_number, 0) as sub_int, ifnull(c.int_number, 0) as ren_int, (SELECT count(d.int_number) FROM " . $Tname . "comm_member_coupon d WHERE a.str_userid = d.str_userid AND NOW() BETWEEN d.dtm_sdate AND d.dtm_edate) as coupon_num
				FROM 
					" . $Tname . "comm_member a 
				LEFT JOIN 
					" . $Tname . "comm_membership b 
				ON
					a.str_userid = b.str_userid
					AND NOW() BETWEEN b.dtm_sdate AND b.dtm_edate
					AND b.int_type = 1
					AND b.str_pass = '0'
				LEFT JOIN 
					" . $Tname . "comm_membership c 
				ON
					a.str_userid = c.str_userid
					AND NOW() BETWEEN c.dtm_sdate AND c.dtm_edate
					AND c.int_type = 2
					AND c.str_pass = '0'
				WHERE a.int_gubun<=2 ";
$SQL_QUERY .= $Str_Query;
$SQL_QUERY .= "order by a.dtm_indate desc ";
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
	<script language="javascript" src="js/memb_user_list.js"></script>
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

							<form id="frm" name="frm" target="_self" method="POST" action="memb_user_list.php">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="str_no">


								<table class=tb>
									<col class=cellC style="width:12%">
									<col class=cellL style="width:38%">
									<col class=cellC style="width:12%">
									<col class=cellL style="width:38%">
									<tr>
										<td>키워드검색</td>
										<td>
											<select name="Txt_key">
												<option value="all" <? if ($Txt_key == "all") { ?>selected<? } ?>> 통합검색 </option>
												<option value="str_userid" <? if ($Txt_key == "str_userid") { ?>selected<? } ?>> 아이디 </option>
												<option value="str_name" <? if ($Txt_key == "str_name") { ?>selected<? } ?>> 회원명 </option>
												<option value="str_email" <? if ($Txt_key == "str_email") { ?>selected<? } ?>> 이메일 </option>
												<option value="str_telep" <? if ($Txt_key == "str_telep") { ?>selected<? } ?>> 전화번호 </option>
												<option value="str_hp" <? if ($Txt_key == "str_hp") { ?>selected<? } ?>> 휴대폰번호 </option>
											</select>
											<input type="text" NAME="Txt_word" value="<?= $Txt_word ?>" style="width:300px;" onkeydown="javascript: if (event.keyCode == 13) {fnc_search();}">
										</td>
										<td>승인여부</td>
										<td>
											<select name="Txt_service">
												<option value="" selected> 전체 </option>
												<option value="A" <? if ($Txt_service == "A") { ?>selected<? } ?>> 대기 </option>
												<option value="Y" <? if ($Txt_service == "Y") { ?>selected<? } ?>> 승인 </option>
												<option value="N" <? if ($Txt_service == "N") { ?>selected<? } ?>> 미승인 </option>
												<option value="E" <? if ($Txt_service == "E") { ?>selected<? } ?>> 탈퇴 </option>
											</select>
										</td>
									</tr>
									<tr>
										<td>회원구분</td>
										<td>
											<select name="Txt_gubun">
												<option value="" selected> 전체 </option>
												<option value="0" <? if ($Txt_gubun == "0") { ?>selected<? } ?>> 일반회원 </option>
												<option value="1" <? if ($Txt_gubun == "1") { ?>selected<? } ?>> 렌트멤버십 </option>
												<option value="2" <? if ($Txt_gubun == "2") { ?>selected<? } ?>> 구독멤버십 </option>
												<option value="3" <? if ($Txt_gubun == "3") { ?>selected<? } ?>> 렌트/구독멤버십 </option>
											</select>
										</td>
										<td>태그등급</td>
										<td>
											<input type="checkbox" name="Txt_grade" id="Txt_grade" value="B" <? if ($Txt_grade == "B") { ?>checked<? } ?>><label for="Txt_grade">BLACK</label>
										</td>
									</tr>
									<tr style="display:none;">
										<td>SMS수신여부</td>
										<td>
											<input type="radio" value="" name="Txt_sms_f" class=null <? if ($Txt_sms_f == "") { ?>checked<? } ?>> 전체
											<input type="radio" value="Y" name="Txt_sms_f" class=null <? if ($Txt_sms_f == "Y") { ?>checked<? } ?>> 수신함
											<input type="radio" value="N" name="Txt_sms_f" class=null <? if ($Txt_sms_f == "N") { ?>checked<? } ?>> 수신안함
										</td>
										<td>메일수신여부</td>
										<td>
											<input type="radio" value="" name="Txt_mail_f" class=null <? if ($Txt_mail_f == "") { ?>checked<? } ?>> 전체
											<input type="radio" value="Y" name="Txt_mail_f" class=null <? if ($Txt_mail_f == "Y") { ?>checked<? } ?>> 수신함
											<input type="radio" value="N" name="Txt_mail_f" class=null <? if ($Txt_mail_f == "N") { ?>checked<? } ?>> 수신안함
										</td>
									</tr>
									<tr>
										<td>가입일</td>
										<td colspan="3">
											<input type=text name=Txt_sindate value="<?= $Txt_sindate ?>" id="Txt_sindate" onclick="displayCalendar(document.frm.Txt_sindate ,'yyyy-mm-dd',this)">
											<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.Txt_sindate ,'yyyy-mm-dd',document.frm.Txt_sindate)">
											<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.Txt_sindate.value=''" ;>
											-
											<input type=text name=Txt_eindate value="<?= $Txt_eindate ?>" id="Txt_eindate" onclick="displayCalendar(document.frm.Txt_eindate ,'yyyy-mm-dd',this)">
											<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.Txt_eindate ,'yyyy-mm-dd',document.frm.Txt_eindate)">
											<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.Txt_eindate.value=''" ;>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?= date("Y-m-d") ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_today.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?= date("Y-m-d", strtotime($day . "-7day")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_week.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?= date("Y-m-d", strtotime($day . "-15day")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_twoweek.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?= date("Y-m-d", strtotime($month . "-1month")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_month.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?= date("Y-m-d", strtotime($month . "-2month")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_twomonth.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sindate','Txt_eindate','','')"><img src="/admincenter/img/sicon_all.gif" align=absmiddle></a>
										</td>
									</tr>
									<tr>
										<td>최종로그인</td>
										<td colspan="3">
											<input type=text name=Txt_sacdate value="<?= $Txt_sacdate ?>" onclick="displayCalendar(document.frm.Txt_sacdate ,'yyyy-mm-dd',this)">
											<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.Txt_sacdate ,'yyyy-mm-dd',document.frm.Txt_sacdate)">
											<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.Txt_sacdate.value=''" ;>
											-
											<input type=text name=Txt_eacdate value="<?= $Txt_eacdate ?>" onclick="displayCalendar(document.frm.Txt_eacdate ,'yyyy-mm-dd',this)">
											<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.Txt_eacdate ,'yyyy-mm-dd',document.frm.Txt_eacdate)">
											<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.Txt_eacdate.value=''" ;>
											<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','<?= date("Y-m-d") ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_today.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','<?= date("Y-m-d", strtotime($day . "-7day")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_week.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','<?= date("Y-m-d", strtotime($day . "-15day")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_twoweek.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','<?= date("Y-m-d", strtotime($month . "-1month")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_month.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','<?= date("Y-m-d", strtotime($month . "-2month")) ?>','<?= date("Y-m-d") ?>')"><img src="/admincenter/img/sicon_twomonth.gif" align=absmiddle></a>
											<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','','')"><img src="/admincenter/img/sicon_all.gif" align=absmiddle></a>
										</td>
									</tr>
								</table>

								<div class=button_top><img src="/admincenter/img/btn_search2.gif" style="cursor:hand" onClick="fnc_search();"></div>


								<table width=100%>
									<tr>
										<td class=pageInfo>총 <b><?= $total_record ?></b>명, <b><?= $page ?></b> of <?= $total_page ?> Pages</td>
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
										<td class=rnd colspan=15></td>
									</tr>
									<tr class=rndbg>
										<th>번호</th>
										<th>아이디</th>
										<th>이름</th>
										<th>태그등급</th>
										<th>이메일</th>
										<th>핸드폰</th>
										<th>적립금</th>
										<th>방문수</th>
										<th>쿠폰</th>
										<th>가입일</th>
										<th>입고알림</th>
										<th>최종로그인</th>
										<th>승인</th>
										<th>수정</th>
										<th>선택</th>
									</tr>
									<tr>
										<td class=rnd colspan=15></td>
									</tr>
									<col width=5% align=center>
									<col width=6% align=center>
									<col width=16% align=center>
									<col width=6% align=center>
									<col width=8% align=center>
									<col width=6% align=center>
									<col width=8% align=center>
									<col width=8% align=center>
									<col width=4% align=center>
									<col width=7% align=center>
									<col width=4% align=center>
									<col width=10% align=center>
									<col width=4% align=center>
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
												<td><?= mysql_result($result, $i, str_userid) ?></td>
												<td><span id="navig" name="navig" m_id="admin" m_no="1">
														<font color=0074BA><b><?= mysql_result($result, $i, str_name) ?>
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
													</span>
													<? if (mysql_result($result, $i, str_cert) == "M") { ?><font color="red">[인증]</font><? } ?>
												</td>
												<td align=center><?= mysql_result($result, $i, str_grade) == 'B' ? 'BLACK' : 'GREEN' ?></td>
												<td align=center><?= mysql_result($result, $i, str_email) ?></td>
												<td align=center><?= mysql_result($result, $i, str_hp) ?></td>
												<td align=center><?= number_format(mysql_result($result, $i, 'int_mileage')) ?>원 <a href="javascript:popupLayer('memb_user_stamp_list.php?str_userid=<?= mysql_result($result, $i, 'str_userid') ?>',800,500)"><img src="/admincenter/img/btn_viewbbs.gif" align="absmiddle"></a></td>
												<td>
													<font class=ver81 color=616161><?= mysql_result($result, $i, int_login) ?></font>
												</td>
												<td align=center><span id="idView_Link<?= mysql_result($result, $i, 'str_userid') ?>"><?= number_format(mysql_result($result, $i, 'coupon_num')) ?></span> <a href="javascript:popupLayer('memb_user_coupon_list.php?str_userid=<?= mysql_result($result, $i, 'str_userid') ?>',800,500)"><img src="/admincenter/img/btn_viewbbs.gif" align="absmiddle"></a></td>
												<td>
													<font class=ver81 color=616161><?= substr(mysql_result($result, $i, dtm_indate), 0, 10) ?></font>
												</td>
												<td>0</td>
												<td>
													<font class=ver81 color=616161>
														<font color=#7070B8><?= mysql_result($result, $i, dtm_acdate) ?></font>
													</font>
												</td>
												<td>
													<font class=small color=616161>
														<? switch (mysql_result($result, $i, str_service)) {
															case  "Y":
																echo "승인";
																break;
															case  "A":
																echo "대기";
																break;
															case  "N":
																echo "미승인";
																break;
															case  "E":
																echo "탈퇴";
																break;
														}
														?>
													</font>
												</td>
												<td><a href="javascript:RowClick('<?= mysql_result($result, $i, str_userid) ?>');"><img src="/admincenter/img/i_edit.gif"></a></td>
												<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?= mysql_result($result, $i, str_userid) ?>"></td>
											</tr>
											<tr>
												<td colspan=15 class=rndline></td>
											</tr>
											<?
											$article_num--;
											if ($article_num == 0) {
												break;
											}
											?>
											<? $count++; ?>
										<? } ?>
									<? } ?>
									<input type="hidden" name="txtRows" value="<%=count%>">
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
									<img src="/admincenter/img/btn_regist_s.gif" alt="등록" border=0 align=absmiddle style="cursor:hand" onClick="AddNew();">
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