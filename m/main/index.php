<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$topmenu = 1;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>

<?php
// 금액정보얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_site_info AS A
                WHERE
                    A.INT_NUMBER=1';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);

//구독멤버십 여부확인
$is_sub_membership = fnc_sub_member_info() > 0 ? true : false;
?>

<!-- 슬라이더 -->
<div class="flex w-full overflow-hidden">
	<?php
	$SQL_QUERY =     'SELECT 
						A.*
					FROM 
						' . $Tname . 'comm_banner A
					WHERE 
						A.STR_SERVICE="Y"
						AND A.INT_GUBUN=6
					ORDER BY A.DTM_INDATE DESC';

	$home_banner_list_result = mysql_query($SQL_QUERY);
	?>
	<div x-data="{
			imageCount: 3,
			slider: 1,
			containerWidth: 0,
			handleScroll() {
				const scrollPosition = this.$refs.sliderContainer.scrollLeft;
				const slider = Math.round(scrollPosition / this.containerWidth) + 1;
				
				this.slider = slider;
			},
			init() {
				setInterval(() => {
					this.imageCount = this.$refs.sliderContainer.children.length;
					this.containerWidth = this.$refs.sliderContainer.offsetWidth;

					if (this.slider + 1 > this.imageCount) {
						this.slider = 1;
					} else {
						this.slider++;
					}
					this.$refs.sliderContainer.scrollTo({
						left: (this.slider - 1) * this.containerWidth,
						behavior: 'smooth'
					});
				}, 3000);
			}
		}" class="flex w-full relative">
		<div class="flex overflow-x-auto snap-x snap-mandatory custom-scrollbar" x-ref="sliderContainer" x-on:scroll="handleScroll">
			<?php
			while ($row = mysql_fetch_assoc($home_banner_list_result)) {
			?>
				<a href="<?= $row['STR_URL1'] ?>" class="flex-none snap-always snap-center max-w-[410px] min-w-full h-[467px] bg-gray-100">
					<img class="min-w-full h-full" src="/admincenter/files/bann/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display='none'" alt="">
				</a>
			<?php
			}
			?>
		</div>
		<div class="absolute w-full flex justify-center px-[77px] bottom-[14.45px]">
			<div class="flex w-full bg-[#C6C6C6] h-[1.55px]">
				<div class="h-[1.55px] bg-black" x-bind:class="slider == imageCount ? 'w-full' : 'w-[' + slider/imageCount * 100 + '%]'"></div>
			</div>
		</div>
	</div>
</div>

<!-- 안내메뉴 -->
<div class="mt-9 grid grid-cols-4 gap-[17px] px-4 w-full">
	<a href="../guide" class="flex flex-col items-center gap-[9px]">
		<img src="../images/menu_item1.png" alt="menu_item1" />
		<p class="font-bold text-[13px] leading-[14px] text-center text-[#444444]">이용안내</p>
	</a>
	<a href="../benefits" class="flex flex-col items-center gap-[9px]">
		<img src="../images/menu_item2.png" alt="menu_item2" />
		<p class="font-bold text-[13px] leading-[14px] text-center text-[#444444]">신규혜택</p>
	</a>
	<a href="../review/index.php" class="flex flex-col items-center gap-[9px]">
		<img src="../images/menu_item3.png" alt="menu_item3" />
		<p class="font-bold text-[13px] leading-[14px] text-center text-[#444444]">리뷰</p>
	</a>
	<a href="#" class="flex flex-col items-center gap-[9px]">
		<img src="../images/menu_item4.png" alt="menu_item4" />
		<p class="font-bold text-[13px] leading-[14px] text-center text-[#444444]">기획전</p>
	</a>
</div>

<!-- 이벤트존 -->
<div class="eventzone">
	<div class="sub-section-top-bar">
		<div class="left-section">
			<p class="title">이벤트존</p>
			<p class="description">에이블랑만의 큐레이션</p>
		</div>
		<a href="/m/eventzone/index.php?menu=event" class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.02539L14.3332 5.9577L8.76416 10.691" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 5.95801H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</a>
	</div>
	<div class="eventzone-scroll-list">
		<?php
		$SQL_QUERY = 	'SELECT 
							A.*
						FROM 
							' . $Tname . 'comm_event A
						WHERE 
							A.STR_SERVICE="Y"
						ORDER BY A.DTM_INDATE DESC
						LIMIT 4';

		$event_list_result = mysql_query($SQL_QUERY);
		while ($row = mysql_fetch_assoc($event_list_result)) {
		?>
			<a href="/m/eventzone/detail.php?int_number=<?= $row['INT_NUMBER'] ?>" class="item flex-none w-[273.16px] bg-gray-100">
				<img class="min-w-full object-cover" src="/admincenter/files/event/<?= $row['STR_IMAGE2'] ?>" onerror="this.style.display = 'none'" alt="">
			</a>
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
		for ($i = 0; $i < 3; $i++) {

			switch ($i) {
				case 0:
					$int_type = 2;
					break;

				case 1:
					$int_type = 1;
					break;

				case 2:
					$int_type = 3;
					break;
			}
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
								A.INT_TYPE=' . $int_type . ' 
							ORDER BY A.INT_VIEW DESC
							LIMIT 2';

			$category_product_result = mysql_query($SQL_QUERY);
		?>
			<div class="section">
				<a href="/m/product/index.php?product_type=<?= $int_type ?>" class="item relative">
					<div class="flex w-[247px] h-[369px] bg-gray-500 rounded-xl">
						<?php
						$SQL_QUERY = 	'SELECT 
											A.*
										FROM 
											' . $Tname . 'comm_banner A
										WHERE 
											A.STR_SERVICE="Y"
											AND A.INT_GUBUN=10
											AND A.INT_TYPE=' . $int_type . '
										LIMIT 1';

						$banner_result = mysql_query($SQL_QUERY);
						$banner_Data = mysql_fetch_assoc($banner_result);
						?>
						<img class="w-full object-cover rounded-xl" src="/admincenter/files/bann/<?= $banner_Data['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="event_zone">
					</div>

					<div class="absolute flex flex-col gap-2 left-[13px] bottom-4">
						<?php
						switch ($i) {
							case 0:
						?>
								<p class="font-extrabold text-[19px] leading-[20px] text-white">RENT BEST</p>
								<p class="font-bold text-[13px] leading-[14px] text-white">렌트 베스트 상품</p>
							<?php
								break;
							case 1:
							?>
								<p class="font-extrabold text-[19px] leading-[20px] text-white">MEMBERSHIP BEST</p>
								<p class="font-bold text-[13px] leading-[14px] text-white">구독 베스트 상품</p>
							<?php
								break;
							case 2:
							?>
								<p class="font-extrabold text-[19px] leading-[20px] text-white">HOT VINTAGE</p>
								<p class="font-bold text-[13px] leading-[14px] text-white">반응 좋은 빈티지 상품</p>
						<?php
								break;
						}
						?>

					</div>
				</a>
				<div class="bottom-section">
					<?php
					while ($row = mysql_fetch_assoc($category_product_result)) {
					?>
						<a href="/m/product/detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="item">
							<div class="image-part relative">
								<div class="flex justify-center items-center absolute top-1 left-2 w-[30px] h-[20px] bg-[<?= $row['INT_TYPE'] == 1 ? '#EEAC4C' : ($row['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A') ?>] <?= $row['INT_DISCOUNT'] ? '' : 'hidden' ?>">
									<p class="font-extrabold text-[9px] leading-[9px] text-white"><?= $row['INT_DISCOUNT'] ?>%</p>
								</div>
								<img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" alt="event_zone">
							</div>
							<div class="flex flex-col items-start">
								<p class="font-extrabold text-xs leading-[14px] text-[#666666]"><?= $row['STR_CODE'] ?></p>
								<p class="mt-[3.36px] font-medium text-xs leading-[14px] text-[#333333] line-clamp-1"><?= $row['STR_GOODNAME'] ?></p>
								<div class="mt-2 price-section">
									<?php
									switch ($row['INT_TYPE']) {
										case 1:
									?>
											<div class="flex flex-row gap-1 items-end">
												<?php
												if (!$is_sub_membership) {
												?>
													<p class="font-bold text-[13px] leading-[14px] text-black">
														<span class="font-medium text-[#EEAC4C]">월</span> <?= number_format($site_Data['INT_OPRICE1']) ?>원
													</p>
												<?php
												}
												?>
											</div>
										<?php
											break;
										case 2:
										?>
											<div class="flex flex-row gap-1 items-end">
												<p class="font-bold text-[13px] leading-[14px] text-black">
													<span class="font-medium">일</span> <?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원
												</p>
												<p class="font-bold text-[11px] leading-[13px] text-[#666666] line-through <?= $row['INT_DISCOUNT'] ? '' : 'hidden' ?>">
													<?= number_format($row['INT_PRICE']) ?>원
												</p>
											</div>
										<?php
											break;
										case 3:
										?>
											<div class="flex flex-row gap-1 items-end">
												<p class="font-bold text-[13px] leading-[14px] text-black">
													<?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원
												</p>
												<p class="font-bold text-[11px] leading-[13px] text-[#666666] line-through <?= $row['INT_DISCOUNT'] ? '' : 'hidden' ?>">
													<?= number_format($row['INT_PRICE']) ?>원
												</p>
											</div>
									<?php
											break;
									}
									?>

								</div>
							</div>
						</a>
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
	<?php
	$query = 	"SELECT * 
				FROM " . $Tname . "comm_com_code 
				WHERE 
					STR_SERVICE = 'Y' 
					AND STR_SHOW_MAIN = 'Y' 
					AND INT_GUBUN = 2";
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
			<div class="w-[115px] rounded-[40px] flex flex-col items-center">
				<div class="flex w-[115px] h-[160px] rounded-[40px] bg-gray-100 <?= $row['STR_BANNER1'] ?: 'animate-pulse' ?>">
					<img class="min-w-full h-full object-cover rounded-[40px]" src="/admincenter/files/com/<?= $row['STR_BANNER1'] ?>" onerror="this.style.display = 'none'" alt="">
				</div>
				<p class="mt-[9.66px] font-extrabold text-sm leading-[14px] text-center text-[#333333]"><?= $row['STR_CODE'] ?></p>
				<p class="mt-[2.66px] font-bold text-xs leading-[14px] text-center text-[#666666]"><?= $row['STR_KCODE'] ?></p>
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
		<a href="/m/product/index.php?product_type=2" class="right-section">
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
							AND A.INT_TYPE=2 
							AND A.INT_DISCOUNT!=0
						ORDER BY A.INT_DISCOUNT DESC
					LIMIT 6';

		$rent_product_result = mysql_query($SQL_QUERY);
		while ($row = mysql_fetch_assoc($rent_product_result)) {
		?>
			<a href="/m/product/detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="item">
				<div class="image">
					<img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="rent">
					<div class="discount">
						<p class="value"><?= $row['INT_DISCOUNT'] ?>%</p>
					</div>
				</div>
				<p class="brand"><?= $row['STR_CODE'] ?></p>
				<p class="title line-clamp-1"><?= $row['STR_GOODNAME'] ?></p>
				<div class="price-section">
					<p class="current-price"><span class="font-medium">일</span> <?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원</p>
					<p class="origin-price <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>"><?= number_format($row['INT_PRICE']) ?>원</p>
				</div>
				<button class="rent-button">렌트</button>
			</a>
		<?php
		}
		?>
	</div>
</div>

<!-- 렌트 신규 입고 -->
<div class="rentnew">
	<div class="sub-section-top-bar px-[14px]">
		<div class="left-section">
			<p class="title">렌트 신규 입고</p>
			<p class="description">실시간으로 업데이트되는 상품을 만나보세요</p>
		</div>
		<a href="/m/product/index.php?product_type=2" class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.13379L14.3332 6.0661L8.76416 10.7994" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 6.06592H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</a>
	</div>
	<div class="mt-[21px] flex w-full h-[205px] bg-gray-100">
		<?php
		$SQL_QUERY = 	'SELECT 
							A.*
						FROM 
							' . $Tname . 'comm_banner A
						WHERE 
							A.STR_SERVICE="Y"
							AND A.INT_GUBUN=11
							AND A.INT_TYPE=1
						LIMIT 1';

		$rent_b_result = mysql_query($SQL_QUERY);
		$rent_b_Data = mysql_fetch_assoc($rent_b_result);
		?>
		<img class="min-w-full object-cover" src="/admincenter/files/bann/<?= $rent_b_Data['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="rentnew">
	</div>
	<div class="mt-[13px] flex px-[14px]">
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

			$rent_new_product_result = mysql_query($SQL_QUERY);
			while ($row = mysql_fetch_assoc($rent_new_product_result)) {
			?>
				<a href="/m/product/detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="item">
					<div class="flex justify-center items-center w-[126px] h-[126px] p-2.5 bg-[#F9F9F9] rounded">
						<img class="w-full" src="/admincenter/files/good/<?= $row['STR_IMAGE1q'] ?>" onerror="this.style.display = 'none'" alt="rent">
					</div>
					<p class="brand"><?= $row['STR_CODE'] ?></p>
					<p class="title line-clamp-1"><?= $row['STR_GOODNAME'] ?></p>
					<div class="price-section">
						<p class="current-price"><span class="text-[#00402F]"><?= $row['INT_DISCOUNT'] ? $row['INT_DISCOUNT'] . '%' : '' ?></span><span class="font-medium">일</span> <?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원</p>
					</div>
					<button class="rent-button">렌트</button>
				</a>
			<?php
			}
			?>
		</div>
	</div>
</div>

<!-- 구독 신규 입고 -->
<div class="subscriptionnew">
	<div class="sub-section-top-bar px-[14px]">
		<div class="left-section">
			<p class="title">구독 신규 입고</p>
			<p class="description">실시간으로 업데이트되는 상품을 만나보세요</p>
		</div>
		<a href="/m/product/index.php?product_type=1" class="right-section">
			<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.76416 1.13379L14.3332 6.0661L8.76416 10.7994" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
				<path d="M14.3332 6.06592H0.402588" stroke="black" stroke-width="1.08396" stroke-miterlimit="10" />
			</svg>
		</a>
	</div>
	<div class="mt-[21px] flex w-full h-[205px] bg-gray-100">
		<?php
		$SQL_QUERY = 	'SELECT 
							A.*
						FROM 
							' . $Tname . 'comm_banner A
						WHERE 
							A.STR_SERVICE="Y"
							AND A.INT_GUBUN=11
							AND A.INT_TYPE=2
						LIMIT 1';

		$sub_b_result = mysql_query($SQL_QUERY);
		$sub_b_Data = mysql_fetch_assoc($sub_b_result);
		?>
		<img class="min-w-full object-cover" src="/admincenter/files/bann/<?= $sub_b_Data['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="subscriptionnew">
	</div>

	<div class="mt-[13px] flex px-[14px]">
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

			$subscription_new_product_result = mysql_query($SQL_QUERY);
			while ($row = mysql_fetch_assoc($subscription_new_product_result)) {
			?>
				<a href="/m/product/detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="item">
					<div class="flex justify-center items-center w-[126px] h-[126px] p-2.5 bg-[#F9F9F9] rounded">
						<img class="w-full" src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="rent">
					</div>
					<p class="brand"><?= $row['STR_CODE'] ?></p>
					<p class="title line-clamp-1"><?= $row['STR_GOODNAME'] ?></p>
					<?php
					if (!$subscription_membership_Data) {
					?>
						<div class="price-section">
							<p class="current-price"><span class="font-medium">월</span> <?= number_format($site_Data['INT_OPRICE1']) ?>원</p>
						</div>
					<?php
					}
					?>
					<button class="subscription-button">구독</button>
				</a>
			<?php
			}
			?>
		</div>
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
	<div class="mt-[19.46px] grid grid-cols-3 gap-[1px] w-full bg-white">
		<?php
		$SQL_QUERY =    'SELECT A.*
						FROM 
							' . $Tname . 'comm_banner A
						WHERE 
							A.STR_SERVICE="Y"
							AND A.INT_GUBUN=12
						LIMIT 9';

		$review_banner_list_result = mysql_query($SQL_QUERY);

		while ($row = mysql_fetch_assoc($review_banner_list_result)) {
		?>
			<a href="<?= $row['STR_URL1'] ?>" class="w-full min-h-[130px] flex bg-gray-100">
				<img class="object-cover object-center" src="/admincenter/files/bann/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display='none'" alt="review">
			</a>
		<?php
		}

		for ($i = 0; $i < 9 - mysql_num_rows($review_banner_list_result); $i++) {
		?>
			<div class="w-full min-h-[130px] flex bg-gray-100">
			</div>
		<?php
		}
		?>
	</div>
	<a href="/m/review/index.php" class="mt-[21px] w-[225px] h-[38px] flex justify-center items-center bg-white border-[0.5px] border-solid border-[#DDDDDD]">
		<p class="font-bold text-[11px] leading-[12px]">더 많은 리뷰 보러가기</p>
	</a>
</div>

<?php
$show_footer_hbutton = true;
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>