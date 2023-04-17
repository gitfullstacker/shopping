<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],100);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	$Txt_name = Fnc_Om_Conv_Default($_REQUEST[Txt_name],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");
	
	If ($Txt_name!="") { $Str_Query .= " and b.str_name like '%$Txt_name%' ";}

	if ($Txt_sindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";}
	if ($Txt_eindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";}

	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member_alarm a inner join ".$Tname."comm_member b on a.str_userid=b.str_userid where a.int_number is not null and a.str_goodcode='$str_no' ";
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

	$SQL_QUERY = "select a.*,b.str_name,b.str_hp from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member_alarm a inner join ".$Tname."comm_member b on a.str_userid=b.str_userid ";
	$SQL_QUERY.="where a.int_number is not null and a.str_goodcode='$str_no' ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.int_number asc ";
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
<script language="javascript" src="js/good_master_like.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td colspan=2 valign=top height=100%> 
			<table width=100%>
				<tr>
					<td style="padding:10px">
						<div class="title title_top">입고알림</div>

						<form id="frm" name="frm" target="_self" method="POST" action="good_master_like.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">

						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:88%">
							<tr>
								<td>회원명</td>
								<td colspan="3">
									<input type="text" NAME="Txt_name" value="<?=$Txt_name?>" style="width:300px;">
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
						<div class=button_top><img src="/admincenter/img/btn_search2.gif" style="cursor:hand" onClick="fnc_search();"></div>


						<div style="float:left;">
						<img src="/admincenter/img/btn_allselect_s.gif" alt="전체선택"  border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('1');">
						<img src="/admincenter/img/btn_alldeselect_s.gif" alt="선택해제"  border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('2');">
						<img src="/admincenter/img/btn_alldelet_s.gif" alt="선택삭제" border="0" align='absmiddle' style="cursor:hand" onclick="javaScript:Adelete_Click();">
						
						
						</div>

						<div style="float:right;">

						</div>

						<table width=100%>
							<tr>
								<td class=pageInfo>총 <b><?=$total_record?></b>건, <b><?=$page?></b> of <?=$total_page?> Pages</td>
								<td align=right>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<select name="str_exceltype">
									<option value="1">선택한 자료
									<option value="2">현재 검색리스트의 자료
									
								</select>
								<img src="/admincenter/img/bt_04.gif" alt="엑셀다운" border=0 align=absmiddle style="cursor:pointer" onClick="fnc_Excel()">
								&nbsp;
								<select name=displayrow onchange="fnc_search()">
									<?for ($i = 10; $i <= 100; ($i++)*5) {?>
									<option value="<?=$i?>" <?If (Trim($i)==trim($displayrow)) {?>selected<?}?>><?=$i?>개 출력
									<?}?>
								</select>
								</td>
							</tr>
						</table>

						
						<table width=100% cellpadding=0 cellspacing=0 border=0 >
							<tr><td class=rnd colspan=6></td></tr>
							<tr class=rndbg>
								<th>번호</th>
								<th>아이디</th>
								<th>회원명</th>
								<th>핸드폰</th>
								<th>등록일</th>
								<th>선택</th>
							</tr>
							<tr><td class=rnd colspan=6></td></tr>
							<col width=10% align=center>
							<col width=15% align=left>
							<col width=15% align=center>
							<col width=15% align=center>
							<col width=15% align=center>
							<col width=10% align=center>
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<tr height=30 align="center">
								<td><font class=ver81 color=616161><?= $article_num?></font></td>
								<td style="text-align:left;"><?=mysql_result($result,$i,str_userid)?></td>
								
								<td style="text-align:left;"><?=mysql_result($result,$i,str_name)?>
										<?
										$SQL_QUERY =	" select ifnull(a.str_ptype,0) as mtype,a.str_userid from `".$Tname."comm_member_pay` as a inner join `".$Tname."comm_member_pay_info` as b on a.int_number=b.int_number and a.str_pass='0' and date_format(b.str_sdate, '%Y-%m-%d') <= '".date("Y-m-d")."' and date_format(b.str_edate, '%Y-%m-%d') >= '".date("Y-m-d")."' and a.str_userid='".mysql_result($result,$i,str_userid)."' ";
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
								<td style="text-align:left;"><?=mysql_result($result,$i,str_hp)?></td>
								<td><font class=ver81 color=616161><?=mysql_result($result,$i,dtm_indate)?></font></td>
								<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?=mysql_result($result,$i,int_number)?>"></td>
							</tr>
							<tr><td colspan=6 class=rndline></td></tr>
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
							<a href="Javascript:MovePageA('1');" class=navi>◀◀</a>
						<?}else{?>
							◀◀
						<?}

						if($block > 1) {
						   $my_page = $first_page;
						?>
							<a href="Javascript:MovePageA('<?=$my_page?>');" class=navi>◀</a>
						<?}else{?>
							◀
						<?}

						echo" | ";
						for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
						   if($page == $direct_page) {?>
						      	<font color='cccccc'><b><?=$direct_page?></b></font> |
						   <?} else {?>
						    	<a href="Javascript:MovePageA('<?=$direct_page?>');" class=navi><?=$direct_page?></a> |
						   <?}
						}

						echo" ";

						if($block < $total_block) {
						   	$my_page = $last_page+1;?>
						    <a href="Javascript:MovePageA('<?=$my_page?>');" class=navi>▶</a>
						<?}else{ ?>
							▶
						<?}

						if($page < $total_page) {?>
							<a href="Javascript:MovePageA('<?=$total_page?>');" class=navi>▶▶</a>
						<?}else{?>
							▶▶
						<?}
						?>
						</div>


						</form>

					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script>table_design_load();</script>
</body>
</html>
