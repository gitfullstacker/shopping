<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
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
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/detail.js"></script>

		<form id="frm" name="frm" target="_self" method="POST">
		<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
		<input type="hidden" name="loc" value="<?=urlencode($_SERVER["SCRIPT_NAME"] . "?" . $_SERVER["QUERY_STRING"])?>">
		
		<div class="detail_img">
			<!-- Swiper -->
			<div class="swiper-container02">
				<div class="swiper-wrapper">
					<?for ($int_I=3;$int_I<=9;$int_I++){?>
					<?if (!($arr_Data["STR_IMAGE".$int_I]=="")) {?><div class="swiper-slide"><img src="/admincenter/files/good/<?=$arr_Data["STR_IMAGE".$int_I]?>"></div> <?}?>
					<?}?>
				</div>
				<!-- Add Pagination --> 
				<div class="swiper-pagination02"></div> 
				<!-- Add Arrows --> 
				<div class="swiper-button-next02"></div> 
				<div class="swiper-button-prev02"></div> 
			</div>
			<script> 
				var swiper = new Swiper('.swiper-container02', { 
				pagination: '.swiper-pagination02', 
				paginationClickable: true, 
				nextButton: '.swiper-button-next02', 
				prevButton: '.swiper-button-prev02', 
				spaceBetween: 40,
				centeredSlides: true, 
				autoplay: 3500, 
				autoplayDisableOnInteraction: false,
				loop: true
				}); 
			</script> 

					
			<!-- <script type="text/javascript" src="/js/jquery.bxslider.js"></script>
			<link type="text/css" rel="stylesheet" href="/css/jquery.bxslider.css" />
			<ul class="bxslider">
				<?for ($int_I=3;$int_I<=9;$int_I++){?>
				<?if (!($arr_Data["STR_IMAGE".$int_I]=="")) {?><li><img src="/admincenter/files/good/<?=$arr_Data["STR_IMAGE".$int_I]?>" border="0"></li><?}?>
				<?}?>
			</ul>
			
			<script type="text/javascript">
				$(document).ready(function(){
					$('.bxslider').bxSlider({
						auto: true
					});
				});
			</script> -->
		</div>
		<dl class="detail_name mt20">
			<dt><?=$arr_Data['STR_EGOODNAME']?></dt>
			<dd>RETAIL ₩<?=number_format($arr_Data['INT_PRICE'])?></dd>
		</dl>
		<div class="detail_btn">
			<p class="btn btn_bk"><a href="javascript:Click_like('<?=$arr_Data["STR_GOODCODE"]?>');">좋아요</a></p>
			<?$sBuy=fnc_buy_info();?>
			<?$sRent=fnc_cart_info($arr_Data["STR_GOODCODE"]);?>

			<?if ($sRent == 0) {//품절일때?>
			<p class="btn btn_bk"><a href="javascript:Alarm_Click('<?=$arr_Data["STR_GOODCODE"]?>');">입고알림받기</a></p>
			<?}?>
			
			<?If ($arr_Auth[0]=="") {?>
				<p class="btn btn_ylw"><a href="javascript:Cart_MClick('<?=$arr_Data["STR_GOODCODE"]?>');">GET</a></p>
			<?}else{?>
				<?if ($sBuy > 0) {//구매가 있을때?>
					<?if ($sRent!=0) {//품절이 아닐때?>
						<?if ($arr_Data["CARTCNT"]>0) {//내가 빌링상품일때?>
							
						<?}else{?>
							<p class="btn btn_ylw"><a href="javascript:Cart_MClick('<?=$arr_Data["STR_GOODCODE"]?>');">CHANGE</a></p>
						<?}?>
					<?}else{?>

					<?}?>
				<?}else{//구매가 없을때?>
					<?if ($sRent!=0) {//품절이 아닐때?>
						<p class="btn btn_ylw"><a href="javascript:Cart_MClick('<?=$arr_Data["STR_GOODCODE"]?>');">GET</a></p>
					<?}?>
				<?}?>
			<?}?>
		</div>
		<div class="detail_tab">
			<ul>
				<li class="on">DETAILS</li>
			</ul>
		</div>
		<dl class="detail_view" style="border-bottom-width: 0px; padding-bottom: 7px;">
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
				<?if ($arr_Data['INT_USED']=="0") {?><img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /><?}?>
				<?if ($arr_Data['INT_USED']=="1") {?><img src="../images/icn_grade05.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /><?}?>
				<?if ($arr_Data['INT_USED']=="2") {?><img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /><?}?>
				<?if ($arr_Data['INT_USED']=="3") {?><img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade05.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /><?}?>
				<?if ($arr_Data['INT_USED']=="4") {?><img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /><?}?>
				<?if ($arr_Data['INT_USED']=="5") {?><img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade05.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /><?}?>
				<?if ($arr_Data['INT_USED']=="6") {?><img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /><?}?>
				<?if ($arr_Data['INT_USED']=="7") {?><img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade05.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /><?}?>
				<?if ($arr_Data['INT_USED']=="8") {?><img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade00.png" alt="" /><?}?>
				<?if ($arr_Data['INT_USED']=="9") {?><img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade05.png" alt="" /><?}?>
				<?if ($arr_Data['INT_USED']=="10") {?><img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /> <img src="../images/icn_grade10.png" alt="" /><?}?>
			</dd>
			<dd><span class="dv_tit">색상</span><?=$arr_Data['STR_COLOR']?></dd>
		</dl>
	
			<div class="mt20"><?=stripslashes($arr_Data['STR_CONTENTS'])?></div>
		<div class="con_width">
			<p class="tit_h3 mt25" style="margin-bottom:10px;">관련가방</p>
			
			<?
				if ($arr_Data['STR_RE_F']=="Y") { //자동으로 검색
				
					$SQL_QUERY = "select a.*,e.str_code,(select c.str_bcode from ".$Tname."comm_goods_master_category c where a.str_goodcode=c.str_goodcode limit 1) as str_bcode,(select ifnull(count(z.str_userid),0) as cnt from ".$Tname."comm_member_like z where z.str_goodcode=a.str_goodcode) as likecnt,(select ifnull(count(d.str_userid),0) as cnt from ".$Tname."comm_goods_cart d where d.str_goodcode=a.str_goodcode and d.str_userid='".$arr_Auth[0]."' and d.int_state in ('4')) as cartcnt from ";
					$SQL_QUERY.=$Tname."comm_goods_master a left join ".$Tname."comm_com_code e on a.int_brand=e.int_number ";
					$SQL_QUERY.="where a.str_goodcode is not null and (a.str_service='Y' or a.str_service='R') ";
					//$SQL_QUERY.="and a.str_goodcode in (select d.str_goodcode from ".$Tname."comm_goods_master_category d where d.str_bcode in (select concat(c.str_menutype,c.str_chocode,c.str_btmuni) from ".$Tname."comm_menu_btm c where c.str_menutype='".substr($arr_Data['STR_BCODE'],0,2)."' and c.str_chocode='".substr($arr_Data['STR_BCODE'],2,2)."' and c.str_unicode='".substr($arr_Data['STR_BCODE'],4,5)."')) ";
					$SQL_QUERY.="and a.int_brand = '".$arr_Data["INT_BRAND"]."' and a.str_goodcode not in ('".str_no."') ";
					$SQL_QUERY.="order by rand() limit 4";

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
			
			<ul class="new_list mt05">
				<?
					for($int_J = 0 ;$int_J < $arr_R_Data_Cnt; $int_J++) {
				?>
				<?$sRent=fnc_cart_info(mysql_result($arr_R_Data,$int_J,str_goodcode));?>
				<li>
					<?if ($sRent==0) {?><span class="rented">RENTED</span><?}?>
					<p class="zzim_icn"><img src="../images/icn_zzim_on.png" alt="" /> <?=mysql_result($arr_R_Data,$int_J,likecnt)?></p>
					<a href="/m/category/detail.php?Txt_bcode=<?=mysql_result($arr_R_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_R_Data,$int_J,str_goodcode)?>">
						<p><?if (mysql_result($arr_R_Data,$int_J,str_image2)!="") {?><img src="/admincenter/files/good/<?=mysql_result($arr_R_Data,$int_J,str_image2)?>" border="0"><?}?></p>
						<dl>
							<dt><?=mysql_result($arr_R_Data,$int_J,str_code)?></dt>
							<dd><?=mysql_result($arr_R_Data,$int_J,str_egoodname)?></dd>
						</dl>
					</a>
				</li>
				<?
					}
				?>
			</ul>
		</div>
		
		</form>

<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/footer.php"; ?>