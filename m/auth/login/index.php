<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-5 text-center text-black">로그인</p>
    </div>

    <form class="mt-7 flex flex-col gap-2.5 w-full">
        <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="user_id" id="user_id" placeholder="아이디 입력">
        <input type="password" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="user_password" id="user_password" placeholder="비밀번호 입력 (영문, 숫자, 특수문자 조합)">
        <button type="submit" class="mt-[5px] flex justify-center items-center w-full h-[45px] bg-black border border-solid border-[#DDDDDD]">
            <p class="font-bold text-xs leading-[14px] text-center text-white">로그인 하기</p>
        </button>
        <div class="flex justify-between items-center">
            <div class="flex gap-[5px] items-center">
                <input type="checkbox" class="w-[14px] h-[14px]" name="login_keep" id="login_keep" checked>
                <label for="login_keep" class="font-bold text-xs leading-[14px] text-[#666666]">자동 로그인</label>
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
            <button class="flex justify-center items-center w-[75px] h-10 bg-[#06BE34] rounded-full">
                <img src="images/naver_icon.png" alt="">
            </button>
            <button class="flex justify-center items-center w-[75px] h-10 bg-[#FFE350] rounded-full">
                <img src="images/kakao_icon.png" alt="">
            </button>
        </div>
    </div>

    <!-- 회원가입 -->
    <div class="mt-10 flex flex-col gap-[15px] items-center">
        <p class="font-bold text-xs leading-[14px] text-center underline text-[#666666]">회원가입하고 다양한 혜택을 받아보세요!</p>
        <button class="w-full h-[50px] flex justify-center items-center bg-whtie border border-solid border-[#DDDDDD]">
            <p class="font-extrabold text-[15px] leading-[17px] text-center text-black">회원가입</p>
        </button>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>