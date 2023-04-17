<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>ABLANC</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<link rel="shortcut icon" type="image/x-icon" href="/images/common/favicon.png" />
<link type="text/css" rel="stylesheet" href="/css/style.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script language="javascript" src="/js/common_gnb.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<link rel="styleSheet" href="/pub/css/dhtml_calendar.css">
<script src="/admincenter/js/common.js"></script>
<script src="/pub/js/CommScript.js"></script>
<script src="/pub/js/dhtml_calendar.js"></script>

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
			$(".search_close").click(function(){
				$("#search_menu").hide();
			});
		};
	 
		// Set effect from select menu value
		$( "#button" ).on( "click", function() {
		  runEffect();
		});
	  } );
	</script>
	<script type="text/javascript" src="/js/jquery.sumoselect.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
			window.test = $('.testsel').SumoSelect({okCancelInMulti:true });
		});
	</script>
</head>
<body onload="InitializeStaticMenu();">
	<div id="wrap">
		<!-- header -->
		<div id="header_w">
			<div class="top_bx01">
				<h1 class="logo"><a href="/main/index.php"><img src="/images/common/logo.png" alt="" /></a></h1>
				<div class="util_sns">
					<a href="#;"><img src="/images/common/btn_facebook.png" alt="" /></a>
					<a href="#;"><img src="/images/common/btn_instagram.png" alt="" /></a>
				</div>
				<div class="util_menu">
					<a href="/boad/bd_free/2/egolist.php?bd=2">후기</a>
					<?if ($arr_Auth[0]=="") {?>
					<a href="/memberjoin/login.php?loc=<?=urlencode($_SERVER["SCRIPT_NAME"] . "?" . $_SERVER["QUERY_STRING"])?>">로그인</a>
					<a href="/memberjoin/join.php">회원가입</a>
					<?}else{?>
					<a href="/mypage/membership.php">멥버십</a>
					<a href="/memberjoin/logout.php">로그아웃</a>
					<a href="/mypage/get.php">마이페이지</a>
					<?}?>
				</div>
				<p class="top_search"><img id="button" src="/images/common/btn_top_search.png" alt="" /></p>
			</div>		
			<div class="gnb">
				<ul>
					<li ><a href="/category/list.php">ALL</a></li>
					<li><a href="/category/list.php?Txt_bcode=030110001">NEW</a></li>
					<li><a href="/category/list.php?Txt_bcode=030210001">SMALL</a></li>
					<li><a href="/category/list.php?Txt_bcode=030310001">MEDIUM</a></li>
					<li><a href="/category/list.php?Txt_bcode=030410001">LARGE</a></li>
					<li><a href="/category/list.php?Txt_bcode=030510001">CLUTCH</a></li>
					<li><a href="/category/list.php?Txt_bcode=030610001">WEDDING</a></li>
				</ul>
			</div>
			
		</div>
		<!-- //header -->
		<!--search-->
		<div id="search_menu">
			<div class="bg_search_menu"></div>
			<form method="post" action="/search/search.php">
				<div class="search_inbx">		
					<div class="search_border">
						<input type="text" class="inp_search" /> 
						<input type="image" class="btn_search" src="/images/common/btn_top_search02.png"/>
					</div>		
				</div>
				<p class="search_close"><img src="/images/common/btn_serch_close.png" alt="" /></p>
			</form>
		</div>
		<!--//search-->
		<!-- STATICMENU -->
		
		<div id="STATICMENU">
			<!-- <p class="STATICMENU_open"><a href="#;">열기</a></p>
			<p class="STATICMENU_close"><a href="#">닫기</a></p> -->
			<div class="STATICMENU_con">
				<div class="q_menu">
					<p class="mypage"><a href="/mypage/my_qna.php">마이페이지</a></p>
					<p><a href="/cscenter/guide.php">이용방법</a></p>
					<p><a href="/cscenter/faq.php">자주묻는 질문</a></p>
					<p><a href="/mypage/my_qna.php">문의하기(Q&amp;A)</a></p>
					<p><a href="/mypage/return.php">반납</a></p>
					<p><a href="/mypage/get.php">GET한 가방</a></p>
					<p><a href="/mypage/stocked.php">입고알림 가방</a></p>
					<p><a href="/mypage/like.php">좋아요 가방</a></p>
					<p><a href="/mypage/request.php">가방 요청</a></p>
					<p><a href="/boad/bd_free/2m/egolist.php?bd=2">내가 쓴 이용후기</a></p>
					<p><a href="/mypage/stamp.php">내 스탬프</a></p>
					<p><a href="/mypage/membership.php">멤버십 정보</a></p>
					<p><a href="/mypage/user_info.php">개인 정보</a></p>
				</div>
				
				<div class="q_tit02" id="idView_Prod">
					<dl>
						<dt>최근본상품<span>2</span></dt>
						<dd>
							<p class="list_bx" style="height:190px;">
								<a href="#;"><img src="/images/main/ex01.jpg" alt="" style="width:85px;height:85px;" /></a>
								<a href="#;"><img src="/images/main/ex02.jpg" alt="" style="width:85px;height:85px;" /></a>
							</p>
							<p class="btn_bx">
								<a href="#;"><img src="/images/common/w_btn_p.gif" alt="" /></a>
								<a href="#;"><img src="/images/common/w_btn_n.gif" alt="" /></a>
							</p>
						</dd>
					</dl>
				</div>
			</div>
			
			<script language="javascript">
				fuc_set('/inc/quick_proc.php?RetrieveFlag=QUICK', '_Prod');
			</script>
		</div>
		<!-- //STATICMENU -->