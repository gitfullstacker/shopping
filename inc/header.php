<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>에이블랑_ABLANC</title>
<meta name="description" content="샤넬, 디올, 셀린느, 구찌 등 명품 브랜드, 1000개 이상의 명품 구독 서비스">
<meta name="Keywords" content="명품대여, 명품렌트, 에이블랑, 가방렌탈, 명품가방대여, 명품가방렌탈, 가방대여, 율럽, 명품렌탈, 명품백대여, 명품백렌탈, ABLANC, 명품가방렌트, 에이블랑후기, 명품구독, 명품가방구독">
<meta property="og:type" content="website">
<meta property="og:title" content="에이블랑_명품렌트서비스">
<meta property="og:description" content="샤넬, 디올, 셀린느, 구찌 등 명품 브랜드, 1000개 이상의 명품 구독 서비스">
<meta name="naver-site-verification" content="56446fd32b606721bf9fdd9ede276db36e2e9ef3"/>
<meta property="og:url" content="https://www.ablanc.co.kr">
 
<link rel="shortcut icon" type="image/x-icon" href="/images/common/favicon.png" />
<link type="text/css" rel="stylesheet" href="/css/style.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
		//$( "#search_menu" ).toggle( selectedEffect, options, 500 );
		//	$(".search_close").click(function(){
		//		$("#search_menu").hide();
		//	});
		//};
	 
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
				<h1 class="logo"><a href="/main/"><img src="/images/common/logo.png" alt style="width: 160px; " /></a></h1>
				<div class="util_sns">
					<a href="https://www.instagram.com/ablanc_lookbook" target="_blank"><img src="/images/common/btn_instagram.png" alt="" /></a>
				</div>
				<p class="top_search"><a href="/search/search.php" target="_blank"><img id="button" src="/images/common/btn_top_search.png" alt="" /></a>
				</p>
				<div class="util_menu">
					<a href="/cscenter/bestreview.php">후기</a>
					<?if ($arr_Auth[0]=="") {?>
					<?
					if ($loc_I_Pg_Fol=="/memberjoin/") {
						$str_Url=urlencode("/main/index.php");
					} else {
						$str_Url=urlencode($_SERVER["SCRIPT_NAME"] . "?" . $_SERVER["QUERY_STRING"]);
					}
					?>
					<a href="/memberjoin/login.php?loc=<?=$str_Url?>">로그인</a>
					<a href="/memberjoin/join.php">회원가입</a>
					<?}else{?>
					<a href="/mypage/membership.php">구독권</a>
					<a href="/memberjoin/logout.php">로그아웃</a>
					<a href="/mypage/get.php">마이페이지</a>
					<?}?>
				</div>
				<p class="top_search"><a href="/search/search.php"><img id="button" src="/images/common/btn_top_search.png" alt="" /></a></p>
			</div>		
<div class="gnb">
				<ul>
					<li ><a href="/category/list.php">ALL</a></li>
					<li><a href="/category/list.php?Txt_bcode=030110001">NEW</a></li>
					<li><a href="/category/list.php?Txt_bcode=030210001">SMALL</a></li>
					<li><a href="/category/list.php?Txt_bcode=030310001">MEDIUM</a></li>
					<li><a href="/category/list.php?Txt_bcode=030410001">LARGE</a></li>
					<li><a href="/category/list.php?Txt_bcode=030510001">CLUTCH</a></li>
					
				</ul>
			</div>
			
		</div>
		<!-- //header -->
		<!--search-->
		<div id="search_menu">
			<div class="bg_search_menu"></div>
			<form id="frmTT" name="frmTT" target="_self" method="POST" action="/search/search.php" onSubmit="return fnc_total();">
				<div class="search_inbx">		
					<div class="search_border">
						<input type="text" name="Txt_word" class="inp_search" /> 
						<input type="image" class="btn_search" src="/images/common/btn_top_search02.png"/>
					</div>		
				</div>
				<p class="search_close"><img src="/images/common/btn_serch_close.png" alt="" /></p>
			</form>
		</div>
		<!--//search-->
		<!-- STATICMENU -->
		<link type="text/css" rel="stylesheet" href="/css/unit_wing_banner.css" />
		<script type="text/javascript" src="/js/unit_wing_banner.js"></script>
		
		<div id="STATICMENU">
			<div id="fix_rt_menu" class="fix_rt_menu">
				<div class="rt_section03"></div>
				<div class="rt_btn" style="left:-31px; top:1px;position:absolute;cursor:pointer;"><img src="/images/common/close_btn.gif" alt="" /></div>
				<div class="STATICMENU_con">
					<div class="q_menu">
						<p class="mypage"><a href="/mypage/my_qna.php">마이페이지</a></p>
						<p><a href="/cscenter/guide.php">이용방법</a></p>
						<p><a href="/mypage/membership.php">구독권 정보</a></p>
						<p><a href="/category/list.php">교환</a></p>
						<p><a href="/mypage/return.php">반납</a></p>
						<p><a href="/mypage/get.php">가방 내역</a></p>
						<p><a href="/mypage/stocked.php">입고알림 가방</a></p>
						<p><a href="/mypage/like.php">좋아요 가방</a></p>
						<p><a href="/mypage/stamp.php">내 스탬프</a></p>
						<p><a href="/mypage/user_info.php">개인 정보</a></p>
						<p><a href="/cscenter/csyong.php">고객센터</a></p>
					
				
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
		</div>
		<!-- //STATICMENU -->