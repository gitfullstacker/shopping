<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$loc = Fnc_Om_Conv_Default($_REQUEST[loc], "");
?>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>
<script language="javascript" src="js/login.js"></script>

<div class="mt-[30px] flex flex-col w-full px-[14px]">
	<div class="flex justify-center">
		<p class="font-extrabold text-lg leading-5 text-center text-black">로그인</p>
	</div>

	<form class="mt-7 flex flex-col gap-2.5 w-full" id="frm" name="frm" target="_self" method="POST" action="/m/memberjoin/login_proc.php">
		<input type="hidden" name="NextPage" value="<?= $loc ?>">
		<input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="str_userid" autocomplete="off" value="<?= $_COOKIE["USER_INFO_DATA"] ?>" placeholder="아이디 입력">
		<input type="password" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="str_passwd" autocomplete="off" placeholder="비밀번호 입력 (영문, 숫자, 특수문자 조합)">
		<a href="javascript:CheckValue1();" class="mt-[5px] flex justify-center items-center w-full h-[45px] bg-black border border-solid border-[#DDDDDD]">
			<p class="font-bold text-xs leading-[12px] text-center text-white">로그인 하기</p>
		</a>
		<div class="flex justify-between items-center">
			<div class="flex gap-[5px] items-center">
				<input type="checkbox" class="w-[14px] h-[14px]" name="idsession" id="idsession" value="1" class="cform">
				<label for="idsession" class="font-bold text-xs leading-[14px] text-[#666666]">자동 로그인</label>
			</div>
			<div class="flex flex-row items-center divide-x divide-[#999999]">
				<a href="#" class="px-[5px] font-bold text-[9px] leading-[10px] text-center text-[#999999]">
					아이디 찾기
				</a>
				<a href="#" class="px-[5px] font-bold text-[9px] leading-[10px] text-center text-[#999999]">
					비밀번호 찾기
				</a>
			</div>
		</div>
	</form>

	<!-- 구분 -->
	<hr class="mt-[15px] mb-[15px] border-t border-[#E0E0E0]" />

	<!-- SNS 계정으로 로그인하기 -->
	<div class="flex flex-col gap-2.5 items-center w-full">
		<p class="font-extrabold text-[15px] leading-[17px] text-center text-black">SNS 계정으로 로그인하기</p>
		<div class="flex justify-center items-center gap-2.5">
			<a href="login_naver.php" class="flex justify-center items-center w-[75px] h-10 bg-[#06BE34] rounded-full">
				<img src="images/naver_icon.png" alt="">
			</a>
			<a href="login_kakao.php" class="flex justify-center items-center w-[75px] h-10 bg-[#FFE350] rounded-full">
				<img src="images/kakao_icon.png" alt="">
			</a>
		</div>
	</div>

	<!-- 회원가입 -->
	<div class="mt-10 flex flex-col gap-[15px] items-center">
		<p class="font-bold text-xs leading-[14px] text-center underline text-[#666666]">회원가입하고 다양한 혜택을 받아보세요!</p>
		<a href="/m/memberjoin/join.php" class="w-full h-[50px] flex justify-center items-center bg-whtie border border-solid border-[#DDDDDD]">
			<p class="font-extrabold text-[15px] leading-[17px] text-center text-black">회원가입</p>
		</a>
	</div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>