<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?   
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<? 
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],5);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
	$str_userid = Fnc_Om_Conv_Default($_REQUEST[str_userid],"");

	
	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member_point a where a.str_userid='$str_userid' ";
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
	$SQL_QUERY.="comm_member_point a ";
	$SQL_QUERY.="where a.str_userid='"&str_userid&"' ";
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
<script language="javascript" src="js/memb_point_list.js"></script>
</head>
<body class=scroll>

<div style="margin-top:10px;">
<div style="margin-bottom:10px;">

<div class="title title_top">현재 적립금현황<span>현재의 적립금현황을 확인합니다</span></div>
<table cellpadding=0 cellspacing=1 border=0 bgcolor=EBEBEB>
	<tr>
		<td bgcolor=E8E8E8>
			<table cellpadding=3 cellspacing=0 border=0 bgcolor=E8E8E8>
				<tr>
					<td bgcolor=F6F6F6 width=160 align=center>현재 <b><?=$str_userid?></b>님의 적립금은</td>
					<td bgcolor=white width=400>&nbsp;&nbsp;<b><?=number_format(Fnc_Om_Point($str_userid))?></b>원 입니다</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div style="padding-top:20"></div>
<div class="title title_top">적립금지급/차감<span>적립금을 지급/차감합니다</span></div>

<form id="frm" name="frm" target="_self" method="POST" action="memb_point_list.php">
<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
<input type="hidden" name="str_userid" value="<?=$str_userid?>">
<input type="hidden" name="Page" value="<?=$page?>">
<input type="hidden" name="str_no">

<table cellpadding=0 cellspacing=0 border=0 bgcolor=EBEBEB>
	<tr>
		<td bgcolor=E8E8E8>
			<table cellpadding=2 cellspacing=1 border=0 bgcolor=E8E8E8>
				<tr>
					<td bgcolor=F6F6F6 width=160 align=center>지급액/차감액</td>
					<td bgcolor=white width=400><input type=text name=int_point size=8 style="ime-mode:inactive" style="text-align:right;" required label="적립금"> Point <font class=small color=444444>(차감시 마이너스포인트으로 입력. 예) -200 )</font></td>
				</tr>
				<tr>
					<td bgcolor=F6F6F6 align=center>이유</td>
					<td bgcolor=white>
						<input type=text name=str_contents size=30>
					</td>
				</tr>
				<tr>
					<td bgcolor=F6F6F6 align=center>사용유무</td>
					<td bgcolor=white>
						<select name=str_service>
							<option value="Y">사용
							<option value="N">사용안함
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<div style="margin-bottom:10px;padding-top:10;" class=noline align=center>
<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_confirm_s.gif"></a>
</div>


<div class="title title_top">적립금내역<span>적립금 상세내역을 확인합니다</span></div>

<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td class=rnd colspan=6></td>
	</tr>
	<tr class=rndbg>
		<th>번호</th>
		<th>날짜</th>
		<th>적립금액</th>
		<th>지급/차감이유</th>
		<th>사용유무</th>
		<th>삭제</th>
	</tr>
	<tr><td class=rnd colspan=6></td></tr>
	<col width=50 align=center>
	<col width=80 align=center>
	<col width=80 align=center>
	<col align=left>
	<col width=80 align=center>
	<col width=40 align=center>
	<tr><td height=4 colspan=6></td></tr>
	<?$count=0;?>
	<?if($total_record_limit!=0){?>
	<?$article_num = $total_record - $displayrow*($page-1) ;?>
	<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
	<tr height=25 align="center">
		<td><font class=ver81 color=616161><?= $article_num?></td>
		<td><font class=ver81 color=616161><?=substr(mysql_result($result,$i,dtm_indate),0,10)?></td>
		<td><font class=ver81 color=0074BA><b><?=number_format(mysql_result($result,$i,int_point))?></b></font>원</td>
		<td><font class=ver81 color=333333><?=mysql_result($result,$i,str_contents)?></td>
		<td><font class=ver81 color=333333><?If (mysql_result($result,$i,str_service)=="Y"){?>사용<?}else{?>사용안함<?}?></td>
		<td align=center><a href="javascript:Delete_Click('<?=mysql_result($result,$i,int_number)?>')"><img src="/admincenter/img/i_del.gif"></a></td>
	</tr>
	<tr><td height=4 colspan=6></td></tr>
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

</form>

<script>table_design_load();</script>
</body>
</html>