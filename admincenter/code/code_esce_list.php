<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?   
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<? 
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
	$str_idxcode  = Fnc_Om_Conv_Default($_REQUEST[str_idxcode],"03");
	
	$Txt_idxword = Fnc_Om_Conv_Default($_REQUEST[Txt_idxword],"");

	If ($Txt_idxword!="") { $Str_Query .= " and a.str_idxword like '%$Txt_idxword%' ";}
	
	$SQL_QUERY="select count(a.str_idxnum) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_fun_code a where a.str_idxcode='$str_idxcode' ";
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
	
	$SQL_QUERY = "select a.* from "; 
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_fun_code a ";
	$SQL_QUERY.="where a.str_idxcode='$str_idxcode' ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.str_idxcode,a.str_idxnum desc ";
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
<script language="javascript" src="js/code_esce_list.js"></script>
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
		<td valign=top id=leftMenu>
			<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_lmenu_info.php";?>
		</td>
		<td colspan=2 valign=top height=100%> 
			<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_stitle_info.php";?>
			<table width=100%>
				<tr>
					<td style="padding:10px">
					
						<form id="frm" name="frm" target="_self" method="POST" action="code_esce_list.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_idxcode" value="<?=$str_idxcode?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="str_no">
						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>
						
						<table class=tb>
							<col class=cellC><col class=cellL>
							<tr>
								<td>분류</td>
								<td>
									<input type=text name=Txt_idxword value="<?=$Txt_idxword?>" class=lline>
								</td>
							</tr>
						</table>
						<div class=button_top><img src="/admincenter/img/btn_search2.gif" style="cursor:hand" onClick="fnc_search();"></div>

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
							<tr><td class=rnd colspan=6></td></tr>
							<tr class=rndbg>
								<th>번호</th>
								<th>분류</th>
								<th>출력유무</th>
								<th>등록일</th>
								<th>수정</th>
								<th>삭제</th>
							</tr>
							<tr><td class=rnd colspan=6></td></tr>
							<col width=5% align=center>
							<col width=59% align=left>
							<col width=8% align=center>
							<col width=20% align=center>
							<col width=4% align=center>
							<col width=4% align=center>
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<tr height=30 align="center">
								<td><font class=ver81 color=616161><?= $article_num?></font></td>
								<td style="text-align:left;"><span id="navig" name="navig" m_id="admin" m_no="1"><font color=0074BA><b><?=mysql_result($result,$i,str_idxword)?></b></font></span></td>
								<td><font class=small color=616161><?If (mysql_result($result,$i,str_service)=="Y"){?>출력<?}else{?>미출력<?}?></font></td>
								<td><font class=ver81 color=616161><?=mysql_result($result,$i,dtm_indate)?></font></td>
								<td><a href="javascript:RowClick('<?=mysql_result($result,$i,str_idxnum)?>');"><img src="/admincenter/img/i_edit.gif"></a></td>
								<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?=mysql_result($result,$i,str_idxnum)?>"></td>
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
	<tr>
		<td style="border-right:3px solid #06372B;font-size:0px">&nbsp;</td>
		<td height=3 bgcolor=#323232 colspan=2></td>
	</tr>
	<tr><td height=10></td></tr>
	<tr><td height=3 bgcolor="#E6E6E6" colspan=2></td></tr>
	<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_copyright_info.php";?>
</table>
<script>table_design_load();</script>
</body>
</html>

</body>
</html>