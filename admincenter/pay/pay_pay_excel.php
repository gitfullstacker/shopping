<?
	Header("Content-type: application/vnd.ms-excel");
	Header("Content-type: charset=utf-8");
	Header("Content-Disposition: attachment; filename=[".date("Y-m-d")."].xls");
	Header("Content-Description: aaaa");
	Header("Pragma: no-cache");
	Header("Expires: 0");
?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$str_exceltype = Fnc_Om_Conv_Default($_REQUEST[str_exceltype],"1");
	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	$Txt_ptype = Fnc_Om_Conv_Default($_REQUEST[Txt_ptype],"");

	$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key],"all");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
	$Txt_pass = Fnc_Om_Conv_Default($_REQUEST[Txt_pass],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");

	If ($Txt_ptype!="") { $Str_Query .= " and a.str_ptype = '$Txt_ptype' ";}

	If ($Txt_word!="") {
		switch ($Txt_key) {
			case  "all" :
				$Str_Query = " and (b.str_name like '%$Txt_word%' or b.str_userid like '%$Txt_word%') ";
				break;
			case  "str_name" :
				$Str_Query = " and b.str_name like '%$Txt_word%' ";
				break;
			case  "str_userid" :
				$Str_Query = " and b.str_userid like '%$Txt_word%' ";
				break;
				
		}
	}

	If ($Txt_pass!="") { $Str_Query .= " and a.str_pass = '$Txt_pass' ";}

	if ($Txt_sindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";}
	if ($Txt_eindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";}


	if ($str_exceltype=="1") {
		for($i=0;$i<count($chkItem1);$i++) {
			if ($i==count($chkItem1)-1) {
				$sTemp.=$chkItem1[$i];
			}else{
				$sTemp.=$chkItem1[$i].",";
			}
		}
		
		$SQL_QUERY = "select a.*,b.str_name,b.str_hp from ";
		$SQL_QUERY.=$Tname;
		$SQL_QUERY.="comm_member_pay a left join ".$Tname."comm_member b on a.str_userid=b.str_userid where a.int_number is not null ";
		$SQL_QUERY.=" and a.int_number in (".$sTemp.") ";
		$SQL_QUERY.="order by a.dtm_indate desc ";

	$arr_ex_Data=mysql_query($SQL_QUERY);
	$arr_ex_Data_Cnt=mysql_num_rows($arr_ex_Data);
	} else {

		$SQL_QUERY = "select a.*,b.str_name,b.str_hp from ";
		$SQL_QUERY.=$Tname;
		$SQL_QUERY.="comm_member_pay a left join ".$Tname."comm_member b on a.str_userid=b.str_userid where a.int_number is not null ";
		$SQL_QUERY.=$Str_Query;
		$SQL_QUERY.="order by a.dtm_indate desc ";

	$arr_ex_Data=mysql_query($SQL_QUERY);
	$arr_ex_Data_Cnt=mysql_num_rows($arr_ex_Data);
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
br{mso-data-placement:same-cell;}
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
		<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">상태</td>
		<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">취소신청</td>
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
		for($int_I = 0 ;$int_I < $arr_ex_Data_Cnt; $int_I++) {
	?>
<tr>
		<?
		$Sql_Query =	" SELECT
						B.*
					FROM `"
						.$Tname."comm_member_pay` AS A
						INNER JOIN
						`".$Tname."comm_member_pay_info` AS B
						ON
						A.INT_NUMBER=B.INT_NUMBER
						AND 
						B.INT_NUMBER='".mysql_result($arr_ex_Data,$int_I,int_number)."'
					ORDER BY
						B.INT_SNUMBER DESC ";
		$arr_Data2=mysql_query($Sql_Query);
		$arr_Data2_Cnt=mysql_num_rows($arr_Data2);
		
		if ($arr_Data2_Cnt > 1) {
			$rowspan=" rowspan=".($arr_Data2_Cnt);
		}else{
			$rowspan="";
		}
		?>
		<td align="center" <?=$rowspan?> style='mso-number-format:"\@";'><?=$int_I+1?></td>
		<td align="center" <?=$rowspan?> style='mso-number-format:"\@";'>
			<?switch (mysql_result($arr_ex_Data,$int_I,str_ptype)) {
				case  "1" : echo "멥버쉽회원"; break;
				case  "2" : echo "1개월권회원"; break;
			}
			?>
		</td>
		<td align="center" <?=$rowspan?> style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_userid)?></td>
		<td align="center" <?=$rowspan?> style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_name)?>
			<?
			$SQL_QUERY =	" select ifnull(a.str_ptype,0) as mtype,a.str_userid from `".$Tname."comm_member_pay` as a inner join `".$Tname."comm_member_pay_info` as b on a.int_number=b.int_number and a.str_pass='0' and date_format(b.str_sdate, '%Y-%m-%d') <= '".date("Y-m-d")."' and date_format(b.str_edate, '%Y-%m-%d') >= '".date("Y-m-d")."' and a.str_userid='".mysql_result($arr_ex_Data,$int_I,str_userid)."' ";
			$arr_Rlt_Data=mysql_query($SQL_QUERY);
			$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
			?>
			(
			<?switch ($arr_Data['mtype']) {
				case  "" : echo "일반회원"; break;
				case  "1" : echo "멤버십회원"; break;
				case  "2" : echo "1개월권회원"; break;
			}
			?>
			)
		</td>
		<td align="center" <?=$rowspan?> style='mso-number-format:"\@";'><?=number_format(mysql_result($arr_ex_Data,$int_I,int_price))?>원</td>
		<td align="center" <?=$rowspan?> style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_pdate)?></td>
		<td align="center" <?=$rowspan?> style='mso-number-format:"\@";'>
			<?switch (mysql_result($arr_ex_Data,$int_I,str_pass)) {
				case  "0" : echo "결제완료"; break;
				case  "1" : echo "결제취소"; break;
			}
			?>
		</td>		
		<td align="center" <?=$rowspan?> style='mso-number-format:"\@";'>
			<?switch (mysql_result($arr_ex_Data,$int_I,str_cancel)) {
				case  "0" : echo "-"; break;
				case  "1" : echo "결제취소신청중"; break;
			}
			?>
		</td>	
		<td align="center" <?=$rowspan?> style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_amemo)?></td>
		<td align="center" <?=$rowspan?> style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,dtm_indate)?></td>
		<?if ($arr_Data2_Cnt) {?>
		<?for($int_J = 0 ;$int_J < 1; $int_J++) {?>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_Data2,$int_J,str_oidxcode)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=number_format(mysql_result($arr_Data2,$int_J,int_sprice))?>원</td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_Data2,$int_J,str_sdate)?>~<?=mysql_result($arr_Data2,$int_J,str_edate)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_Data2,$int_J,dtm_indate)?></td>
		<?}?>
		<?}else{?>
		<td align="center" style='mso-number-format:"\@";'>&nbsp;</td>
		<td align="center" style='mso-number-format:"\@";'>&nbsp;</td>
		<td align="center" style='mso-number-format:"\@";'>&nbsp;</td>
		<td align="center" style='mso-number-format:"\@";'>&nbsp;</td>
		<?}?>
	</tr>
	<?if ($arr_Data2_Cnt) {?>
	<?for($int_J = 1 ;$int_J < $arr_Data2_Cnt; $int_J++) {?>
	<tr>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_Data2,$int_J,str_oidxcode)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=number_format(mysql_result($arr_Data2,$int_J,int_sprice))?>원</td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_Data2,$int_J,str_sdate)?>~<?=mysql_result($arr_Data2,$int_J,str_edate)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_Data2,$int_J,dtm_indate)?></td>
	</tr>
	<?}?>
	<?}?>
	<?}?>
</table>

</body>
</html>