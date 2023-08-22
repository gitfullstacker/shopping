<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<link href="css/style.css" rel="stylesheet">

<?php
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], '');

$SQL_QUERY = 'UPDATE ' . $Tname . 'comm_goods_master SET INT_VIEW=INT_VIEW + 1 WHERE STR_GOODCODE=' . $str_goodcode;
mysql_query($SQL_QUERY);

if ($arr_Auth[0]) {

    $SQL_QUERY = 'SELECT COUNT(A.INT_NUMBER) AS COUNT FROM ' . $Tname . 'comm_member_seen A WHERE A.STR_USERID="' . $arr_Auth[0] . '" AND A.STR_GOODCODE="' . $str_goodcode . '"';
    $arr_Rlt_Data = mysql_query($SQL_QUERY);

    if ($arr_Rlt_Data) {
        $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

        if ($arr_Data['COUNT'] > 0) {
            $SQL_QUERY = 'UPDATE ' . $Tname . 'comm_member_seen SET DTM_INDATE="' . date("Y-m-d H:i:s") . '" WHERE STR_USERID="' . $arr_Auth[0] . '" AND STR_GOODCODE="' . $str_goodcode . '"';
            mysql_query($SQL_QUERY);
        } else {
            $SQL_QUERY = 'INSERT INTO ' . $Tname . 'comm_member_seen (STR_GOODCODE, STR_USERID, DTM_INDATE) VALUES ("' . $str_goodcode . '", "' . $arr_Auth[0] . '", "' . date("Y-m-d H:i:s") . '")';
            mysql_query($SQL_QUERY);
        }
    }
}

$SQL_QUERY =    'SELECT
                    A.*, B.STR_CODE AS STR_BRAND, (SELECT COUNT(C.STR_GOODCODE) FROM ' . $Tname . 'comm_member_like C WHERE A.STR_GOODCODE=C.STR_GOODCODE AND C.STR_USERID="' . ($arr_Auth[0] ?: 'NULL') . '") AS IS_LIKE, (SELECT COUNT(D.STR_GOODCODE) FROM ' . $Tname . 'comm_member_basket D WHERE A.STR_GOODCODE=D.STR_GOODCODE AND D.STR_USERID="' . ($arr_Auth[0] ?: 'NULL') . '") AS IS_BASKET
                FROM 
                    ' . $Tname . 'comm_goods_master A
                LEFT JOIN
                    ' . $Tname . 'comm_com_code B
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

// 금액정보얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_site_info A
                WHERE
                    A.INT_NUMBER=1';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);

switch ($arr_Data['INT_TYPE']) {
    case 1:
        // 구독멤버십가입 여부 확인
        $is_subscription_membership = fnc_sub_member_info() > 0 ? true : false;

        // 입고알림이 되여있는지 확인
        $SQL_QUERY =    'SELECT 
                            COUNT(A.STR_GOODCODE) AS COUNT 
                        FROM 
                            ' . $Tname . 'comm_member_alarm A
                        WHERE
                            A.STR_USERID="' . $arr_Auth[0] . '"
                            AND A.STR_GOODCODE=' . $str_goodcode;

        $arr_Rlt_Data = mysql_query($SQL_QUERY);
        $alarm_Data = mysql_fetch_assoc($arr_Rlt_Data);

        // 다른 상품을 구독중인지 확인
        $SQL_QUERY =    'SELECT 
                            COUNT(A.STR_GOODCODE) AS COUNT 
                        FROM 
                            ' . $Tname . 'comm_goods_cart A
                        LEFT JOIN
                            ' . $Tname . 'comm_goods_master AS B
                        ON
                            A.STR_GOODCODE=B.STR_GOODCODE
                        WHERE
                            A.STR_USERID="' . $arr_Auth[0] . '"
                            AND B.INT_TYPE=1
                            AND A.INT_STATE IN (1, 2, 3)';

        $arr_Rlt_Data = mysql_query($SQL_QUERY);
        $other_Sub_Data = mysql_fetch_assoc($arr_Rlt_Data);

        // 렌트가능한 상품정보 얻기
        $rent_number = fnc_cart_info($str_goodcode);
        break;
    case 2:
        //렌트멤버십가입 여부 확인
        $is_rent_membership = fnc_ren_member_info() > 0 ? true : false;
        break;
}
?>

<div x-data="{
        rentDate: null,
        vintageCount: 0,
        vintageOMoney: 0,
        vintageMoney: 0,
        showCalendar: false,
        showSubscriptionAlert: false,
        customAlert: {
            show: false,
            text: ''
        },
        showVintagePanel: false,
        goSubscription() {
            if (<?= $is_subscription_membership ? 'false' : 'true' ?>) {
                this.showSubscriptionAlert = true;
            } else if (<?= $other_Sub_Data['COUNT'] > 0 ? 'true' : 'false' ?>) {
                this.customAlert.show = true;
                this.customAlert.text = '현재 접수중인 상품이 있습니다. <br>배송완료 후 교환신청이 가능합니다.';
            } else {
                window.location.href = '/m/pay/index.php?int_type=1&str_goodcode=<?= $arr_Data['STR_GOODCODE'] ?>';
            }
        },
        goRent() {
            if (this.rentDate == null) {
                this.showCalendar = true;
            } else {
                const startDate = this.rentDate.startDate.getFullYear().toString() + '-' + (this.rentDate.startDate.getMonth() + 1).toString().padStart(2, '0') + '-' + this.rentDate.startDate.getDate().toString().padStart(2, '0');
                const endDate = this.rentDate.endDate.getFullYear().toString() + '-' + (this.rentDate.endDate.getMonth() + 1).toString().padStart(2, '0') + '-' + this.rentDate.endDate.getDate().toString().padStart(2, '0');

                window.location.href = '/m/pay/index.php?int_type=2&str_goodcode=<?= $arr_Data['STR_GOODCODE'] ?>&start_date=' + startDate + '&end_date=' + endDate;
            }
        },
        goVintage() {
            if (this.vintageCount == 0) {
                this.addVintageCount();
                this.showVintagePanel = true;
            } else {
                window.location.href = '/m/pay/index.php?int_type=3&str_goodcode=<?= $arr_Data['STR_GOODCODE'] ?>&count=' + this.vintageCount;
            }
        },
        addVintageCount() {
            if (this.vintageCount < 1) {
                this.vintageCount++;
                this.vintageOMoney = <?= $arr_Data['INT_PRICE'] ?> * this.vintageCount;
                this.vintageMoney = <?= $arr_Data['INT_PRICE'] - $arr_Data['INT_PRICE'] * $arr_Data['INT_DISCOUNT'] / 100 ?> * this.vintageCount;
            }
        },
        removeVintageCount() {
            if (this.vintageCount > 0) {
                this.vintageCount--;
                this.vintageOMoney = <?= $arr_Data['INT_PRICE'] ?> * this.vintageCount;
                this.vintageMoney = <?= $arr_Data['INT_PRICE'] - $arr_Data['INT_PRICE'] * $arr_Data['INT_DISCOUNT'] / 100 ?> * this.vintageCount;
            }
        },
        initVintageCount() {
            this.vintageCount = 0;
            this.vintageOMoney = 0;
            this.vintageMoney = 0;
        }
    }" class="flex flex-col w-full">
    <!-- 렌트 제품_상세_관련 상품 리뷰 -->
    <div class="flex flex-col w-full">
        <!-- 슬라이더 -->
        <div class="slider-section">
            <?php
            for ($i = 1; $i <= 5; $i++) {
                if ($arr_Data['STR_IMAGE' . $i]) {
                    $first_image = $first_image ?: $arr_Data['STR_IMAGE' . $i];
            ?>
                    <div class="bg-gray-100">
                        <img class="w-[410px]" src="/admincenter/files/good/<?= $arr_Data['STR_IMAGE' . $i] ?>" onerror="this.style.display='none'" alt="">
                    </div>
            <?php
                }
            }
            ?>
        </div>

        <!-- 제품정보 -->
        <div class="flex flex-col w-full mt-[30px] px-[14px]">
            <div class="flex justify-between">
                <!-- 타그 -->
                <div class="flex justify-center items-center px-2 py-1 bg-[<?= ($arr_Data['INT_TYPE'] == 1 ? '#EEAC4C' : ($arr_Data['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                    <p class="font-normal text-xs leading-[14px] text-center text-white"><?= ($arr_Data['INT_TYPE'] == 1 ? '구독' : ($arr_Data['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?></p>
                </div>
                <!-- Like -->
                <div class="cursor-pointer" onclick="setProductLike('<?= $arr_Data['STR_GOODCODE'] ?>')">
                    <svg id="is_like_no" style="<?= $arr_Data['IS_LIKE'] > 0 ? 'display:none;' : '' ?>" width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.78561 16.7712L8.78511 16.7707C6.20323 14.4295 4.0883 12.5088 2.61474 10.706C1.14504 8.90792 0.35 7.26994 0.35 5.5C0.35 2.60372 2.61288 0.35 5.5 0.35C7.13419 0.35 8.70844 1.11256 9.73441 2.30795L10 2.6174L10.2656 2.30795C11.2916 1.11256 12.8658 0.35 14.5 0.35C17.3871 0.35 19.65 2.60372 19.65 5.5C19.65 7.26994 18.855 8.90792 17.3853 10.706C15.9117 12.5088 13.7968 14.4295 11.2149 16.7707L11.2144 16.7712L10 17.8767L8.78561 16.7712Z" stroke="#666666" stroke-width="0.7" />
                    </svg>
                    <svg id="is_like_yes" style="<?= $arr_Data['IS_LIKE'] > 0 ? '' : 'display:none;' ?>" width="20" height="19" viewBox="0 0 20 19" fill="#FF0000" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.78561 16.7712L8.78511 16.7707C6.20323 14.4295 4.0883 12.5088 2.61474 10.706C1.14504 8.90792 0.35 7.26994 0.35 5.5C0.35 2.60372 2.61288 0.35 5.5 0.35C7.13419 0.35 8.70844 1.11256 9.73441 2.30795L10 2.6174L10.2656 2.30795C11.2916 1.11256 12.8658 0.35 14.5 0.35C17.3871 0.35 19.65 2.60372 19.65 5.5C19.65 7.26994 18.855 8.90792 17.3853 10.706C15.9117 12.5088 13.7968 14.4295 11.2149 16.7707L11.2144 16.7712L10 17.8767L8.78561 16.7712Z" stroke="#666666" stroke-width="0.7" />
                    </svg>
                </div>
            </div>
            <p class="mt-[9px] font-extrabold text-[14px] leading-4 text-[#666666]"><?= $arr_Data['STR_BRAND'] ?></p>
            <p class="mt-[5px] font-extrabold text-lg leading-5 text-[#333333]"><?= $arr_Data['STR_GOODNAME'] ?></p>
            <?php
            switch ($arr_Data['INT_TYPE']) {
                case 1:
            ?>
                    <p class="mt-[15px] font-semibold text-[14px] text-[#666666]">월정액 구독 전용</p>
                    <div class="mt-[7px] flex gap-2 items-end">
                        <p class="font-extrabold text-lg leading-5 text-[#333333]"><span class="text-[#EEAC4C]">월</span> <?= number_format($site_Data['INT_OPRICE1']) ?>원</p>
                    </div>
                <?php
                    break;

                case 2:
                ?>
                    <p class="mt-[15px] font-semibold text-[14px] leading-4 line-through text-[#666666] <?= $arr_Data['INT_DISCOUNT'] ? '' : 'hidden' ?>">일 <?= number_format($arr_Data['INT_PRICE']) ?>원</p>
                    <div class="mt-[7px] flex gap-2 items-end">
                        <p class="font-extrabold text-lg leading-5 text-[#00402F] <?= $arr_Data['INT_DISCOUNT'] ? '' : 'hidden' ?>"><?= number_format($arr_Data['INT_DISCOUNT']) ?>%</p>
                        <p class="font-extrabold text-lg leading-5 text-[#333333]">일 <?= number_format($arr_Data['INT_PRICE'] - $arr_Data['INT_PRICE'] * $arr_Data['INT_DISCOUNT'] / 100) ?>원</p>
                    </div>
                <?php
                    break;
                case 3:
                ?>
                    <p class="mt-[15px] font-semibold text-[14px] leading-4 text-[#666666]">최대 할인적용가</p>
                    <div class="mt-[7px] flex gap-2 items-end">
                        <p class="font-extrabold text-lg leading-5 text-[#7E6B5A] <?= $arr_Data['INT_DISCOUNT'] ? '' : 'hidden' ?>"><?= number_format($arr_Data['INT_DISCOUNT']) ?>%</p>
                        <p class="font-extrabold text-lg leading-5 text-[#333333]"><?= number_format($arr_Data['INT_PRICE'] - $arr_Data['INT_PRICE'] * $arr_Data['INT_DISCOUNT'] / 100) ?>원</p>
                        <p class="font-semibold text-[14px] leading-4 line-through text-[#666666] <?= $arr_Data['INT_DISCOUNT'] ? '' : 'hidden' ?>"><?= number_format($arr_Data['INT_PRICE']) ?>원</p>
                    </div>
            <?php
                    break;
            }
            ?>
        </div>

        <?php
        if ($arr_Data['INT_TYPE'] == 1) {
        ?>
            <!-- 프리미엄 멤버십 (정기결제) -->
            <div class="flex px-[14px] mt-4 w-full">
                <div class="flex flex-col gap-2.5 w-full border-[0.72px] border-solid border-[#DDDDDD] bg-[#FFF3E1] p-[14px]">
                    <a href="/m/mine/membership/index.php?int_type=1" class="flex justify-center items-center w-full h-10 bg-[#EEAC4C]">
                        <p class="font-bold text-sm leading-4 text-white">정기구독 월 <?= number_format($site_Data['INT_PRICE1']) ?>원</p>
                    </a>
                </div>
            </div>
        <?php
        }
        ?>

        <!-- 구분선 -->
        <hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

        <?php
        if ($arr_Data['INT_TYPE'] == 3) {
        ?>
            <!-- 할인정보 -->
            <div class="mt-[15px] px-[14px] flex flex-col gap-[15px]">
                <button class="flex flex-col gap-[3px] justify-center items-center w-full h-[49px] bg-[#7E6B5A] border border-solid border-[#DDDDDD]">
                    <span class="flex gap-[1px] items-center">
                        <svg width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.3 0C0.955218 0 0.624558 0.144866 0.380761 0.402728C0.136964 0.660591 0 1.01033 0 1.375V4.125C0.344781 4.125 0.675442 4.26987 0.919239 4.52773C1.16304 4.78559 1.3 5.13533 1.3 5.5C1.3 5.86467 1.16304 6.21441 0.919239 6.47227C0.675442 6.73013 0.344781 6.875 0 6.875V9.625C0 9.98967 0.136964 10.3394 0.380761 10.5973C0.624558 10.8551 0.955218 11 1.3 11H11.7C12.0448 11 12.3754 10.8551 12.6192 10.5973C12.863 10.3394 13 9.98967 13 9.625V6.875C12.6552 6.875 12.3246 6.73013 12.0808 6.47227C11.837 6.21441 11.7 5.86467 11.7 5.5C11.7 5.13533 11.837 4.78559 12.0808 4.52773C12.3246 4.26987 12.6552 4.125 13 4.125V1.375C13 1.01033 12.863 0.660591 12.6192 0.402728C12.3754 0.144866 12.0448 0 11.7 0H1.3ZM8.775 2.0625L9.75 3.09375L4.225 8.9375L3.25 7.90625L8.775 2.0625ZM4.4265 2.09C5.0635 2.09 5.577 2.63313 5.577 3.30688C5.577 3.62961 5.45579 3.93913 5.24003 4.16734C5.02427 4.39554 4.73163 4.52375 4.4265 4.52375C3.7895 4.52375 3.276 3.98063 3.276 3.30688C3.276 2.98414 3.39721 2.67462 3.61297 2.44641C3.82873 2.21821 4.12137 2.09 4.4265 2.09ZM8.5735 6.47625C9.2105 6.47625 9.724 7.01937 9.724 7.69312C9.724 8.01586 9.60279 8.32538 9.38703 8.55359C9.17127 8.78179 8.87863 8.91 8.5735 8.91C7.9365 8.91 7.423 8.36687 7.423 7.69312C7.423 7.37039 7.54421 7.06087 7.75997 6.83266C7.97573 6.60446 8.26837 6.47625 8.5735 6.47625Z" fill="white" />
                        </svg>
                        <span class="font-bold text-[11px] leading-[12px] text-center text-white">빈티지 제품 전용 할인 코드 2583849</span>
                    </span>
                    <span class="font-bold text-[8px] leading-[9px] text-center text-white">(2023. 07. 31 까지)</span>
                </button>
                <div class="w-full flex flex-col gap-[9px]">
                    <div class="flex gap-5">
                        <p class="font-bold text-xs text-[#999999]">상품등급</p>
                        <p class="font-semibold text-xs text-[#666666]">
                            <?php
                            switch ($arr_Data['INT_GRADE']) {
                                case 1:
                                    echo 'PRESERVED';
                                    break;
                                case 2:
                                    echo 'S CLASS';
                                    break;
                                case 3:
                                    echo 'A CLASS';
                                    break;
                                case 4:
                                    echo 'B CLASS';
                                    break;
                                case 5:
                                    echo 'C CLASS';
                                    break;
                            }
                            ?>(하단 상세참조)
                        </p>
                    </div>
                    <div class="flex gap-5">
                        <p class="font-bold text-xs text-[#999999]">예상적립</p>
                        <!-- <p class="font-semibold text-xs text-[#666666]">최대 13,000원 적립(실 결제금액에 한함)</p> -->
                    </div>
                    <div class="flex gap-5">
                        <p class="font-bold text-xs text-[#999999]">카드혜택</p>
                        <p class="font-semibold text-xs text-[#666666]">무이자 할부(최대 3개월)</p>
                    </div>
                    <div class="flex gap-5">
                        <p class="font-bold text-xs text-[#999999]">배송정보</p>
                        <div class="flex flex-col gap-[5px]">
                            <p class="font-semibold text-xs text-[#666666]">국내배송(무료배송)</p>
                            <p class="font-semibold text-xs text-[#666666]">도서산간 지역 배송비 별도 추가</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 구분선 -->
            <hr class="mt-[15px] w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

            <!-- 에이블랑 명품감정 -->
            <div class="mt-[15px] px-[14px] flex flex-col gap-[15px]">
                <img class="min-w-full" src="images/discount_vintage.png" alt="">
            </div>
        <?php
        } else {
        ?>
            <!-- 할인정보 -->
            <div class="mt-[15px] px-[14px] flex flex-col gap-[15px]">
                <?php
                if ($arr_Data['INT_TYPE'] == 2) {
                    $SQL_QUERY =    'SELECT A.STR_IMAGE1, A.STR_URL1 
                                    FROM ' . $Tname . 'comm_banner A 
                                    WHERE 
                                        A.INT_GUBUN=13 
                                        AND A.STR_SERVICE="Y"
                                    LIMIT 1';
                    $arr_Rlt_Data = mysql_query($SQL_QUERY);
                    $discount_banner_Data = mysql_fetch_assoc($arr_Rlt_Data);
                ?>
                    <a href="<?= $discount_banner_Data['STR_URL1'] ?: '#' ?>" class="flex w-full">
                        <img class="min-w-full" src="/admincenter/files/bann/<?= $discount_banner_Data['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
                    </a>
                <?php
                }
                ?>

                <div class="w-full flex flex-col gap-[9px]">
                    <div class="flex gap-5">
                        <p class="font-bold text-xs text-[#999999]">렌트기간</p>
                        <?php
                        if ($arr_Data['INT_TYPE'] == 1) {
                        ?>
                            <p class="font-semibold text-xs text-[#666666]">무제한</p>
                        <?php
                        } else {
                        ?>
                            <p class="font-semibold text-xs text-[#666666]">최소 4일 ~ 최대 14일</p>
                        <?php
                        }
                        ?>

                    </div>
                    <div class="flex gap-5">
                        <p class="font-bold text-xs text-[#999999]">배송정보</p>
                        <p class="font-semibold text-xs text-[#666666]">국내배송(무료배송)</p>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

        <?php
        if ($arr_Data['INT_TYPE'] != 3) {
        ?>
            <!-- 구분선 -->
            <hr class="mt-[15px] w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

            <!-- 최근상태 -->
            <div class="mt-[15px] px-[14px] flex flex-col gap-[13px] w-full">
                <p class="font-extrabold text-sm text-[#666666]">최근 상태를 확인해주세요.</p>
                <div class="detail-image-scroll-list splide">
                    <div class="splide__track w-full">
                        <div class="splide__list w-full flex flex-row gap-[5px]">
                            <?php
                            for ($i = 6; $i <= 12; $i++) {
                                if ($arr_Data['STR_IMAGE' . $i]) {
                            ?>
                                    <a href="javascript:showRelativeImage(<?= $i - 6 ?>)" class="flex-none flex-grow-0 w-[130px] h-[130px] border border-solid border-[#DDDDDD] bg-gray-100 splide__slide">
                                        <img class="min-w-full h-full object-cover" src="/admincenter/files/good/<?= $arr_Data['STR_IMAGE' . $i] ?>" onerror="this.style.display='none'" alt="">
                                    </a>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

        <!-- 메뉴 -->
        <div id="menu_panel" class="mt-[15px] flex justify-around bg-white border-t-[0.5px] border-b-[0.5px] border-solid border-[#E0E0E0]">
            <div class="flex justify-center items-center px-[12px] py-2.5 cursor-pointer" x-bind:class="$store.detailMenu == 1 ? ' border-b border-black' : ''" x-on:click="$store.detailMenu = 1" onclick="scrollToDiv('menu_div1')">
                <p class="text-[14px] leading-4 text-center" x-bind:class="$store.detailMenu == 1 ? 'font-bold text-black' : 'font-medium text-[#999999]'">상품정보</p>
            </div>
            <div class="flex justify-center items-center px-[12px] py-2.5 cursor-pointer" x-bind:class="$store.detailMenu == 2 ? ' border-b border-black' : ''" x-on:click="$store.detailMenu = 2" onclick="scrollToDiv('menu_div2')">
                <p class="text-[14px] leading-4 text-center" x-bind:class="$store.detailMenu == 2 ? 'font-bold text-black' : 'font-medium text-[#999999]'"><?= $arr_Data['INT_TYPE'] != 3 ? '상세후기' : '1:1문의' ?></p>
            </div>
            <div class="flex justify-center items-center px-[12px] py-2.5 cursor-pointer" x-bind:class="$store.detailMenu == 3 ? ' border-b border-black' : ''" x-on:click="$store.detailMenu = 3" onclick="scrollToDiv('menu_div3')">
                <p class="text-[14px] leading-4 text-center" x-bind:class="$store.detailMenu == 3 ? 'font-bold text-black' : 'font-medium text-[#999999]'">이용안내</p>
            </div>
            <div class="flex justify-center items-center px-[12px] py-2.5 cursor-pointer" x-bind:class="$store.detailMenu == 4 ? ' border-b border-black' : ''" x-on:click="$store.detailMenu = 4" onclick="scrollToDiv('menu_div4')">
                <p class="text-[14px] leading-4 text-center" x-bind:class="$store.detailMenu == 4 ? 'font-bold text-black' : 'font-medium text-[#999999]'">관련상품</p>
            </div>
        </div>

        <!-- 톱메뉴 -->
        <div id="top_menu_panel" class="fixed top-[56px] flex justify-around bg-white border-b-[0.5px] border-solid border-[#E0E0E0] w-full max-w-[410px] z-10 hidden">
            <div class="flex justify-center items-center px-[12px] py-2.5 cursor-pointer" x-bind:class="$store.detailMenu == 1 ? ' border-b border-black' : ''" x-on:click="$store.detailMenu = 1" onclick="scrollToDiv('menu_div1')">
                <p class="text-[14px] leading-4 text-center" x-bind:class="$store.detailMenu == 1 ? 'font-bold text-black' : 'font-medium text-[#999999]'">상품정보</p>
            </div>
            <div class="flex justify-center items-center px-[12px] py-2.5 cursor-pointer" x-bind:class="$store.detailMenu == 2 ? ' border-b border-black' : ''" x-on:click="$store.detailMenu = 2" onclick="scrollToDiv('menu_div2')">
                <p class="text-[14px] leading-4 text-center" x-bind:class="$store.detailMenu == 2 ? 'font-bold text-black' : 'font-medium text-[#999999]'"><?= $arr_Data['INT_TYPE'] != 3 ? '상세후기' : '1:1문의' ?></p>
            </div>
            <div class="flex justify-center items-center px-[12px] py-2.5 cursor-pointer" x-bind:class="$store.detailMenu == 3 ? ' border-b border-black' : ''" x-on:click="$store.detailMenu = 3" onclick="scrollToDiv('menu_div3')">
                <p class="text-[14px] leading-4 text-center" x-bind:class="$store.detailMenu == 3 ? 'font-bold text-black' : 'font-medium text-[#999999]'">이용안내</p>
            </div>
            <div class="flex justify-center items-center px-[12px] py-2.5 cursor-pointer" x-bind:class="$store.detailMenu == 4 ? ' border-b border-black' : ''" x-on:click="$store.detailMenu = 4" onclick="scrollToDiv('menu_div4')">
                <p class="text-[14px] leading-4 text-center" x-bind:class="$store.detailMenu == 4 ? 'font-bold text-black' : 'font-medium text-[#999999]'">관련상품</p>
            </div>
        </div>

        <!-- 상품정보 -->
        <div class="mt-7 px-[14px] flex flex-col" id="menu_div1">
            <div class="flex flex-col gap-[15px] px-3 pt-[15px] pb-[19px] bg-[#F5F5F5]">
                <?php
                if ($arr_Data['INT_TYPE'] == 3) {
                ?>
                    <!-- 상품등급 -->
                    <div class="flex flex-col w-full">
                        <p class="font-extrabold text-xs leading-[14px] text-black">상품등급</p>
                    </div>
                    <div x-data="{ grade: <?= $arr_Data['INT_GRADE'] ?> }" class="flex flex-col w-full">
                        <div class="relative flex w-full h-8 border border-solid" x-bind:class="grade == 1 ? 'border-black' : 'border-[#D9D9D9]'">
                            <div x-show="grade == 1" class="absolute top-0 left-0" style="display: none;">
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.22222 7.33333L8.13889 3.41667L7.36111 2.63889L4.22222 5.77778L2.63889 4.19444L1.86111 4.97222L4.22222 7.33333ZM0 10V0H10V10H0Z" fill="black" />
                                </svg>
                            </div>
                            <div class="w-[91px] flex justify-center items-center bg-[#F9F9F9]">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">PRESERVED</p>
                            </div>
                            <div class="grow flex justify-center items-center bg-white border-l" x-bind:class="grade == 1 ? 'border-black' : 'border-[#D9D9D9]'">
                                <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">깨끗하게 보존된 새 상품</p>
                            </div>
                        </div>
                        <div class="relative flex w-full h-8 border border-solid" x-bind:class="grade == 2 ? 'border-black' : 'border-[#D9D9D9]'">
                            <div x-show="grade == 2" class="absolute top-0 left-0" style="display: none;">
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.22222 7.33333L8.13889 3.41667L7.36111 2.63889L4.22222 5.77778L2.63889 4.19444L1.86111 4.97222L4.22222 7.33333ZM0 10V0H10V10H0Z" fill="black" />
                                </svg>
                            </div>
                            <div class="w-[91px] flex justify-center items-center bg-[#F9F9F9]">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">S CLASS</p>
                            </div>
                            <div class="grow flex justify-center items-center bg-white border-l" x-bind:class="grade == 2 ? 'border-black' : 'border-[#D9D9D9]'">
                                <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">새 상품과 비슷한 수준의 깨끗한 상품</p>
                            </div>
                        </div>
                        <div class="relative flex w-full h-8 border border-solid" x-bind:class="grade == 3 ? 'border-black' : 'border-[#D9D9D9]'">
                            <div x-show="grade == 3" class="absolute top-0 left-0" style="display: none;">
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.22222 7.33333L8.13889 3.41667L7.36111 2.63889L4.22222 5.77778L2.63889 4.19444L1.86111 4.97222L4.22222 7.33333ZM0 10V0H10V10H0Z" fill="black" />
                                </svg>
                            </div>
                            <div class="w-[91px] flex justify-center items-center bg-[#F9F9F9]">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">A CLASS</p>
                            </div>
                            <div class="grow flex justify-center items-center bg-white border-l" x-bind:class="grade == 3 ? 'border-black' : 'border-[#D9D9D9]'">
                                <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">대체적으로 깨끗한 상품</p>
                            </div>
                        </div>
                        <div class="relative flex w-full h-8 border border-solid" x-bind:class="grade == 4 ? 'border-black' : 'border-[#D9D9D9]'">
                            <div x-show="grade == 4" class="absolute top-0 left-0" style="display: none;">
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.22222 7.33333L8.13889 3.41667L7.36111 2.63889L4.22222 5.77778L2.63889 4.19444L1.86111 4.97222L4.22222 7.33333ZM0 10V0H10V10H0Z" fill="black" />
                                </svg>
                            </div>
                            <div class="w-[91px] flex justify-center items-center bg-[#F9F9F9]">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">B CLASS</p>
                            </div>
                            <div class="grow flex justify-center items-center bg-white border-l" x-bind:class="grade == 4 ? 'border-black' : 'border-[#D9D9D9]'">
                                <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">약한 스크래치·탈색·오염이 있는 상품</p>
                            </div>
                        </div>
                        <div class="relative flex w-full h-8 border border-solid" x-bind:class="grade == 5 ? 'border-black' : 'border-[#D9D9D9]'">
                            <div x-show="grade == 5" class="absolute top-0 left-0" style="display: none;">
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.22222 7.33333L8.13889 3.41667L7.36111 2.63889L4.22222 5.77778L2.63889 4.19444L1.86111 4.97222L4.22222 7.33333ZM0 10V0H10V10H0Z" fill="black" />
                                </svg>
                            </div>
                            <div class="w-[91px] flex justify-center items-center bg-[#F9F9F9]">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">C CLASS</p>
                            </div>
                            <div class="grow flex justify-center items-center bg-white border-l" x-bind:class="grade == 5 ? 'border-black' : 'border-[#D9D9D9]'">
                                <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">눈에 띄는 스크래치·탈색·오염이 있는 상품</p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                <!-- 상품코드 -->
                <div class="flex flex-col gap-1.5">
                    <p class="font-bold text-sm leading-4 text-black">상품코드</p>
                    <p class="font-semibold text-xs text-[#666666]"><?= $arr_Data['STR_BRAND'] ?></p>
                </div>
                <!-- 기본정보 -->
                <div class="flex flex-col gap-1.5">
                    <p class="font-bold text-sm leading-4 text-black">기본정보</p>
                    <?php
                    switch ($arr_Data['INT_TYPE']) {
                        case 1:
                    ?>
                            <div class="flex flex-row">
                                <div class="w-[55px]">
                                    <p class="font-semibold text-xs text-[#666666]">리테일가</p>
                                </div>
                                <p class="font-semibold text-xs text-[#666666]"><?= number_format($arr_Data['INT_PRICE']) ?>원</p>
                            </div>
                        <?php
                            break;
                        case 2:
                        ?>
                            <div class="flex flex-row">
                                <div class="w-[55px]">
                                    <p class="font-semibold text-xs text-[#666666]">리테일가</p>
                                </div>
                                <p class="font-semibold text-xs text-[#666666]"><?= number_format($arr_Data['INT_RPRICE']) ?>원</p>
                            </div>
                    <?php
                            break;
                    }
                    ?>
                    <div class="flex flex-row">
                        <div class="w-[55px]">
                            <p class="font-semibold text-xs text-[#666666]">소재</p>
                        </div>
                        <p class="font-semibold text-xs text-[#666666]"><?= $arr_Data['STR_MATERIAL'] ?></p>
                    </div>
                    <div class="flex flex-row">
                        <div class="w-[55px]">
                            <p class="font-semibold text-xs text-[#666666]">색상</p>
                        </div>
                        <div class="flex flex-row gap-[3px] items-center">
                            <div class="w-3 h-3 bg-[<?= $arr_Data['STR_COLOR_VAL'] ?: '#000000' ?>]"></div>
                            <p class="font-semibold text-xs text-[#666666]"><?= $arr_Data['STR_COLOR'] ?></p>
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <div class="w-[55px]">
                            <p class="font-semibold text-xs text-[#666666]">원산지</p>
                        </div>
                        <p class="font-semibold text-xs text-[#666666]"><?= $arr_Data['STR_ORIGIN'] ?></p>
                    </div>
                </div>
                <!-- 사이즈정보 -->
                <div class="flex flex-col">
                    <p class="mt-1.5 font-bold text-sm leading-4 text-black">사이즈정보</p>
                    <div class="mt-1.5 flex flex-col gap-7 justify-center items-center w-full pt-7 pb-[20px] bg-white">
                        <?php
                        if ($arr_Data['STR_TIMAGE']) {
                        ?>
                            <img class="w-[222px] h-[252px]" src="/admincenter/files/good/<?= $arr_Data['STR_TIMAGE'] ?>" onerror="this.style.display = 'none'" alt="" />
                        <?php
                        } else {
                        ?>
                            <img class="w-[222px] h-[252px]" src="images/product_size.png" onerror="this.style.display = 'none'" alt="" />
                        <?php
                        }
                        ?>
                        <p class="font-semibold text-[10px] text-center text-[#999999]">*측정 위치 및 방법에 따라 1~3cm 정도 오차가 생길 수 있습니다.</p>
                    </div>

                    <div class="mt-2.5 flex flex-col gap-1.5">
                        <?php
                        preg_match_all('/\d+(\.\d+)?/', $arr_Data['STR_SIZE'], $matches);
                        $size_array = $matches[0];
                        ?>
                        <div class="flex items-center">
                            <div class="w-[65px]">
                                <p class="font-semibold text-xs text-[#666666]">A 가로</p>
                            </div>
                            <p class="font-semibold text-xs text-[#666666]"><?= $size_array[0] ?: '0' ?> cm</p>
                        </div>
                        <div class="flex items-center">
                            <div class="w-[65px]">
                                <p class="font-semibold text-xs text-[#666666]">B 폭</p>
                            </div>
                            <p class="font-semibold text-xs text-[#666666]"><?= $size_array[1] ?: '0' ?> cm</p>
                        </div>
                        <div class="flex items-center">
                            <div class="w-[65px]">
                                <p class="font-semibold text-xs text-[#666666]">C 높이</p>
                            </div>
                            <p class="font-semibold text-xs text-[#666666]"><?= $size_array[2] ?: '0' ?> cm</p>
                        </div>
                        <div class="flex items-center">
                            <div class="w-[65px]">
                                <p class="font-semibold text-xs text-[#666666]">D 스트랩</p>
                            </div>
                            <p class="font-semibold text-xs text-[#666666]"><?= preg_replace('/[^0-9]/', '', $arr_Data['STR_LENGTH']) ?> cm</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 상품이미지 -->
            <div x-data="{ showFullContent: false }" class="mt-7 flex flex-col gap-7 w-full">
                <div class="flex flex-col w-full" x-ref="content" x-bind:style="showFullContent ? 'max-height: none' : 'max-height: 300px; overflow: hidden'">
                    <?= str_replace('\"', '', $arr_Data['STR_CONTENTS']) ?>
                </div>
                <!-- 더보기 버튼 -->
                <button class="flex justify-center items-center gap-[3px] h-[39px] rounded-[5px] border-[0.72222px] border-solid border-[#DDDDDD] bg-white" x-on:click="showFullContent = !showFullContent">
                    <span class="font-bold text-[11px] text-black" x-text="showFullContent ? '접기' : '더보기'">더보기</span>
                    <div class="flex items-center" x-bind:style="showFullContent ? 'rotate: 180deg;' : ''">
                        <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576043 0.435356 4.59757e-07 0.593667 4.53547e-07C0.751979 4.47336e-07 0.890501 0.0576043 1.00923 0.172811L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.011521 8.40016 0.011521C8.56259 0.011521 8.70317 0.0691244 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587557C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#333333" />
                        </svg>
                    </div>
                </button>
            </div>
        </div>

        <!-- 구분선 -->
        <hr class="mt-7 border-t-[0.5px] border-solid border-[#E0E0E0]" />

        <?php
        if ($arr_Data['INT_TYPE'] != 3) {
        ?>
            <!-- 리뷰혜택 이미지 -->
            <div class="mt-[15px] flex w-full px-[14px]" id="menu_div2">
                <div class="flex flex-col gap-[7px] w-full border-[0.72px] border-solid border-[#DDDDDD] px-[11px] py-[13px]">
                    <p class="font-bold text-sm leading-4 text-[#666666]">리뷰혜택</p>
                    <p class="font-normal text-xs leading-[17px] text-[#666666]">
                        ✍️ 상품 리뷰 작성 시: 적립금 400원 지급<br>
                        📷 포토 리뷰 작성 시: 적립금 1,000원 지급<br>
                        🏆 베스트 리뷰 선정 시: 적립금 10,000원 추가 지급
                    </p>
                </div>
            </div>

            <!-- 리뷰 -->
            <div x-data="{ reviewMenu: 1 }" class="mt-[25px] flex flex-col px-[14px]">
                <!-- 메뉴 -->
                <div class="flex gap-10 justify-center">
                    <div class="px-[9px] pb-[3px] flex justify-center cursor-pointer" x-bind:class="reviewMenu == 1 ? 'border-b border-b-[#6A696C] text-[#6A696C]' : 'text-[#999999]'" x-on:click="reviewMenu = 1;searchOwnReview();">
                        <p class="font-bold text-sm leading-4 text-center" x-bind:class="reviewMenu == 1 ? 'font-bold' : 'font-medium'">해당 상품 리뷰</p>
                    </div>
                    <div class="px-[9px] pb-[3px] flex justify-center cursor-pointer" x-bind:class="reviewMenu == 2 ? 'border-b border-b-[#6A696C] text-[#6A696C]' : 'text-[#999999]'" x-on:click="reviewMenu = 2;searchRelatedReview();">
                        <p class="font-bold text-sm leading-4 text-center" x-bind:class="reviewMenu == 2 ? 'font-bold' : 'font-medium'">관련 상품 리뷰</p>
                    </div>
                </div>
                <!-- 해당 상품 리뷰목록 -->
                <div x-show="reviewMenu == 1" class="mt-[27px] flex flex-col w-full">
                    <p class="font-extrabold text-lg leading-5 text-black">REVIEW</p>
                    <?php
                    $SQL_QUERY =    'SELECT
                                        A.BD_SEQ, B.IMG_F_NAME
                                    FROM 
                                        `' . $Tname . 'b_bd_data@01` A
                                    LEFT JOIN
                                        `' . $Tname . 'b_img_data@01` B
                                    ON
                                        A.CONF_SEQ=B.CONF_SEQ
                                        AND
                                        A.BD_SEQ=B.BD_SEQ
                                    LEFT JOIN
                                        `' . $Tname . 'comm_goods_master` C
                                    ON
                                        A.BD_ITEM1=C.STR_GOODCODE
                                    WHERE
                                        C.INT_TYPE=' . $arr_Data['INT_TYPE'] . '
                                        AND C.STR_GOODCODE=' . $arr_Data['STR_GOODCODE'] . '
                                        AND B.IMG_F_NAME <> ""
                                        LIMIT 10';

                    $review_img_list_result = mysql_query($SQL_QUERY);
                    ?>
                    <div class="review-image-scroll-list splide my-7 w-full <?= mysql_num_rows($review_img_list_result) > 0 ? '' : 'hidden' ?>">
                        <div class="splide__track w-full">
                            <div class="splide__list w-full flex flex-row gap-[5px]">
                                <?php
                                while ($image_row = mysql_fetch_assoc($review_img_list_result)) {
                                ?>
                                    <a href="/m/review/detail.php?bd_seq=<?= $image_row['BD_SEQ'] ?>" class="flex-none w-20 h-20 bg-gray-100 splide__slide">
                                        <img class="min-w-full h-full object-cover" src="/admincenter/files/boad/2/<?= $image_row['IMG_F_NAME'] ?>" onerror="this.style.display='none'" alt="">
                                    </a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2.5 flex flex-col w-full" id="own_review_list"></div>
                </div>
                <!-- 관련 상품 리뷰목록 -->
                <div x-show="reviewMenu == 2" id="related_review_list" class="mt-[27px] flex flex-col w-full">
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="mt-[25px] flex flex-col px-[14px]" id="menu_div2">
                <p class="font-bold text-lg leading-5 text-[#333333]">1:1문의</p>
                <div class="mt-[15px] flex flex-col bg-[#F5F5F5] px-[15px] py-[17px]">
                    <a href="/m/mine/question/index.php">
                        <p class="font-bold text-[13px] leading-[15px] text-black">CUSTOMER CENTER</p>
                    </a>
                    <p class="mt-[13px] font-medium text-xs leading-[14px] text-black">CS NUMBER : 02-6013-6733</p>
                    <a href="https://pf.kakao.com/_eZdId">
                        <p class="mt-[5px] font-medium text-xs leading-[14px] text-black">카카오톡 : @에이블랑컴퍼니</p>
                    </a>
                    <p class="mt-[15px] font-medium text-[9px] leading-[10px] text-[#999999]">※ 운영시간: 평일 09:00 ~ 17:30 (점심시간 12:00~13:00) / 주말 및 공휴일 휴무</p>
                </div>
                <div class="flex mt-[15px] mb-[5px]" style="width: 100%;">
                    <a href="https://pf.kakao.com/_eZdId" style="display: flex; width: calc((100% - 7px) * 45 / (312 + 45));">
                        <img src="images/kakao2.png" alt="Kakao 2" style="width: 100%;">
                    </a>
                    <div style="width: 7px;"></div> <!-- 14px 간격 -->
                    <a href="/m/mine/question/index.php" class="font-medium" style="display: flex; width: calc((100% - 7px) * 312 / (312 + 45)); background-color: black; color: white; align-items: center; justify-content: center; font-size: 12px;">
                        1:1문의 작성하기
                    </a>
                </div>
            </div>
        <?php
        }
        ?>

        <!-- 구분선 -->
        <hr class="mt-7 border-t-[0.5px] border-solid border-[#E0E0E0]" />

        <!-- 이용 안내 -->
        <div x-data="{ collapse: false }" class="mt-5 flex flex-col gap-[15px] px-[14px]" id="menu_div3">
            <div class="flex items-center justify-between">
                <p class="font-extrabold text-lg leading-5 text-[#333333]">이용 안내</p>
                <span class="cursor-pointer" x-on:click="collapse = !collapse">
                    <svg x-show="collapse" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.2576 1.58525L7.81002 7.79723C7.73327 7.87097 7.65012 7.92307 7.56057 7.95355C7.47102 7.98452 7.37507 8 7.27273 8C7.17038 8 7.07444 7.98452 6.98489 7.95355C6.89534 7.92307 6.81218 7.87097 6.73543 7.79724L0.268649 1.58525C0.0895495 1.41321 -2.97318e-07 1.19816 -3.08598e-07 0.940092C-3.19879e-07 0.682027 0.0959459 0.46083 0.287838 0.276498C0.479731 0.0921659 0.703606 -3.07556e-08 0.959462 -4.19394e-08C1.21532 -5.31233e-08 1.43919 0.0921659 1.63109 0.276498L7.27273 5.69585L12.9144 0.276497C13.0935 0.104454 13.314 0.0184325 13.576 0.0184325C13.8385 0.0184325 14.0657 0.110598 14.2576 0.29493C14.4495 0.479262 14.5455 0.694316 14.5455 0.940091C14.5455 1.18587 14.4495 1.40092 14.2576 1.58525Z" fill="#333333" />
                    </svg>
                    <svg x-show="!collapse" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.742365 6.41475L7.18998 0.202768C7.26673 0.129028 7.34988 0.0769254 7.43943 0.0464487C7.52898 0.0154817 7.62493 0 7.72727 0C7.82962 0 7.92556 0.0154817 8.01511 0.0464487C8.10466 0.0769254 8.18782 0.129028 8.26457 0.20276L14.7314 6.41475C14.9105 6.58679 15 6.80184 15 7.05991C15 7.31797 14.9041 7.53917 14.7122 7.7235C14.5203 7.90783 14.2964 8 14.0405 8C13.7847 8 13.5608 7.90783 13.3689 7.7235L7.72727 2.30415L2.08556 7.7235C1.9065 7.89555 1.686 7.98157 1.424 7.98157C1.16154 7.98157 0.934344 7.88941 0.742445 7.70507C0.550552 7.52074 0.454545 7.30569 0.454545 7.05991C0.454545 6.81413 0.550552 6.59908 0.742365 6.41475Z" fill="#333333" />
                    </svg>
                </span>
            </div>
            <div x-show="!collapse" class="flex flex-col gap-[9px] p-3 bg-[#F5F5F5]">
                <p class="font-normal text-xs leading-[14px] text-[#666666]" style="line-height: 1.5;">
                    [명품 렌트] </br>
                    - 상품에 따라 주문 후 별도의 보증금을 요청드릴 수 있습니다.</br>
                    - 반납일에 상품회수가 되지 않을 경우 연체료가 발생합니다.</br>
                    - 수령 직후 주문한 상품이 아닌 경우 라벨을 제거하기 전 문의바랍니다.

                </p>
                <p class="font-normal text-xs leading-[14px] text-[#666666]" style="line-height: 1.5;">
                    [명품 구독] </br>
                    - 월 89,000원으로 명품 구독 상품을 무제한으로 이용할 수 있습니다.</br>
                    - 상품에 따라 주문 후 별도의 보증금을 요청드릴 수 있습니다.</br>
                    - 멤버십 종료일, 반납일에 상품 회수가 지연될 경우 연체료가 발생합니다.</br>
                    - 상품 변경 및 취소는 주문 접수 상태일 때만 가능합니다.</br>
                    - 수령 직후 주문한 상품이 아닌 경우 라벨을 제거하기 전 문의바랍니다.
                </p>

            </div>
        </div>

        <!-- 배송 및 교환 -->
        <div x-data="{ collapse: false }" class="mt-5 flex flex-col gap-[15px] px-[14px]">
            <div class="flex items-center justify-between">
                <p class="font-bold text-lg leading-5 text-[#333333]">배송 안내</p>
                <span class="cursor-pointer" x-on:click="collapse = !collapse">
                    <svg x-show="collapse" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.2576 1.58525L7.81002 7.79723C7.73327 7.87097 7.65012 7.92307 7.56057 7.95355C7.47102 7.98452 7.37507 8 7.27273 8C7.17038 8 7.07444 7.98452 6.98489 7.95355C6.89534 7.92307 6.81218 7.87097 6.73543 7.79724L0.268649 1.58525C0.0895495 1.41321 -2.97318e-07 1.19816 -3.08598e-07 0.940092C-3.19879e-07 0.682027 0.0959459 0.46083 0.287838 0.276498C0.479731 0.0921659 0.703606 -3.07556e-08 0.959462 -4.19394e-08C1.21532 -5.31233e-08 1.43919 0.0921659 1.63109 0.276498L7.27273 5.69585L12.9144 0.276497C13.0935 0.104454 13.314 0.0184325 13.576 0.0184325C13.8385 0.0184325 14.0657 0.110598 14.2576 0.29493C14.4495 0.479262 14.5455 0.694316 14.5455 0.940091C14.5455 1.18587 14.4495 1.40092 14.2576 1.58525Z" fill="#333333" />
                    </svg>
                    <svg x-show="!collapse" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.742365 6.41475L7.18998 0.202768C7.26673 0.129028 7.34988 0.0769254 7.43943 0.0464487C7.52898 0.0154817 7.62493 0 7.72727 0C7.82962 0 7.92556 0.0154817 8.01511 0.0464487C8.10466 0.0769254 8.18782 0.129028 8.26457 0.20276L14.7314 6.41475C14.9105 6.58679 15 6.80184 15 7.05991C15 7.31797 14.9041 7.53917 14.7122 7.7235C14.5203 7.90783 14.2964 8 14.0405 8C13.7847 8 13.5608 7.90783 13.3689 7.7235L7.72727 2.30415L2.08556 7.7235C1.9065 7.89555 1.686 7.98157 1.424 7.98157C1.16154 7.98157 0.934344 7.88941 0.742445 7.70507C0.550552 7.52074 0.454545 7.30569 0.454545 7.05991C0.454545 6.81413 0.550552 6.59908 0.742365 6.41475Z" fill="#333333" />
                    </svg>
                </span>
            </div>
            <div x-show="!collapse" class="flex flex-col gap-[4px] p-3 bg-[#F5F5F5]">
                <p class="font-normal text-xs leading-[14px] text-[#666666]">
                    - 배송은 우체국택배로 진행되며, 배송비는 무료입니다.
                </p>
                <p class="font-normal text-xs leading-[14px] text-[#666666]">
                    - [명품렌트] 상품의 경우 예약일 2일 전 출고됩니다. (영업일 기준)
                </p>
                <p class="font-normal text-xs leading-[14px] text-[#666666]">
                    - [명품 구독],[빈티지] 상품의 경우 오후 12시 이전 주문 시 당일 출고됩니다.
                </p>

            </div>
        </div>
        <div x-data="{ collapse: false }" class="mt-5 flex flex-col gap-[15px] px-[14px]">
            <div class="flex items-center justify-between">
                <p class="font-bold text-lg leading-5 text-[#333333]">반납 및 교환</p>
                <span class="cursor-pointer" x-on:click="collapse = !collapse">
                    <svg x-show="collapse" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.2576 1.58525L7.81002 7.79723C7.73327 7.87097 7.65012 7.92307 7.56057 7.95355C7.47102 7.98452 7.37507 8 7.27273 8C7.17038 8 7.07444 7.98452 6.98489 7.95355C6.89534 7.92307 6.81218 7.87097 6.73543 7.79724L0.268649 1.58525C0.0895495 1.41321 -2.97318e-07 1.19816 -3.08598e-07 0.940092C-3.19879e-07 0.682027 0.0959459 0.46083 0.287838 0.276498C0.479731 0.0921659 0.703606 -3.07556e-08 0.959462 -4.19394e-08C1.21532 -5.31233e-08 1.43919 0.0921659 1.63109 0.276498L7.27273 5.69585L12.9144 0.276497C13.0935 0.104454 13.314 0.0184325 13.576 0.0184325C13.8385 0.0184325 14.0657 0.110598 14.2576 0.29493C14.4495 0.479262 14.5455 0.694316 14.5455 0.940091C14.5455 1.18587 14.4495 1.40092 14.2576 1.58525Z" fill="#333333" />
                    </svg>
                    <svg x-show="!collapse" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.742365 6.41475L7.18998 0.202768C7.26673 0.129028 7.34988 0.0769254 7.43943 0.0464487C7.52898 0.0154817 7.62493 0 7.72727 0C7.82962 0 7.92556 0.0154817 8.01511 0.0464487C8.10466 0.0769254 8.18782 0.129028 8.26457 0.20276L14.7314 6.41475C14.9105 6.58679 15 6.80184 15 7.05991C15 7.31797 14.9041 7.53917 14.7122 7.7235C14.5203 7.90783 14.2964 8 14.0405 8C13.7847 8 13.5608 7.90783 13.3689 7.7235L7.72727 2.30415L2.08556 7.7235C1.9065 7.89555 1.686 7.98157 1.424 7.98157C1.16154 7.98157 0.934344 7.88941 0.742445 7.70507C0.550552 7.52074 0.454545 7.30569 0.454545 7.05991C0.454545 6.81413 0.550552 6.59908 0.742365 6.41475Z" fill="#333333" />
                    </svg>
                </span>
            </div>
            <div x-show="!collapse" class="flex flex-col gap-[4px] p-3 bg-[#F5F5F5]">

                <p class="font-normal text-xs leading-[14px] text-[#666666]" style="line-height: 1.5;">
                    [명품 렌트] </br>
                    - 가방 이용기간을 확인해주시고 반납일에 맞추어 가방을 반납해 주세요.</br>
                    - 반납일에 제품 회수가 되지 않을 경우 연체료가 발생합니다.</br>
                </p>

                <p class="font-normal text-xs leading-[14px] text-[#666666]" style="line-height: 1.5;">
                    [명품 구독] </br>
                    - 교환은 가방 선택 후 사용중인 가방의 반납 일자를 지정하면 됩니다.</br>
                    - 교환은 횟수 제한 없이 무료 배송으로 이용할 수 있습니다.</br>
                    - 반납 신청은 [마이페이지-렌트/구매 내역]에서 신청 가능합니다.</br>
                </p>

                <p class="font-normal text-xs leading-[14px] text-[#666666]" style="line-height: 1.5;">
                    [공통] </br>
                    - 단순 변심으로 인한 반품 요청 시 반품배송비 6,000원이 발생합니다.</br>
                    - 반품 상품의 택(사용 방지택 포함) 훼손 및 제거되지 않고, </br>
                    - 구성품과 가방 모두 미사용 상태일 경우에 반품이 가능합니다. </br>
                    - 가방의 안전을 위해, 기사님의 연락을 받으실 경우에만 회수가 진행됩니다.</br>
                </p>
            </div>
        </div>
        <!-- 구분선 -->
        <hr class="mt-7 border-t-[0.5px] border-solid border-[#E0E0E0]" />

        <!-- 관련 상품 -->
        <div class="mt-5 flex flex-col gap-5 px-[14px]" id="menu_div4">
            <p class="font-bold text-lg leading-5 text-[#333333]">관련 상품</p>
            <div class="grid grid-cols-2 gap-x-[13.5px] gap-y-[30.45px] w-full">
                <?php
                $SQL_QUERY =    'SELECT 
                                    A.*, 
                                    B.STR_CODE, 
                                    COUNT(C.STR_SGOODCODE) AS RENT_NUM, 
                                    (SELECT COUNT(C.INT_NUMBER) FROM ' . $Tname . 'comm_goods_cart C WHERE A.STR_GOODCODE=C.STR_GOODCODE AND C.STR_USERID="' . $arr_Auth[0] . '" AND C.INT_STATE=6) AS CART_NUM
                                FROM 
                                    ' . $Tname . 'comm_goods_master A
                                LEFT JOIN
                                    ' . $Tname . 'comm_com_code B
                                ON
                                    A.INT_BRAND=B.INT_NUMBER
                                LEFT JOIN
                                    ' . $Tname . 'comm_goods_master_sub C
                                ON
                                    A.STR_GOODCODE=C.STR_GOODCODE
                                    AND C.STR_SGOODCODE NOT IN (SELECT DISTINCT(D.STR_SGOODCODE) FROM ' . $Tname . 'comm_goods_cart D WHERE D.INT_STATE IN (1, 2, 3, 4, 5) AND D.STR_GOODCODE=A.STR_GOODCODE)
                                    AND C.STR_SERVICE="Y"
                                WHERE 
                                    (A.STR_SERVICE="Y" OR A.STR_SERVICE="R") 
                                    AND A.STR_GOODCODE!="' . $arr_Data['STR_GOODCODE'] . '" 
                                    AND A.INT_TYPE=' . $arr_Data['INT_TYPE'] . ' 
                                    AND A.INT_BRAND=' . $arr_Data['INT_BRAND'] . ' 
                                GROUP BY A.STR_GOODCODE
                                ORDER BY A.INT_VIEW DESC
                                LIMIT 4';

                $product_result = mysql_query($SQL_QUERY);

                while ($row = mysql_fetch_assoc($product_result)) {
                ?>
                    <a href="detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="flex flex-col w-full">
                        <div class="w-full flex justify-center items-center relative px-2.5 bg-[#F9F9F9] rounded-[5px] h-[176px]">
                            <!-- 타그 -->
                            <div class="flex justify-center items-center w-[30px] h-[30px] bg-[<?= ($row['INT_TYPE'] == 1 ? '#EEAC4C' : ($row['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>] absolute top-2 left-2 <?= $row['INT_DISCOUNT'] ? '' : 'hidden' ?>">
                                <p class="font-extrabold text-[9px] text-center text-white"><?= $row['INT_DISCOUNT'] ?>%</p>
                            </div>

                            <img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
                            <?php
                            if ($row['RENT_NUM'] == 0 && $row['INT_TYPE'] == 1) {
                            ?>
                                <div class="flex justify-center items-center w-full h-full bg-black bg-opacity-60 rounded-md absolute top-0 left-0">
                                    <p class="font-bold text-xs leading-[14px] text-white text-center">RENTED</p>
                                </div>
                            <?php
                            }
                            ?>

                            <?php
                            if ($row['CART_NUM'] > 0) {
                            ?>
                                <!-- 사용중 표시 -->
                                <div class="flex justify-center items-center absolute top-0 left-0 w-full h-full rounded-[5px] bg-black bg-opacity-60">
                                    <p class="font-bold text-xs leading-[14px] text-white">
                                        <?php
                                        switch ($row['INT_TYPE']) {
                                            case 1:
                                                echo '구독중';
                                                break;
                                            case 2:
                                                echo '렌트중';
                                                break;
                                            case 3:
                                                echo '사용중';
                                                break;
                                        }
                                        ?>
                                    </p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <p class="mt-[5.52px] font-extrabold text-[12px] leading-[14px] text-[#666666]"><?= $row['STR_CODE'] ?></p>
                        <p class="mt-[3.27px] font-medium text-[12px] leading-[14px] text-[#333333]"><?= $row['STR_GOODNAME'] ?></p>
                        <div class="mt-[7.87px] flex gap-[3px] items-center">
                            <?php
                            switch ($row['INT_TYPE']) {
                                case 1:
                                    if (!$is_subscription_membership) {
                            ?>
                                        <p class="font-bold text-[13px] leading-[14px] text-black"><span class="font-medium">월</span> <?= number_format($site_Data['INT_OPRICE1']) ?>원</p>
                                    <?php
                                    }
                                    break;

                                case 2:
                                    ?>
                                    <p class="font-bold text-[13px] leading-[14px] text-black"><span class="font-medium">일</span> <?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원</p>
                                    <p class="font-bold text-[11px] leading-[13px] line-through text-[#666666] <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>"><?= number_format($row['INT_PRICE']) ?>원</p>
                                <?php
                                    break;
                                case 3:
                                ?>
                                    <p class="font-bold text-[13px] leading-[14px] text-black"><?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원</p>
                                    <p class="font-bold text-[11px] leading-[13px] line-through text-[#666666] <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>"><?= number_format($row['INT_PRICE']) ?>원</p>
                            <?php
                                    break;
                            }
                            ?>
                        </div>
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <!-- 하단 메뉴 -->
    <div class="fixed bottom-0 w-full flex gap-[5px] px-[5px] py-2 h-[66px] border-t border-[#F4F4F4] bg-white max-w-[410px]">
        <button type="button" class="w-[50px] h-[50px] flex justify-center items-center border border-solid border-[#D9D9D9] bg-white" onclick="setProductLike('<?= $arr_Data['STR_GOODCODE'] ?>')">
            <svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.65129 0C5.76148 0.00304681 4.88214 0.191208 4.06902 0.552599C3.25591 0.91399 2.52697 1.4407 1.92845 2.09914C0.687349 3.47032 0 5.25375 0 7.10321C0 8.95266 0.687349 10.7361 1.92845 12.1073L11.8511 22.8886C11.9368 22.9814 12.0409 23.0555 12.1566 23.1062C12.2724 23.1569 12.3974 23.1831 12.5238 23.1831C12.6501 23.1831 12.7751 23.1569 12.8909 23.1062C13.0066 23.0555 13.1107 22.9814 13.1964 22.8886C16.5056 19.3001 19.8132 15.7095 23.119 12.117C24.361 10.7462 25.0489 8.96261 25.0489 7.1129C25.0489 5.26319 24.361 3.4796 23.119 2.10883C22.5224 1.44993 21.7944 0.923224 20.9818 0.562826C20.1692 0.202427 19.2901 0.0163981 18.4012 0.0163981C17.5122 0.0163981 16.6332 0.202427 15.8207 0.562826C15.0081 0.923224 14.2799 1.44993 13.6833 2.10883L12.5278 3.35862L11.3635 2.09914C10.7669 1.44098 10.0396 0.914317 9.22808 0.552952C8.41656 0.191586 7.53856 0.00344715 6.65023 0.000352648L6.65129 0ZM6.65129 1.78422C7.29012 1.79389 7.92 1.93723 8.50004 2.20511C9.08008 2.47298 9.59748 2.85933 10.0191 3.3394L11.8608 5.33362C11.9465 5.42641 12.0506 5.50039 12.1663 5.55103C12.2821 5.60167 12.4069 5.62773 12.5333 5.62773C12.6596 5.62773 12.7846 5.60167 12.9004 5.55103C13.0161 5.50039 13.1202 5.42641 13.2059 5.33362L15.0378 3.34751C15.4537 2.86082 15.9701 2.47005 16.5515 2.20211C17.1329 1.93417 17.7656 1.79533 18.4057 1.79533C19.0459 1.79533 19.6785 1.93417 20.26 2.20211C20.8414 2.47005 21.3578 2.86082 21.7737 3.34751C22.6957 4.38446 23.2049 5.72373 23.2049 7.11132C23.2049 8.4989 22.6957 9.83817 21.7737 10.8751C18.6905 14.2188 15.609 17.5652 12.5292 20.9141L3.28474 10.8675C2.36304 9.8305 1.85387 8.49135 1.85387 7.10391C1.85387 5.71647 2.36304 4.37732 3.28474 3.34028C3.7064 2.8602 4.22402 2.47369 4.80412 2.20581C5.38422 1.93793 6.01398 1.79459 6.65287 1.78493L6.65129 1.78422Z" fill="black" />
            </svg>
        </button>
        <button type="button" class="w-[50px] h-[50px] flex justify-center items-center border border-solid border-[#D9D9D9] bg-white" onclick="addProductBasket('<?= $arr_Data['STR_GOODCODE'] ?>')">
            <svg width="27" height="23" viewBox="0 0 27 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M24.2308 0H2.01923C1.4837 0 0.970098 0.211722 0.591419 0.588589C0.21274 0.965457 0 1.4766 0 2.00957V20.0957C0 20.6287 0.21274 21.1398 0.591419 21.5167C0.970098 21.8935 1.4837 22.1053 2.01923 22.1053H24.2308C24.7663 22.1053 25.2799 21.8935 25.6586 21.5167C26.0373 21.1398 26.25 20.6287 26.25 20.0957V2.00957C26.25 1.4766 26.0373 0.965457 25.6586 0.588589C25.2799 0.211722 24.7663 0 24.2308 0ZM24.2308 20.0957H2.01923V2.00957H24.2308V20.0957ZM19.1827 6.02871C19.1827 7.62762 18.5445 9.16105 17.4084 10.2916C16.2724 11.4223 14.7316 12.0574 13.125 12.0574C11.5184 12.0574 9.9776 11.4223 8.84157 10.2916C7.70553 9.16105 7.06731 7.62762 7.06731 6.02871C7.06731 5.76222 7.17368 5.50665 7.36302 5.31822C7.55236 5.12978 7.80916 5.02392 8.07692 5.02392C8.34469 5.02392 8.60149 5.12978 8.79083 5.31822C8.98017 5.50665 9.08654 5.76222 9.08654 6.02871C9.08654 7.09465 9.51202 8.11693 10.2694 8.87067C11.0267 9.6244 12.0539 10.0478 13.125 10.0478C14.1961 10.0478 15.2233 9.6244 15.9806 8.87067C16.738 8.11693 17.1635 7.09465 17.1635 6.02871C17.1635 5.76222 17.2698 5.50665 17.4592 5.31822C17.6485 5.12978 17.9053 5.02392 18.1731 5.02392C18.4408 5.02392 18.6976 5.12978 18.887 5.31822C19.0763 5.50665 19.1827 5.76222 19.1827 6.02871Z" fill="black" />
            </svg>
        </button>
        <?php
        switch ($arr_Data['INT_TYPE']) {
            case 1:
                if ($rent_number > 0) {
        ?>
                    <button class="grow flex justify-center items-center h-[50px] bg-black border border-solid border-[#D9D9D9]" x-on:click="goSubscription()">
                        <span class="font-extrabold text-lg text-center text-white">구독하기</span>
                    </button>
                <?php
                } else {
                ?>
                    <button class="grow flex justify-center items-center h-[50px] bg-black border border-solid border-[#D9D9D9]" onclick="showAlarmConfirmPanel()">
                        <span class="font-extrabold text-lg text-center text-white">입고알림 신청하기</span>
                    </button>
                <?php
                }
                break;
            case 2:
                ?>
                <button class="grow flex justify-center items-center h-[50px] bg-black border border-solid border-[#D9D9D9]" x-on:click="goRent()">
                    <span class="font-extrabold text-lg text-center text-white">렌트하기</span>
                </button>
            <?php
                break;
            case 3:
            ?>
                <button class="grow flex justify-center items-center h-[50px] bg-black border border-solid border-[#D9D9D9]" x-on:click="goVintage()">
                    <span class="font-extrabold text-lg text-center text-white">구매하기</span>
                </button>
        <?php
                break;
        }
        ?>
    </div>

    <?php
    if ($arr_Data['INT_TYPE']) {
        // 캘린더 날짜관리
        $SQL_QUERY =    'SELECT A.STR_DAY FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=1 AND A.INT_DTYPE=1';
        $start_days_result = mysql_query($SQL_QUERY);
        $start_days_array = array();
        while ($row = mysql_fetch_assoc($start_days_result)) {
            $start_days_array[] = $row['STR_DAY'];
        }

        $SQL_QUERY =    'SELECT A.STR_DATE FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=2 AND A.INT_DTYPE=1';
        $start_dates_result = mysql_query($SQL_QUERY);
        $start_dates_array = array();
        while ($row = mysql_fetch_assoc($start_dates_result)) {
            $start_dates_array[] = $row['STR_DATE'];
        }

        $SQL_QUERY =    'SELECT A.STR_WEEK FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=3 AND A.INT_DTYPE=1';
        $start_weeks_result = mysql_query($SQL_QUERY);
        $start_weeks_array = array();
        while ($row = mysql_fetch_assoc($start_weeks_result)) {
            $start_weeks_array[] = $row['STR_WEEK'];
        }

        $SQL_QUERY =    'SELECT A.STR_DAY FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=1 AND A.INT_DTYPE=2';
        $end_days_result = mysql_query($SQL_QUERY);
        $end_days_array = array();
        while ($row = mysql_fetch_assoc($end_days_result)) {
            $end_days_array[] = $row['STR_DAY'];
        }

        $SQL_QUERY =    'SELECT A.STR_DATE FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=2 AND A.INT_DTYPE=2';
        $end_dates_result = mysql_query($SQL_QUERY);
        $end_dates_array = array();
        while ($row = mysql_fetch_assoc($end_dates_result)) {
            $end_dates_array[] = $row['STR_DATE'];
        }

        $SQL_QUERY =    'SELECT A.STR_WEEK FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=3 AND A.INT_DTYPE=2';
        $end_weeks_result = mysql_query($SQL_QUERY);
        $end_weeks_array = array();
        while ($row = mysql_fetch_assoc($end_weeks_result)) {
            $end_weeks_array[] = $row['STR_WEEK'];
        }

        // 렌트관리
        $SQL_QUERY =    'SELECT A.STR_SDATE, A.STR_EDATE 
                        FROM  
                            ' . $Tname . 'comm_goods_cart A
                        WHERE 
                            A.INT_STATE IN (1, 2, 3, 4, 5) 
                            AND A.STR_GOODCODE="' . $str_goodcode . '"
                        ORDER BY A.DTM_INDATE ASC';
        $rent_result = mysql_query($SQL_QUERY);

        $rentDates = array();
        while ($row = mysql_fetch_assoc($rent_result)) {
            $start = $row['STR_SDATE'];
            $end = $row['STR_EDATE'];
            $rentDates[] = array('start' => $start, 'end' => $end);
        }
    ?>
        <div x-show="showCalendar" x-transition x-data="{
                currentYear: null,
                currentMonth: null,
                firstDayOfWeek: 0,
                dates: [],
                selectedStatus: 0,
                exportDate: null,
                startDate: null,
                endDate: null,
                collectDate: null,
                price: {
                    originPrice: <?= $arr_Data['INT_PRICE'] ?>,
                    discount: {
                        product: <?= $arr_Data['INT_DISCOUNT'] ?: 0 ?>,
                        productMoney: 0,
                        areaMoney: 0,
                        membership: <?= $is_rent_membership ? 30 : 0 ?>,
                        membershipMoney: 0
                    },
                    totalPrice: 0
                },
                rentDays: 0,
                startDDays: <?= str_replace('"', '\'', json_encode($start_days_array)) ?>,
                startDWeeks: <?= str_replace('"', '\'', json_encode($start_weeks_array)) ?>,
                startDDates: <?= str_replace('"', '\'', json_encode($start_dates_array)) ?>,
                endDDays: <?= str_replace('"', '\'', json_encode($end_days_array)) ?>,
                endDWeeks: <?= str_replace('"', '\'', json_encode($end_weeks_array)) ?>,
                endDDates: <?= str_replace('"', '\'', json_encode($end_dates_array)) ?>,
                showCalendarAlert: false,
                rentDates: <?= str_replace('"', '\'', json_encode($rentDates)) ?>,

                generateDates(month, year) {
                    year = month == 0 ? year - 1 : month == 13 ? year + 1 : year;
                    month = month == 0 ? 12 : month == 13 ? 1 : month;
                    const firstDayOfWeek = new Date(year, month - 1, 1).getDay();
                    const daysInMonth = new Date(year, month, 0).getDate();
                    const dates = [];
                    
                    for (let day = 1; day <= daysInMonth; day++) {
                        const date = new Date(year, month - 1, day);

                        status = 1;
                        showPrice = false;
                        areaDiscount = 0;
                        rentDays = 0;

                        const year1 = date.getFullYear().toString();
                        const month1 = (date.getMonth() + 1).toString().padStart(2, '0');
                        const day1 = date.getDate().toString().padStart(2, '0');

                        const dateString = `${year1}-${month1}-${day1}`;

                        if (this.selectedStatus == 0) {
                            const enableToday = new Date();
                            enableToday.setDate(enableToday.getDate() + 2);

                            // 이미 렌트한 날짜 제외
                            var isDateBetween = false;
                            for (var i = 0; i < this.rentDates.length; i++) {
                                const rentStartDate = new Date(this.rentDates[i].start + ' 00:00:00');
                                // 반납일(1일)과 출고일(3일)제외
                                rentStartDate.setDate(rentStartDate.getDate() - 4);

                                const rentEndDate = new Date(this.rentDates[i].end + ' 00:00:00');
                                // 반납일(1일)과 출고일(3일)제외
                                rentEndDate.setDate(rentEndDate.getDate() + 4);

                                if (date.getTime() >= rentStartDate.getTime() && date.getTime() <= rentEndDate.getTime()) {
                                    isDateBetween = true;
                                    break;
                                }
                            }

                            if (isDateBetween) {
                                status = 0;
                            } else if (date.getTime() < enableToday.getTime()) {
                                status = 0;
                            } else if (date.getDay() === 1 || date.getDay() === 2) {
                                // Monday: 1, Tuesday: 2
                                status = 0;
                            } else {
                                // 일 | 날짜 | 요일
                                if (this.startDDays.includes(date.getDate().toString())) {
                                    status = 0;
                                } else if (this.startDWeeks.includes(date.getDay().toString())) {
                                    status = 0;
                                } else if (this.startDDates.includes(dateString)) {
                                    status = 0;
                                }
                            }
                        } else if (this.selectedStatus == 1) {
                            // 최소 3일을 마감선택불가일로 설정
                            const disableEndDay = new Date(this.startDate);
                            disableEndDay.setDate(disableEndDay.getDate() + 2);

                            // 최대 14일을 마감선택일로 설정
                            const finalEndday = new Date(this.startDate);
                            finalEndday.setDate(finalEndday.getDate() + 13);
                            
                            // 다음 예약한 렌트 날짜 제외
                            var isDateBetween = false;
                            for (var i = 0; i < this.rentDates.length; i++) {
                                const rentStartDate = new Date(this.rentDates[i].start + ' 00:00:00');
                                // 반납일(1일)과 출고일(3일)제외
                                rentStartDate.setDate(rentStartDate.getDate() - 4);

                                const rentEndDate = new Date(this.rentDates[i].end + ' 00:00:00');
                                // 반납일(1일)과 출고일(3일)제외
                                rentEndDate.setDate(rentEndDate.getDate() + 4);

                                if (date.getTime() >= rentStartDate.getTime() && this.startDate.getTime() < rentEndDate.getTime()) {
                                    isDateBetween = true;
                                    break;
                                }
                            }

                            if (isDateBetween) {
                                status = 5;
                            } else if (date.getTime() == this.startDate.getTime()) {
                                status = 2;
                                showPrice = true;
                            } else if (date.getTime() > finalEndday.getTime()) {
                                status = 0;
                            } else if (date.getDay() === 5 || date.getDay() === 6) {
                                // Friday: 1, Saturday: 2
                                if (date.getTime() > this.startDate.getTime() && date.getTime() < finalEndday.getTime()) {
                                    status = 5;
                                    showPrice = true;
                                } else {
                                    status = 0;
                                }
                            } else if (this.endDDays.includes(date.getDate().toString())) {
                                status = 0;
                            } else if (this.endDWeeks.includes(date.getDay().toString())) {
                                status = 0;
                            } else if (this.endDDates.includes(dateString)) {
                                status = 0;
                            } else if (date.getTime() > this.startDate.getTime() && date.getTime() <= disableEndDay.getTime()) {
                                status = 5;
                                showPrice = true;
                            } else if (date.getTime() > disableEndDay.getTime()) {
                                status = 8;
                                showPrice = true;
                            } else {
                                status = 0;
                            }

                            <!-- 출고 표시 -->
                            if (date.getTime() == this.exportDate.getTime()) {
                                status = 6;
                            }

                            <!-- 렌트 날짜 얻기 -->
                            if (date.getTime() >= this.startDate.getTime()) {
                                var diffMilliseconds = date.getTime() - this.startDate.getTime();
                                var diffDays = Math.floor(diffMilliseconds / (1000 * 60 * 60 * 24));

                                rentDays = diffDays + 1;
                            }
                        } else {
                            status = 0;
                            if (date.getTime() == this.startDate.getTime()) {
                                status = 2;
                            } else if (date.getTime() == this.endDate.getTime()) {
                                status = 3;
                            } else if (date.getTime() >= this.startDate.getTime() && date.getTime() <= this.endDate.getTime()) {
                                status = 4;
                            } else if (date.getTime() > this.endDate.getTime()) {
                                status = 5;
                            }

                            <!-- 출고 표시 -->
                            if (date.getTime() == this.exportDate.getTime()) {
                                status = 6;
                            }
                            <!-- 회수 표시 -->
                            if (date.getTime() == this.collectDate.getTime()) {
                                status = 7;
                            }

                            <!-- 렌트 날짜 얻기 -->
                            if (date.getTime() >= this.startDate.getTime() && date.getTime() <= this.endDate.getTime()) {
                                var diffMilliseconds = date.getTime() - this.startDate.getTime();
                                var diffDays = Math.floor(diffMilliseconds / (1000 * 60 * 60 * 24));

                                rentDays = diffDays + 1;
                            }
                        }

                        areaDiscount = this.getAreaDiscount(rentDays);
                        productDiscount = this.price.originPrice * this.price.discount.product / 100;
                        productSPrice = this.price.originPrice - productDiscount;
                        totalPrice = this.roundNumber(productSPrice - productSPrice * areaDiscount / 100);

                        dates.push({
                            date: date,
                            day: day,
                            // 선택불가능: 0, 선택가능: 1, 시작날짜: 2, 마감날짜: 3, 기간날짜: 4, 숨기기(시작일만 선택한경우는 마감선택불가능, 마감일을 넘는 경우): 5, 출고일: 6, 반납일: 7, 시작날짜 선택시 선택가능: 8
                            status: status,
                            showPrice: showPrice,
                            rentDays: rentDays,
                            productDiscount: productDiscount,
                            areaDiscount: areaDiscount,
                            totalPrice: totalPrice
                        });
                    }

                    this.dates = dates;
                    this.currentYear = year;
                    this.currentMonth = month;
                    this.firstDayOfWeek = firstDayOfWeek;
                },
                selectDate(date) {
                    var selectedDate = date.date;

                    if (this.selectedStatus == 0) {
                        this.startDate = new Date(selectedDate);
                        this.exportDate = new Date(selectedDate);
                        this.exportDate.setDate(this.exportDate.getDate() - 2);
                        this.selectedStatus++;
                    } else if (this.selectedStatus == 1) {
                        if (selectedDate.getTime() == this.startDate.getTime()) {
                            // 시작날짜를 눌렀을때 시작해제
                            this.selectedStatus = 0;
                            this.startDate = null;
                            this.exportDate = null;
                        } else {
                            this.endDate = new Date(selectedDate);
                            this.collectDate = new Date(selectedDate);
                            this.collectDate.setDate(this.collectDate.getDate() + 1);
                            
                            sumTotalPrice = 0;
                            sumAreaPrice = 0;
                            sumProductPrice = 0;
                            selectedStartDate = this.startDate;
                            selectedEndDate = this.endDate;
                            productSPrice = this.price.originPrice - this.price.originPrice * this.price.discount.product / 100;
                            this.dates.forEach(function(eachDay) {
                                if (eachDay.date.getTime() >= selectedStartDate.getTime() && eachDay.date.getTime() <= selectedEndDate.getTime()) {
                                    sumAreaPrice += productSPrice * eachDay.areaDiscount / 100;
                                    sumProductPrice += eachDay.productDiscount;
                                }
                            });
                            this.price.discount.areaMoney = this.roundNumber(sumAreaPrice);
                            this.price.discount.productMoney = this.roundNumber(sumProductPrice);
                            sumTotalPrice = this.price.originPrice * date.rentDays - this.price.discount.areaMoney - this.price.discount.productMoney;
                            this.price.discount.membershipMoney = this.roundNumber(sumTotalPrice * this.price.discount.membership / 100);
                            this.price.totalPrice = this.price.originPrice * date.rentDays - this.price.discount.areaMoney - this.price.discount.productMoney - this.price.discount.membershipMoney;
                            this.rentDays = date.rentDays;
                            this.selectedStatus++;

                            rentDate = {
                                startDate: this.startDate,
                                endDate: this.endDate
                            };
                        }
                    } else if (this.selectedStatus == 2) {
                        if (selectedDate.getTime() == this.endDate.getTime()) {
                            // 마감날짜를 눌렀을때 마감해제
                            this.selectedStatus = 1;
                            this.endDate = null;
                            this.collectDate = null;

                            rentDate = null;
                        }
                    }

                    this.generateDates(selectedDate.getMonth() + 1, selectedDate.getFullYear());
                },
                getAreaDiscount(rentDays) {
                    areaDiscount = 0;

                    // 구간1
                    if (<?= $site_Data['INT_DSTART1'] ?: 0 ?> <= rentDays && rentDays <= <?= $site_Data['INT_DEND1'] ?: 0 ?>) {
                        areaDiscount = <?= $site_Data['INT_DISCOUNT1'] ?>;
                    } else if (<?= $site_Data['INT_DSTART2'] ?: 0 ?> <= rentDays && rentDays <= <?= $site_Data['INT_DEND2'] ?: 0 ?>) {
                        areaDiscount = <?= $site_Data['INT_DISCOUNT2'] ?>;
                    } else if (<?= $site_Data['INT_DSTART3'] ?: 0 ?> <= rentDays && rentDays <= <?= $site_Data['INT_DEND3'] ?: 0 ?>) {
                        areaDiscount = <?= $site_Data['INT_DISCOUNT3'] ?>;
                    } else if (<?= $site_Data['INT_DSTART4'] ?: 0 ?> <= rentDays && rentDays <= <?= $site_Data['INT_DEND4'] ?: 0 ?>) {
                        areaDiscount = <?= $site_Data['INT_DISCOUNT4'] ?>;
                    }

                    return areaDiscount;
                },
                formatDate(date) {
                    const weekdays = ['일', '월', '화', '수', '목', '금', '토'];
                    const year = date.getFullYear().toString().slice(-2);
                    const month = (date.getMonth() + 1).toString().padStart(2, '0');
                    const day = date.getDate().toString().padStart(2, '0');
                    const weekday = weekdays[date.getDay()];
                    
                    return `${month}. ${day}(${weekday})`;
                },
                initDate() {
                    this.selectedStatus = 0;
                    this.startDate = null;
                    this.endDate = null;
                    this.generateDates(this.currentMonth, this.currentYear);

                    rentDate = null;
                },
                showAlert() {
                    this.showCalendarAlert = true;
                    setTimeout(() => this.showCalendarAlert = false, 2000);
                },
                roundNumber(number) {
                    return Math.round(number / 100) * 100;
                },
                closeCalendar() {
                    showCalendar = false;
                    this.initDate();
                    this.init();
                },
                init() {
                    today = new Date();
                    this.generateDates(today.getMonth() + 1, today.getFullYear());
                }
            }" class="w-full bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center max-w-[410px]" style="display: none;height: calc(100vh - 66px);">
            <div class="flex flex-col items-center rounded-t-lg bg-white w-full h-full relative">
                <div class="flex flex-row pt-3 pb-2.5 px-[26px] justify-between items-center w-full">
                    <p class="font-extrabold text-xs leading-[14px] text-black">예약</p>
                    <button class="w-2.5 h-2.5" x-on:click="closeCalendar();">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                        </svg>
                    </button>
                </div>
                <hr class="border-t-[0.5px] border-[#E0E0E0] w-full" />
                <div class="flex flex-col items-center w-full overflow-auto h-full">
                    <div class="flex flex-col items-center justify-center px-8 pt-[34px] pb-7">
                        <p class="font-medium text-base leading-[18px] text-black">예약날짜 설정하기</p>
                        <div class="mt-[17px] flex gap-[13px] items-center">
                            <div class="flex gap-[1.4px] items-center">
                                <div class="w-[12.56px] h-[12.56px] rounded-full bg-[#BED2B6]"></div>
                                <label for="calendar_available" class="font-bold text-[11px] leading-[11px] text-[#666666]">선택가능</label>
                            </div>
                            <div class="flex gap-[1.4px] items-center">
                                <div class="w-[12.56px] h-[12.56px] rounded-full bg-[#E5EAE3]"></div>
                                <label for="calendar_use" class="font-bold text-[11px] leading-[11px] text-[#666666]">이용기간</label>
                            </div>
                            <div class="flex gap-[1.4px] items-center">
                                <div class="w-[12.56px] h-[12.56px] rounded-full bg-[#DDDDDD]"></div>
                                <label for="calendar_no_use" class="font-bold text-[11px] leading-[11px] text-[#666666]">이용불가</label>
                            </div>
                        </div>
                        <div class="flex flex-col w-full">
                            <div class="mt-[27px] relative flex justify-center items-end w-full">
                                <p class="font-extrabold text-[13px] leading-[15px] text-black" x-text="currentYear + '.' + (currentMonth > 9 ? currentMonth : '0' + currentMonth)">2023.01</p>
                                <button id="previous_month" class="absolute left-0 bottom-0" x-on:click="generateDates(currentMonth - 1, currentYear)">
                                    <svg width="7" height="9" viewBox="0 0 7 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.19892 4.51706L6.67092 6.74006V8.39106L0.378921 5.14106V3.85406L6.67092 0.604062V2.24206L2.19892 4.43906V4.51706Z" fill="black" />
                                    </svg>
                                </button>
                                <button id="next_month" class="absolute right-0 bottom-0" x-on:click="generateDates(currentMonth + 1, currentYear)">
                                    <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.23103 4.43906L0.759028 2.24206V0.604062L7.05103 3.85406V5.14106L0.759028 8.39106V6.74006L5.23103 4.51706V4.43906Z" fill="black" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-[17px] flex gap-[9px] justify-between items-center">
                                <?php
                                $daysOfWeek = array("일", "월", "화", "수", "목", "금", "토");
                                for ($i = 0; $i < count($daysOfWeek); $i++) {
                                ?>
                                    <div class="flex-1 flex justify-center items-center">
                                        <p class="font-bold text-xs leading-[14px] text-[#898989]"><?= $daysOfWeek[$i] ?></p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <hr class="mt-[19px] border-t-[0.5px] border-[#E0E0E0]" />
                            <div class="mt-[13px] grid grid-cols-7 gap-y-[11px] place-content-between place-items-center w-full">
                                <template x-for="i in firstDayOfWeek">
                                    <div class="flex justify-center items-center rounded-full w-[38px] h-[38px]"></div>
                                </template>
                                <template x-for="date in dates">
                                    <div class="flex justify-center items-center px-1.5" x-bind:class="
                                        date.status == 1 ? '' :
                                        (date.status == 2 && selectedStatus == 2) ? 'bg-[#E5EAE3] rounded-l-full ml-1.5 pl-0' :
                                        date.status == 3 ? 'bg-[#E5EAE3] rounded-r-full mr-1.5 pr-0' :
                                        date.status == 4 ? 'bg-[#E5EAE3]' : 'bg-white'">
                                        <div class="flex justify-center items-center rounded-full w-[38px] h-[38px] z-10 relative cursor-pointer" x-bind:class="
                                            date.status == 0 ? 'bg-[#DDDDDD] text-black' : 
                                            date.status == 1 ? 'bg-[#BED2B6] text-black' : 
                                            (date.status == 2 || date.status == 3) ? 'bg-[#00402F] text-white' : 
                                            date.status == 4 ? 'bg-[#E5EAE3] text-black' : 
                                            date.status == 5 ? 'bg-white text-[#DDDDDD]' : 
                                            date.status == 6 ? 'bg-white text-black border border-solid border-[#DDDDDD]' : 
                                            date.status == 7 ? 'bg-white text-black border border-solid border-[#DDDDDD]' : 
                                            date.status == 8 ? 'bg-white text-black' : 'bg-white text-[#DDDDDD]'" x-on:click="(date.status == 1 || date.status == 2 || date.status == 3 || date.status == 8) ? selectDate(date) : showAlert()">
                                            <template x-if="date.status == 6 || date.status == 7">
                                                <div class="absolute -top-[4px] left-[3px] flex justify-center items-center w-8 h-[14px] bg-[#DDDDDD] rounded-full">
                                                    <p class="font-normal text-[9px] leading-[10px] text-black" x-text="date.status == 6 ? '출고' : '회수'">출고</p>
                                                </div>
                                            </template>
                                            <p class="font-bold text-xs leading-[14px]" x-text="date.day"></p>
                                            <template x-if="date.showPrice">
                                                <p class="absolute bottom-0 left-0 w-full font-normal text-[9px] leading-[10px] text-center" x-bind:class="
                                            date.status == 2 ? 'top-[38px] text-[#00402F]' : 
                                            date.status == 5 ? 'bottom-0 text-[#DDDDDD]' : 'bottom-0 text-black'" x-text="date.totalPrice.toLocaleString()">31,800</p>
                                            </template>
                                            <template x-if="date.status == 2 && selectedStatus == 1">
                                                <div class="flex flex-col justify-center items-center w-[86px] h-[34px] bg-black bg-opacity-80 rounded-[12px] absolute -top-11 z-10">
                                                    <p class="font-bold text-[10px] leading-3 text-white" x-text="currentMonth + '월 ' + date.day + '일'">1월 22일</p>
                                                    <p class="font-medium text-[9px] leading-[11px] text-white">종료일을 선택하세요</p>
                                                    <div class="absolute top-[34px] z-10">
                                                        <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M3.49691e-07 0.0583489L8 0.0583496L4 4.05835L3.49691e-07 0.0583489Z" fill="black" fill-opacity="0.8" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <template x-if="selectedStatus == 1">
                        <div class="flex flex-col w-full">
                            <hr class="border-t-[0.5px] border-[#E0E0E0] w-full" />
                            <div class="flex flex-col gap-[8.62px] px-7 py-[14px]">
                                <div class="flex">
                                    <p class="w-[60px] font-bold text-xs leading-[14px] text-black">출고일</p>
                                    <p class="font-bold text-xs leading-[14px] text-[#666666]" x-text="formatDate(exportDate)">01. 20(금)</p>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="selectedStatus == 2">
                        <div class="flex flex-col w-full">
                            <hr class="border-t-[0.5px] border-[#E0E0E0] w-full" />
                            <div class="flex flex-col gap-[8.62px] px-7 py-[14px]">
                                <div class="flex">
                                    <p class="w-[60px] font-bold text-xs leading-[14px] text-black">출고일</p>
                                    <p class="font-bold text-xs leading-[14px] text-[#666666]" x-text="formatDate(exportDate)">01. 20(금)</p>
                                </div>
                                <div class="flex">
                                    <p class="w-[60px] font-bold text-xs leading-[14px] text-black">이용기간</p>
                                    <p class="font-bold text-xs leading-[14px] text-[#666666]" x-text="formatDate(startDate) + ' ~ ' + formatDate(endDate)">01. 22(일) ~ 01. 26(목)</p>
                                </div>
                                <div class="flex">
                                    <p class="w-[60px] font-bold text-xs leading-[14px] text-black">회수일</p>
                                    <p class="font-bold text-xs leading-[14px] text-[#666666]" x-text="formatDate(collectDate)">01. 27(금)</p>
                                </div>
                            </div>
                            <hr class="border-t-[0.5px] border-[#E0E0E0] w-full" />
                            <div class="flex flex-col gap-[4.79px] px-7 py-5">
                                <div class="flex">
                                    <p class="w-[60px] font-bold text-xs leading-[14px] text-black">주문금액</p>
                                    <p class="font-bold text-xs leading-[14px] line-through text-[#666666]" x-text="(price.originPrice * rentDays).toLocaleString() + '원'">100원</p>
                                </div>
                                <div class="flex">
                                    <p class="w-[60px] font-bold text-xs leading-[14px] text-black">금액할인가</p>
                                    <p class="font-bold text-xs leading-[14px] text-[#666666]" x-text="'-' + (price.discount.productMoney).toLocaleString() + '원'">100원</p>
                                </div>
                                <div class="flex">
                                    <p class="w-[60px] font-bold text-xs leading-[14px] text-black">구간할인가</p>
                                    <p class="font-bold text-xs leading-[14px] text-[#666666]" x-text="'-' + (price.discount.areaMoney).toLocaleString() + '원'">100원</p>
                                </div>
                                <div class="flex">
                                    <p class="w-[60px] font-bold text-xs leading-[14px] text-black">멤버십할인</p>
                                    <p class="font-bold text-xs leading-[14px] text-[#666666]" x-text="'-' + (price.discount.membershipMoney).toLocaleString() + '원'">100원</p>
                                </div>
                                <div class="flex">
                                    <p class="w-[60px] font-bold text-xs leading-[14px] text-black"></p>
                                    <div class="flex gap-2 items-end">
                                        <p class="font-extrabold text-lg leading-5 text-[#00402F]" x-text="(Math.floor(price.totalPrice / (price.originPrice * rentDays) * 100)).toLocaleString() + '%'">30%</p>
                                        <p class="font-extrabold text-lg leading-5 text-[#333333]" x-text="price.totalPrice.toLocaleString() + '원'">1000원</p>
                                        <p class="font-bold text-xs leading-[14px] text-[#00402F]">할인혜택 적용가</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <hr class="border-t-[0.5px] border-[#E0E0E0] w-full" />
                    <div class="mt-[15px] mb-5 flex flex-col items-center w-full px-[13px]">
                        <div class="flex justify-center items-center px-2.5 py-[5px] bg-[#F5F5F5] rounded-[10px]">
                            <p class="font-bold text-xs leading-[14px] text-black">렌트 가격 할인 TIP!</p>
                        </div>
                        <p class="mt-2 font-bold text-[11px] leading-[13px] text-[#666666]">기간이 길어질수록 1일 렌트가가 내려갑니다.</p>
                        <div class="mt-[26px] flex flex-col w-full px-7">
                            <div class="flex flex-col w-full relative">
                                <div class="w-full pl-[28px] pr-[25px] mt-5">
                                    <img class="min-w-full" src="images/rent_discount.png" alt="">
                                </div>
                                <div class="flex justify-between w-full px-[7px] absolute left-0">
                                    <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px]"><?= $site_Data['INT_DISCOUNT1'] ? $site_Data['INT_DISCOUNT1'] . '% 할인' : '할인혜택 없음' ?></p>
                                    <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px] mt-[16px]"><?= $site_Data['INT_DISCOUNT2'] ? $site_Data['INT_DISCOUNT2'] . '% 할인' : '할인혜택 없음' ?></p>
                                    <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px] mt-[32px]"><?= $site_Data['INT_DISCOUNT3'] ? $site_Data['INT_DISCOUNT3'] . '% 할인' : '할인혜택 없음' ?></p>
                                    <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px] mt-[46px]"><?= $site_Data['INT_DISCOUNT4'] ? $site_Data['INT_DISCOUNT4'] . '% 할인' : '할인혜택 없음' ?></p>
                                </div>
                                <hr class="mt-5 border-t-[0.5px] border-[#E0E0E0] w-full" />
                                <div class="mt-2 flex justify-between w-full px-[7px]">
                                    <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px]"><?= $site_Data['INT_DSTART1'] ?>일~<?= $site_Data['INT_DEND1'] ?>일</p>
                                    <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px]"><?= $site_Data['INT_DSTART2'] ?>일~<?= $site_Data['INT_DEND2'] ?>일</p>
                                    <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px]"><?= $site_Data['INT_DSTART3'] ?>일~<?= $site_Data['INT_DEND3'] ?>일</p>
                                    <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px]"><?= $site_Data['INT_DSTART4'] ?>일~<?= $site_Data['INT_DEND4'] ?>일</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-[40%] z-20">
                    <div x-show="showCalendarAlert" class="flex flex-col justify-center items-center gap-3 px-[50px] py-5 bg-black bg-opacity-80 border border-solid border-[#D9D9D9] rounded-[11px] w-[300px]" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 0.00023987C17.713 0.00023987 21.2739 1.47517 23.8995 4.10066C26.5251 6.72616 28 10.2873 28 14.0001C28 17.7129 26.5251 21.274 23.8995 23.8996C21.274 26.5251 17.7129 28 14 28C10.2871 28 6.7261 26.5251 4.10046 23.8996C1.47494 21.2741 0 17.7129 0 14.0001C0.00398445 10.2883 1.48034 6.72988 4.1049 4.10486C6.7297 1.48033 10.288 0.00396002 14.0002 0L14 0.00023987ZM14 22.4002C14.3713 22.4002 14.7275 22.2527 14.99 21.99C15.2525 21.7275 15.3999 21.3715 15.3999 21.0002C15.3999 20.6288 15.2525 20.2727 14.99 20.0102C14.7275 19.7477 14.3713 19.6001 14 19.6001C13.6287 19.6001 13.2725 19.7477 13.01 20.0102C12.7475 20.2727 12.6001 20.6288 12.6001 21.0002C12.6001 21.3715 12.7475 21.7275 13.01 21.99C13.2725 22.2527 13.6287 22.4002 14 22.4002ZM12.6001 16.8002C12.6001 17.3004 12.8668 17.7626 13.2999 18.0126C13.733 18.2627 14.2669 18.2627 14.7001 18.0126C15.1332 17.7626 15.3999 17.3004 15.3999 16.8002V6.99976C15.3999 6.4996 15.1332 6.03741 14.7001 5.78733C14.267 5.53725 13.7331 5.53725 13.2999 5.78733C12.8668 6.03741 12.6001 6.4996 12.6001 6.99976V16.8002Z" fill="white" />
                        </svg>
                        <p class="font-medium text-[15px] leading-[17px] text-center text-white">
                            해당 날짜엔 이용이 불가합니다.<br>
                            다른 일을 선택해주세요.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <div id="basket_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-end max-w-[410px] hidden" style="height: calc(100vh - 66px);">
        <div class="mb-5 flex flex-col gap-[12.5px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
            <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('basket_dialog').classList.add('hidden');">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                </svg>
            </button>
            <p class="font-bold text-[15px] leading-[17px] text-black">장바구니에 상품이 담겼습니다.</p>
            <a href="/m/mine/basket/index.php" class="flex flex-row gap-[12.3px] items-center justify-center px-5 py-2.5 bg-white border-[0.84px] border-solid border-[#D9D9D9]">
                <p class="font-bold text-[10px] leading-[11px] text-[#666666]">장바구니 바로가기</p>
                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.52603 9.0481L5.45631 4.95636C5.50296 4.90765 5.53592 4.85488 5.55521 4.79805C5.5748 4.74122 5.58459 4.68033 5.58459 4.61538C5.58459 4.55044 5.5748 4.48955 5.55521 4.43272C5.53592 4.37589 5.50296 4.32312 5.45631 4.27441L1.52603 0.170489C1.41718 0.0568296 1.28112 0 1.11785 0C0.95457 0 0.814619 0.060889 0.697994 0.182667C0.581368 0.304445 0.523056 0.446519 0.523056 0.60889C0.523056 0.77126 0.581368 0.913335 0.697994 1.03511L4.12678 4.61538L0.697994 8.19566C0.589143 8.30932 0.534719 8.44928 0.534719 8.61555C0.534719 8.78214 0.593031 8.92632 0.709656 9.0481C0.826282 9.16988 0.962345 9.23077 1.11785 9.23077C1.27335 9.23077 1.40941 9.16988 1.52603 9.0481Z" fill="#666666" />
                </svg>
            </a>
        </div>
    </div>

    <div x-show="showSubscriptionAlert" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-end max-w-[410px]" style="display: none;height: calc(100vh - 66px);">
        <div class="mb-5 flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-10">
            <button class="absolute top-[15px] right-[21px]" x-on:click="showSubscriptionAlert = false">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                </svg>
            </button>
            <p class="font-bold text-[15px] leading-[17px] text-black">구독권 결제가 필요합니다.</p>
            <p class="font-bold text-xs leading-[18px] text-[#666666] text-center">
                구독권 가입 후 해당 상품 이용이 가능합니다.<br>
                해당 페이지 상단에 있는 프리미엄 멤버십을 가입해주세요.
            </p>
        </div>
    </div>

    <div x-show="customAlert.show" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-end max-w-[410px]" style="display: none;height: calc(100vh - 66px);">
        <div class="mb-5 flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-10">
            <button class="absolute top-[15px] right-[21px]" x-on:click="customAlert.show = false">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                </svg>
            </button>
            <p class="font-bold text-xs leading-[18px] text-[#666666] text-center" x-html="customAlert.text"></p>
        </div>
    </div>

    <div x-show="showVintagePanel" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-end max-w-[410px]" style="display: none;height: calc(100vh - 66px);">
        <div class="flex flex-col items-center justify-center rounded-t-lg bg-white w-full relative">
            <button class="absolute top-[15px] right-[21px]" x-on:click="showVintagePanel = false; initVintageCount();">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                </svg>
            </button>
            <div class="mt-[46px] flex flex-col gap-[9px] border-t-[0.5px] border-[#E0E0E0] w-full px-7 py-[15px]">
                <p class="font-bold text-sm leading-4 text-black"><?= $arr_Data['STR_GOODNAME'] ?></p>
                <div class="flex justify-between items-start">
                    <div class="flex flex-row">
                        <button class="flex justify-center items-center border border-solid border-[#D9D9D9] w-[22px] h-[22px]" x-on:click="removeVintageCount()">
                            <p class="font-bold text-base leading-[16px] text-[#666666]">-</p>
                        </button>
                        <input type="text" class="border border-solid border-[#D9D9D9] w-[41.25px] h-[22px] font-bold text-base text-center text-black" x-model="vintageCount">
                        <button class="flex justify-center items-center border border-solid border-[#D9D9D9] w-[22px] h-[22px]" x-on:click="addVintageCount()">
                            <p class="font-bold text-base leading-[16px] text-[#666666]">+</p>
                        </button>
                    </div>
                    <p class="font-semibold text-sm leading-4 text-black"><?= number_format($arr_Data['INT_PRICE']) ?>원</p>
                </div>
            </div>
            <div class="flex flex-row gap-[19px] border-t-[0.5px] border-[#E0E0E0] w-full px-7 py-[15px]">
                <p class="font-semibold text-sm leading-4 text-black">주문금액</p>
                <div class="flex flex-col gap-[5px]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]" x-text="vintageOMoney.toLocaleString() + '원'">2,700,000원</p>
                    <div class="flex flex-row gap-2 items-end">
                        <p class="font-extrabold text-lg leading-5 text-[#7E6B5A]"><?= $arr_Data['INT_DISCOUNT'] ?: 0 ?>%</p>
                        <p class="font-extrabold text-lg leading-5 text-[#333333A]" x-text="vintageMoney.toLocaleString() + '원'">2,400,000원</p>
                        <p class="font-bold text-sm leading-4 text-[#7E6B5A]">최대 할인적용가</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="relative_image_panel" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-end max-w-[410px] hidden" style="height: calc(100vh - 66px);">
        <div class="flex flex-col items-center justify-center bg-white w-full h-full relative pt-[100px]">
            <button class="absolute top-[80px] right-[21px] z-10" onclick="closeRelativeImage()">
                <svg width="20" height="20" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                </svg>
            </button>
            <div class="flex relative w-full">
                <button class="flex justify-center items-center absolute top-[45%] left-0 w-[10%] h-[10%] bg-black bg-opacity-50" onclick="document.getElementById('scrollContainer').scrollLeft -= 410">
                    <p class="font-extrabold text-base text-white">
                        < </p>
                </button>
                <div id="scrollContainer" class="flex flex-row gap-[5px] overflow-x-auto overflow-y-clip scrollbar-hide snap-x snap-mandatory scroll-smooth h-[503px]">
                    <?php
                    for ($i = 6; $i <= 12; $i++) {
                        if ($arr_Data['STR_IMAGE' . $i]) {
                    ?>
                            <div class="snap-always snap-center flex-none flex-grow-0 w-full max-h-[500px] border border-solid border-[#DDDDDD] bg-gray-100">
                                <img class="min-w-full h-full object-cover" src="/admincenter/files/good/<?= $arr_Data['STR_IMAGE' . $i] ?>" onerror="this.style.display='none'" alt="">
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <button class="flex justify-center items-center absolute top-[45%] right-0 w-[10%] h-[10%] bg-black bg-opacity-50" onclick="document.getElementById('scrollContainer').scrollLeft += 410">
                    <p class="font-extrabold text-base text-white">></p>
                </button>
            </div>
        </div>
    </div>

    <div id="alarm_confirm_panel" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-end max-w-[410px] hidden" style="height: calc(100vh - 66px);">
        <div class="mb-5 flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative">
            <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('alarm_confirm_panel').classList.add('hidden');">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                </svg>
            </button>
            <div class="flex justify-center items-center w-full py-[15px] border-b-[0.5px] border-[#E0E0E0]">
                <p class="font-bold text-[15px] leading-[17px] text-black">입고알림 신청</p>
            </div>
            <div class="flex flex-col gap-[15px] w-full px-[14px] pt-[15px] pb-[25px]">
                <div class="flex flex-row gap-2.5">
                    <div class="w-[91px] h-[91px] flex justify-center items-center bg-[#F9F9F9] p-2.5">
                        <img class="w-full" src="/admincenter/files/good/<?= $arr_Data['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
                    </div>
                    <div class="flex flex-col justify-center">
                        <div class="flex justify-center items-center w-[34px] h-[18px] py-1 bg-[#EEAC4C]">
                            <p class="font-normal text-[10px] leading-[11px] text-center text-white">구독</p>
                        </div>
                        <p class="mt-2.5 font-bold text-xs leading-3 text-black"><?= $arr_Data['STR_BRAND'] ?></p>
                        <p class="mt-2 font-extrabold text-xs leading-3 text-[#666666]"><?= $arr_Data['STR_GOODNAME'] ?: '' ?></p>
                        <p class="mt-1 font-bold text-[13px] leading-[14px] text-black">
                            <span class="font-medium text-[#EEAC4C]">월</span> <?= number_format($site_Data['INT_OPRICE1']) ?>원
                        </p>
                    </div>
                </div>
                <p class="font-bold text-xs leading-[18px] text-[#666666]">
                    상품이 재입고되면 알림톡 또는 SMS가 발송됩니다.<br>
                    입고 알림을 신청하시겠습니까?
                </p>
                <div class="flex flex-col gap-1.5 px-3 items-start py-[15px] bg-[#F5F5F5]">
                    <div class="flex flex-row gap-[3px] items-center">
                        <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 9.42345e-05C6.95869 9.42345e-05 8.35761 0.579531 9.38911 1.61098C10.4206 2.64242 11 4.04144 11 5.50005C11 6.95866 10.4206 8.35763 9.38911 9.38912C8.35765 10.4206 6.95862 11 5.5 11C4.04138 11 2.6424 10.4206 1.6109 9.38912C0.579442 8.35768 0 6.95866 0 5.50005C0.00156498 4.04184 0.581562 2.64388 1.61264 1.61263C2.64381 0.581558 4.04162 0.00164996 5.5 9.42345e-05ZM5.5 8.80007C5.64585 8.80007 5.78581 8.74215 5.88893 8.63893C5.99206 8.53581 6.04998 8.39593 6.04998 8.2501C6.04998 8.10416 5.99206 7.96429 5.88893 7.86117C5.78581 7.75804 5.64586 7.70003 5.5 7.70003C5.35414 7.70003 5.21419 7.75804 5.11107 7.86117C5.00794 7.96429 4.95002 8.10417 4.95002 8.2501C4.95002 8.39595 5.00794 8.53581 5.11107 8.63893C5.21419 8.74215 5.35414 8.80007 5.5 8.80007ZM4.95002 6.60008C4.95002 6.79658 5.05481 6.97815 5.22497 7.0764C5.39512 7.17464 5.60487 7.17464 5.77504 7.0764C5.9452 6.97815 6.04998 6.79658 6.04998 6.60008V2.74991C6.04998 2.55342 5.94519 2.37184 5.77504 2.2736C5.60488 2.17535 5.39513 2.17535 5.22497 2.2736C5.0548 2.37184 4.95002 2.55341 4.95002 2.74991V6.60008Z" fill="#333333" />
                        </svg>
                        <p class="font-bold text-[10px] leading-[14px] text-black">재입고 알림 서비스 안내</p>
                    </div>
                    <p class="font-normal text-[9px] leading-[14px] text-[#666666]">
                        -재입고 알림 서비스는 신청 후 30일간 유효합니다. (30일 이후에는<br>
                        재입고시에도 알림이 되지 않습니다.)<br>
                        -신청 상품의 옵션 및 가격 등의 상품정보가 변동될 수 있으니 재입고시<br>
                        상품정보 확인 후 구매하시기 바랍니다.<br>
                        -신청한 상품은 마이페이지 > 입고알림내역 에서 확인 가능합니다.<br>
                        -개인정보의 SMS 수신동의 여부와 관계없이 알림 메시지가 발송됩니다.<br>
                    </p>
                </div>
                <button class="flex justify-center items-center w-full h-[40px] bg-black border-[0.8px] border-solid border-[#D9D9D9]" onclick="setAlarm()">
                    <p class="font-bold text-xs leading-[14px] text-white">입고알림 신청하기</p>
                </button>
            </div>
        </div>
    </div>

    <div id="alarm_result_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-end max-w-[410px] hidden" style="height: calc(100vh - 66px);">
        <div class="mb-5 flex flex-col gap-[12.5px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
            <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('alarm_result_dialog').classList.add('hidden');">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                </svg>
            </button>
            <p class="font-bold text-[15px] leading-[17px] text-black">입고알림 신청이 완료되었습니다.</p>
            <a href="/m/mine/favorite/index.php" class="flex flex-row gap-[12.3px] items-center justify-center px-5 py-2.5 bg-white border-[0.84px] border-solid border-[#D9D9D9]">
                <p class="font-bold text-[10px] leading-[11px] text-[#666666]">입고알림 내역 바로가기</p>
                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.52603 9.0481L5.45631 4.95636C5.50296 4.90765 5.53592 4.85488 5.55521 4.79805C5.5748 4.74122 5.58459 4.68033 5.58459 4.61538C5.58459 4.55044 5.5748 4.48955 5.55521 4.43272C5.53592 4.37589 5.50296 4.32312 5.45631 4.27441L1.52603 0.170489C1.41718 0.0568296 1.28112 0 1.11785 0C0.95457 0 0.814619 0.060889 0.697994 0.182667C0.581368 0.304445 0.523056 0.446519 0.523056 0.60889C0.523056 0.77126 0.581368 0.913335 0.697994 1.03511L4.12678 4.61538L0.697994 8.19566C0.589143 8.30932 0.534719 8.44928 0.534719 8.61555C0.534719 8.78214 0.593031 8.92632 0.709656 9.0481C0.826282 9.16988 0.962345 9.23077 1.11785 9.23077C1.27335 9.23077 1.40941 9.16988 1.52603 9.0481Z" fill="#666666" />
                </svg>
            </a>
        </div>
    </div>
</div>

<script>
    var is_basket = <?= $arr_Data['IS_BASKET'] ?: 0 ?>;

    $(document).ready(function() {
        searchOwnReview();
        searchRelatedReview();

        $('.slider-section').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: true,
            autoplay: true,
            autoplaySpeed: 3000,
        });

        var detail_image_scroll_list = new Splide('.detail-image-scroll-list', {
            drag: 'free',
        });
        detail_image_scroll_list.mount();

        var review_image_scroll_list = new Splide('.review-image-scroll-list', {
            drag: 'free',
        });
        review_image_scroll_list.mount();

        // See more button showing
        const contentElement = $refs.content;
        console.log(contentElement.clientHeight);
        console.log(contentElement.scrollHeight);
        return contentElement.scrollHeight > contentElement.clientHeight;
    });
    const isTextClamped = elm => elm.scrollHeight > elm.clientHeight

    function searchOwnReview(page = 0) {
        url = "get_own_review_list.php";
        url += "?page=" + page;
        url += "&str_goodcode=" + <?= $arr_Data['STR_GOODCODE'] ?>;

        $.ajax({
            url: url,
            success: function(result) {
                $("#own_review_list").html(result);
                if (page > 0) {
                    $('html, body').animate({
                        scrollTop: $("#own_review_list").offset().top - 150
                    }, 500);
                }
            }
        });
    }

    function searchRelatedReview(page = 0) {
        url = "get_related_review_list.php";
        url += "?page=" + page;
        url += "&str_goodcode=" + <?= $arr_Data['STR_GOODCODE'] ?>;
        url += "&int_good_type=" + <?= $arr_Data['INT_TYPE'] ?>;
        url += "&int_brand=" + <?= $arr_Data['INT_BRAND'] ?>;

        $.ajax({
            url: url,
            success: function(result) {
                $("#related_review_list").html(result);
                if (page > 0) {
                    $('html, body').animate({
                        scrollTop: $("#related_review_list").offset().top - 150
                    }, 500);
                }
            }
        });
    }

    function setReviewLike(bd_seq) {
        $.ajax({
            url: "/m/review/set_like.php",
            data: {
                bd_seq: bd_seq
            },
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');

                    const str_url = encodeURIComponent(window.location.pathname + window.location.search);
                    document.location.href = "/m/memberjoin/login.php?loc=" + str_url;
                }
                if (result['status'] == 200) {
                    $("#like_count_" + bd_seq).html(result['data']);
                }
            }
        });
    }

    function setProductLike(str_goodcode) {
        $.ajax({
            url: "/m/product/set_like.php",
            data: {
                str_goodcode: str_goodcode
            },
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');

                    const str_url = encodeURIComponent(window.location.pathname + window.location.search);
                    document.location.href = "/m/memberjoin/login.php?loc=" + str_url;
                }
                if (result['status'] == 200) {
                    if (result['data'] == true) {
                        $("#is_like_no").hide();
                        $("#is_like_yes").show();
                    }
                    if (result['data'] == false) {
                        $("#is_like_no").show();
                        $("#is_like_yes").hide();
                    }
                }
            }
        });
    }

    function addProductBasket(str_goodcode) {
        if (is_basket) {
            document.getElementById('basket_dialog').classList.remove('hidden');
            return;
        }
        $.ajax({
            url: "/m/product/set_basket.php",
            data: {
                str_goodcode: str_goodcode
            },
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');

                    const str_url = encodeURIComponent(window.location.pathname + window.location.search);
                    document.location.href = "/m/memberjoin/login.php?loc=" + str_url;
                }
                if (result['status'] == 200) {
                    if (result['data'] == true) {
                        is_basket = 1;
                        document.getElementById('basket_dialog').classList.remove('hidden');
                    }
                }
            }
        });
    }

    function scrollToDiv(name) {
        const element = document.getElementById(name);
        const topOffset = element.offsetTop - 100;
        window.scrollTo({
            top: topOffset,
            behavior: 'smooth'
        });
    }

    window.addEventListener('scroll', function() {
        var staticMenu = document.getElementById('menu_panel');
        var topMenu = document.getElementById('top_menu_panel');

        if (isElementHidden(staticMenu)) {
            topMenu.classList.remove('hidden');
            setTopMenu();
        } else {
            topMenu.classList.add('hidden');
        }
    });

    function setTopMenu() {
        for (var i = 1; i <= 4; i++) {
            var menu = document.getElementById('menu_div' + i);

            if (menu.getBoundingClientRect().top <= 120) {
                Alpine.store('detailMenu', i);
            }
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.store('detailMenu', 0);
    })

    function isElementHidden(element) {
        var rect = element.getBoundingClientRect();
        return rect.bottom <= 100;
    }

    function showRelativeImage(index) {
        var imagePanel = document.getElementById('relative_image_panel');
        imagePanel.classList.remove('hidden');
        document.getElementById('scrollContainer').scrollLeft = 410 * index;

        // Disable body scroll
        document.body.style.height = '100px';
        document.body.style.overflow = 'hidden';
    }

    function closeRelativeImage(index) {
        var imagePanel = document.getElementById('relative_image_panel');
        imagePanel.classList.add('hidden');

        // Disable body scroll
        document.body.style.height = 'auto';
        document.body.style.overflow = 'auto';
    }

    function showAlarmConfirmPanel() {
        if (<?= $alarm_Data['COUNT'] ?: 0 ?> > 0) {
            alert('이미 입고알림을 신청하셨습니다.');
            return;
        }
        document.getElementById('alarm_confirm_panel').classList.remove('hidden');
    }

    function setAlarm() {
        $.ajax({
            url: "/m/product/set_alarm.php",
            data: {
                str_goodcode: '<?= $str_goodcode ?>'
            },
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');

                    const str_url = encodeURIComponent(window.location.pathname + window.location.search);
                    document.location.href = "/m/memberjoin/login.php?loc=" + str_url;
                }
                if (result['status'] == 200) {
                    if (result['data'] == true) {
                        document.getElementById('alarm_confirm_panel').classList.add('hidden');
                        document.getElementById('alarm_result_dialog').classList.remove('hidden');
                    }
                }
            }
        });
    }
</script>

<?php
$hide_footer_menu = true;
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>