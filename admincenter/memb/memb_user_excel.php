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

	$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key],"all");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
	$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service],"");
	$Txt_gubun = Fnc_Om_Conv_Default($_REQUEST[Txt_gubun],"");
	$Txt_sms_f = Fnc_Om_Conv_Default($_REQUEST[Txt_sms_f],"");
	$Txt_mail_f = Fnc_Om_Conv_Default($_REQUEST[Txt_mail_f],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");
	$Txt_sacdate = Fnc_Om_Conv_Default($_REQUEST[Txt_sacdate],"");
	$Txt_eacdate = Fnc_Om_Conv_Default($_REQUEST[Txt_eacdate],"");

	If ($Txt_word!="") {
		switch ($Txt_key) {
			case  "all" :
				$Str_Query = " and (a.str_userid like '%$Txt_word%' or a.str_name like '%$Txt_word%' or a.str_email like '%$Txt_word%' or replace(a.str_telep,'-','') like '%".str_replace('-','',$Txt_word)."%' or replace(a.str_hp,'-','') like '%".str_replace('-','',$Txt_word)."%') ";
				break;
			case  "str_userid" :
				$Str_Query = " and a.str_userid like '%$Txt_word%' ";
				break;
			case  "str_name" :
				$Str_Query = " and a.str_name like '%$Txt_word%' ";
				break;
			case  "str_email" :
				$Str_Query = " and a.str_email like '%$Txt_word%' ";
				break;
			case  "str_telep" :
				$Str_Query = " and a.str_telep like '%$Txt_word%' ";
				break;
			case  "str_hp" :
				$Str_Query = " and a.str_hp like '%$Txt_word%' ";
				break;
		}
	}

	If ($Txt_service!="") { $Str_Query .= " and a.str_service = '$Txt_service' ";}
	If ($Txt_gubun!="") { 
		//$Str_Query .= " and a.str_userid = '$Txt_gubun' ";
		$Str_Query .= " and a.str_userid in (select f.str_userid from `".$Tname."comm_member` as f left join (select ifnull(d.str_ptype,0) as mtype,d.str_userid from `".$Tname."comm_member_pay` as d inner join `".$Tname."comm_member_pay_info` as e on d.int_number=e.int_number and d.str_pass='0' and date_format(e.str_sdate, '%Y-%m-%d') <= '".date("Y-m-d")."' and date_format(e.str_edate, '%Y-%m-%d') >= '".date("Y-m-d")."') as g on f.str_userid=g.str_userid where ";
		if ($Txt_gubun=="0") {
			$Str_Query .= " mtype is null ";
		}
		if ($Txt_gubun=="1") {
			$Str_Query .= " mtype = '1' ";
		}
		if ($Txt_gubun=="2") {
			$Str_Query .= " mtype = '2' ";
		}
		$Str_Query .= " ) ";
	}
	If ($Txt_sms_f!="") { $Str_Query .= " and a.str_sms_f = '$Txt_sms_f' ";}
	If ($Txt_mail_f!="") { $Str_Query .= " and a.str_mail_f = '$Txt_mail_f' ";}


	if ($Txt_sindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";}
	if ($Txt_eindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";}

	if ($Txt_sacdate!="") { $Str_Query .= " and date_format(a.dtm_acdate, '%Y-%m-%d') >= '$Txt_sacdate' ";}
	if ($Txt_eacdate!="") { $Str_Query .= " and date_format(a.dtm_acdate, '%Y-%m-%d') <= '$Txt_eacdate' ";}


	if ($str_exceltype=="1") {
		for($i=0;$i<count($chkItem1);$i++) {
			if ($i==count($chkItem1)-1) {
				$sTemp.="'".$chkItem1[$i]."'";
			}else{
				$sTemp.="'".$chkItem1[$i]."',";
			}
		}
		
		$SQL_QUERY = "select a.* from ";
		$SQL_QUERY.=$Tname;
		$SQL_QUERY.="comm_member a where a.int_gubun<=2 ";
		$SQL_QUERY.=" and a.str_userid in (".$sTemp.") ";
		$SQL_QUERY.="order by a.dtm_indate desc ";

	$arr_ex_Data=mysql_query($SQL_QUERY);
	$arr_ex_Data_Cnt=mysql_num_rows($arr_ex_Data);
	} else {

		$SQL_QUERY = "select a.* from ";
		$SQL_QUERY.=$Tname;
		$SQL_QUERY.="comm_member a where a.int_gubun<=2 ";
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
		<td align="center" style="width:50px;" bordercolor="#eeeeee">번호</td>
		<td align="center" style="width:100px;" bordercolor="#eeeeee">회원구분</td>
		<td align="center" style="width:100px;" bordercolor="#eeeeee">아이디</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">이름</td>
		<td align="center" style="width:100px;" bordercolor="#eeeeee">생년월일</td>
		<td align="center" style="width:100px;" bordercolor="#eeeeee">성별</td>
		<td align="center" style="width:100px;" bordercolor="#eeeeee">승인</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">전화번호</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">핸드폰</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">주소[우편]</td>
		<td align="center" style="width:500px;" bordercolor="#eeeeee">주소</td>
		<td align="center" style="width:400px;" bordercolor="#eeeeee">이메일</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">추천아이디</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">메일수신</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">SNS수신</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">회원가입일</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">최종로그인</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">등록된배송지[우편]</td>
		<td align="center" style="width:500px;" bordercolor="#eeeeee">등록된배송지</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">경비실</td>
		<td align="center" style="width:200px;" bordercolor="#eeeeee">무인택배함</td>
	</tr>
	<?
		$tcnt = $arr_ex_Data_Cnt;
		for($int_I = 0 ;$int_I < $arr_ex_Data_Cnt; $int_I++) {
	?>
	<tr>
		<td align="center" style='mso-number-format:"\@";'><?=$int_I+1?></td>
		<td align="center" style='mso-number-format:"\@";'>
			<?
			$SQL_QUERY =	" select ifnull(a.str_ptype,0) as mtype,a.str_userid from `".$Tname."comm_member_pay` as a inner join `".$Tname."comm_member_pay_info` as b on a.int_number=b.int_number and a.str_pass='0' and date_format(b.str_sdate, '%Y-%m-%d') <= '".date("Y-m-d")."' and date_format(b.str_edate, '%Y-%m-%d') >= '".date("Y-m-d")."' and a.str_userid='".mysql_result($arr_ex_Data,$int_I,str_userid)."' ";
			$arr_Rlt_Data=mysql_query($SQL_QUERY);
			$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
			?>
			<?switch ($arr_Data['mtype']) {
				case  "" : echo "일반회원"; break;
				case  "1" : echo "멤버십회원"; break;
				case  "2" : echo "1개월권회원"; break;
			}
			?>
		</td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_userid)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_name)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_birth)?></td>
		<td align="center" style='mso-number-format:"\@";'>
			<?switch (mysql_result($arr_ex_Data,$int_I,str_sex)) {
				case  "1" : echo "남"; break;
				case  "2" : echo "여"; break;
			}
			?>
		</td>
		<td align="center" style='mso-number-format:"\@";'>
			<?switch (mysql_result($arr_ex_Data,$int_I,str_service)) {
				case  "Y" : echo "승인"; break;
				case  "A" : echo "대기"; break;
				case  "N" : echo "미승인"; break;
				case  "E" : echo "탈퇴"; break;
			}
			?>
		</td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_telep)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_hp)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_post)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_addr1)." ".mysql_result($arr_ex_Data,$int_I,str_addr2)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_email)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_tuserid)?></td>
		<td align="center" style='mso-number-format:"\@";'><?if (mysql_result($arr_ex_Data,$int_I,str_mail_f)=="Y") {?>수신<?}else{?>수신안함<?}?></td>
		<td align="center" style='mso-number-format:"\@";'><?if (mysql_result($arr_ex_Data,$int_I,str_sms_f)=="Y") {?>수신<?}else{?>수신안함<?}?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,dtm_indate)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,dtm_acdate)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_spost)?></td>
		<td align="center" style='mso-number-format:"\@";'><?=mysql_result($arr_ex_Data,$int_I,str_saddr1)." ".mysql_result($arr_ex_Data,$int_I,str_saddr2)?></td>
		<td align="center" style='mso-number-format:"\@";'>
			<?switch (mysql_result($arr_ex_Data,$int_I,str_splace1)) {
				case  "1" : echo "있다"; break;
				case  "0" : echo "없다"; break;
			}
			?>
		</td>
		<td align="center" style='mso-number-format:"\@";'>
			<?switch (mysql_result($arr_ex_Data,$int_I,str_splace2)) {
				case  "1" : echo "있다"; break;
				case  "0" : echo "없다"; break;
			}
			?>
		</td>
	</tr>
	<?}?>
</table>

</body>
</html>