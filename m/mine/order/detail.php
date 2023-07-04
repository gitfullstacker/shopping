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
                    A.*, B.INT_TYPE, B.STR_IMAGE1, B.STR_GOODNAME, B.INT_PRICE AS PRODUCT_PRICE, B.INT_DISCOUNT, C.STR_CODE, D.STR_NAME AS USER_NAME, (SELECT IFNULL(COUNT(E.BD_SEQ), 0) FROM `' . $Tname . 'b_bd_data@01` E WHERE E.INT_CART = A.INT_NUMBER) AS BD_COUNT
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
                    A.INT_STATE IN (1, 2, 3, 4, 5, 6, 10)
                    AND A.INT_NUMBER="' . $int_number . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

$current_state = '취소됨';

switch ($arr_Data['INT_STATE']) {
    case 1:
        $current_state = '주문접수';
        break;
    case 2:
        $current_state = '상품준비중';
        break;
    case 3:
        $current_state = '배송중';
        break;
    case 4:
        if ($arr_Data['INT_TYPE'] == 3) {
            $current_state = '배송완료';
        } else {
            $current_state = '이용중';
        }
        break;
    case 5:
        $current_state = '반납중';
        break;
    case 10:
        $current_state = '반납완료';
        break;
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
                            <p class="mt-[3px] font-medium text-xs leading-[14px] text-[#999999]">반납: <?= date('Y.m.d', strtotime($arr_Data['STR_EDATE'] . ' +1 day')) ?></p>
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
                    if ($arr_Data['INT_STATE'] == 1) {
                        echo '우체국택배';
                    } else if ($arr_Data['INT_STATE'] == 2 || $arr_Data['INT_STATE'] == 3 || $arr_Data['INT_STATE'] == 4 || $arr_Data['INT_STATE'] == 5) {
                        echo '우체국택배(' . $arr_Data['INT_NUMBER'] . ')';
                    }
                    ?>
                </p>
            </div>
            <div class="mt-[15px] grid grid-cols-2 gap-[5px] px-[14px]">
                <?php
                switch ($arr_Data['INT_STATE']) {
                    case 1:
                        // 주문접수
                ?>
                        <a href="/m/mine/question/create.php?int_cart=<?= $arr_Data['INT_NUMBER'] ?>" class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">1:1 문의</p>
                        </a>
                        <button class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]" onclick="cancelOrder()">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">취소 신청</p>
                        </button>
                    <?php
                        break;
                    case 2:
                        // 상품준비중
                    ?>
                        <a href="/m/mine/question/create.php?int_cart=<?= $arr_Data['INT_NUMBER'] ?>" class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px] col-span-2">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">1:1 문의</p>
                        </a>
                    <?php
                        break;
                    case 3:
                        // 배송중
                    ?>
                        <div class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]" onclick="openDeliveryDialog()">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">배송 조회</p>
                        </div>
                        <a href="/m/mine/question/create.php?int_cart=<?= $arr_Data['INT_NUMBER'] ?>" class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">1:1 문의</p>
                        </a>
                    <?php
                        break;
                    case 4:
                        // 이용중
                    ?>
                        <?php
                        if ($arr_Data['INT_TYPE'] == 1) {
                        ?>
                            <div class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]" onclick="openDeliveryDialog()">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">배송 조회</p>
                            </div>
                            <button class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]" onclick="returnOrder()">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">반납 신청</p>
                            </button>
                            <a href="/m/mine/question/create.php?int_cart=<?= $arr_Data['INT_NUMBER'] ?>" class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px] col-span-2">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">1:1 문의</p>
                            </a>
                        <?php
                        } else if ($arr_Data['INT_TYPE'] == 2) {
                        ?>
                            <div class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]" onclick="openDeliveryDialog()">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">배송 조회</p>
                            </div>
                            <a href="/m/mine/question/create.php?int_cart=<?= $arr_Data['INT_NUMBER'] ?>" class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">1:1 문의</p>
                            </a>
                        <?php
                        } else if ($arr_Data['INT_TYPE'] == 3) {
                        ?>
                            <div class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]" onclick="openDeliveryDialog()">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">배송 조회</p>
                            </div>
                            <a href="/m/mine/question/create.php?int_cart=<?= $arr_Data['INT_NUMBER'] ?>" class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">1:1 문의</p>
                            </a>
                        <?php
                        }
                        ?>
                    <?php
                        break;
                    case 5:
                        // 반납중
                    ?>
                        <a href="/m/mine/question/create.php?int_cart=<?= $arr_Data['INT_NUMBER'] ?>" class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px] col-span-2">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">1:1 문의</p>
                        </a>
                    <?php
                        break;
                    case 10:
                        // 반납완료
                    ?>
                        <a href="/m/product/detail.php?str_goodcode=<?= $arr_Data['STR_GOODCODE'] ?>" class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px] <?= ($arr_Data['BD_COUNT'] == 0 && (time() <= strtotime('+1 week', strtotime($arr_Data['DTM_EDIT_DATE'])))) ? '' : 'col-span-2' ?>">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">재이용 하기</p>
                        </a>
                        <?php
                        if ($arr_Data['BD_COUNT'] == 0 && (time() <= strtotime('+1 week', strtotime($arr_Data['DTM_EDIT_DATE'])))) {
                        ?>
                            <a href="/m/mine/review/create.php?int_cart=<?= $arr_Data['INT_NUMBER'] ?>" class="w-full h-10 flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px] relative">
                                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">리뷰 작성</p>
                                <div class="absolute -top-[10px] right-0 flex justify-center items-center w-[64px] h-5 bg-[#DDDDDD] rounded-tl-[10px] rounded-tr-[10px] rounded-br-[10px] rounded-bl-none">
                                    <p class="font-bold text-[10px] leading-[11px] text-black">적립금 지급!</p>
                                </div>
                            </a>
                        <?php
                        }
                        ?>
                <?php
                        break;
                }
                ?>
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
                    <p class="font-medium text-xs leading-[14px] text-[#000000]"><?= date('Y. m. d', strtotime($arr_Data['DTM_INDATE'])) ?></p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">주문자</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]"><?= $arr_Data['USER_NAME'] ?></p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">주문처리상태</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000]">
                        <?php
                        switch ($arr_Data['INT_STATE']) {
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
        <?php
        if ($arr_Data['INT_TYPE'] != 1) {
        ?>
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
                            <p class="font-medium text-xs leading-[14px] text-[#000000]">-<?= number_format($arr_Data['INT_CDISCOUNT']) ?>원</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="font-medium text-xs leading-[14px] text-[#666666]">적립금사용</p>
                            <p class="font-medium text-xs leading-[14px] text-[#000000]">-<?= number_format($arr_Data['INT_MILEAGE']) ?>원</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                        <p class="font-medium text-xs leading-[14px] text-[#DA2727]">총 결제금액</p>
                        <p class="font-bold text-[15px] leading-[17px] text-[#000000]"><?= number_format($arr_Data['INT_TPRICE']) ?>원</p>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

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
                    <p class="font-medium text-xs leading-[14px] text-[#000000] max-w-[280px]">(<?= $arr_Data['STR_POST'] ?>) <?= $arr_Data['STR_ADDR1'] ?> <?= $arr_Data['STR_ADDR2'] ?></p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">배송메세지</p>
                    <p class="font-medium text-xs leading-[14px] text-[#000000] max-w-[280px]"><?= $arr_Data['STR_MEMO'] ?></p>
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

<div id="cancel_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden" style="height: calc(100vh - 66px);">
    <div class="mt-[60%] flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
        <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('cancel_dialog').classList.add('hidden');">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <p class="font-bold text-[15px] leading-[17px] text-black">취소 신청이 완료되었습니다.</p>
        <a href="/m/product/index.php" id="cancel_dialog_btn" class="flex flex-row gap-[12.3px] items-center justify-center px-5 py-2.5 bg-white border-[0.84px] border-solid border-[#D9D9D9]">
            <p class="font-bold text-[10px] leading-[11px] text-[#666666]">다른 가방 렌트하기</p>
            <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.52603 9.0481L5.45631 4.95636C5.50296 4.90765 5.53592 4.85488 5.55521 4.79805C5.5748 4.74122 5.58459 4.68033 5.58459 4.61538C5.58459 4.55044 5.5748 4.48955 5.55521 4.43272C5.53592 4.37589 5.50296 4.32312 5.45631 4.27441L1.52603 0.170489C1.41718 0.0568296 1.28112 0 1.11785 0C0.95457 0 0.814619 0.060889 0.697994 0.182667C0.581368 0.304445 0.523056 0.446519 0.523056 0.60889C0.523056 0.77126 0.581368 0.913335 0.697994 1.03511L4.12678 4.61538L0.697994 8.19566C0.589143 8.30932 0.534719 8.44928 0.534719 8.61555C0.534719 8.78214 0.593031 8.92632 0.709656 9.0481C0.826282 9.16988 0.962345 9.23077 1.11785 9.23077C1.27335 9.23077 1.40941 9.16988 1.52603 9.0481Z" fill="#666666" />
            </svg>
        </a>
    </div>
</div>

<div id="return_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden" style="height: calc(100vh - 66px);">
    <div class="mt-[60%] flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
        <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('return_dialog').classList.add('hidden');">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <p class="font-bold text-[15px] leading-[17px] text-black">반납 날짜를 선택해주세요.</p>
        <div x-data="{
                selectedValue: '',
                showSelectPanel: false,
                selectItem(value) {
                    this.selectedValue = value;
                    this.showSelectPanel = false;
                    doReturnOrder(value);
                }
            }" class="w-[144px] h-[30px] flex justify-center items-center bg-white border-[0.72px] border-solid border-[#DDDDDD] relative">
            <div class="flex gap-[18px] items-center cursor-pointer" x-on:click="showSelectPanel = true" x-on:click.outside="showSelectPanel = false">
                <p value="font-bold text-[10px] leading-3 text-[#666666]" x-text="selectedValue == '' ? '반납 날짜' : selectedValue">반납 날짜</p>
                <svg class="absolute top-3 right-[25px]" width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7228 1.67005L5.87374 5.86313C5.81602 5.9129 5.75348 5.94807 5.68613 5.96865C5.61878 5.98955 5.54662 6 5.46965 6C5.39268 6 5.32053 5.98955 5.25318 5.96865C5.18583 5.94807 5.12329 5.9129 5.06556 5.86313L0.202045 1.67005C0.0673482 1.55392 -2.23606e-07 1.40876 -2.3209e-07 1.23456C-2.40574e-07 1.06037 0.0721588 0.91106 0.216477 0.786636C0.360795 0.662212 0.529166 0.6 0.72159 0.6C0.914014 0.6 1.08239 0.662212 1.2267 0.786636L5.46965 4.4447L9.71261 0.786635C9.8473 0.670507 10.0132 0.612442 10.2102 0.612442C10.4076 0.612442 10.5785 0.674654 10.7228 0.799078C10.8672 0.923502 10.9393 1.06866 10.9393 1.23456C10.9393 1.40046 10.8672 1.54562 10.7228 1.67005Z" fill="#333333" />
                </svg>
            </div>
            <div id="return_dates" x-show="showSelectPanel" class="absolute top-[30px] left-0 flex flex-col w-full bg-white border-[0.72px] border-solid border-[#DDDDDD]">
            </div>
        </div>
    </div>
</div>

<div id="return_result_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden" style="height: calc(100vh - 66px);">
    <div class="mt-[60%] flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
        <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('return_result_dialog').classList.add('hidden');document.location.href = 'index.php';">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <p class="font-bold text-[15px] leading-[17px] text-black">반납 신청이 완료되었습니다.</p>
        <a href="index.php" class="flex flex-row gap-[12.3px] items-center justify-center px-5 py-2.5 bg-white border-[0.84px] border-solid border-[#D9D9D9]">
            <p class="font-bold text-[10px] leading-[11px] text-[#666666]">확인</p>
        </a>
    </div>
</div>

<div id="show_delivery_dialog" class="w-full h-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden">
    <div class="mt-[30%] flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
        <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('show_delivery_dialog').classList.add('hidden');">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <iframe id="delivery_frame" src="" frameborder="0"></iframe>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    function cancelOrder() {
        url = "order_proc.php";
        url += "?RetrieveFlag=CANCELORDER";
        url += "&int_cart=<?= $int_number ?>";

        $.ajax({
            url: url,
            success: function(result) {
                document.getElementById('cancel_dialog').classList.remove('hidden');
                searchOrder(current_page);

                switch (<?= $int_type ?: 1 ?>) {
                    case 1:
                        $('#cancel_dialog_btn').attr('href', '/m/product/index.php?product_type=1');
                        $('#cancel_dialog_btn p').html('다른 가방 구독하기');
                        break;
                    case 2:
                        $('#cancel_dialog_btn').attr('href', '/m/product/index.php?product_type=2');
                        $('#cancel_dialog_btn p').html('다른 가방 렌트하기');
                        break;
                    case 3:
                        $('#cancel_dialog_btn').attr('href', '/m/product/index.php?product_type=3');
                        $('#cancel_dialog_btn p').html('다른 가방 구매하기');
                        break;
                }
            }
        });
    }

    function returnOrder() {
        document.getElementById('return_dialog').classList.remove('hidden');

        var selectElement = document.getElementById("return_dates");

        var temp_date = new Date();
        var start_date = null;
        var end_date = null;

        if (new Date().getHours() < 17) {
            temp_date.setDate(temp_date.getDate() + 1);
        } else {
            temp_date.setDate(temp_date.getDate() + 2);
        }

        // 불가일 검사
        const endDDays = <?= str_replace('"', '\'', json_encode($end_days_array)) ?>;
        const endDWeeks = <?= str_replace('"', '\'', json_encode($end_weeks_array)) ?>;
        const endDDates = <?= str_replace('"', '\'', json_encode($end_dates_array)) ?>;

        do {
            var setted = true;
            const dateString = temp_date.getFullYear().toString() + '-' + (temp_date.getMonth() + 1).toString().padStart(2, '0') + '-' + temp_date.getDate().toString().padStart(2, '0');

            if (endDDays.includes(temp_date.getDate().toString())) {
                setted = false;
            } else if (endDWeeks.includes(temp_date.getDay().toString())) {
                setted = false;
            } else if (endDDates.includes(dateString)) {
                setted = false;
            }

            if (setted) {
                if (start_date == null) {
                    start_date = new Date(temp_date);
                } else {
                    end_date = new Date(temp_date);
                }
            }

            temp_date.setDate(temp_date.getDate() + 1);
        } while (start_date == null || end_date == null);

        while (selectElement.firstChild) {
            selectElement.removeChild(selectElement.firstChild);
        }

        var dateRange = getDateRange(start_date, end_date);

        for (var i = 0; i < dateRange.length; i++) {
            var button = document.createElement("button");
            button.className = "py-[17px] flex justify-center items-center hover:bg-gray-100";
            button.setAttribute("x-on:click", "selectItem('" + dateRange[i] + "')");

            var p = document.createElement("p");
            p.className = "font-bold text-[10px] leading-3 text-[#666666]";
            p.textContent = dateRange[i];

            button.appendChild(p);
            selectElement.appendChild(button);
        }
    }

    function doReturnOrder(d_date) {
        url = "order_proc.php";
        url += "?RetrieveFlag=RETURNORDER";
        url += "&int_cart=<?= $int_number ?>";
        url += "&d_date=" + d_date;

        $.ajax({
            url: url,
            success: function(result) {
                document.getElementById('return_dialog').classList.add('hidden');
                document.getElementById('return_result_dialog').classList.remove('hidden');
            }
        });
    }

    function getDateRange(startDate, endDate) {
        var dateArray = [];
        var currentDate = startDate;

        while (currentDate <= endDate) {
            dateArray.push(currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1).toString().padStart(2, '0') + '-' + currentDate.getDate().toString().padStart(2, '0'));
            currentDate.setDate(currentDate.getDate() + 1);
        }

        return dateArray;
    }

    function openDeliveryDialog() {
        // Create the iframe element
        var iframe = document.getElementById('delivery_frame');

        // Set the iframe properties
        iframe.src = 'https://m.epost.go.kr/postal/mobile/mobile.trace.RetrieveDomRigiTraceList.comm?sid1=<?= $arr_Data['STR_DELICODE'] ?>'; // Replace with your desired URL
        iframe.style.width = '300px'; // Set the width of the iframe
        iframe.style.height = '500px'; // Set the height of the iframe
        iframe.style.border = 'none'; // Remove iframe border

        document.getElementById('show_delivery_dialog').classList.remove('hidden');
    }
</script>