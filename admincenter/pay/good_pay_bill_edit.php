<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
//	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], "");

$SQL_QUERY =	" SELECT
					A.*, B.STR_NAME, B.STR_EMAIL, B.STR_HP, B.STR_TELEP, C.STR_SDATE, C.STR_EDATE, D.STR_GOODNAME
				FROM 
					" . $Tname . "comm_good_pay AS A
				LEFT JOIN
					" . $Tname . "comm_member AS B
				ON
					A.STR_USERID=B.STR_USERID
				LEFT JOIN
					" . $Tname . "comm_goods_cart AS C
				ON
					A.INT_CART=C.INT_NUMBER
				LEFT JOIN
					" . $Tname . "comm_goods_master AS D
				ON
					A.STR_GOODCODE=D.STR_GOODCODE
				WHERE
					A.INT_NUMBER='$str_no' ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
if (!$arr_Rlt_Data) {
	echo 'Could not run query: ' . mysql_error();
	exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

//카드정보얻기
$SQL_QUERY =    "SELECT 
                    A.*
                FROM 
                    `" . $Tname . "comm_member_pay` AS A
                WHERE
                    A.STR_USERID='" . $arr_Data['STR_USERID'] . "'
					AND A.STR_USING='Y'
                ORDER BY DTM_INDATE DESC
                LIMIT 1 ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$card_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>
<html>

<head>
	<? include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php"; ?>
	<script language="javascript" src="js/good_pay_bill_edit.js"></script>
</head>

<body class=scroll onload="init_orderid()">
	<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
		<tr>
			<td colspan=2 valign=top height=100%>
				<table width=100%>
					<tr>
						<td style="padding:10px">

							<form id="frm" name="frm" target="_self" method="POST" action="good_pay_bill_edit.php" enctype="multipart/form-data">
								<input type="hidden" name="RetrieveFlag" value="<?= $RetrieveFlag ?>">
								<input type="hidden" name="str_no" value="<?= $str_no ?>">
								<input type="hidden" name="page" value="<?= $page ?>">
								<input type="hidden" name="Obj">
								<input type="hidden" name="int_type" value="<?= $int_type ?>">

								<input type="hidden" name="int_gubun" value="<?= $int_gubun ?>">

								<input type="hidden" name="res_cd" value="<?= $res_cd ?>"> <!-- 결과 코드 -->
								<input type="hidden" name="res_msg" value="<?= $res_msg ?>"> <!-- 결과 메세지 -->
								<input type="hidden" name="buyr_name" value="<?= $arr_Data['STR_NAME'] ?>"> <!-- 요청자 이름 -->
								<input type="hidden" name="card_cd" value="<?= $card_cd ?>"> <!-- 카드 코드 -->
								<input type="hidden" name="bt_batch_key" value="<?= $card_Data['STR_BILLCODE'] ?>"> <!-- 배치 인증키 -->

								<input type="hidden" name="pay_method" value="CARD" />
								<input type="hidden" name="ordr_idxx" value=""> <!-- 주문번호 -->
								<input type="hidden" name="good_name" value="<?= $int_type == 1 ? '구독멤버십' : '렌트멥버십' ?>" />
								<input type="hidden" name="buyr_mail" value="<?= $arr_Data['STR_EMAIL'] ?>" />
								<input type="hidden" name="buyr_tel1" value="<?= $arr_Data['STR_HP'] ?>" />
								<input type="hidden" name="buyr_tel2" value="<?= $arr_Data['STR_TELEP'] ?>" />
								<input type="hidden" name="bt_group_id" value="A52Q71000489" />
								<input type="hidden" name="quotaopt" value="00" />

								<input type="hidden" name="req_tx" value="pay" />
								<input type="hidden" name="card_pay_method" value="Batch" />
								<input type="hidden" name="currency" value="410" />

								<input type="hidden" name="str_userid" value="<?= $arr_Data['STR_USERID'] ?>" />
								<input type="hidden" name="str_goodcode" value="<?= $arr_Data['STR_GOODCODE'] ?>" />
								<input type="hidden" name="int_cart" value="<?= $arr_Data['INT_CART'] ?>" />

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
										<td>상품명</td>
										<td colspan="3">
											<font class=def><?= $arr_Data['STR_GOODNAME'] ?></font>
										</td>
									</tr>
								</table>
								<br>

								<?php
								$lastnumber1 = date("Y-m-d", strtotime(date("Y-m-d", strtotime($arr_Data['STR_EDATE'])) . "1day"));
								$lastnumber2 = date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastnumber1)) . "1month"));
								$lastnumber3 = date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastnumber2)) . "-1day"));
								?>
								<table class=tb>
									<col class=cellC style="width:15%">
									<col class=cellL style="width:85%">
									<tr>
										<td>일자설정</td>
										<td colspan="3">
											<font class=def>
												<input type=text name=str_sdate value="<?= $lastnumber1 ?>" id="str_sdate" onclick="displayCalendar(document.frm.str_sdate ,'yyyy-mm-dd',this)">
												<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:hand" onclick="displayCalendar(document.frm.str_sdate ,'yyyy-mm-dd',document.frm.str_sdate)">
												<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:hand" onclick="document.frm.str_sdate.value=''" ;>
												-
												<input type=text name=str_edate value="<?= $lastnumber3 ?>" id="str_edate" onclick="displayCalendar(document.frm.str_edate ,'yyyy-mm-dd',this)">
												<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:hand" onclick="displayCalendar(document.frm.str_edate ,'yyyy-mm-dd',document.frm.str_edate)">
												<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:hand" onclick="document.frm.str_edate.value=''" ;>
										</td>
									</tr>
									<tr>
										<td>결제금액</td>
										<td colspan="3">
											<font class=def><input type="text" name="good_mny" value="<?= $arr_Data['INT_PRICE'] ?>">원
										</td>
									</tr>
								</table>

								<div class=button>
									<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_register.gif"></a>
								</div>

								<div class="title">결제내역</div>
								<?
								$Sql_Query =	"SELECT
													A.*, C.STR_SDATE, C.STR_EDATE
												FROM 
													`" . $Tname . "comm_good_pay` A
												LEFT JOIN
													" . $Tname . "comm_goods_master B
												ON
													A.STR_GOODCODE=B.STR_GOODCODE
												LEFT JOIN
													" . $Tname . "comm_goods_cart C
												ON
													A.INT_CART=C.INT_NUMBER
												WHERE
													B.INT_TYPE=2
													AND A.STR_GOODCODE='" . $arr_Data['STR_GOODCODE'] . "'
													AND A.STR_USERID='" . $arr_Data['STR_USERID'] . "'
												ORDER BY
													A.DTM_INDATE DESC ";
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
											<td><?= mysql_result($arr_Data2, $int_I, 'INT_CART') ?></td>
											<td><?= number_format(mysql_result($arr_Data2, $int_I, 'INT_PRICE')) ?>원</td>
											<td><?= mysql_result($arr_Data2, $int_I, 'STR_SDATE') ?> ~ <?= mysql_result($arr_Data2, $int_I, 'STR_EDATE') ?></td>
											<td><?= mysql_result($arr_Data2, $int_I, 'DTM_INDATE') ?></td>
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