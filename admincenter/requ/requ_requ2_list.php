<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$Txt_gbn = Fnc_Om_Conv_Default($_REQUEST[Txt_gbn],"1");
	
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
	$Txt_store = Fnc_Om_Conv_Default($_REQUEST[Txt_store],"");
	$Txt_gubun = Fnc_Om_Conv_Default($_REQUEST[Txt_gubun],"");

	$Txt_name = Fnc_Om_Conv_Default($_REQUEST[Txt_name],"");
	$Txt_pass = Fnc_Om_Conv_Default($_REQUEST[Txt_pass],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");

	$Txt_sdate = Fnc_Om_Conv_Default($_REQUEST[Txt_sdate],"");
	$Txt_edate = Fnc_Om_Conv_Default($_REQUEST[Txt_edate],"");

	If ($Txt_store!="") { $Str_Query .= " and a.int_store = '$Txt_store' ";}
	If ($Txt_gubun!="") { $Str_Query .= " and a.str_gubun = '$Txt_gubun' ";}
	If ($Txt_name!="") { $Str_Query .= " and a.str_name like '%$Txt_name%' ";}
	If ($Txt_pass!="") { $Str_Query .= " and a.str_pass = '$Txt_pass' ";}

	if ($Txt_sindate!="") { $Str_Query .= " and date_format(a.dtm_mdate, '%Y-%m-%d') >= '$Txt_sindate' ";}
	if ($Txt_eindate!="") { $Str_Query .= " and date_format(a.dtm_mdate, '%Y-%m-%d') <= '$Txt_eindate' ";}

	if ($Txt_sdate!="") { $Str_Query .= " and date_format(a.str_sdate, '%Y-%m-%d') >= '$Txt_sdate' ";}
	if ($Txt_edate!="") { $Str_Query .= " and date_format(a.str_sdate, '%Y-%m-%d') <= '$Txt_edate' ";}
	
	if ($Txt_gbn=="1") {
		$Str_Query .= " and a.str_gubun in ('1','2') ";
	}else{
		$Str_Query .= " and a.str_gubun in ('3') ";
	}

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

	$SQL_QUERY = "select a.*,b.str_code from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_requ a left join ".$Tname."comm_com_code b on a.int_store=b.int_number ";
	$SQL_QUERY.="where a.int_number is not null and a.str_pass in ('2','3') ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.dtm_mdate desc ";
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
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/requ_requ2_list.js"></script>
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

						<form id="frm" name="frm" target="_self" method="POST" action="requ_requ2_list.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="Txt_gbn" value="<?=$Txt_gbn?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="str_no">

						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<tr>
								<td>지점</td>
								<td colspan="3">
									<select name="Txt_store" style="width:200px;">
										<option value="">선택</option>
										<?
										$Sql_Query =	" SELECT
														A.*
													FROM `"
														.$Tname."comm_com_code` AS A
													WHERE
														A.INT_GUBUN='6'
														AND
														A.STR_SERVICE='Y'
													ORDER BY
														A.INT_NUMBER ASC ";
									
										$arr_Data2=mysql_query($Sql_Query);
										$arr_Data2_Cnt=mysql_num_rows($arr_Data2);
										?>
										<?
											for($int_I = 0 ;$int_I < $arr_Data2_Cnt; $int_I++) {
										?>
										<option value="<?=mysql_result($arr_Data2,$int_I,int_number)?>" <?if (trim(mysql_result($arr_Data2,$int_I,int_number))==trim($Txt_store)) {?> selected<?}?>><?=mysql_result($arr_Data2,$int_I,str_code)?></option>
										<?
											}
										?>
									</select>
								</td>
							</tr>
							<?if ($Txt_gbn=="1") {?>
							<tr>
								<td>구분</td>
								<td colspan="3">
									<select name="Txt_gubun" style="width:200px;">
										<option value="" selected> 선택 </option>
										<option value="1" <?If ($Txt_gubun=="1") {?>selected<?}?>> 부동산대출 </option>
										<option value="2" <?If ($Txt_gubun=="2") {?>selected<?}?>> 동산대출 </option>
									</select>
								</td>
							</tr>
							<?}?>
							<tr>
								<td>이름</td>
								<td>
									<input type="text" NAME="Txt_name" value="<?=$Txt_name?>" style="width:300px;">
								</td>
								<td>상태</td>
								<td>
									<select name="Txt_pass" style="width:200px;">
										<option value="" selected> 선택 </option>
										<option value="2" <?If ($Txt_pass=="2") {?>selected<?}?>> 대출/매입고객정보 </option>
										<option value="3" <?If ($Txt_pass=="3") {?>selected<?}?>> 상환완료고객 </option>
									</select>
								</td>
							</tr>
							<tr>
								<td>최초계약일</td>
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
								<td>대출기간</td>
								<td colspan="3">
									<input type=text name=Txt_sdate value="<?=$Txt_sdate?>" id="Txt_sdate" onclick="displayCalendar(document.frm.Txt_sdate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.Txt_sdate ,'yyyy-mm-dd',document.frm.Txt_sdate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.Txt_sdate.value=''";>
									 -
									<input type=text name=Txt_edate value="<?=$Txt_edate?>" id="Txt_edate" onclick="displayCalendar(document.frm.Txt_edate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.Txt_edate ,'yyyy-mm-dd',document.frm.Txt_edate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.Txt_edate.value=''";>
									<a href="javascript:setDate('Txt_sdate','Txt_edate','<?=date("Y-m-d")?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_today.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sdate','Txt_edate','<?=date("Y-m-d", strtotime($day."-7day"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_week.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sdate','Txt_edate','<?=date("Y-m-d", strtotime($day."-15day"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_twoweek.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sdate','Txt_edate','<?=date("Y-m-d", strtotime($month."-1month"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_month.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sdate','Txt_edate','<?=date("Y-m-d", strtotime($month."-2month"))?>','<?=date("Y-m-d")?>')"><img src="/admincenter/img/sicon_twomonth.gif" align=absmiddle></a>
									<a href="javascript:setDate('Txt_sdate','Txt_edate','','')"><img src="/admincenter/img/sicon_all.gif" align=absmiddle></a>
								</td>
							</tr>
						</table>
						<div class=button_top><img src="/admincenter/img/btn_search2.gif" style="cursor:pointer" onClick="fnc_search();"></div>

						<table width=100%>
							<tr>
								<td class=pageInfo>총 <b><?=$total_record?></b>건, <b><?=$page?></b> of <?=$total_page?> Pages</td>
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
								<th>번호</th>
								<th>지점</th>
								<th>건번호</th>
								<th>구분</th>
								<th>이름</th>
								<th>연락처</th>
								<th>대출기간[매입일]</th>
								<th>대출금[매입금액]</th>
								<th>이자[현재/완료일]</th>
								<th>상태</th>
								<th>최초계약일</th>
								<th>보기</th>
								<th>선택</th>
							</tr>
							<tr><td class=rnd colspan=13></td></tr>
							<col width=5% align=center>
							<col width=5% align=center>
							<col width=5% align=center>
							<col width=5% align=center>
							<col width=6% align=center>
							<col width=8% align=left>
							<col width=15% align=left>
							<col width=15% align=center>
							<col width=12% align=center>
							<col width=10% align=center>
							<col width=6% align=center>
							<col width=4% align=center>
							<col width=4% align=center>
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<tr height=30 align="center">
								<td><font class=ver81 color=616161><?= $article_num?></font></td>
								<td><?=mysql_result($result,$i,str_code)?></td>
								<td><?=mysql_result($result,$i,str_doc)?></td>
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
										[이율 : <?=number_format(mysql_result($result,$i,int_rate),3)?>%]
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
											<?$sDay=((strtotime($edate) - strtotime($sdate))/86400)+1?>
											<?=number_format(mysql_result($result,$i,int_price) * ((mysql_result($result,$i,int_rate)/100) * $sDay / 365),0)?>원
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
								<td><font color=616161><?=substr(mysql_result($result,$i,dtm_mdate),0,10)?></font></td>
								<td><a href="javascript:RowClick('<?=mysql_result($result,$i,int_number)?>');"><img src="/admincenter/img/btn_viewbbs.gif"></a></td>
								<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?=mysql_result($result,$i,int_number)?>"></td>
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

						<div style="float:left;">
						<img src="/admincenter/img/btn_allselect_s.gif" alt="전체선택"  border="0" align='absmiddle' style="cursor:pointer" onclick="javascript:selectItem('1');">
						<img src="/admincenter/img/btn_alldeselect_s.gif" alt="선택해제"  border="0" align='absmiddle' style="cursor:pointer" onclick="javascript:selectItem('2');">
						<img src="/admincenter/img/btn_alldelet_s.gif" alt="선택삭제" border="0" align='absmiddle' style="cursor:pointer" onclick="javaScript:Adelete_Click();">
						</div>

						<div style="float:right;">

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
