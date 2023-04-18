<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$SQL_QUERY = "SELECT
				A.STR_IDXWORD,
				A.INT_CHOSORT,
				A.INT_UNISORT,
				A.FULL_NAME,
				A.FULL_CODE,
				A.STR_MENUTYPE,
				A.STR_CHOCODE,
				A.STR_UNICODE,
				A.STR_SERVICE
			FROM ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_menu_idx A
			WHERE
				A.STR_MENUTYPE='03'
				AND
				A.STR_UNICODE='10001'
			ORDER BY
				A.FULL_SORT ASC ";

	$arr_menu_Data=mysql_query($SQL_QUERY);
	
	$arr_Data=mysql_query($SQL_QUERY);
	$arr_Data_Cnt=mysql_num_rows($arr_Data);
	
	if ($arr_Data_Cnt) {
		$str_mbcode = mysql_result($arr_Data,0,str_menutype).mysql_result($arr_Data,0,str_chocode).mysql_result($arr_Data,0,str_unicode);
	}


	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);

	$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key],"all");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
	$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service],"");

	$Txt_bname = Fnc_Om_Conv_Default($_REQUEST[Txt_bname],"");
	$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode],$str_mbcode);

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");

	If ($Txt_word!="") {
		switch ($Txt_key) {
			case  "all" :
				$Str_Query = " and (a.str_title like '%$Txt_word%') ";
				break;
			case  "str_title" :
				$Str_Query = " and a.str_title like '%$Txt_word%' ";
				break;
		}
	}

	If ($Txt_service!="") { $Str_Query .= " and a.str_service = '$Txt_service' ";}

	if ($Txt_bcode!="") { $Str_Query .= " and a.str_bcode in (select concat(c.str_menutype,c.str_chocode,c.str_btmuni) from ".$Tname."comm_menu_btm c where c.str_menutype='".substr($Txt_bcode,0,2)."' and c.str_chocode='".substr($Txt_bcode,2,2)."' and c.str_unicode='".substr($Txt_bcode,4,5)."') ";}


	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_cpp_main_ban_master a where a.int_number is not null ";
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

	$SQL_QUERY = "select a.* ";
	$SQL_QUERY.=" from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_cpp_main_ban_master a ";
	$SQL_QUERY.="where a.int_number is not null ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.int_number desc ";
	$SQL_QUERY.="limit $f_limit,$l_limit";

	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);

	$str_String = "?Page=".$page."&displayrow=".urlencode($displayrow)."&Txt_key=".urlencode($Txt_key)."&Txt_word=".urlencode($Txt_word)."&Txt_service=".urlencode($Txt_service)."&Txt_bname=".urlencode($Txt_bname)."&Txt_bcode=".urlencode($Txt_bcode)."&Txt_sindate=".urlencode($Txt_sindate)."&Txt_eindate=".urlencode($Txt_eindate);
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/cate_larg_list.js"></script>
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
						
						<?if ($arr_Data_Cnt) {?>
						<table class=tb>
							<col style="padding-left:10px;width:<?=100/$arr_Data_Cnt;?>%;">
							<tr>
								<?for($int_I = 0 ;$int_I < $arr_Data_Cnt; $int_I++) {?>
								<td>
									<a href="cate_larg_list.php?str_bcode=<?=mysql_result($arr_Data,$int_I,str_menutype).mysql_result($arr_Data,$int_I,str_chocode).mysql_result($arr_Data,$int_I,str_unicode)?>">
										<?if (mysql_result($arr_Data,$int_I,str_menutype).mysql_result($arr_Data,$int_I,str_chocode).mysql_result($arr_Data,$int_I,str_unicode)==$str_bcode) {?>
											<b><?=mysql_result($arr_Data,$int_I,str_idxword)?></b>
										<?}else{?>
											<?=mysql_result($arr_Data,$int_I,str_idxword)?>
										<?}?>
									</a>
								</td>
								<?}?>
							</tr>
						</table>
						<br>
						
						<form id="frm" name="frm" target="_self" method="POST" action="cate_larg_list.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="str_bcode" value="<?=$str_bcode?>">
						<input type="hidden" name="str_no">
						<input type="hidden" name="str_String" value="<?=$str_String?>">


						<table class=tb>
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:88%;">
							<tr>
								<td>키워드검색</td>
								<td colspan="3">
									<select name="Txt_key">
										<option value="all" <?If ($Txt_key=="all") {?>selected<?}?>> 통합검색 </option>
										<option value="str_title" <?If ($Txt_key=="str_title") {?>selected<?}?>> 제목 </option>
									</select>
									<input type="text" NAME="Txt_word" value="<?=$Txt_word?>">
								</td>
							</tr>
							<tr>
								<td>출력여부</td>
								<td colspan="3">
									<input type="radio" value="" name="Txt_service" class=null <?If ($Txt_service=="") {?>checked<?}?>> 전체
									<input type="radio" value="Y" name="Txt_service" class=null <?If ($Txt_service=="Y") {?>checked<?}?>> 출력
									<input type="radio" value="N" name="Txt_service" class=null <?If ($Txt_service=="N") {?>checked<?}?>> 미출력
								</td>
							</tr>
							<tr>
								<td>등록일</td>
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

						<div class=button_top><img src="/admincenter/img/btn_search2.gif" style="cursor:hand" onClick="fnc_search();"></div>
						
						<table width=100%>
							<tr>
								<td class=pageInfo>총 <b><?=$total_record?></b>건, <b><?=$page?></b> of <?=$total_page?> Pages
								</td>
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
							<tr><td class=rnd colspan=9></td></tr>
							<tr class=rndbg>
								<th>번호</th>
								<th>배너타입</th>
								<th>제목</th>
								<th>설정기간</th>
								<th>소트번호</th>
								<th>등록일</th>
								<th>출력유무</th>
								<th>수정</th>
								<th>삭제</th>
							</tr>
							<tr><td class=rnd colspan=9></td></tr>
							<col width=5% align=center>
							<col width=10% align=center>
							<col width=30% align=left>
							<col width=20% align=center>
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
								<td>
									<span id="navig" name="navig" m_id="admin" m_no="1"><font color=0074BA><b><?=mysql_result($result,$i,str_goodcode)?></b></font></span>
								</td>
								<td>
									<?switch (mysql_result($result,$i,str_btype)) {
										case  "1" : echo "기본형"; break;
										case  "2" : echo "세로형"; break;
										case  "3" : echo "조합형"; break;
										case  "4" : echo "갤러리형"; break;
										case  "5" : echo "탭메뉴형"; break;
									}
									?>	
								</td>
								<td style="text-align:left"><?=mysql_result($result,$i,str_title)?></td>
								<td><?=mysql_result($result,$i,str_sdate)?>~<?=mysql_result($result,$i,str_edate)?></td>
								<td>
									<input type=text name="int_sort[]" id="int_sort" value="<?=mysql_result($result,$i,int_sort)?>" style="width:50px;background-Color:#eeeded;text-align:center;ime-mode:inactive" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()">
									<input type=hidden name="chkItem2[]" id="chkItem2" value="<?=mysql_result($result,$i,int_number)?>">
								</td>
								<td><font class=ver81 color=616161><?=substr(mysql_result($result,$i,dtm_indate),0,10)?></font></td>
								<td><font class=small color=616161>
									<?switch (mysql_result($result,$i,str_service)) {
										case  "Y" : echo "출력"; break;
										case  "N" : echo "미출력"; break;
									}
									?>	
								</font></td>
								<td><a href="javascript:RowClick('<?=mysql_result($result,$i,int_number)?>');"><img src="/admincenter/img/i_edit.gif"></a></td>
								<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?=mysql_result($result,$i,int_number)?>"></td>
							</tr>
							<tr><td colspan=9 class=rndline></td></tr>
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
						<img src="/admincenter/img/btn_allselect_s.gif" alt="전체선택"  border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('1');">
						<img src="/admincenter/img/btn_alldeselect_s.gif" alt="선택해제"  border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('2');">
						<img src="/admincenter/img/btn_alldelet_s.gif" alt="선택삭제" border="0" align='absmiddle' style="cursor:hand" onclick="javaScript:Adelete_Click();">
						</div>

						<div style="float:right;">
						<select name="str_btype">
							<option value="1">기본형
							<option value="2">세로형
							<option value="3">조합형
							<option value="4">갤러리형
							<option value="5">탭메뉴형
						</select>
						<img src="/admincenter/img/btn_regist_s.gif" alt="등록" border=0 align=absmiddle style="cursor:hand" onClick="AddNew();">
						</div>
						
						
						</form>
						
						<?}?>


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
