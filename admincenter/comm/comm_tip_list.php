<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
	$str_filename = Fnc_Om_Conv_Default($_REQUEST[str_filename],"");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");

	If ($Txt_word!="") { $Str_Query .= " and A.str_title like '%$Txt_word%' ";}

	$SQL_QUERY="SELECT
			COUNT(A.INT_NUMBER)
		FROM
			".$Tname."comm_check_tip A
		WHERE
			A.STR_FILENAME='".$str_filename."' ";
	$SQL_QUERY .= $Str_Query;
	$SQL_QUERY .= " ORDER BY A.INT_NUMBER DESC";

	$arr_Rlt_Data = mysql_query($SQL_QUERY);

	if(!$arr_Rlt_Data){
	   error("QUERY_ERROR");
	   exit;
	}
	$arr_Rlt_Data_Cnt = mysql_result($arr_Rlt_Data,0,0);

	if(!$arr_Rlt_Data_Cnt){
		$first = 1;
		$last = 0;
	}else{
	  	$first = $displayrow *($page-1) ;
	  	$last = $displayrow *$page;

	  	$IsNext = $arr_Rlt_Data_Cnt - $last ;
	  	if($IsNext > 0){
			$last -= 1;
	  	}else{
	   		$last = $arr_Rlt_Data_Cnt -1 ;
	  	}
	}
	$total_page = ceil($arr_Rlt_Data_Cnt/$displayrow);

	$f_limit=$first;
	$l_limit=$last + 1 ;

	$SQL_QUERY="SELECT
			A.*
		FROM
			".$Tname."comm_check_tip A
		WHERE
			A.STR_FILENAME='".$str_filename."' ";
	$SQL_QUERY .= $Str_Query;
	$SQL_QUERY .= " ORDER BY A.INT_NUMBER DESC ";
	$SQL_QUERY .="limit $f_limit,$l_limit";

	$arr_Rlt_Data = mysql_query($SQL_QUERY);
	if(!$arr_Rlt_Data) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($arr_Rlt_Data);
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/comm_tip_list.js"></script>
</head>
<body class=scroll>

<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" align="center">

			<table width=100%>
				<tr>
					<td style="padding:10px">

						<form id="frm" name="frm" target="_self" method="POST" action="coomm_tip_list.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="str_filename" value="<?=$str_filename?>">
						<input type="hidden" name="str_no">
						<div class="title title_top">CHECK TIP정보</div>
						<table class=tb>
							<col class=cellC><col class=cellL>
							<tr>
								<td>제목</td>
								<td>
									<input type="text" NAME="Txt_word" value="<?=$Txt_word?>" style="width:400px;">
								</td>
							</tr>
						</table>

						<div class=button_top><img src="/admincenter/img/btn_search2.gif" style="cursor:hand" onClick="fnc_search();"></div>

						<table width=100%>
							<tr>
								<td class=pageInfo>총 <b><?=$arr_Rlt_Data_Cnt?></b>건, <b><?=$page?></b> of <?=$total_page?> Pages</td>
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
							<tr><td class=rnd colspan=10></td></tr>
							<tr class=rndbg>
								<th>번호</th>
								<th>제목</th>
								<th>최종수정일</th>
								<th>수정</th>
								<th>삭제</th>
							</tr>
							<tr><td class=rnd colspan=10></td></tr>
							<col width=8% align=center>
							<col width=66% align=left>
							<col width=12% align=center>
							<col width=7% align=center>
							<col width=7% align=center>
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $arr_Rlt_Data_Cnt - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<tr height=30 align="center">
								<td><font class=ver81 color=616161><?= $article_num?></font></td>
								<td><font class=small color=616161><?=mysql_result($arr_Rlt_Data,$i,str_title)?></font></td>
								<td><font class=ver81 color=616161><?=substr(mysql_result($arr_Rlt_Data,$i,dtm_indate),0,10)?></font></td>
								<td><a href="javascript:RowClick('<?=mysql_result($arr_Rlt_Data,$i,int_number)?>');"><img src="/admincenter/img/i_edit.gif" border=0 align=absmiddle align="right"></a></td>
								<td class="noline"><input type=checkbox name="chkItem1[]" id="chkItem1" value="<?=mysql_result($arr_Rlt_Data,$i,int_number)?>"></td>
							</tr>
							<tr><td colspan=10 class=rndline></td></tr>
							<?
							$article_num--;
							$count++;
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
						<img src="/admincenter/img/btn_regist_s.gif" alt="등록" border=0 align=absmiddle style="cursor:hand" onClick="AddNew();">
						</div>

						<table border="0" style="display:none;">
							<tr>
								<td id="obj_Lbl" colspan="2" height="0"></td>
							</tr>
						</table>
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