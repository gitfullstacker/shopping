<!DOCTYPE html>
<html lang="en">

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
	<script>
		$(function() {
			// run the currently selected effect
			function runEffect() {
				// get effect type from
				var selectedEffect = $("#effectTypes").val();

				// Most effect types need no options passed by default
				var options = {};
				// some effects have required parameters
				if (selectedEffect === "scale") {
					options = {
						percent: 50
					};
				} else if (selectedEffect === "size") {
					options = {
						to: {
							width: 200,
							height: 60
						}
					};
				}

				// Run the effect
				$("#search_menu").toggle(selectedEffect, options, 500);
			};

			// Set effect from select menu value
			$("#button").on("click", function() {
				runEffect();
			});
		});
	</script>

	<link rel="styleSheet" href="/pub/css/dhtml_calendar.css">
	<script src="/admincenter/js/common.js"></script>
	<script src="/pub/js/CommScript.js"></script>
	<script src="/pub/js/dhtml_calendar.js"></script>

	<script src="https://cdn.tailwindcss.com"></script>
	<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
</head>

<body>
	<!-- <link rel="stylesheet" href="/m/css/sidenav.min.css" type="text/css"> -->
	<link rel="stylesheet" href="/m/css/font-awesome.min.css">

	<div class="header-mobile">
		<div class="header-alert">
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
			<script type="text/javascript" src="/js/jquery.bxslider.js"></script>
			<link type="text/css" rel="stylesheet" href="/css/jquery.bxslider.css" />
			<ul class="bxslider">
				<?
				for ($int_I = 0; $int_I < $arr_Get_Data_Cnt5; $int_I++) {
				?>
					<li>
						<a href="/boad/bd_news/m1/egoread.php?bd=<?= mysql_result($arr_Get_Data5, $int_I, conf_seq) ?>&seq=<?= mysql_result($arr_Get_Data5, $int_I, bd_seq) ?>">

							<?
							// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
							//	= 비공개글 표시 아이콘 변수에 저장 시작
							$str_Tmp = "";
							if (mysql_result($arr_Get_Data5, $int_I, bd_open_yn) > 0) {
								$str_Tmp = "<img src='" . $str_Board_Icon_Img . "ic_key.gif' border='0' align='absMiddle' style='width:12px;height:14px;'> ";
							}
							//	= 비공개글 표시 아이콘 변수에 저장 종료
							// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
							?>
							<?= $str_Tmp ?>
							<?
							// ========================
							//	= 메모글 갯수 출력 시작
							if (mysql_result($arr_Get_Data5, $int_I, bd_memo_cnt) > 0) {
								echo " (<img src='" . $str_Board_Icon_Img . "ic_memo.gif' align='absMiddle' border='0'> " . mysql_result($arr_Get_Data5, $int_I, bd_memo_cnt) . ") ";
							}
							//	= 메모글 갯수 출력 종료
							// ========================

							$str_Tmp = mb_strimwidth(stripslashes(mysql_result($arr_Get_Data5, $int_I, bd_title)), 0, 80, "...", "utf-8");
							?>
							<?= $str_Tmp ?>
						</a>
					</li>
				<?
				}
				?>
			</ul>
			<script type="text/javascript">
				$(document).ready(function() {
					$('.bxslider').bxSlider({
						auto: true,
						controls: false,
						pager: false,
						mode: 'vertical',
					});
				});
			</script>
		</div>
		<?php
		if (!$hide_header) {
		?>
			<div class="header-content">
				<div class="body">
					<a href="/m/main/" class="logo-text">ABLANC</a>
					<div class="menu">
						<div>
							<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M9.5 15.1818C14.1941 15.1818 18 11.7363 18 7.81967C18 3.90308 14.1941 1 9.5 1C4.80587 1 1 4.17482 1 8.09141C1 9.62006 1.58012 11.0365 2.56719 12.1937L1.53125 17L5.692 14.4327C6.89767 14.9318 8.19266 15.1866 9.5 15.1818Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
						<a href="/m/mycart/">
							<svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M17.5385 0H1.46154C1.07391 0 0.702166 0.153246 0.428075 0.426026C0.153983 0.698807 0 1.06878 0 1.45455V14.5455C0 14.9312 0.153983 15.3012 0.428075 15.574C0.702166 15.8468 1.07391 16 1.46154 16H17.5385C17.9261 16 18.2978 15.8468 18.5719 15.574C18.846 15.3012 19 14.9312 19 14.5455V1.45455C19 1.06878 18.846 0.698807 18.5719 0.426026C18.2978 0.153246 17.9261 0 17.5385 0ZM17.5385 14.5455H1.46154V1.45455H17.5385V14.5455ZM13.8846 4.36364C13.8846 5.52095 13.4227 6.63085 12.6004 7.44919C11.7781 8.26753 10.6629 8.72727 9.5 8.72727C8.33713 8.72727 7.22188 8.26753 6.39961 7.44919C5.57733 6.63085 5.11538 5.52095 5.11538 4.36364C5.11538 4.17075 5.19238 3.98577 5.32942 3.84938C5.46647 3.71299 5.65234 3.63636 5.84615 3.63636C6.03997 3.63636 6.22584 3.71299 6.36289 3.84938C6.49993 3.98577 6.57692 4.17075 6.57692 4.36364C6.57692 5.13518 6.88489 5.87511 7.43307 6.42067C7.98126 6.96624 8.72475 7.27273 9.5 7.27273C10.2752 7.27273 11.0187 6.96624 11.5669 6.42067C12.1151 5.87511 12.4231 5.13518 12.4231 4.36364C12.4231 4.17075 12.5001 3.98577 12.6371 3.84938C12.7742 3.71299 12.96 3.63636 13.1538 3.63636C13.3477 3.63636 13.5335 3.71299 13.6706 3.84938C13.8076 3.98577 13.8846 4.17075 13.8846 4.36364Z" fill="black" />
							</svg>
						</a>
					</div>
				</div>
				<div class="menu">
					<a href="/m/main/" class="menu-item <?= $topmenu == 1 ? 'active' : ''; ?>">홈</a>
					<a href="/m/product/index.php?product_type=1" class="menu-item <?= $topmenu == 2 ? 'active' : ''; ?>">명품렌트</a>
					<a href="/m/product/index.php?product_type=2" class="menu-item <?= $topmenu == 3 ? 'active' : ''; ?>">명품구독</a>
					<a href="/m/product/index.php?product_type=3" class="menu-item <?= $topmenu == 4 ? 'active' : ''; ?>">홈중고명품</a>
					<a href="/boad/bd_news/m1/egolist.php?bd=3&itm=&txt=&pg=1" class="menu-item <?= $topmenu == 5 ? 'active' : ''; ?>">이벤트존</a>
				</div>
			</div>
		<?php
		}
		?>
	</div>

	<!-- hidden by kkk -->
	<div id="header" style="display: none;">
		<div class="head01">
			<h1><a href="/m/main/"><img src="/m/images/logo.gif" alt="" /></a></h1>
			<!-- <p class="top_search"><button id="button" class="ui-state-default ui-corner-all icn" ><span class="screen_hide">검색</span></button></p> -->
			<p class="top_search"><a href="/m/search/search.php" class="ui-state-default ui-corner-all icn"><span class="screen_hide">검색</span></a></p>
			<p class="top_menu"><a href="#pageslide" id="openPageslide"><span class="icon2 icn"><span class="screen_hide">Menu</span></span></a></p>
			<p class="top_mypage"><span class="icon3 icn"><span class="screen_hide">마이페이지</span></span></p>
		</div>
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
						margin-right: 30px;
					}
				</style>
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><a href="/m/category/list.php" <? if ($Txt_bcode == "") { ?> class="on" <? } ?>>ALL</a></div>
						<div class="swiper-slide"><a href="/m/category/list.php?Txt_bcode=030110001" <? if ($Txt_bcode == "030110001") { ?> class="on" <? } ?>>NEW</a></div>
						<div class="swiper-slide"><a href="/m/category/list.php?Txt_bcode=030210001" <? if ($Txt_bcode == "030210001") { ?> class="on" <? } ?>>SMALL</a></div>
						<div class="swiper-slide"><a href="/m/category/list.php?Txt_bcode=030310001" <? if ($Txt_bcode == "030310001") { ?> class="on" <? } ?>>MEDIUM</a></div>
						<div class="swiper-slide"><a href="/m/category/list.php?Txt_bcode=030410001" <? if ($Txt_bcode == "030410001") { ?> class="on" <? } ?>>LARGE</a></div>
						<div class="swiper-slide"><a href="/m/category/list.php?Txt_bcode=030510001" <? if ($Txt_bcode == "030510001") { ?> class="on" <? } ?>>CLUTCH</a></div>

					</div>
					<!-- Add Arrows -->

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
	</div>

	<div id="mypage_pop" style="display:none;">
		<div class="mypage_w">
			<p class="pop_tit">마이페이지</p>
			<a href="#;" class="btn close_mypage"><img src="/m/images/btn_pop_close.png" alt="마이페이지닫기" /></a>
			<ul class="mypage_menu">
				<li><a href="/m/mypage/membership.php"><i class="icn icn_membership"></i><span>구독권 정보</span></a></li>
				<li><a href="/m/category/list.php"><i class="icn icn_return"></i><span>교환</span></a></li>
				<li><a href="/m/mypage/return.php"><i class="icn icn_return2"></i><span>반납</span></a></li>
				<li><a href="/m/mypage/get.php"><i class="icn icn_request"></i><span>가방 내역</span></a></li>
				<li><a href="/boad/bd_free/m2m/egolist.php?bd=2"><i class="icn icn_review"></i><span>내가 쓴 이용후기</span></a></li>
				<li><a href="/m/mypage/stamp.php"><i class="icn icn_stamp"></i><span>내 스탬프</span></a></li>
				<li><a href="/m/mypage/user_info.php"><i class="icn icn_userinfo"></i><span>개인정보</span></a></li>
				<li><a href="/m/cscenter/csyong.php"><i class="icn icn_qna"></i><span>고객센터</span></a></li>
			</ul>
			<div class="my_bag_w">
				<script type="text/javascript">
					$(function() {
						tab('#tab');
					});

					function tab(e) {

						var menu = $(e).children();
						var con = $(e + '_con').children();

						var select = $(menu).first();
						var i = 0;

						menu.click(function() {
							if (select !== null) { // 활성화 된 탭메뉴 닫기
								select.removeClass("on");
								con.eq(i).hide();
							}

							select = $(this); // 새 메뉴 index 받기
							i = $(this).index();

							select.addClass('on'); // 새 탭메뉴 활성화
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
					<? if ($arr_Auth[0] == "") { ?>
						<div class="center mt20">로그인하시면 <br />GET한가방의 <br />정보를 보실 수 있습니다.</div>

						<div style="display:none;" class="center mt20">로그인하시면 <br />좋아요가방의 <br />정보를 보실 수 있습니다.</div>
						<div style="display:none;" class="center mt20">로그인하시면 <br />입고알림가방의 <br />정보를 보실 수 있습니다.</div>
					<? } else { ?>
						<div>
							<?
							$SQL_QUERY =	" SELECT
										A.*,B.*,C.STR_URL1,D.STR_CODE
									FROM "
								. $Tname . "comm_goods_cart AS A
										INNER JOIN
										" . $Tname . "comm_goods_master AS B
										ON
										A.STR_GOODCODE=B.STR_GOODCODE
										LEFT JOIN 
										" . $Tname . "comm_com_code AS C 
										ON 
										A.INT_DELICODE=C.INT_NUMBER 
										AND 
										C.STR_SERVICE='Y' 
										LEFT JOIN
										" . $Tname . "comm_com_code D
										ON
										B.INT_BRAND=D.INT_NUMBER
									WHERE
										A.INT_STATE IN ('1','2','3','4') AND STR_USERID='$arr_Auth[0]' ORDER BY A.DTM_INDATE DESC LIMIT 1 ";

							$arr_my1_Data = mysql_query($SQL_QUERY);
							if (!$arr_my1_Data) {
								echo 'Could not run query: ' . mysql_error();
								exit;
							}
							$arr_m1_Data = mysql_fetch_assoc($arr_my1_Data);
							?>
							<? if ($arr_m1_Data["INT_NUMBER"] != "") { ?>

								<div class="get_img">

									<? if (!($arr_m1_Data["STR_IMAGE3"] == "")) { ?>
										<li><img src="/admincenter/files/good/<?= $arr_m1_Data["STR_IMAGE3"] ?>" border="0"></li>
									<? } ?>
								</div>
								<dl class="detail_name mt40">
									<dt><?= $arr_m1_Data['STR_EGOODNAME'] ?></dt>
									<dd>RETAIL <?= number_format($arr_m1_Data['INT_PRICE']) ?>원</dd>
								</dl>
								<div class="center btn_w">
									<? if ($arr_m1_Data["INT_STATE"] == "1") { ?>
										<a href="javascript:MClick_Cancel('<?= $arr_m1_Data["INT_NUMBER"] ?>');" class="btn btn_l btn_bk w30p f_bd">GET 취소</a>
									<? } ?>
									<? if ($arr_m1_Data["INT_STATE"] == "3") { ?>
										<a href="<? if ($arr_m1_Data["STR_DELICODE"] != "") { ?><?= str_replace("__INVOICENO__", $arr_m1_Data["STR_DELICODE"], $arr_m1_Data["STR_URL1"]) ?><? } else { ?>#<? } ?>" <? if ($arr_m1_Data["STR_DELICODE"] != "") { ?> target="_blank" <? } ?> class="btn btn_l btn_bk w30p f_bd">배송조회</a>
									<? } ?>
									<? if ($arr_m1_Data["INT_STATE"] == "4") { ?>
										<a href="/m/mypage/return.php" class="btn btn_l btn_bk w30p f_bd">반납하기</a>
									<? } ?>
									<div style="text-align:center; padding-top:50px;"> 정기권 이용 시, 한 가방은 최대 3개월까지 이용가능합니다. </br> 구독권 종료예정인 경우 종료일 전 반납 부탁드립니다.</br></br>
									</div>
									<p><a href="/m/mypage/get.php" class="btn btn_readmore mt05">가방 구독 내역</a></p>
								</div>
							<? } else { ?>
								<div class="center mt60">내역이 없습니다.</div>
							<? } ?>
						</div>
						<!-- 좋아요가방 -->
						<div style="display:none;">
							<?
							$SQL_QUERY = "select a.*,e.str_code,(select b.str_bcode from " . $Tname . "comm_goods_master_category b where a.str_goodcode=b.str_goodcode limit 1) as str_bcode,(select ifnull(count(b.str_userid),0) as cnt from " . $Tname . "comm_member_like b where b.str_goodcode=a.str_goodcode) as likecnt,(select ifnull(count(d.str_userid),0) as cnt from " . $Tname . "comm_goods_cart d where d.str_goodcode=a.str_goodcode and d.str_userid='" . $arr_Auth[0] . "' and d.int_state in ('4')) as cartcnt 
												from 
													" . $Tname . "comm_goods_master a inner join " . $Tname . "comm_member_like b on a.str_goodcode=b.str_goodcode and b.str_userid='$arr_Auth[0]' left join " . $Tname . "comm_com_code e on a.int_brand=e.int_number 
												where 
													a.str_goodcode is not null and (a.str_service='Y' or a.str_service='R') 
												order by 
													a.int_sort desc limit 4";

							$arr_my2_Data = mysql_query($SQL_QUERY);
							if (!$arr_my2_Data) {
								echo 'Could not run query: ' . mysql_error();
								exit;
							}
							$arr_m2_Data_Cnt = mysql_num_rows($arr_my2_Data);
							?>
							<? if ($arr_m2_Data_Cnt) { ?>
								<ul class="new_list mt15" id="labData2">
									<?
									for ($int_I = 0; $int_I < $arr_m2_Data_Cnt; $int_I++) {
									?>
										<li>
											<? if (fnc_cart_info(mysql_result($arr_my2_Data, $int_I, str_goodcode)) == 0) { ?><span class="rented">RENTED</span><? } ?>
											<p class="zzim_icn"><img src="../images/icn_zzim_on.png" alt="" /> <?= mysql_result($arr_my2_Data, $int_I, likecnt) ?></p>
											<a href="/m/category/detail.php?Txt_bcode=<?= mysql_result($arr_my2_Data, $int_I, str_bcode) ?>&str_no=<?= mysql_result($arr_my2_Data, $int_I, str_goodcode) ?>">
												<p><? if (mysql_result($arr_my2_Data, $int_I, str_image1) != "") { ?><img src="/admincenter/files/good/<?= mysql_result($arr_my2_Data, $int_I, str_image1) ?>" border="0"><? } else { ?>&nbsp;<? } ?></p>
												<dl>
													<dt><?= mysql_result($arr_my2_Data, $int_I, str_code) ?></dt>
													<dd><?= mysql_result($arr_my2_Data, $int_I, str_egoodname) ?></dd>
												</dl>
											</a>
										</li>
									<?
									}
									?>
								</ul>
								<p><a href="/m/mypage/like.php" class="btn btn_readmore">수정/삭제 하러가기</a></p>
							<? } else { ?>
								<div class="center mt20" style="padding-bottom:40px;">내역이 없습니다.</div>
							<? } ?>
						</div>
						<!-- //좋아요가방 -->
						<!-- 입고알림가방 -->
						<div style="display:none;">
							<?
							$SQL_QUERY = "select a.*,e.str_code,(select b.str_bcode from " . $Tname . "comm_goods_master_category b where a.str_goodcode=b.str_goodcode limit 1) as str_bcode,(select ifnull(count(b.str_userid),0) as cnt from " . $Tname . "comm_member_like b where b.str_goodcode=a.str_goodcode) as likecnt,(select ifnull(count(b.int_number),0) as cnt from " . $Tname . "comm_member_alarm b where b.str_goodcode=a.str_goodcode) as alarmcnt 
												from 
													" . $Tname . "comm_goods_master a inner join " . $Tname . "comm_member_alarm b on a.str_goodcode=b.str_goodcode and b.str_userid='$arr_Auth[0]' left join " . $Tname . "comm_com_code e on a.int_brand=e.int_number 
												where 
													a.str_goodcode is not null and (a.str_service='Y' or a.str_service='R') 
												order by 
													a.int_sort desc limit 3";

							$arr_my3_Data = mysql_query($SQL_QUERY);
							if (!$arr_my3_Data) {
								echo 'Could not run query: ' . mysql_error();
								exit;
							}
							$arr_m3_Data_Cnt = mysql_num_rows($arr_my3_Data);
							?>
							<? if ($arr_m3_Data_Cnt) { ?>
								<ul class="new_list mt15">
									<?
									for ($int_I = 0; $int_I < $arr_m3_Data_Cnt; $int_I++) {
									?>
										<li>
											<? if (fnc_cart_info(mysql_result($arr_my3_Data, $int_I, str_goodcode)) == 0) { ?><span class="rented">RENTED</span><? } ?>
											<p class="zzim_icn"><img src="../images/icn_zzim_on.png" alt="" /> <?= mysql_result($arr_my3_Data, $int_I, likecnt) ?></p>
											<a href="/m/category/detail.php?Txt_bcode=<?= mysql_result($arr_my3_Data, $int_I, str_bcode) ?>&str_no=<?= mysql_result($arr_my3_Data, $int_I, str_goodcode) ?>">
												<p><? if (mysql_result($arr_my3_Data, $int_I, str_image1) != "") { ?><img src="/admincenter/files/good/<?= mysql_result($arr_my3_Data, $int_I, str_image1) ?>" border="0"><? } else { ?>&nbsp;<? } ?></p>
												<dl>
													<dt><?= mysql_result($arr_my3_Data, $int_I, str_code) ?></dt>
													<dd><?= mysql_result($arr_my3_Data, $int_I, str_egoodname) ?></dd>
												</dl>
											</a>
										</li>
									<?
									}
									?>
								</ul>
								<p><a href="/m/mypage/stocked.php" class="btn btn_readmore">수정/삭제 하러가기</a></p>
							<? } else { ?>
								<div class="center mt20" style="padding-bottom:40px;">내역이 없습니다.</div>
							<? } ?>
						</div>
						<!-- //입고알림가방 -->
					<? } ?>
				</div>
			</div>

		</div>
	</div>
	<script language="javascript">
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

	<div id="pageslide" class="navBox">
		<div class="user_info">
			<a class="btn nav-home" href="/m/main/"><i class="icn"></i></a>
			<div class="util_btn">
				<a class="btn nav-util" style="padding-top: 1px;" href="/bestreview.php">후기</a>
				<? if ($arr_Auth[0] == "") { ?>
					<a class="btn nav-util" style="padding-top: 1px;" href="/m/memberjoin/login.php?loc=<?= urlencode($_SERVER["SCRIPT_NAME"] . "?" . $_SERVER["QUERY_STRING"]) ?>">로그인</a>
					<a class="btn nav-util" style="padding-top: 1px;" href="/m/memberjoin/join.php">회원가입</a>
				<? } else { ?>
					<a class="btn nav-util" style="padding-top: 1px;" href="/m/memberjoin/logout.php">로그아웃</a>
					<a class="btn nav-util" style="padding-top: 1px;" href="/m/mypage/membership.php">구독권</a>
				<? } ?>
			</div>
		</div>
		<div class="left_menu01">
			<ul>
				<li><a href="/m/mypage/return.php"><i class="icn icn_return"></i><span>반납</span></a></li>
				<li><a href="/m/cscenter/csyong.php"><i class="icn icn_cscenter"></i><span>고객센터</span></a></li>
				<li><a href="/m/cscenter/guideyong.php"><i class="icn icn_faq"></i><span>이용 방법</span></a></li>
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
		$Sql_Query .= "limit 1";

		$arr_Get_Data1 = mysql_query($Sql_Query);
		if (!$arr_Get_Data1) {
			error("QUERY_ERROR");
			exit;
		}
		$arr_Get_Data_Cnt1 = mysql_num_rows($arr_Get_Data1);
		?>
		<div class="left_event">
			<?
			for ($int_I = 0; $int_I < $arr_Get_Data_Cnt1; $int_I++) {
			?>
				<span class="tit">NOTICE</span>
				<a href="/boad/bd_news/m1/egoread.php?bd=<?= mysql_result($arr_Get_Data1, $int_I, conf_seq) ?>&seq=<?= mysql_result($arr_Get_Data1, $int_I, bd_seq) ?>">
					<?
					// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
					//	= 비공개글 표시 아이콘 변수에 저장 시작
					$str_Tmp = "";
					if (mysql_result($arr_Get_Data1, $int_I, bd_open_yn) > 0) {
						$str_Tmp = "<img src='" . $str_Board_Icon_Img . "ic_key.gif' border='0' align='absMiddle'> ";
					}
					//	= 비공개글 표시 아이콘 변수에 저장 종료
					// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
					?>
					<?= $str_Tmp ?>
					<?
					// ========================
					//	= 메모글 갯수 출력 시작
					if (mysql_result($arr_Get_Data1, $int_I, bd_memo_cnt) > 0) {
						echo " (<img src='" . $str_Board_Icon_Img . "ic_memo.gif' align='absMiddle' border='0'> " . mysql_result($arr_Get_Data1, $int_I, bd_memo_cnt) . ") ";
					}
					//	= 메모글 갯수 출력 종료
					// ========================

					$str_Tmp = mb_strimwidth(stripslashes(mysql_result($arr_Get_Data1, $int_I, bd_title)), 0, 80, "...", "utf-8");
					?>
					<?= $str_Tmp ?>
				</a>
			<?
			}
			?>
			<?
			for ($int_J = $int_I; $int_J < 1; $int_J++) {
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

		</ul>
		<div class="left_menu03">
			<div class="nm mypage_nm" id="mypage_nm"><a href="#mypage_nm">마이페이지</a></div>
			<ul class="dropNav01">
				<li><a href="/m/mypage/membership.php">- 구독권 정보</a></li>
				<li><a href="/m/category/list.php">- 교환</a></li>
				<li><a href="/m/mypage/return.php">- 반납</a></li>
				<li><a href="/m/mypage/get.php">- GET한 가방</a></li>
				<li><a href="/m/mypage/stocked.php">- 입고알림 가방</a></li>
				<li><a href="/m/mypage/like.php">- 좋아요 가방</a></li>
				<li><a href="/boad/bd_free/m2m/egolist.php?bd=2">- 내가 쓴 이용후기</a></li>
				<li><a href="/m/mypage/stamp.php">- 내 스탬프 </a></li>
				<li><a href="/m/mypage/user_info.php">- 개인정보</a></li>
			</ul>
		</div>


		<script>
			$(document).ready(function() {
				$(".mypage_nm").click(function() {
					$(".dropNav01").toggle();
				});
				$(".cscenter_nm").click(function() {
					$(".dropNav02").toggle();
				});
			});
		</script>

	</div>
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