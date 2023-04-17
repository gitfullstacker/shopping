<?
	Header("Content-type: application/vnd.ms-excel");
	Header("Content-type: charset=utf-8");
	Header("Content-Disposition: attachment; filename=[".date("Y-m-d")."].xls");
	Header("Content-Description: aaaa");
	Header("Pragma: no-cache");
	Header("Expires: 0");
?>
<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$str_exceltype = Fnc_Om_Conv_Default($_REQUEST[str_exceltype],"1");
	$str_gbn = Fnc_Om_Conv_Default($_REQUEST[str_gbn],"1");
	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	$Txt_name = Fnc_Om_Conv_Default($_REQUEST[Txt_name],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");

	If ($Txt_name!="") { $Str_Query .= " and b.str_name like '%$Txt_name%' ";}

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
		$SQL_QUERY.="comm_member_alarm a inner join ".$Tname."comm_member b on a.str_userid=b.str_userid ";
		$SQL_QUERY.="where a.int_number is not null and a.str_goodcode='$str_no' ";
		$SQL_QUERY.=" and a.int_number in (".$sTemp.") ";
		$SQL_QUERY.="order by a.int_number asc ";

	$arr_ex_Data=mysql_query($SQL_QUERY);
	$arr_ex_Data_Cnt=mysql_num_rows($arr_ex_Data);
	} else {

		$SQL_QUERY = "select a.*,b.str_name,b.str_hp from ";
		$SQL_QUERY.=$Tname;
		$SQL_QUERY.="comm_member_alarm a inner join ".$Tname."comm_member b on a.str_userid=b.str_userid ";
		$SQL_QUERY.="where a.int_number is not null and a.str_goodcode='$str_no' ";
		$SQL_QUERY.=$Str_Query;
		$SQL_QUERY.="order by a.int_number asc ";

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
		<td align="center" style="width:50px;" bordercolor="#eeeeee">번호</td>
		<td align="center" style="width:100px;" bordercolor="#eeeeee">아이디</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">회원명</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">핸드폰</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">등록일</td>
	</tr>
	<?
		$tcnt = $arr_ex_Data_Cnt;
		for($int_I = 0 ;$int_I < $arr_ex_Data_Cnt; $int_I++) {
	?>
	<tr>
		<td align="center" style='mso-number-format:"\@";'><?=$int_I+1?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_userid)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_name)?>
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
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_hp)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,dtm_indate)?></td>
	</tr>
	<?}?>
</table>

</body>
</html>