<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi">
	<title>ABLANC</title>
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	<link rel="shortcut icon" type="image/x-icon" href="/images/common/favicon.png" />


	<link href="/m/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="/m/css/swiper.min.css">
	<script src="/m/js/swiper.min.js"></script>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
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
	<link rel="stylesheet" href="/m/css/sidenav.min.css" type="text/css">
   
	<nav class="sidenav" data-sidenav data-sidenav-toggle="#sidenav-toggle">
		<div class="user_info">
			<a class="btn nav-home" href="/m/main/"><i class="icn"></i>홈</a>
			<div class="util_btn">
				<a class="btn nav-util" href="/boad/bd_free/m2/egolist.php?bd=2">후기</a>
				<?if ($arr_Auth[0]=="") {?>
				<a class="btn nav-util" href="/m/memberjoin/login.php?loc=<?=urlencode($_SERVER["SCRIPT_NAME"] . "?" . $_SERVER["QUERY_STRING"])?>">로그인</a>
				<a class="btn nav-util" href="/m/memberjoin/join.php">회원가입</a>
				<?}else{?>
				<a class="btn nav-util" href="/m/memberjoin/logout.php">로그아웃</a>
				<a class="btn nav-util" href="/m/mypage/membership.php">멤버십</a>
				<?}?>
			</div>
		</div>
		<div class="left_menu01">
			<ul>
				<li><a href="/m/mypage/get.php"><i class="icn icn_get"></i><span>GET한 가방</span></a></li>
				<li><a href="/m/mypage/return.php"><i class="icn icn_return"></i><span>반납</span></a></li>
				<li><a href="/m/cscenter/guide.php"><i class="icn icn_faq"></i><span>이용 방법</span></a></li>
			</ul>
		</div>
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
							.$Tname."b_bd_data".$str_Ini_Group_Table."` AS A
							LEFT JOIN `"
							.$Tname."b_img_data".$str_Ini_Group_Table."` AS C
							ON
							A.CONF_SEQ=C.CONF_SEQ
							AND
							A.BD_SEQ=C.BD_SEQ
							AND
							C.IMG_ALIGN=1
							LEFT JOIN `"
							.$Tname."b_file_data".$str_Ini_Group_Table."` AS D
							ON
							A.CONF_SEQ=D.CONF_SEQ
							AND
							A.BD_SEQ=D.BD_SEQ
							AND
							D.FILE_ALIGN=1
						WHERE ";
			$Sql_Query .= " A.CONF_SEQ=1 AND ";
			$Sql_Query .= " A.BD_ID_KEY IS NOT NULL ";
			$Sql_Query .= " ORDER BY
										BD_ORDER DESC ";
			$Sql_Query.="limit 1";
		
			$arr_Get_Data1= mysql_query($Sql_Query);
			if(!$arr_Get_Data1) {
			 	error("QUERY_ERROR");
			 	exit;
			}
			$arr_Get_Data_Cnt1=mysql_num_rows($arr_Get_Data1);
		?>
		<div class="left_event">
			<?
				for($int_I = 0 ;$int_I < $arr_Get_Data_Cnt1; $int_I++) {
			?>
				<span class="tit">EVENT</span>
				<a href="/boad/bd_news/m1/egoread.php?bd=<?=mysql_result($arr_Get_Data1,$int_I,conf_seq)?>&seq=<?=mysql_result($arr_Get_Data1,$int_I,bd_seq)?>">
				<?
					// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
					//	= 비공개글 표시 아이콘 변수에 저장 시작
					$str_Tmp = "";
					If (mysql_result($arr_Get_Data1,$int_I,bd_open_yn)>0) {
						$str_Tmp = "<img src='".$str_Board_Icon_Img."ic_key.gif' border='0' align='absMiddle'> ";
					}
					//	= 비공개글 표시 아이콘 변수에 저장 종료
					// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				?>
				<?=$str_Tmp?>
				<?
					// ========================
					//	= 메모글 갯수 출력 시작
					If (mysql_result($arr_Get_Data1,$int_I,bd_memo_cnt)>0) {
						echo " (<img src='".$str_Board_Icon_Img."ic_memo.gif' align='absMiddle' border='0'> " . mysql_result($arr_Get_Data1,$int_I,bd_memo_cnt) . ") ";
					}
					//	= 메모글 갯수 출력 종료
					// ========================
					
					$str_Tmp = mb_strimwidth(stripslashes(mysql_result($arr_Get_Data1,$int_I,bd_title)),0,80,"...","utf-8");
				?>
				<?=$str_Tmp?>
				</a>
			<?
				}
			?>
			<?
				for($int_J = $int_I ;$int_J < 1; $int_J++) {
			?>
			<li>
				<span class="tit">&nbsp;</span>
				<a href="#">&nbsp;</a>
			</li>
			<?
				}
			?>	
		</div>
		<ul class="left_menu02">
			<li><a href="/m/category/list.php">ALL</a></li>
			<li><a href="/m/category/list.php?Txt_bcode=030110001">NEW</a></li>
			<li><a href="/m/category/list.php?Txt_bcode=030210001">SMALL</a></li>
			<li><a href="/m/category/list.php?Txt_bcode=030310001">MEDIUM</a></li>
			<li><a href="/m/category/list.php?Txt_bcode=030410001">LARGE</a></li>
			<li><a href="/m/category/list.php?Txt_bcode=030510001">CLUTCH</a></li>
			<li><a href="/m/category/list.php?Txt_bcode=030610001">WEDDING</a></li>
		</ul>
		<ul class="sidenav-menu">
			<li id="top2-menu1">
				<a href="javascript:;" data-sidenav-dropdown-toggle>
					<span class="sidenav-link-title">마이페이지</span>
					<span class="sidenav-dropdown-icon show" data-sidenav-dropdown-icon>
						<i class="material-icons"><img src="/m/images/bg_leftmenu_blet.png" alt="" /></i>
					</span>
					<span class="sidenav-dropdown-icon" data-sidenav-dropdown-icon>
						<i class="material-icons"><img src="/m/images/bg_leftmenu_blet02.png" alt="" /></i>
					</span>
				</a>

				<ul class="sidenav-dropdown" data-sidenav-dropdown>
					<li><a href="/m/mypage/my_qna.php">- 문의하기(Q&A)</a></li>
					<li><a href="/m/mypage/return.php">- 반납</a></li>
					<li><a href="/m/mypage/get.php">- GET한 가방</a></li>
					<li><a href="/m/mypage/stocked.php">- 입고알림 가방</a></li>
					<li><a href="/m/mypage/like.php">- 좋아요 가방</a></li>
					<li><a href="/m/mypage/request.php">- 가방 요청 </a></li>
					<li><a href="/boad/bd_free/m2m/egolist.php?bd=2">- 내가 쓴 이용후기</a></li>
					<li><a href="/m/mypage/stamp.php">- 내 스탬프 </a></li>
					<li><a href="/m/mypage/membership.php">- 멤버십 정보</a></li>
					<li><a href="/m/mypage/user_info.php">- 개인정보</a></li>
				</ul>
			</li>
			<li id="top2-menu2">
				<a href="javascript:;" data-sidenav-dropdown-toggle>
					<span class="sidenav-link-title">고객센터</span>
					<span class="sidenav-dropdown-icon show" data-sidenav-dropdown-icon>
						<i class="material-icons"><img src="/m/images/bg_leftmenu_blet.png" alt="" /></i>
					</span>
					<span class="sidenav-dropdown-icon" data-sidenav-dropdown-icon>
						<i class="material-icons"><img src="/m/images/bg_leftmenu_blet02.png" alt="" /></i>
					</span>
				</a>

				<ul class="sidenav-dropdown" data-sidenav-dropdown>
					<li><a href="/m/cscenter/guide.php">- 이용방법  </a></li>
					<li><a href="/m/cscenter/faq.php">- 자주하는 질문  </a></li>
					<li><a href="/m/mypage/my_qna.php">- 문의하기</a></li>
					<li><a href="/boad/bd_free/m2/egolist.php?bd=2">- 이용후기 </a></li>
					<li><a href="/boad/bd_news/m1/egolist.php?bd=1">- 공지사항 </a></li>
					<li><a href="/m/cscenter/today.php">- 최근 본 가방 </a></li>
				</ul>
			</li>
		</ul>
	</nav>

	
	<script src="/m/js/sidenav.min.js"></script>
	<script>$('[data-sidenav]').sidenav();</script>
	<div id="header">
		<h1><a href="/m/main/"><img src="/m/images/logo.gif" alt="" /></a></h1>
		<p class="top_search"><button id="button" class="ui-state-default ui-corner-all icn" ><span class="screen_hide">검색</span></button></p>
		<!-- <p class="top_menu demoLink slide_nav"><a class="demoLink slide_nav" href="javascript:"><span class="icon2 icn"><span class="screen_hide">Menu</span></span></a></p> -->
		<p class="top_menu"><a href="javascript:;" class="toggle" id="sidenav-toggle"><span class="icon2 icn"><span class="screen_hide">Menu</span></span></a></p>
		<p class="top_mypage"><span class="icon3 icn"><span class="screen_hide">마이페이지</span></span></p>
	</div>

 
	<!--search-->
	<div id="search_menu">
		<form id="frmTT" name="frmTT" target="_self" method="POST" action="/m/search/search.php" onSubmit="return fnc_total();">
			<div>		
				<input type="text" name="Txt_word" /> 
				<input type="image" title="검색" src="/m/images/btn_top_search02.png" />		
			</div>
		</form>
	</div>
	<!--//search-->

	<div id="mypage_pop" style="display:none;">
		<div class="mypage_w">
			<p class="pop_tit">마이페이지</p>
			<a href="#;" class="btn close_mypage"><img src="/m/images/btn_pop_close.png" alt="마이페이지닫기" /></a>
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
				<link rel="stylesheet" href="/m/css/swiper.min.css">
				<style>
					.swiper-container {
						width: 100%;
						height: 100%;
					}
					.swiper-slide {
						text-align: center;
						width: auto;
						/* Center slide text vertically */
						display: -webkit-box;
						display: -ms-flexbox;
						display: -webkit-flex;
						display: flex;
						-webkit-box-pack: center;
						-ms-flex-pack: center;
						-webkit-justify-content: center;
						justify-content: center;
						-webkit-box-align: center;
						-ms-flex-align: center;
						-webkit-align-items: center;
						align-items: center;
					}
					.swiper-slide:last-child {
						margin-right:30px;
					}
				</style>
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><a href="/m/category/list.php"<?if ($Txt_bcode=="") {?> class="on"<?}?>>ALL</a></div>
						<div class="swiper-slide"><a href="/m/category/list.php?Txt_bcode=030110001"<?if ($Txt_bcode=="030110001") {?> class="on"<?}?>>NEW</a></div>
						<div class="swiper-slide"><a href="/m/category/list.php?Txt_bcode=030210001"<?if ($Txt_bcode=="030210001") {?> class="on"<?}?>>SMALL</a></div>
						<div class="swiper-slide"><a href="/m/category/list.php?Txt_bcode=030310001"<?if ($Txt_bcode=="030310001") {?> class="on"<?}?>>MEDIUM</a></div>
						<div class="swiper-slide"><a href="/m/category/list.php?Txt_bcode=030410001"<?if ($Txt_bcode=="030410001") {?> class="on"<?}?>>LARGE</a></div>
						<div class="swiper-slide"><a href="/m/category/list.php?Txt_bcode=030510001"<?if ($Txt_bcode=="030510001") {?> class="on"<?}?>>CLUTCH</a></div>
						<div class="swiper-slide"><a href="/m/category/list.php?Txt_bcode=030610001"<?if ($Txt_bcode=="030610001") {?> class="on"<?}?>>WEDDING</a></div>
					</div>
					 <!-- Add Arrows -->
					 <div class="swiper-button-next"></div>
				</div>
				<script src="/m/js/swiper.min.js"></script>
				<script>
					var swiper = new Swiper('.swiper-container', {
						pagination: '.swiper-pagination',
						slidesPerView: 'auto',
						paginationClickable: true,
						nextButton: '.swiper-button-next',
						spaceBetween: 0
					});
				</script>
				
				
			</div>
		</div>
		