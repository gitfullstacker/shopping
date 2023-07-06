<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<?php
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], 1);

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

// 사이트 정보얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_site_info AS A
                WHERE
                    A.INT_NUMBER=1';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);

//카드정보얻기
$SQL_QUERY =    "SELECT 
                    A.*
                FROM 
                    `" . $Tname . "comm_member_pay` AS A
                WHERE
                    A.STR_PASS='0' 
                    AND A.STR_USERID='$arr_Auth[0]'
                ORDER BY DTM_INDATE
                LIMIT 1 ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$payment_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<form x-data="{
    type: '',
    payAmount: {
        totalPrice: 0,
        price: <?= $int_type == 1 ? $site_Data['INT_PRICE1'] : $site_Data['INT_PRICE2'] ?>,
        coupon: 0,
        mileage: 0
    },
    calTotalPrice() {
        this.payAmount.totalPrice = this.payAmount.price - this.payAmount.coupon - this.payAmount.mileage;
    },
    changeCoupon(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const couponValue = selectedOption.getAttribute('price');
        const couponPercent = selectedOption.getAttribute('percent');

        if (couponValue > 0) {
            this.payAmount.coupon = couponValue;
        } else {
            if (couponPercent > 0) {
                const beforePrice = this.payAmount.price - this.payAmount.mileage;
                this.payAmount.coupon = this.roundNumber(beforePrice * couponPercent / 100);
            } else {
                this.payAmount.coupon = 0;
            }
        }
        this.calTotalPrice();
    },
    changeMileage(mileage) {
        this.payAmount.mileage = mileage;
        this.calTotalPrice();
    },
    formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    },
    roundNumber(number) {
        return Math.round(number / 100) * 100;
    },
    init() {
        this.calTotalPrice();
    }
}" id="frm" name="frm" action="" method="post" class="mt-[30px] flex flex-col w-full">
    <input type="hidden" name="int_type" value="<?= $int_type ?>">
    <input type="hidden" name="good_name" value="<?= $int_type == 1 ? '구독멤버십' : '렌트멥버십' ?>">

    <input type="hidden" name="total_price" id="total_price" x-bind:value="payAmount.totalPrice">
    <input type="hidden" name="price" x-bind:value="payAmount.price">
    <input type="hidden" name="coupon" x-bind:value="payAmount.coupon">
    <input type="hidden" name="mileage" x-bind:value="payAmount.mileage">

    <!-- 주문정보 -->
    <div class="px-[14px] pb-7 border-b-[0.5px] border-solid border-[#E0E0E0]">
        <p class="font-extrabold text-lg leading-5 text-[#333333]">주문정보</p>
        <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-black"><?= $int_type == 1 ? '에이블랑 구독 멤버십' : '블랑 렌트 멤버십' ?></p>
        <div class="mt-3 flex gap-[11px]">
            <div class="w-[120px] h-[120px] flex justify-center items-center bg-[#F9F9F9]">
                <img class="w-full" src="images/<?= $int_type == 1 ? 'subscription_image.png' : 'rent_image.png' ?>" onerror="this.style.display = 'none'" alt="">
            </div>
            <div class="flex flex-col justify-start">
                <div class="flex justify-center items-center max-w-[42px] px-2 py-1 w-auto bg-[<?= $int_type == 1 ? '#EEAC4C' : '#00402F' ?>]">
                    <p class="font-normal text-[10px] leading-[11px] text-center text-white">멤버십</p>
                </div>
                <p class="mt-[15px] font-bold text-xs leading-[14px] text-[#666666]"><?= $int_type == 1 ? '에이블랑 구독 멤버십' : '블랑 렌트 멤버십' ?></p>
                <p class="mt-1.5 font-bold text-xs leading-[14px] text-black">월 <?= number_format($int_type == 1 ? $site_Data['INT_PRICE1'] : $site_Data['INT_PRICE2']) ?>원</p>
            </div>
        </div>
        <!-- 구분선 -->
        <hr class="mt-5 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />
        <div class="mt-[15px] flex flex-col gap-1.5">
            <div class="flex gap-5">
                <p class="font-bold text-xs leading-[14px] text-[#999999]">배송분류</p>
                <p class="font-medium text-xs leading-[14px] text-[#666666]">미해당</p>
            </div>
            <div class="flex gap-5">
                <p class="font-bold text-xs leading-[14px] text-[#999999]">등급할인</p>
                <p class="font-medium text-xs leading-[14px] text-[#666666]">미해당</p>
            </div>
        </div>
    </div>

    <!-- 쿠폰/적립금 -->
    <div class="mt-[15px] px-[14px] pb-7 border-b-[0.5px] border-solid border-[#E0E0E0]">
        <p class="font-extrabold text-lg leading-5 text-[#333333]">쿠폰/적립금</p>
        <div class="mt-[15px] relative flex w-full">
            <?php
            $SQL_QUERY =    'SELECT 
                                COUNT(A.INT_NUMBER) AS COUPON_COUNT
                            FROM 
                                ' . $Tname . 'comm_member_coupon A
                            WHERE 
                                A.STR_USERID="' . $arr_Auth[0] . '"
                                AND NOW() BETWEEN A.DTM_SDATE AND A.DTM_EDATE';

            $total_coupon_result = mysql_query($SQL_QUERY);
            $total_coupon_data = mysql_fetch_assoc($total_coupon_result);

            $SQL_QUERY =    'SELECT 
                                A.INT_NUMBER, A.DTM_SDATE, A.DTM_EDATE, B.INT_VALUE, B.STR_PERCENT, B.STR_TITLE
                            FROM 
                                ' . $Tname . 'comm_member_coupon A
                            LEFT JOIN
                                ' . $Tname . 'comm_coupon B
                            ON
                                A.INT_COUPON=B.INT_NUMBER
                            WHERE 
                                A.STR_USED="N"
                                AND A.STR_USERID="' . $arr_Auth[0] . '"
                                AND NOW() BETWEEN A.DTM_SDATE AND A.DTM_EDATE
                                AND (B.INT_TYPE=0 OR B.INT_TYPE=' . $int_type . ')
                            ORDER BY A.DTM_INDATE DESC';

            $coupon_list_result = mysql_query($SQL_QUERY);
            ?>
            <select name="int_coupon" id="" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-[3px] px-2.5 w-full h-[35px] font-normal text-xs leading-[15px] text-[#666666]" x-on:change="changeCoupon($event.target)">
                <option value="" price="0">사용가능 쿠폰 <?= mysql_num_rows($coupon_list_result) ?>장 / 전체 <?= $total_coupon_data['COUPON_COUNT'] ?>장</option>
                <?php
                while ($row = mysql_fetch_assoc($coupon_list_result)) {
                ?>
                    <option value="<?= $row['INT_NUMBER'] ?>" price="<?= $row['STR_PERCENT'] == 'N' ? ($row['INT_VALUE'] ?: 0) : 0 ?>" percent="<?= $row['STR_PERCENT'] == 'Y' ? ($row['INT_VALUE'] ?: 0) : 0 ?>"><?= $row['STR_TITLE'] ?></option>
                <?php
                }
                ?>
            </select>
            <div class="absolute top-[15px] right-[15px] pointer-events-none">
                <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576042 0.435356 5.34201e-07 0.593667 5.27991e-07C0.751979 5.2178e-07 0.890501 0.0576042 1.00923 0.172812L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.0115208 8.40016 0.0115208C8.56259 0.0115208 8.70317 0.0691245 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587558C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#666666" />
                </svg>
            </div>
        </div>
        <div class="mt-[5px] flex gap-[5px]">
            <input type="number" min="0" max="100" step="1" name="" id="mileage_input" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-[3px] px-2.5 w-full h-[35px] font-normal text-xs leading-[15px] text-[#666666]" oninput="validateMoneyInput(this, <?= $user_Data['INT_MILEAGE'] ?: 0 ?>)" x-on:change="changeMileage($event.target.value)">
            <button type="button" class="w-[97px] h-[35px] flex justify-center items-center bg-black border-[0.72px] border-solid rounded-[3px]" onclick="document.getElementById('mileage_input').value = <?= $user_Data['INT_MILEAGE'] ?: 0 ?>" x-on:click="changeMileage(<?= $user_Data['INT_MILEAGE'] ?: 0 ?>)">
                <span class="font-bold text-xs leading-[15px] text-center text-white">전액사용</span>
            </button>
        </div>
        <div class="mt-1.5 flex gap-1.5 items-center">
            <p class="font-bold text-[10px] leading-3 text-[#666666]">사용가능 적립금</p>
            <p class="font-bold text-[10px] leading-3 text-black"><?= number_format($user_Data['INT_MILEAGE'] ?: 0) ?>원</p>
        </div>
    </div>

    <!-- 결제방법 -->
    <div class="mt-[15px] flex flex-col w-full px-[14px] pb-7 border-b-[0.5px] border-solid border-[#E0E0E0]">
        <p class="font-extrabold text-lg leading-5 text-[#333333]">결제방법</p>
        <div class="mt-[15px] flex flex-col gap-3 w-full">
            <p class="font-bold text-[15px] leading-[17px] text-black">간편결제</p>
            <div class="flex flex-col gap-[25px] justify-center items-center w-full">
                <?php
                if ($payment_Data) {
                ?>
                    <div class="w-[280px] h-[165px] flex flex-col border border-solid border-[#DDDDDD] rounded-[10px] bg-[#2395FF]">
                        <div class="flex p-[15px] h-[112px]">
                            <p class="font-bold text-xs leading-[14px] text-white"><?= fnc_card_kind($payment_Data['STR_CARDCODE']) ?></p>
                        </div>
                        <hr class="border-t-[1px] border-white">
                        <div class="flex-1 flex justify-end items-center px-[15px]">
                            <p class="font-bold text-xs leading-[10px] text-white">**** **** **** 1234</p>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <a href="/m/mine/payment/index.php" class="w-[280px] h-[165px] flex flex-col justify-center items-center border border-solid border-[#DDDDDD] rounded-[10px]">
                        <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                            <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.27684 0.225V8.065H16.9068V9.535H9.27684V17.865H7.73684V9.535H0.106836V8.065H7.73684V0.225H9.27684Z" fill="#DDDDDD" />
                            </svg>
                        </div>
                        <p class="mt-[15px] font-extrabold text-sm leading-4 text-center text-[#666666]">결제 카드를 등록해주세요.</p>
                        <p class="mt-2 font-medium text-xs leading-[14px] text-center text-[#666666]">마이페이지 > 쇼핑정보 > 에이블랑 결제관리에서 <br />카드 삭제 및 변경가능합니다.</p>
                    </a>
                <?php
                }
                ?>
                <?php
                switch ($int_type) {
                    case 1:
                ?>
                        <div class="flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                            <p class="font-bold text-xs leading-[14px] text-black">멤버십 결제 안내</p>
                            <p class="font-normal text-[10px] leading-3 text-[#666666]">
                                -멤버십 결제는 구독권이 갱신되는 매월 1일에 등록하신 카드로 자동결제 됩니다.<br>
                                (마이페이지 > 쇼핑정보 > 에이블랑 결제관리에서 카드 삭제 및 변경가능합니다.)
                            </p>
                        </div>
                    <?php
                        break;
                    case 2:
                    ?>
                        <div class="flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                            <p class="font-bold text-xs leading-[14px] text-black">블랑 렌트 멤버십 혜택 안내</p>
                            <p class="font-normal text-[10px] leading-3 text-[#666666]">
                                블랑 렌트 멤버십으로 30% 추가할인 되셨습니다.<br>
                                블랑 렌트 멤버십을 가입하시면 30% 추가할인 받을 수 있어요!
                            </p>
                        </div>
                <?php
                        break;
                }
                ?>
            </div>
        </div>
    </div>

    <!-- 결제금액 -->
    <div x-data="{ isCollapsed: false }" class="mt-[15px] flex flex-col w-full px-[14px] pb-7 border-b-[0.5px] border-solid border-[#E0E0E0]">
        <div class="flex items-center justify-between">
            <p class="font-extrabold text-lg leading-5 text-[#333333]">결제금액</p>
            <div x-on:click="isCollapsed = !isCollapsed" x-bind:class="isCollapsed ? 'rotate-180' : 'rotate-0'">
                <svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.2576 1.58525L7.81002 7.79723C7.73327 7.87097 7.65012 7.92307 7.56057 7.95355C7.47102 7.98452 7.37507 8 7.27273 8C7.17038 8 7.07444 7.98452 6.98489 7.95355C6.89534 7.92307 6.81218 7.87097 6.73543 7.79724L0.268649 1.58525C0.0895495 1.41321 -2.97318e-07 1.19816 -3.08598e-07 0.940092C-3.19879e-07 0.682027 0.0959459 0.46083 0.287838 0.276498C0.479731 0.0921659 0.703606 -3.07556e-08 0.959462 -4.19394e-08C1.21532 -5.31233e-08 1.43919 0.0921659 1.63109 0.276498L7.27273 5.69585L12.9144 0.276497C13.0935 0.104454 13.314 0.0184325 13.576 0.0184325C13.8385 0.0184325 14.0657 0.110598 14.2576 0.29493C14.4495 0.479262 14.5455 0.694316 14.5455 0.940091C14.5455 1.18587 14.4495 1.40092 14.2576 1.58525Z" fill="#333333" />
                </svg>
            </div>
        </div>
        <div class="mt-[15px] flex flex-col gap-2.5 w-full">
            <div x-show="!isCollapsed" class="flex flex-col gap-2.5 w-full">
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[15px] leading-[17px] text-black">주문금액</p>
                    <p class="font-bold text-[15px] leading-[17px] text-black" x-text="formatNumber(payAmount.price) + '원'"></p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[15px] leading-[17px] text-black">쿠폰할인</p>
                    <p class="font-bold text-[15px] leading-[17px] text-black" x-text="formatNumber(payAmount.coupon) + '원'"></p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[15px] leading-[17px] text-black">적립금사용</p>
                    <p class="font-bold text-[15px] leading-[17px] text-black" x-text="formatNumber(payAmount.mileage) + '원'"></p>
                </div>
            </div>
            <hr class="mt-[5px] w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />
            <div class="mt-[5px] flex items-center justify-between">
                <p class="font-extrabold text-[15px] leading-[17px] text-[#DA2727]">총 결제예정금액</p>
                <p class="font-extrabold text-[15px] leading-[17px] text-right text-black" x-text="formatNumber(payAmount.totalPrice) + '원'"></p>
            </div>
        </div>
    </div>

    <!-- 약관동의 -->
    <div class="mt-4 flex flex-col gap-2.5 px-[14px]">
        <div class="flex justify-between items-center">
            <div class="flex gap-[5px] items-center">
                <input type="checkbox" name="agree_terms" id="agree_terms" class="w-[14px] h-[14px] accent-black">
                <label for="agree_terms" class="font-bold text-xs leading-[14px] text-[#666666]">보증금 약관 동의하기</label>
            </div>
            <a href="/m/help/deposit_agree.php" class="font-medium text-[10px] leading-3 text-right underline text-[#666666]">약관보기</a>
        </div>
        <div class="flex justify-between items-center">
            <div class="flex gap-[5px] items-center">
                <input type="checkbox" name="agree_payment" id="agree_payment" class="w-[14px] h-[14px] accent-black">
                <label for="agree_payment" class="font-bold text-xs leading-[14px] text-[#666666]">약관 및 개인정보 제 3자 제공사항 결제 동의하기</label>
            </div>
            <a href="/m/help/privacy_agree.php" class="font-medium text-[10px] leading-3 text-right underline text-[#666666]">약관보기</a>
        </div>
    </div>

    <!-- 하단 메뉴 -->
    <div class="fixed bottom-0 w-full flex h-[66px] max-w-[410px]">
        <button type="button" class="grow flex justify-center items-center h-[66px] bg-black border border-solid border-[#D9D9D9]" onclick="payKCP(<?= $int_type ?>)">
            <span class="font-extrabold text-lg text-center text-white" x-text="formatNumber(payAmount.totalPrice) + '원 결제하기'"></span>
        </button>
    </div>
</form>

<!-- 카드등록 알람 -->
<div id="payment_alert" class="fixed top-0 flex justify-center items-center w-full h-full bg-black bg-opacity-80 z-20 max-w-[410px]" style="display: none;">
    <div class="relative flex flex-col justify-center items-center w-[328px] h-[179px] bg-white border border-solid border-[#D9D9D9] rounded-[11px]">
        <button class="absolute top-[15px] right-[21px]" onclick="javascript:document.getElementById('payment_alert').style.display = 'none';">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <p class="font-bold text-[15px] leading-[17px] text-center text-black">카드를 등록해주세요.</p>
        <p class="mt-[11px] font-bold text-xs leading-[18px] text-center text-[#666666]">카드를 등록해주셔야 해당 상품 이용이 가능합니다. <br />하단 페이지에서 카드 등록을 완료해주세요.</p>
        <a href="/m/mine/payment/index.php" class="mt-5 flex gap-[11px] items-center justify-center w-[144px] h-[30px] bg-white border border-solid border-[#D9D9D9]">
            <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">카드 등록 바로가기</p>
            <span>
                <svg width="6" height="11" viewBox="0 0 6 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.00296 9.92237L4.93324 5.83063C4.97989 5.78192 5.01285 5.72915 5.03213 5.67232C5.05173 5.61549 5.06152 5.5546 5.06152 5.48965C5.06152 5.4247 5.05173 5.36381 5.03213 5.30698C5.01285 5.25015 4.97989 5.19738 4.93324 5.14867L1.00296 1.04476C0.894112 0.931097 0.758049 0.874268 0.594774 0.874268C0.431499 0.874268 0.291548 0.935157 0.174922 1.05693C0.0582972 1.17871 -1.52588e-05 1.32079 -1.52588e-05 1.48316C-1.52588e-05 1.64553 0.0582972 1.7876 0.174922 1.90938L3.60371 5.48965L0.174922 9.06992C0.066072 9.18358 0.0116472 9.32355 0.0116472 9.48981C0.0116472 9.65641 0.0699596 9.80059 0.186585 9.92237C0.30321 10.0441 0.439273 10.105 0.594774 10.105C0.750274 10.105 0.886337 10.0441 1.00296 9.92237Z" fill="#666666" />
                </svg>
            </span>
        </a>
    </div>
</div>

<?php
$hide_footer_menu = true;
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    function payKCP(int_type) {
        if (int_type == 2 && <?= $payment_Data ? 'false' : 'true' ?>) {
            document.getElementById('payment_alert').style.display = 'flex';
            return;
        }

        if (ValidChk() == false) return;

        // document.frm.action = "/kcp_payment/mobile_sample/order_mobile.php";
        document.frm.action = "sub_process.php";
        document.frm.submit();
    }

    function ValidChk() {
        var checkbox1 = $('#agree_terms').is(':checked');
        var checkbox2 = $('#agree_payment').is(':checked');

        if (!checkbox1 || !checkbox2) {
            event.preventDefault(); // Prevent the default redirect behavior
            alert('약관동의에 동의하셔야 합니다.');
            return false;
        }

        var total_price = $('#total_price').val();
        if (total_price <= 0) {
            alert('상품가격을 다시 확인해주십시요.');
            return false;
        }

        return true;
    }

    function validateMoneyInput(input, max_value = 0) {
        // Get the entered value
        let value = parseFloat(input.value);

        // Check if the entered value is within the specified range
        if (isNaN(value) || value < 0 || value > max_value) {
            // Clear the input value
            input.value = '';
        }
    }
</script>