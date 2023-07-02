<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<?php
$int_number = Fnc_Om_Conv_Default($_REQUEST['int_number'], '');

// 상품정보 얻기
$SQL_QUERY =    'SELECT
                    A.*, B.INT_TYPE, B.STR_IMAGE1, B.STR_GOODNAME, B.INT_PRICE, C.STR_CODE AS STR_BRAND
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
                    A.INT_NUMBER="' . $int_number .'"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}

$product_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<!-- 주문완료 -->
<div class="mt-[30px] flex flex-col items-center w-full">
    <p class="font-extrabold text-lg leading-5 text-center text-[#333333]">주문완료</p>
    <div class="mt-[25px] w-[280px] h-[163px] flex justify-center items-center">
        <img class="w-full h-full" src="images/paid.png" alt="successful">
    </div>
    <p class="mt-5 font-bold text-[15px] leading-[17px] text-center text-black">주문이 완료되었습니다.</p>
    <p class="mt-2.5 font-medium text-xs leading-[140%] text-center text-[#666666]"><?= date('Y. m. d', strtotime($product_Data['DTM_INDATE'])) ?> 주문하신 상품의 주문번호는 <br /> <span class="font-bold"><?= $int_number ?></span> 입니다.</p>
    <a href="/m/mine/order/detail.php?int_number=<?= $int_number ?>" class="mt-5 flex justify-center items-center w-[178px] h-[45px] bg-white border border-solid border-[#DDDDDD]">
        <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">주문 상세보기</p>
    </a>
</div>

<!-- 구분선 -->
<hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

<!-- 주문정보 -->
<div class="mt-[15px] px-[14px]">
    <p class="font-extrabold text-lg leading-5 text-[#333333]">주문정보</p>
    <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-black">DIOR</p>
    <div class="mt-3 flex gap-[11px]">
        <div class="w-[120px] h-[120px] flex justify-center items-center bg-[#F9F9F9] p-2.5">
            <img class="w-full" src="/admincenter/files/good/<?= $product_Data['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
        </div>
        <div class="flex flex-col justify-center">
            <div class="flex justify-center items-center w-[34px] h-[18px] py-1 bg-[<?= ($product_Data['INT_TYPE'] == 1 ? '#EEAC4C' : ($product_Data['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                <p class="font-normal text-[10px] leading-[11px] text-center text-white">
                    <?= ($product_Data['INT_TYPE'] == 1 ? '구독' : ($product_Data['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?>
                </p>
            </div>
            <p class="mt-[15px] font-bold text-xs leading-[14px] text-[#666666]"><?= $product_Data['STR_GOODNAME'] ?></p>
            <?php
            switch ($product_Data['INT_TYPE']) {
                case 1:
            ?>
                    <p class="mt-2.5 font-medium text-xs leading-[14px] text-[#999999]">월정액 구독 전용</p>
                    <p class="mt-1.5 font-bold text-xs leading-[14px] text-black"><span class="text-[#EEAC4C]"><?= $product_Data['INT_DISCOUNT'] ? $product_Data['INT_DISCOUNT'] . '%' : '' ?> 무료교환</span></p>
                    <p class="mt-1.5 font-medium text-xs leading-[14px] text-[#999999]">ㄴ기간: <?= date('Y.m.d', strtotime($product_Data['STR_SDATE'])) ?> ~ <?= date('Y.m.d', strtotime($product_Data['STR_EDATE'])) ?></p>
                <?php
                    break;
                case 2:
                ?>
                    <p class="mt-2.5 font-medium text-xs leading-[14px] text-[#999999] line-through <?= $product_Data['INT_DISCOUNT'] ? '' : 'hidden' ?>">일 <?= $product_Data['INT_PRICE'] ?>원</p>
                    <p class="mt-1.5 font-bold text-xs leading-[14px] text-black"><span class="text-[#00402F]"><?= $product_Data['INT_DISCOUNT'] ? $product_Data['INT_DISCOUNT'] . '%' : '' ?> 일</span> <?= number_format($product_Data['INT_PRICE'] - $product_Data['INT_PRICE'] * $product_Data['INT_DISCOUNT'] / 100) ?>원</p>
                    <p class="mt-1.5 font-medium text-xs leading-[14px] text-[#999999]">ㄴ기간: <?= date('Y.m.d', strtotime($product_Data['STR_SDATE'])) ?> ~ <?= date('Y.m.d', strtotime($product_Data['STR_EDATE'])) ?></p>
                <?php
                    break;
                case 3:
                ?>
                    <p class="mt-2.5 font-medium text-xs leading-[14px] text-[#999999] line-through <?= $product_Data['INT_DISCOUNT'] ? '' : 'hidden' ?>"><?= $product_Data['INT_PRICE'] ?>원</p>
                    <p class="mt-1.5 font-bold text-xs leading-[14px] text-black"><span class="text-[#7E6B5A]"><?= $product_Data['INT_DISCOUNT'] ? $product_Data['INT_DISCOUNT'] . '%' : '' ?></span> <?= number_format($product_Data['INT_PRICE'] - $product_Data['INT_PRICE'] * $product_Data['INT_DISCOUNT'] / 100) ?>원</p>
            <?php
                    break;
            }
            ?>
        </div>
    </div>
</div>

<!-- 구분선 -->
<hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

<!-- 결제금액 -->
<div x-data="{ isCollapsed: false }" class="mt-[15px] flex flex-col w-full px-[14px]">
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
            <?php
            if ($product_Data['INT_TYPE'] == 1) {
            ?>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[15px] leading-[17px] text-black">주문금액</p>
                    <p class="font-bold text-[15px] leading-[17px] text-black">월정액 구독 전용</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[15px] leading-[17px] text-black">배송비</p>
                    <p class="font-bold text-[15px] leading-[17px] text-black">무료배송</p>
                </div>
            <?php
            } else {
            ?>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[15px] leading-[17px] text-black">주문금액</p>
                    <p class="font-bold text-[15px] leading-[17px] text-black"><?= number_format($product_Data['INT_PRICE']) ?>원</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[15px] leading-[17px] text-black">상품 할인금액</p>
                    <p class="font-bold text-[15px] leading-[17px] text-black"><?= number_format($product_Data['INT_PDISCOUNT'] + $product_Data['INT_MDISCOUNT']) ?>원</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[11px] leading-3 text-[#666666]">ㄴ 금액할인</p>
                    <p class="font-bold text-[11px] leading-3 text-[#666666]">-<?= number_format($product_Data['INT_PDISCOUNT']) ?>원</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[11px] leading-3 text-[#666666]">ㄴ 멤버십할인</p>
                    <p class="font-bold text-[11px] leading-3 text-[#666666]">-<?= number_format($product_Data['INT_MDISCOUNT']) ?>원</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[15px] leading-[17px] text-black">쿠폰할인</p>
                    <p class="font-bold text-[15px] leading-[17px] text-black"><?= number_format($product_Data['INT_COUPON']) ?>원</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[15px] leading-[17px] text-black">적립금사용</p>
                    <p class="font-bold text-[15px] leading-[17px] text-black"><?= number_format($product_Data['INT_MILEAGE']) ?>원</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-[15px] leading-[17px] text-black">배송비</p>
                    <p class="font-bold text-[15px] leading-[17px] text-black">무료배송</p>
                </div>
            <?php
            }
            ?>
        </div>

        <hr class="mt-[5px] w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />
        <div class="mt-[5px] flex items-center justify-between">
            <p class="font-extrabold text-[15px] leading-[17px] text-[#DA2727]">총 결제금액</p>
            <?php
            if ($product_Data['INT_TYPE'] == 1) {
            ?>
                <p class="font-extrabold text-[15px] leading-[17px] text-right text-black">월정액 별도 적용가</p>
            <?php
            } else {
            ?>
                <p class="font-extrabold text-[15px] leading-[17px] text-right text-black"><?= number_format($product_Data['INT_TPRICE']) ?>원</p>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<!-- 구분선 -->
<hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

<?php
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>