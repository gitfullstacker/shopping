<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);

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
				$Str_Query = " and (a.str_name like '%$Txt_word%' or a.str_email like '%$Txt_word%' or a.str_telep like '%$Txt_word%') ";
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
		}
	}

	If ($Txt_service!="") { $Str_Query .= " and a.str_service = '$Txt_service' ";}
	If ($Txt_gubun!="") { $Str_Query .= " and a.int_gubun = '$Txt_gubun' ";}
	If ($Txt_sms_f!="") { $Str_Query .= " and a.str_sms_f = '$Txt_sms_f' ";}
	If ($Txt_mail_f!="") { $Str_Query .= " and a.str_mail_f = '$Txt_mail_f' ";}


	if ($Txt_sindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";}
	if ($Txt_eindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";}

	if ($Txt_sacdate!="") { $Str_Query .= " and date_format(a.dtm_acdate, '%Y-%m-%d') >= '$Txt_sacdate' ";}
	if ($Txt_eacdate!="") { $Str_Query .= " and date_format(a.dtm_acdate, '%Y-%m-%d') <= '$Txt_eacdate' ";}

	$SQL_QUERY="select count(a.str_userid) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member a where a.int_gubun<=2 ";
	$SQL_QUERY.=$Str_Query;
	$result = mysql_query($SQL_QUERY);


	if(!result){
	   error("QUERY_ERROR");
	   exit;
	}
	$total_record = mysql_result($result,0,0);

	if(!$total_record){
		$first = 1;
		$last = 0;
	}else{
	  	$first = $displayrow *($page-1) ;
	  	$last = $displayrow *$page;

	  	$IsNext = $total_record - $last ;
	  	if($IsNext > 0){
			$last -= 1;
	  	}else{
	   		$last = $total_record -1 ;
	  	}
	}
	$total_page = ceil($total_record/$displayrow);

	$f_limit=$first;
	$l_limit=$last + 1 ;

	$SQL_QUERY = "select a.*,b.str_idxword,(select ifnull(sum(c.int_stamp),0) from ".$Tname."comm_member_stamp c where a.str_userid=c.str_userid) as int_stamp,
						ifnull((select ifnull(d.str_ptype,0) from `".$Tname."comm_member_pay` as d inner join `".$Tname."comm_member_pay_info` as e on d.int_number=e.int_number and d.str_pass='0' and date_format(e.str_sdate, '%Y-%m-%d') <= '".date("Y-m-d")."' and date_format(e.str_edate, '%Y-%m-%d') >= '".date("Y-m-d")."' where d.str_userid=a.str_userid),0) as mtype 
	 from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member a ";
	$SQL_QUERY.="left join  ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_fun_code b on b.str_idxcode='01' and a.str_menu_level=b.str_idxnum where a.int_gubun<=2 ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.dtm_indate desc ";
	$SQL_QUERY.="limit $f_limit,$l_limit";
	echo $SQL_QUERY;
	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/memb_user_list.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_logo_info.php";?>
		<td width=100%>
			<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_tmenu_info.php";?>
		</td>
	</tr>
	<tr>
		<td colspan="3"><?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_tmenu.php";?></td>
	</tr>
	<tr>
		<td valign=top id=leftMenu>
			<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_lmenu_info.php";?>
		</td>
		<td colspan=2 valign=top height=100%> 
			<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_stitle_info.php";?>
			<table width=100%>
				<tr>
					<td style="padding:10px">
						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>

						<form id="frm" name="frm" target="_self" method="POST" action="memb_user_list.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="str_no">


						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<tr>
								<td>키워드검색</td>
								<td>
									<select name="Txt_key">
										<option value="all" <?If ($Txt_key=="all") {?>selected<?}?>> 통합검색 </option>
										<option value="str_name" <?If ($Txt_key=="str_name") {?>selected<?}?>> 회원명 </option>
										<option value="str_email" <?If ($Txt_key=="str_email") {?>selected<?}?>> 아이디(이메일) </option>
										<option value="str_telep" <?If ($Txt_key=="str_telep") {?>selected<?}?>> 전화번호 </option>
									</select>
									<input type="text" NAME="Txt_word" value="<?=$Txt_word?>">
								</td>
								<td>승인여부</td>
								<td>
									<select name="Txt_service">
										<option value="" selected> 전체 </option>
										<option value="A" <?If ($Txt_service=="A") {?>selected<?}?>> 대기 </option>
										<option value="Y" <?If ($Txt_service=="Y") {?>selected<?}?>> 승인 </option>
										<option value="N" <?If ($Txt_service=="N") {?>selected<?}?>> 미승인 </option>
										<option value="E" <?If ($Txt_service=="E") {?>selected<?}?>> 탈퇴 </option>
									</select>
								</td>
							</tr>
							<tr>
								<td>회원구분</td>
								<td colspan="3">
									<select name="Txt_gubun">
										<option value="" selected> 전체 </option>
										<option value="1" <?If ($Txt_gubun=="1") {?>selected<?}?>> 일반회원  </option>
									</select>
								</td>
							</tr>
							<tr style="display:none;">
								<td>SMS수신여부</td>
								<td>
									<input type="radio" value="" name="Txt_sms_f" class=null <?If ($Txt_sms_f=="") {?>checked<?}?>> 전체
									<input type="radio" value="Y" name="Txt_sms_f" class=null <?If ($Txt_sms_f=="Y") {?>checked<?}?>> 수신함
									<input type="radio" value="N" name="Txt_sms_f" class=null <?If ($Txt_sms_f=="N") {?>checked<?}?>> 수신안함
								</td>
								<td>메일수신여부</td>
								<td>
									<input type="radio" value="" name="Txt_mail_f" class=null <?If ($Txt_mail_f=="") {?>checked<?}?>> 전체
									<input type="radio" value="Y" name="Txt_mail_f" class=null <?If ($Txt_mail_f=="Y") {?>checked<?}?>> 수신함
									<input type="radio" value="N" name="Txt_mail_f" class=null <?If ($Txt_mail_f=="N") {?>checked<?}?>> 수신안함
								</td>
							</tr>
							<tr>
								<td>가입일</td>
								<td colspan="3">
									<input type=text name=Txt_sindate value="<?=$Txt_sindate?>" id="Txt_sindate" onclick="displayCalendar(document.frm.Txt_sindate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.Txt_sindate ,'yyyy-mm-dd',document.frm.Txt_sindate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.Txt_sindate.value=''";>
									 -
									<input type=text name=Txt_eindate value="<?=$Txt_eindate?>" id="Txt_eindate" onclick="displayCalendar(document.frm.Txt_eindate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.Txt_eindate ,'yyyy-mm-dd',document.frm.Txt_eindate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.Txt_eindate.value=''";>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?=date("Y-m-d")?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_today.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?=date("Y-m-d", strtotime($day."-7day"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_week.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?=date("Y-m-d", strtotime($day."-15day"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_twoweek.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?=date("Y-m-d", strtotime($month."-1month"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_month.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?=date("Y-m-d", strtotime($month."-2month"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_twomonth.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','','')"><img src="/admincenter/img/sicon_all.gif" align=absmiddle></a>
								</td>
							</tr>
							<tr>
								<td>최종로그인</td>
								<td colspan="3">
									<input type=text name=Txt_sacdate value="<?=$Txt_sacdate?>" onclick="displayCalendar(document.frm.Txt_sacdate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.Txt_sacdate ,'yyyy-mm-dd',document.frm.Txt_sacdate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.Txt_sacdate.value=''";>
									-
									<input type=text name=Txt_eacdate value="<?=$Txt_eacdate?>" onclick="displayCalendar(document.frm.Txt_eacdate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.Txt_eacdate ,'yyyy-mm-dd',document.frm.Txt_eacdate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.Txt_eacdate.value=''";>
									<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','<?=date("Y-m-d")?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_today.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','<?=date("Y-m-d", strtotime($day."-7day"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_week.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','<?=date("Y-m-d", strtotime($day."-15day"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_twoweek.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','<?=date("Y-m-d", strtotime($month."-1month"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_month.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','<?=date("Y-m-d", strtotime($month."-2month"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_twomonth.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sacdate','Txt_eacdate','','')"><img src="/admincenter/img/sicon_all.gif" align=absmiddle></a>
								</td>
							</tr>
						</table>

						<div class=button_top><img src="/admincenter/img/btn_search2.gif" style="cursor:hand" onClick="fnc_search();"></div>


						<table width=100%>
							<tr>
								<td class=pageInfo>총 <b><?=$total_record?></b>명, <b><?=$page?></b> of <?=$total_page?> Pages</td>
								<td align=right>
								<select name=displayrow onchange="fnc_search()">
									<?for ($i = 10; $i <= 100; ($i++)*5) {?>
									<option value="<?=$i?>" <?If (Trim($i)==trim($displayrow)) {?>selected<?}?>><?=$i?>개 출력
									<?}?>
								</select>
								</td>
							</tr>
						</table>

						<table width=100% cellpadding=0 cellspacing=0 border=0>
							<tr><td class=rnd colspan=11></td></tr>
							<tr class=rndbg>
								<th>번호</th>
								<th>이름</th>
								<th>아이디(이메일)</th>
								<th>전화번호</th>
								<th>스탬프</th>
								<th>방문수</th>
								<th>가입일</th>
								<th>최종로그인</th>
								<th>승인</th>
								<th>수정</th>
								<th>선택</th>
							</tr>
							<tr><td class=rnd colspan=11></td></tr>
							<col width=5% align=center>
							<col width=10% align=center>
							<col width=20% align=center>
							<col width=10% align=center>
							<col width=10% align=center>
							<col width=10% align=center>
							<col width=10% align=center>
							<col width=10% align=center>
							<col width=5% align=center>
							<col width=5% align=center>
							<col width=5% align=center>
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<tr height=30 align="center">
								<td><font class=ver81 color=616161><?= $article_num?></font></td>
								<td><span id="navig" name="navig" m_id="admin" m_no="1"><font color=0074BA><b><?=mysql_result($result,$i,str_name)?>
										(
										<?switch (mysql_result($result,$i,int_gubun)) {
											case  "1" : echo "일반회원"; break;
										}
										?>
										)
								</b></font></span></td>
								<td align=center><?=mysql_result($result,$i,str_email)?></td>
								<td align=center><?=mysql_result($result,$i,str_telep)?></td>
								<td align=center><?=number_format(mysql_result($result,$i,int_stamp))?>개 <a href="javascript:popupLayer('memb_user_stamp_list.php?str_userid=<?=mysql_result($result,$i,str_userid)?>',800,500)"><img src="/admincenter/img/btn_viewbbs.gif" align="absmiddle"></a></td>
								<td><font class=ver81 color=616161><?=mysql_result($result,$i,int_login)?></font></td>
								<td><font class=ver81 color=616161><?=substr(mysql_result($result,$i,dtm_indate),0,10)?></font></td>
								<td><font class=ver81 color=616161><font color=#7070B8><?=mysql_result($result,$i,dtm_acdate)?></font></font></td>
								<td><font class=small color=616161>
									<?switch (mysql_result($result,$i,str_service)) {
										case  "Y" : echo "승인"; break;
										case  "A" : echo "대기"; break;
										case  "N" : echo "미승인"; break;
										case  "E" : echo "탈퇴"; break;
									}
									?>
								</font></td>
								<td><a href="javascript:RowClick('<?=mysql_result($result,$i,str_userid)?>');"><img src="/admincenter/img/i_edit.gif"></a></td>
								<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?=mysql_result($result,$i,str_userid)?>"></td>
							</tr>
							<tr><td colspan=11 class=rndline></td></tr>
							<?
							$article_num--;
							if($article_num==0){
								break;
							}
							?>
							<?$count++;?>
							<?}?>
							<?}?>
							<input type="hidden" name="txtRows" value="<%=count%>">
						</table>

						<div align=center class=pageNavi>
						<?
						$total_block = ceil($total_page/$displaypage);
						$block = ceil($page/$displaypage);

						$first_page = ($block-1)*$displaypage;
						$last_page = $block*$displaypage;

						if($total_block <= $block) {
   							$last_page = $total_page;
						}

						$file_link= basename($PHP_SELF);
						$link="$file_link?$param";

						if($page > 1) {?>
							<a href="Javascript:MovePage('1');" class=navi>◀◀</a>
						<?}else{?>
							◀◀
						<?}

						if($block > 1) {
						   $my_page = $first_page;
						?>
							<a href="Javascript:MovePage('<?=$my_page?>');" class=navi>◀</a>
						<?}else{?>
							◀
						<?}

						echo" | ";
						for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
						   if($page == $direct_page) {?>
						      	<font color='cccccc'><b><?=$direct_page?></b></font> |
						   <?} else {?>
						    	<a href="Javascript:MovePage('<?=$direct_page?>');" class=navi><?=$direct_page?></a> |
						   <?}
						}

						echo" ";

						if($block < $total_block) {
						   	$my_page = $last_page+1;?>
						    <a href="Javascript:MovePage('<?=$my_page?>');" class=navi>▶</a>
						<?}else{ ?>
							▶
						<?}

						if($page < $total_page) {?>
							<a href="Javascript:MovePage('<?=$total_page?>');" class=navi>▶▶</a>
						<?}else{?>
							▶▶
						<?}
						?>
						</div>

						<div style="float:left;">
						<img src="/admincenter/img/btn_allselect_s.gif" alt="전체선택"  border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('1');">
						<img src="/admincenter/img/btn_alldeselect_s.gif" alt="선택해제"  border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('2');">
						<img src="/admincenter/img/btn_alldelet_s.gif" alt="선택삭제" border="0" align='absmiddle' style="cursor:hand" onclick="javaScript:Adelete_Click();">
						</div>

						<div style="float:right;">
						<img src="/admincenter/img/btn_regist_s.gif" alt="등록" border=0 align=absmiddle style="cursor:hand" onClick="AddNew();">
						</div>
						</form>

						<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_btip_info.php";?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr><td height=3 bgcolor="#E6E6E6" colspan=2></td></tr>
	<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_copyright_info.php";?>
</table>
<script>table_design_load();</script>
</body>
</html>
