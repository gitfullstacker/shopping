<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);

	$Txt_gubun = Fnc_Om_Conv_Default($_REQUEST[Txt_gubun],"");
	$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key],"all");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
	$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service],"");
	$Txt_mail_f = Fnc_Om_Conv_Default($_REQUEST[Txt_mail_f],"");
	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");
	
	$str_mailtitle = Fnc_Om_Conv_Default($_REQUEST[str_mailtitle],"");
	$str_mailcode = Fnc_Om_Conv_Default($_REQUEST[str_mailcode],"");

	If ($Txt_gubun!="") { $Str_Query .= " and a.int_gubun = '$Txt_gubun' ";}
	
	If ($Txt_word!="") {
		switch ($Txt_key) {
			case  "all" :
				$Str_Query = " and (a.str_name like '%$Txt_word%' or a.str_email like '%$Txt_word%') ";
				break;
			case  "str_name" :
				$Str_Query = " and a.str_name like '%$Txt_word%' ";
				break;
			case  "str_email" :
				$Str_Query = " and a.str_email like '%$Txt_word%' ";
				break;
		}
	}
	
	If ($Txt_service!="") { $Str_Query .= " and a.str_service = '$Txt_service' ";}
	If ($Txt_mail_f!="") { $Str_Query .= " and a.str_mail_f = '$Txt_mail_f' ";}

	if ($Txt_sindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";}
	if ($Txt_eindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";}

	$SQL_QUERY="select count(a.str_userid) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member a where a.str_userid is not null and a.int_gubun <= 90 ";
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

	$SQL_QUERY = "select a.*, ifnull(b.str_read_f,'') as str_read_f,b.dtm_rdate from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member a left join ".$Tname."comm_mail_history b on a.str_userid=b.str_userid and b.int_number='".$str_mailcode."'  ";
	$SQL_QUERY.="where a.str_userid is not null and a.int_gubun <= 90 ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.dtm_indate desc ";
	$SQL_QUERY.="limit $f_limit,$l_limit";

	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/mail_process_list.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_logo_info.php";?>
		<td width=100%>
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu_info.php";?>
		</td>
	</tr>
	<tr>
		<td colspan="3"><?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu.php";?></td>
	</tr>
	<tr>
		<td valign=top id=leftMenu>
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_lmenu_info.php";?>
		</td>
		<td colspan=2 valign=top height=100%> 
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_stitle_info.php";?>
			<table width=100%>
				<tr>
					<td style="padding:10px">
						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>


						<form id="frm" name="frm" target="_self" method="POST" action="mail_process_list.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="int_gubun" value="<?=$int_gubun?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="str_no">

						<table class=tb>
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<tr>
								<td>키워드검색</td>
								<td>
									<select name="Txt_key">
										<option value="all" <?If ($Txt_key=="all") {?>selected<?}?>> 통합검색 </option>
										<option value="str_name" <?If ($Txt_key=="str_name") {?>selected<?}?>> 회원명 </option>
										<option value="str_email" <?If ($Txt_key=="str_email") {?>selected<?}?>> 아이디(이메일) </option>
									</select> 
									<input type="text" NAME="Txt_word" value="<?=$Txt_word?>">
								</td>
								<td>승인여부 / 회원구분</td>
								<td>
									<select name="Txt_service">
										<option value="" selected> 전체 </option>
										<option value="A" <?If ($Txt_service=="A") {?>selected<?}?>> 대기 </option>
										<option value="Y" <?If ($Txt_service=="Y") {?>selected<?}?>> 승인 </option>
										<option value="N" <?If ($Txt_service=="N") {?>selected<?}?>> 미승인 </option>
										<option value="E" <?If ($Txt_service=="E") {?>selected<?}?>> 대기 </option>
									</select>
									/
									<select name="Txt_gubun">
										<option value="" selected> 전체 </option>
										<option value="1" <?If ($Txt_gubun=="1") {?>selected<?}?>> 일반회원</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>메일링수신</td>
								<td colspan="3">
									<select name="Txt_mail_f">
										<option value="" <?If ($Txt_mail_f=="") {?>selected<?}?>> 전체 </option>
										<option value="Y" <?If ($Txt_mail_f=="Y") {?>selected<?}?>> 수신 </option>
										<option value="N" <?If ($Txt_mail_f=="N") {?>selected<?}?>> 미수신 </option>
									</select> 
								</td>
							</tr>
							<tr>
								<td>가입일</td>
								<td colspan="3">
									<input type=text name=Txt_sindate value="<?=$Txt_sindate?>" id="Txt_sindate" onclick="displayCalendar(document.frm.Txt_sindate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:hand" onclick="displayCalendar(document.frm.Txt_sindate ,'yyyy-mm-dd',document.frm.Txt_sindate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:hand" onclick="document.frm.Txt_sindate.value=''";>
									 -
									<input type=text name=Txt_eindate value="<?=$Txt_eindate?>" id="Txt_eindate" onclick="displayCalendar(document.frm.Txt_eindate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:hand" onclick="displayCalendar(document.frm.Txt_eindate ,'yyyy-mm-dd',document.frm.Txt_eindate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:hand" onclick="document.frm.Txt_eindate.value=''";>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?=date("Y-m-d")?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_today.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?=date("Y-m-d", strtotime($day."-7day"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_week.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?=date("Y-m-d", strtotime($day."-15day"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_twoweek.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?=date("Y-m-d", strtotime($month."-1month"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_month.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','<?=date("Y-m-d", strtotime($month."-2month"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_twomonth.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sindate','Txt_eindate','','')"><img src="/admincenter/img/sicon_all.gif" align=absmiddle></a>
								</td>
							</tr>
						</table>
						<br>
						<table class=tb>
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:88%;">
							<tr>
								<td>메일컨텐츠선택</td>
								<?
								$SQL_QUERY = "select * from ";
											$SQL_QUERY .= $Tname;
											$SQL_QUERY .= "comm_mail_master
										where
											int_number='".$str_mailcode."' " ;

								$arr_Rlt_Data=mysql_query($SQL_QUERY);
								if (!$arr_Rlt_Data) {
						    		echo 'Could not run query: ' . mysql_error();
						    		exit;
								}
								$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
								?>
								
								<td>
									<input type=text name=str_mailtitle value="<?=$arr_Data['STR_TITLE']?>" style="width:400px;" style="background-Color:#eeeded;" readonly> <a href="javascript:popupLayer('comm_cmail_list.php?obj1=frm&obj2=str_mailcode',500,450)"><img src="/admincenter/img/i_search.gif" align=absmiddle></a>
									<?if ($arr_Data['INT_NUMBER']!="") {?>
									<?
									$SQL_QUERY="select count(b.str_userid) as cnt from ";
									$SQL_QUERY.=$Tname;
									$SQL_QUERY.="comm_mail_master a, ".$Tname."comm_mail_history b where a.int_number=b.int_number and a.int_number='".$str_mailcode."' ";
									$result1 = mysql_query($SQL_QUERY);
								
									if(!result1){
									   error("QUERY_ERROR");
									   exit;
									}
									$cnt1 = mysql_result($result1,0,0);
									?>
									총 보낸인원 : <?=$cnt1?> 명
									<?
									$SQL_QUERY="select count(b.str_userid) as cnt from ";
									$SQL_QUERY.=$Tname;
									$SQL_QUERY.="comm_mail_master a, ".$Tname."comm_mail_history b where a.int_number=b.int_number and a.int_number='".$str_mailcode."' and b.str_read_f='Y' ";
									$result2 = mysql_query($SQL_QUERY);
								
									if(!result2){
									   error("QUERY_ERROR");
									   exit;
									}
									$cnt2 = mysql_result($result2,0,0);
									?>
									읽은 인원 : <?=$cnt2?> 명

									[<a href="javascript:fnc_sendDelete()">초기화</a>]
									<?}?>
									

								</td>
							</tr>
							<input type="hidden" name="str_mailcode" value="<?=$str_mailcode?>">
							<input type="hidden" name="str_mailname" value="<?=$arr_Data['STR_NAME']?>">
							<input type="hidden" name="str_mailemail" value="<?=$arr_Data['STR_EMAIL']?>">
							<input type="hidden" name="str_mailcontents" value="<?=js_escape($arr_Data['STR_CONTENTS'])?>">
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
							<tr><td class=rnd colspan=13></td></tr>
							<tr class=rndbg>
								<th>선택</th>	
								<th>번호</th>
								<th>이름</th>
								<th>아이디(이메일)</th>
								<th>승인</th>
								<th>핸드폰</th>
								<th>전화번호</th>
								<th>방문수</th>
								<th>가입일</th>
								<th>상태</th>
								<th>수신시간</th>
							</tr>
							<tr><td class=rnd colspan=13></td></tr>
							<col width=5% align=center>
							<col width=5% align=center>
							<col width=10% align=center>
							<col width=10% align=center>
							<col width=10% align=center>
							<col width=10% align=center>
							<col width=10% align=center>
							<col width=10% align=center>
							<col width=10% align=center>
							<col width=5% align=center>
							<col width=15% align=center>
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<tr height=30 align="center">
								<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?=mysql_result($result,$i,str_userid)?>|<?=js_escape(mysql_result($result,$i,str_name))?>|<?=js_escape(mysql_result($result,$i,str_email))?>"></td>
								<td><font class=ver81 color=616161><?= $article_num?></font></td>
								<td><span id="navig" name="navig" m_id="admin" m_no="1"><font color=0074BA><b><?=mysql_result($result,$i,str_name)?></b></font></span></td>
								<td><span id="navig" name="navig" m_id="admin" m_no="1"><font color=0074BA><?=mysql_result($result,$i,str_email)?></font></span></td>
								<td><font class=small color=616161>
									<?switch (mysql_result($result,$i,str_service)) {
										case  "A" : echo "대기"; break;
										case  "Y" : echo "승인"; break;
										case  "N" : echo "미승인"; break;
										case  "E" : echo "거부"; break;
									}
									?>		
								</font></td>
								<td align=center><?=mysql_result($result,$i,str_hp)?></td>
								<td align=center><?=mysql_result($result,$i,str_telep)?></td>
								<td><font class=ver81 color=616161><?=mysql_result($result,$i,int_login)?></font></td>
								<td><font class=ver81 color=616161><?=substr(mysql_result($result,$i,dtm_indate),0,10)?></font></td>
								<td class="noline">
									<?switch (mysql_result($result,$i,str_read_f)) {
										case  "N" : echo "미확인"; break;
										case  "Y" : echo "확인"; break;
										default : echo "-"; break;
									}?>
								</td>
								<td><font class=ver81 color=616161><?=Fnc_Om_Conv_Default(mysql_result($result,$i,dtm_rdate),"-")?></font></td>
							</tr>
							<tr><td colspan=13 class=rndline></td></tr>
							<?$count++;?>
							<?
							$article_num--;
							if($article_num==0){
								break;
							}
							?>
							<?}?>
							<?}?>
							<input type="hidden" name="txtRows" value="<?=$count?>">

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


						<div style='font:0;height:10'></div>
						<div align=center>
						<table bgcolor=F7F7F7 width=100%>
							<tr>
								<td class=noline width=57% align=right>
								<select name="str_mailtype"">
								<option value="1">선택한 회원들에게
								<option value="2">현재 검색리스트에 있는 모든 회원에게
								</select>
								</td>
								<td width=43% style="padding-left:10px">
								<a href="javascript:fnc_sendAmail()"><img src="/admincenter/img/btn_mailpower.gif"></a>
								</td>
							</tr>
						</table>
						
						<table border="0" style="display:none;">
							<tr>
								<td id="obj_Lbl" colspan="2" height="0"></td>
							</tr>
						</table>
						</div>

						</form>
						
						<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_btip_info.php";?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr><td height=3 bgcolor="#E6E6E6" colspan=2></td></tr>
	<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_copyright_info.php";?>
</table>
<script>table_design_load();</script>
</body>
</html>
