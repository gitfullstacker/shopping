<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$per_page = 5;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$last_page = 0;
$start_page = 1;
$end_page = 1;

$SQL_QUERY = 'SELECT 
                    COUNT(A.INT_NUMBER)
                FROM 
                    ' . $Tname . 'comm_goods_cart A
                LEFT JOIN
                    ' . $Tname . 'comm_review D
                ON
                    A.INT_NUMBER=D.STR_CART
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                AND 
                    A.INT_STATE IN ("4","5","10")
                AND
                    D.INT_NUMBER IS NULL';

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
                    A.*, B.STR_GOODNAME, B.STR_IMAGE1, B.INT_TYPE, C.STR_CODE 
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
                    ' . $Tname . 'comm_review D
                ON
                    A.INT_NUMBER=D.STR_CART
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                AND 
                    A.INT_STATE IN ("4","5","10")
                AND
                    D.INT_NUMBER IS NULL
                ORDER BY A.DTM_INDATE DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$arr_Data = mysql_query($SQL_QUERY);
$arr_Data_Cnt = mysql_num_rows($arr_Data);

$result = '<div class="flex flex-col gap-[15px] w-full border-t-[0.5px] border-[#E0E0E0] pt-[15px]">';
for ($int_J = 0; $int_J < $arr_Data_Cnt; $int_J++) {
    $result .= '
        <div class="flex flex-col gap-[15px] w-full border-b-[0.5px] border-[#E0E0E0] pb-[21px]">
            <p class="font-bold text-[13px] leading-[15px] text-[#999999]">구매확정일 ' . substr(mysql_result($arr_Data, $int_J, 'DTM_INDATE'), 0, 10) . '</p>
            <div class="flex gap-[11px]">
                <div class="flex justify-center items-center w-[120px] h-[120px] bg-[#F9F9F9] p-2.5">
                    <img src="/admincenter/files/good/' . mysql_result($arr_Data, $int_J, 'STR_IMAGE1') . '" alt="">
                </div>
                <div class="grow flex flex-col justify-center">
                    <div class="w-[34px] h-[18px] flex justify-center items-center bg-[' . (mysql_result($arr_Data, $int_J, 'INT_TYPE') == 1 ? '#EEAC4C' : (mysql_result($arr_Data, $int_J, 'INT_TYPE') == 2 ? '#00402F' : '#7E6B5A')) . ']">
                        <p class="font-normal text-[10px] leading-[11px] text-center text-white">' . (mysql_result($arr_Data, $int_J, 'INT_TYPE') == 1 ? '구독' : (mysql_result($arr_Data, $int_J, 'INT_TYPE') == 2 ? '렌트' : '빈티지')) . '</p>
                    </div>
                    <p class="mt-1.5 font-bold text-[15px] leading-[17px] text-black">' . mysql_result($arr_Data, $int_J, 'STR_CODE') . '</p>
                    <p class="mt-[2px] font-bold text-xs leading-[14px] text-[#666666]">' . mysql_result($arr_Data, $int_J, 'STR_GOODNAME') . '</p>
                    <p class="mt-[9px] font-bold text-xs leading-[14px] text-[#999999]">기간: 2023.02.10 ~ 2023.02.13</p>
                </div>
            </div>
            <div class="mt-[14px] flex gap-[35px] items-center w-full">
                <div class="flex flex-col gap-[5px]">
                    <p class="font-bold text-xs leading-[14px] text-black">적립가능한 마일리지: 1,000</p>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">작성기한 D-20(2023.04.10)</p>
                </div>
                <a href="create.php?int_cart=' . mysql_result($arr_Data, $int_J, 'INT_NUMBER') . '" class="grow flex justify-center items-center h-[35px] bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                    <p class="font-bold text-[11px] leading-[12px] text-black">리뷰 작성</p>
                </a>
            </div>
        </div>';
}
$result .= '</div>';

// Pagination
$result .= '
    <div class="mt-[30px] flex gap-[23px] justify-center items-center">
        <button type="button" onclick="searchCart(' . (($page - 1) < 0 ? '0' : $page - 1) . ')">
            <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z" fill="black" />
            </svg>
        </button>
        <div class="flex gap-[9.6px] items-center">';
for ($i = $start_page; $i <= $end_page; $i++) {
    $result .=
        '<button type="button" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] ' . ($i == $page ? 'bg-black' : 'bg-white') . '" onclick="searchCart(' . $i . ')">
            <p class="font-bold text-xs leading-[14px] text-center ' . ($i == $page ? 'text-white' : 'text-black') . '">' . $i . '</p>
        </button>';
}
$result .= '
        </div>
        <button type="button" onclick="searchCart(' . (($page + 1) > $last_page ? $last_page : $page + 1) . ')">
            <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.280895 15.6874L1.19642 16.4055L7.31785 8.59663L1.21437 0.787764L0.280895 1.46992L5.88173 8.59663L0.280895 15.6874Z" fill="black" />
            </svg>
        </button>
    </div>';

echo $result;

?>