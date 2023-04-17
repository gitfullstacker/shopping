<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi">
	<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	<title>ABLANC</title>
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	<link rel="shortcut icon" type="image/x-icon" href="/images/common/favicon.png" />


	<link href="../css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/swiper.min.css">
	<script src="../js/swiper.min.js"></script>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<!-- jquery.mobilemenu -->
	<link href="../css/jquery.mobilemenu.css" type="text/css" rel="stylesheet" />
	<script src="../js/jquery.mobilemenu.js" type="text/javascript"></script>
	<script src="../js/main.js" type="text/javascript"></script>
	
	<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
	<script>
	  $( function() {
		// run the currently selected effect
		function runEffect() {
		  // get effect type from
		  var selectedEffect = $( "#effectTypes" ).val();
	 
		  // Most effect types need no options passed by default
		  var options = {};
		  // some effects have required parameters
		  if ( selectedEffect === "scale" ) {
			options = { percent: 50 };
		  } else if ( selectedEffect === "size" ) {
			options = { to: { width: 200, height: 60 } };
		  }
	 
		  // Run the effect
		  $( "#search_menu" ).toggle( selectedEffect, options, 500 );
		};
	 
		// Set effect from select menu value
		$( "#button" ).on( "click", function() {
		  runEffect();
		});
	  } );
	</script>
	
	<link rel="styleSheet" href="/pub/css/dhtml_calendar.css">
	<script src="/admincenter/js/common.js"></script>
	<script src="/pub/js/CommScript.js"></script>
	<script src="/pub/js/dhtml_calendar.js"></script>

</head>

<body>
	<div id="header">
		<h1><a href="/m/main/"><img src="../images/logo.gif" alt="" /></a></h1>
		<p class="top_search"><button id="button" class="ui-state-default ui-corner-all icn" ><span class="screen_hide">검색</span></button></p>
		<p class="top_menu demoLink slide_nav"><a class="demoLink slide_nav" href="javascript:"><span class="icon2 icn"><span class="screen_hide">Menu</span></span></a></p>
		<p class="top_mypage"><span class="icon3 icn"><span class="screen_hide">마이페이지</span></span></p>
	</div>

 
	<!--search-->
	<div id="search_menu">
		<form action="/m/search/search.php"> 
			<div>		
				<input type="text" /> 
				<input type="image" title="검색" src="../images/btn_top_search02.png" />		
			</div>
		</form>
	</div>
	<!--//search-->

	<div id="mypage_pop" style="display:none;">
		<div class="mypage_w">
			<p class="pop_tit">마이페이지</p>
			<a href="#;" class="btn close_mypage"><img src="../images/btn_pop_close.png" alt="마이페이지닫기" /></a>
			<ul class="mypage_menu">
				<li><a href="/m/mypage/membership.php"><i class="icn icn_membership"></i><span>멤버십 정보</span></a></li>
				<li><a href="/m/category/list.php"><i class="icn icn_return"></i><span>교환</span></a></li>
				<li><a href="/m/mypage/return.php"><i class="icn icn_return"></i><span>반납</span></a></li>
				<li><a href="/m/mypage/request.php"><i class="icn icn_request"></i><span>가방 요청</span></a></li>
				<li><a href="/boad/bd_free/m2m/egolist.php?bd=2"><i class="icn icn_review"></i><span>내가 쓴 이용후기</span></a></li>
				<li><a href="/m/mypage/stamp.php"><i class="icn icn_stamp"></i><span>내 스탬프</span></a></li>
				<li><a href="/m/mypage/user_info.php"><i class="icn icn_userinfo"></i><span>개인정보</span></a></li>
				<li><a href="/m/mypage/my_qna.php"><i class="icn icn_qna"></i><span>문의하기(Q&A)</span></a></li>
			</ul>
			<div class="my_bag_w">
				<script type="text/javascript">
					$(function () {	
						tab('#tab');	
					});

					function tab(e){	
						
						var menu = $(e).children();
						var con = $(e+'_con').children();
						
						var select = $(menu).first();
						var i = 0;
						
						menu.click(function(){				
							if(select!==null){					// 활성화 된 탭메뉴 닫기
								select.removeClass("on");
								con.eq(i).hide();
							}
							
							select = $(this);					// 새 메뉴 index 받기
							i = $(this).index();
							
							select.addClass('on');				// 새 탭메뉴 활성화
							con.eq(i).show();				
						});
						
					}
				</script>
				<ul id="tab">
					<li class="on">GET한 가방</li>
					<li>좋아요 가방</li>
					<li>입고알림가방</li>
				</ul>
				<div class="tab_con" id="tab_con">
					<div>
						1<br />1<br />1<br />1<br />1<br />1<br />1<br />1<br />1<br />1<br />1<br />1<br />1<br />
					</div>
					<div style="display:none;">22222
					</div>
					<div style="display:none;">3333333
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<script language="javascript">
		$(function(){
			$('#mypage_pop').hide();
			$('.top_mypage .icn').click(function(){
				$('#mypage_pop').show();
				$('html').css('overflow-y','hidden').css('height','100%');
				$('body').css('overflow-y','hidden').css('height','100%');
			});
			$('#mypage_pop .close_mypage').click(function(){
				$('#mypage_pop').hide();
				$('html').css('overflow-y','auto').css('height','auto');
				$('body').css('overflow-y','auto').css('height','auto');
			});
		});
	</script>

	<div id="wrapper" >
		<div class="m_ctgr">
			<div class="topmenu">
				
				<div class="slider1">
					<div class="slide"><a href="/m/category/list.php" class="on">ALL</a></div>
					<div class="slide"><a href="#;">NEW</a></div>
					<div class="slide"><a href="#;">SMALL</a></div>
					<div class="slide"><a href="#;">MEDIUM</a></div>
					<div class="slide"><a href="#;">LARGE</a></div>
					<div class="slide"><a href="#;">CLUTCH</a></div>
				</div>
			</div>
			<script type="text/javascript" src="../../js/jquery.bxslider.js"></script>
			<link type="text/css" rel="stylesheet" href="../../css/jquery.bxslider.css" />
			<script type="text/javascript">
				$(document).ready(function(){
					$('.slider1').bxSlider({
						slideWidth:'integer',
						moveSlides:5,
						infiniteLoop:false,
						pager:false
					});
				});
			</script>
		</div>
		