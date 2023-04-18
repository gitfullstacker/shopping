<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   MEMBER JOIN    >   회원가입</p>
					<!--<div class="tit_h2 mt10">MEMBER JOIN</div>//-->
					<div class="lnb_tab lnb_tab5 mt20">
						<ul>
							<li><a href="login.php">로그인</a></li>
							<li class="on"><a href="join.php">회원가입</a></li>
							<li><a href="idpw_search.php">ID/비밀번호 찾기</a></li>
							<li><a href="use.php">이용약관</a></li>
							<li><a href="privaty.php">개인정보취급방침</a></li>
						</ul>
					</div>
					<div class="join_end">
						<dl>
							<dt>회원가입이 완료되었습니다.</dt>
							<dd class="txt"><span>멤버십을 등록하시고</span> 에이블랑에서 럭셔리 쇼핑을 즐겨보세요!</dd>
							<dd class="mt50">
								<a href="/main/" class="btn btn_l btn_ylw w270 f_bd">쇼핑하러가기</a>
								<a href="/mypage/membership.php" class="btn btn_l btn_bk w270 f_bd">멤버쉽 등록하러가기</a>
							</dd>
						</dl>
					</div>

					
				</div>
			</div>
			

		</div>
		
<!-- 전환페이지 설정 -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> 
<script type="text/javascript"> 
var _nasa={};
_nasa["cnv"] = wcs.cnv("2","1"); 
</script> 

		
<!-- Mirae Log Analysis Conversion Script Ver 1.0   -->
<script type='text/javascript'>
var mi_type = 'member';
var mi_val = 'Y';
</script>
<!-- Mirae Log Analysis Conversion Script END  -->

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>