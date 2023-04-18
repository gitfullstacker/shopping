<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	//Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"");

	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_option_value a where a.int_gubun='$int_gubun' and a.str_goodcode='$str_goodcode' ";
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
	$SQL_QUERY.="comm_goods_option_value a where a.int_gubun='$int_gubun' and a.str_goodcode='$str_goodcode' ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.dtm_indate desc ";
	$SQL_QUERY.="limit $f_limit,$l_limit";

	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);

	$SQL_QUERY = "select count(int_number) as seq from ".$Tname."comm_goods_option_value where int_gubun='$int_gubun' and str_goodcode='$str_goodcode' ";
	$arr_Data=mysql_query($SQL_QUERY);
	$idView_Option = mysql_result($arr_Data,0,seq);
	
	$RetrieveFlag="INSERT";
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/good_option_edit.js"></script>
<script language="javascript">
	parent.document.getElementById("idView_Option<?=$str_goodcode?>_<?=$int_gubun?>").innerHTML = "<?=$idView_Option?>건";
</script>
</head>
<body class=scroll onload="document.frm.str_option.focus();">

<div style="margin-top:10px;">
<div style="margin-bottom:10px;">

<div class="title title_top">옵션설정</div>
<form id="frm" name="frm" target="_self" method="POST" action="good_option_edit.php">
<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
<input type="hidden" name="int_gubun" value="<?=$int_gubun?>">
<input type="hidden" name="str_goodcode" value="<?=$str_goodcode?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="str_no">

<table cellpadding=0 cellspacing=0 border=0 bgcolor=EBEBEB>
	<tr>
		<td bgcolor=E8E8E8>
			<table cellpadding=2 cellspacing=1 border=0 bgcolor=E8E8E8>
				<tr>
					<td bgcolor=F6F6F6 align=center>옵션값</td>
					<td bgcolor=white>
						<input type=text name="str_option" size=30>
					</td>
				</tr>
				<tr>
					<td bgcolor=F6F6F6 width=160 align=center>추가금액</td>
					<td bgcolor=white width=400><input type=text name=int_aprice size=8 style="ime-mode:inactive" style="text-align:right;" required label="추가금액" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()"> 원 <font class=small color=444444>(추가 금액이 있을시 등록, 기본 0 입력.)</font></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<div style="margin-bottom:10px;padding-top:10;" class=noline align=center>
<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_confirm_s.gif"></a>
</div>


<div class="title title_top">옵션내역<span>포인트 상세내역을 확인합니다</span></div>

<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td class=rnd colspan=5></td>
	</tr>
	<tr class=rndbg>
		<th>번호</th>
		<th>옵션값</th>
		<th>추가금액</th>
		<th>등록일자</th>
		<th>삭제</th>
	</tr>
	<tr><td class=rnd colspan=5></td></tr>
	<col width=10% align=center>
	<col width=40% align=center>
	<col width=20% align=center>
	<col width=20% align=center>
	<col width=10% align=center>
	<tr><td height=4 colspan=5></td></tr>
	<?$count=0;?>
	<?if($total_record_limit!=0){?>
	<?$article_num = $total_record - $displayrow*($page-1) ;?>
	<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
	<tr height=25 align="center">
		<td><font class=ver81 color=616161><?= $article_num?></td>
		<td><font class=ver81 color=333333><a href="javascript:fnc_sv('<?=mysql_result($result,$i,int_number)?>','<?=mysql_result($result,$i,str_option)?>','<?=mysql_result($result,$i,int_aprice)?>')"><?=mysql_result($result,$i,str_option)?></a></td>
		<td><font class=ver81 color=0074BA><b><?=number_format(mysql_result($result,$i,int_aprice))?></b>원</font></td>
		<td><font class=ver81 color=616161><?=substr(mysql_result($result,$i,dtm_indate),0,10)?></td>
		<td align=center><a href="javascript:Delete_Click('<?=mysql_result($result,$i,int_number)?>')"><img src="/admincenter/img/i_del.gif"></a></td>
	</tr>
	<tr><td height=4 colspan=6></td></tr>
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

<script>table_design_load();</script>
</body>
</html>