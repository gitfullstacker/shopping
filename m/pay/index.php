<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<?php
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], 1);
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], '');

// 사용자정보 얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_member AS A
                WHERE
                    A.STR_USERID="' . $arr_Auth[0] . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}

$user_Data = mysql_fetch_assoc($arr_Rlt_Data);

// 상품정보 얻기
$SQL_QUERY =    'SELECT
                    A.*, B.STR_CODE AS STR_BRAND, (SELECT COUNT(C.STR_GOODCODE) FROM ' . $Tname . 'comm_member_like AS C WHERE A.STR_GOODCODE=C.STR_GOODCODE AND C.STR_USERID="' . ($arr_Auth[0] ?: 'NULL') . '") AS IS_LIKE, (SELECT COUNT(D.STR_GOODCODE) FROM ' . $Tname . 'comm_member_basket AS D WHERE A.STR_GOODCODE=D.STR_GOODCODE AND D.STR_USERID="' . ($arr_Auth[0] ?: 'NULL') . '") AS IS_BASKET
                FROM 
                    ' . $Tname . 'comm_goods_master AS A
                LEFT JOIN
                    ' . $Tname . 'comm_com_code AS B
                ON
                    A.INT_BRAND=B.INT_NUMBER
                WHERE
                    A.STR_GOODCODE="' . $str_goodcode . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}

$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>
<!-- 배송정보 -->
<div x-data="{ type: 1 }" class="mt-[30px] flex flex-col w-full px-[14px]">
    <p class="font-extrabold text-lg leading-5 text-[#333333]">배송정보</p>
    <div class="mt-1.5 flex gap-[7px]">
        <a href="#" class="flex justify-center items-center w-[86px] h-[29px] bg-white border border-solid rounded-[12.5px]" x-bind:class="type == 1 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="type = 1">
            <span class="font-bold text-xs leading-[14px] flex items-center text-center text-[#666666]">기본 배송지</span>
        </a>
        <a href="#" class="flex justify-center items-center w-[86px] h-[29px] bg-white border border-solid rounded-[12.5px]" x-bind:class="type == 2 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="type = 2">
            <span class="font-bold text-xs leading-[14px] flex items-center text-center text-[#666666]">신규 배송지</span>
        </a>
    </div>
    <!-- 기본 배송지 -->
    <div x-show="type == 1" class="mt-[15px] flex flex-col w-full">
        <p class="font-bold text-[15px] leading-[17px] text-black">에이블랑</p>
        <p class="mt-[9px] font-bold text-xs leading-[14px] text-black">(<?= $user_Data['STR_SPOST'] ?>) <?= $user_Data['STR_SADDR1'] . ' ' . $user_Data['STR_SADDR2'] ?></p>
        <p class="mt-1.5 font-bold text-xs leading-[14px] text-[#666666]"><?= $user_Data['STR_TELEP'] ?> / <?= $user_Data['STR_HP'] ?></p>
        <div class="mt-3 relative flex w-full">
            <select name="" id="" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-[3px] px-2.5 w-full h-[35px] font-bold text-[11px] leading-3 text-[#666666]">
                <option value="">배송시 요청사항을 선택해 주세요</option>
            </select>
            <div class="absolute top-[15px] right-[15px] pointer-events-none">
                <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576042 0.435356 5.34201e-07 0.593667 5.27991e-07C0.751979 5.2178e-07 0.890501 0.0576042 1.00923 0.172812L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.0115208 8.40016 0.0115208C8.56259 0.0115208 8.70317 0.0691245 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587558C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#666666" />
                </svg>
            </div>
        </div>
    </div>
    <!-- 신규 배송지 -->
    <div x-show="type == 2" class="mt-[15px] flex flex-col gap-[15px] w-full">
        <div class="flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">이름</p>
            <input type="text" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-bold text-xs leading-[14px] text-black" name="" id="" placeholder="이름을 입력해 주세요">
        </div>
        <div class="flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">연락처</p>
            <div class="grid grid-cols-3 gap-[5px] w-full">
                <input type="number" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-bold text-xs leading-[14px] text-black" name="" id="" placeholder="010">
                <input type="number" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-bold text-xs leading-[14px] text-black" name="" id="" placeholder="1234">
                <input type="number" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-bold text-xs leading-[14px] text-black" name="" id="" placeholder="5678">
            </div>
        </div>
        <div class="flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">주소</p>
            <div class="flex flex-col gap-[5px] w-full">
                <div class="flex gap-[5px]">
                    <div class="grow">
                        <input type="number" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-bold text-xs leading-[14px] text-black disabled:bg-[#F5F5F5]" name="" id="" placeholder="우편번호" disabled>
                    </div>
                    <button class="flex justify-center items-center w-[97px] h-[45px] bg-[#EBEBEB] border border-solid border-[#DDDDDD]">
                        <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">검색</p>
                    </button>
                </div>
                <input type="number" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-bold text-xs leading-[14px] text-black disabled:bg-[#F5F5F5]" name="" id="" placeholder="기본주소" disabled>
                <input type="number" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-bold text-xs leading-[14px] text-black" name="" id="" placeholder="상세 주소를 입력해 주세요">
            </div>
        </div>
        <button class="w-full h-[45px] bg-black border border-solid border-[#DDDDDD]">
            <p class="font-bold text-xs leading-[14px] text-center text-white">등록하기</p>
        </button>
    </div>
</div>

<!-- 구분선 -->
<hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

<!-- 주문정보 -->
<div class="mt-[15px] px-[14px]">
    <p class="font-extrabold text-lg leading-5 text-[#333333]">주문정보</p>
    <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-black"><?= $arr_Data['STR_BRAND'] ?></p>
    <div class="mt-3 flex gap-[11px]">
        <div class="w-[120px] h-[120px] flex justify-center items-center bg-[#F9F9F9] p-2.5">
            <img class="w-full" src="/admincenter/files/good/<?= $arr_Data['STR_IMAGE1'] ?>" alt="">
        </div>
        <div class="flex flex-col">
            <div class="flex justify-center items-center max-w-[38px] px-2 py-1 w-auto bg-[<?= ($arr_Data['INT_TYPE'] == 1 ? '#EEAC4C' : ($arr_Data['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                <p class="font-normal text-[10px] leading-[11px] text-center text-white"><?= ($arr_Data['INT_TYPE'] == 1 ? '구독' : ($arr_Data['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?></p>
            </div>
            <p class="mt-[15px] font-bold text-xs leading-[14px] text-[#666666]"><?= $arr_Data['STR_GOODNAME'] ?></p>
            <?php
            switch ($arr_Data['INT_TYPE']) {
                case 1:
            ?>
                    <p class="mt-[15px] font-bold text-xs text-[#666666]">월정액 구독 전용</p>
                    <div class="mt-[7px] flex gap-2 items-center">
                        <p class="font-bold text-xs text-[#333333]"><span class="text-[#EEAC4C]">월</span> <?= number_format($arr_Data['INT_PRICE']) ?>원</p>
                    </div>
                <?php
                    break;

                case 2:
                ?>
                    <p class="mt-[15px] font-bold text-xs line-through text-[#666666]"><?= $arr_Data['INT_DISCOUNT'] ? ('일 ' . number_format($arr_Data['INT_PRICE']) . '원') : '' ?></p>
                    <div class="mt-[7px] flex gap-2 items-center">
                        <p class="font-bold text-xs text-[#00402F]"><?= $arr_Data['INT_DISCOUNT'] ? (number_format($arr_Data['INT_DISCOUNT']) . '%') : '' ?></p>
                        <p class="font-bold text-xs text-[#333333]">일 <?= $arr_Data['INT_DISCOUNT'] ? number_format($arr_Data['INT_PRICE'] * $arr_Data['INT_DISCOUNT'] / 100) : number_format($arr_Data['INT_PRICE']) ?>원</p>
                        <p class="font-bold text-xs text-[#666666]">멤버십 혜택가</p>
                    </div>
                <?php
                    break;
                case 3:
                ?>
                    <p class="mt-[15px] font-bold text-xs line-through text-[#666666]"><?= $arr_Data['INT_DISCOUNT'] ? (number_format($arr_Data['INT_PRICE']) . '원') : '' ?></p>
                    <div class="mt-[7px] flex gap-2 items-center">
                        <p class="font-bold text-xs text-[#7E6B5A]"><?= $arr_Data['INT_DISCOUNT'] ? (number_format($arr_Data['INT_DISCOUNT']) . '%') : '' ?></p>
                        <p class="font-bold text-xs text-[#333333]"><?= $arr_Data['INT_DISCOUNT'] ? number_format($arr_Data['INT_PRICE'] * $arr_Data['INT_DISCOUNT'] / 100) : number_format($arr_Data['INT_PRICE']) ?>원</p>
                        <p class="font-bold text-xs text-[#666666]">최대 할인적용가</p>
                    </div>
            <?php
                    break;
            }
            ?>
        </div>
    </div>
    <!-- 구분선 -->
    <hr class="mt-5 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />
    <div class="mt-[15px] flex flex-col gap-1.5">
        <div class="flex gap-5">
            <p class="font-bold text-xs leading-[14px] text-[#999999]">이용날짜</p>
            <p class="font-bold text-xs leading-[14px] text-[#666666]"><?= date('Y. m. d', time()) ?></p>
        </div>
        <div class="flex gap-5">
            <p class="font-bold text-xs leading-[14px] text-[#999999]">배송분류</p>
            <p class="font-bold text-xs leading-[14px] text-[#666666]">무료배송</p>
        </div>
        <div class="flex gap-5">
            <p class="font-bold text-xs leading-[14px] text-[#999999]">등급할인</p>
            <p class="font-bold text-xs leading-[14px] text-[#666666]">미해당</p>
        </div>
    </div>
</div>

<!-- 구분선 -->
<hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

<!-- 쿠폰/적립금 -->
<div class="mt-[15px] px-[14px]">
    <p class="font-extrabold text-lg leading-5 text-[#333333]">쿠폰/적립금</p>
    <div class="mt-[15px] relative flex w-full">
        <select name="" id="" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-[3px] px-2.5 w-full h-[35px] font-bold text-[11px] leading-3 text-[#666666]">
            <option value="">사용가능 쿠폰 1장 / 전체 1장</option>
        </select>
        <div class="absolute top-[15px] right-[15px] pointer-events-none">
            <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576042 0.435356 5.34201e-07 0.593667 5.27991e-07C0.751979 5.2178e-07 0.890501 0.0576042 1.00923 0.172812L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.0115208 8.40016 0.0115208C8.56259 0.0115208 8.70317 0.0691245 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587558C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#666666" />
            </svg>
        </div>
    </div>
    <div class="mt-[5px] flex gap-[5px]">
        <div class="relative flex w-full">
            <select name="" id="" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-[3px] px-2.5 w-full h-[35px] font-bold text-[11px] leading-3 text-[#666666]">
                <option value="">1,000원</option>
            </select>
            <div class="absolute top-[15px] right-[15px] pointer-events-none">
                <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576042 0.435356 5.34201e-07 0.593667 5.27991e-07C0.751979 5.2178e-07 0.890501 0.0576042 1.00923 0.172812L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.0115208 8.40016 0.0115208C8.56259 0.0115208 8.70317 0.0691245 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587558C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#666666" />
                </svg>
            </div>
        </div>
        <button class="w-[97px] h-[35px] flex justify-center items-center bg-black border-[0.72px] border-solid rounded-[3px]">
            <span class="font-bold text-[11px] leading-3 text-center text-white">전액사용</span>
        </button>
    </div>
    <div class="mt-1.5 flex gap-1.5">
        <p class="font-bold text-[9px] leading-[10px] text-[#666666]">사용가능 적립금</p>
        <p class="font-bold text-[9px] leading-[10px] text-black">3,000원</p>
    </div>
</div>

<!-- 구분선 -->
<hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

<!-- 결제방법 -->
<div class="mt-[15px] flex flex-col w-full px-[14px]">
    <p class="font-extrabold text-lg leading-5 text-[#333333]">결제방법</p>

    <?php
    if ($int_type == 1) {
    ?>
        <!-- MEMBERSHIP -->
        <div class="flex flex-col w-full">
            <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-black">MEMBERSHIP</p>

            <!-- 미가입자 -->
            <div class="mt-3 flex justify-center items-center w-full">
                <div class="w-[210px] h-[140px] flex flex-col justify-center items-center bg-[#F5F5F5] border border-solid border-[#DDDDDD] rounded-[10px]">
                    <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#D9D9D9" />
                        </svg>
                    </div>
                    <p class="mt-[15px] font-extrabold text-[11px] leading-3 text-center text-[#666666]">MEMBERSHIP CARD</p>
                    <p class="mt-2 font-bold text-[8px] leading-[10px] text-center text-[#666666]">프리미엄 멤버십 미가입자입니다. <br />멤버십 가입 후 다양한 가방을 구독해보세요!</p>
                </div>
            </div>

            <!-- 가입자 -->
            <div class="mt-3 flex flex-col gap-[25px] items-center w-full">
                <div class="w-[210px] h-[140px] flex flex-col justify-center items-center bg-[#F1D58E] border border-solid border-[#DDDDDD] rounded-[10px]">
                    <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#F1D58E" />
                        </svg>
                    </div>
                    <p class="mt-[15px] font-extrabold text-[11px] leading-3 text-center text-black">MEMBERSHIP CARD</p>
                    <p class="mt-2 font-bold text-[8px] leading-[10px] text-center text-black">프리미엄 멤버십 미가입자입니다. <br />멤버십 가입 후 다양한 가방을 구독해보세요!</p>
                </div>
                <div class="flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                    <p class="font-bold text-[10px] leading-[140%] text-black">멤버십 결제 안내</p>
                    <p class="font-bold text-[10px] leading-[140%] text-[#666666]">
                        -멤버십 결제는 구독권이 갱신되는 매월 1일에 등록하신 카드로 자동결제 됩니다.
                        (마이페이지 > 쇼핑정보 > 에이블랑 결제관리에서 카드 삭제 및 변경가능합니다.)
                    </p>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    if ($int_type == 2 || $int_type == 3) {
    ?>
        <!-- 간편결제 -->
        <div class="flex flex-col w-full">
            <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-black">간편결제</p>
            <div class="mt-3 flex flex-col gap-[25px] justify-center items-center w-full">
                <div class="w-[210px] h-[140px] flex flex-col justify-center items-center border border-solid border-[#DDDDDD] rounded-[10px]">
                    <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                        <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.27684 0.225V8.065H16.9068V9.535H9.27684V17.865H7.73684V9.535H0.106836V8.065H7.73684V0.225H9.27684Z" fill="#DDDDDD" />
                        </svg>
                    </div>
                    <p class="mt-[15px] font-extrabold text-[11px] leading-3 text-center text-[#666666]">결제 카드를 등록해주세요.</p>
                    <p class="mt-2 font-bold text-[8px] leading-[10px] text-center text-[#666666]">마이페이지 > 쇼핑정보 > 에이블랑 결제관리에서 <br />카드 삭제 및 변경가능합니다.</p>
                </div>
                <div class="flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                    <p class="font-bold text-[10px] leading-[140%] text-black">블랑 렌트 멤버십 혜택 안내</p>
                    <p class="font-bold text-[10px] leading-[140%] text-[#666666]">블랑 렌트 멤버십으로 30% 추가할인 되셨습니다. 블랑 렌트 멤버십을 가입하시면 30% 추가할인 받을 수 있어요!</p>
                </div>
            </div>
        </div>

        <!-- 일반결제 -->
        <div class="flex flex-col gap-1.5 w-full">
            <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-black">일반결제</p>
            <div class="flex flex-col gap-1.5 w-full">
                <div x-data="{ cardType: 1 }" class="flex flex-row gap-[5px]">
                    <button class="flex justify-center items-center w-full h-[35px] border-[0.72px] border-solid rounded-[3px]" x-bind:class="cardType == 1 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="cardType = 1">
                        <p class="font-bold text-[11px] leading-3 text-[#666666]">신용/체크카드</p>
                    </button>
                    <button class="flex justify-center items-center w-full h-[35px] border-[0.72px] border-solid rounded-[3px]" x-bind:class="cardType == 2 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="cardType = 2">
                        <p class="font-bold text-[11px] leading-3 text-[#666666]">무통장 입금</p>
                    </button>
                </div>
                <div class="relative flex w-full">
                    <select name="" id="" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-[3px] px-2.5 w-full h-[35px] font-bold text-[11px] leading-3 text-[#666666]">
                        <option value="">현대카드</option>
                    </select>
                    <div class="absolute top-[15px] right-[15px] pointer-events-none">
                        <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576042 0.435356 5.34201e-07 0.593667 5.27991e-07C0.751979 5.2178e-07 0.890501 0.0576042 1.00923 0.172812L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.0115208 8.40016 0.0115208C8.56259 0.0115208 8.70317 0.0691245 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587558C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#666666" />
                        </svg>
                    </div>
                </div>
                <div class="relative flex w-full">
                    <select name="" id="" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-[3px] px-2.5 w-full h-[35px] font-bold text-[11px] leading-3 text-[#666666]">
                        <option value="">일시불</option>
                    </select>
                    <div class="absolute top-[15px] right-[15px] pointer-events-none">
                        <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576042 0.435356 5.34201e-07 0.593667 5.27991e-07C0.751979 5.2178e-07 0.890501 0.0576042 1.00923 0.172812L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.0115208 8.40016 0.0115208C8.56259 0.0115208 8.70317 0.0691245 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587558C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#666666" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                <p class="font-bold text-[10px] leading-[140%] text-black">무이자/부분 무이자 할부 혜택 안내</p>
                <p class="font-bold text-[10px] leading-[140%] text-[#666666]">
                    -공통: 2~5개월 (별도 신청 없이 적용)<br />
                    -삼성/국민카드: 2~12개월(별도 신청 없이 적용)
                </p>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<!-- 구분선 -->
<hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

<!-- 결제금액 -->
<?php
if ($int_type == 2 || $int_type == 3) {
?>
    <div x-data="{ isCollapsed: false }" class="mt-[15px] flex flex-col w-full px-[14px]">
        <div class="flex items-center justify-between">
            <p class="font-extrabold text-lg leading-5 text-[#333333]">결제금액</p>
            <div x-on:click="isCollapsed = !isCollapsed">
                <svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.2576 1.58525L7.81002 7.79723C7.73327 7.87097 7.65012 7.92307 7.56057 7.95355C7.47102 7.98452 7.37507 8 7.27273 8C7.17038 8 7.07444 7.98452 6.98489 7.95355C6.89534 7.92307 6.81218 7.87097 6.73543 7.79724L0.268649 1.58525C0.0895495 1.41321 -2.97318e-07 1.19816 -3.08598e-07 0.940092C-3.19879e-07 0.682027 0.0959459 0.46083 0.287838 0.276498C0.479731 0.0921659 0.703606 -3.07556e-08 0.959462 -4.19394e-08C1.21532 -5.31233e-08 1.43919 0.0921659 1.63109 0.276498L7.27273 5.69585L12.9144 0.276497C13.0935 0.104454 13.314 0.0184325 13.576 0.0184325C13.8385 0.0184325 14.0657 0.110598 14.2576 0.29493C14.4495 0.479262 14.5455 0.694316 14.5455 0.940091C14.5455 1.18587 14.4495 1.40092 14.2576 1.58525Z" fill="#333333" />
                </svg>
            </div>
        </div>
        <div x-show="!isCollapsed" class="mt-[15px] flex flex-col gap-2.5 w-full">
            <?php
            $total_price = $arr_Data['INT_PRICE'];
            $discount_price = $arr_Data['INT_DISCOUNT'] ? $arr_Data['INT_PRICE'] * $arr_Data['INT_DISCOUNT'] / 100 : 0;
            $membership_price = 0;
            $cupon_price = 0;
            $saved_price = 0;

            $pay_price = $total_price - $discount_price - $membership_price - $cupon_price - $saved_price;
            ?>
            <div class="flex items-center justify-between">
                <p class="font-bold text-[15px] leading-[17px] text-black">주문금액</p>
                <p class="font-bold text-[15px] leading-[17px] text-black"><?= number_format($total_price) ?>원</p>
            </div>
            <div class="flex items-center justify-between">
                <p class="font-bold text-[15px] leading-[17px] text-black">상품 할인금액</p>
                <p class="font-bold text-[15px] leading-[17px] text-black"><?= number_format($discount_price) ?>원</p>
            </div>
            <div class="flex items-center justify-between">
                <p class="font-bold text-[11px] leading-3 text-[#666666]">ㄴ 금액할인</p>
                <p class="font-bold text-[11px] leading-3 text-[#666666]">-<?= number_format($discount_price) ?>원</p>
            </div>
            <div class="flex items-center justify-between">
                <p class="font-bold text-[11px] leading-3 text-[#666666]">ㄴ 멤버십할인</p>
                <p class="font-bold text-[11px] leading-3 text-[#666666]">-<?= number_format($membership_price) ?>원</p>
            </div>
            <div class="flex items-center justify-between">
                <p class="font-bold text-[15px] leading-[17px] text-black">쿠폰할인</p>
                <p class="font-bold text-[15px] leading-[17px] text-black"><?= number_format($cupon_price) ?>원</p>
            </div>
            <div class="flex items-center justify-between">
                <p class="font-bold text-[15px] leading-[17px] text-black">적립금사용</p>
                <p class="font-bold text-[15px] leading-[17px] text-black"><?= number_format($saved_price) ?>원</p>
            </div>
            <hr class="mt-[5px] w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />
            <div class="mt-[5px] flex items-center justify-between">
                <p class="font-extrabold text-[15px] leading-[17px] text-[#DA2727]">총 결제예정금액</p>
                <p class="font-extrabold text-[15px] leading-[17px] text-right text-black"><?= number_format($pay_price) ?>원</p>
            </div>
        </div>
    </div>
<?php
}
?>

<!-- 구분선 -->
<hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

<!-- 약관동의 -->
<div class="mt-4 flex flex-col gap-2.5 px-[14px]">
    <div class="flex justify-between items-center">
        <div class="flex gap-[5px] items-center">
            <input type="checkbox" name="agree_terms" id="agree_terms" class="w-[14px] h-[14px]  accent-black">
            <label for="agree_terms" class="font-bold text-xs leading-[14px] text-[#666666]">보증금 약관 동의하기</label>
        </div>
        <a href="/m/help/deposit_agree.php" class="font-bold text-[9px] leading-[10px] text-right underline text-[#666666]">약관보기</a>
    </div>
    <div class="flex justify-between items-center">
        <div class="flex gap-[5px] items-center">
            <input type="checkbox" name="agree_payment" id="agree_payment" class="w-[14px] h-[14px]  accent-black">
            <label for="agree_payment" class="font-bold text-xs leading-[14px] text-[#666666]">약관 및 개인정보 제 3자 제공사항 결제 동의하기</label>
        </div>
        <a href="/m/help/privacy_agree.php" class="font-bold text-[9px] leading-[10px] text-right underline text-[#666666]">약관보기</a>
    </div>
</div>

<!-- 하단 메뉴 -->
<div class="fixed bottom-0 left-0 w-full flex h-[66px]">
    <?php
    if ($arr_Data['INT_TYPE'] == 2) {
    ?>
        <a href="simplepay.php" class="grow flex justify-center items-center h-[66px] bg-black border border-solid border-[#D9D9D9]">
            <span class="font-extrabold text-lg text-center text-white">구독 멤버십 가입하러 가기</span>
        </a>
    <?php
    } else {
    ?>
        <a href="simplepay.php" class="grow flex justify-center items-center h-[66px] bg-black border border-solid border-[#D9D9D9]">
            <span class="font-extrabold text-lg text-center text-white"><?= number_format($pay_price) ?>원 결제하기</span>
        </a>
    <?php
    }
    ?>
</div>

<!-- 카드등록 알람 -->
<div class="hidden fixed top-0 left-0 flex justify-center items-center w-full h-full bg-black bg-opacity-80 z-20">
    <div class="relative flex flex-col justify-center items-center w-[328px] h-[179px] bg-white border border-solid border-[#D9D9D9] rounded-[11px]">
        <button class="absolute top-[15px] right-[21px]">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <p class="font-bold text-[15px] leading-[17px] text-center text-black">카드를 등록해주세요.</p>
        <p class="mt-[11px] font-bold text-xs leading-[18px] text-center text-[#666666]">카드를 등록해주셔야 해당 상품 이용이 가능합니다. <br />하단 페이지에서 카드 등록을 완료해주세요.</p>
        <a class="mt-5 flex gap-[11px] items-center justify-center w-[144px] h-[30px] bg-white border border-solid border-[#D9D9D9]">
            <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">카드 등록 바로가기</p>
            <span>
                <svg width="6" height="11" viewBox="0 0 6 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.00296 9.92237L4.93324 5.83063C4.97989 5.78192 5.01285 5.72915 5.03213 5.67232C5.05173 5.61549 5.06152 5.5546 5.06152 5.48965C5.06152 5.4247 5.05173 5.36381 5.03213 5.30698C5.01285 5.25015 4.97989 5.19738 4.93324 5.14867L1.00296 1.04476C0.894112 0.931097 0.758049 0.874268 0.594774 0.874268C0.431499 0.874268 0.291548 0.935157 0.174922 1.05693C0.0582972 1.17871 -1.52588e-05 1.32079 -1.52588e-05 1.48316C-1.52588e-05 1.64553 0.0582972 1.7876 0.174922 1.90938L3.60371 5.48965L0.174922 9.06992C0.066072 9.18358 0.0116472 9.32355 0.0116472 9.48981C0.0116472 9.65641 0.0699596 9.80059 0.186585 9.92237C0.30321 10.0441 0.439273 10.105 0.594774 10.105C0.750274 10.105 0.886337 10.0441 1.00296 9.92237Z" fill="#666666" />
                </svg>
            </span>
        </a>
    </div>
</div>

<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer_detail.php"; ?>