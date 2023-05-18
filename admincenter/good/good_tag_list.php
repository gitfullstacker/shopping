<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
$page1 = Fnc_Om_Conv_Default($_REQUEST[page1], 1);
$page2 = Fnc_Om_Conv_Default($_REQUEST[page2], 1);
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode], "");

$SQL_QUERY = "select ifnull(count(int_tag),0) as seq from " . $Tname . "comm_goods_master_tag where str_goodcode = '" . $str_goodcode . "' ";
$arr_Data = mysql_query($SQL_QUERY);
$idView_Link = mysql_result($arr_Data, 0, seq);
?>
<html>

<head>
	<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php"; ?>
	<script language="javascript" src="js/good_tag_list.js"></script>
	<script language="javascript">
		parent.document.getElementById("idView_Link<?= $str_goodcode ?>").innerHTML = "<?= $idView_Link ?>건";
	</script>
</head>

<body class=scroll>
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<form id="frm" name="frm" target="_self" method="POST" action="good_tag_list.php">
			<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
			<input type="hidden" name="str_goodcode" value="<?= $str_goodcode ?>">
			<input type="hidden" name="page1" value="<?= $page1 ?>">
			<input type="hidden" name="page2" value="<?= $page2 ?>">
			<input type="hidden" name="str_no">
			<tr>
				<?
				$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow], 10);
				$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage], 10);

				$Txt_word1 = Fnc_Om_Conv_Default($_REQUEST[Txt_word1], "");

				if ($Txt_word1 != "") {
					$Str_Query = " and a.str_tag like '%$Txt_word1%' ";
				}

				$SQL_QUERY = "select count(a.int_number) from ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_tag a inner join " . $Tname . "comm_goods_master_tag b on a.int_number=b.int_tag and b.str_goodcode='$str_goodcode' where a.int_number is not null ";
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
					$first = $displayrow * ($page1 - 1);
					$last = $displayrow * $page1;

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

				$SQL_QUERY = "select a.*,b.int_tag ";
				$SQL_QUERY .= " from ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_tag a inner join " . $Tname . "comm_goods_master_tag b on a.int_number=b.int_tag and b.str_goodcode='$str_goodcode' where a.int_number is not null ";
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
				<td valign=top width="50%" align="center">



					<table width=95% cellpadding=0 cellspacing=0 border=0>
						<tr>
							<td colspan=4 height="10"></td>
						</tr>
						<tr>
							<td colspan=4>
								<div class="title title_top">선택태그 </div>
								<table class=tb>
									<col class=cellC>
									<col class=cellL>
									<tr>
										<td>태그검색</td>
										<td>
											<input type="text" NAME="Txt_word1" value="<?= $Txt_word1 ?>">
										</td>
									</tr>
								</table>

								<div class=button_top style="text-align:center;padding-top:10px;"><img src="/admincenter/img/btn_search2.gif" style="cursor:pointer" onClick="fnc_search1();"></div>

								<table width=100%>
									<tr>
										<td class=pageInfo>총 <b><?= $total_record_limit ?></b>건, <b><?= $page1 ?></b> of <?= $total_page ?> Pages</td>
									</tr>
								</table>

							</td>
						</tr>
						<tr>
							<td class=rnd colspan=4></td>
						</tr>
						<tr class=rndbg>
							<th>번호</th>
							<th>태그명</th>
							<th>등록일자</th>
							<th>삭제</th>
						</tr>
						<tr>
							<td class=rnd colspan=4></td>
						</tr>
						<col width=10% align=center>
						<col width=60% align=center>
						<col width=20% align=center>
						<col width=10% align=center>
						<tr>
							<td height=4 colspan=4></td>
						</tr>
						<? $count = 0; ?>
						<? if ($total_record_limit != 0) { ?>
							<? $article_num = $total_record - $displayrow * ($page1 - 1); ?>
							<? for ($i = 0; $i <= $displayrow - 1; $i++) { ?>
								<tr height=25 align="center">
									<td>
										<font class=ver81 color=616161><?= $article_num ?>
									</td>
									<td>
										<font class=ver81 color=333333><?= mysql_result($result, $i, str_tag) ?>
									</td>
									<td>
										<font class=ver81 color=616161><?= substr(mysql_result($result, $i, dtm_indate), 0, 10) ?>
									</td>
									<td align=center><a href="javascript:Delete_Click('<?= mysql_result($result, $i, int_tag) ?>')"><img src="/admincenter/img/i_del.gif"></a></td>
								</tr>
								<tr>
									<td height=4 colspan=5></td>
								</tr>
								<tr>
									<td colspan=6 class=rndline></td>
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
						<input type="hidden" name="txtRows1" value="<?= $count ?>">
					</table>

					<div align=center class=pageNavi>
						<?
						$total_block = ceil($total_page / $displaypage);
						$block = ceil($page1 / $displaypage);

						$first_page = ($block - 1) * $displaypage;
						$last_page = $block * $displaypage;

						if ($total_block <= $block) {
							$last_page = $total_page;
						}

						$file_link = basename($PHP_SELF);
						$link = "$file_link?$param";

						if ($page1 > 1) { ?>
							<a href="Javascript:MovePage1('1');" class=navi>◀◀</a>
						<? } else { ?>
							◀◀
						<? }

						if ($block > 1) {
							$my_page = $first_page;
						?>
							<a href="Javascript:MovePage1('<?= $my_page ?>');" class=navi>◀</a>
						<? } else { ?>
							◀
							<? }

						echo " | ";
						for ($direct_page = $first_page + 1; $direct_page <= $last_page; $direct_page++) {
							if ($page1 == $direct_page) { ?>
								<font color='cccccc'><b><?= $direct_page ?></b></font> |
							<? } else { ?>
								<a href="Javascript:MovePage1('<?= $direct_page ?>');" class=navi><?= $direct_page ?></a> |
							<? }
						}

						echo " ";

						if ($block < $total_block) {
							$my_page = $last_page + 1; ?>
							<a href="Javascript:MovePage1('<?= $my_page ?>');" class=navi>▶</a>
						<? } else { ?>
							▶
						<? }

						if ($page1 < $total_page) { ?>
							<a href="Javascript:MovePage1('<?= $total_page ?>');" class=navi>▶▶</a>
						<? } else { ?>
							▶▶
						<? }
						?>
					</div>

				</td>

				<?
				$Txt_word2 = Fnc_Om_Conv_Default($_REQUEST[Txt_word2], "");

				if ($Txt_word2 != "") {
					$Str_Query = " and a.str_tag like '%$Txt_word2%' ";
				}

				$SQL_QUERY = "select count(a.int_number) from ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_tag a where a.int_number is not null ";
				$SQL_QUERY .= " and a.int_number not in (select b.int_tag from " . $Tname . "comm_goods_master_tag b where b.str_goodcode='$str_goodcode') ";
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
					$first = $displayrow * ($page2 - 1);
					$last = $displayrow * $page2;

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

				$SQL_QUERY = "select a.* ";
				$SQL_QUERY .= " from ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_tag a where a.int_number is not null  ";
				$SQL_QUERY .= " and a.int_number not in (select b.int_tag from " . $Tname . "comm_goods_master_tag b where b.str_goodcode='$str_goodcode') ";
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

				<td valign="top" width="50%" align="center">

					<table width=95% cellpadding=0 cellspacing=0 border=0>
						<tr>
							<td colspan=4 height="10"></td>
						</tr>
						<tr>
							<td colspan=4>
								<div class="title title_top">전체태그 </div>
								<table class=tb>
									<col class=cellC>
									<col class=cellL>
									<tr>
										<td>태그검색</td>
										<td>
											<input type="text" NAME="Txt_word2" value="<?= $Txt_word2 ?>">
										</td>
									</tr>
								</table>

								<div class=button_top style="text-align:center;padding-top:10px;"><img src="/admincenter/img/btn_search2.gif" style="cursor:pointer" onClick="fnc_search2();"></div>

								<table width=100%>
									<tr>
										<td class=pageInfo>총 <b><?= $total_record_limit ?></b>건, <b><?= $page2 ?></b> of <?= $total_page ?> Pages</td>
									</tr>
								</table>

							</td>
						</tr>
						<tr>
							<td class=rnd colspan=4></td>
						</tr>
						<tr class=rndbg>
							<th>번호</th>
							<th>태그명</th>
							<th>등록일자</th>
							<th>추가</th>
						</tr>
						<tr>
							<td class=rnd colspan=4></td>
						</tr>
						<col width=10% align=center>
						<col width=60% align=center>
						<col width=20% align=center>
						<col width=10% align=center>
						<tr>
							<td height=4 colspan=4></td>
						</tr>
						<? $count = 0; ?>
						<? if ($total_record_limit != 0) { ?>
							<? $article_num = $total_record - $displayrow * ($page2 - 1); ?>
							<? for ($i = 0; $i <= $displayrow - 1; $i++) { ?>
								<tr height=25 align="center">
									<td>
										<font class=ver81 color=616161><?= $article_num ?>
									</td>
									<td>
										<font class=ver81 color=333333><?= mysql_result($result, $i, str_tag) ?>
									</td>
									<td>
										<font class=ver81 color=616161><?= substr(mysql_result($result, $i, dtm_indate), 0, 10) ?>
									</td>
									<td align=center><a href="javascript:Add_Click('<?= mysql_result($result, $i, int_number) ?>')"><img src="/admincenter/img/i_add.gif"></a></td>
								</tr>
								<tr>
									<td height=4 colspan=5></td>
								</tr>
								<tr>
									<td colspan=6 class=rndline></td>
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
						<input type="hidden" name="txtRows2" value="<?= $count ?>">
					</table>

					<div align=center class=pageNavi>
						<?
						$total_block = ceil($total_page / $displaypage);
						$block = ceil($page1 / $displaypage);

						$first_page = ($block - 1) * $displaypage;
						$last_page = $block * $displaypage;

						if ($total_block <= $block) {
							$last_page = $total_page;
						}

						$file_link = basename($PHP_SELF);
						$link = "$file_link?$param";

						if ($page2 > 1) { ?>
							<a href="Javascript:MovePage2('1');" class=navi>◀◀</a>
						<? } else { ?>
							◀◀
						<? }

						if ($block > 1) {
							$my_page = $first_page;
						?>
							<a href="Javascript:MovePage2('<?= $my_page ?>');" class=navi>◀</a>
						<? } else { ?>
							◀
							<? }

						echo " | ";
						for ($direct_page = $first_page + 1; $direct_page <= $last_page; $direct_page++) {
							if ($page2 == $direct_page) { ?>
								<font color='cccccc'><b><?= $direct_page ?></b></font> |
							<? } else { ?>
								<a href="Javascript:MovePage2('<?= $direct_page ?>');" class=navi><?= $direct_page ?></a> |
							<? }
						}

						echo " ";

						if ($block < $total_block) {
							$my_page = $last_page + 1; ?>
							<a href="Javascript:MovePage2('<?= $my_page ?>');" class=navi>▶</a>
						<? } else { ?>
							▶
						<? }

						if ($page2 < $total_page) { ?>
							<a href="Javascript:MovePage2('<?= $total_page ?>');" class=navi>▶▶</a>
						<? } else { ?>
							▶▶
						<? }
						?>
					</div>

				</td>
			</tr>
		</form>
	</table>
	<script>
		table_design_load();
	</script>
</body>

</html>