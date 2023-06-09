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

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

	<link rel="styleSheet" href="/pub/css/dhtml_calendar.css">
	<script src="/admincenter/js/common.js"></script>
	<script src="/pub/js/CommScript.js"></script>
	<script src="/pub/js/dhtml_calendar.js"></script>

	<script src="https://cdn.tailwindcss.com"></script>
	<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
</head>

<body class="w-full max-w-[410px] overflow-hidden" style="display: none;">
	<!-- <link rel="stylesheet" href="/m/css/sidenav.min.css" type="text/css"> -->
	<link rel="stylesheet" href="/m/css/font-awesome.min.css">

	<div class="header-mobile max-w-[410px]">
		<?php
		$int_number = Fnc_Om_Conv_Default($_REQUEST['int_number'], '');

		$SQL_QUERY =    'SELECT
							A.*
						FROM 
							' . $Tname . 'comm_event AS A
						WHERE
							A.STR_SERVICE="Y"
						ORDER BY A.DTM_INDATE DESC
						LIMIT 1';

		$arr_Rlt_Data = mysql_query($SQL_QUERY);
		$event_Data = mysql_fetch_assoc($arr_Rlt_Data);
		?>
		<a href="/m/eventzone/event_detail.php?int_number=<?= $event_Data['INT_NUMBER'] ?>" class="flex items-center justify-center h-[37.58px] px-4 bg-black">
			<p class="font-bold text-[13px] leading-[15px] text-white line-clamp-1"><?= $event_Data['STR_TITLE'] ?></p>
		</a>
		<?php
		if (!$hide_header) {
		?>
			<div class="header-content">
				<div class="body">
					<a href="/m/main/" class="logo-title font-normal text-xl leading-[30px] text-black">ABLANC</a>
					<div class="menu">
						<a href="/m/mine/question/index.php">
							<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M9.5 15.1818C14.1941 15.1818 18 11.7363 18 7.81967C18 3.90308 14.1941 1 9.5 1C4.80587 1 1 4.17482 1 8.09141C1 9.62006 1.58012 11.0365 2.56719 12.1937L1.53125 17L5.692 14.4327C6.89767 14.9318 8.19266 15.1866 9.5 15.1818Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
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
		}
		?>
	</div>

	<script language="javascript">
		window.addEventListener('load', function() {
			var bodyElement = document.body;
			bodyElement.style.display = 'block';
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
	<div id="wrapper" style="<?= $search_menu ? 'margin-top: 102.58px;' : '' ?><?= $hide_header ? 'margin-top: 38.58px;' : '' ?>">