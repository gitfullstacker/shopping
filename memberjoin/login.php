<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	$loc = Fnc_Om_Conv_Default($_REQUEST[loc],"");
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>
<script language="javascript" src="js/login.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   MEMBER JOIN    >   로그인</p>
					<!-- <div class="tit_h2 mt10">MEMBER JOIN</div> -->
					<div class="lnb_tab lnb_tab5 mt20">
						<ul>
							<li class="on"><a href="login.php">로그인</a></li>
							<li><a href="join.php">회원가입</a></li>
							<li><a href="idpw_search.php">ID/비밀번호 찾기</a></li>
							<li><a href="use.php">이용약관</a></li>
							<li><a href="privaty.php">개인정보취급방침</a></li>
						</ul>
					</div>
					
					<form id="frm" name="frm" target="_self" method="POST" action="/memberjoin/login_proc.php" onSubmit="return CheckValue1();">
					<input type="hidden" name="NextPage" value="<?=$loc?>">
					
					<div class="login_w mt40">
						<div class="login_f">
							<div class="login_tit"><em>LOGIN</em> 로그인 후 다양한 서비스를 이용하실 수 있습니다. </div>
							<div class="login_bx01">
								<p class="lgn_f01"><input type="text" name="str_userid" autocomplete="off" class="inp_login" value="<?=$_COOKIE["USER_INFO_DATA"]?>" placeholder="아이디" /></p>
								<p class="lgn_f01"><input type="password" name="str_passwd" autocomplete="off" class="inp_login" placeholder="비밀번호" /></p>
								<p class="lgn_f02"><label><input type="checkbox" name="idsave" value="1" <?if ($_COOKIE["USER_FLAG_DATA"]=="1"){?> checked<?}?> /> 아이디 저장</label></p>
								<p class="lgn_f03"><input type="image" src="../images/sub/btn_login.gif" alt="" /></p>
							</div>
							<div class="login_bx02 mt30">
								<p>
									<span>지금 에이블랑에 가입하시고 특별한 서비스를 즐기세요</span>
									<a href="join.php" class="btn btn_wt btn_join">회원가입</a>
								</p>
								<p>
									<span>아이디 또는 비밀번호를 잊으셨나요?</span>
									<a href="idpw_search.php" class="btn btn_wt">아이디/비밀번호 찾기</a>
								</p>
							</div>
						</div>
						<div class="login_ban"><img src="../images/sub/join_ban.gif" alt="" /></div>
					</div>
					
					</form>
					
					<script type="text/javascript">
						<!--
						window.onload = function() {
							document.frm.str_userid.focus();
						}
						//-->
					</script>

					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>