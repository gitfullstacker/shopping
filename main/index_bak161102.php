<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>

	

		<div id="container">
			<script type="text/javascript" src="../js/swiper.min.js"></script>
			<link type="text/css" rel="stylesheet" href="../css/swiper.min.css" />
			<div class="main_visual">
				<style type="text/css">
					#mvisual01{background:url('../images/main/main_visual01.jpg') no-repeat 50% 0;}
					#mvisual02{background:url('../images/main/main_visual02.jpg') no-repeat 50% 0;}
					#mvisual03{background:url('../images/main/main_visual03.jpg') no-repeat 50% 0;}
					#mvisual04{background:url('../images/main/main_visual04.jpg') no-repeat 50% 0;}
					#mvisual05{background:url('../images/main/main_visual05.jpg') no-repeat 50% 0;}
				</style>
				<!-- Swiper --> 
				<div class="swiper-container"> 
					<div class="swiper-wrapper"> 
						<div class="swiper-slide" id="mvisual01"></div> 
						<div class="swiper-slide" id="mvisual02"></div> 
						<div class="swiper-slide" id="mvisual03"></div> 
						<div class="swiper-slide" id="mvisual04"></div> 
						<div class="swiper-slide" id="mvisual05"></div> 
					</div>  
					<!-- Add Pagination --> 
					<!-- <div class="swiper-pagination"></div>  -->
					<!-- Add Arrows --> 
					<div class="swiper-button-next"></div> 
					<div class="swiper-button-prev"></div> 
				</div> 
				<!-- Initialize Swiper --> 
				<script> 
					var swiper = new Swiper('.swiper-container', { 
						pagination: '.swiper-pagination', 
						paginationClickable: true, 
						nextButton: '.swiper-button-next', 
						prevButton: '.swiper-button-prev', 
						spaceBetween: 0,
						autoplay: 5000,
						loop: true
					}); 
				</script> 
			</div>
			<div class="main_event">
				<div class="contents_w">
					<div class="m_event_bx">
						<span class="m_event_tit"><img src="../images/main/tit_m_event.gif" alt="" /></span>
						<script type="text/javascript" src="../js/jquery.bxslider.js"></script>
						<link type="text/css" rel="stylesheet" href="../css/jquery.bxslider.css" />
						<ul class="bxslider">
							<li>
								<a href="#;">지금 가입하시면 첫 달은 무료로 이용 가능하세요!</a>
								<span>2016/09/08</span>
							</li>
							<li>
								<a href="#;">111지금 가입하시면 첫 달은 무료로 이용 가능하세요!</a>
								<span>2016/09/08</span>
							</li>
							<li>
								<a href="#;">222지금 가입하시면 첫 달은 무료로 이용 가능하세요!</a>
								<span>2016/09/08</span>
							</li>
						</ul>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$('.bxslider').bxSlider({
								auto: true,
								autoControls: true,
								mode: 'vertical',
								
							});
						});
					</script>

				</div>
			</div>
			
			<div class="main01">
				<div class="contents_w">
					
					<div class="main_tab mt45">
						<ul>
							<li class="on" id="n2tab-btn01"><a href="#;" onmouseover="tab_view2(1);">#이용절차&amp;상세서비스</a></li>
							<li id="n2tab-btn02"><a href="#;" onmouseover="tab_view2(2);">#취급브랜드</a></li>
							<li id="n2tab-btn03"><a href="#;" onmouseover="tab_view2(3);">#공지사항</a></li>
							<li id="n2tab-btn04"><a href="#;" onmouseover="tab_view2(4);">#Q&amp;A</a></li>
						</ul>
					</div>
					<div id="n2tab01">
						
						<h3 class="main_tit mt40"><span>이용절차 &amp; 상세서비스</span></h3>
						<ul class="use_guide01">
							<li>
								<p class="bg_img"><img src="../images/main/m_img01.jpg" alt="" /></p>
								<p class="dt"><span class="icn icn_r_bk">01</span>가방선택</p>
								<p class="dd">30초면 예약 완료!</p>
							</li>
							<li>
								<p class="bg_img"><img src="../images/main/m_img02.jpg" alt="" /></p>
								<p class="dt"><span class="icn icn_r_bk">02</span>가방사용</p>
								<p class="dd">생활기스 안전보험 포함<br />가방은 해외 매장 및 백화점에서 직접 구입한 100% 정품!</p>
							</li>
							<li class="last">
								<p class="bg_img"><img src="../images/main/m_img03.jpg" alt="" /></p>
								<p class="dt"><span class="icn icn_r_bk">03</span>교환</p>
								<p class="dd">원하는 가방으로 언제든지 교환 가능!<br />(왕복 배송비 월 2회 무료)</p>
							</li>
						</ul>
						<div id="fullgroup" style="display:none;">
							<div class="use_guide02">
								<dl>
									<dt><i><img src="../images/main/icn_use_guide01.gif" alt="" /></i>가방선택</dt>
									<dd>
										<ul>
											<li><i>01.</i> 회원가입을 한다.</li>
											<li><i>02.</i> 쇼핑을 한다.</li>
											<li><i>03.</i> 원하는 가방을 발견하고 GET 클릭!</li>
											<li><i>04.</i> 배송지 및 카드정보 입력 하면 GET 완료! <span>(카드정보 입력해도 바로 결제되지 않으며, 언제든 수정이</span> 가능하니 안심하고 이용하세요.)</li>
											<li><i>05.</i> 오전 11시 이전 GET 한 가방은 당일 출고! <span>(왕복배송비 무료)</span></li>
										</ul>
									</dd>
								</dl>
								<dl>
									<dt><i><img src="../images/main/icn_use_guide02.gif" alt="" /></i>가방사용</dt>
									<dd>
										<ul>
											<li><i>01.</i> 배송 온 박스는 잘 보관해 두고 가방을 소중히 사용한다.</li>
											<li><i>02.</i> 가방을 사용하지 않을 때에는 아이나 애완동물의 손이 <span>닿지 않는 곳에 보관한다.</span></li>
										</ul>
									</dd>
								</dl>
								<dl class="last">
									<dt><i><img src="../images/main/icn_use_guide03.gif" alt="" /></i>가방교환</dt>
									<dd>
										<ul>
											<li><i>01.</i> 사용하던 가방을 반납신청 한다.</li>
											<li><i>02.</i> 새로운 가방을 쇼핑한다.</li>
											<li><i>03.</i> 원하는 가방을 발견하고  [CHANGE] 를 클릭하면 끝! <span>반납신청을 하지 않은 상태로 CHANGE를 클릭하시면</span> CHANGE가 완료되지 못한 채 반납페이지로 이동합니다. <span>이 경우 반납신청 후 다시 CHANGE를 신청해주셔야 합니다.</span></li>
											<li><i>04.</i> 기존에 사용하던 가방의 반납승인이 완료되는 즉시 새로 선택한 가방 발송</li>
										</ul>
									</dd>
									<dt class="dt02"><i><img src="../images/main/icn_use_guide04.gif" alt="" /></i>반납방법</dt>
									<dd>
										<ul>
											<li><i>01.</i> 앱이나 홈페이지에서 [반납]을 클릭한다.</li>
											<li><i>02.</i> 반납방법과 날짜를 선택하면 반납신청 완료</li>
											<li><i>03.</i> 배송시 받은 박스에 가방을 다시 넣고 반품스티커를 <span>붙인다.</span></li>
											<li><i>04.</i> 선택한 날짜에 원하는 반납방법으로 반납하면 끝! <span>(왕복배송비 무료)</span></li>
										</ul>
									</dd>
								</dl>
							</div>
							
							<p class="group_view tit_fg02"><a href="#;"><img src="../images/main/btn_main_hidden.gif" alt="감추기" /></a></p>
						</div>
						<p class="group_view tit_fg"><a href="#;"><img src="../images/main/btn_main_more.gif" alt="더보기" /></a></p>
					
						<script language="javascript">
						$(function(){
							$('#fullgroup').hide();
							$('.tit_fg').click(function(){
								$('#fullgroup').show();
								$('#partgroup').hide();		
								$('.tit_fg').hide();
							});
							$('#fullgroup .tit_fg02').click(function(){
								$('#fullgroup').hide();
								$('#partgroup').show();		
								$('.tit_fg').show();
							});
						});

						</script>
					</div>
					<div id="n2tab02" style="display:none;">
						<h3 class="main_tit mt40"><span>취급브랜드</span></h3>
						<div class="m_brand">
							<div class="m_brand_in">
								<ul>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand01.gif" alt="" /></p></div>
										<div class="brand_name"><p>고야드</p></div>
										<i></i>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand02.gif" alt="" /></p></div>
										<div class="brand_name"><p>구찌</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand03.gif" alt="" /></p></div>
										<div class="brand_name"><p>끌로에</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand04.gif" alt="" /></p></div>
										<div class="brand_name"><p>디올</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand05.gif" alt="" /></p></div>
										<div class="brand_name"><p>로에베</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand06.gif" alt="" /></p></div>
										<div class="brand_name"><p>루이비통</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand07.gif" alt="" /></p></div>
										<div class="brand_name"><p>마르니</p></div>
									</li>

									
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand08.gif" alt="" /></p></div>
										<div class="brand_name"><p>마크제이콥스</p></div>
										<i></i>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand09.gif" alt="" /></p></div>
										<div class="brand_name"><p>멀버리</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand10.gif" alt="" /></p></div>
										<div class="brand_name"><p>미우미우</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand11.gif" alt="" /></p></div>
										<div class="brand_name"><p>발렌시아가</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand12.gif" alt="" /></p></div>
										<div class="brand_name"><p>발렌티노</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand13.gif" alt="" /></p></div>
										<div class="brand_name"><p>버버리</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand14.gif" alt="" /></p></div>
										<div class="brand_name"><p>보테가베네타</p></div>
									</li>

									
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand15.gif" alt="" /></p></div>
										<div class="brand_name"><p>생로랑</p></div>
										<i></i>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand16.gif" alt="" /></p></div>
										<div class="brand_name"><p>샤넬</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand17.gif" alt="" /></p></div>
										<div class="brand_name"><p>셀린느</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand18.gif" alt="" /></p></div>
										<div class="brand_name"><p>지방시</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand19.gif" alt="" /></p></div>
										<div class="brand_name"><p>토즈</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand20.gif" alt="" /></p></div>
										<div class="brand_name"><p>펜디</p></div>
									</li>
									<li>
										<div class="brand_logo"><p><img src="../images/main/m_brand21.gif" alt="" /></p></div>
										<div class="brand_name"><p>프라다</p></div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div id="n2tab03" style="display:none;">
						<h3 class="main_tit mt40"><span>공지사항</span></h3>
						<ul class="m_notice_list">
							<li>
								<a href="#;">
									<p><img src="../images/main/img_notice01.jpg" alt="" /></p>
									<dl>
										<dt>내달 7일부터 샤넬 등 해외명품 대전</dt>
										<dd class="con_txt">이번 명품 대전에선 총 30여개 명품 브랜드가 참여하며, 올해 가을 겨울(FW시)즌 신상품을 많이 확보하여 서비스 할 예정이며...</dd>
										<dd class="date">2016.08.10</dd>
									</dl>
								</a>
							</li>
							<li>
								<a href="#;">
									<p><img src="../images/main/img_notice02.jpg" alt="" /></p>
									<dl>
										<dt>‘은밀한 유혹의 시작’ 구찌 핸드백 출시</dt>
										<dd class="con_txt">이번 명품 대전에선 총 30여개 명품 브랜드가 참여하며, 올해 가을 겨울(FW시)즌 신상품을 많이 확보하여 서비스 할 예정이며 이번 명품 대전에선 총 30여개 명품 브랜드가 참여하며, 올해 가을 겨울(FW시)즌 신상품을 많이 확보하여 서비스 할 예정이며</dd>
										<dd class="date">2016.08.10</dd>
									</dl>
								</a>
							</li>
							<li class="nd3">
								<a href="#;">
									<p><img src="../images/main/img_notice03.jpg" alt="" /></p>
									<dl>
										<dt>루비이통, 잘나가는 브랜드의 탐나는 비밀</dt>
										<dd class="con_txt">이번 명품 대전에선 총 30여개 명품 브랜드가 참여하며, 올해 가을 겨울(FW시)즌 신상품을 많이 확보하여 서비스 할 예정이며...</dd>
										<dd class="date">2016.08.10</dd>
									</dl>
								</a>
							</li>
						</ul>
						<p class="group_view"><a href="#;"><img src="../images/main/btn_main_more.gif" alt="더보기" /></a></p>
					</div>
					<div id="n2tab04" style="display:none;">
						<h3 class="main_tit mt40"><span>Q&amp;A</span></h3>
					</div>
					<script type="text/javascript">
						<!--
						var tabcount = 4;
						function tab_view2(num){
						 for (i=1; i<=tabcount; i++) {
							var view_up = document.getElementById("n2tab0" + i);
							var view_up_btn = document.getElementById("n2tab-btn0" + i);
							if (i == num)
							 {
								 view_up.style.display = "";
								 view_up_btn.className = 'on';
							 }
							else
							 {
								 view_up.style.display = "none";
								 view_up_btn.className = '';
							 }
						 }
						}
						//-->
					</script>

					<h3 class="main_tit mt40"><span> 신 제 품 </span></h3>
					
					<div class="item_list mt20">
						<ul>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="#;"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="#;">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">GET</a></p>
							</li>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="#;"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="#;">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">CHANGE</a></p>
							</li>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="#;"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="#;">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">GET</a></p>
							</li>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="#;"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="#;">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">CHANGE</a></p>
							</li>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="#;"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="#;">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">GET</a></p>
							</li>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="#;"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="#;">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">CHANGE</a></p>
							</li>
						</ul>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
					
							$(".item_img img").hover(function() {
								var temp = $(this).attr("src");
								$(this).attr("src", $(this).attr("data-alt-src"));
								$(this).attr("data-alt-src", temp);
							});
						})
					</script>
				</div>
			</div>
			<div class="main02 mt35">
				<div class="contents_w">
					<div class="m_use_info">
						<dl class="mui01">
							<dt>89,000/월</dt>
							<dd><span>다양한 명품 가방을 교환 횟수</span> 제한없이 마음껏 이용하세요.</dd>
						</dl>
						<dl class="mui02">
							<dt>반납</dt>
							<dd>반납 페이지에서 반납 <span>신청만 하시면 택배기사님 접수는</span> 에이블랑이 해드립니다.</dd>
						</dl>
						<dl class="mui03">
							<dt>교환</dt>
							<dd>반납 신청 후 언제든 <span>새로운 가방을 쇼핑하세요.</span> 원하는 가방을 발견하고 교환 버튼 클릭 <span>한 번이면 교환 신청이 완료됩니다.</span> </dd>
						</dl>
						<dl class="mui04">
							<dt>배송</dt>
							<dd>왕복 배송비는 <span>매월 2회까지 무료입니다.</span> 오전 11시 이전 GET한 가방은 <span>당일 발송됩니다.(발송 후 1~2일 소요)</span></dd>
						</dl>
						<dl class="mui05">
							<dt>생활 스크래치 안심보험 </dt>
							<dd>에이블랑은 고객에게 상품을 <span>안심하고 사용할 수 있도록</span> ‘생활스크래치 안심보험’을 <span>제공하고 있습니다</span></dd>
						</dl>
					</div>
				</div>
			</div>
			

		</div>

	

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
