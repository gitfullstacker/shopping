<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
	$obj1 = Fnc_Om_Conv_Default($_REQUEST[obj1],"");
	$obj2 = Fnc_Om_Conv_Default($_REQUEST[obj2],"");
	$obj3 = Fnc_Om_Conv_Default($_REQUEST[obj3],"");

	$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key],"all");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
	$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service],"");

	$Txt_bname = Fnc_Om_Conv_Default($_REQUEST[Txt_bname],"");
	$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");

	If ($Txt_word!="") {
		switch ($Txt_key) {
			case  "all" :
				$Str_Query = " and (a.str_goodname like '%$Txt_word%') ";
				break;
			case  "str_goodname" :
				$Str_Query = " and a.str_goodname like '%$Txt_word%' ";
				break;
		}
	}

	If ($Txt_service!="") { $Str_Query .= " and a.str_service = '$Txt_service' ";}
	//If ($Txt_bcode!="") { $Str_Query .= " and a.str_bcode = '$Txt_bcode' ";}

	if ($Txt_bcode!="") { $Str_Query .= " and a.str_goodcode in (select d.str_goodcode from ".$Tname."comm_goods_master_category d where d.str_bcode in (select concat(c.str_menutype,c.str_chocode,c.str_btmuni) from ".$Tname."comm_menu_btm c where c.str_menutype='".substr($Txt_bcode,0,2)."' and c.str_chocode='".substr($Txt_bcode,2,2)."' and c.str_unicode='".substr($Txt_bcode,4,5)."')) ";}


	$SQL_QUERY="select count(a.str_goodcode) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_master a where a.str_goodcode is not null ";
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

	$SQL_QUERY = "select a.*,(select count(b.str_sgoodcode) from ".$Tname."comm_goods_master_link b where b.str_goodcode=a.str_goodcode) as cnt2  ";
	$SQL_QUERY.=" from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_master a ";
	$SQL_QUERY.="where a.str_goodcode is not null ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.int_sort desc ";
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
<script language="javascript" src="js/egogood.js"></script>
<script language="javascript">
	function fnc_mgood(str_goodname,str_goodcode) {
		parent.document.<?=$obj1?>.<?=$obj2?>.value = str_goodname;
		parent.document.<?=$obj1?>.<?=$obj3?>.value = str_goodcode;
		parent.closeLayer();
	}
</script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td colspan=2 valign=top height=100%> 

			<table width=100%>
				<tr>
					<td style="padding:10px">
						<div class="title title_top">상품선택</div>

						<form id="frm" name="frm" target="_self" method="POST" action="egogood.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="obj1" value="<?=$obj1?>">
						<input type="hidden" name="obj2" value="<?=$obj2?>">
						<input type="hidden" name="obj3" value="<?=$obj3?>">
						<input type="hidden" name="str_no">
						<input type="hidden" name="str_String" value="<?=$str_String?>">


						<table class=tb>
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<tr>
								<td>키워드검색</td>
								<td colspan="3">
									<select name="Txt_key">
										<option value="all" <?If ($Txt_key=="all") {?>selected<?}?>> 통합검색 </option>
										<option value="str_goodname" <?If ($Txt_key=="str_goodname") {?>selected<?}?>> 상품명 </option>
									</select>
									<input type="text" NAME="Txt_word" value="<?=$Txt_word?>">
								</td>
							</tr>
							<tr>
								<td>출력여부</td>
								<td>
									<input type="radio" value="" name="Txt_service" class=null <?If ($Txt_service=="") {?>checked<?}?>> 전체
									<input type="radio" value="Y" name="Txt_service" class=null <?If ($Txt_service=="Y") {?>checked<?}?>> 출력
									<input type="radio" value="N" name="Txt_service" class=null <?If ($Txt_service=="N") {?>checked<?}?>> 미출력
									<input type="radio" value="R" name="Txt_service" class=null <?If ($Txt_service=="R") {?>checked<?}?>> 품절
								</td>
								<td>카테고리</td>
								<td>
									<input type=text name=Txt_bname value="<?=$Txt_bname?>" style="width:180px;" style="background-Color:#eeeded;" readonly> <a href="javascript:popupLayer('/admincenter/comm/comm_bcode.php?obj1=frm&obj2=Txt_bcode&obj3=Txt_bname&str_menutype=03',400,450)"><img src="/admincenter/img/i_search.gif" align=absmiddle></a>
									<a href="javascript:fnc_blank('Txt_bname','Txt_bcode')"><img src="/admincenter/img/i_del.gif" align=absmiddle></a>
								</td>
								<input type="hidden" name="Txt_bcode" value="<?=$Txt_bcode?>">
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
							<tr><td class=rnd colspan=6></td></tr>
							<tr class=rndbg>
								<th>번호</th>
								<th>상품코드</th>
								<th>이미지</th>
								<th>상품명</th>
								<th>정가</th>
								<th>등록된분류</th>
							</tr>
							<tr><td class=rnd colspan=6></td></tr>
							<col width=10% align=center>
							<col width=10% align=left>
							<col width=20% align=center>
							<col width=30% align=center>
							<col width=10% align=left>
							<col width=20% align=center>
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<tr height=30 align="center">
								<td><font class=ver81 color=616161><?= $article_num?></font></td>
								<td>
									<a href="javascript:fnc_mgood('<?=mysql_result($result,$i,str_goodname)?>','<?=mysql_result($result,$i,str_goodcode)?>');">
									<span id="navig" name="navig" m_id="admin" m_no="1"><font color=0074BA><b><?=mysql_result($result,$i,str_goodcode)?></b></font></span>
									</a>
								</td>
								<td height="100" align="center" valign="middle">
									<?if (mysql_result($result,$i,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" width="120" height="80" border="0"><?}else{?>&nbsp;<?}?>
								</td>
								<td>
									<span id="navig" name="navig" m_id="admin" m_no="1"><font class=ver81 color=0074BA><b><?=mysql_result($result,$i,str_goodname)?></b></font></span>
									<br>
									<?if (fnc_cart_info(mysql_result($result,$i,str_goodcode))==0) {?><font color="red"><b></i>RENTED</b></font><?}?>
								</td>
								<td><?=number_format(mysql_result($result,$i,int_price))?>원</td>
								<td><font class=small color=616161>
									<?
									$Sql_Query =	" SELECT
													A.*
												FROM `"
													.$Tname."comm_goods_master_category` AS A
												WHERE
													A.STR_GOODCODE='".mysql_result($result,$i,str_goodcode)."'
												ORDER BY
													A.STR_BCODE ASC ";
								
									$arr_Data=mysql_query($Sql_Query);
									$arr_Data_Cnt=mysql_num_rows($arr_Data);
									?>
									<?
										for($int_I = 0 ;$int_I < $arr_Data_Cnt; $int_I++) {
									?>
										<?=Fnc_Om_Cate_Name(mysql_result($arr_Data,$int_I,str_bcode))?><br>
									<?
										}
									?>
								</td>
							</tr>
							<tr><td colspan=6 class=rndline></td></tr>
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


						</form>
						<table border="0" style="display:none;">
							<tr>
								<td id="obj_Lbl" colspan="2" height="0"></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script>table_design_load();</script>
</body>
</html>
