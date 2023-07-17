<?
Header("Content-type: application/vnd.ms-excel");
Header("Content-type: charset=utf-8");
Header("Content-Disposition: attachment; filename=[" . date("Y-m-d") . "].xls");
Header("Content-Description: aaaa");
Header("Pragma: no-cache");
Header("Expires: 0");
?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$str_exceltype = Fnc_Om_Conv_Default($_REQUEST[str_exceltype], "1");
$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1], "");

$Txt_ptype = Fnc_Om_Conv_Default($_REQUEST[Txt_ptype], "");

$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key], "all");
$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word], "");
$Txt_pass = Fnc_Om_Conv_Default($_REQUEST[Txt_pass], "");

$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate], "");
$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate], "");

if ($Txt_ptype != "") {
	$Str_Query .= " and a.str_ptype = '$Txt_ptype' ";
}

if ($Txt_word != "") {
	switch ($Txt_key) {
		case  "all":
			$Str_Query = " and (b.str_name like '%$Txt_word%' or b.str_userid like '%$Txt_word%') ";
			break;
		case  "str_name":
			$Str_Query = " and b.str_name like '%$Txt_word%' ";
			break;
		case  "str_userid":
			$Str_Query = " and b.str_userid like '%$Txt_word%' ";
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


if ($str_exceltype == "1") {
	for ($i = 0; $i < count($chkItem1); $i++) {
		if ($i == count($chkItem1) - 1) {
			$sTemp .= $chkItem1[$i];
		} else {
			$sTemp .= $chkItem1[$i] . ",";
		}
	}

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
	$SQL_QUERY .= " and a.int_number in (" . $sTemp . ") ";
	$SQL_QUERY .= "order by a.dtm_indate desc ";

	$arr_ex_Data = mysql_query($SQL_QUERY);
	$arr_ex_Data_Cnt = mysql_num_rows($arr_ex_Data);
} else {

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
	$SQL_QUERY .= "order by a.dtm_indate desc ";

	$arr_ex_Data = mysql_query($SQL_QUERY);
	$arr_ex_Data_Cnt = mysql_num_rows($arr_ex_Data);
}
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">
		br {
			mso-data-placement: same-cell;
		}
	</style>
</head>

<body class=scroll>

	<table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#cccccc">
		<tr>
			<td align="center" rowspan="2" style="width:50px;" bordercolor="#eeeeee">번호</td>
			<td align="center" rowspan="2" style="width:100px;" bordercolor="#eeeeee">구분</td>
			<td align="center" rowspan="2" style="width:100px;" bordercolor="#eeeeee">아이디</td>
			<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">이름</td>
			<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">결제금액</td>
			<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">결제일</td>
			<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">상태(구독)</td>
			<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">취소신청(구독)</td>
			<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">상태(렌트)</td>
			<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">취소신청(렌트)</td>
			<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">관리자메모</td>
			<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">등록일</td>
			<td align="center" colspan="4" style="width:1000px;" bordercolor="#eeeeee">결제내역</td>
		</tr>
		<tr>
			<td align="center" style="width:200px;" bordercolor="#eeeeee">주문번호</td>
			<td align="center" style="width:200px;" bordercolor="#eeeeee">결제금액</td>
			<td align="center" style="width:400px;" bordercolor="#eeeeee">일자</td>
			<td align="center" style="width:200px;" bordercolor="#eeeeee">등록일자</td>
		</tr>
		<?
		$tcnt = $arr_ex_Data_Cnt;
		for ($int_I = 0; $int_I < $arr_ex_Data_Cnt; $int_I++) {
		?>
			<tr>
				<?
				$Sql_Query =	" SELECT
						B.*
					FROM `"
					. $Tname . "comm_member_pay` AS A
						INNER JOIN
						`" . $Tname . "comm_member_pay_info` AS B
						ON
						A.INT_NUMBER=B.INT_NUMBER
						AND 
						B.INT_NUMBER='" . mysql_result($arr_ex_Data, $int_I, int_number) . "'
					ORDER BY
						B.INT_SNUMBER DESC ";
				$arr_Data2 = mysql_query($Sql_Query);
				$arr_Data2_Cnt = mysql_num_rows($arr_Data2);

				if ($arr_Data2_Cnt > 1) {
					$rowspan = " rowspan=" . ($arr_Data2_Cnt);
				} else {
					$rowspan = "";
				}
				?>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'><?= $int_I + 1 ?></td>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'>
					<?php
					if (mysql_result($arr_ex_Data, $int_I, 'sub_int') == 0 && mysql_result($arr_ex_Data, $int_I, 'ren_int') == 0) {
						echo "일반회원";
					} else {
						if (mysql_result($arr_ex_Data, $int_I, 'sub_int') > 0) {
							echo "구독멤버십 |";
						}
						if (mysql_result($arr_ex_Data, $int_I, 'ren_int') > 0) {
							echo "| 렌트멤버십";
						}
					}
					?>
				</td>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'><?= mysql_result($arr_ex_Data, $int_I, str_userid) ?></td>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'><?= mysql_result($arr_ex_Data, $int_I, str_name) ?></td>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'><?= number_format(mysql_result($arr_ex_Data, $int_I, int_price)) ?>원</td>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'><?= mysql_result($arr_ex_Data, $int_I, str_pdate) ?></td>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'>
					<? switch (mysql_result($arr_ex_Data, $int_I, 'str_pass1')) {
						case  "0":
							echo "결제완료";
							break;
						case  "1":
							echo "결제취소";
							break;
					}
					?>
				</td>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'>
					<? switch (mysql_result($arr_ex_Data, $int_I, 'str_cancel1')) {
						case  "0":
							echo "-";
							break;
						case  "1":
							echo "결제취소신청중";
							break;
					}
					?>
				</td>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'>
					<? switch (mysql_result($arr_ex_Data, $int_I, 'str_pass2')) {
						case  "0":
							echo "결제완료";
							break;
						case  "1":
							echo "결제취소";
							break;
					}
					?>
				</td>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'>
					<? switch (mysql_result($arr_ex_Data, $int_I, 'str_cancel2')) {
						case  "0":
							echo "-";
							break;
						case  "1":
							echo "결제취소신청중";
							break;
					}
					?>
				</td>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'><?= mysql_result($arr_ex_Data, $int_I, str_amemo) ?></td>
				<td align="center" <?= $rowspan ?> style='mso-number-format:"\@";'><?= mysql_result($arr_ex_Data, $int_I, dtm_indate) ?></td>
				<? if ($arr_Data2_Cnt) { ?>
					<? for ($int_J = 0; $int_J < 1; $int_J++) { ?>
						<td align="center" style='mso-number-format:"\@";'><?= mysql_result($arr_Data2, $int_J, str_orderidx) ?></td>
						<td align="center" style='mso-number-format:"\@";'><?= number_format(mysql_result($arr_Data2, $int_J, int_sprice)) ?>원</td>
						<td align="center" style='mso-number-format:"\@";'><?= mysql_result($arr_Data2, $int_J, str_sdate) ?>~<?= mysql_result($arr_Data2, $int_J, str_edate) ?></td>
						<td align="center" style='mso-number-format:"\@";'><?= mysql_result($arr_Data2, $int_J, dtm_indate) ?></td>
					<? } ?>
				<? } else { ?>
					<td align="center" style='mso-number-format:"\@";'>&nbsp;</td>
					<td align="center" style='mso-number-format:"\@";'>&nbsp;</td>
					<td align="center" style='mso-number-format:"\@";'>&nbsp;</td>
					<td align="center" style='mso-number-format:"\@";'>&nbsp;</td>
				<? } ?>
			</tr>
			<? if ($arr_Data2_Cnt) { ?>
				<? for ($int_J = 1; $int_J < $arr_Data2_Cnt; $int_J++) { ?>
					<tr>
						<td align="center" style='mso-number-format:"\@";'><?= mysql_result($arr_Data2, $int_J, str_orderidx) ?></td>
						<td align="center" style='mso-number-format:"\@";'><?= number_format(mysql_result($arr_Data2, $int_J, int_sprice)) ?>원</td>
						<td align="center" style='mso-number-format:"\@";'><?= mysql_result($arr_Data2, $int_J, str_sdate) ?>~<?= mysql_result($arr_Data2, $int_J, str_edate) ?></td>
						<td align="center" style='mso-number-format:"\@";'><?= mysql_result($arr_Data2, $int_J, dtm_indate) ?></td>
					</tr>
				<? } ?>
			<? } ?>
		<? } ?>
	</table>

</body>

</html>