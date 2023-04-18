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
	
	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_mail_master a where a.int_number is not null ";
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
	$SQL_QUERY.="comm_mail_master a ";
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
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript">
	function fnc_om_set(str_mailcode) {
		parent.document.<?=$obj1?>.<?=$obj2?>.value = str_mailcode;
		parent.document.frm.submit();
	}
</script>
</head>

<body class=scroll>

			<table width=100%>
				<tr>
					<td style="padding:10px">
					
						<div class="title title_top">컨텐츠메일선택</div>

						<form id="frm" name="frm" target="_self" method="POST">
						<input type="hidden" name="obj1" value="<?=$obj1?>">
						<input type="hidden" name="obj2" value="<?=$obj2?>">
						<input type="hidden" name="obj3" value="<?=$obj3?>">

						<table width=100% cellpadding=0 cellspacing=0 border=0>
							<tr><td class=rnd colspan=4></td></tr>
							<tr class=rndbg>
								<th>번호</th>
								<th>제목</th>
								<th>등록일</th>
								<th>선택</th>
							</tr>
							<tr><td class=rnd colspan=4></td></tr>
							<col width=10% align=center>
							<col width=40% align=center>
							<col width=20% align=center>
							<col width=10% align=center>
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<tr height=30 align="center">
								<td><font class=ver81 color=616161><?= $article_num?></font></td>
								<td style="text-align:left;"><?=mysql_result($result,$i,str_title)?></td>
								<td><font color=0074BA><b><?=substr(mysql_result($result,$i,dtm_indate),0,10)?></b></font></td>
								<td class="noline"><a href="javascript:fnc_om_set('<?=mysql_result($result,$i,int_number)?>');"><img src="/admincenter/img/i_add.gif"></a></td>
							</tr>
							<tr><td colspan=5 class=rndline></td></tr>
							<?
							$article_num--;
							if($article_num==0){
								break;
							}
							?>
							<?$count++;?>
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