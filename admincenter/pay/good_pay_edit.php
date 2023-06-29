<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "INSERT");
$page = Fnc_Om_Conv_Default($_REQUEST['page'], 1);
$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], "");

if ($RetrieveFlag == "UPDATE") {

	$SQL_QUERY =	" SELECT
						A.*,B.STR_NAME
					FROM "
		. $Tname . "comm_good_pay AS A
						LEFT JOIN
						" . $Tname . "comm_member AS B
						ON
						A.STR_USERID=B.STR_USERID
					WHERE
						A.INT_NUMBER='$str_no' ";

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
	<script language="javascript" src="js/good_pay_edit.js"></script>
</head>

<body class=scroll>
	<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
		<tr>
			<td colspan=2 valign=top height=100%>
				<table width=100%>
					<tr>
						<td style="padding:10px">

							<form id="frm" name="frm" target="_self" method="POST" action="good_pay_edit.php" enctype="multipart/form-data">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="str_no" value="<?= $str_no ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="Obj">
								<input type="hidden" name="int_type" value="<?= $int_type ?>">

								<div class="title title_top"><?= Fnc_Om_Loc_Name("01" . $arr_Auth[7]); ?></div>
								<table class=tb>
									<col class=cellC style="width:15%">
									<col class=cellL style="width:35%">
									<col class=cellC style="width:15%">
									<col class=cellL style="width:35%">
									<tr>
										<td>아이디</td>
										<td>
											<font class=def><?= $arr_Data['STR_USERID'] ?>
										</td>
										<td>이름</td>
										<td>
											<font class=def><?= $arr_Data['STR_NAME'] ?>
										</td>
									</tr>
									<tr>
										<td>결제금액</td>
										<td>
											<font class=def><?= number_format($arr_Data['INT_PRICE']) ?>원
										</td>
										<td>결제일</td>
										<td>
											<font class=def><?= $arr_Data['DTM_INDATE'] ?>
										</td>
									</tr>
									<tr>
										<td>관리자메모</td>
										<td colspan="3" style="height:50px;" valign="top"><textarea name="str_amemo" style="width:100%;height:80px;"><?= stripslashes(Fnc_Om_Conv_Default($arr_Data['STR_AMEMO'], "")) ?></textarea></td>
									</tr>
									<? if ($RetrieveFlag == "UPDATE") { ?>
										<tr>
											<td>등록일자</td>
											<td colspan=3 class=noline>
												<font class=def>
													<?= $arr_Data['DTM_INDATE'] ?>
											</td>
										</tr>
									<? } ?>
								</table>
								<br>

								<div class=button>
									<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<? if ($RetrieveFlag == "INSERT") { ?>register<? } else { ?>modify<? } ?>.gif"></a>
								</div>

								<div class="title">결제내역</div>
								<?
								$Sql_Query =	" SELECT
													A.*
												FROM `"
												. $Tname . "comm_good_pay` AS A
												WHERE
													A.STR_USERID='" . $arr_Data['STR_USERID'] . "'
												ORDER BY
													A.DTM_INDATE DESC ";
								$arr_Data2 = mysql_query($Sql_Query);
								$arr_Data2_Cnt = mysql_num_rows($arr_Data2);
								?>
								<table width=100% cellpadding=0 cellspacing=0 border=0>
									<tr>
										<td class=rnd colspan=4></td>
									</tr>
									<tr class=rndbg>
										<th>번호</th>
										<th>주문번호</th>
										<th>결제금액</th>
										<th>등록일자</th>
									</tr>
									<tr>
										<td class=rnd colspan=4></td>
									</tr>
									<col width=10% align=center>
									<col width=25% align=center>
									<col width=20% align=center>
									<col width=45% align=center>
									<?
									for ($int_I = 0; $int_I < $arr_Data2_Cnt; $int_I++) {
									?>
										<tr height=30 align="center">
											<td>
												<font class=ver81 color=616161><?= $int_I + 1 ?></font>
											</td>
											<td><?= mysql_result($arr_Data2, $int_I, str_orderidx) ?></td>
											<td><?= number_format(mysql_result($arr_Data2, $int_I, int_price)) ?>원</td>
											<td><?= mysql_result($arr_Data2, $int_I, dtm_indate) ?></td>
										</tr>
										<tr>
											<td colspan=4 class=rndline></td>
										</tr>
									<? } ?>
								</table>
							</form>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<script>
		table_design_load();
	</script>
</body>

</html>

</body>

</html>