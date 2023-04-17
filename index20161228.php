<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
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
	$Sql_Query.="limit 3";

	$arr_Get_Data1= mysql_query($Sql_Query);
	if(!$arr_Get_Data1) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$arr_Get_Data_Cnt1=mysql_num_rows($arr_Get_Data1);
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>
<script language="javascript" src="/main/js/index.js"></script>

	

		<div id="container">
			<script type="text/javascript" src="/js/swiper.min.js"></script>
			<link type="text/css" rel="stylesheet" href="/css/swiper.min.css" />
			<?
			$SQL_QUERY = "select a.* from ".$Tname."comm_banner a where a.str_service='Y' and a.int_gubun='1' order by a.int_number asc ";

			$arr_Bann_Data=mysql_query($SQL_QUERY);
			$arr_Bann_Data_Cnt=mysql_num_rows($arr_Bann_Data);
			?>
			<div class="main_visual">
				<style type="text/css">
					<?
						for($int_J = 0 ;$int_J < $arr_Bann_Data_Cnt; $int_J++) {
					?>
					<?if (mysql_result($arr_Bann_Data,$int_J,str_image1)!="") {?>
					#mvisual<?=Fnc_Om_Add_Zero($int_J,2)?>{background:url('/admincenter/files/bann/<?=mysql_result($arr_Bann_Data,$int_J,str_image1)?>') no-repeat 50% 0;}
					<?}?>
					<?
						}
					?>
				</style>
				<!-- Swiper --> 
				<div class="swiper-container"> 
					<div class="swiper-wrapper"> 
						<?
							for($int_J = 0 ;$int_J < $arr_Bann_Data_Cnt; $int_J++) {
						?>
						<?if (mysql_result($arr_Bann_Data,$int_J,str_image1)!="") {?>
						<div class="swiper-slide" id="mvisual<?=Fnc_Om_Add_Zero($int_J,2)?>" <?if (mysql_result($arr_Bann_Data,$int_J,str_url1)!="") {?> onclick="fnc_open('<?=mysql_result($arr_Bann_Data,$int_J,str_url1)?>','<?=mysql_result($arr_Bann_Data,$int_J,str_target1)?>')" <?}?>></div> 
						<?}?>
						<?
							}
						?>
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
						effect: 'fade',
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
						<span class="m_event_tit"><img src="/images/main/tit_m_event.gif" alt="" /></span>
						<script type="text/javascript" src="/js/jquery.bxslider.js"></script>
						<link type="text/css" rel="stylesheet" href="/css/jquery.bxslider.css" />
						<ul class="bxslider">
							<?
								for($int_I = 0 ;$int_I < $arr_Get_Data_Cnt1; $int_I++) {
							?>
							<li>
								<a href="/boad/bd_news/1/egoread.php?bd=<?=mysql_result($arr_Get_Data1,$int_I,conf_seq)?>&seq=<?=mysql_result($arr_Get_Data1,$int_I,bd_seq)?>">
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
								<span><?=str_replace("-","/",substr(mysql_result($arr_Get_Data1,$int_I,bd_reg_date),0,10))?></span>
							</li>
							<?
								}
							?>
							<?
								for($int_J = $int_I ;$int_J < 3; $int_J++) {
							?>
							<li>
								<a href="#">&nbsp;</a>
								<span>&nbsp;</span>
							</li>
							<?
								}
							?>
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
							<li id="n2tab-btn01"><a href="#;" onmouseover="tab_view2(1);">이용절차&amp;상세서비스</a></li>
							<li class="on" id="n2tab-btn02"><a href="#;" onmouseover="tab_view2(2);">취급브랜드</a></li>
							<li id="n2tab-btn03"><a href="#;" onmouseover="tab_view2(3);">공지사항</a></li>
							<li id="n2tab-btn04"><a href="#;" onmouseover="tab_view2(4);">FAQ</a></li>
						</ul>
					</div>
					<div id="n2tab01" style="display:none;">
						
						<h3 class="main_tit mt40"><span>이용절차 &amp; 상세서비스</span></h3>
						<ul class="use_guide01">
							<li>
								<p class="bg_img"><img src="/images/main/m_img01.jpg" alt="" /></p>
								<p class="dt"><span class="icn icn_r_bk">01</span>가방선택</p>
								<p class="dd">1분이면 끝! <br />원하는 가방을 GET 하세요.</p>
							</li>
							<li>
								<p class="bg_img"><img src="/images/main/m_img02.jpg" alt="" /></p>
								<p class="dt"><span class="icn icn_r_bk">02</span>가방사용</p>
								<p class="dd">생활 스크래치 걱정은 NO!<br />안심하고 즐겁게 사용하세요.</p>
							</li>
							<li class="last">
								<p class="bg_img"><img src="/images/main/m_img03.jpg" alt="" /></p>
								<p class="dt"><span class="icn icn_r_bk">03</span>교환/반납</p>
								<p class="dd">원하는 가방으로 횟수 제한 없이 교환 가능!<br />(왕복 배송비 월 2회 무료)</p>
							</li>
						</ul>
						<div id="fullgroup" style="display:none;">
							<div class="use_guide02">
								<dl>
									<dt><i><img src="/images/main/icn_use_guide01.gif" alt="" /></i>선택</dt>
									<dd>
										<ul>
											<li><i>01.</i> 회원 가입을 하고 에이블랑 멤버십에 등록합니다.</li>
											<li><i>02.</i> 쇼핑을 합니다.</li>
											<li><i>03.</i> 원하는 가방을 발견하고 GET 클릭!</li>
											<li><i>04.</i> 오전 11시 이전 GET한 가방은 당일 출고됩니다.  <span>(출고 후 1~2일 소요)</span></li>
										</ul>
									</dd>
								</dl>
								<dl>
									<dt><i><img src="/images/main/icn_use_guide02.gif" alt="" /></i>사용</dt>
									<dd>
										<ul>
											<li><i>01.</i> 배송 온 박스는 잘 보관해 두고 가방을 즐겁게 사용하세요.</li>
											<li><i>02.</i> 가방을 사용하지 않을 때에는 아이나 애완동물의 손이 <span>닿지 않는 곳에 보관해주세요.</span></li>
											<li><i>03.</i> 가방이 훼손/분실되었을 경우 즉시 에이블랑에 <span>연락해주세요.</span></li>
										</ul>
									</dd>
								</dl>
								<dl class="last">
									<dt><i><img src="/images/main/icn_use_guide03.gif" alt="" /></i>교환</dt>
									<dd>
										<ul>
											<li><i>01.</i> 새로운 가방을 쇼핑합니다.</li>
											<li><i>02.</i> 원하는 가방을 발견하고 CHANGE를 클릭하세요.</li>
											<li><i>03.</i> 반납정보 입력 후 확인 누르면 교환신청 완료!</li>
											<li><i>04.</i> 기존에 사용하시던 가방은 배송 온 박스 그대로 포장해 <span>반납스티커를 붙인 후 택배기사님께 반납해주세요.</span> (고객님이 입력하신 반납일에 택배기사님을 보내드리니 <span>별도로 신청하지 않으셔도 됩니다.)</span></li>
											<li><i>05.</i> 기존에 사용하던 가방의 반납이 확인되는 즉시 새로 <span>선택한 가방이 출고됩니다.</span></li>
										</ul>
									</dd>
									<dt class="dt02"><i><img src="/images/main/icn_use_guide04.gif" alt="" /></i>반납</dt>
									<dd>
										<ul>
											<li><i>01.</i> 교환이 아닌 반납만을 원하실 경우 마이페이지에서 반납을 클릭하세요.</li>
											<li><i>02.</i> 반납정보 입력 후 확인 누르면 반납신청 완료!</li>
											<li><i>03.</i> 반납할 가방은 배송 온 박스 그대로 포장해 반납스티커를 <span>붙인 후 택배기사님께 반납해주세요.</span> (고객님이 입력하신 반납일에 택배기사님을 보내드리니 <span>별도로 신청하지 않으셔도 됩니다.)</span></li>
										</ul>
									</dd>
								</dl>
							</div>
							
							<p class="group_view tit_fg02"><a href="#;"><img src="/images/main/btn_main_hidden.gif" alt="감추기" /></a></p>
						</div>
						<p class="group_view tit_fg"><a href="#;"><img src="/images/main/btn_main_more.gif" alt="더보기" /></a></p>
					
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
					<div id="n2tab02">
						<h3 class="main_tit mt40"><span>취급브랜드</span></h3>
						<div class="m_brand">
							<?
							$SQL_QUERY = "select a.* from ".$Tname."comm_com_code a where a.str_service='Y' and a.int_gubun='2' order by a.int_number asc ";
				
							$arr_Bann_Data=mysql_query($SQL_QUERY);
							$arr_Bann_Data_Cnt=mysql_num_rows($arr_Bann_Data);
							?>
							<div class="m_brand_in">
								<ul>
									<?
										for($int_J = 0 ;$int_J < $arr_Bann_Data_Cnt; $int_J++) {
									?>
									<li>
										<div class="brand_logo"><p><a href="/search/search.php?Txt_brand[]=<?=mysql_result($arr_Bann_Data,$int_J,int_number)?>"><?if (mysql_result($arr_Bann_Data,$int_J,str_image1)!="") {?><img src="/admincenter/files/com/<?=mysql_result($arr_Bann_Data,$int_J,str_image1)?>" alt="" /><?}?></a></p></div>
										<div class="brand_name"><p><a href="/search/search.php?Txt_brand[]=<?=mysql_result($arr_Bann_Data,$int_J,int_number)?>"><?=mysql_result($arr_Bann_Data,$int_J,str_kcode)?></a></p></div>
										<?if (($int_J+7)%7==0) {?>
										<i></i>
										<?}?>
									</li>
									<?
										}
									?>
								</ul>
							</div>
						</div>
					</div>
					<div id="n2tab03" style="display:none;">
						<h3 class="main_tit mt40"><span>공지사항</span></h3>
						<?
						$SQL_QUERY = "select a.* from ".$Tname."comm_banner a where a.int_number is not null and a.int_gubun='3' and a.str_service='Y' order by a.int_number desc limit 3 ";

						$arr_Bann_Data=mysql_query($SQL_QUERY);
						$arr_Bann_Data_Cnt=mysql_num_rows($arr_Bann_Data);
						?>
						<ul class="m_notice_list">
							<?
								for($int_J = 0 ;$int_J < $arr_Bann_Data_Cnt; $int_J++) {
							?>
							<li<?if ($int_J == 2) {?> class="nd3"<?}?>>
								<?if (mysql_result($arr_Bann_Data,$int_J,str_url1)!="") {?>
								<a href="<?=mysql_result($arr_Bann_Data,$int_J,str_url1)?>" <?if (mysql_result($arr_Bann_Data,$int_J,str_target1)=="2") {?> target="_blank"<?}?>>
								<?}?>
									<p><?if (mysql_result($arr_Bann_Data,$int_J,str_image1)!="") {?><img src="/admincenter/files/bann/<?=mysql_result($arr_Bann_Data,$int_J,str_image1)?>" alt=""  style="width:336px;height:243px;"/><?}?></p>
									<dl>
										<dt><?=mysql_result($arr_Bann_Data,$int_J,str_title)?></dt>
										<dd class="con_txt"><?=mysql_result($arr_Bann_Data,$int_J,str_cont)?></dd>
										<dd class="date"><?=str_replace("-",".",substr(mysql_result($arr_Bann_Data,$int_J,dtm_indate),0,10))?></dd>
									</dl>
								<?if (mysql_result($arr_Bann_Data,$int_J,str_url1)!="") {?>
								</a>
								<?}?>
							</li>
							<?
								}
							?>

						</ul>
						<p class="group_view"><a href="#;"><img src="/images/main/btn_main_more.gif" alt="더보기" /></a></p>
					</div>
					<div id="n2tab04" style="display:none;">
						<h3 class="main_tit mt40"><span>FAQ</span></h3>
						<?
						$SQL_QUERY = "select a.*,b.str_code from ".$Tname."comm_faq a left join ".$Tname."comm_com_code b on a.int_gubun=b.int_number where a.int_number is not null and a.str_service='Y' and a.str_mservice='Y' order by a.dtm_indate desc ";

						$arr_Bann_Data=mysql_query($SQL_QUERY);
						$arr_Bann_Data_Cnt=mysql_num_rows($arr_Bann_Data);
						?>
						<div class="t_cover01 mt25">
						<ul class="faq_list">
							<?
								for($int_J = 0 ;$int_J < $arr_Bann_Data_Cnt; $int_J++) {
							?>
							<li class="q"><a href="javascript:menu('<?=mysql_result($arr_Bann_Data,$int_J,int_number)?>');"><?=mysql_result($arr_Bann_Data,$int_J,str_quest)?></a></li>
							<li class="a" id="submenu_prodeval<?=mysql_result($arr_Bann_Data,$int_J,int_number)?>" style="display: none;"><?=mysql_result($arr_Bann_Data,$int_J,str_answer)?></li>
							<?
								}
							?>

						</ul>
					</div>
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

					<h3 class="main_tit mt40"><span> N E W </span></h3>
					
					<script type="text/javascript">
						(function( $ ){
							$.fn.hoverGrid = function( options ) {  
							var settings = $.extend( {
									'itemClass' : '.item'
								}, options);
							
								return this.each(function() {       
								var hoverGrid = $(this);
								hoverGrid.addClass('hover-grid');
								hoverGrid.find(settings.itemClass).addClass('hover-grid-item');
								
								$(hoverGrid).find(settings.itemClass).hover(function () {
									$(this).find('div.caption').stop(false, true).fadeIn(200);
								},
										function () {
												$(this).find('div.caption').stop(false, true).fadeOut(200);
										});
								});
							};
						})( jQuery );
					</script>
					<script type="text/javascript">
							$(document).ready(function() {
								$('#layout').hoverGrid();
							});
					</script>
					<div class="item_list02">
						<?
						$SQL_QUERY = "SELECT 
													A.*,
													(SELECT B.STR_BCODE FROM ".$Tname."comm_goods_master_category B WHERE A.STR_GOODCODE=B.STR_GOODCODE LIMIT 1) AS STR_BCODE,
													(SELECT IFNULL(COUNT(Z.STR_USERID),0) AS CNT FROM ".$Tname."comm_member_like Z WHERE Z.STR_GOODCODE=A.STR_GOODCODE) AS LIKECNT, 
													(SELECT IFNULL(COUNT(D.STR_USERID),0) AS CNT FROM ".$Tname."comm_goods_cart D WHERE D.STR_GOODCODE=A.STR_GOODCODE AND D.STR_USERID='".$arr_Auth[0]."' AND D.INT_STATE IN ('4')) AS CARTCNT,
													E.STR_CODE
												FROM 
													".$Tname."comm_goods_master A
													LEFT JOIN
													".$Tname."comm_com_code E
													ON
													A.INT_BRAND=E.INT_NUMBER
												WHERE 
													A.STR_GOODCODE IS NOT NULL 
													AND 
													(A.STR_SERVICE='Y' OR A.STR_SERVICE='R') 
													AND 
													A.STR_MYN='Y' 
												ORDER BY 
													A.STR_GOODCODE DESC";

						$arr_Data=mysql_query($SQL_QUERY);
						$arr_Data_Cnt=mysql_num_rows($arr_Data);
						?>
						<?$sBuy = fnc_buy_info();?>
						<div id="layout">
							<?
								for($int_J = 0 ;$int_J < $arr_Data_Cnt; $int_J++) {
							?>
							<?$sRent=fnc_cart_info(mysql_result($arr_Data,$int_J,str_goodcode));?>
							<div class="item">
								<p class="rented"><?if ($sRent==0) {?><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a><?}?></p>
								<p class="zzim_icn"><a href="/category/detail.php?Txt_bcode=<?=mysql_result($arr_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_Data,$int_J,str_goodcode)?>"><img src="/images/main/icn_zzim_on.png" alt="" /></a> <?=mysql_result($arr_Data,$int_J,likecnt)?></p>
								<p class="item_img" style="width:320px;height:320px; margin:0 auto;"><?if (mysql_result($arr_Data,$int_J,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($arr_Data,$int_J,str_image1)?>" style="width:320px;height:320px;" border="0"><?}?></p>
								<dl>
									<dt><a href="/category/detail.php?Txt_bcode=<?=mysql_result($arr_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_Data,$int_J,str_goodcode)?>"><?=mysql_result($arr_Data,$int_J,str_code)?></a></dt>
									<dd><?=mysql_result($arr_Data,$int_J,str_egoodname)?></dd>
								</dl>
								<div class="caption" style="display: none;">
									<p class="item_img" style="width:320px;height:320px;margin:0 auto;"><a href="/category/detail.php?Txt_bcode=<?=mysql_result($arr_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_Data,$int_J,str_goodcode)?>"><?if (mysql_result($arr_Data,$int_J,str_image2)!="") {?><img src="/admincenter/files/good/<?=mysql_result($arr_Data,$int_J,str_image2)?>" style="width:320px;height:320px;" border="0"><?}?></a></p>
									<?If ($arr_Auth[0]=="") {?>
										<p class="on_btn mt20"><a href="/category/detail.php?Txt_bcode=<?=mysql_result($arr_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_Data,$int_J,str_goodcode)?>" class="btn btn_get">GET</a></p>
									<?}else{?>
										<?if ($sBuy > 0) {//구매가 있을때?>
											<?if ($sRent!=0) {//품절이 아닐때?>
												<?if (mysql_result($arr_Data,$int_J,cartcnt)>0) {//내가 빌링상품일때?>
													
												<?}else{?>
													<p class="on_btn mt20"><a href="/category/detail.php?Txt_bcode=<?=mysql_result($arr_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_Data,$int_J,str_goodcode)?>" class="btn btn_get">CHANGE</a></p>
												<?}?>
											<?}else{?>

											<?}?>
										<?}else{//구매가 없을때?>
											<?if ($sRent!=0) {//품절이 아닐때?>
												<p class="on_btn mt20"><a href="/category/detail.php?Txt_bcode=<?=mysql_result($arr_Data,$int_J,str_bcode)?>&str_no=<?=mysql_result($arr_Data,$int_J,str_goodcode)?>" class="btn btn_get">GET</a></p>		
											<?}?>
										<?}?>
									<?}?>
								</div>
							</div>
							<?
								}
							?>
						
						</div>
					</div>
					<p class="center mt20"><a href="/category/list.php" class="btn btn_ml btn_wt w270 f_bd">MORE</a></p>
				</div>
			</div>
			
			

		</div>

	

<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"; ?>


