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

	$Txt_name = Fnc_Om_Conv_Default($_REQUEST[Txt_name],"");
	$Txt_pass = Fnc_Om_Conv_Default($_REQUEST[Txt_pass],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");
	
	$str_mailtitle = Fnc_Om_Conv_Default($_REQUEST[str_mailtitle],"");
	$str_mailcode = Fnc_Om_Conv_Default($_REQUEST[str_mailcode],"");

	If ($Txt_gubun!="") { $Str_Query .= " and a.str_gubun = '$Txt_gubun' ";}
	If ($Txt_name!="") { $Str_Query .= " and a.str_name like '%$Txt_name%' ";}
	If ($Txt_pass!="") { $Str_Query .= " and a.str_pass = '$Txt_pass' ";}

	if ($Txt_sindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";}
	if ($Txt_eindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";}

	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_requ a where a.int_number is not null and a.str_pass in ('2','3') ";
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

	$SQL_QUERY = "select a.*,b.dtm_indate as dtm_send from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_requ a left join ".$Tname."comm_sms_history b on a.int_number=b.int_mnumber and b.int_number='".$str_mailcode."'  ";
	$SQL_QUERY.="where a.int_number is not null and a.str_pass in ('2','3') ";
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
<script language="javascript" src="js/sms_process_list.js"></script>
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


						<form id="frm" name="frm" target="_self" method="POST" action="sms_process_list.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="int_gubun" value="<?=$int_gubun?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="str_no">

						<table class=tb>
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<tr>
								<td>구분</td>
								<td colspan="3">
									<select name="Txt_gubun">
										<option value="" selected> 선택 </option>
										<option value="1" <?If ($Txt_gubun=="1") {?>selected<?}?>> 부동산대출 </option>
										<option value="2" <?If ($Txt_gubun=="2") {?>selected<?}?>> 동산대출 </option>
										<option value="3" <?If ($Txt_gubun=="3") {?>selected<?}?>> 상품매입 </option>
									</select>
								</td>
							</tr>
							<tr>
								<td>이름</td>
								<td>
									<input type="text" NAME="Txt_name" value="<?=$Txt_name?>" style="width:300px;">
								</td>
								<td>상태</td>
								<td>
									<select name="Txt_pass">
										<option value="" selected> 선택 </option>
										<option value="2" <?If ($Txt_pass=="2") {?>selected<?}?>> 대출/매입고객정보 </option>
										<option value="3" <?If ($Txt_pass=="3") {?>selected<?}?>> 상환완료고객 </option>
									</select>
								</td>
							</tr>
							<tr>
								<td>등록일</td>
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
						</table>
						<br>
						<table class=tb>
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:88%;">
							<tr>
								<td>문자컨텐츠선택</td>
								<?
								$SQL_QUERY = "select * from ";
											$SQL_QUERY .= $Tname;
											$SQL_QUERY .= "comm_sms_master
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
									<input type=text name=str_mailtitle value="<?=$arr_Data['STR_CONTENTS']?>" style="width:400px;" style="background-Color:#eeeded;" readonly> <a href="javascript:popupLayer('comm_cmail_list.php?obj1=frm&obj2=str_mailcode',1000,450)"><img src="/admincenter/img/i_search.gif" align=absmiddle></a>
									<?if ($arr_Data['INT_NUMBER']!="") {?>
									<?
									$SQL_QUERY="select count(b.int_mnumber) as cnt from ";
									$SQL_QUERY.=$Tname;
									$SQL_QUERY.="comm_sms_master a, ".$Tname."comm_sms_history b where a.int_number=b.int_number and a.int_number='".$str_mailcode."' ";
									$result1 = mysql_query($SQL_QUERY);
								
									if(!result1){
									   error("QUERY_ERROR");
									   exit;
									}
									$cnt1 = mysql_result($result1,0,0);
									?>
									총 보낸인원 : <?=$cnt1?> 명

									[<a href="javascript:fnc_sendDelete()">초기화</a>]
									<?}?>
									

								</td>
							</tr>
							<input type="hidden" name="str_mailcode" value="<?=$str_mailcode?>">
							<input type="hidden" name="str_mailshp" value="<?=$arr_Data['STR_SHP']?>">
							<input type="hidden" name="str_mailcontents" value="<?=js_escape($arr_Data['STR_CONTENTS'])?>">
						</table>
						
						<div class=button_top><img src="/admincenter/img/btn_search2.gif" style="cursor:pointer" onClick="fnc_search();"></div>

						<table width=100%>
							<tr>
								<td class=pageInfo>총 <b><?=$total_record?></b>명, <b><?=$page?></b> of <?=$total_page?> Pages</td>
								<td align=right>
								<?=fnc_Sms_Ram()?>
								<select name=displayrow onchange="fnc_search()">
									<?for ($i = 10; $i <= 100; ($i++)*5) {?>
									<option value="<?=$i?>" <?If (Trim($i)==trim($displayrow)) {?>selected<?}?>><?=$i?>개 출력
									<?}?>
								</select>
								</td>
							</tr>
						</table>
						
						<table width=100% cellpadding=0 cellspacing=0 border=0>
							<tr><td class=rnd colspan=10></td></tr>
							<tr class=rndbg>
								<th>선택</th>	
								<th>번호</th>
								<th>구분</th>
								<th>이름</th>
								<th>연락처</th>
								<th>대출기간[매입일]</th>
								<th>대출금[매입금액]</th>
								<th>이자[현재/완료일]</th>
								<th>상태</th>
								<th>보낸시각</th>
							</tr>
							<tr><td class=rnd colspan=10></td></tr>
							<col width=5% align=center>
							<col width=5% align=center>
							<col width=7% align=center>
							<col width=8% align=center>
							<col width=8% align=left>
							<col width=15% align=left>
							<col width=20% align=center>
							<col width=12% align=center>
							<col width=10% align=center>
							<col width=15% align=center>
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<tr height=30 align="center">
								<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?=mysql_result($result,$i,int_number)?>|<?=js_escape(mysql_result($result,$i,str_telep))?>"></td>
								<td><font class=ver81 color=616161><?= $article_num?></font></td>
								<td><font color=616161>
									<?switch (mysql_result($result,$i,str_gubun)) {
										case  "1" : echo "부동산대출"; break;
										case  "2" : echo "동산대출"; break;
										case  "3" : echo "상품매입"; break;
									}
									?>
								</font></td>
								<td><span id="navig" name="navig" m_id="admin" m_no="1"><font color=0074BA><b><?=mysql_result($result,$i,str_name)?></b></font></span></td>
								<td><?=mysql_result($result,$i,str_telep)?></td>
								<td>
									<?if (mysql_result($result,$i,str_gubun)=="3") {?>
										<?=mysql_result($result,$i,str_sdate)?>
									<?}else{?>
										<?=mysql_result($result,$i,str_sdate)?>~<?=mysql_result($result,$i,str_edate)?>
									<?}?>
								</td>
								<td style="text-align:right;padding-right:10px;">
									<?if (mysql_result($result,$i,str_gubun)!="3") {?>
										[이율 : <?=number_format(mysql_result($result,$i,int_rate),2)?>%]
									<?}?>
									<?=number_format(mysql_result($result,$i,int_price))?>원
								</td>
								<td style="text-align:right;padding-right:10px;">
									<?if (mysql_result($result,$i,str_gubun)=="3") {?>
										-
									<?}else{?>
										<?
										if (mysql_result($result,$i,str_sdate) <= date("Y-m-d")) {
											$sdate = mysql_result($result,$i,str_sdate);
											if (date("Y-m-d") > mysql_result($result,$i,str_edate)) {
												$edate = mysql_result($result,$i,str_edate);
											}else{
												$edate = date("Y-m-d");
											}
											?>
											<?if ($edate!="") {?>
											[기준 : <?=$edate?>]
											<?}?>
											<?$sDay=((strtotime($edate) - strtotime($sdate))/86400)?>
											<?=number_format(mysql_result($result,$i,int_price) * ((mysql_result($result,$i,int_rate)/100) * ($sDay/365)),0)?>원
										<?}else{?>
											-
										<?}?>
									<?}?>
								</td>
								<td><font color=616161>
									<?switch (mysql_result($result,$i,str_pass)) {
										case  "2" : echo "대출/매입고객정보"; break;
										case  "3" : echo "상환완료고객"; break;
									}
									?>
								</font></td>
								<td><font class=ver81 color=616161><?=Fnc_Om_Conv_Default(mysql_result($result,$i,dtm_send),"-")?></font></td>
							</tr>
							<tr><td colspan=10 class=rndline></td></tr>
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
						
						<table border="1" width=100% style="display:none;">
							<tr>
								<td id="obj_Lbl" colspan="2" height="1000"></td>
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
