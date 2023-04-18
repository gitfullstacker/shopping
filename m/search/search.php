<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],16);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],5);

	$Txt_rent = Fnc_Om_Conv_Default($_REQUEST[Txt_rent],"1");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");

	$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode],"");
	$Txt_brand = Fnc_Om_Conv_Default($_REQUEST[Txt_brand],"");
	
	$sTemp1 = "";
	if (is_array($Txt_bcode)) {
	
		for ($int_A = 0; $int_A < count($Txt_bcode); $int_A++) {
			$sTemp1.= "'".$Txt_bcode[$int_A]."'";
			if ($int_A != (count($Txt_bcode)-1)) {
				$sTemp1.= ",";
			}
		}
	
	}
	
	$sTemp2 = "";
	if (is_array($Txt_brand)) {
	
		for ($int_A = 0; $int_A < count($Txt_brand); $int_A++) {
			$sTemp2.= "'".$Txt_brand[$int_A]."'";
			if ($int_A != (count($Txt_brand)-1)) {
				$sTemp2.= ",";
			}
		}
	
	}

	//If ($Txt_rent!="0") { $Str_Query .= " AND A.RENT != '0' ";}
	If ($Txt_rent!="0") { $Str_Query .= " AND A.STR_GOODCODE IN (SELECT F.STR_GOODCODE FROM ".$Tname."comm_goods_master_sub F WHERE F.STR_GOODCODE=A.STR_GOODCODE AND F.STR_SERVICE='Y' AND F.STR_SGOODCODE NOT IN (SELECT G.STR_SGOODCODE FROM ".$Tname."comm_goods_cart G WHERE G.STR_GOODCODE=A.STR_GOODCODE AND NOT(G.INT_STATE='0' OR G.INT_STATE='10' OR G.INT_STATE='11'))) ";}
	
	If ($Txt_word!="") {$Str_Query = " AND (A.STR_GOODNAME LIKE '%$Txt_word%' OR A.STR_EGOODNAME LIKE '%$Txt_word%' OR A.INT_BRAND IN (select E.INT_NUMBER FROM ".$Tname."comm_com_code E WHERE (E.STR_KCODE LIKE '%$Txt_word%' OR E.STR_CODE LIKE '%$Txt_word%') AND E.INT_GUBUN='2' AND E.STR_SERVICE='Y')) ";}


	if ($sTemp1!="") { $Str_Query .= " AND A.STR_GOODCODE IN (SELECT D.STR_GOODCODE FROM ".$Tname."comm_goods_master_category D WHERE D.STR_BCODE IN (SELECT CONCAT(C.STR_MENUTYPE,C.STR_CHOCODE,C.STR_BTMUNI) FROM ".$Tname."comm_menu_btm C WHERE CONCAT(C.STR_MENUTYPE,C.STR_CHOCODE,C.STR_BTMUNI) IN (".$sTemp1."))) ";}
	if ($sTemp2!="") { $Str_Query .= " AND A.INT_BRAND IN (".$sTemp2.") ";}


	$SQL_QUERY="SELECT COUNT(A.STR_GOODCODE) FROM ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_master A WHERE A.STR_GOODCODE IS NOT NULL AND (A.STR_SERVICE='Y' OR A.STR_SERVICE='R') ";
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

	$SQL_QUERY = "SELECT 
								A.*,
								(SELECT B.STR_BCODE FROM ".$Tname."comm_goods_master_category B WHERE A.STR_GOODCODE=B.STR_GOODCODE LIMIT 1) AS STR_BCODE,
								(SELECT IFNULL(COUNT(C.STR_USERID),0) AS CNT FROM ".$Tname."comm_member_like C WHERE C.STR_GOODCODE=A.STR_GOODCODE) AS LIKECNT,
								(SELECT IFNULL(COUNT(D.STR_USERID),0) AS CNT FROM ".$Tname."comm_goods_cart D WHERE D.STR_GOODCODE=A.STR_GOODCODE AND D.STR_USERID='".$arr_Auth[0]."' AND D.INT_STATE IN ('4')) AS CARTCNT,
								E.STR_CODE,
								(SELECT IFNULL(COUNT(F.STR_SGOODCODE),0) AS CNT FROM ".$Tname."comm_goods_master_sub F WHERE F.STR_GOODCODE=A.STR_GOODCODE AND F.STR_SERVICE='Y' AND F.STR_SGOODCODE NOT IN (SELECT G.STR_SGOODCODE FROM ".$Tname."comm_goods_cart G WHERE G.STR_GOODCODE=A.STR_GOODCODE AND NOT(G.INT_STATE='0' OR G.INT_STATE='10' OR G.INT_STATE='11'))) AS RENT
							FROM 
								".$Tname."comm_goods_master A
								LEFT JOIN
								".$Tname."comm_com_code E
								ON
								A.INT_BRAND=E.INT_NUMBER
							WHERE 
								A.STR_GOODCODE IS NOT NULL 
								AND 
								(A.STR_SERVICE='Y' OR A.STR_SERVICE='R') ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="ORDER BY A.INT_SORT DESC ";
	$SQL_QUERY.="limit $f_limit,$l_limit";

	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);
	
	$sBuy = fnc_buy_info();
	 
	
	function fnc_chkbox($Txt_bcode,$str_bcode) {
	
		if (is_array($Txt_bcode)) {
		
			for ($int_A = 0; $int_A < count($Txt_bcode); $int_A++) {
				If ($Txt_bcode[$int_A]==$str_bcode) {
					echo " checked";
				}
			}
		
		}
	
	}
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/search.js"></script>
		
		<div class="con_width">
			<div class="tit_h2 ">
				<em>가방 빨리 찾아보기</em>
				<span class="tit_h2_desc"><!--원하는 조건으로 찾아보세요.//-->&nbsp;</span>
			</div>
			
			<form id="frm" name="frm" target="_self" method="POST" action="search.php">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="str_no">
			<input type="hidden" name="Txt_bcode" value="<?=$Txt_bcode?>">
			<input type="hidden" name="Txt_rent" value="<?=$Txt_rent?>">
			<input type="hidden" name="str_String" value="<?=$str_String?>">
			<input type="hidden" name="total_page" value="<?=$total_page?>">
			
			<div class="t_cover01 mt10">
				<table class="t_type">
					<colgroup>
						<col style="width:20%;" />
						<col />
					</colgroup>
					<tbody>
						<tr>
							<th>카테고리</th>
							<td>
								<ul class="sc_list">
									<?
									$SQL_QUERY = "select a.* from ".$Tname."comm_menu_idx a where a.str_menutype='03' and a.str_unicode='10001' and a.str_service='Y' order by a.full_sort asc ";
						
									$arr_sData=mysql_query($SQL_QUERY);
									$arr_sData_Cnt=mysql_num_rows($arr_sData);
									?>
									<!--<li><label><input type="checkbox" /> ALL</label></li>//-->
									<?if ($arr_sData_Cnt){?>
									<?
										for($int_B = 0 ;$int_B < $arr_sData_Cnt; $int_B++) {
									?>
									<li><label><input type="checkbox" name="Txt_bcode[]"  class="cform" value="<?=mysql_result($arr_sData,$int_B,str_menutype).mysql_result($arr_sData,$int_B,str_chocode).mysql_result($arr_sData,$int_B,str_unicode)?>" <?=fnc_chkbox($Txt_bcode,mysql_result($arr_sData,$int_B,str_menutype).mysql_result($arr_sData,$int_B,str_chocode).mysql_result($arr_sData,$int_B,str_unicode))?> /> <?=mysql_result($arr_sData,$int_B,str_idxword)?></label></li>
									<?
										}
									?>
									<?}?>
								</ul>
							</td>
						</tr>
						<tr>
							<th>브랜드</th>
							<td>
								<ul class="sc_list">
									<?
									$SQL_QUERY = "select a.* from ".$Tname."comm_com_code a where a.int_gubun='2' and a.str_service='Y' order by a.int_number asc ";
						
									$arr_sData=mysql_query($SQL_QUERY);
									$arr_sData_Cnt=mysql_num_rows($arr_sData);
									?>
									<?if ($arr_sData_Cnt){?>
									<?
										for($int_B = 0 ;$int_B < $arr_sData_Cnt; $int_B++) {
									?>
									<li><label><input type="checkbox" name="Txt_brand[]" class="cform" value="<?=mysql_result($arr_sData,$int_B,int_number)?>" <?=fnc_chkbox($Txt_brand,mysql_result($arr_sData,$int_B,int_number))?> /> <?=mysql_result($arr_sData,$int_B,str_code)?></label></li>
									<?
										}
									?>
									<?}?>
								</ul>
							</td>
						</tr>
						<tr>
							<th>키워드</th>
							<td>
								<input type="text" name="Txt_word" value="<?=$Txt_word?>" class="inp w100p" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class=" btn_w mt15">
				<p class="f_left"><a href="/m/search/search.php" class="btn btn_l btn_bk w100p f_bd">검색 초기화</a></p>
				<p class="f_right"><a href="javascript:fnc_search();" class="btn btn_l btn_ylw w100p f_bd">선택 조건으로 검색하기</a></p>
			</div>
			<p class="list_option mt15">
				<a href="javascript:fnc_gbn('0');"<?If ($Txt_rent=="0") {?> class="on"<?}?>><i class="icn icn_all"></i>전체 가방</a>
				<a href="javascript:fnc_gbn('1');"<?If ($Txt_rent=="1") {?> class="on"<?}?>><i class="icn icn_possible"></i>GET 가능한 가방</a>
			</p>
			<ul class="new_list mt25" id="labData">
				<?$count=0;?>
				<?if($total_record_limit!=0){?>
				<?$article_num = $total_record - $displayrow*($page-1) ;?>
				<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
				<?$sRent=fnc_cart_info(mysql_result($result,$i,str_goodcode));?>
				<li>
					<?if ($sRent==0) {?><span class="rented">RENTED</span><?}?>
					<p class="zzim_icn"><img src="../images/icn_zzim_on.png" alt="" /> <?=mysql_result($result,$i,likecnt)?></p>
					<a href="/m/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>">
						<p><?if (mysql_result($result,$i,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" border="0"><?}else{?>&nbsp;<?}?></p>
						<dl>
							<dt><?=mysql_result($result,$i,str_code)?></dt>
							<dd><?=mysql_result($result,$i,str_egoodname)?></dd>
						</dl>
						<!--<p class="mt10">
							<?If ($arr_Auth[0]=="") {?>
								<a href="/m/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a>
							<?}else{?>
								<?if ($sBuy > 0) {//구매가 있을때?>
									<?if ($sRent!=0) {//품절이 아닐때?>
										<?if (mysql_result($result,$i,cartcnt)>0) {//내가 빌링상품일때?>
											<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
										<?}else{?>
											<a href="/m/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">CHANGE</a>
										<?}?>
									<?}else{?>
										<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
									<?}?>
								<?}else{//구매가 없을때?>
									<?if ($sRent!=0) {//품절이 아닐때?>
										<a href="/m/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a>
									<?}else{?>
										<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
									<?}?>
								<?}?>
							<?}?>
						</p>//-->
					</a>
				</li>
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
			</ul>
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
			<!--
			<p><a href="javascript:fnc_more();" class="btn btn_readmore">READ MORE <i class="icn"></i></a></p>
			//-->
		</div>
		
		
		</form>

<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/footer.php"; ?>


