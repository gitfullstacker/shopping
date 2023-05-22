<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$topmenu = 1;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>

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
	<a href="../guide" class="menu-item">
		<img src="../images/menu_item1.png" alt="menu_item1" />
		<p class="item-title">이용안내</p>
	</a>
	<a href="../benefits" class="menu-item">
		<img src="../images/menu_item2.png" alt="menu_item2" />
		<p class="item-title">신규혜택</p>
	</a>
	<a href="../review/index.php" class="menu-item">
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
			<p class="title">CATEGORY PICK</p>
			<p class="description">카테고리별 조회수 높은 상품</p>
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
		for ($i = 1; $i <= 3; $i++) {
			$SQL_QUERY = 	'SELECT 
								A.*, B.STR_CODE
							FROM 
								' . $Tname . 'comm_goods_master A
							LEFT JOIN
								' . $Tname . 'comm_com_code B
							ON
								A.INT_BRAND=B.INT_NUMBER
							WHERE 
								(A.STR_SERVICE="Y" OR A.STR_SERVICE="R") 
								AND 
								A.INT_TYPE=' . $i . ' 
							ORDER BY A.INT_VIEW DESC
							LIMIT 2';

			$category_product_result = mysql_query($SQL_QUERY);
		?>
			<div class="section">
				<div class="item relative">
					<img src="images/category<?= $i ?>.png" alt="event_zone">
					<div class="absolute flex flex-col gap-2 left-[13px] bottom-4">
						<?php
						switch ($i) {
							case 1:
						?>
								<p class="font-extrabold text-lg leading-[20px] text-white">RENT BEST</p>
								<p class="font-bold text-xs leading-[14px] text-white">렌트 베스트 상품</p>
							<?php
								break;
							case 2:
							?>
								<p class="font-extrabold text-lg leading-[20px] text-white">MEMBERSHIP BEST</p>
								<p class="font-bold text-xs leading-[14px] text-white">구독 베스트 상품</p>
							<?php
								break;
							case 3:
							?>
								<p class="font-extrabold text-lg leading-[20px] text-white">HOT VINTAGE</p>
								<p class="font-bold text-xs leading-[14px] text-white">반응 좋은 빈티지 상품</p>
						<?php
								break;
						}
						?>

					</div>
				</div>
				<div class="bottom-section">
					<?php
					while ($row = mysql_fetch_assoc($category_product_result)) {
					?>
						<div class="item">
							<div class="image-part">
								<img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" alt="event_zone">
							</div>
							<div class="text-part">
								<p class="tag"><?= $row['STR_CODE'] ?></p>
								<p class="title"><?= $row['STR_GOODNAME'] ?></p>
								<div class="price-section">
									<p class="regular-price">일 <?= number_format($row['INT_PRICE']) ?>원</p>
									<p class="origin-price"><?= $row['INT_DISCOUNT'] ? number_format($row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) . '원' : '' ?></p>
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
	<?
	$query = "SELECT * FROM " . $Tname . "comm_com_code where STR_SERVICE = 'Y' and INT_GUBUN = 2";
	$brand_list_result = mysql_query($query);
	?>
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
		<?
		while ($row = mysql_fetch_assoc($brand_list_result)) {
		?>
			<div class="item">
				<div class="flex w-[115px] h-[160px] rounded-[40px] bg-gray-100 <?= $row['STR_BANNER1'] ?: 'animate-pulse' ?>">
					<img class="w-full h-full rounded-[40px] <?= $row['STR_BANNER1'] ? 'flex' : 'hidden' ?>" src="/admincenter/files/com/<?= $row['STR_BANNER1'] ?>" alt="">
				</div>
				<p class="e-brand"><?= $row['STR_CODE'] ?></p>
				<p class="k-brand"><?= $row['STR_KCODE'] ?></p>
			</div>
		<?php
		}
		?>
	</div>
</div>

<!-- 렌트 한정 기간 타임세일 -->
<div class="rentlimit">
	<div class="sub-section-top-bar">
		<div class="left-section">
			<p class="title">렌트 한정 기간 타임세일</p>
			<p class="description">매주 만나볼 수 있는 특별한 기회를 놓치지마세요</p>
		</div>
		<a href="/m/product/index.php?product_type=1" class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.13379L14.3332 6.0661L8.76416 10.7994" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 6.06592H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</a>
	</div>
	<div class="product-scroll-list">
		<?php
		$SQL_QUERY = 	'SELECT 
							A.*, B.STR_CODE
						FROM 
							' . $Tname . 'comm_goods_master A
						LEFT JOIN
							' . $Tname . 'comm_com_code B
						ON
							A.INT_BRAND=B.INT_NUMBER
						WHERE 
							(A.STR_SERVICE="Y" OR A.STR_SERVICE="R") 
							AND A.INT_TYPE=1 
							AND A.INT_DISCOUNT!=0
						ORDER BY A.INT_DISCOUNT DESC
						LIMIT 6';

		$rent_product_result = mysql_query($SQL_QUERY);
		while ($row = mysql_fetch_assoc($rent_product_result)) {
		?>
			<div class="item">
				<div class="image">
					<img src="../images/mockup/rent_product.png" alt="rent">
					<div class="discount">
						<p class="value"><?= $row['INT_DISCOUNT'] ?>%</p>
					</div>
				</div>
				<p class="brand"><?= $row['STR_CODE'] ?></p>
				<p class="title"><?= $row['STR_GOODNAME'] ?></p>
				<div class="price-section">
					<p class="current-price">일 <?= number_format($row['INT_PRICE']) ?>원</p>
					<p class="origin-price"><?= number_format($row['INT_PRICE'] * $row['INT_DISCOUNT'] * 100) ?>원</p>
				</div>
				<button class="rent-button">렌트</button>
			</div>
		<?php
		}
		?>
	</div>
</div>

<!-- 렌트 신규 입고 -->
<div class="rentnew">
	<div class="sub-section-top-bar">
		<div class="left-section">
			<p class="title">렌트 신규 입고</p>
			<p class="description">실시간으로 업데이트되는 상품을 만나보세요</p>
		</div>
		<a href="/m/product/index.php?product_type=1" class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.13379L14.3332 6.0661L8.76416 10.7994" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 6.06592H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</a>
	</div>
	<div class="main-image">
		<img src="images/new_rent.png" alt="rentnew">
	</div>
	<div class="product-scroll-list">
		<?
		$SQL_QUERY = 	'SELECT 
							A.*, B.STR_CODE
						FROM 
							' . $Tname . 'comm_goods_master A
						LEFT JOIN
							' . $Tname . 'comm_com_code B
						ON
							A.INT_BRAND=B.INT_NUMBER
						WHERE 
							(A.STR_SERVICE="Y" OR A.STR_SERVICE="R") 
							AND A.INT_TYPE=1 
						ORDER BY A.DTM_INDATE DESC
						LIMIT 6';

		$rent_new_product_result = mysql_query($SQL_QUERY);
		while ($row = mysql_fetch_assoc($rent_new_product_result)) {
		?>
			<div class="item">
				<div class="flex justify-center items-center w-[126px] h-[126px] p-2.5 bg-[#F9F9F9] rounded">
					<img class="w-full" src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" alt="rent">
				</div>
				<p class="brand"><?= $row['STR_CODE'] ?></p>
				<p class="title"><?= $row['STR_GOODNAME'] ?></p>
				<div class="price-section">
					<p class="current-price"><span class="text-[#00402F]"><?= $row['INT_DISCOUNT'] ? $row['INT_DISCOUNT'] . '%' : '' ?></span>일 <?= $row['INT_DISCOUNT'] ? number_format($row['INT_PRICE'] * $row['INT_DISCOUNT'] * 100) : number_format($row['INT_PRICE']) ?>원</p>
				</div>
				<button class="rent-button">렌트</button>
			</div>
		<?php
		}
		?>
	</div>
</div>

<!-- 구독 신규 입고 -->
<div class="subscriptionnew">
	<div class="sub-section-top-bar">
		<div class="left-section">
			<p class="title">구독 신규 입고</p>
			<p class="description">실시간으로 업데이트되는 상품을 만나보세요</p>
		</div>
		<a href="/m/product/index.php?product_type=2" class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.13379L14.3332 6.0661L8.76416 10.7994" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 6.06592H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</a>
	</div>
	<div class="main-image">
		<img src="images/new_subscription.png" alt="subscriptionnew">
	</div>
	<div class="product-scroll-list">
		<?
		$SQL_QUERY = 	'SELECT 
							A.*, B.STR_CODE
						FROM 
							' . $Tname . 'comm_goods_master A
						LEFT JOIN
							' . $Tname . 'comm_com_code B
						ON
							A.INT_BRAND=B.INT_NUMBER
						WHERE 
							(A.STR_SERVICE="Y" OR A.STR_SERVICE="R") 
							AND A.INT_TYPE=2 
						ORDER BY A.DTM_INDATE DESC
						LIMIT 6';

		$subscription_new_product_result = mysql_query($SQL_QUERY);
		while ($row = mysql_fetch_assoc($subscription_new_product_result)) {
		?>
			<div class="item">
				<div class="flex justify-center items-center w-[126px] h-[126px] p-2.5 bg-[#F9F9F9] rounded">
					<img class="w-full" src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" alt="rent">
				</div>
				<p class="brand"><?= $row['STR_CODE'] ?></p>
				<p class="title"><?= $row['STR_GOODNAME'] ?></p>
				<div class="price-section">
					<p class="current-price">월 <?= number_format($row['INT_PRICE']) ?>원</p>
				</div>
				<button class="subscription-button">구독</button>
			</div>
		<?php
		}
		?>
	</div>
</div>

<!-- Review -->
<div class="review">
	<div class="sub-section-top-bar">
		<div class="left-section">
			<p class="title">REVIEW</p>
		</div>
		<a href="/m/review/index.php" class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.13379L14.3332 6.0661L8.76416 10.7994" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 6.06592H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</a>
	</div>
	<div class="image-grid">
		<?php
		$SQL_QUERY =   'SELECT 
							A.*
						FROM 
							' . $Tname . 'comm_review A
						WHERE 
							A.STR_GOODCODE IS NOT NULL
							AND (A.STR_IMAGE1 IS NOT NULL OR A.STR_IMAGE2 IS NOT NULL OR A.STR_IMAGE3 IS NOT NULL)
						ORDER BY 
							A.INT_STAR DESC,
							A.DTM_EDIT_DATE DESC
						LIMIT 8';

		$best_review_list_result = mysql_query($SQL_QUERY);
		while ($row = mysql_fetch_assoc($best_review_list_result)) {
		?>
			<div class="image <?= $i == 2 ? 'large' : '' ?> bg-gray-100">
				<img class="object-cover object-center <?= !$row['STR_IMAGE1'] && !$row['STR_IMAGE2'] && !$row['STR_IMAGE3'] ? 'hidden' : 'flex' ?>" onError="this.style.display='none'" src="/admincenter/files/boad/2/<?= $row['STR_IMAGE1'] ?: $row['STR_IMAGE2'] ?: $row['STR_IMAGE3'] ?>" alt="review">
			</div>
		<?php
		}
		?>
	</div>
	<a href="/m/review/index.php" class="mt-[21px] w-[225px] h-[38px] flex justify-center items-center bg-white border-[0.5px] border-solid border-[#DDDDDD]">
		<p class="font-bold text-[11px] leading-[12px]">더 많은 리뷰 보러가기</p>
	</a>
</div>

<!-- hidden by kkk -->
<div style="display: none;">
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
		<a href="/m/cscenter/lookbook1.php"><img src="../images/lookbook.jpg" style="padding-top:10px;" /></a>
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
</div>


<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php"; ?>