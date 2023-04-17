<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	//Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");

	$SQL_QUERY="select count(a.int_gubun) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_option_name a where a.str_goodcode='$str_goodcode' ";
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
	$SQL_QUERY.="comm_goods_option_name a  ";
	$SQL_QUERY.="where a.str_goodcode='$str_goodcode' ";
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
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/good_option_name.js"></script>
</head>
<body class=scroll onload="document.frm.str_oname.focus();">
<script language="javascript">
	parent.fuc_set('good_option_name_proc.php?RetrieveFlag=OPTION&str_goodcode=<?=$str_goodcode?>','_Option<?=$str_goodcode?>');
</script>
<div style="margin-top:10px;">
<div style="margin-bottom:10px;">

<div class="title title_top">옵션명설정</div>
<form id="frm" name="frm" target="_self" method="POST" action="good_option_name.php">
<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
<input type="hidden" name="str_goodcode" value="<?=$str_goodcode?>">
<input type="hidden" name="Page" value="<?=$page?>">
<input type="hidden" name="str_no">

<table width=100% cellpadding=0 cellspacing=0 border=0 bgcolor=EBEBEB>
	<tr>
		<td bgcolor=E8E8E8>
			<table width="100%" cellpadding=2 cellspacing=1 border=0 bgcolor=E8E8E8>
				<tr>
					<td width="20%" bgcolor=F6F6F6 align=center>옵션명</td>
					<td width="80%" bgcolor=white>
						<input type=text name="str_oname" size=30>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<div style="margin-bottom:10px;padding-top:10;" class=noline align=center>
<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_confirm_s.gif"></a>
</div>


<div class="title title_top">옵션내역<span></span></div>

<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td class=rnd colspan=4></td>
	</tr>
	<tr class=rndbg>
		<th>번호</th>
		<th>옵션명</th>
		<th>등록일자</th>
		<th>삭제</th>
	</tr>
	<tr><td class=rnd colspan=4></td></tr>
	<col width=10% align=center>
	<col width=60% align=left>
	<col width=20% align=center>
	<col width=10% align=center>
	<tr><td height=4 colspan=5></td></tr>
	<?$count=0;?>
	<?if($total_record_limit!=0){?>
	<?$article_num = $total_record - $displayrow*($page-1) ;?>
	<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
	<tr height=25 align="center">
		<td><font class=ver81 color=616161><?= $article_num?></td>
		<td style="text-align:left;"><font class=ver81 color=333333><?=mysql_result($result,$i,str_oname)?></td>
		<td><font class=ver81 color=616161><?=substr(mysql_result($result,$i,dtm_indate),0,10)?></td>
		<td align=center><a href="javascript:Delete_Click('<?=mysql_result($result,$i,int_gubun)?>')"><img src="/admincenter/img/i_del.gif"></a></td>
	</tr>
	<tr><td height=4 colspan=4></td></tr>
	<tr><td colspan=4 class=rndline></td></tr>
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

<script>table_design_load();</script>
</body>
</html>