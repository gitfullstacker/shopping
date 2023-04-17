<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],9);
	$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode],"");

	$SQL_QUERY =	" SELECT
					A.*,
					B.STR_KCODE AS STR_BRAND,
					B.STR_CODE AS STR_EBRAND,
					(SELECT C.STR_BCODE FROM ".$Tname."comm_goods_master_category C WHERE A.STR_GOODCODE=C.STR_GOODCODE LIMIT 1) AS STR_BCODE,
					(SELECT IFNULL(COUNT(C.STR_USERID),0) AS CNT FROM ".$Tname."comm_member_like C WHERE C.STR_GOODCODE=A.STR_GOODCODE) AS LIKECNT,
					(SELECT IFNULL(COUNT(D.STR_USERID),0) AS CNT FROM ".$Tname."comm_goods_cart D WHERE D.STR_GOODCODE=A.STR_GOODCODE AND D.STR_USERID='".$arr_Auth[0]."' AND D.INT_STATE IN ('4')) AS CARTCNT
				FROM "
					.$Tname."comm_goods_master AS A
					LEFT JOIN
					".$Tname."comm_com_code AS B
					ON
					A.INT_BRAND=B.INT_NUMBER
				WHERE
					A.STR_GOODCODE='$str_no' AND (A.STR_SERVICE='Y' OR A.STR_SERVICE='R')";

	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	
	Fun_Goods_Cnt($str_no);

	$str_String = "?Page=".$page."&displayrow=".urlencode($displayrow)."&Txt_bcode=".urlencode($Txt_bcode);
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>
<script language="javascript" src="js/detail.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >  <?=Fnc_Om_Conv_Default(Fnc_Om_Cate_Name($Txt_bcode),"ALL")?></p>
					
					
					<form id="frm" name="frm" target="_self" method="POST">
					<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
					<input type="hidden" name="loc" value="<?=urlencode($_SERVER["SCRIPT_NAME"] . "?" . $_SERVER["QUERY_STRING"])?>">
					
					<div class="detail_img mt10">
						<script type="text/javascript" src="../js/jquery.bxslider.js"></script>
						<link type="text/css" rel="stylesheet" href="../css/jquery.bxslider.css" />
						<ul class="bxslider">
							<?for ($int_I=3;$int_I<=9;$int_I++){?>
							<?if (!($arr_Data["STR_IMAGE".$int_I]=="")) {?><li><img src="/admincenter/files/good/<?=$arr_Data["STR_IMAGE".$int_I]?>" style="width:700px;height:700px;" border="0"></li><?}?>
							<?}?>
						</ul>
						
						<div id="bx-pager">
							<?for ($int_I=3;$int_I<=9;$int_I++){?>
							<?if (!($arr_Data["STR_IMAGE".$int_I]=="")) {?><a data-slide-index="<?=$int_I-3?>" href=""><img src="/admincenter/files/good/<?=$arr_Data["STR_IMAGE".$int_I]?>" style="width:92px;height:92px;"  border="0"></a><?}?>
							<?}?>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$('.bxslider').bxSlider({
									pagerCustom: '#bx-pager'
								});
							});
						</script>
					</div>
					<dl class="detail_name">
						<dt><span class="tit_brand"><?=$arr_Data['STR_EBRAND']?></span><?=$arr_Data['STR_EGOODNAME']?></dt>
						<dd>RETAIL ₩<?=number_format($arr_Data['INT_PRICE'])?></dd>
					</dl>
					<div class="detail_btn">
						<p class="btn btn_like"><a href="javascript:Click_like('<?=$arr_Data["STR_GOODCODE"]?>');">좋아요<br /><span id="span_like"><img src="/images/sub/btn_icn_like.png" alt="" /> <?=$arr_Data["LIKECNT"]?></span></a></p>
						<?$sBuy=fnc_buy_info();?>
						<?$sRent=fnc_cart_info($arr_Data["STR_GOODCODE"]);?>

						<?if ($sRent == 0) {//품절일때?>
						<p class="btn btn_arlim"><a href="javascript:Alarm_Click('<?=$arr_Data["STR_GOODCODE"]?>');">입고알림받기</a></p>
						<?}?>
						

						<?If ($arr_Auth[0]=="") {?>
							<p class="btn btn_get01"><a href="javascript:Cart_Click('<?=$arr_Data["STR_GOODCODE"]?>');"><em>GET</em><br /><span>지금 바로 마음에 드는 가방을 GET하세요!</span></a></p>
						<?}else{?>
							<?if ($sBuy > 0) {//구매가 있을때?>
								<?if ($sRent!=0) {//품절이 아닐때?>
									<?if ($arr_Data["CARTCNT"]>0) {//내가 빌링상품일때?>
										
									<?}else{?>
										<p class="btn btn_get01"><a href="javascript:Cart_Click('<?=$arr_Data["STR_GOODCODE"]?>');"><em>CHANGE</em><br /><span>새로운 가방으로 교환해보세요!</span></a></p>
									<?}?>
								<?}else{?>

								<?}?>
							<?}else{//구매가 없을때?>
								<?if ($sRent!=0) {//품절이 아닐때?>
									<p class="btn btn_get01"><a href="javascript:Cart_Click('<?=$arr_Data["STR_GOODCODE"]?>');"><em>GET</em><br /><span>지금 바로 마음에 드는 가방을 GET하세요!</span></a></p>
								<?}?>
							<?}?>
						<?}?>
					</div>
					<div class="detail_tab">
						<ul>
							<li class="on">DETAILS</li>
							<!--<li>REVIEW</li>//-->
						</ul>
					</div>
					<dl class="detail_view">
						<dt><?=$arr_Data['STR_GOODNAME']?></dt>
						<dd><span class="dv_tit">브랜드 </span><?=$arr_Data['STR_BRAND']?></dd>
						<dd><span class="dv_tit">소재 </span><?=$arr_Data['STR_MATERIAL']?></dd>
						<dd><span class="dv_tit">제품명 </span><?=$arr_Data['STR_GOODNAME']?></dd>
						<dd><span class="dv_tit">크기 </span><?=$arr_Data['STR_SIZE']?></dd>
						<dd><span class="dv_tit">정가 </span><?=number_format($arr_Data['INT_PRICE'])?>원</dd>
						<dd><span class="dv_tit">스트랩길이 </span><?=$arr_Data['STR_LENGTH']?></dd>
						<dd><span class="dv_tit">원산지 </span><?=$arr_Data['STR_ORIGIN']?></dd>
						<dd>
							<span class="dv_tit">사용감 </span>
							<?if ($arr_Data['INT_USED']=="0") {?><img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /><?}?>
							<?if ($arr_Data['INT_USED']=="1") {?><img src="../images/sub/icn_grade05.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /><?}?>
							<?if ($arr_Data['INT_USED']=="2") {?><img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /><?}?>
							<?if ($arr_Data['INT_USED']=="3") {?><img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade05.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /><?}?>
							<?if ($arr_Data['INT_USED']=="4") {?><img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /><?}?>
							<?if ($arr_Data['INT_USED']=="5") {?><img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade05.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /><?}?>
							<?if ($arr_Data['INT_USED']=="6") {?><img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /><?}?>
							<?if ($arr_Data['INT_USED']=="7") {?><img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade05.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /><?}?>
							<?if ($arr_Data['INT_USED']=="8") {?><img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade00.png" alt="" /><?}?>
							<?if ($arr_Data['INT_USED']=="9") {?><img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade05.png" alt="" /><?}?>
							<?if ($arr_Data['INT_USED']=="10") {?><img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /> <img src="../images/sub/icn_grade10.png" alt="" /><?}?>
						</dd>
						<dd><span class="dv_tit">색상</span><?=$arr_Data['STR_COLOR']?></dd>
					</dl>
					

					<div class="tit_h4 mt40">관련 가방</div>
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

					<?
						if ($arr_Data['STR_RE_F']=="Y") { //자동으로 검색
						
							$SQL_QUERY = "select a.*,e.str_code,(select c.str_bcode from ".$Tname."comm_goods_master_category c where a.str_goodcode=c.str_goodcode limit 1) as str_bcode,(select ifnull(count(z.str_userid),0) as cnt from ".$Tname."comm_member_like z where z.str_goodcode=a.str_goodcode) as likecnt,(select ifnull(count(d.str_userid),0) as cnt from ".$Tname."comm_goods_cart d where d.str_goodcode=a.str_goodcode and d.str_userid='".$arr_Auth[0]."' and d.int_state in ('4')) as cartcnt from ";
							$SQL_QUERY.=$Tname."comm_goods_master a left join ".$Tname."comm_com_code e on a.int_brand=e.int_number ";
							$SQL_QUERY.="where a.str_goodcode is not null and (a.str_service='Y' or a.str_service='R') ";
							//$SQL_QUERY.="and a.str_goodcode in (select d.str_goodcode from ".$Tname."comm_goods_master_category d where d.str_bcode in (select concat(c.str_menutype,c.str_chocode,c.str_btmuni) from ".$Tname."comm_menu_btm c where c.str_menutype='".substr($arr_Data['STR_BCODE'],0,2)."' and c.str_chocode='".substr($arr_Data['STR_BCODE'],2,2)."' and c.str_unicode='".substr($arr_Data['STR_BCODE'],4,5)."')) ";
							$SQL_QUERY.="and a.int_brand = '".$arr_Data["INT_BRAND"]."' and a.str_goodcode not in ('".str_no."') ";
							$SQL_QUERY.="order by rand() limit 3";

						} else {
						
							$SQL_QUERY = "select a.*,e.str_code,(select c.str_bcode from ".$Tname."comm_goods_master_category c where a.str_goodcode=c.str_goodcode limit 1) as str_bcode,(select ifnull(count(z.str_userid),0) as cnt from ".$Tname."comm_member_like z where z.str_goodcode=a.str_goodcode) as likecnt,(select ifnull(count(d.str_userid),0) as cnt from ".$Tname."comm_goods_cart d where d.str_goodcode=a.str_goodcode and d.str_userid='".$arr_Auth[0]."' and d.int_state in ('4')) as cartcnt from ";
							$SQL_QUERY.=$Tname."comm_goods_master a left join ".$Tname."comm_com_code e on a.int_brand=e.int_number ";
							$SQL_QUERY.="inner join ".$Tname."comm_goods_master_link c on c.str_sgoodcode=a.str_goodcode and c.str_goodcode='".$str_no."' ";
							$SQL_QUERY.="where a.str_goodcode is not null and (a.str_service='Y' or a.str_service='R') ";
							$SQL_QUERY.="order by a.str_goodcode desc";
					
						}	
						$arr_R_Data=mysql_query($SQL_QUERY);
						$arr_R_Data_Cnt=mysql_num_rows($arr_R_Data);
					?>

					<div class="item_list02">
						<div id="layout">
						
							<?
								for($int_J = 0 ;$int_J < $arr_R_Data_Cnt; $int_J++) {
							?>
							<?$sRent=fnc_cart_info(mysql_result($arr_R_Data,$int_J,str_goodcode));?>
							<div class="item">
								<p class="rented"><?if ($sRent==0) {?><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a><?}?></p>
								<p class="zzim_icn"><a href="detail.php?Txt_bcode=<?=mysql_result($arr_R_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_R_Data,$int_J,str_goodcode)?>"><img src="../images/main/icn_zzim_on.png" alt="" /></a> <?=mysql_result($arr_R_Data,$int_J,likecnt)?></p>
								<p class="item_img" style="width:320px;height:320px;"><?if (mysql_result($arr_R_Data,$int_J,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($arr_R_Data,$int_J,str_image1)?>" style="width:320px;height:320px;" border="0"><?}?></p>
								<dl>
									<dt><a href="detail.php?Txt_bcode=<?=mysql_result($arr_R_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_R_Data,$int_J,str_goodcode)?>"><?=mysql_result($arr_R_Data,$int_J,str_code)?></a></dt>
									<dd><?=mysql_result($arr_R_Data,$int_J,str_egoodname)?></dd>
								</dl>
								<div class="caption" style="display: none;">
									<p class="item_img" style="width:320px;height:320px;"><a href="detail.php?Txt_bcode=<?=mysql_result($arr_R_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_R_Data,$int_J,str_goodcode)?>"><?if (mysql_result($arr_R_Data,$int_J,str_image2)!="") {?><img src="/admincenter/files/good/<?=mysql_result($arr_R_Data,$int_J,str_image2)?>" style="width:320px;height:320px;" border="0"><?}?></a></p>
									<?If ($arr_Auth[0]=="") {?>
										<p class="on_btn mt20"><a href="detail.php?Txt_bcode=<?=mysql_result($arr_R_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_R_Data,$int_J,str_goodcode)?>" class="btn btn_get">GET</a></p>
									<?}else{?>
										<?if ($sBuy > 0) {//구매가 있을때?>
											<?if ($sRent!=0) {//품절이 아닐때?>
												<?if (mysql_result($arr_R_Data,$int_J,cartcnt)>0) {//내가 빌링상품일때?>
													
												<?}else{?>
													<p class="on_btn mt20"><a href="detail.php?Txt_bcode=<?=mysql_result($arr_R_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_R_Data,$int_J,str_goodcode)?>" class="btn btn_get">CHANGE</a></p>
												<?}?>
											<?}else{?>

											<?}?>
										<?}else{//구매가 없을때?>
											<?if ($sRent!=0) {//품절이 아닐때?>
												<p class="on_btn mt20"><a href="detail.php?Txt_bcode=<?=mysql_result($arr_R_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_R_Data,$int_J,str_goodcode)?>" class="btn btn_get">GET</a></p>		
											<?}?>
										<?}?>
									<?}?>
									
								</div>
							</div>
							<?
								}
							?>
							

						</div>
					</div>
					
					</form>

				</div>
			</div>
			

		</div>

<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"; ?>