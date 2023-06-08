<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<script language="javascript" src="js/index.js"></script>

<?php
$per_page = 5;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$last_page = 0;
$start_page = 1;
$end_page = 1;

$SQL_QUERY =    'SELECT 
                    COUNT(A.INT_NUMBER)
                FROM 
                    ' . $Tname . 'comm_goods_cart A
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"';
                    
$result = mysql_query($SQL_QUERY);

if (!$result) {
    error("QUERY_ERROR");
    exit;
}

$total_record = mysql_result($result, 0, 0);
$last_page = ceil($total_record / $per_page);
$start_page = max(1, $page - 2);
$end_page = min($start_page + 4, $last_page);

$SQL_QUERY =    'SELECT 
                    A.INT_NUMBER, A.STR_SDATE, A.STR_EDATE, A.INT_STATE AS ORDER_STATE, A.DTM_INDATE AS ORDER_DATE, B.*, C.STR_CODE
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
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                ORDER BY A.DTM_INDATE DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$order_list_result = mysql_query($SQL_QUERY);

$result = '<div class="flex flex-col gap-[25px] w-full">';
while ($row = mysql_fetch_assoc($order_list_result)) {
    $str_delivery_status = '이용중';

    switch ($row['ORDER_STATE']) {
        case 1:
            $str_delivery_status = '주문접수';
            break;
        
        case 2:
            $str_delivery_status = '상품준비';
            break;

        case 3:
            $str_delivery_status = '배송중';
            break;

        case 4:
            $str_delivery_status = '이용중';
            break;

        case 5:
            $str_delivery_status = '반납';
            break;
    }

    $result .= '
        <div class="flex flex-col w-full">
            <a href="detail.php?int_number=' . $row['INT_NUMBER'] . '" class="flex justify-between items-center px-[14px] pb-3 border-b-[0.5px] border-[#E0E0E0]">
                <div class="flex gap-[5px] items-center">
                    <p class="font-bold text-[15px] leading-[17px] text-black">' . $row['INT_NUMBER'] . '</p>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">' . date('Y.m.d', strtotime($row['ORDER_DATE'])) . '</p>
                </div>
                <div class="pr-[5px]">
                    <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.511521 0 0.345622 0.0593668 0.207373 0.1781C0.0691246 0.296834 -1.19209e-07 0.435356 -1.19209e-07 0.593668C-1.19209e-07 0.751979 0.0691246 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.0783412 8.10158 0.0138248 8.23805 0.0138248 8.40016C0.0138248 8.56259 0.0829491 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.889401 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                    </svg>
                </div>
            </a>
            <div class="flex flex-col px-[14px]">
                <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-[#999999]">' . $str_delivery_status . '</p>
                <div class="mt-3 flex gap-2.5 w-full">
                    <div class="flex justify-center items-center w-[120px] h-[120px] p-2.5 bg-[#F9F9F9] rounded-[6px]">
                        <img src="/admincenter/files/good/' . $row['STR_IMAGE1'] . '" alt="product">
                    </div>
                    <div class="grow flex flex-col justify-center">
                        <div class="w-[34px] h-[18px] flex justify-center items-center bg-[' . ($row['INT_TYPE'] == 1 ? '#EEAC4C' : ($row['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A')) . ']">
                            <p class="font-normal text-[10px] leading-[11px] text-center text-white">' . ($row['INT_TYPE'] == 1 ? '구독' : ($row['INT_TYPE'] == 2 ? '렌트' : '빈티지')) . '</p>
                        </div>
                        <p class="mt-1.5 font-bold text-[15px] leading-[17px] text-black">' . $row['STR_CODE'] . '</p>
                        <p class="mt-[2px] font-bold text-xs leading-[14px] text-[#666666]">' . $row['STR_GOODNAME'] . '</p>
                        <p class="mt-[9px] font-bold text-xs leading-[14px] text-[#999999]">기간: ' . $row['STR_SDATE'] . ' ~ ' . $row['STR_EDATE'] . '</p>
                        <p class="mt-[3px] font-extrabold text-xs leading-[14px] text-black">' . number_format($row['INT_PRICE']) . '원</p>
                    </div>
                </div>
                <div class="mt-[15px] grid grid-cols-2 gap-[5px]">
                    <div class="w-full h-[35px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                        <p class="font-bold text-[11px] leading-[12px] text-center text-[#666666]">배송 조회</p>
                    </div>
                    <a href="/m/mine/question/create.php?str_cart=' . $row['INT_NUMBER'] . '" class="w-full h-[35px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                        <p class="font-bold text-[11px] leading-[12px] text-center text-[#666666]">1:1 문의</p>
                    </a>
                    <div class="w-full h-[35px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                        <p class="font-bold text-[11px] leading-[12px] text-center text-[#666666]">기간 연장</p>
                    </div>
                    <div class="w-full h-[35px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                        <p class="font-bold text-[11px] leading-[12px] text-center text-[#666666]">취소 신청</p>
                    </div>
                </div>
            </div>
        </div>';
}
$result .= '</div>';

// Pagination
$result .= '
    <div class="mt-[30px] flex gap-[23px] justify-center items-center">
        <button type="button" onclick="searchOrder(' . (($page - 1) < 0 ? '0' : $page - 1) . ')">
            <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z" fill="black" />
            </svg>
        </button>
        <div class="flex gap-[9.6px] items-center">';
for ($i = $start_page; $i <= $end_page; $i++) {
    $result .=
        '<button type="button" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] ' . ($i == $page ? 'bg-black' : 'bg-white') . '" onclick="searchOrder(' . $i . ')">
            <p class="font-bold text-xs leading-[14px] text-center ' . ($i == $page ? 'text-white' : 'text-black') . '">' . $i . '</p>
        </button>';
}
$result .= '
        </div>
        <button type="button" onclick="searchOrder(' . (($page + 1) > $last_page ? $last_page : $page + 1) . ')">
            <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.280895 15.6874L1.19642 16.4055L7.31785 8.59663L1.21437 0.787764L0.280895 1.46992L5.88173 8.59663L0.280895 15.6874Z" fill="black" />
            </svg>
        </button>
    </div>';

echo $result;

?>