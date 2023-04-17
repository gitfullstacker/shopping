<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();

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


	$SQL_QUERY="select count(a.str_goodcode) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_master a inner join ".$Tname."comm_member_like b on a.str_goodcode=b.str_goodcode and b.str_userid='$arr_Auth[0]' where a.str_goodcode is not null and (a.str_service='Y' or a.str_service='R') ";
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

	$SQL_QUERY = "select a.*,e.str_code,(select b.str_bcode from ".$Tname."comm_goods_master_category b where a.str_goodcode=b.str_goodcode limit 1) as str_bcode,(select ifnull(count(b.str_userid),0) as cnt from ".$Tname."comm_member_like b where b.str_goodcode=a.str_goodcode) as likecnt,(select ifnull(count(d.str_userid),0) as cnt from ".$Tname."comm_goods_cart d where d.str_goodcode=a.str_goodcode and d.str_userid='".$arr_Auth[0]."' and d.int_state in ('4')) as cartcnt ";
	$SQL_QUERY.=" from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_master a inner join ".$Tname."comm_member_like b on a.str_goodcode=b.str_goodcode and b.str_userid='$arr_Auth[0]' left join ".$Tname."comm_com_code e on a.int_brand=e.int_number ";
	$SQL_QUERY.="where a.str_goodcode is not null and (a.str_service='Y' or a.str_service='R') ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.int_sort desc ";
	$SQL_QUERY.="limit $f_limit,$l_limit";

	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);
	
	$sBuy = fnc_buy_info();

	$str_String = "?Page=".$page."&displayrow=".urlencode($displayrow)."&Txt_bcode=".urlencode($Txt_bcode);
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>
<script language="javascript" src="js/like.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   좋아요 가방</p>
					<div class="lnb_tab mt10">
						<? require_once $_SERVER[DOCUMENT_ROOT]."/mypage/tab.php"; ?>
					</div>
					<!-- <div class="tit_h2_2 mt45">좋아요 가방</div>
					<p class="tit_desc mt45">고객님께서 좋아요를 누르신 가방입니다.</p> -->
					
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
					
					<form id="frm" name="frm" target="_self" method="POST" action="like.php">
					<input type="hidden" name="page" value="<?=$page?>">
					<input type="hidden" name="str_no">
					<input type="hidden" name="str_String" value="<?=$str_String?>">
					
					<div class="item_list02">
						<div id="layout">
						
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							
							<div class="item">
								<p class="rented"><?if (fnc_cart_info(mysql_result($result,$i,str_goodcode))==0) {?><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a><?}?></p>
								<p class="zzim_icn"><a href="/category/detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><img src="../images/main/icn_zzim_on.png" alt="" /></a> <?=mysql_result($result,$i,likecnt)?></p>
								<p class="item_img" style="wdith:320px;height:320px;"><?if (mysql_result($result,$i,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" style="wdith:320px;height:320px;" border="0"><?}else{?>&nbsp;<?}?></p>
								<dl>
									<dt><a href="/category/detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><?=mysql_result($result,$i,str_code)?></a></dt>
									<dd><?=mysql_result($result,$i,str_egoodname)?></dd>
								</dl>
								<div class="caption" style="display: none;">
									<p class="item_img" style="wdith:320px;height:320px;"><a href="/category/detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><?if (mysql_result($result,$i,str_image2)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image2)?>" style="wdith:320px;height:320px;" border="0"><?}else{?>&nbsp;<?}?></a></p>
									<p class="on_btn mt20">
										<?$sRent=fnc_cart_info(mysql_result($result,$i,str_goodcode));?>
										<?If ($arr_Auth[0]=="") {?>
											<a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a>
										<?}else{?>
											<?if ($sBuy > 0) {//구매가 있을때?>
												<?if ($sRent!=0) {//품절이 아닐때?>
													<?if (mysql_result($result,$i,cartcnt)>0) {//내가 빌링상품일때?>
														
													<?}else{?>
														<a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">CHANGE</a>
													<?}?>
												<?}else{?>
	
												<?}?>
											<?}else{//구매가 없을때?>
												<?if ($sRent!=0) {//품절이 아닐때?>
													<a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a>
												<?}?>
											<?}?>
										<?}?>
									
										<a href="javascript:Click_Del('<?=mysql_result($result,$i,str_goodcode)?>');" class="btn btn_del">DELETE</a>
									</p>
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
