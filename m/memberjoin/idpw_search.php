<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>
<script language="JavaScript" src="js/idpw_search.js"></script>

<?php
$menu = Fnc_Om_Conv_Default($_REQUEST['menu'], 1);
$id_step = Fnc_Om_Conv_Default($_REQUEST['id_step'], 1);
$pwd_step = Fnc_Om_Conv_Default($_REQUEST['pwd_step'], 1);

$str_userid = Fnc_Om_Conv_Default($_REQUEST[str_userid], "");
$str_rname = Fnc_Om_Conv_Default($_REQUEST[str_rname], "");
$str_rhp = Fnc_Om_Conv_Default($_REQUEST[str_rhp1], "") . "-" . Fnc_Om_Conv_Default($_REQUEST[str_rhp2], "") . "-" . Fnc_Om_Conv_Default($_REQUEST[str_rhp3], "");

$_SESSION['PHONE_VERIFY'] = 'JOIN';

$authtype = "M";          // 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드

$popgubun     = "N";        //Y : 취소버튼 있음 / N : 취소버튼 없음
$customize     = "Mobile";            //없으면 기본 웹페이지 / Mobile : 모바일페이지

$reqseq = "REQ_0123456789";     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
// 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
$reqseq = `$cb_encode_path SEQ $sitecode`;

// CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
$returnurl = "//" . $_SERVER["HTTP_HOST"] . "/m/memberjoin/checkplus_success.php";    // 성공시 이동될 URL
$errorurl = "//" . $_SERVER["HTTP_HOST"] . "/m/memberjoin/checkplus_fail.php";        // 실패시 이동될 URL

// reqseq값은 성공페이지로 갈 경우 검증을 위하여 세션에 담아둔다.

$_SESSION["REQ_SEQ"] = $reqseq;

// 입력될 plain 데이타를 만든다.
$plaindata =  "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
	"8:SITECODE" . strlen($sitecode) . ":" . $sitecode .
	"9:AUTH_TYPE" . strlen($authtype) . ":" . $authtype .
	"7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
	"7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
	"11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
	"9:CUSTOMIZE" . strlen($customize) . ":" . $customize;

$enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;

if ($enc_data == -1) {
	$returnMsg = "암/복호화 시스템 오류입니다.";
	$enc_data = "";
} else if ($enc_data == -2) {
	$returnMsg = "암호화 처리 오류입니다.";
	$enc_data = "";
} else if ($enc_data == -3) {
	$returnMsg = "암호화 데이터 오류 입니다.";
	$enc_data = "";
} else if ($enc_data == -9) {
	$returnMsg = "입력값 오류 입니다.";
	$enc_data = "";
}
?>
<div x-data="{ menu: <?= $menu ?>, idStep: <?= $id_step ?>, pwdStep: <?= $pwd_step ?> }" class="mt-[30px] mb-[100px] flex flex-col w-full px-[14px]">
	<form class="flex flex-col items-center" id="frm" name="frm" method="POST">
		<input type="hidden" name="RetrieveFlag">
		<input type="hidden" name="gbn">
		<input type="hidden" name="str_hp1">
		<input type="hidden" name="str_hp2">
		<input type="hidden" name="str_hp3">

		<p class="font-extrabold text-lg leading-5 text-center text-black">아이디/비밀번호 찾기</p>
		<div class="mt-[9px] flex flex-row gap-10 items-center">
			<div class="flex jusitfy-center items-center px-1 py-[3px]" x-bind:class="menu == 1 ? 'border-b border-[#6A696C]' : ''" x-on:click="menu = 1">
				<p class="font-bold text-xs leading-[14px] text-center" x-bind:class="menu == 1 ? 'text-[#6A696C]' : 'text-[#999999]'">아이디 찾기</p>
			</div>
			<div class="flex jusitfy-center items-center px-1 py-[3px]" x-bind:class="menu == 2 ? 'border-b border-[#6A696C]' : ''" x-on:click="menu = 2">
				<p class="font-bold text-xs leading-[14px] text-center" x-bind:class="menu == 2 ? 'text-[#6A696C]' : 'text-[#999999]'">비밀번호 찾기</p>
			</div>
		</div>
		<!-- 아이디 찾기 -->
		<div x-show="menu == 1" class="mt-7 flex flex-col w-full">
			<div x-show="idStep == 1" class="flex flex-col gap-2.5 w-full" id="search_id_panel">
				<input type="text" class="w-full h-[50px] px-[15px] bg-white border-[0.72px] border-[#DDDDDD] font-normal text-xs leading-[14px] text-black placeholder-[#999999]" name="str_name" placeholder="이름">
				<button type="button" class="mt-[5px] flex justify-center items-center w-full h-[50px] bg-black border-[0.72px] border-[#DDDDDD]" onclick="verifyPhone('1')">
					<p class="font-bold text-xs leading-[14px] text-white">휴대폰 인증</p>
				</button>
			</div>
			<div x-show="idStep == 2" class="flex flex-col gap-7 w-full" id="search_id_result_panel">
				<p class="font-medium text-[15px] leading-[22px] text-[#6A696C] text-center">
					회원님의 이메일로 아이디를 발송했습니다.<br>
					<span class="text-black">메일</span>을 확인해주세요.
				</p>
				<a href="/m/memberjoin/login.php" type="button" class="mt-[5px] flex justify-center items-center w-full h-[50px] bg-black border-[0.72px] border-[#DDDDDD]">
					<p class="font-bold text-xs leading-[14px] text-white">로그인 바로가기</p>
				</a>
			</div>
		</div>
		<!-- 비밀번호 찾기 -->
		<div x-show="menu == 2" class="mt-7 flex flex-col w-full">
			<div x-show="pwdStep == 1" class="flex flex-col gap-2.5 w-full">
				<input type="text" class="w-full h-[50px] px-[15px] bg-white border-[0.72px] border-[#DDDDDD] font-normal text-xs leading-[14px] text-black placeholder-[#999999]" name="str_userid" placeholder="아이디">
				<input type="text" class="w-full h-[50px] px-[15px] bg-white border-[0.72px] border-[#DDDDDD] font-normal text-xs leading-[14px] text-black placeholder-[#999999]" name="str_rname" placeholder="이름">
				<button type="button" class="mt-[5px] flex justify-center items-center w-full h-[50px] bg-black border-[0.72px] border-[#DDDDDD]" onclick="verifyPhone('2')">
					<p class="font-bold text-xs leading-[14px] text-white">휴대폰 인증</p>
				</button>
			</div>
			<div x-show="pwdStep == 2" class="flex flex-col gap-7 w-full">
				<p class="font-medium text-[15px] leading-[22px] text-[#6A696C] text-center">
					휴대폰 인증이 완료되었습니다.<br>
					<span class="text-black">새 비밀번호</span>를 설정해주세요.
				</p>
				<div class="flex flex-col gap-2.5 w-full">
					<input type="password" class="w-full h-[50px] px-[15px] bg-white border-[0.72px] border-[#DDDDDD] font-normal text-xs leading-[14px] text-black placeholder-[#999999]" id="str_password" placeholder="새 비밀번호">
					<input type="password" class="w-full h-[50px] px-[15px] bg-white border-[0.72px] border-[#DDDDDD] font-normal text-xs leading-[14px] text-black placeholder-[#999999]" id="str_password_conf" placeholder="비밀번호 확인">
					<button type="button" class="mt-[5px] flex justify-center items-center w-full h-[50px] bg-black border-[0.72px] border-[#DDDDDD]" onclick="setPassword()">
						<p class="font-bold text-xs leading-[14px] text-white">비밀번호 변경하기</p>
					</button>
				</div>
			</div>
		</div>
	</form>
</div>

<div id="pwd_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden" style="height: calc(100vh - 66px);">
	<div class="mt-[60%] flex flex-col gap-[12.5px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
		<button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('pwd_dialog').classList.add('hidden');">
			<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
			</svg>
		</button>
		<p class="font-bold text-[15px] leading-[17px] text-black">비밀번호 변경이 완료되었습니다.</p>
		<a href="/m/memberjoin/login.php" class="flex flex-row gap-[12.3px] items-center justify-center px-5 py-2.5 bg-white border-[0.84px] border-solid border-[#D9D9D9]">
			<p class="font-bold text-[10px] leading-[11px] text-[#666666]">로그인 바로가기</p>
			<svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.52603 9.0481L5.45631 4.95636C5.50296 4.90765 5.53592 4.85488 5.55521 4.79805C5.5748 4.74122 5.58459 4.68033 5.58459 4.61538C5.58459 4.55044 5.5748 4.48955 5.55521 4.43272C5.53592 4.37589 5.50296 4.32312 5.45631 4.27441L1.52603 0.170489C1.41718 0.0568296 1.28112 0 1.11785 0C0.95457 0 0.814619 0.060889 0.697994 0.182667C0.581368 0.304445 0.523056 0.446519 0.523056 0.60889C0.523056 0.77126 0.581368 0.913335 0.697994 1.03511L4.12678 4.61538L0.697994 8.19566C0.589143 8.30932 0.534719 8.44928 0.534719 8.61555C0.534719 8.78214 0.593031 8.92632 0.709656 9.0481C0.826282 9.16988 0.962345 9.23077 1.11785 9.23077C1.27335 9.23077 1.40941 9.16988 1.52603 9.0481Z" fill="#666666" />
			</svg>
		</a>
	</div>
</div>

<form name="form_chk" method="post">
	<input type="hidden" name="m" id="m" value="checkplusSerivce"> <!-- 필수 데이타로, 누락하시면 안됩니다. -->
	<input type="hidden" name="EncodeData" id="EncodeData" value="<?= $enc_data ?>"> <!-- 위에서 업체정보를 암호화 한 데이타입니다. -->

	<!-- 업체에서 응답받기 원하는 데이타를 설정하기 위해 사용할 수 있으며, 인증결과 응답시 해당 값을 그대로 송신합니다.
			    	 해당 파라미터는 추가하실 수 없습니다. -->
	<input type="hidden" name="param_r1" id="param_r1" value="">
	<input type="hidden" name="param_r2" id="param_r2" value="">
	<input type="hidden" name="param_r3" id="param_r3" value="">
</form>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
	function setPassword() {
		if (document.getElementById('str_password').value != document.getElementById('str_password_conf').value) {
			alert('비밀번호가 맞지 않습니다.');
		} else {
			$.ajax({
				url: 'idpw_search_proc.php?RetrieveFlag=PWSET&str_password=' + document.getElementById('str_password').value,
				success: function(result) {
					document.getElementById('pwd_dialog').classList.remove('hidden');
				}
			});
		}
	}
</script>