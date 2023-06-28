<!DOCTYPE html>
<html lang="en" class="flex justify-center">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi">
	<title>에이블랑_ABLANC</title>

	<meta name="description" content="구찌, 샤넬, 생로랑 등 21개 브랜드, 700개 명품을 무제한 이용하는 명품 구독 서비스">
	<meta name="Keywords" content="명품대여, 에이블랑, 가방렌탈, 명품가방대여, 명품가방렌탈, 가방대여, 율럽, 명품렌탈, 명품백대여, 명품백렌탈, ABLANC, 명품가방렌트, 에이블랑후기, 명품구독, 명품가방구독">
	<meta property="og:type" content="website">
	<meta property="og:title" content="에이블랑_명품구독서비스">
	<meta property="og:description" content="구찌, 샤넬, 생로랑 등 21개 브랜드, 700개 명품을 무제한 이용하는 명품 구독 서비스">
	<meta property="og:url" content="http://www.ablanc.co.kr">

	<link rel="shortcut icon" type="image/x-icon" href="/images/common/favicon.png" />

	<link href="/m/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="/m/css/swiper.min.css">
	<script src="/m/js/swiper.min.js"></script>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<script src="//code.jquery.com/jquery-1.12.4.js"></script>
	<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

	<link rel="styleSheet" href="/pub/css/dhtml_calendar.css">
	<script src="/admincenter/js/common.js"></script>
	<script src="/pub/js/CommScript.js"></script>
	<script src="/pub/js/dhtml_calendar.js"></script>

	<script src="//cdn.tailwindcss.com"></script>
	<script defer src="//cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
	<script>
		tailwind.config = {
			theme: {
				extend: {
					animation: {
						marqueeLeft: 'marqueeLeft 25s linear infinite',
						marqueeLeft2: 'marqueeLeft2 25s linear infinite',
						marqueeRight: 'marqueeRight 25s linear infinite',
						marqueeRight2: 'marqueeRight2 25s linear infinite',
					},
					keyframes: {
						marqueeLeft: {
							'0%': {
								transform: 'translateX(0%)'
							},
							'100%': {
								transform: 'translateX(-100%)'
							},
						},
						marqueeLeft2: {
							'0%': {
								transform: 'translateX(100%)'
							},
							'100%': {
								transform: 'translateX(0%)'
							},
						},
						marqueeRight: {
							'0%': {
								transform: 'translateX(0%)'
							},
							'100%': {
								transform: 'translateX(100%)'
							},
						},
						marqueeRight2: {
							'0%': {
								transform: 'translateX(-100%)'
							},
							'100%': {
								transform: 'translateX(0%)'
							},
						},
					},
				}
			}
		}
	</script>
</head>

<body class="w-full max-w-[410px] overflow-hidden">
	<!-- <link rel="stylesheet" href="/m/css/sidenav.min.css" type="text/css"> -->
	<link rel="stylesheet" href="/m/css/font-awesome.min.css">

	<div class="header-mobile max-w-[410px]" style="<?= $header_title ? 'border: none;' : '' ?>">
		<?php
		$int_number = Fnc_Om_Conv_Default($_REQUEST['int_number'], '');

		$SQL_QUERY =    'SELECT
							A.*
						FROM 
							' . $Tname . 'comm_event AS A
						WHERE
							A.STR_SERVICE="Y"
						ORDER BY A.DTM_INDATE DESC';

		$event_list_result = mysql_query($SQL_QUERY);
		?>
		<div x-data="{
				scrollHeight: 37.58,
				eventCount: 3,
				slider: 1,
				init() {
					setInterval(() => {
						this.eventCount = this.$refs.scrollContainer.children.length;
						
						if (this.slider + 1 > this.eventCount) {
							this.slider = 1;
						} else {
							this.slider++;
						}
						this.$refs.scrollContainer.scrollTo({
							top: (this.slider - 1) * this.scrollHeight,
							behavior: 'smooth'
						});
					}, 4000);
				}
			}" class="flex flex-col w-full h-[37.58px] px-4 bg-black overflow-y-auto event-popup" x-ref="scrollContainer">
			<?php
			while ($row = mysql_fetch_assoc($event_list_result)) {
			?>
				<a href="/m/eventzone/detail.php?int_number=<?= $row['INT_NUMBER'] ?>" class="flex-none">
					<div class="flex justify-center items-center w-full h-[37.58px]">
						<p class="font-bold text-[13px] leading-[15px] text-white text-center line-clamp-1"><?= $row['STR_TITLE'] ?></p>
					</div>
				</a>
			<?php
			}
			?>
		</div>
		<?php
		if (!$hide_header) {
		?>
			<div class="header-content">
				<div class="body">
					<a href="/m/main/" class="logo-title font-normal text-xl leading-[30px] text-black">ABLANC</a>
					<div class="menu">
						<a href="/m/mine/question/index.php">
							<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M9.5 15.1818C4.80587 15.1818 1 11.7363 1 7.81967C1 3.90308 4.80587 1 9.5 1C14.1941 1 18 4.17482 18 8.09141C18 9.62006 17.4199 11.0365 16.4328 12.1937L17.4688 17L13.308 14.4327C12.1023 14.9318 10.8073 15.1866 9.5 15.1818Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</a>
						<a href="/m/mine/basket/index.php">
							<svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M17.5385 0H1.46154C1.07391 0 0.702166 0.153246 0.428075 0.426026C0.153983 0.698807 0 1.06878 0 1.45455V14.5455C0 14.9312 0.153983 15.3012 0.428075 15.574C0.702166 15.8468 1.07391 16 1.46154 16H17.5385C17.9261 16 18.2978 15.8468 18.5719 15.574C18.846 15.3012 19 14.9312 19 14.5455V1.45455C19 1.06878 18.846 0.698807 18.5719 0.426026C18.2978 0.153246 17.9261 0 17.5385 0ZM17.5385 14.5455H1.46154V1.45455H17.5385V14.5455ZM13.8846 4.36364C13.8846 5.52095 13.4227 6.63085 12.6004 7.44919C11.7781 8.26753 10.6629 8.72727 9.5 8.72727C8.33713 8.72727 7.22188 8.26753 6.39961 7.44919C5.57733 6.63085 5.11538 5.52095 5.11538 4.36364C5.11538 4.17075 5.19238 3.98577 5.32942 3.84938C5.46647 3.71299 5.65234 3.63636 5.84615 3.63636C6.03997 3.63636 6.22584 3.71299 6.36289 3.84938C6.49993 3.98577 6.57692 4.17075 6.57692 4.36364C6.57692 5.13518 6.88489 5.87511 7.43307 6.42067C7.98126 6.96624 8.72475 7.27273 9.5 7.27273C10.2752 7.27273 11.0187 6.96624 11.5669 6.42067C12.1151 5.87511 12.4231 5.13518 12.4231 4.36364C12.4231 4.17075 12.5001 3.98577 12.6371 3.84938C12.7742 3.71299 12.96 3.63636 13.1538 3.63636C13.3477 3.63636 13.5335 3.71299 13.6706 3.84938C13.8076 3.98577 13.8846 4.17075 13.8846 4.36364Z" fill="black" />
							</svg>
						</a>
					</div>
				</div>
				<div class="menu">
					<a href="/m/main/" class="px-[7px] pb-2.5 text-sm leading-[15px] <?= $topmenu == 1 ? 'font-bold text-black border-b-[1.5px] border-black' : 'font-medium text-[#666666]'; ?>">홈</a>
					<a href="/m/product/index.php?product_type=2" class="px-[7px] pb-2.5 text-sm leading-[15px] <?= $topmenu == 2 ? 'font-bold text-black border-b-[1.5px] border-black' : 'font-medium text-[#666666]'; ?>">명품렌트</a>
					<a href="/m/product/index.php?product_type=1" class="px-[7px] pb-2.5 text-sm leading-[15px] <?= $topmenu == 3 ? 'font-bold text-black border-b-[1.5px] border-black' : 'font-medium text-[#666666]'; ?>">명품구독</a>
					<a href="/m/product/index.php?product_type=3" class="px-[7px] pb-2.5 text-sm leading-[15px] <?= $topmenu == 4 ? 'font-bold text-black border-b-[1.5px] border-black' : 'font-medium text-[#666666]'; ?>">중고명품</a>
					<a href="/m/eventzone/index.php" class="px-[7px] pb-2.5 text-sm leading-[15px] <?= $topmenu == 5 ? 'font-bold text-black border-b-[1.5px] border-black' : 'font-medium text-[#666666]'; ?>">이벤트존</a>
				</div>
			</div>
			<?php
		} else {
			if ($header_title) {
			?>
				<div class="flex flex-row items-center gap-5 px-3 py-[13px] w-full bg-white">
					<a href="javascript:history.back();">
						<svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M6.41475 14.2576L0.202765 7.81002C0.129032 7.73327 0.0769276 7.65012 0.0464514 7.56057C0.0154837 7.47102 0 7.37507 0 7.27273C0 7.17038 0.0154837 7.07444 0.0464514 6.98489C0.0769276 6.89534 0.129032 6.81218 0.202765 6.73543L6.41475 0.268649C6.58679 0.0895498 6.80184 0 7.05991 0C7.31797 0 7.53917 0.0959463 7.7235 0.287839C7.90783 0.479731 8 0.703606 8 0.959463C8 1.21532 7.90783 1.43919 7.7235 1.63109L2.30415 7.27273L7.7235 12.9144C7.89555 13.0935 7.98157 13.314 7.98157 13.576C7.98157 13.8385 7.8894 14.0657 7.70507 14.2576C7.52074 14.4495 7.30568 14.5455 7.05991 14.5455C6.81413 14.5455 6.59908 14.4495 6.41475 14.2576Z" fill="black" />
						</svg>
					</a>
					<p class="font-extrabold text-xl leading-[23px] text-black"><?= $header_title ?></p>
				</div>
		<?php
			}
		}
		?>
	</div>

	<script language="javascript">
		window.addEventListener('load', function() {
			// var bodyElement = document.body;
			// bodyElement.style.display = 'block';
		});

		$(function() {
			$('#mypage_pop').hide();
			$('.top_mypage .icn').click(function() {
				$('#mypage_pop').show();
				$('html').css('overflow-y', 'hidden').css('height', '100%');
				$('body').css('overflow-y', 'hidden').css('height', '100%');
			});


			$('#mypage_pop .close_mypage').click(function() {
				$('#mypage_pop').hide();
				$('html').css('overflow-y', 'auto').css('height', 'auto');
				$('body').css('overflow-y', 'auto').css('height', 'auto');
			});
		});
	</script>

	<script src="/m/js/sidenav.js"></script>
	<script>
		$(function() {
			var responsiveWidth = 300;
			var _widthResize;

			$(window).resize(function() {
				_widthResize = $(this).width() > responsiveWidth;
			}).resize();

			$('.navBox >ul >li').hover(function() {
				if (_widthResize) {
					var _this = $(this);
					_this.addClass('active').children('.dropNav').stop(true, true).slideDown(300);
				}
			}, function() {
				if (_widthResize) {
					$(this).removeClass('active').children('.dropNav').stop(true, true).hide();
				}
			});

			$('.dropNav').parent('li').click(function(e) {
				if (!_widthResize) {
					$(this).children('.dropNav').stop(true, true).slideToggle(300);
					e.preventDefault();
				}
			});

			$("#openPageslide").sideNav();

		});
	</script>
	<?php
	$margin_top = 0;
	if ($search_menu) {
		$margin_top = 102.58;
	} else if ($hide_header) {
		if ($header_title) {
			$margin_top = 87.58;
		} else {
			$margin_top = 38.58;
		}
	} else {
		$margin_top = 122.58;
	}
	?>
	<div id="wrapper" style="margin-top: <?= $margin_top ?>px;">