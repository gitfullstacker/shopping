<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	$loc = Fnc_Om_Conv_Default($_REQUEST[loc],"");
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/login.js"></script>	
		
		<div class="con_width"style="padding-top: 1px;">
			<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/submenu_memberjoin.php"; ?>
			<div class="tit_login mt105">
				<em>LOGIN</em>
				
			</div>
			
			<form id="frm" name="frm" target="_self" method="POST" action="/m/memberjoin/login_proc.php">
			<input type="hidden" name="NextPage" value="<?=$loc?>">
			
			<div class="login_bx mt10">
				<p><input type="text" class="inp02 w100p" name="str_userid" autocomplete="off" value="<?=$_COOKIE["USER_INFO_DATA"]?>" placeholder="아이디" /></p>
				<p class="mt05"><input type="password" name="str_passwd" autocomplete="off" class="inp02 w100p" placeholder="비밀번호" /></p>
				<p class="f_bk mt20">
					<label><input type="checkbox" name="idsave" class="cform" value="1" <?if ($_COOKIE["USER_FLAG_DATA"]=="1"){?> checked<?}?> /> 아이디 저장</label>
					<label class="pl15"><input type="checkbox" name="idsession" value="1" class="cform" /> 로그인 유지하기</label>
				</p>
				<p class="btn_login"><a href="javascript:CheckValue1();" class="btn btn_l btn_bk w100p">로그인</a></p>
			</div>
			
			</form>
			
			<dl class="login_menu">
				<dd>
					<a href="/m/memberjoin/join.php" class="btn btn_m btn_gray02 ">회원가입</a>
					<span> </span>
					<a href="/m/memberjoin/idpw_search.php" class="btn btn_m btn_gray02 ">아이디/비밀번호 찾기</a>
				</dd>
			</dl>

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/footer.php"; ?>

