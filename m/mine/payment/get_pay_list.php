<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>

<?php
$per_page = 6;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$last_page = 0;
$start_page = 1;
$end_page = 1;

$filter_period = $_GET['filter_period'];
$int_card = $_GET['int_card'];

$FILTER_QUERY = 'AND A.INT_SNUMBER IS NOT NULL ';
if ($filter_period) {
    $FILTER_QUERY = 'AND A.DTM_INDATE >= DATE_SUB(NOW(), INTERVAL ' . $filter_period . ' MONTH) ';
}

$SQL_QUERY = 'SELECT 
                    COUNT(A.INT_SNUMBER)
                FROM 
                    `' . $Tname . 'comm_member_pay_info` A
                LEFT JOIN
                    `' . $Tname . 'comm_member_pay` B
                ON
                    A.INT_NUMBER=B.INT_NUMBER
                WHERE 
                    B.STR_USERID="' . $arr_Auth[0] . '"
                    ' . $FILTER_QUERY;

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
                    A.*
                FROM 
                    `' . $Tname . 'comm_member_pay_info` A
                LEFT JOIN
                    `' . $Tname . 'comm_member_pay` B
                ON
                    A.INT_NUMBER=B.INT_NUMBER
                WHERE 
                    B.STR_USERID="' . $arr_Auth[0] . '"
                    ' . $FILTER_QUERY . '
                ORDER BY A.DTM_INDATE DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$pay_list_result = mysql_query($SQL_QUERY);

$result = '<div class="flex flex-col w-full divide-y">';
while ($row = mysql_fetch_assoc($pay_list_result)) {
    $result .= '
        <div class="flex flex-row w-full justify-between py-[15px]">
            <div class="flex flex-col">
                <p class="font-normal text-[10px] leading-[11px] text-[#999999]">' . date('Y.m.d', strtotime($row['DTM_INDATE'])) . '</p>
                <p class="mt-1.5 font-bold text-xs leading-[14px] text-[#666666]">결제완료</p>
                <p class="mt-[5px] font-bold text-xs leading-[14px] text-[#999999]">주문번호: ' . $row['STR_ORDERIDX'] . '</p>
            </div>
            <div class="flex flex-col justify-end">
                <p class="font-bold text-xs leading-[14px] text-black">' . number_format($row['INT_SPRICE']) . '원</p>
            </div>
        </div>';
}
$result .= '</div>';

// Pagination
if ($end_page) {
    $result .= '
        <div class="pt-[30px] flex gap-[23px] justify-center items-center border-t-[0.5px] border-[#E0E0E0]">
            <button type="button" onclick="searchPay(' . (($page - 1) < 0 ? '0' : $page - 1) . ')">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z" fill="black" />
                </svg>
            </button>
            <div class="flex gap-[9.6px] items-center">';
    for ($i = $start_page; $i <= $end_page; $i++) {
        $result .= '
            <button type="button" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] ' . ($i == $page ? 'bg-black' : 'bg-white') . '" onclick="searchPay(' . $i . ')">
                <p class="font-bold text-xs leading-[14px] text-center ' . ($i == $page ? 'text-white' : 'text-black') . '">' . $i . '</p>
            </button>';
    }
    $result .= '
            </div>
            <button type="button" onclick="searchPay(' . (($page + 1) > $last_page ? $last_page : $page + 1) . ')">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.280895 15.6874L1.19642 16.4055L7.31785 8.59663L1.21437 0.787764L0.280895 1.46992L5.88173 8.59663L0.280895 15.6874Z" fill="black" />
                </svg>
            </button>
        </div>';
}

echo $result;

?>