<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
$int_number = Fnc_Om_Conv_Default($_REQUEST['int_number'], '');

$SQL_QUERY =    'SELECT
                    A.*, B.INT_TYPE, B.STR_IMAGE1, B.STR_GOODNAME, B.INT_PRICE AS PRODUCT_PRICE, B.INT_DISCOUNT, C.STR_CODE, D.STR_NAME AS USER_NAME
                FROM 
                    ' . $Tname . 'comm_goods_cart A
                LEFT JOIN
                    ' . $Tname . 'comm_goods_master B
                ON
                    A.STR_GOODCODE=B.STR_GOODCODE
                LEFT JOIN
                    ' . $Tname . 'comm_com_code C
                ON
                    B.INT_BRAND=C.INT_NUMBER
                LEFT JOIN
                    ' . $Tname . 'comm_member D
                ON
                    A.STR_USERID=D.STR_USERID
                WHERE 
                    A.INT_NUMBER=' . $int_number;

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

$current_state = '접수중';

switch ($arr_Data['ORDER_STATE']) {
    case 1:
        $current_state = '주문접수';
        break;

    case 2:
        $current_state = '상품준비';
        break;

    case 3:
        $current_state = '배송중';
        break;

    case 4:
        $current_state = '이용중';
        break;

    case 5:
        $current_state = '반납';
        break;
}
?>

<div class="mt-[30px] flex flex-col items-center w-full">
    <p class="font-extrabold text-lg leading-5 text-black">주문 내역 상세</p>

    <div class="mt-[22px] flex flex-col gap-[35px] w-full">
        <!-- 주문상품 -->
        <div class="flex flex-col w-full">
            <p class="font-bold text-[15px] leading-[17px] text-black px-[14px]">주문상품</p>
            <hr class="mt-3 border-t border-[#E0E0E0]" />
            <div class="mt-3 flex flex-row gap-[11px] w-full px-[14px]">
                <div class="w-[120px] h-[120px] flex justify-center items-center p-2 bg-[#F9F9F9]">
                    <img class="w-full" src="/admincenter/files/good/<?= $arr_Data['STR_IMAGE1'] ?>" alt="">
                </div>
                <div class="flex-1 flex flex-col justify-center w-full">
                    <div class="flex justify-center items-center w-[34px] h-[18px] bg-[<?= ($arr_Data['INT_TYPE'] == 1 ? '#EEAC4C' : ($arr_Data['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A')) ?>]">
                        <p class="font-normal text-[10px] leading-[11px] text-center text-white"><?= ($arr_Data['INT_TYPE'] == 1 ? '구독' : ($arr_Data['INT_TYPE'] == 2 ? '렌트' : '빈티지')) ?></p>
                    </div>
                    <p class="mt-1.5 font-bold text-[15px] leading-[17px] text-black"><?= $arr_Data['STR_CODE'] ?></p>
                    <p class="mt-0.5 font-bold text-xs leading-[14px] text-[#666666]"><?= $arr_Data['STR_GOODNAME'] ?></p>
                    <?php
                    switch ($arr_Data['INT_TYPE']) {
                        case 1:
                    ?>
                            <p class="mt-[9px] font-medium text-xs leading-[14px] text-[#999999]">기간: <?= date('Y.m.d', strtotime($arr_Data['STR_SDATE'])) ?> ~</p>
                            <p class="mt-[3px] font-medium text-xs leading-[14px] text-[#999999]">반납: <?= date('Y.m.d', strtotime($arr_Data['STR_EDATE'])) ?></p>
                            <p class="mt-[3px] font-extrabold text-xs leading-[14px] text-black">프리미엄 구독권 사용</p>
                        <?php
                            break;
                        case 2:
                        ?>
                            <p class="mt-[9px] font-medium text-xs leading-[14px] text-[#999999]">기간: <?= date('Y.m.d', strtotime($arr_Data['STR_SDATE'])) ?> ~ <?= date('Y.m.d', strtotime($arr_Data['STR_EDATE'])) ?></p>
                            <p class="mt-[3px] font-extrabold text-xs leading-[14px] text-black"><?= number_format($arr_Data['PRODUCT_PRICE']) ?>원</p>
                        <?php
                            break;
                        case 3:
                        ?>
                            <p class="mt-[9px] font-medium text-xs leading-[14px] text-[#999999]">등급: UNUSED</p>
                            <p class="mt-[3px] font-extrabold text-xs leading-[14px] text-black"><?= number_format($arr_Data['PRODUCT_PRICE']) ?>원</p>
                    <?php
                            break;
                    }
                    ?>

                </div>
            </div>
            <div class="mt-2.5 flex gap-[26px] items-center px-[14px]">
                <p class="font-bold text-xs leading-[14px] text-[#999999]"><?= $current_state ?></p>
                <p class="font-bold text-xs leading-[14px] text-black underline">
                    <?php
                    if ($arr_Data['ORDER_STATE'] == 1) {
                        echo '우체국택배';
                    } else if ($arr_Data['ORDER_STATE'] == 2 || $arr_Data['ORDER_STATE'] == 3 || $arr_Data['ORDER_STATE'] == 4 || $arr_Data['ORDER_STATE'] == 5) {
                        echo '우체국택배(' . $arr_Data['INT_NUMBER'] . ')';
                    }
                    ?>
                </p>
            </div>
            <div class="mt-[15px] grid grid-cols-2 gap-[5px] px-[14px]">
                <div class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                    <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">배송 조회</p>
                </div>
                <a href="/m/mine/question/create.php?int_cart=<?= $arr_Data['INT_NUMBER'] ?>" class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                    <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">1:1 문의</p>
                </a>
                <a href="/m/mine/order/extension.php?int_number=<?= $arr_Data['INT_NUMBER'] ?>" class="col-span-2 w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                    <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">기간 연장</p>
                </a>
            </div>
        </div>
        <!-- 주문정보 -->
        <div class="flex flex-col w-full">
            <p class="font-bold text-[15px] leading-[17px] text-black px-[14px]">주문정보</p>
            <hr class="mt-3 border-t border-[#E0E0E0]" />
            <div class="flex flex-col w-full px-[14px]">
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">주문번호</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]"><?= $arr_Data['INT_NUMBER'] ?></p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">주문일자</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]"><?= date('Y. m. d', strtotime($arr_Data['ORDER_DATE'])) ?></p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">주문자</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]"><?= $arr_Data['USER_NAME'] ?></p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">주문처리상태</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]">
                        <?php
                        switch ($arr_Data['ORDER_STATE']) {
                            case 1:
                                echo '접수중';
                                break;
                            case 2:
                                echo '관리자확인';
                                break;
                            case 3:
                                echo '발송';
                                break;
                            case 4:
                                echo '배송완료';
                                break;
                            case 5:
                                echo '반납접수';
                                break;
                            case 6:
                                echo '이용중';
                                break;
                            case 10:
                                echo '반납완료';
                                break;
                            case 11:
                                echo '취소';
                                break;
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- 결제정보 -->
        <div class="flex flex-col w-full">
            <p class="font-bold text-[15px] leading-[17px] text-black px-[14px]">결제정보</p>
            <hr class="mt-3 border-t border-[#E0E0E0]" />
            <div class="flex flex-col w-full px-[14px]">
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">결제수단</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]">ABLANC PAY(자동결제)</p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">상품금액</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]"><?= number_format($arr_Data['INT_PRICE']) ?>원</p>
                </div>
                <div class="flex flex-col gap-2.5 w-full py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <div class="flex items-center justify-between">
                        <p class="font-medium text-xs leading-[14px] text-[#666666]">상품할인금액</p>
                        <p class="font-medium text-xs leading-[14px] text-[#000000]"><?= number_format($arr_Data['INT_PDISCOUNT'] + $arr_Data['INT_MDISCOUNT']) ?>원</p>
                    </div>
                    <div class="flex flex-col gap-2.5 w-full">
                        <div class="flex items-center justify-between">
                            <p class="font-medium text-[11px] leading-3 text-[#666666]">ㄴ 금액할인</p>
                            <p class="font-medium text-[11px] leading-3 text-[#000000]">-<?= number_format($arr_Data['INT_PDISCOUNT']) ?>원</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="font-medium text-[11px] leading-3 text-[#666666]">ㄴ 멤버십할인</p>
                            <p class="font-medium text-[11px] leading-3 text-[#000000]">-<?= number_format($arr_Data['INT_MDISCOUNT']) ?>원</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="font-medium text-xs leading-[14px] text-[#666666]">쿠폰할인</p>
                        <p class="font-medium text-xs leading-[14px] text-[#000000]">-<?= number_format($arr_Data['INT_COUPON']) ?>원</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="font-medium text-xs leading-[14px] text-[#666666]">적립금사용</p>
                        <p class="font-medium text-xs leading-[14px] text-[#000000]">-<?= number_format($arr_Data['INT_SAVED']) ?>원</p>
                    </div>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#DA2727]">총 결제금액</p>
                    <p class="font-bold text-[15px] leading-[17px] text-[#000000]"><?= number_format($arr_Data['INT_TPRICE']) ?>원</p>
                </div>
            </div>
        </div>
        <!-- 배송정보 -->
        <div class="flex flex-col w-full">
            <p class="font-bold text-[15px] leading-[17px] text-black px-[14px]">배송정보</p>
            <hr class="mt-3 border-t border-[#E0E0E0]" />
            <div class="flex flex-col w-full px-[14px]">
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">받는 분</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]"><?= $arr_Data['STR_NAME'] ?></p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">핸드폰번호</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]"><?= $arr_Data['STR_HP'] ?></p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">전화번호</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]"><?= $arr_Data['STR_TELEP'] ?></p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">주소</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]">(<?= $arr_Data['STR_POST'] ?>) <?= $arr_Data['STR_ADDR1'] ?> <?= $arr_Data['STR_ADDR2'] ?></p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">배송메세지</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]"><?= $arr_Data['STR_MEMO'] ?></p>
                </div>
            </div>
        </div>

        <!-- 주문목록 보기 -->
        <div class="flex px-[14px]">
            <a href="/m/mine/order/index.php" class="w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                <p class="font-bold text-xs leading-[14px] text-[#666666]">주문목록 보기</p>
            </a>
        </div>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>