<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$str_Ini_Group_Table = "@01";
$str_Board_Icon_Img = "/pub/img/board/";
$Sql_Query =	" SELECT
					A.BD_SEQ,
					A.CONF_SEQ,
					A.BD_ID_KEY,
					A.BD_IDX,
					A.BD_ORDER,
					A.BD_LEVEL,
					A.MEM_CODE,
					A.MEM_ID,
					A.BD_W_NAME,
					A.BD_W_EMAIL,
					A.BD_TITLE,
					A.BD_CONT,
					A.BD_OPEN_YN,
					A.BD_REG_DATE,
					A.BD_DEL_YN,
					A.BD_VIEW_CNT,
					A.BD_GOOD_CNT,
					A.BD_BAD_CNT,
					IFNULL(A.BD_MEMO_CNT, 0) AS BD_MEMO_CNT,
					IFNULL(C.IMG_SEQ, 0) AS IMG_SEQ,
					IFNULL(C.IMG_ID_KEY, '') AS IMG_ID_KEY,
					IFNULL(C.IMG_TITLE, '') AS IMG_TITLE,
					IFNULL(C.IMG_CONT, '') AS IMG_CONT,
					IFNULL(C.IMG_F_WIDTH, 0) AS IMG_F_WIDTH,
					IFNULL(C.IMG_F_HEIGHT, 0) AS IMG_F_HEIGHT,
					IFNULL(D.FILE_SEQ, 0) AS FILE_SEQ
				FROM `"
	. $Tname . "b_bd_data" . $str_Ini_Group_Table . "` AS A
					LEFT JOIN `"
	. $Tname . "b_img_data" . $str_Ini_Group_Table . "` AS C
					ON
					A.CONF_SEQ=C.CONF_SEQ
					AND
					A.BD_SEQ=C.BD_SEQ
					AND
					C.IMG_ALIGN=1
					LEFT JOIN `"
	. $Tname . "b_file_data" . $str_Ini_Group_Table . "` AS D
					ON
					A.CONF_SEQ=D.CONF_SEQ
					AND
					A.BD_SEQ=D.BD_SEQ
					AND
					D.FILE_ALIGN=1
				WHERE ";
$Sql_Query .= " A.CONF_SEQ=3 AND ";
$Sql_Query .= " A.BD_ID_KEY IS NOT NULL ";
$Sql_Query .= " ORDER BY
								BD_ORDER DESC ";
$Sql_Query .= "limit 3";

$arr_Get_Data5 = mysql_query($Sql_Query);
if (!$arr_Get_Data5) {
	error("QUERY_ERROR");
	exit;
}
$arr_Get_Data_Cnt5 = mysql_num_rows($arr_Get_Data5);
?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php"; ?>

<!-- 슬라이더 -->
<div class="m_visual">
	<div class="swiper-container1">
		<div class="swiper-wrapper">
			<?
			$SQL_QUERY = "select a.* from " . $Tname . "comm_banner a where a.str_service='Y' and a.int_gubun='6' order by a.int_number asc ";

			$arr_Bann_Data = mysql_query($SQL_QUERY);
			$arr_Bann_Data_Cnt = mysql_num_rows($arr_Bann_Data);
			?>
			<?
			for ($int_J = 0; $int_J < $arr_Bann_Data_Cnt; $int_J++) {
			?>
				<? if (mysql_result($arr_Bann_Data, $int_J, str_image1) != "") { ?>
					<div class="swiper-slide">
						<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
							<a href="<?= mysql_result($arr_Bann_Data, $int_J, str_url1) ?>" <? if (mysql_result($arr_Bann_Data, $int_J, str_target1) == "2") { ?> target="_blank" <? } ?>>
							<? } ?>
							<img src="/admincenter/files/bann/<?= mysql_result($arr_Bann_Data, $int_J, str_image1) ?>" alt="" />
							<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
							</a>
						<? } ?>
					</div>
				<? } ?>
			<?
			}
			?>
		</div>
		<!-- Add Pagination -->
		<div class="swiper-pagination"></div>
		<!-- Add Arrows -->
	</div>
	<script>
		var swiper = new Swiper('.swiper-container1', {
			effect: 'fade',
			pagination: '.swiper-pagination',
			paginationClickable: true,
			spaceBetween: 0,
			centeredSlides: true,
			autoplay: 2500,
			autoplayDisableOnInteraction: false,
			loop: true
		});
	</script>
</div>

<!-- 안내메뉴 -->
<div class="sub-menu">
	<a href="#" class="menu-item">
		<img src="../images/menu_item1.png" alt="menu_item1" />
		<p class="item-title">이용안내</p>
	</a>
	<a href="#" class="menu-item">
		<img src="../images/menu_item2.png" alt="menu_item2" />
		<p class="item-title">신규혜택</p>
	</a>
	<a href="#" class="menu-item">
		<img src="../images/menu_item3.png" alt="menu_item3" />
		<p class="item-title">리뷰</p>
	</a>
	<a href="#" class="menu-item">
		<img src="../images/menu_item4.png" alt="menu_item4" />
		<p class="item-title">기획전</p>
	</a>
</div>

<!-- 이벤트존 -->
<div class="eventzone">
	<div class="sub-section-top-bar">
		<div class="left-section">
			<p class="title">이벤트존</p>
			<p class="description">에이블랑만의 큐레이션</p>
		</div>
		<a href="#" class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.02539L14.3332 5.9577L8.76416 10.691" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 5.95801H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</a>
	</div>
	<div class="eventzone-scroll-list">
		<?php
		for ($i = 0; $i < 5; $i++) {
		?>
			<div class="item">
				<img src="../images/mockup/event_zone.png" alt="event_zone">
			</div>
		<?php
		}
		?>
	</div>
</div>

<!-- Category Pick -->
<div class="categorypick">
	<div class="sub-section-top-bar">
		<div class="left-section">
			<p class="title">이벤트존</p>
			<p class="description">에이블랑만의 큐레이션</p>
		</div>
		<a href="#" class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.02539L14.3332 5.9577L8.76416 10.691" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 5.95801H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</a>
	</div>
	<div class="categorypick-scroll-list">
		<?php
		for ($i = 0; $i < 5; $i++) {
		?>
			<div class="section">
				<div class="item">
					<img src="../images/mockup/category.png" alt="event_zone">
				</div>
				<div class="bottom-section">
					<?php
					for ($j = 0; $j < 2; $j++) {
					?>
						<div class="item">
							<div class="image-part">
								<img src="../images/mockup/product.png" alt="event_zone">
							</div>
							<div class="text-part">
								<p class="tag">BOTTEGA BENETA</p>
								<p class="title">카세트 스몰</p>
								<div class="price-section">
									<p class="regular-price">일 35,920원</p>
									<p class="origin-price">35,920원</p>
								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		<?php
		}
		?>
	</div>
</div>

<!-- Top Brand -->
<div class="topbrand">
	<div class="sub-section-top-bar">
		<div class="left-section">
			<p class="title">TOP BRAND</p>
			<p class="description">주간 급상승, 이 브랜드에 주목하세요</p>
		</div>
		<div class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.13379L14.3332 6.0661L8.76416 10.7994" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 6.06592H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</div>
	</div>
	<div class="topbrand-scroll-list">
		<?php
		for ($i = 0; $i < 5; $i++) {
		?>
			<div class="item">
				<img src="../images/mockup/brand.png" alt="event_zone">
				<p class="e-brand">CHANEL</p>
				<p class="k-brand">샤넬</p>
			</div>
		<?php
		}
		?>
	</div>
</div>

<!-- Rent Limit -->
<div class="rentlimit">
	<div class="sub-section-top-bar">
		<div class="left-section">
			<p class="title">렌트 한정 기간 타임세일</p>
			<p class="description">매주 만나볼 수 있는 특별한 기회를 놓치지마세요</p>
		</div>
		<div class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.13379L14.3332 6.0661L8.76416 10.7994" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 6.06592H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</div>
	</div>
	<div class="product-scroll-list">
		<?php
		for ($i = 0; $i < 5; $i++) {
		?>
			<div class="item">
				<div class="image">
					<img src="../images/mockup/rent_product.png" alt="rent">
					<div class="discount">
						<p class="value">20%</p>
					</div>
				</div>
				<p class="brand">DIOR</p>
				<p class="title">바비백 스몰</p>
				<div class="price-section">
					<p class="current-price">일 35,920원</p>
					<p class="origin-price">35,920원</p>
				</div>
				<button class="rent-button">렌트</button>
			</div>
		<?php
		}
		?>
	</div>
</div>

<!-- Rent New -->
<div class="rentnew">
	<div class="sub-section-top-bar">
		<div class="left-section">
			<p class="title">렌트 신규 입고</p>
			<p class="description">실시간으로 업데이트되는 상품을 만나보세요</p>
		</div>
		<div class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.13379L14.3332 6.0661L8.76416 10.7994" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 6.06592H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</div>
	</div>
	<div class="main-image">
		<img src="../images/mockup/new_rent.png" alt="rentnew">
	</div>
	<div class="product-scroll-list">
		<?php
		for ($i = 0; $i < 5; $i++) {
		?>
			<div class="item">
				<div class="image">
					<img src="../images/mockup/rent_product.png" alt="rent">
				</div>
				<p class="brand">DIOR</p>
				<p class="title">바비백 스몰</p>
				<div class="price-section">
					<p class="current-price">일 35,920원</p>
					<p class="origin-price">35,920원</p>
				</div>
				<button class="rent-button">렌트</button>
			</div>
		<?php
		}
		?>
	</div>
</div>

<!-- Subscription New -->
<div class="subscriptionnew">
	<div class="sub-section-top-bar">
		<div class="left-section">
			<p class="title">구독 신규 입고</p>
			<p class="description">실시간으로 업데이트되는 상품을 만나보세요</p>
		</div>
		<div class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.13379L14.3332 6.0661L8.76416 10.7994" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 6.06592H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</div>
	</div>
	<div class="main-image">
		<img src="../images/mockup/new_subscription.png" alt="subscriptionnew">
	</div>
	<div class="product-scroll-list">
		<?php
		for ($i = 0; $i < 5; $i++) {
		?>
			<div class="item">
				<div class="image">
					<img src="../images/mockup/rent_product.png" alt="rent">
				</div>
				<p class="brand">DIOR</p>
				<p class="title">바비백 스몰</p>
				<div class="price-section">
					<p class="current-price">일 35,920원</p>
					<p class="origin-price">35,920원</p>
				</div>
				<button class="subscription-button">구독</button>
			</div>
		<?php
		}
		?>
	</div>
</div>

<div class="con_width">
	<div class="main_tit2"><span>NEW</span></div>
	<ul class="new_list">
		<?
		$SQL_QUERY = "SELECT 
							A.*,
							(SELECT B.STR_BCODE FROM " . $Tname . "comm_goods_master_category B WHERE A.STR_GOODCODE=B.STR_GOODCODE LIMIT 1) AS STR_BCODE,
							(SELECT IFNULL(COUNT(Z.STR_USERID),0) AS CNT FROM " . $Tname . "comm_member_like Z WHERE Z.STR_GOODCODE=A.STR_GOODCODE) AS LIKECNT, 
							(SELECT IFNULL(COUNT(D.STR_USERID),0) AS CNT FROM " . $Tname . "comm_goods_cart D WHERE D.STR_GOODCODE=A.STR_GOODCODE AND D.STR_USERID='" . $arr_Auth[0] . "' AND D.INT_STATE IN ('4')) AS CARTCNT,
							E.STR_CODE
						FROM 
							" . $Tname . "comm_goods_master A
							LEFT JOIN
							" . $Tname . "comm_com_code E
							ON
							A.INT_BRAND=E.INT_NUMBER
						WHERE 
							A.STR_GOODCODE IS NOT NULL 
							AND 
							(A.STR_SERVICE='Y' OR A.STR_SERVICE='R') 
							AND 
							A.STR_MMYN='Y' 
						ORDER BY 
							A.INT_SORT DESC";

		$arr_Data = mysql_query($SQL_QUERY);
		$arr_Data_Cnt = mysql_num_rows($arr_Data);
		?>
		<? $sBuy = fnc_buy_info(); ?>
		<?
		for ($int_J = 0; $int_J < $arr_Data_Cnt; $int_J++) {
		?>
			<? $sRent = fnc_cart_info(mysql_result($arr_Data, $int_J, str_goodcode)); ?>
			<li>
				<? if ($sRent == 0) { ?>
					<span class="rented">RENTED</span>
				<? } ?>
				<p class="zzim_icn"><img src="../images/icn_zzim_on.png" alt="" /> <?= mysql_result($arr_Data, $int_J, likecnt) ?></p>
				<a href="/m/category/detail.php?Txt_bcode=<?= mysql_result($arr_Data, $int_J, str_bcode) ?>&str_no=<?= mysql_result($arr_Data, $int_J, str_goodcode) ?>">
					<p><? if (mysql_result($arr_Data, $int_J, str_image1) != "") { ?><img src="/admincenter/files/good/<?= mysql_result($arr_Data, $int_J, str_image1) ?>" border="0"><? } ?></p>
					<dl>
						<dt><?= mysql_result($arr_Data, $int_J, str_code) ?></dt>
						<dd><?= mysql_result($arr_Data, $int_J, str_egoodname) ?></dd>
					</dl>
				</a>
			</li>
		<?
		}
		?>

	</ul>
	<p><a href="/m/category/list.php" class="btn btn_readmore">MORE BAGS <i class="icn"></i></a></p>
	<div class="banner_line2 mt50"></div>
	<div class="main_tit">
		<span>BRAND</span>
	</div>
	<div class="m_brand">
		<ul>
			<?
			$SQL_QUERY = "select a.* from " . $Tname . "comm_com_code a where a.str_service='Y' and a.int_gubun='2' order by a.int_number asc ";

			$arr_Bann_Data = mysql_query($SQL_QUERY);
			$arr_Bann_Data_Cnt = mysql_num_rows($arr_Bann_Data);
			?>
			<?
			for ($int_J = 0; $int_J < $arr_Bann_Data_Cnt; $int_J++) {
			?>
				<li><a href="/m/search/search.php?Txt_brand[]=<?= mysql_result($arr_Bann_Data, $int_J, int_number) ?>"><span><? if (mysql_result($arr_Bann_Data, $int_J, str_image1) != "") { ?><img src="/admincenter/files/com/<?= mysql_result($arr_Bann_Data, $int_J, str_image1) ?>" alt="" /><? } ?></span></a></li>
			<?
			}
			?>
		</ul>
	</div>

</div>
<div class="banner_line2 mt50">
	<?
	$SQL_QUERY = "select a.* from " . $Tname . "comm_banner a where a.str_service='Y' and a.int_gubun='4' order by a.int_number asc ";

	$arr_Bann_Data = mysql_query($SQL_QUERY);
	$arr_Bann_Data_Cnt = mysql_num_rows($arr_Bann_Data);
	?>
	<?
	for ($int_J = 0; $int_J < $arr_Bann_Data_Cnt; $int_J++) {
	?>
		<? if (mysql_result($arr_Bann_Data, $int_J, str_image1) != "") { ?>
			<p>
				<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
					<a href="<?= mysql_result($arr_Bann_Data, $int_J, str_url1) ?>" <? if (mysql_result($arr_Bann_Data, $int_J, str_target1) == "2") { ?> target="_blank" <? } ?>>
					<? } ?>
					<img src="/admincenter/files/bann/<?= mysql_result($arr_Bann_Data, $int_J, str_image1) ?>" alt="" />
					<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
					</a>
				<? } ?>
			</p>
		<? } ?>
	<?
	}
	?>
</div>
<div class="con_width" style="padding-bottom: 30px;">
	<?
	$SQL_QUERY = "select a.* from " . $Tname . "comm_banner a where a.str_service='Y' and a.int_gubun='5' order by a.int_number asc ";

	$arr_Bann_Data = mysql_query($SQL_QUERY);
	$arr_Bann_Data_Cnt = mysql_num_rows($arr_Bann_Data);
	?>
	<?
	for ($int_J = 0; $int_J < $arr_Bann_Data_Cnt; $int_J++) {
	?>
		<? if (mysql_result($arr_Bann_Data, $int_J, str_image1) != "") { ?>
			<p class="m_service">
				<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
					<a href="<?= mysql_result($arr_Bann_Data, $int_J, str_url1) ?>" <? if (mysql_result($arr_Bann_Data, $int_J, str_target1) == "2") { ?> target="_blank" <? } ?>>
					<? } ?>
					<img src="/admincenter/files/bann/<?= mysql_result($arr_Bann_Data, $int_J, str_image1) ?>" alt="" />
					<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
					</a>
				<? } ?>
			</p>
		<? } ?>
	<?
	}
	?>


	<div class="modal__wrapper is-hidden js-example-modal-1">
		<div class="modal__double js-modal__double">
			<div class="modal__content">
				<a href="#" class="modal__close js-modal__close"></a>
				<div class="contents_bx">
					<p style="height:315px;overflow-y:scroll;border:1px solid #ccc;"><img src="../images/membership_guide_mobile02.gif" alt="멤버십 이용 가이드" /></p>
					<p class="center mt10"><a href="/m/mypage/membership.php" class="btn btn_bk btn_s">멤버십 등록하러 가기</a></p>
				</div>
			</div>
		</div>
	</div>

	<link rel="stylesheet" href="/m/css/simplePop.css">

	<script src="/m/js/simplePopup.js"></script>
	<script type="text/javascript">
		$(function() {

			$('.js-open-modal').each(function() {

				var modalClass = $(this).data('what');
				var $modal = $('.' + modalClass);
				var $this = $(this);


				var code = $modal.html();
				var textarea = $this.parents('.example__item').append('<div class="example__code"><textarea></textarea></div>').find('textarea');
				textarea.val(code);

				$this.on('click', function() {
					$modal.simplePop();
				});

			});

		});
	</script>
</div>
<div class="main_banner">
	<a href="https://www.instagram.com/ablanc_lookbook/?hl=ko"><img src="../images/instagram.jpg" /></a>
	<a href="/m/cscenter/lookbook1.php"><img src="../images/lookbook.jpg" style="padding-top:10px;" /><a>
			<a href="/m/cscenter/guideyong.php"><img src="../images/introduce.jpg" style="padding-top:10px; padding-bottom:10px;" /></a>
</div>

<div>
	<a href="/m/cscenter/guideyong.php"><img src="../images/helper1.jpg" /></a>
</div>

<div>
	<div style="width:50%; float:left;">
		<a href="/m/cscenter/deliveryyong.php"><img src="../images/helper2.jpg" /></a>
	</div>
	<div style="width:50%; float:left;">
		<a href="/m/cscenter/updateyong.php"><img src="../images/helper3.jpg" /></a>
	</div>
</div>
<div>
	<div style="width:50%; float:left;">
		<a href="/m/cscenter/faq.php"><img src="../images/helper4.jpg" /></a>
	</div>
	<div style="width:50%; float:left;">
		<a href="/m/cscenter/csyong.php"><img src="../images/helper5.jpg" /></a>
	</div>
</div>


<div>
	<a href="/m/cscenter/guideyong.php"><img src="../images/bottom_banner.jpg" alt="멤버십 이용 가이드" /></a>

</div>


<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php"; ?>