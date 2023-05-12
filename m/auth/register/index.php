<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<div class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-5 text-center text-black">회원가입</p>
    </div>

    <!-- 계정 정보 -->
    <div class="flex flex-col gap-[19px] w-full">
        <p class="font-extrabold text-[13px] leading-[15px] text-black">계정 정보 <span class="text-[#DA2727]">*</span></p>
        <div class="flex flex-col gap-[15px] w-full">
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">아이디</p>
                <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="user_id" id="user_id" placeholder="ablanc1234">
                <p class="font-bold text-xs leading-[14px] text-[#DA2727]">* ablanc1234 는 사용중인 아이디 입니다.</p>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">비밀번호</p>
                <input type="password" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="password" id="password" placeholder="ablanc1234">
                <p class="font-bold text-xs leading-[14px] text-[#DA2727]">* 영문, 숫자, 특수문자, 8-20자 이내로 입력해 주세요</p>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">비밀번호 확인</p>
                <input type="password" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="password_confirm" id="password_confirm" placeholder="ablanc1234">
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">이메일</p>
                <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="user_email" id="user_email" placeholder="ablanc1231@naver.com">
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">연락처</p>
                <div class="grid grid-cols-3 gap-[5px]">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="phone1" id="phone1" placeholder="010">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="phone2" id="phone2" placeholder="1234">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="phone3" id="phone3" placeholder="5678">
                </div>
                <button class="flex justify-center items-center w-full h-[45px] bg-[#EBEBEB] border border-solid border-[#DDDDDD]">
                    <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">변경</p>
                </button>
            </div>
        </div>
    </div>

    <!-- 구분 -->
    <hr class="mt-[30px] mb-[20px] border-t-[0.5px] border-[#E0E0E0]" />

    <!-- 배송지 정보 -->
    <div class="flex flex-col gap-[19px] w-full">
        <p class="font-extrabold text-[13px] leading-[15px] text-black">배송지 정보</p>
        <div class="flex flex-col gap-[15px] w-full">
            <div class="flex gap-[5px] items-center">
                <input type="checkbox" class="w-[14px] h-[14px]" name="same_account" id="same_account" checked>
                <label for="same_account" class="font-bold text-xs leading-[14px] text-[#666666]">회원정보와 동일</label>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">이름</p>
                <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="delivery_name" id="delivery_name" placeholder="에이블랑">
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">연락처</p>
                <div class="grid grid-cols-3 gap-[5px]">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="delivery_phone1" id="delivery_phone1" placeholder="010">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="delivery_phone2" id="delivery_phone2" placeholder="1234">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="delivery_phone3" id="delivery_phone3" placeholder="5678">
                </div>
                <button class="flex justify-center items-center w-full h-[45px] bg-[#EBEBEB] border border-solid border-[#DDDDDD]">
                    <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">변경</p>
                </button>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">주소</p>
                <div class="flex gap-[5px] items-center">
                    <div class="grow">
                        <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="delivery_postal_code" id="delivery_postal_code" placeholder="우편번호" disabled>
                    </div>
                    <button class="flex justify-center items-center w-[97px] h-[45px] bg-[#EBEBEB] border border-solid border-[#DDDDDD]"  id="search_address">
                        <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">검색</p>
                    </button>
                </div>
                <div class="flex gap-[5px] items-center">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="delivery_address" id="delivery_address" placeholder="기본주소" disabled>
                </div>
                <div class="flex gap-[5px] items-center">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="delivery_detail_address" id="delivery_detail_address" placeholder="상세 주소를 입력해 주세요">
                </div>
            </div>
        </div>
    </div>

    <!-- 구분 -->
    <hr class="mt-[30px] mb-[20px] border-t-[0.5px] border-[#E0E0E0]" />

    <!-- 추가 정보 -->
    <div class="flex flex-col gap-[19px] w-full">
        <p class="font-extrabold text-[13px] leading-[15px] text-black">추가 정보</p>
        <div class="flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">성별</p>
            <div class="flex gap-[15px] items-center">
                <div class="flex gap-[5px] items-center">
                    <input type="radio" class="w-[14px] h-[14px]" name="sex" id="woman" checked>
                    <label for="woman" class="font-bold text-xs leading-[14px] text-[#666666]">여성</label>
                </div>
                <div class="flex gap-[5px] items-center">
                    <input type="radio" class="w-[14px] h-[14px]" name="sex" id="man">
                    <label for="man" class="font-bold text-xs leading-[14px] text-[#666666]">남성</label>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">생년월일</p>
            <div class="grid grid-cols-3 gap-[5px] items-center">
                <div class="relative w-full">
                    <select class="w-full h-[45px] px-[15px] bg-white border border-solid border-[#DDDDDD] font-bold text-xs leading-[14px] text-[#999999]" name="birthday_year" id="birthday_year">
                        <?php
                        for ($i = 0; $i < 100; $i++) {
                        ?>
                            <option value="<?= $i + 1900 ?>" <?= $i == 50 ? 'selected' : '' ?>><?= $i + 1900 ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="absolute top-5 right-[19px]">
                        <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.6932 1.18894L5.85752 5.84793C5.79995 5.90323 5.73759 5.9423 5.67042 5.96516C5.60326 5.98839 5.5313 6 5.45455 6C5.37779 6 5.30583 5.98839 5.23867 5.96516C5.1715 5.9423 5.10914 5.90323 5.05157 5.84793L0.201487 1.18894C0.0671621 1.05991 -2.22989e-07 0.898617 -2.31449e-07 0.705069C-2.39909e-07 0.51152 0.0719594 0.345622 0.215879 0.207373C0.359798 0.0691242 0.527704 -4.99904e-07 0.719597 -5.08292e-07C0.911489 -5.1668e-07 1.0794 0.0691242 1.22331 0.207373L5.45454 4.27189L9.68578 0.207373C9.8201 0.0783406 9.98551 0.013824 10.182 0.013824C10.3789 0.013824 10.5493 0.0829482 10.6932 0.221197C10.8371 0.359446 10.9091 0.520736 10.9091 0.705068C10.9091 0.8894 10.8371 1.05069 10.6932 1.18894Z" fill="#333333" />
                        </svg>
                    </span>
                </div>
                <div class="relative w-full">
                    <select class="w-full h-[45px] px-[15px] bg-white border border-solid border-[#DDDDDD] font-bold text-xs leading-[14px] text-[#999999]" name="birthday_month" id="birthday_month">
                        <?php
                        for ($i = 0; $i < 12; $i++) {
                        ?>
                            <option value="<?= $i + 1 ?>"><?= $i + 1 ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="absolute top-5 right-[19px]">
                        <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.6932 1.18894L5.85752 5.84793C5.79995 5.90323 5.73759 5.9423 5.67042 5.96516C5.60326 5.98839 5.5313 6 5.45455 6C5.37779 6 5.30583 5.98839 5.23867 5.96516C5.1715 5.9423 5.10914 5.90323 5.05157 5.84793L0.201487 1.18894C0.0671621 1.05991 -2.22989e-07 0.898617 -2.31449e-07 0.705069C-2.39909e-07 0.51152 0.0719594 0.345622 0.215879 0.207373C0.359798 0.0691242 0.527704 -4.99904e-07 0.719597 -5.08292e-07C0.911489 -5.1668e-07 1.0794 0.0691242 1.22331 0.207373L5.45454 4.27189L9.68578 0.207373C9.8201 0.0783406 9.98551 0.013824 10.182 0.013824C10.3789 0.013824 10.5493 0.0829482 10.6932 0.221197C10.8371 0.359446 10.9091 0.520736 10.9091 0.705068C10.9091 0.8894 10.8371 1.05069 10.6932 1.18894Z" fill="#333333" />
                        </svg>
                    </span>
                </div>
                <div class="relative w-full">
                    <select class="w-full h-[45px] px-[15px] bg-white border border-solid border-[#DDDDDD] font-bold text-xs leading-[14px] text-[#999999]" name="birthday_day" id="birthday_day">
                        <?php
                        for ($i = 0; $i < 31; $i++) {
                        ?>
                            <option value="<?= $i + 1 ?>"><?= $i + 1 ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="absolute top-5 right-[19px]">
                        <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.6932 1.18894L5.85752 5.84793C5.79995 5.90323 5.73759 5.9423 5.67042 5.96516C5.60326 5.98839 5.5313 6 5.45455 6C5.37779 6 5.30583 5.98839 5.23867 5.96516C5.1715 5.9423 5.10914 5.90323 5.05157 5.84793L0.201487 1.18894C0.0671621 1.05991 -2.22989e-07 0.898617 -2.31449e-07 0.705069C-2.39909e-07 0.51152 0.0719594 0.345622 0.215879 0.207373C0.359798 0.0691242 0.527704 -4.99904e-07 0.719597 -5.08292e-07C0.911489 -5.1668e-07 1.0794 0.0691242 1.22331 0.207373L5.45454 4.27189L9.68578 0.207373C9.8201 0.0783406 9.98551 0.013824 10.182 0.013824C10.3789 0.013824 10.5493 0.0829482 10.6932 0.221197C10.8371 0.359446 10.9091 0.520736 10.9091 0.705068C10.9091 0.8894 10.8371 1.05069 10.6932 1.18894Z" fill="#333333" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- 구분 -->
    <hr class="mt-[30px] mb-[20px] border-t-[0.5px] border-[#E0E0E0]" />

    <!-- 수신동의 -->
    <div class="flex flex-col gap-[19px] w-full">
        <p class="font-extrabold text-[13px] leading-[15px] text-black">수신동의</p>
        <div class="flex flex-col gap-2.5 w-full">
            <p class="font-bold text-xs leading-[14px] text-black">마케팅 수신동의</p>
            <div class="flex gap-[18px] items-center">
                <div class="flex gap-[5px] items-center">
                    <input type="checkbox" class="w-[14px] h-[14px]" name="agree_email" id="agree_email" checked>
                    <label for="woman" class="font-bold text-xs leading-[14px] text-[#666666]">이메일 수신동의</label>
                </div>
                <div class="flex gap-[5px] items-center">
                    <input type="checkbox" class="w-[14px] h-[14px]" name="agree_sms" id="agree_sms">
                    <label for="man" class="font-bold text-xs leading-[14px] text-[#666666]">SMS 수신동의</label>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-[15px] px-[9px] py-[15px] bg-[#F5F5F5] w-full">
        <p class="font-bold text-[10px] leading-[160%] text-[#999999]">
            수신동의를 하시면 에이블랑에서 제공하는 다양한 할인 혜택과 <br />이벤트/신상품 등의 정보를 만나실 수 있습니다.
        </p>
        <p class="font-bold text-[10px] leading-[160%] text-black">
            주문 및 배송관련 SMS는 수신동의와 상관없이 자동 발송됩니다.
        </p>
    </div>

    <button class="mt-[30px] flex justify-center items-center w-full h-[45px] bg-black border border-solid border-[#DDDDDD]">
        <p class="font-bold text-xs leading-[14px] text-center text-white">가입하기</p>
    </button>
</div>

<script>
    $(document).ready(function() {
        // 주소 검색 버튼 클릭 이벤트 처리
        $('#search_address').click(function() {
            new daum.Postcode({
                oncomplete: function(data) {
                    // 선택한 주소의 우편번호와 주소 입력하기
                    $('#delivery_postal_code').val(data.zonecode);
                    $('#delivery_address').val(data.address);
                }
            }).open();
        });
    });
</script>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>