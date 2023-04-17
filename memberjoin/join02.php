<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	$str_cert = Fnc_Om_Conv_Default($_REQUEST[str_cert],"");
	$str_name = Fnc_Om_Conv_Default($_REQUEST[str_name],"");
	$str_hp = Fnc_Om_Conv_Default($_REQUEST[str_hp],"");
	$str_birth = Fnc_Om_Conv_Default($_REQUEST[str_birth],"");
	$str_sex = Fnc_Om_Conv_Default($_REQUEST[str_sex],"");
	
	If ($str_name=="") {
		?>
		<script language="javascript">
			alert("비정상적 접속입니다.");
			window.location.href="/main/index.php";
		</script>
		<?
		exit;
	}
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>
<script language="javascript" src="js/join02.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   MEMBER JOIN    >   회원가입</p>
					<div class="tit_h2 mt10">MEMBER JOIN</div>
					<div class="lnb_tab lnb_tab5">
						<ul>
							<li><a href="login.php">로그인</a></li>
							<li class="on"><a href="join.php">회원가입</a></li>
							<li><a href="idpw_search.php">ID/비밀번호 찾기</a></li>
							<li><a href="use.php">이용약관</a></li>
							<li><a href="privaty.php">개인정보취급방침</a></li>
						</ul>
					</div>
					
					<form id="frm" name="frm" target="_self" method="POST">
					<input type="hidden" name="str_cert" value="<?=$str_cert?>">
					<input type="hidden" name="str_name" value="<?=$str_name?>">
					<input type="hidden" name="str_hp" value="<?=$str_hp?>">
					<input type="hidden" name="str_birth" value="<?=$str_birth?>">
					<input type="hidden" name="str_sex" value="<?=$str_sex?>">

					<dl class="join_agree_tit mt40">
						<dt>이용약관</dt>
						<dd>에이블랑은 공정거래위원회의 표준 약관을 사용하고 있습니다. 회원가입 전 이용약관을 반드시 읽어 보시고 아래 동의 버튼을 눌러 주십시오.</dd>
					</dl>
					<div class="join_agree_bx">
						<div class="frame_bx"><iframe src="use_txt.html" frameborder="0"></iframe></div>
						<p class="frame_ck"><label><input type="checkbox" name="str_agree1" /> 이용약관에 동의</label></p>
					</div>

					<dl class="join_agree_tit mt55">
						<dt>개인정보 수집 및 이용 동의</dt>
						<dd>에이블랑은 정보통신망 이용촉진 및 정보보호에 관한 법률을 준수하고 있습니다. </dd>
						<dd>개인정보보호를 위한 이용자 동의사항 (자세한 내용은 “개인정보취급방침”을 확인하시기 바랍니다)을 반드시 읽어 보시고 아래 동의 버튼을 눌러 주십시오. </dd>
					</dl>
					<div class="join_agree_bx">
						<div class="frame_bx"><iframe src="privaty_txt.html" frameborder="0"></iframe></div>
						<p class="frame_ck"><label><input type="checkbox" name="str_agree2" /> 개인정보 수집 및 이용에 동의</label></p>
					</div>
					<div class="center f_bk mt40"><label><input type="checkbox" name="str_agree3" onclick="fnc_agree(this)" /> 위 모든 항목에 동의합니다.</label></div>
					<div class="center mt25"><a href="javascript:Save_Click();" class="btn btn_l btn_bk w270 f_bd">회원가입</a></div>
					
					</form>

					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"; ?>
