$(function(){
  $('.nav').mobilemenu({
    menuOpenIcon: '<span class="mobilemenu--open-icon mobilemenu-theme"><span class="slicknav_icon"><span class="slicknav_icon-bar slicknav_icon-bar--first"></span><span class="slicknav_icon-bar"></span><span class="slicknav_icon-bar"></span></span></span>',
    onInit: function(menu, options){
      menu.find('ul').removeClass('nav nav-pills pull-right');
    }
  });
  
  var menu = $.mobilemenu({
    menuOpenObject: $('.demoLink'),
    body: '<div class="user_info"><a class="btn nav-home" href="/m/main/"><i class="icn"></i>홈</a><div class="util_btn"><a class="btn nav-util" href="/m/cscenter/review.php">후기</a><a class="btn nav-util" href="/m/memberjoin/login.php">로그인</a><a class="btn nav-util" href="/m/memberjoin/join.php">회원가입</a></div></div>\
	<div class="left_menu01">\
		<ul>\
			<li><a href="/m/cart/get_cart.php"><i class="icn icn_get"></i><span>GET한 가방</span></a></li>\
			<li><a href="/m/mypage/return.php"><i class="icn icn_return"></i><span>반납</span></a></li>\
			<li><a href="/m/cscenter/guideyong.php"><i class="icn icn_faq"></i><span>이용 방법</span></a></li>\
		</ul>\
	</div>\
	<div class="left_event"><span class="tit">EVENT</span><a href="#">에이블랑에 가입해주셔서 감사합니다.</a></div>\
	<ul class="left_menu02">\
		<li><a href="/m/category/list.php">ALL</a></li>\
		<li><a href="#">NEW</a></li>\
		<li><a href="#">SMALL</a></li>\
		<li><a href="#">MEDIUM</a></li>\
		<li><a href="#">LARGE</a></li>\
		<li><a href="#">CLUTCH</a></li>\
		<li><a href="#">WEDDING</a></li>\
	</ul>\
	<ul class="left_menu03">\
      <li>\
        <a href="#;">마이페이지</a>\
        <ul>\
          <li><a href="/m/mypage/my_qna.php">- 문의하기(Q&A)</a></li>\
          <li><a href="/m/mypage/return.php">- 반납</a></li>\
          <li><a href="/m/mypage/get.php">- GET한 가방</a></li>\
          <li><a href="/m/mypage/stocked.php">- 입고알림 가방</a></li>\
          <li><a href="/m/mypage/like.php">- 좋아요 가방</a></li>\
          <li><a href="/m/mypage/request.php">- 가방 요청 </a></li>\
          <li><a href="/m/mypage/myreview.php">- 내가 쓴 이용후기</a></li>\
          <li><a href="/m/mypage/stamp.php">- 내 스탬프 </a></li>\
          <li><a href="/m/mypage/membership.php">- 멤버십 정보  </a></li>\
          <li><a href="/m/mypage/user_info.php">- 개인정보</a></li>\
        </ul>\
      </li>\
	  <li>\
        <a href="#;">고객센터</a>\
        <ul>\
          <li><a href="/m/cscenter/guideyong.php">- 이용방법  </a></li>\
          <li><a href="/m/cscenter/faq.php">- 자주하는 질문  </a></li>\
          <li><a href="/m/mypage/my_qna.php">- 문의하기</a></li>\
          <li><a href="/m/cscenter/review.php">- 이용후기 </a></li>\
          <li><a href="/m/cscenter/notice.php">- 공지사항 </a></li>\
          <li><a href="/m/cscenter/today.php">- 최근 본 가방 </a></li>\
        </ul>\
      </li>\
    </ul>'
  });
});
