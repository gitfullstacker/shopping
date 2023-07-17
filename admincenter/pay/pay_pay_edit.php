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
						A.*,B.STR_NAME,C.STR_CODE
					FROM "
		. $Tname . "comm_member_pay AS A
						LEFT JOIN
						" . $Tname . "comm_member AS B
						ON
						A.STR_USERID=B.STR_USERID
						LEFT JOIN
						" . $Tname . "comm_com_code AS C
						ON
						A.INT_ESCE=C.INT_NUMBER
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
	<script language="javascript" src="js/pay_pay_edit.js"></script>
</head>

<body class=scroll>
	<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
		<tr>
			<td colspan=2 valign=top height=100%>
				<table width=100%>
					<tr>
						<td style="padding:10px">

							<form id="frm" name="frm" target="_self" method="POST" action="pay_pay_edit.php" enctype="multipart/form-data">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="str_no" value="<?= $str_no ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="Obj">
								<input type="hidden" name="int_type" value="<?= $int_type ?>">
								<input type="hidden" name="str_userid" value="<?= $arr_Data['STR_USERID'] ?>">

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
											<font class=def><?= number_format($arr_Data['INT_SPRICE']) ?>원
										</td>
										<td>결제일</td>
										<td>
											<font class=def><?= $arr_Data['STR_PDATE'] ?>
										</td>
									</tr>
									<?php
									if ($int_type == 0 || $int_type == 1) {
										if ($int_type != 0) {
									?>
											<input type="hidden" name="str_pass2" value="<?= $arr_Data['STR_PASS2'] ?>">
											<input type="hidden" name="str_cancel2" value="<?= $arr_Data['STR_CANCEL2'] ?>">
										<?php
										}
										?>
										<tr>
											<td>상태(구독)</td>
											<td colspan=3>
												<input type="radio" value="0" name="str_pass1" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_PASS1'], "0") == "0") { ?>checked<? } ?>> 결제완료
												<input type="radio" value="1" name="str_pass1" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_PASS1'], "0") == "1") { ?>checked<? } ?>> 결제취소
												<? if ($arr_Data['STR_CANCEL1'] == "1") { ?> <font color="red">(취소요청중)</font><? } ?>
											</td>
										</tr>
										<tr>
											<td>취소신청(구독)</td>
											<td colspan=3>
												<input type="radio" value="0" name="str_cancel1" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_CANCEL1'], "0") == "0") { ?>checked<? } ?>> 정상
												<input type="radio" value="1" name="str_cancel1" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_CANCEL1'], "0") == "1") { ?>checked<? } ?>> 취소요청중
											</td>
										</tr>
									<?php
									}
									?>
									<?php
									if ($int_type == 0 || $int_type == 2) {
										if ($int_type != 0) {
									?>
											<input type="hidden" name="str_pass1" value="<?= $arr_Data['STR_PASS1'] ?>">
											<input type="hidden" name="str_cancel1" value="<?= $arr_Data['STR_CANCEL1'] ?>">
										<?php
										}
										?>
										<tr>
											<td>상태(렌트)</td>
											<td colspan=3>
												<input type="radio" value="0" name="str_pass2" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_PASS2'], "0") == "0") { ?>checked<? } ?>> 결제완료
												<input type="radio" value="1" name="str_pass2" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_PASS2'], "0") == "1") { ?>checked<? } ?>> 결제취소
												<? if ($arr_Data['STR_CANCEL2'] == "1") { ?> <font color="red">(취소요청중)</font><? } ?>
											</td>
										</tr>
										<tr>
											<td>취소신청(렌트)</td>
											<td colspan=3>
												<input type="radio" value="0" name="str_cancel2" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_CANCEL2'], "0") == "0") { ?>checked<? } ?>> 정상
												<input type="radio" value="1" name="str_cancel2" class=null <? if (Fnc_Om_Conv_Default($arr_Data['STR_CANCEL2'], "0") == "1") { ?>checked<? } ?>> 취소요청중
											</td>
										</tr>
									<?php
									}
									?>
									<? if (Fnc_Om_Conv_Default($arr_Data[$int_type == 1 ? 'STR_CANCEL1' : 'STR_CANCEL2'], "0") == "1") { ?>
										<tr>
											<td>취소사유</td>
											<td colspan=3><?= $arr_Data['STR_CODE'] ?><br><?= $arr_Data['STR_ESCONT'] ?></td>
										</tr>
									<? } ?>
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
								switch ($int_type) {
									case 0:
										$WHERE_QUERY = "";
										break;
									case 1:
										$WHERE_QUERY = "AND B.INT_TYPE=1";
										break;
									case 2:
										$WHERE_QUERY = "AND B.INT_TYPE=2";
										break;
								}
								$Sql_Query =	" SELECT
													B.*
												FROM 
													`" . $Tname . "comm_member_pay` AS A
												INNER JOIN
													`" . $Tname . "comm_member_pay_info` AS B
												ON
													A.INT_NUMBER=B.INT_NUMBER
													AND 
													B.INT_NUMBER='" . $arr_Data['INT_NUMBER'] . "'
													" . $WHERE_QUERY . "
												ORDER BY
													B.INT_SNUMBER DESC ";
								$arr_Data2 = mysql_query($Sql_Query);
								$arr_Data2_Cnt = mysql_num_rows($arr_Data2);
								?>
								<table width=100% cellpadding=0 cellspacing=0 border=0>
									<tr>
										<td class=rnd colspan=5></td>
									</tr>
									<tr class=rndbg>
										<th>번호</th>
										<th>주문번호</th>
										<th>결제금액</th>
										<th>일자</th>
										<th>등록일자</th>
									</tr>
									<tr>
										<td class=rnd colspan=5></td>
									</tr>
									<col width=10% align=center>
									<col width=25% align=center>
									<col width=20% align=center>
									<col width=20% align=center>
									<col width=25% align=center>
									<?
									for ($int_I = 0; $int_I < $arr_Data2_Cnt; $int_I++) {
									?>
										<tr height=30 align="center">
											<td>
												<font class=ver81 color=616161><?= $int_I + 1 ?></font>
											</td>
											<td><?= mysql_result($arr_Data2, $int_I, 'str_orderidx') ?></td>
											<td><?= number_format(mysql_result($arr_Data2, $int_I, 'int_sprice')) ?>원</td>
											<td><?= mysql_result($arr_Data2, $int_I, 'str_sdate') ?> ~ <?= mysql_result($arr_Data2, $int_I, 'str_edate') ?></td>
											<td><?= mysql_result($arr_Data2, $int_I, 'dtm_indate') ?></td>
										</tr>
										<tr>
											<td colspan=5 class=rndline></td>
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