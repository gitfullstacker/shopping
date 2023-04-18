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

	$Txt_gbn = Fnc_Om_Conv_Default($_REQUEST[Txt_gbn],"1");
	$Txt_state = Fnc_Om_Conv_Default($_REQUEST[Txt_state],"");

	$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key],"all");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");

	if ($Txt_gbn=="1") {
		$Str_Query .= " and a.int_state in ('1','2','3','4') ";
	} else {
		$Str_Query .= " and a.int_state in ('5','10','11') ";
	}

	If ($Txt_state!="") { $Str_Query .= " and a.int_state = '$Txt_state' ";}
	
	If ($Txt_word!="") {
		switch ($Txt_key) {
			case  "all" :
				$Str_Query .= " and (a.str_userid like '%$Txt_word%' or a.str_name like '%$Txt_word%' or c.str_goodname like '%$Txt_word%' or replace(b.str_hp,'-','') like '%".str_replace('-','',$Txt_word)."%' or e.str_usercode like '%$Txt_word%' ) ";
				break;
			case  "str_userid" :
				$Str_Query .= " and a.str_userid like '%$Txt_word%' ";
				break;
			case  "str_name" :
				$Str_Query .= " and a.str_name like '%$Txt_word%' ";
				break;
			case  "str_goodname" :
				$Str_Query .= " and a.str_goodname like '%$Txt_word%' ";
				break;
			case  "str_hp" :
				$Str_Query .= " and replace(b.str_hp,'-','') like '%".str_replace('-','',$Txt_word)."%' ";
				break;
			case  "str_usercode" :
				$Str_Query .= " and e.str_usercode like '%$Txt_word%' ";
				break;
		}
	}
	

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
		
		$SQL_QUERY = "select a.*,b.str_name,b.str_hp,c.str_goodname,e.str_usercode,(select count(d.str_userid) from ".$Tname."comm_member_alarm d where d.str_goodcode=a.str_goodcode) as cnt3 from ";
		$SQL_QUERY.=$Tname;
		$SQL_QUERY.="comm_goods_cart a left join ".$Tname."comm_member b on a.str_userid=b.str_userid left join ".$Tname."comm_goods_master c on a.str_goodcode=c.str_goodcode left join ".$Tname."comm_goods_master_sub e on a.str_sgoodcode=e.str_sgoodcode where a.int_number is not null and a.int_state not in ('0') ";
		$SQL_QUERY.=" and a.int_number in (".$sTemp.") ";
		$SQL_QUERY.="order by a.dtm_indate desc ";

	$arr_ex_Data=mysql_query($SQL_QUERY);
	$arr_ex_Data_Cnt=mysql_num_rows($arr_ex_Data);
	} else {

		$SQL_QUERY = "select a.*,b.str_name,b.str_hp,c.str_goodname,e.str_usercode,(select count(d.str_userid) from ".$Tname."comm_member_alarm d where d.str_goodcode=a.str_goodcode) as cnt3 from ";
		$SQL_QUERY.=$Tname;
		$SQL_QUERY.="comm_goods_cart a left join ".$Tname."comm_member b on a.str_userid=b.str_userid left join ".$Tname."comm_goods_master c on a.str_goodcode=c.str_goodcode left join ".$Tname."comm_goods_master_sub e on a.str_sgoodcode=e.str_sgoodcode where a.int_number is not null and a.int_state not in ('0') ";
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
		<td align="center" rowspan="2" style="width:40px;" bordercolor="#eeeeee">번호</td>
		<td align="center" rowspan="2" style="width:80px;" bordercolor="#eeeeee">아이디</td>
		<td align="center" rowspan="2" style="width:120px;" bordercolor="#eeeeee">구분</td>
		<td align="center" rowspan="2" style="width:250px;" bordercolor="#eeeeee">상품</td>
		<td align="center" rowspan="2" style="width:150px;" bordercolor="#eeeeee">기간</td>
		<td align="center" rowspan="2" style="width:80px;" bordercolor="#eeeeee">핸드폰</td>
		<td align="center" rowspan="2" style="width:80px;" bordercolor="#eeeeee">반납일자</td>
		<td align="center" rowspan="2" style="width:80px;" bordercolor="#eeeeee">상태</td>
		<td align="center" rowspan="2" style="width:80px;" bordercolor="#eeeeee">입고알림</td>
		<td align="center" rowspan="2" style="width:150px;" bordercolor="#eeeeee">등록일</td>
		<td align="center" rowspan="2" style="width:50px;" bordercolor="#eeeeee">우편번호</td>
		<td align="center" rowspan="2" style="width:300px;" bordercolor="#eeeeee">주소1</td>
		<td align="center" rowspan="2" style="width:100px;" bordercolor="#eeeeee">주소2</td>
		<td align="center" rowspan="2" style="width:80px;" bordercolor="#eeeeee">경비실</td>
		<td align="center" rowspan="2" style="width:100px;" bordercolor="#eeeeee">무인택배함</td>
		<td align="center" rowspan="2" style="width:200px;" bordercolor="#eeeeee">메모</td>
		<td align="center" colspan="2" style="width:10px;" bordercolor="#eeeeee">반납정보</td>
	</tr>
	<tr>
		<td align="center" style="width:100px;" bordercolor="#eeeeee">주소[우편번호]</td>
		<td align="center" style="width:500px;" bordercolor="#eeeeee">주소</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">반납방법</td>
		<td align="center" style="width:400px;" bordercolor="#eeeeee">메모</td>
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
		<td align="center" style='mso-number-format:"\@";'>[<?=mysql_result($arr_ex_Data,$int_I,str_usercode)?>] <?=mysql_result($arr_ex_Data,$int_I,str_goodname)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_sdate)?>~<?=mysql_result($arr_ex_Data,$int_I,str_edate)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_hp)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_rdate)?></td>
		<td align="center" style='mso-number-format:"\@";'>
			<?switch (mysql_result($arr_ex_Data,$int_I,int_state)) {
				case  "1" : echo "접수"; break;
				case  "2" : echo "관리자확인"; break;
				case  "3" : echo "발송"; break;
				case  "4" : echo "배송완료"; break;
				case  "5" : echo "반납접수"; break;
				case  "10" : echo "반납완료"; break;
				case  "11" : echo "취소"; break;
			}
			?>
		</td>		
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,cnt3)?>건</td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,dtm_indate)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_post)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_addr1)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_addr2)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_place1)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_place2)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_memo)?></td>
		
		
		
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_rpost)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_raddr1)." ".mysql_result($arr_ex_Data,$int_I,str_raddr2)?></td>
		<td align="center" style='mso-number-format:"\@";'>
			<?switch (mysql_result($arr_ex_Data,$int_I,str_method)) {
				case  "1" : echo "수령지에서"; break;
				case  "2" : echo "경비실에 맡긴다"; break;
				case  "3" : echo "무인택배함"; break;
			}
			?>	
		</td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_rmemo)?></td>
	</tr>
	<?}?>
</table>

</body>
</html>