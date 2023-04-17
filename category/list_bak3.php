<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],9);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);

	$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key],"all");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
	$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service],"");

	$Txt_bname = Fnc_Om_Conv_Default($_REQUEST[Txt_bname],"");
	$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");

	If ($Txt_word!="") {
		switch ($Txt_key) {
			case  "all" :
				$Str_Query = " AND (A.STR_GOODNAME LIKE '%$Txt_word%') ";
				break;
			case  "str_goodname" :
				$Str_Query = " AND A.STR_GOODNAME LIKE '%$Txt_word%' ";
				break;
		}
	}

	If ($Txt_service!="") { $Str_Query .= " and a.str_service = '$Txt_service' ";}
	//If ($Txt_bcode!="") { $Str_Query .= " AND A.STR_BCODE = '$Txt_bcode' ";}

	if ($Txt_bcode!="") { $Str_Query .= " AND A.STR_GOODCODE IN (SELECT D.STR_GOODCODE FROM ".$Tname."comm_goods_master_category D WHERE D.STR_BCODE IN (SELECT CONCAT(C.STR_MENUTYPE,C.STR_CHOCODE,C.STR_BTMUNI) FROM ".$Tname."comm_menu_btm C WHERE C.STR_MENUTYPE='".substr($Txt_bcode,0,2)."' AND C.STR_CHOCODE='".substr($Txt_bcode,2,2)."' AND C.STR_UNICODE='".substr($Txt_bcode,4,5)."')) ";}


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

	$str_String = "?page=".$page."&displayrow=".urlencode($displayrow)."&Txt_bcode=".urlencode($Txt_bcode);
	
	$sBuy = fnc_pay_info();
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>
<script language="javascript" src="js/list.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >  <?=Fnc_Om_Conv_Default(Fnc_Om_Cate_Name($Txt_bcode),"ALL")?></p>
				</div>
				<?
				$SQL_QUERY =	" select * from ".$Tname."comm_banner as a where a.str_bcode='".$str_bcode."' and a.int_gubun='2' ";

				$arr_Bann_Data=mysql_query($SQL_QUERY);
				$arr_Bann_Data_Cnt=mysql_num_rows($arr_Bann_Data);
				?>
				<?
					for($int_J = 0 ;$int_J < $arr_Bann_Data_Cnt; $int_J++) {
				?>
				<?if (mysql_result($arr_Bann_Data,$int_J,str_image1)!="") {?>
				<style type="text/css">
					.s_v01{background:url('/admincenter/files/bann/<?=mysql_result($arr_Bann_Data,$int_J,str_image1)?>') no-repeat 50% 0;}
				</style>
				<div class="sub_visual s_v01 mt20"  <?if (mysql_result($arr_Bann_Data,$int_J,str_url1)!="") {?> onclick="fnc_open('<?=mysql_result($arr_Bann_Data,$int_J,str_url1)?>','<?=mysql_result($arr_Bann_Data,$int_J,str_target1)?>')" <?}?>></div>
				<?}?>
				<?
					}
				?>
				
				
				<div class="contents_w">
					<p class="mt30">총 <?=$total_record?> 개의 가방이 있습니다.</p>
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
					
					
					<form id="frm" name="frm" target="_self" method="POST" action="list.php">
					<input type="hidden" name="page" value="<?=$page?>">
					<input type="hidden" name="str_no">
					<input type="hidden" name="Txt_bcode" value="<?=$Txt_bcode?>">
					<input type="hidden" name="str_String" value="<?=$str_String?>">
					
					<div class="item_list02">
						<div id="layout">
						
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							
							<div class="item">
								<?$sRent=fnc_cart_info(mysql_result($result,$i,str_goodcode));?>
								<p class="rented"><?if ($sRent==0) {?><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a><?}?></p>
								<p class="zzim_icn"><a href="detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><img src="../images/main/icn_zzim_on.png" alt="" /></a> <?=mysql_result($result,$i,likecnt)?></p>
								<p class="item_img" style="wdith:320px;height:320px;margin:0 auto;"><?if (mysql_result($result,$i,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" style="wdith:320px;height:320px;" border="0"><?}else{?>&nbsp;<?}?></p>
								<dl>
									<dt><a href="detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><?=mysql_result($result,$i,str_code)?>//<?=mysql_result($result,$i,rent)?></a></dt>
									<dd><?=mysql_result($result,$i,str_egoodname)?></dd>
								</dl>
								<div class="caption" style="display: none;">
									<p class="item_img" style="wdith:320px;height:320px;margin:0 auto;"><a href="detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><?if (mysql_result($result,$i,str_image2)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image2)?>" style="wdith:320px;height:320px;" border="0"><?}else{?>&nbsp;<?}?></a></p>
									<?If ($arr_Auth[0]=="") {?>
										<p class="on_btn mt10"><a href="detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a></p>
									<?}else{?>
										<?if ($sBuy > 0) {//구매가 있을때?>
											<?if ($sRent!=0) {//품절이 아닐때?>
												<?if (mysql_result($result,$i,cartcnt)>0) {//내가 빌링상품일때?>
													
												<?}else{?>
													<p class="on_btn mt10"><a href="detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">CHANGE</a></p>
												<?}?>
											<?}else{?>

											<?}?>
										<?}else{//구매가 없을때?>
											<?if ($sRent!=0) {//품절이 아닐때?>
												<p class="on_btn mt20"><a href="detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a></p>		
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

<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"; ?>
