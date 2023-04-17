<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?   
	Fnc_Acc_Admin();
	//Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<? 
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
	
	$obj1 = Fnc_Om_Conv_Default($_REQUEST[obj1],"");
	$obj2 = Fnc_Om_Conv_Default($_REQUEST[obj2],"");
	$obj3 = Fnc_Om_Conv_Default($_REQUEST[obj3],"");
	$obj4 = Fnc_Om_Conv_Default($_REQUEST[obj4],"");
	$obj5 = Fnc_Om_Conv_Default($_REQUEST[obj5],""); 
	$obj6 = Fnc_Om_Conv_Default($_REQUEST[obj6],""); 
	$obj7 = Fnc_Om_Conv_Default($_REQUEST[obj7],"");
	
	$findit = Fnc_Om_Conv_Default($_REQUEST[findit],""); 
	$Flag = Fnc_Om_Conv_Default($_REQUEST[Flag],"1");
	
	If ($findit!="") { $Str_Query .= " and a.str_donglee like '%$findit%' ";}
	
	if ($Flag=="1") {
		$SQL_QUERY1="select count(a.int_number) from ".$Tname."comm_post a where a.str_sido='' ";
		$SQL_QUERY1.=$Str_Query;
		$SQL_QUERY2="select a.* from ".$Tname."comm_post a where a.str_sido='' ";
		$SQL_QUERY2.=$Str_Query;
	}else{
		$SQL_QUERY1="select count(a.int_number) from ".$Tname."comm_post a where a.int_number is not null ";
		$SQL_QUERY1.=$Str_Query;
		$SQL_QUERY2="select a.* from ".$Tname."comm_post a where a.int_number is not null ";
		$SQL_QUERY2.=$Str_Query;
	}
	$result = mysql_query($SQL_QUERY1);
	
	if(!result) {
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
	$SQL_QUERY2.="limit $f_limit,$l_limit";
	
	$result = mysql_query($SQL_QUERY2);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);
	
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript">
	function RowDClick(fm,cnt) {
		if(parseInt(frm.txtRows.value) <= 1) {
			parent.<?=$obj1?>.<?=$obj2?>.value=frm.txtstr_post1.value;
			parent.<?=$obj1?>.<?=$obj3?>.value=frm.txtstr_post2.value;
			parent.<?=$obj1?>.<?=$obj4?>.value=frm.txtstr_sido.value;
			parent.<?=$obj1?>.<?=$obj5?>.value=frm.txtstr_sigun.value;
			parent.<?=$obj1?>.<?=$obj6?>.value=frm.txtstr_donglee.value;
		} else	{
			parent.<?=$obj1?>.<?=$obj2?>.value=frm.txtstr_post1[cnt].value;
			parent.<?=$obj1?>.<?=$obj3?>.value=frm.txtstr_post2[cnt].value;
			parent.<?=$obj1?>.<?=$obj4?>.value=frm.txtstr_sido[cnt].value;
			parent.<?=$obj1?>.<?=$obj5?>.value=frm.txtstr_sigun[cnt].value;
			parent.<?=$obj1?>.<?=$obj6?>.value=frm.txtstr_donglee[cnt].value;
		}
		parent.<?=$obj1?>.<?=$obj7?>.focus();
		parent.closeLayer();
	}
	function fnc_search() {
		document.frm.Page.value=1;
		document.frm.action = "comm_zipcode.php";
		document.frm.submit();
	}
</script>
</head>

<body topmargin=5 margintop=5 leftmargin=10 rightmargin=10 marginwidth=10 marginheight=5 onLoad="document.frm.findit.focus();">

<table border=0 cellspacing=0 cellpadding=0 width=100%>
	<tr><td><img src="/admincenter/img/title_address.gif" border=0></td></tr>
	<tr><td height=4 background="/admincenter/img/bg_ex.gif"></td></tr>
	<tr><td height=15></td></tr>
</table>

<form id="frm" name="frm" method="POST" action="comm_zipcode.php">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="obj1" value="<?=$obj1?>">
<input type="hidden" name="obj2" value="<?=$obj2?>">
<input type="hidden" name="obj3" value="<?=$obj3?>">
<input type="hidden" name="obj4" value="<?=$obj4?>">
<input type="hidden" name="obj5" value="<?=$obj5?>">
<input type="hidden" name="obj6" value="<?=$obj6?>">
<input type="hidden" name="obj7" value="<?=$obj7?>">
<input type="hidden" name="Flag" value="2">

<table border=0 cellspacing=0 cellpadding=0 align=center>
	<tr>
		<td><input type=text name="findit" value="<?=$findit?>"></td>
		<td width=5></td>
		<td><a href="Javascript:fnc_search();"><img src=/admincenter/img/btn_search_s.gif class=null></a></td>
	</tr>
</table>
<p>
<table width=100% cellpadding=0 cellspacing=0>
	<col width=80 align=center>
	<tr><td colspan=2 bgcolor="#cccccc" height=2></td></tr>
	<tr height=25>
		<th>우편번호</th>
		<th>주소</th>
	</tr>
	<tr><td colspan=2 bgcolor="#cccccc" height=2></td></tr>
	<?$count=0;?>
	<?if($total_record_limit!=0){?>
	<?$article_num = $total_record - $displayrow*($page-1) ;?>
	<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
	<tr  height=25>
		<td><font class=ver81 color=545454><?=substr(mysql_result($result,$i,str_post),0,3)?>-<?=substr(mysql_result($result,$i,str_post),3,3)?></td>
		<td><a href="javascript:RowDClick(this,<?=$count?>);"><font color=353535><?=mysql_result($result,$i,str_sido)?>&nbsp;<?=mysql_result($result,$i,str_sigun)?>&nbsp;<?=mysql_result($result,$i,str_donglee)?>&nbsp;<?=mysql_result($result,$i,str_bunji)?></a>
		<input type="hidden" name="txtstr_post1" value="<?=substr(mysql_result($result,$i,str_post),0,3)?>">
		<input type="hidden" name="txtstr_post2" value="<?=substr(mysql_result($result,$i,str_post),3,3)?>">
		<input type="hidden" name="txtstr_sido" value="<?=mysql_result($result,$i,str_sido)?>">
		<input type="hidden" name="txtstr_sigun" value="<?=mysql_result($result,$i,str_sigun)?>">
		<input type="hidden" name="txtstr_donglee" value="<?=Trim(mysql_result($result,$i,str_donglee))?>">
		</td>
	</tr>
	<?
	$article_num--;
	if($article_num==0){ 
		break;
	}
	?>
	<?$count++;?>
	<?}?>
	<?}else{?>
	
	<tr  height=250>
		<td colspan="2">&nbsp;</td>
	</tr>
	<?}?>
	<input type="hidden" name="txtRows" value="<?=$count?>">
	<tr><td colspan=2 bgcolor="#cccccc" height=2></td></tr>
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

</body>
</html>