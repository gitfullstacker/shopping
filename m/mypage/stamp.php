<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();
	
	$str_userid = Fnc_Om_Conv_Default($_REQUEST[str_userid],"");

	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],5);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],5);
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"1");

	$Txt_code = Fnc_Om_Conv_Default($_REQUEST[Txt_code],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");

	If ($Txt_code!="") { $Str_Query .= " and a.str_code like '%$Txt_code%' ";}

	if ($Txt_sindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";}
	if ($Txt_eindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";}

	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member_stamp a where a.int_number is not null and a.str_userid='$arr_Auth[0]' ";
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
	$SQL_QUERY.="comm_member_stamp a ";
	$SQL_QUERY.="where a.int_number is not null and a.str_userid='$arr_Auth[0]' ";
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
<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/header.php"; ?>
<script language="javascript" src="js/stamp.js"></script>
		
		<div class="con_width">
			


			
			<form id="frm" name="frm" target="_self" method="POST" action="stamp.php">
			<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
			<input type="hidden" name="page" value="<?=$page?>">

			<div class="mt15">
				<?
				$SQL_QUERY =	" SELECT
								*
							FROM "
								.$Tname."comm_banner AS A
							WHERE
								A.INT_GUBUN='8' AND A.STR_SERVICE='Y' ";
			
				$arr_Rlt_Data=mysql_query($SQL_QUERY);
				if (!$arr_Rlt_Data) {
			  		echo 'Could not run query: ' . mysql_error();
			  		exit;
				}
				$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
				?>
				<?if ($arr_Data['STR_URL1']!="") {?>
					<a href="<?=$arr_Data['STR_URL1']?>" <?if ($arr_Data['STR_TARGET1']=="2") {?> target="_blank"<?}?>>
				<?}?>
				<?if (!($arr_Data['STR_IMAGE1']=="")) {?><img src="/admincenter/files/bann/<?=$arr_Data['STR_IMAGE1']?>" style="width:100%;" border="0"><?}else{?>&nbsp;<?}?>
				<?if ($arr_Data['STR_URL1']!="") {?>
					</a>
				<?}?>
			</div>
			<dl class="stamp_bx01 mt15" style="display:none;">
				<dt>스탬프 받을 수 있는 방법</dt>
				<?
				$SQL_QUERY =	" SELECT
								*
							FROM "
								.$Tname."comm_site_info
							WHERE
								INT_NUMBER=1 ";
					
				$arr_Rlt_Data=mysql_query($SQL_QUERY);
				if (!$arr_Rlt_Data) {
					    		echo 'Could not run query: ' . mysql_error();
					    		exit;
				}
				$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
				?>
				<dd>
					<p>멤버십가입 : <?=number_format($arr_Data['INT_STAMP1'])?>개 </p>
					<p>추천인 ID (회원가입시) : 각자 <?=number_format($arr_Data['INT_STAMP2'])?>개</p>
					<p>후기작성: <?=number_format($arr_Data['INT_STAMP3'])?>개, 블로그 후기 작성 : 2개//</p>
					<p>정기결제 고객 : 결제일마다 <?=number_format($arr_Data['INT_STAMP4'])?>개</p>
				</dd>
			</dl>
			<div class="stamp_bx02 mt10"><span class="f_ylw f_bd"><?=$arr_Auth[2]?> (<?=$arr_Auth[0]?>)</span> 회원님이 보유한 <br />스탬프는 총 <span class="f_ylw f_bd"><?=number_format(Fnc_Om_Stamp($arr_Auth[0]))?>개</span> 입니다. </div>
			<div class="stamp_bx03 mt10">
				<ul>
					<?for ($int_I=1;$int_I<=Fnc_Om_Stamp($arr_Auth[0]);$int_I++) {?>
					<li><img src="../../images/sub/icn_stamp.gif" alt="" /></li>
					<?}?>
				</ul>
			</div>
			
			<?
			$SQL_QUERY = "select a.* from ".$Tname."comm_stamp_prod a where a.str_service='Y' order by a.int_prod asc ";

			$arr_sData=mysql_query($SQL_QUERY);
			$arr_sData_Cnt=mysql_num_rows($arr_sData);
			?>
			<?if ($arr_sData_Cnt){?>
			<p class="f_bd f_bk mt25">&nbsp;&nbsp;스탬프 10개로 아래 상품을 구매할 수 있습니다</p>
			<div class="stamp_bx04 mt07">
				<ul>
					<?
						for($int_B = 0 ;$int_B < $arr_sData_Cnt; $int_B++) {
					?>
					<li>
						<p class="stmp_tit"><?=mysql_result($arr_sData,$int_B,str_prod)?></p>
						<p class="stmp_img"><?if (mysql_result($arr_sData,$int_B,str_image1)!=""){?><img src="/admincenter/files/stamp/<?=mysql_result($arr_sData,$int_B,str_image1)?>" alt="" /><?}else{?>&nbsp;<?}?></p>
						<p><a href="javascript:Click_Buy('<?=mysql_result($arr_sData,$int_B,int_prod)?>','<?=mysql_result($arr_sData,$int_B,int_ustamp)?>');" class="btn btn_m btn_wt f_bd w50p">구매</a></p>
					</li>
					<?
						}
					?>
				</ul>
			</div>
			<?}?>
			
			
			<p class="f_bd f_bk mt25">&nbsp;&nbsp;스탬프 이용 및 적립 내역 </p>
			<div class="t_cover01 mt07">
				<table class="t_type01">
					<colgroup>
						<col style="width:30%;" />
						<col />
					</colgroup>
					<thead>
						<tr>
							<th class="f_bd line_r">날짜</th>
							<th class="f_bd">지급/사용개수 및 내역</th>
						</tr>
					</thead>
					<tbody>
						<?$count=0;?>
						<?if($total_record_limit!=0){?>
						<?$article_num = $total_record - $displayrow*($page-1) ;?>
						<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
						<tr>
							<td class="line_r"><?=substr(mysql_result($result,$i,dtm_indate),0,10)?></td>
							<td class="center f_bk">
								<?=number_format(mysql_result($result,$i,int_stamp))?>개
								/
								<?switch (mysql_result($result,$i,str_gubun)) {
									case  "1" : echo "멤버쉽가입"; break;
									case  "2" : echo "추천인ID"; break;
									case  "3" : echo "이미지후기"; break;
									case  "4" : echo "정기결제고객"; break;
									case  "5" : echo "기타"; break;
								}
								?>
								<?if (mysql_result($result,$i,str_cont)!="") {?>
									(<?=mysql_result($result,$i,str_cont)?>)
								<?}?>
							</td>
						</tr>
						<?$count++;?>
						<?
						$article_num--;
						if($article_num==0){
							break;
						}
						?>
						<?}?>
						<?}else{?>
						<tr>
							<td colspan="2">내역이 없습니다.</td>
						</tr>								
						<?}?>
					</tbody>
				</table>
			</div>
			<div class="paging mt15" style="margin-bottom: 15px;">
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
					<a href="Javascript:MovePage('1');" class="pg_nav pg_fir"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_fir"></a>
				<?}

				if($block > 1) {
				   $my_page = $first_page;
				?>
					<a href="Javascript:MovePage('<?=$my_page?>');" class="pg_nav pg_prev"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_prev"></a>
				<?}
				
				?>
				<span class="num">
				<?

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				   if($page == $direct_page) {?>
				      	<a href="#;" class="on"><?=$direct_page?></a>
				   <?} else {?>
				    	<a href="Javascript:MovePage('<?=$direct_page?>');"><?=$direct_page?></a>
				   <?}
				}

				?>
				</span>
				<?

				if($block < $total_block) {
				   	$my_page = $last_page+1;?>
				    <a href="Javascript:MovePage('<?=$my_page?>');" class="pg_nav pg_next"></a>
				<?}else{ ?>
					<a href="#;" class="pg_nav pg_next"></a>
				<?}

				if($page < $total_page) {?>
					<a href="Javascript:MovePage('<?=$total_page?>');" class="pg_nav pg_last"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_last"></a>
				<?}
				?>
			</div>
			
			</form>
			

		</div>

<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/footer.php"; ?>


<link rel="styleSheet" href="/css/sumoselect.css">
<script type="text/javascript" src="/js/custominputfile.min.js"></script>
<script type="text/javascript">
	$('#demo-1').custominputfile({
		theme: 'blue-grey',
		//icon : 'fa fa-upload'
	});
	$('#demo-2').custominputfile({
		theme: 'red',
		icon : 'fa fa-file'
	});
</script>