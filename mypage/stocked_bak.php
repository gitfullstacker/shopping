<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   입고 알림 가방</p>
					<div class="lnb_tab mt10">
						<ul>
							<li><a href="get.php">GET한 가방</a></li>
							<li><a href="return.php">반납</a></li>
							<li class="on"><a href="stocked.php">입고 알림 가방</a></li>
							<li><a href="request.php">가방요청</a></li>
							<li><a href="membership.php">멤버십 정보</a></li>
							<li><a href="like.php">좋아요 가방</a></li>
							<li><a href="stamp.php">내 스탬프</a></li>
							<li><a href="my_qna.php">문의하기(Q&amp;A)</a></li>
							<li><a href="my_review.php">내가 쓴 이용후기</a></li>
							<li><a href="user_info.php">개인정보</a></li>
						</ul>
					</div>
					
					<div class="tit_h2_2 mt45">입고 알림 가방</div>
					<p class="tit_desc mt20">고객님께서 입고 알림 신청을 한 가방들입니다. </p>

					<div class="mypage_img_w mypage_img_w02 mt40">
						<script type="text/javascript" src="../js/jquery.bxslider.js"></script>
						<link type="text/css" rel="stylesheet" href="../css/jquery.bxslider.css" />
						<ul class="bxslider">
							<li>
								<div class="mypage_txt01">
									<p class="tit">현재 입고알림 대기자 <span class="f_ylw">2명</span>이 있습니다.</p>
									
								</div>
								<p class="bx_img mt45"><a href="#;"><img src="../images/sub/item01.jpg" class="img_bd" style="width:698px;height:698px;" /></a></p>
								<p class="bx_tit"><a href="#;">샤넬 2.55 클래식 M</a></p>
								<div class="bx_btn mt35">
									<a href="#;" class="btn btn_l btn_bk w w270 f_bd">입고알림 취소</a>
								</div>
							</li>
							<li>
								<div class="mypage_txt01">
									<p class="tit">현재 입고알림 대기자 <span class="f_ylw">2명</span>이 있습니다.</p>
									
								</div>
								<p class="bx_img mt45"><a href="#;"><img src="../images/sub/item01.jpg" class="img_bd" style="width:698px;height:698px;" /></a></p>
								<p class="bx_tit"><a href="#;">샤넬 2.55 클래식 M</a></p>
								<div class="bx_btn mt35">
									<a href="#;" class="btn btn_l btn_bk w w270 f_bd">입고알림 취소</a>
								</div>
							</li>
							<li>
								<div class="mypage_txt01">
									<p class="tit">현재 입고알림 대기자 <span class="f_ylw">2명</span>이 있습니다.</p>
									
								</div>
								<p class="bx_img mt45"><a href="#;"><img src="../images/sub/item01.jpg" class="img_bd" style="width:698px;height:698px;" /></a></p>
								<p class="bx_tit"><a href="#;">샤넬 2.55 클래식 M</a></p>
								<div class="bx_btn mt35">
									<a href="#;" class="btn btn_l btn_bk w w270 f_bd">입고알림 취소</a>
								</div>
							</li>
							<li>
								<div class="mypage_txt01">
									<p class="tit">현재 입고알림 대기자 <span class="f_ylw">2명</span>이 있습니다.</p>
									
								</div>
								<p class="bx_img mt45"><a href="#;"><img src="../images/sub/item01.jpg" class="img_bd" style="width:698px;height:698px;" /></a></p>
								<p class="bx_tit"><a href="#;">샤넬 2.55 클래식 M</a></p>
								<div class="bx_btn mt35">
									<a href="#;" class="btn btn_l btn_bk w w270 f_bd">입고알림 취소</a>
								</div>
							</li>
						</ul>

						<script type="text/javascript">
							$(document).ready(function(){
								$('.bxslider').bxSlider({
									mode: 'fade',
									captions: true
								});
							});
						</script>
					</div>
					
					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
