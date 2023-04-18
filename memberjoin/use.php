<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   MEMBER JOIN    >   이용약관</p>
					<div class="lnb_tab lnb_tab5 mt20">
						<ul>
							<li><a href="login.php">로그인</a></li>
							<li><a href="join.php">회원가입</a></li>
							<li><a href="idpw_search.php">ID/비밀번호 찾기</a></li>
							<li class="on"><a href="use.php">이용약관</a></li>
							<li><a href="privaty.php">개인정보취급방침</a></li>
						</ul>
					</div>
					<script>
						function autosize(){
							var oFrame = top.document.getElementById("clause01");
							contentHeight = oFrame.contentWindow.document.body.scrollHeight;
							oFrame.style.height = String(contentHeight) + "px";
						} 
					</script>
					
					<iframe src="use_txt.html" id="clause01" frameborder="0" width="100%" height="100%" scrolling="no" onload="autosize()"></iframe>
					

					
				</div>
			</div>
			
		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
