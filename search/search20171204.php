<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],30);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);

	$Txt_rent = Fnc_Om_Conv_Default($_REQUEST[Txt_rent],"0");
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
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>
<script language="javascript" src="js/search.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   가방찾기</p>
					<!-- <div class="tit_h2 mt10">가방찾기</div> -->
					<div class=" mt40">
						<span class="tit_h3">가방 빨리 찾아보기</span>  
						<span>원하는 조건으로 찾아보세요.</span>
					</div>


					<form id="frm" name="frm" target="_self" method="POST" action="search.php">
					<input type="hidden" name="page" value="<?=$page?>">
					<input type="hidden" name="str_no">
					<input type="hidden" name="Txt_bcode" value="<?=$Txt_bcode?>">
					<input type="hidden" name="Txt_rent" value="<?=$Txt_rent?>">
					<input type="hidden" name="str_String" value="<?=$str_String?>">

					<div class="t_cover01 mt15">
					
						<table class="t_type01">
							<colgroup>
								<col style="width:20%;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">카테고리</th>
									<td class="left">
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
											<li><label><input type="checkbox" name="Txt_bcode[]" value="<?=mysql_result($arr_sData,$int_B,str_menutype).mysql_result($arr_sData,$int_B,str_chocode).mysql_result($arr_sData,$int_B,str_unicode)?>" <?=fnc_chkbox($Txt_bcode,mysql_result($arr_sData,$int_B,str_menutype).mysql_result($arr_sData,$int_B,str_chocode).mysql_result($arr_sData,$int_B,str_unicode))?> /> <?=mysql_result($arr_sData,$int_B,str_idxword)?></label></li>
											<?
												}
											?>
											<?}?>
										</ul>
									</td>
								</tr>
								<tr>
									<th class="left">브랜드</th>
									<td class="left">
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
											<li><label><input type="checkbox" name="Txt_brand[]" value="<?=mysql_result($arr_sData,$int_B,int_number)?>" <?=fnc_chkbox($Txt_brand,mysql_result($arr_sData,$int_B,int_number))?> /> <?=mysql_result($arr_sData,$int_B,str_code)?></label></li>
											<?
												}
											?>
											<?}?>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>
						<table class="t_type01 t_top_line">
							<colgroup>
								<col style="width:20%;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">키워드</th>
									<td style="text-align:left;padding-left:25px;"><input type="text" class="inp01 w580" name="Txt_word" value="<?=$Txt_word?>" style="width:628px;" /></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="center mt35">
						<a href="/search/search.php" class="btn btn_l btn_bk w w270 f_bd">검색 초기화</a>
						<a href="javascript:fnc_search();" class="btn btn_l btn_ylw w w270 f_bd">선택 조건으로 검색하기</a>
					</div>

					<p class="mt50">총 <?=$total_record?> 개의 가방이 있습니다.</p>
					<script type="text/javascript">
						(function( $ ){
							$.fn.hoverGrid = function( options ) {  
							var settings = $.extend( {
									'itemClass' : '.item'
								}, options);
							
								return this.each(function() {       
								var hoverGrid = $(this);
								hoverGrid.addClass('hover-grid');
								hoverGrid.find(settings.itemClass).addClass('hover-grid-item');
								
								$(hoverGrid).find(settings.itemClass).hover(function () {
									$(this).find('div.caption').stop(false, true).fadeIn(200);
								},
										function () {
												$(this).find('div.caption').stop(false, true).fadeOut(200);
										});
								});
							};
						})( jQuery );
					</script>
					<script type="text/javascript">
							$(document).ready(function() {
								$('#layout').hoverGrid();
							});
					</script>
					<div class="item_list02">
						<div id="layout">
						
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							
							<div class="item">
								<?$sRent=fnc_cart_info(mysql_result($result,$i,str_goodcode));?>
								<p class="rented"><?if ($sRent==0) {?><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a><?}?></p>
								<p class="zzim_icn"><a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><img src="../images/main/icn_zzim_on.png" alt="" /></a> <?=mysql_result($result,$i,likecnt)?></p>
								<p class="item_img" style="wdith:320px;height:320px;margin:0 auto;"><?if (mysql_result($result,$i,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" style="wdith:320px;height:320px;" border="0"><?}else{?>&nbsp;<?}?></p>
								<dl>
									<dt><a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><?=mysql_result($result,$i,str_code)?></a></dt>
									<dd><?=mysql_result($result,$i,str_egoodname)?></dd>
								</dl>
								<div class="caption" style="display: none;">
									<p class="item_img" style="wdith:320px;height:320px;margin:0 auto;"><a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><?if (mysql_result($result,$i,str_image2)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image2)?>" style="wdith:320px;height:320px;" border="0"><?}else{?>&nbsp;<?}?></a></p>
									<?If ($arr_Auth[0]=="") {?>
										<p class="on_btn mt10"><a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a></p>
									<?}else{?>
										<?if ($sBuy > 0) {//구매가 있을때?>
											<?if ($sRent!=0) {//품절이 아닐때?>
												<?if (mysql_result($result,$i,cartcnt)>0) {//내가 빌링상품일때?>
													
												<?}else{?>
													<p class="on_btn mt10"><a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">CHANGE</a></p>
												<?}?>
											<?}else{?>

											<?}?>
										<?}else{//구매가 없을때?>
											<?if ($sRent!=0) {//품절이 아닐때?>
												<p class="on_btn mt20"><a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a></p>		
											<?}?>
										<?}?>
									<?}?>
								</div>
							</div>
							
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
						</div>
					</div>

					<div class="paging02 mt30">
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
							<a href="Javascript:MovePage('1');" class="img_b"><img src="../images/board/btn_page_first.gif" alt="" /></a>
						<?}else{?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_first.gif" alt="" /></a>
						<?}

						if($block > 1) {
						   $my_page = $first_page;
						?>
							<a href="Javascript:MovePage('<?=$my_page?>');" class="img_b"><img src="../images/board/btn_page_prev.gif" alt="" /></a>
						<?}else{?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_prev.gif" alt="" /></a>
						<?}

						for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
						   if($page == $direct_page) {?>
						      	<a href="#;" class="on"><?=$direct_page?></a>
						   <?} else {?>
						    	<a href="Javascript:MovePage('<?=$direct_page?>');"><?=$direct_page?></a>
						   <?}
						}

						if($block < $total_block) {
						   	$my_page = $last_page+1;?>
						    <a href="Javascript:MovePage('<?=$my_page?>');" class="img_b"><img src="../images/board/btn_page_next.gif" alt="" /></a>
						<?}else{ ?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_next.gif" alt="" /></a>
						<?}

						if($page < $total_page) {?>
							<a href="Javascript:MovePage('<?=$total_page?>');" class="img_b"><img src="../images/board/btn_page_last.gif" alt="" /></a>
						<?}else{?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_last.gif" alt="" /></a>
						<?}
						?>
					</div>
					
					
					</form>

					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
