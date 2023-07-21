<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<?php
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], 1);
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], '');

// 렌트인 경우
$start_date = Fnc_Om_Conv_Default($_REQUEST['start_date'], '');
$end_date = Fnc_Om_Conv_Default($_REQUEST['end_date'], '');

// 빈티지인 경우
$count = Fnc_Om_Conv_Default($_REQUEST['count'], '');

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
$product_Data = mysql_fetch_assoc($arr_Rlt_Data);

// 사이트 정보얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_site_info AS A
                WHERE
                    A.INT_NUMBER=1';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);

switch ($int_type) {
    case 1:
        //구독멤버십가입 여부 확인
        $is_subscription_membership = fnc_sub_member_info() > 0 ? true : false;

        //구독멤버십정보얻기
        if ($is_subscription_membership) {
            $SQL_QUERY =    'SELECT 
                                A.*
                            FROM 
                                `' . $Tname . 'comm_membership` A
                            WHERE 
                                A.STR_USERID = "' . $arr_Auth[0] . '"
                                AND NOW() BETWEEN A.DTM_SDATE AND A.DTM_EDATE
                                AND A.INT_TYPE = 1
                                AND A.STR_PASS = "0"';

            $arr_Rlt_Data = mysql_query($SQL_QUERY);
            $subscription_membership_Data = mysql_fetch_assoc($arr_Rlt_Data);
        }

        break;
    case 2:
        //렌트멤버십가입 여부 확인
        $is_rent_membership = fnc_ren_member_info() > 0 ? true : false;

        // 구간할인정보
        $date1 = new DateTime($start_date);
        $date2 = new DateTime($end_date);

        $use_days = $date1->diff($date2)->d + 1;

        $area_discount = 0;
        $product_discount = 0;
        $total_rent_money = $product_Data['INT_PRICE'] * $use_days;

        $updated_price = $product_Data['INT_PRICE'] - $product_Data['INT_PRICE'] * $product_Data['INT_DISCOUNT'] / 100;
        for ($rent_number = 1; $rent_number <= $use_days; $rent_number++) {
            if (($site_Data['INT_DSTART1'] ?: 0) <= $rent_number && $rent_number <= ($site_Data['INT_DEND1'] ?: 0)) {
                $area_discount += $updated_price * ($site_Data['INT_DISCOUNT1'] ?: 0) / 100;
            } else if (($site_Data['INT_DSTART2'] ?: 0) <= $rent_number && $rent_number <= ($site_Data['INT_DEND2'] ?: 0)) {
                $area_discount += $updated_price * ($site_Data['INT_DISCOUNT2'] ?: 0) / 100;
            } else if (($site_Data['INT_DSTART3'] ?: 0) <= $rent_number && $rent_number <= ($site_Data['INT_DEND3'] ?: 0)) {
                $area_discount += $updated_price * ($site_Data['INT_DISCOUNT3'] ?: 0) / 100;
            } else if (($site_Data['INT_DSTART4'] ?: 0) <= $rent_number && $rent_number <= ($site_Data['INT_DEND4'] ?: 0)) {
                $area_discount += $updated_price * ($site_Data['INT_DISCOUNT4'] ?: 0) / 100;
            }

            $product_discount += $product_Data['INT_PRICE'] * $product_Data['INT_DISCOUNT'] / 100;
        }

        $product_discount = round($product_discount ?: 0, -2);
        $area_discount = round($area_discount ?: 0, -2);
        $total_rent_money = $total_rent_money - $product_discount - $area_discount;

        $membership_discount = round(($total_rent_money * ($is_rent_membership ? 30 : 0) / 100) ?: 0, -2);
        $total_rent_money = $total_rent_money - $membership_discount;

        break;
    case 3:
        $product_discount = round(($product_Data['INT_PRICE'] * $product_Data['INT_DISCOUNT'] / 100) ?: 0, -2);
        break;
}

//카드정보얻기
$SQL_QUERY =    "SELECT 
                    A.*
                FROM 
                    `" . $Tname . "comm_member_pay` AS A
                WHERE
                    A.STR_USERID='$arr_Auth[0]'
                    AND A.STR_USING <> 'N'
                ORDER BY DTM_INDATE DESC
                LIMIT 1 ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$payment_Data = mysql_fetch_assoc($arr_Rlt_Data);

// 반납불가일 얻기
$SQL_QUERY =    'SELECT A.STR_DAY FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=1 AND A.INT_DTYPE=2';
$end_days_result = mysql_query($SQL_QUERY);
$end_days_array = array();
while ($row = mysql_fetch_assoc($end_days_result)) {
    $end_days_array[] = $row['STR_DAY'];

    // 구독상품인 경우 당일에 기사님이 가므로 1일 연장
    $end_days_array[] = strval(intval($row['STR_DAY']) + 1);
}

$SQL_QUERY =    'SELECT A.STR_DATE FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=2 AND A.INT_DTYPE=2';
$end_dates_result = mysql_query($SQL_QUERY);
$end_dates_array = array();
while ($row = mysql_fetch_assoc($end_dates_result)) {
    $end_dates_array[] = $row['STR_DATE'];

    // 구독상품인 경우 당일에 기사님이 가므로 1일 연장
    $end_dates_array[] = date('Y-m-d', strtotime($row['STR_DATE'] . ' +1 day'));
}

$SQL_QUERY =    'SELECT A.STR_WEEK FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=3 AND A.INT_DTYPE=2';
$end_weeks_result = mysql_query($SQL_QUERY);
$end_weeks_array = array();
while ($row = mysql_fetch_assoc($end_weeks_result)) {
    $end_weeks_array[] = $row['STR_WEEK'];

    // 구독상품인 경우 당일에 기사님이 가므로 1일 연장
    $end_weeks_array[] = strval((intval($row['STR_WEEK']) + 1) < 7 ? (intval($row['STR_WEEK']) + 1) : 0);
}
?>

<form x-data="{
    type: '',
    payAmount: {
        totalPrice: 0,
        price: <?= $int_type == 2 ? ($product_Data['INT_PRICE'] * $use_days) : $product_Data['INT_PRICE'] ?>,
        useDays: <?= $use_days ?: 0 ?>,
        discount: {
            product: <?= $product_discount ?: 0 ?>,
            area: <?= $area_discount ?: 0 ?>,
            membership: <?= $membership_discount ?: 0 ?>
        },
        coupon: 0,
        mileage: 0
    },
    calTotalPrice() {
        this.payAmount.totalPrice = this.payAmount.price - this.payAmount.discount.product - this.payAmount.discount.membership - this.payAmount.coupon - this.payAmount.mileage - this.payAmount.discount.area;
        this.payAmount.totalPrice = this.payAmount.totalPrice >= 0 ? this.payAmount.totalPrice : 0;
    },
    changeCoupon(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const couponValue = selectedOption.getAttribute('price');
        const couponPercent = selectedOption.getAttribute('percent');

        if (couponValue > 0) {
            this.payAmount.coupon = couponValue;
        } else {
            if (couponPercent > 0) {
                const beforePrice = this.payAmount.price - this.payAmount.discount.product - this.payAmount.discount.membership - this.payAmount.mileage - this.payAmount.discount.area;
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
    <input type="hidden" name="str_goodcode" value="<?= $str_goodcode ?>">
    <input type="hidden" name="good_name" value="<?= $product_Data['STR_GOODNAME'] ?>">

    <input type="hidden" name="buyr_name" value="<?= $user_Data['STR_NAME'] ?>">
    <input type="hidden" name="buyr_mail" value="<?= $user_Data['STR_EMAIL'] ?>">
    <input type="hidden" name="buyr_tel1" value="<?= $user_Data['STR_TELEP'] ?>">
    <input type="hidden" name="buyr_tel2" value="<?= $user_Data['STR_HP'] ?>">

    <input type="hidden" name="total_price" id="total_price" x-bind:value="payAmount.totalPrice">
    <input type="hidden" name="price" x-bind:value="payAmount.price">
    <input type="hidden" name="discount_product" x-bind:value="payAmount.discount.product">
    <input type="hidden" name="discount_area" x-bind:value="payAmount.discount.area">
    <input type="hidden" name="discount_membership" x-bind:value="payAmount.discount.membership">
    <input type="hidden" name="coupon" x-bind:value="payAmount.coupon">
    <input type="hidden" name="mileage" x-bind:value="payAmount.mileage">

    <input type="hidden" name="start_date" value="<?= $start_date ?>">
    <input type="hidden" name="end_date" value="<?= $end_date ?>">
    <input type="hidden" name="count" value="<?= $count ?>">

    <!-- 배송정보 -->
    <div x-data="{
        type: 1,
        customCompleted: false,
        deliveryInfo: {
            main: {
                name: '<?= $user_Data['STR_NAME'] ?>',
                telep: '<?= $user_Data['STR_HP'] ?>',
                hp: '<?= $user_Data['STR_SHP'] ?>',
                address1: '<?= $user_Data['STR_SADDR1'] ?>',
                address2: '<?= $user_Data['STR_SADDR2'] ?>',
                postal: '<?= $user_Data['STR_SPOST'] ?>'
            },
            new: {
                name: '<?= $user_Data['STR_NAME'] ?>',
                telep: '<?= $user_Data['STR_HP'] ?>',
                hp: '<?= $user_Data['STR_SHP'] ?>',
                address1: '',
                address2: '',
                postal: ''
            }
        },
        messageType: '',
        messageContent: '',
        addDeliveryAddress() {
            if (document.getElementById('set_main_delivery').checked) {
                this.deliveryInfo.main.name = document.getElementById('new_delivery_name').value;
                this.deliveryInfo.main.hp = document.getElementById('new_delivery_phone1').value + '-' + document.getElementById('new_delivery_phone2').value + '-' + document.getElementById('new_delivery_phone3').value;
                this.deliveryInfo.main.address1 = document.getElementById('new_delivery_address').value;
                this.deliveryInfo.main.address2 = document.getElementById('new_delivery_detail_address').value;
                this.deliveryInfo.main.postal = document.getElementById('new_delivery_postal_code').value;

                this.type = 1;

                updateMainAddress(this.deliveryInfo.main.address1, this.deliveryInfo.main.address2, this.deliveryInfo.main.postal);
            } else {
                this.deliveryInfo.new.name = document.getElementById('new_delivery_name').value;
                this.deliveryInfo.new.hp = document.getElementById('new_delivery_phone1').value + '-' + document.getElementById('new_delivery_phone2').value + '-' + document.getElementById('new_delivery_phone3').value;
                this.deliveryInfo.new.address1 = document.getElementById('new_delivery_address').value;
                this.deliveryInfo.new.address2 = document.getElementById('new_delivery_detail_address').value;
                this.deliveryInfo.new.postal = document.getElementById('new_delivery_postal_code').value;

                this.customCompleted = true;
            }
        }
    }" class="flex flex-col w-full px-[14px] pb-7 border-b-[0.5px] border-solid border-[#E0E0E0]">

        <input type="hidden" name="delivery_name" id="delivery_name" x-bind:value="type == 1 ? deliveryInfo.main.name : deliveryInfo.new.name">
        <input type="hidden" name="delivery_address1" id="delivery_address1" x-bind:value="type == 1 ? deliveryInfo.main.address1 : deliveryInfo.new.address1">
        <input type="hidden" name="delivery_address2" id="delivery_address2" x-bind:value="type == 1 ? deliveryInfo.main.address2 : deliveryInfo.new.address2">
        <input type="hidden" name="delivery_postal" id="delivery_postal" x-bind:value="type == 1 ? deliveryInfo.main.postal : deliveryInfo.new.postal">
        <input type="hidden" name="delivery_telep" id="delivery_telep" x-bind:value="type == 1 ? deliveryInfo.main.telep : deliveryInfo.new.telep">
        <input type="hidden" name="delivery_hp" id="delivery_hp" x-bind:value="type == 1 ? deliveryInfo.main.hp : deliveryInfo.new.hp">

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
        <div x-show="type == 1 || customCompleted" class="mt-[15px] flex flex-col w-full">
            <p class="font-bold text-[15px] leading-[17px] text-black" x-text="(customCompleted && type == 2) ? deliveryInfo.new.name : deliveryInfo.main.name">에이블랑</p>
            <p class="mt-[9px] font-medium text-xs leading-[14px] text-black" x-text="(customCompleted && type == 2) ? ('(' + deliveryInfo.new.postal + ') ' + deliveryInfo.new.address1 + ' ' + deliveryInfo.new.address2) : ('(' + deliveryInfo.main.postal + ') ' + deliveryInfo.main.address1 + ' ' + deliveryInfo.main.address2)">(03697) 서울특별시 서대문구 연희로27길 16 (연희동) 2층</p>
            <p class="mt-1.5 font-medium text-xs leading-[14px] text-[#666666]" x-text="(customCompleted && type == 2) ? (deliveryInfo.new.telep + ' / ' + deliveryInfo.new.hp) : (deliveryInfo.main.telep + ' / ' + deliveryInfo.main.hp)">010-9556-6439 / 031-572-6439</p>
            <div class="mt-3 relative flex w-full">
                <select name="delivery_memo_type" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-[3px] px-2.5 w-full h-[35px] font-normal text-xs leading-[15px] text-[#666666]" x-model="messageType">
                    <option value="" selected>배송시 요청사항을 선택해 주세요</option>
                    <option value="파손위험상품입니다. 배송시 주의해주세요.">파손위험상품입니다. 배송시 주의해주세요.</option>
                    <option value="부재시 전화 또는 문자 주세요">부재시 전화 또는 문자 주세요</option>
                    <option value="부재시 경비실에 맡겨 주세요">부재시 경비실에 맡겨 주세요</option>
                    <option value="부재시 문 앞에 놓아주세요">부재시 문 앞에 놓아주세요</option>
                    <option value="택배함에 넣어주세요">택배함에 넣어주세요</option>
                    <option value="배송전에 꼭 연락주세요">배송전에 꼭 연락주세요</option>
                    <option value="0">직접입력</option>
                </select>
                <div class="absolute top-[15px] right-[15px] pointer-events-none">
                    <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576042 0.435356 5.34201e-07 0.593667 5.27991e-07C0.751979 5.2178e-07 0.890501 0.0576042 1.00923 0.172812L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.0115208 8.40016 0.0115208C8.56259 0.0115208 8.70317 0.0691245 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587558C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#666666" />
                    </svg>
                </div>
            </div>
            <template x-if="messageType === '0'">
                <textarea class="mt-1.5 border-[0.72px] border-[#DDDDDD] rounded-[3px] p-2.5 w-full" name="delivery_memo" id="" cols="30" rows="6" x-model="messageContent"></textarea>
            </template>
        </div>
        <!-- 신규 배송지 -->
        <div x-show="type == 2 && !customCompleted" class="mt-[15px] flex flex-col gap-[15px] w-full" style="display: none;">
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">이름</p>
                <input type="text" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-normal text-xs leading-[14px] text-black" name="" id="new_delivery_name" value="<?= $user_Data['STR_NAME'] ?>" placeholder="이름을 입력해 주세요" readonly>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">연락처</p>
                <?php
                $str_shp = explode('-', $user_Data['STR_SHP']);

                $str_shp1 = $str_shp[0] ?: '010';
                $str_shp2 = $str_shp[1] ?: '';
                $str_shp3 = $str_shp[2] ?: '';
                ?>
                <div class="grid grid-cols-3 gap-[5px] w-full">
                    <input type="text" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-normal text-xs leading-[14px] text-black" name="" id="new_delivery_phone1" value="<?= $str_shp1 ?>" maxlength="3" placeholder="010" readonly>
                    <input type="text" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-normal text-xs leading-[14px] text-black" name="" id="new_delivery_phone2" value="<?= $str_shp2 ?>" maxlength="4" placeholder="1234" readonly>
                    <input type="text" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-normal text-xs leading-[14px] text-black" name="" id="new_delivery_phone3" value="<?= $str_shp3 ?>" maxlength="4" placeholder="5678" readonly>
                </div>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">주소</p>
                <div class="flex flex-col gap-[5px] w-full">
                    <div class="flex gap-[5px]">
                        <div class="grow">
                            <input type="text" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-normal text-xs leading-[14px] text-black disabled:bg-[#F5F5F5]" name="" id="new_delivery_postal_code" placeholder="우편번호" disabled>
                        </div>
                        <button type="button" class="flex justify-center items-center w-[97px] h-[45px] bg-[#EBEBEB] border border-solid border-[#DDDDDD]" id="search_address">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">검색</p>
                        </button>
                    </div>
                    <input type="text" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-normal text-xs leading-[14px] text-black disabled:bg-[#F5F5F5]" name="" id="new_delivery_address" placeholder="기본주소" disabled>
                    <input type="text" class="w-full h-[45px] bg-white border border-solid border-[#DDDDDD] px-[15px] placeholder-gray-[#999999] font-normal text-xs leading-[14px] text-black" name="" id="new_delivery_detail_address" placeholder="상세 주소를 입력해 주세요">
                </div>
            </div>
            <div class="flex gap-[5px] items-center">
                <input type="checkbox" class="w-[14px] h-[14px] accent-black" name="set_main_delivery" id="set_main_delivery" value="1" class="cform">
                <label for="set_main_delivery" class="font-bold text-xs leading-[14px] text-[#666666]">기본 배송지로 선택</label>
            </div>
            <button type="button" class="w-full h-[45px] bg-black border border-solid border-[#DDDDDD]" x-on:click="addDeliveryAddress()">
                <p class="font-bold text-xs leading-[14px] text-center text-white">등록하기</p>
            </button>
        </div>
    </div>

    <?php
    // 구독인 경우 반납상품현시
    if ($int_type == 1) {
        // 반납상품정보 얻기
        $SQL_QUERY =    'SELECT
                            B.*, C.STR_CODE AS STR_BRAND
                        FROM 
                            ' . $Tname . 'comm_goods_cart AS A
                        LEFT JOIN
                            ' . $Tname . 'comm_goods_master AS B
                        ON
                            A.STR_GOODCODE=B.STR_GOODCODE
                        LEFT JOIN
                            ' . $Tname . 'comm_com_code AS C
                        ON
                            B.INT_BRAND=C.INT_NUMBER
                        WHERE
                            A.INT_STATE=4
                            AND B.INT_TYPE=1
                            AND A.STR_USERID="' . $arr_Auth[0] . '"
                        LIMIT 1';

        $arr_Rlt_Data = mysql_query($SQL_QUERY);
        $return_product_Data = mysql_fetch_assoc($arr_Rlt_Data);

        if ($return_product_Data) {
    ?>
            <!-- 반납정보 -->
            <div class="mt-[15px] px-[14px] pb-7 border-b-[0.5px] border-solid border-[#E0E0E0]">
                <p class="font-extrabold text-lg leading-5 text-[#333333]">반납정보</p>
                <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-black"><?= $return_product_Data['STR_BRAND'] ?></p>
                <div class="mt-3 flex gap-[11px]">
                    <div class="w-[120px] h-[120px] flex justify-center items-center bg-[#F9F9F9] p-2.5">
                        <img class="w-full" src="/admincenter/files/good/<?= $return_product_Data['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
                    </div>
                    <div class="flex flex-col justify-start">
                        <div class="flex justify-center items-center max-w-[42px] px-2 py-1 w-auto bg-[#EEAC4C]">
                            <p class="font-normal text-[10px] leading-[11px] text-center text-white">구독</p>
                        </div>
                        <p class="mt-[15px] font-bold text-xs leading-[14px] text-[#666666]"><?= $return_product_Data['STR_GOODNAME'] ?></p>
                        <p class="mt-[10px] font-bold text-xs leading-[14px] text-[#666666]">월정액 구독 전용</p>
                        <div class="mt-1.5 flex gap-2 items-center">
                            <?php
                            if ($is_subscription_membership) {
                            ?>
                                <p class="font-bold text-xs leading-[14px] text-[#333333]"><span class="text-[#EEAC4C]">구독권 사용</span></p>
                            <?php
                            } else {
                            ?>
                                <p class="font-bold text-xs leading-[14px] text-[#333333]"><span class="text-[#EEAC4C]">월</span> <?= number_format($site_Data['INT_PRICE1']) ?>원</p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="mt-3 relative flex w-full">
                    <input type="hidden" name="return_product" value="<?= $return_product_Data['STR_GOODCODE'] ?>">
                    <select name="return_date" id="return_date" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-[3px] px-2.5 w-full h-[35px] font-normal text-[11px] leading-3 text-[#666666]">
                        <option value="" selected>반납 날짜를 선택해 주세요</option>
                        <?php
                        $temp_date = new DateTime();
                        $start_date = null;
                        $end_date = null;

                        // Check if the current time is before 5 PM
                        if (intval($temp_date->format('H')) < 17) {
                            $temp_date->modify('+1 day');
                        } else {
                            $temp_date->modify('+2 days');
                        }

                        do {
                            $setted = true;
                            $dateString = $temp_date->format('Y-m-d');

                            if (in_array($temp_date->format('d'), $end_days_array)) {
                                $setted = false;
                            } else if (in_array($temp_date->format('w'), $end_weeks_array)) {
                                $setted = false;
                            } else if (in_array($dateString, $end_dates_array)) {
                                $setted = false;
                            }

                            if ($setted) {
                                if ($start_date === null) {
                                    $start_date = clone $temp_date;
                                } else {
                                    $end_date = clone $temp_date;
                                }
                            }

                            $temp_date->modify('+1 day');
                        } while ($start_date === null || $end_date === null);

                        // Format the dates as options
                        $tomorrowOption = $start_date->format('Y-m-d');
                        $nextTomorrowOption = $end_date->format('Y-m-d');
                        ?>

                        <option value="<?php echo $tomorrowOption; ?>"><?php echo $tomorrowOption; ?></option>
                        <option value="<?php echo $nextTomorrowOption; ?>"><?php echo $nextTomorrowOption; ?></option>
                    </select>
                    <div class="absolute top-[15px] right-[15px] pointer-events-none">
                        <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576042 0.435356 5.34201e-07 0.593667 5.27991e-07C0.751979 5.2178e-07 0.890501 0.0576042 1.00923 0.172812L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.0115208 8.40016 0.0115208C8.56259 0.0115208 8.70317 0.0691245 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587558C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#666666" />
                        </svg>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <!-- 주문정보 -->
    <div class="mt-[15px] px-[14px] pb-7 border-b-[0.5px] border-solid border-[#E0E0E0]">
        <p class="font-extrabold text-lg leading-5 text-[#333333]">주문정보</p>
        <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-black"><?= $product_Data['STR_BRAND'] ?></p>
        <div class="mt-3 flex gap-[11px]">
            <div class="w-[120px] h-[120px] flex justify-center items-center bg-[#F9F9F9] p-2.5">
                <img class="w-full" src="/admincenter/files/good/<?= $product_Data['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
            </div>
            <div class="flex flex-col justify-start">
                <div class="flex justify-center items-center max-w-[42px] px-2 py-1 w-auto bg-[<?= ($int_type == 1 ? '#EEAC4C' : ($int_type == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                    <p class="font-normal text-[10px] leading-[11px] text-center text-white"><?= ($int_type == 1 ? '구독' : ($int_type == 2 ? '렌트' : '빈티지'))  ?></p>
                </div>
                <p class="mt-[15px] font-bold text-xs leading-[14px] text-[#666666]"><?= $product_Data['STR_GOODNAME'] ?></p>
                <?php
                switch ($int_type) {
                    case 1:
                ?>
                        <p class="mt-[10px] font-bold text-xs leading-[14px] text-[#666666]">월정액 구독 전용</p>
                        <div class="mt-1.5 flex gap-2 items-center">
                            <?php
                            if ($is_subscription_membership) {
                            ?>
                                <p class="font-bold text-xs leading-[14px] text-[#333333]"><span class="text-[#EEAC4C]">구독권 사용</span></p>
                            <?php
                            } else {
                            ?>
                                <p class="font-bold text-xs leading-[14px] text-[#333333]"><span class="text-[#EEAC4C]">월</span> <?= number_format($site_Data['INT_PRICE1']) ?>원</p>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                        break;

                    case 2:
                    ?>
                        <p class="mt-[10px] font-medium text-xs leading-[14px] text-[#666666] <?= $product_Data['INT_DISCOUNT'] ? '' : 'hidden' ?>">할인가</p>
                        <div class="mt-1.5 flex gap-1 items-center">
                            <p class="font-bold text-xs leading-[14px] text-[#00402F] <?= $product_Data['INT_DISCOUNT'] ? '' : 'hidden' ?>"><?= $product_Data['INT_DISCOUNT'] ?>%</p>
                            <p class="font-bold text-xs leading-[14px] text-[#333333]"><span class="font-medium">일</span> <?= number_format($product_Data['INT_PRICE'] - $product_Data['INT_PRICE'] * $product_Data['INT_DISCOUNT'] / 100) ?>원</p>
                        </div>
                    <?php
                        break;
                    case 3:
                    ?>
                        <p class="mt-[10px] font-bold text-xs leading-[14px] line-through text-[#666666] <?= $product_Data['INT_DISCOUNT'] ? '' : 'hidden' ?>"><?= number_format($product_Data['INT_PRICE']) ?>원</p>
                        <div class="mt-1.5 flex gap-2 items-center">
                            <p class="font-bold text-xs leading-[14px] text-[#7E6B5A] <?= $product_Data['INT_DISCOUNT'] ? '' : 'hidden' ?>"><?= $product_Data['INT_DISCOUNT'] ?>%</p>
                            <p class="font-bold text-xs leading-[14px] text-[#333333]"><?= number_format($product_Data['INT_PRICE'] - $product_Data['INT_PRICE'] * $product_Data['INT_DISCOUNT'] / 100) ?>원</p>
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
            <?php
            switch ($int_type) {
                case 1:
            ?>
                    <div class="flex gap-5">
                        <p class="font-bold text-xs leading-[14px] text-[#999999]">이용날짜</p>
                        <p class="font-medium text-xs leading-[14px] text-[#666666]"><?= date('Y. m. d', time()) ?></p>
                    </div>
                <?php
                    break;
                case 2:
                ?>
                    <div class="flex gap-5">
                        <p class="font-bold text-xs leading-[14px] text-[#999999]">이용날짜</p>
                        <p class="font-medium text-xs leading-[14px] text-[#666666]"><?= date('Y. m. d', strtotime($start_date)) ?> ~ <?= date('Y. m. d', strtotime($end_date)) ?></p>
                    </div>
                <?php
                    break;
                case 3:
                ?>
                    <div class="flex gap-5">
                    </div>
            <?php
                    break;
            }
            ?>
            <div class="flex gap-5">
                <p class="font-bold text-xs leading-[14px] text-[#999999]">배송분류</p>
                <p class="font-medium text-xs leading-[14px] text-[#666666]">무료배송</p>
            </div>
            <div class="flex gap-5">
                <p class="font-bold text-xs leading-[14px] text-[#999999]">등급할인</p>
                <p class="font-medium text-xs leading-[14px] text-[#666666]">
                    <?php
                    switch ($int_type) {
                        case 1:
                            echo '미해당';
                            break;
                        case 2:
                            echo '적용가능';
                            break;
                        case 3:
                            echo '적용가능';
                            break;
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>

    <!-- 쿠폰/적립금 -->
    <?php
    if ($int_type != 1) {
    ?>
        <div class="mt-[15px] px-[14px] pb-7 border-b-[0.5px] border-solid border-[#E0E0E0]">
            <p class="font-extrabold text-lg leading-5 text-[#333333]">쿠폰/적립금</p>
            <div class="mt-[15px] relative flex w-full">
                <?php
                $SQL_QUERY =    'SELECT 
                                    COUNT(A.INT_NUMBER) AS COUPON_COUNT
                                FROM 
                                    ' . $Tname . 'comm_member_coupon A
                                WHERE 
                                    A.STR_USED="N"
                                    AND A.STR_USERID="' . $arr_Auth[0] . '"
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
    <?php
    }
    ?>

    <!-- 결제방법 -->
    <div class="mt-[15px] flex flex-col w-full px-[14px] pb-7 border-b-[0.5px] border-solid border-[#E0E0E0]">
        <p class="font-extrabold text-lg leading-5 text-[#333333]">결제방법</p>
        <?php
        if ($int_type == 1) {
        ?>
            <!-- MEMBERSHIP -->
            <div class="flex flex-col w-full">
                <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-black">MEMBERSHIP</p>

                <?php
                if ($is_subscription_membership && $subscription_membership_Data) {
                    $sub_end_date = $subscription_membership_Data['DTM_EDATE']; // Replace with your actual end date

                    $datetime1 = new DateTime();
                    $datetime2 = new DateTime($sub_end_date);
                    $interval = $datetime1->diff($datetime2);

                    $days_left = $interval->format('%a');
                ?>
                    <!-- 가입자 -->
                    <div class="mt-3 flex flex-col gap-[25px] items-center w-full">
                        <div class="w-[280px] h-[165px] flex flex-col justify-center items-center bg-[#F1D58E] border border-solid border-[#DDDDDD] rounded-[10px]">
                            <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                                <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#F1D58E" />
                                </svg>
                            </div>
                            <p class="mt-[15px] font-extrabold text-[14px] leading-4 text-center text-black">MEMBERSHIP CARD</p>
                            <p class="mt-2 font-medium text-xs leading-[14px] text-center text-black">
                                프리미엄 구독권 잔여일이 <span class="font-bold underline"><?= $days_left + 1 ?></span>일 남았습니다.<br>
                                마이페이지에서 구독 연장/취소 신청 가능합니다.
                            </p>
                        </div>
                        <div class="flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                            <p class="font-bold text-xs leading-[14px] text-black">멤버십 결제 안내</p>
                            <p class="font-medium text-[10px] leading-[14px] text-[#666666]">
                                -멤버십 결제는 구독권이 갱신되는 매월 1일에 등록하신 카드로 자동결제 됩니다.<br>
                                (마이페이지 > 쇼핑정보 > 에이블랑 결제관리에서 카드 삭제 및 변경가능합니다.)
                            </p>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <!-- 미가입자 -->
                    <div class="mt-3 flex justify-center items-center w-full">
                        <div class="w-[280px] h-[165px] flex flex-col justify-center items-center bg-[#F5F5F5] border border-solid border-[#DDDDDD] rounded-[10px]">
                            <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                                <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#D9D9D9" />
                                </svg>
                            </div>
                            <p class="mt-[15px] font-extrabold text-[14px] leading-4 text-center text-[#666666]">MEMBERSHIP CARD</p>
                            <p class="mt-2 font-medium text-xs leading-[14px] text-center text-[#666666]">
                                프리미엄 멤버십 미가입자입니다. <br>
                                멤버십 가입 후 다양한 가방을 구독해보세요!<br>
                            </p>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        } else {
        ?>
            <div class="mt-[15px] flex flex-col w-full">
                <?php
                if ($int_type == 2) {
                ?>
                    <div class="flex flex-col gap-3 w-full">
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
                                        <p class="font-bold text-xs leading-[10px] text-white">**** **** **** <?= $payment_Data['STR_CARDNO'] ? substr($payment_Data['STR_CARDNO'], -4) : '' ?></p>
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
                            if ($int_type == 2) {
                            ?>
                                <div class="flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                                    <p class="font-bold text-xs leading-[14px] text-black">블랑 렌트 멤버십 혜택 안내</p>
                                    <p class="font-normal text-[10px] leading-3 text-[#666666]">
                                        블랑 렌트 멤버십으로 30% 추가할인 되셨습니다.<br>
                                        블랑 렌트 멤버십을 가입하시면 30% 추가할인 받을 수 있어요!
                                    </p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <!-- 일반결제 -->
                    <div class="mt-[25px] flex flex-col gap-1.5 w-full">
                        <p class="font-bold text-[15px] leading-[17px] text-black">일반결제</p>
                        <div class="flex flex-col gap-1.5 w-full">
                            <div x-data="{ cardType: 1 }" class="flex flex-row gap-[5px]">
                                <input type="hidden" name="card_type" x-model="cardType">
                                <button type="button" class="flex justify-center items-center w-full h-[35px] border-[0.72px] border-solid rounded-[3px]" x-bind:class="cardType == 1 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="cardType = 1">
                                    <p class="font-bold text-[11px] leading-3 text-[#666666]">신용/체크카드</p>
                                </button>
                                <button type="button" class="flex justify-center items-center w-full h-[35px] border-[0.72px] border-solid rounded-[3px]" x-bind:class="cardType == 2 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="cardType = 2">
                                    <p class="font-bold text-[11px] leading-3 text-[#666666]">무통장 입금</p>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                            <p class="font-bold text-xs leading-[14px] text-black">무이자/부분 무이자 할부 혜택 안내</p>
                            <p class="font-normal text-[10px] leading-3 text-[#666666]">
                                -공통: 2~5개월 (별도 신청 없이 적용)<br />
                                -삼성/국민카드: 2~12개월(별도 신청 없이 적용)
                            </p>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- 결제금액 -->
    <?php
    if ($int_type == 2 || $int_type == 3) {
    ?>
        <div x-data="{ isCollapsed: false }" class="mt-[15px] flex flex-col w-full px-[14px] pb-7 border-b-[0.5px] border-solid border-[#E0E0E0]">
            <div class="flex items-center justify-between">
                <p class="font-extrabold text-lg leading-5 text-[#333333]">결제금액</p>
                <div class="cursor-pointer" x-on:click="isCollapsed = !isCollapsed" x-bind:class="isCollapsed ? 'rotate-180' : 'rotate-0'">
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
                        <p class="font-bold text-[15px] leading-[17px] text-black">상품 할인금액</p>
                        <p class="font-bold text-[15px] leading-[17px] text-black" x-text="formatNumber(payAmount.discount.product + payAmount.discount.area + payAmount.discount.membership) + '원'"></p>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="font-bold text-[11px] leading-3 text-[#666666]">ㄴ 금액할인</p>
                        <p class="font-bold text-[11px] leading-3 text-[#666666]" x-text="'-' + formatNumber(payAmount.discount.product) + '원'"></p>
                    </div>
                    <?php
                    if ($int_type == 2) {
                    ?>
                        <div class="flex items-center justify-between">
                            <p class="font-bold text-[11px] leading-3 text-[#666666]">ㄴ 구간할인</p>
                            <p class="font-bold text-[11px] leading-3 text-[#666666]" x-text="'-' + formatNumber(payAmount.discount.area) + '원'"></p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="font-bold text-[11px] leading-3 text-[#666666]">ㄴ 멤버십할인</p>
                            <p class="font-bold text-[11px] leading-3 text-[#666666]" x-text="'-' + formatNumber(payAmount.discount.membership) + '원'"></p>
                        </div>
                    <?php
                    }
                    ?>
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
    <?php
    }
    ?>

    <!-- 약관동의 -->
    <?php
    if ($int_type != 1) {
    ?>
        <div class="mt-4 flex flex-col gap-2.5 px-[14px]">
            <div class="flex justify-between items-center">
                <div class="flex gap-[5px] items-center">
                    <input type="checkbox" name="agree_terms" id="agree_terms" class="w-[14px] h-[14px] accent-black cursor-pointer">
                    <label for="agree_terms" class="font-bold text-xs leading-[14px] text-[#666666] cursor-pointer">보증금 약관 동의하기</label>
                </div>
                <a href="/m/help/deposit_agree.php" class="font-medium text-[10px] leading-3 text-right underline text-[#666666]">약관보기</a>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex gap-[5px] items-center">
                    <input type="checkbox" name="agree_payment" id="agree_payment" class="w-[14px] h-[14px] accent-black cursor-pointer">
                    <label for="agree_payment" class="font-bold text-xs leading-[14px] text-[#666666] cursor-pointer">약관 및 개인정보 제 3자 제공사항 결제 동의하기</label>
                </div>
                <a href="/m/help/privacy_agree.php" class="font-medium text-[10px] leading-3 text-right underline text-[#666666]">약관보기</a>
            </div>
        </div>
    <?php
    }
    ?>

    <!-- 하단 메뉴 -->
    <div class="fixed bottom-0 w-full flex h-[66px] max-w-[410px]">
        <?php
        if ($int_type == 1) {
            if ($is_subscription_membership) {
        ?>
                <button type="button" class="grow flex justify-center items-center h-[66px] bg-black border border-solid border-[#D9D9D9]" onclick="paySubscription()">
                    <span class="font-extrabold text-lg text-center text-white">구독하기</span>
                </button>
            <?php
            } else {
            ?>
                <a href="/m/mine/membership/index.php?int_type=1" type="button" class="grow flex justify-center items-center h-[66px] bg-black border border-solid border-[#D9D9D9]">
                    <span class="font-extrabold text-lg text-center text-white">구독 멤버십 가입하러 가기</span>
                </a>
            <?php
            }
        } else {
            ?>
            <button type="button" class="grow flex justify-center items-center h-[66px] bg-black border border-solid border-[#D9D9D9]" onclick="payKCP(<?= $int_type ?>)">
                <span class="font-extrabold text-lg text-center text-white" x-text="formatNumber(payAmount.totalPrice) + '원 결제하기'"></span>
            </button>
        <?php
        }
        ?>
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
    $(document).ready(function() {
        // 주소 검색 버튼 클릭 이벤트 처리
        $('#search_address').click(function() {
            new daum.Postcode({
                oncomplete: function(data) {
                    // 선택한 주소의 우편번호와 주소 입력하기
                    $('#new_delivery_postal_code').val(data.zonecode);
                    $('#new_delivery_address').val(data.address);
                }
            }).open();
        });
    });

    function paySubscription() {
        if (ValidChk(1) == false) return;

        document.frm.action = "sub_process.php";
        document.frm.submit();
    }

    function payKCP(int_type) {
        if (ValidChk(int_type) == false) return;

        if (int_type == 2 && <?= $payment_Data ? 'false' : 'true' ?>) {
            document.getElementById('payment_alert').style.display = 'flex';
            return;
        }

        // document.frm.action = "/kcp_payment/mobile_sample/order_mobile.php";
        document.frm.action = "sub_process.php";
        document.frm.submit();
    }

    function ValidChk(int_type) {
        if (int_type == 1) {
            if (<?= $return_product_Data ? 'true' : 'false' ?> && $('#return_date').val() == '') {
                alert('반납날짜를 선택해주십시요.');
                return false;
            }
        } else {
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

    function updateMainAddress(str_saddr1, str_saddr2, str_spost) {
        url = "/m/memberjoin/edit_address_proc.php";
        url += "?str_spost=" + str_spost;
        url += "&str_saddr1=" + str_saddr1;
        url += "&str_saddr2=" + str_saddr2;

        $.ajax({
            url: url,
            success: function(result) {

            }
        });
    }
</script>