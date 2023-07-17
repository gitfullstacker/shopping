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

$Txt_name = Fnc_Om_Conv_Default($_REQUEST[Txt_name], "");

$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate], "");
$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate], "");

if ($Txt_name != "") {
	$Str_Query .= " and d.str_name like '%$Txt_name%' ";
}

if ($Txt_sindate != "") {
	$Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";
}
if ($Txt_eindate != "") {
	$Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";
}

$SQL_QUERY	= 	"SELECT 
					COUNT(a.int_number)
				FROM
					" . $Tname . "comm_member_pay a
				LEFT JOIN
					(
					SELECT 
						c.int_number, MAX(c.int_snumber) AS max_snumber
					FROM
						" . $Tname . "comm_member_pay_info c
					WHERE
						c.int_type = " . $int_type . "
					GROUP BY c.int_number
					) sub ON a.int_number = sub.int_number
				LEFT JOIN
					" . $Tname . "comm_member_pay_info b ON b.int_snumber = sub.max_snumber
				LEFT JOIN
					" . $Tname . "comm_member d ON a.str_userid = d.str_userid
				WHERE
					a.int_number IS NOT NULL
					AND a.str_using = 'Y'
					AND b.int_type = " . $int_type . "
					" . $Str_Query;

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

$SQL_QUERY	= 	"SELECT 
					DATE_ADD(b.str_edate, INTERVAL 1 DAY) AS str_sdate,
					DATE_ADD(b.str_edate, INTERVAL 1 MONTH) AS str_edate,
					a.*,
					d.str_name,
					d.str_hp,
					b.int_snumber,
					b.int_sprice
				FROM
					" . $Tname . "comm_member_pay a
				LEFT JOIN
					(
					SELECT 
						c.int_number, MAX(c.int_snumber) AS max_snumber
					FROM
						" . $Tname . "comm_member_pay_info c
					WHERE
						c.int_type = " . $int_type . "
					GROUP BY c.int_number
					) sub ON a.int_number = sub.int_number
				LEFT JOIN
					" . $Tname . "comm_member_pay_info b ON b.int_snumber = sub.max_snumber
				LEFT JOIN
					" . $Tname . "comm_member d ON a.str_userid = d.str_userid
				WHERE
					a.int_number IS NOT NULL
					AND a.str_using = 'Y'
					AND b.int_type = " . $int_type . "
					" . $Str_Query . "
				ORDER BY str_edate ASC
				LIMIT " . $f_limit . "," . $l_limit;

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
	<script language="javascript" src="js/pay_membship_list.js"></script>
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

							<form id="frm" name="frm" target="_self" method="POST" action="pay_membship_list.php">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="str_no">
								<input type="hidden" name="int_type" value="<?= $int_type ?>">

								<table class=tb>
									<col class=cellC style="width:12%">
									<col class=cellL style="width:88%">
									<tr>
										<td>이름</td>
										<td colspan="3">
											<input type="text" NAME="Txt_name" value="<?= $Txt_name ?>" style="width:300px;">
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
											<button type="button" onclick="popupLayer('pay_bill_edit.php?str_no=<?= mysql_result($result, $i, 'int_number') ?>&int_type=<?= $int_type ?>',800,500);">
												빌링작업
											</button>
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
										<td class=rnd colspan=11></td>
									</tr>
									<tr class=rndbg>
										<th>
											<input type="checkbox" name="check_all" id="check_all" onchange="fnc_All_Chk(document.frm_List)">
										</th>
										<th>번호</th>
										<th>이름</th>
										<th>핸드폰</th>
										<th>결제금액</th>
										<th>카드종류</th>
										<th>취소신청</th>
										<th>상태</th>
										<th>결제예정일</th>
										<th>등록일</th>
										<th>보기</th>
									</tr>
									<tr>
										<td class=rnd colspan=11></td>
									</tr>
									<col width=5% align=center>
									<col width=5% align=center>
									<col width=8% align=center>
									<col width=8% align=center>
									<col width=8% align=center>
									<col width=8% align=left>
									<col width=8% align=left>
									<col width=10% align=center>
									<col width=15% align=center>
									<col width=10% align=center>
									<col width=5% align=center>
									<? $count = 0; ?>
									<? if ($total_record_limit != 0) { ?>
										<? $article_num = $total_record - $displayrow * ($page - 1); ?>
										<? for ($i = 0; $i <= $displayrow - 1; $i++) { ?>
											<tr height=30 align="center">
												<td align="center">
													<input type="checkbox" name="int_number[]" value="<?= mysql_result($result, $i, int_number) ?>" style="border:0px;">
												</td>
												<td>
													<font class=ver81 color=616161><?= $article_num ?></font>
												</td>
												<td><span id="navig" name="navig" m_id="admin" m_no="1">
														<font color=0074BA><b><?= mysql_result($result, $i, str_name) ?></b></font>(<?= mysql_result($result, $i, str_userid) ?>)
													</span></td>
												<td><?= mysql_result($result, $i, str_hp) ?></td>
												<td><?= number_format(mysql_result($result, $i, int_sprice)) ?>원</td>
												<td><?= mysql_result($result, $i, str_cardcode) ?></td>
												<td>
													<? switch (mysql_result($result, $i, ($int_type == 1 ? 'str_cancel1' : 'str_cancel2'))) {
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
														<? switch (mysql_result($result, $i, $int_type == 1 ? 'str_pass1' : 'str_pass2')) {
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
												<td><?= mysql_result($result, $i, 'str_sdate') ?>~<?= mysql_result($result, $i, 'str_edate') ?>
													<a href="javascript:popupLayer('pay_bill_edit.php?str_no=<?= mysql_result($result, $i, 'int_number') ?>&int_type=<?= $int_type ?>',800,500);">
														<font color="red">[빌링작업]</font>
													</a>
												</td>
												<td>
													<font class=ver81 color=616161><?= mysql_result($result, $i, dtm_indate) ?></font>
												</td>
												<td><a href="javascript:RowClick('<?= mysql_result($result, $i, 'int_number') ?>', '<?= $int_type ?>');"><img src="/admincenter/img/btn_viewbbs.gif"></a></td>
											</tr>
											<tr>
												<td colspan=11 style="padding-top:0px;padding-bottom:5px;">
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
												<td colspan=11 class=rndline></td>
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
									<!--
						<img src="/admincenter/img/btn_allselect_s.gif" alt="전체선택"  border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('1');">
						<img src="/admincenter/img/btn_alldeselect_s.gif" alt="선택해제"  border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('2');">
						<img src="/admincenter/img/btn_alldelet_s.gif" alt="선택삭제" border="0" align='absmiddle' style="cursor:hand" onclick="javaScript:Adelete_Click();">
						//-->
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

		function fnc_All_Chk(pr_Form) {
			var obj_Form = pr_Form;
			try {
				var obj = document.getElementsByName("int_number[]");

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
	</script>
</body>

</html>