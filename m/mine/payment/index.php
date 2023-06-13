<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
//카드정보얻기
$SQL_QUERY =    'SELECT
                    A.*, B.STR_BATCH_KEY
                FROM 
                    ' . $Tname . 'comm_member AS A
                LEFT JOIN 
                    ' . $Tname . 'comm_member_payment AS B
                ON
                    A.STR_USERID=B.STR_USERID
                WHERE
                    A.STR_USERID="' . $arr_Auth[0] . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$card_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div class="mt-[30px] flex flex-col items-center w-full px-[14px]">
    <p class="font-extrabold text-lg leading-5 text-black">자동 결제 수단 등록</p>
    <?php
    if (!$card_Data['STR_BATCH_KEY']) {
    ?>
        <!-- 카드가 등록된 상태 -->
        <div class="flex flex-col items-center gap-8 w-full">
            <!-- 카드 -->
            <div class="mt-[22px] flex flex-col border border-solid border-black bg-[#2395FF] rounded-[10px] relative w-[280px] h-[165px]">
                <button class="absolute top-2 right-2 flex justify-center items-center w-[14px] h-[14px] bg-black">
                    <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.208 2.976L0 0.636001L0.648 0L2.856 2.34L5.064 0L5.712 0.636001L3.504 2.976L5.712 5.316L5.064 5.952L2.856 3.612L0.648 5.952L0 5.316L2.208 2.976Z" fill="white" />
                    </svg>
                </button>
                <div class="flex p-[15px] h-[112px]">
                    <p class="font-bold text-xs leading-[14px] text-white">삼성카드</p>
                </div>
                <hr class="border-t-[1px] border-white">
                <div class="flex-1 flex justify-end items-center px-[15px]">
                    <p class="font-bold text-xs leading-[10px] text-white">**** **** **** 1234</p>
                </div>
            </div>
            <!-- 대표 카드 변경 -->
            <button class="flex justify-center items-center w-full h-[45px] border-[0.72px] border-solid border-[#DDDDDD] bg-whtie" onclick="javascript:document.forms.auto_pay_form.submit();">
                <p class="font-bold text-xs leading-[14px] text-[#666666]">대표 카드 변경</p>
            </button>
        </div>
    <?php
    } else {
    ?>
        <!-- 등록된 카드가 없는 상태 -->
        <div class="flex">
            <!-- 카드 -->
            <button class="mt-[22px] flex flex-col gap-[15px] justify-center items-center border border-solid border-[#DDDDDD] bg-white rounded-[10px] w-[280px] h-[165px]" onclick="javascript:document.forms.auto_pay_form.submit();">
                <div class="flex justify-center items-center w-[42px] h-[42px] bg-white border border-solid border-[#DDDDDD] rounded-full">
                    <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.17 0V7.84H16.8V9.31H9.17V17.64H7.63V9.31H0V7.84H7.63V0H9.17Z" fill="#DDDDDD" />
                    </svg>
                </div>
                <p class="font-bold text-sm leading-4 text-[#666666]">결제 카드를 등록해보세요.</p>
            </button>
        </div>
    <?php
    }
    ?>

    <form class="hidden" name="auto_pay_form" action="/kcp_mobile_auto/mobile_auth/order_mobile.php" method="post">
        <input type="hidden" name="good_name" value="">
        <input type="hidden" name="good_mny" value="">
        <input type="hidden" name="buyr_name" value="<?= $card_Data['STR_NAME'] ?>">
        <input type="hidden" name="buyr_mail" value="<?= $card_Data['STR_EMAIL'] ?>">
        <input type="hidden" name="buyr_tel1" value="<?= $card_Data['STR_TELEP'] ?>">
        <input type="hidden" name="buyr_tel2" value="<?= $card_Data['STR_HP'] ?>">
    </form>

    <div class="mt-[15px] flex flex-col gap-[7px] w-full px-[9px] py-[15px] bg-[#F5F5F5]">
        <p class="font-bold text-xs leading-[14px] text-black">자동 결제 수단 등록 안내</p>
        <p class="font-normal text-[10px] leading-4 text-[#999999]">
            -본인 명의의 카드만 등록 가능합니다.<br>
            -만 19세 이상 성인에게만 제공되는 서비스입니다.<br>
            -무이자 및 할부 혜택은 카드 일반 결제에서만 가능합니다.<br>
            -구독권 정기 결제는 무이자 및 할부 혜택을 받을 수 없습니다.<br>
        </p>
    </div>

    <?php
    if ($card_Data) {
    ?>
        <!-- 결제 내역 -->
        <div class="mt-[30px] flex flex-col w-full">
            <p class="font-extrabold text-sm leading-[15px] text-black">결제 내역</p>
            <hr class="mt-[14px] border-t-[0.5px] border-solid border-[#E0E0E0]" />
            <div class="mt-[15px] relative flex w-full">
                <select name="" id="" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-[3px] px-2.5 w-full h-[45px] font-normal text-xs leading-[14px] text-[#666666]">
                    <option value="3">최근 3개월</option>
                    <option value="6">최근 6개월</option>
                    <option value="12">최근 12개월</option>
                </select>
                <div class="absolute top-5 right-5 pointer-events-none">
                    <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.6398 1.67005L6.79074 5.86313C6.73301 5.9129 6.67047 5.94807 6.60312 5.96865C6.53578 5.98955 6.46362 6 6.38665 6C6.30968 6 6.23752 5.98955 6.17017 5.96865C6.10282 5.94807 6.04028 5.9129 5.98256 5.86313L1.11904 1.67005C0.98434 1.55392 0.916992 1.40876 0.916992 1.23456C0.916992 1.06037 0.989151 0.91106 1.13347 0.786636C1.27779 0.662212 1.44616 0.6 1.63858 0.6C1.83101 0.6 1.99938 0.662212 2.1437 0.786636L6.38665 4.4447L10.6296 0.786635C10.7643 0.670507 10.9302 0.612442 11.1272 0.612442C11.3246 0.612442 11.4955 0.674654 11.6398 0.799078C11.7841 0.923502 11.8563 1.06866 11.8563 1.23456C11.8563 1.40046 11.7841 1.54562 11.6398 1.67005Z" fill="#333333" />
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex flex-col w-full">
                <?php
                for ($i = 0; $i < 5; $i++) {
                ?>
                    <div class="flex flex-row w-full justify-between py-[15px] border-b-[0.5px] border-[#E0E0E0]">
                        <div class="flex flex-col">
                            <p class="font-normal text-[10px] leading-[11px] text-[#999999]">2023.02.12</p>
                            <p class="mt-1.5 font-bold text-xs leading-[14px] text-[#666666]">결제완료</p>
                            <p class="mt-[5px] font-bold text-xs leading-[14px] text-[#999999]">주문번호: 20230210100</p>
                        </div>
                        <div class="flex flex-col justify-between">
                            <div class="flex items-center gap-[5px]">
                                <p class="font-normal text-[10px] leading-[11px] text-[#999999]">상세보기</p>
                                <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.990783 7.35158L4.87327 4.02704C4.91936 3.98747 4.95192 3.94459 4.97097 3.89842C4.99032 3.85224 5 3.80277 5 3.75C5 3.69723 4.99032 3.64776 4.97097 3.60158C4.95192 3.55541 4.91936 3.51253 4.87327 3.47295L0.990783 0.138522C0.883256 0.0461741 0.748848 0 0.587558 0C0.426268 0 0.288019 0.0494723 0.172812 0.148417C0.0576043 0.247361 0 0.362797 0 0.494723C0 0.626649 0.0576043 0.742084 0.172812 0.841029L3.55991 3.75L0.172812 6.65897C0.0652847 6.75132 0.0115209 6.86504 0.0115209 7.00013C0.0115209 7.13549 0.0691247 7.25264 0.184332 7.35158C0.299539 7.45053 0.433948 7.5 0.587558 7.5C0.741168 7.5 0.875576 7.45053 0.990783 7.35158Z" fill="#999999" />
                                </svg>
                            </div>
                            <p class="font-bold text-xs leading-[14px] text-black">55,000원</p>
                        </div>
                    </div>
                <?
                }
                ?>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>