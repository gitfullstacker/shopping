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

	If ($Txt_word!="") {
		switch ($Txt_key) {
			case  "all" :
				$Str_Query = " and (a.str_code like '%$Txt_word%') ";
				break;
			case  "str_brand" :
				$Str_Query = " and a.str_code like '%$Txt_word%' ";
				break;
		}
	}
	
	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_com_code a where a.int_number is not null and a.int_gubun='3' ";
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
	$SQL_QUERY.="comm_com_code a  ";
	$SQL_QUERY.="where a.int_number is not null and a.int_gubun='3' ";
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
<script language="javascript">
	function fnc_good(str_ncontents) {
		parent.oEditors.getById['str_ncontents'].exec("PASTE_HTML", [unescape(str_ncontents)]);
		//parent.document.frm.str_ncontents.value = unescape(str_ncontents);
		parent.closeLayer();
	}
	function fnc_search() {
		document.frm.page.value=1;
		document.frm.action = "comm_notice.php";
		document.frm.submit();
	}
</script>
</head>

<body class=scroll>

			<table width=100%>
				<tr>
					<td style="padding:10px">
					
						<div class="title title_top">상품</div>

						<form id="frm" name="frm" target="_self" method="POST">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="obj1" value="<?=$obj1?>">
						<input type="hidden" name="obj2" value="<?=$obj2?>">
						<input type="hidden" name="obj3" value="<?=$obj3?>">
						
						<table class=tb>
							<col class=cellC><col class=cellL style="width:250">
							<col class=cellC><col class=cellL>
							<tr>
								<td>키워드검색</td>
								<td colspan="3">
									<select name="Txt_key">
										<option value="all" <?If ($Txt_key=="all") {?>selected<?}?>> 통합검색 </option>
										<option value="str_brand" <?If ($Txt_key=="str_brand") {?>selected<?}?>> 브랜드 </option>
									</select> 
									<input type="text" NAME="Txt_word" value="<?=$Txt_word?>">
								</td>
							</tr>
						</table>
						
						<div class=button_top><img src="/admincenter/img/btn_search2.gif" style="cursor:pointer" onClick="fnc_search();"></div>

						<table width=100% cellpadding=0 cellspacing=0 border=0>
							<tr><td class=rnd colspan=3></td></tr>
							<tr class=rndbg>
								<th>번호</th>
								<th>상품고지</th>
								<th>선택</th>
							</tr>
							<tr><td class=rnd colspan=3></td></tr>
							<col width=10% align=center>
							<col width=80% align=left>
							<col width=10% align=center>
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<tr height=30 align="center">
								<td><font class=ver81 color=616161><?= $article_num?></font></td>
								<td style="text-align:left"><?=mysql_result($result,$i,str_code)?></td>
								<td class="noline"><a href="javascript:fnc_good('<?=js_escape(mysql_result($result,$i,str_contents))?>')"><img src="/admincenter/img/i_add.gif"></a></td>
							</tr>
							<tr><td colspan=3 class=rndline></td></tr>
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


						<br>
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
					</td>
				</tr>
			</table>

</body>
</html>