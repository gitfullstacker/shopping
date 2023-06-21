<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$period = Fnc_Om_Conv_Default($_REQUEST['period'], "3");

$per_page = 5;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$last_page = 0;
$start_page = 1;
$end_page = 1;

$SQL_QUERY = 'SELECT 
                    COUNT(A.INT_NUMBER)
                FROM 
                    ' . $Tname . 'comm_mileage_history A
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.DTM_INDATE >= DATE_SUB(CURDATE(), INTERVAL ' . $period . ' MONTH)';

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
                    ' . $Tname . 'comm_mileage_history A
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.DTM_INDATE >= DATE_SUB(CURDATE(), INTERVAL ' . $period . ' MONTH)
                ORDER BY A.DTM_INDATE DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$reserve_list_result = mysql_query($SQL_QUERY);

if ($end_page > 0) {
    $result = '<div class="flex flex-col gap-[15px] w-full">';
    while ($row = mysql_fetch_assoc($reserve_list_result)) {
        $result .= '
            <div class="flex justify-between items-center pb-[15px] border-b-[0.5px] border-[#E0E0E0]">
                <div class="flex flex-col w-full">
                    <p class="font-normal text-[10px] leading-[11px] text-[#999999]">' . date('Y.m.d', strtotime($row['DTM_INDATE'])) . '</p>
                    <p class="mt-1.5 font-bold text-xs leading-14px text-[#666666]">' . ($row['STR_INCOME'] == 'Y' ? '주문 적립' : '주문 시 사용') . '</p>
                    <p class="mt-[5px] font-bold text-xs leading-[14px] text-[#999999]">주문번호: ' . ($row['STR_INCOME'] == 'Y' ? $row['INT_CART'] : $row['STR_ORDERIDX']) . '</p>
                </div>
                <p class="font-bold text-xs leading-[14px] text-[#000000] whitespace-nowrap">' . ($row['STR_INCOME'] == 'Y' ? '+' : '-') . number_format($row['INT_VALUE']) . '원</p>
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
        $result .= '
            <button type="button" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] ' . ($i == $page ? 'bg-black' : 'bg-white') . '" onclick="searchCart(' . $i . ')">
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
} else {
    $result = '
        <div class="flex flex-col gap-5 items-center pt-[55px] pb-[70px]">
            <svg width="70" height="69" viewBox="0 0 70 69" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M50 0C40.8 0 33.3333 7.53951 33.3333 16.8293C33.3333 26.119 40.8 33.6585 50 33.6585C59.2 33.6585 66.6667 26.119 66.6667 16.8293C66.6667 7.53951 59.2 0 50 0ZM50 26.9268C44.4667 26.9268 40 22.4166 40 16.8293C40 11.242 44.4667 6.73171 50 6.73171C55.5333 6.73171 60 11.242 60 16.8293C60 22.4166 55.5333 26.9268 50 26.9268ZM60 47.1219H53.3333C53.3333 43.0829 50.8333 39.4478 47.1 38.0341L26.5667 30.2927H0V67.3171H20V62.4702L43.3333 69L70 60.5854V57.2195C70 51.6322 65.5333 47.1219 60 47.1219ZM13.3333 60.5854H6.66667V37.0244H13.3333V60.5854ZM43.2333 61.9654L20 55.5366V37.0244H25.3667L44.7667 44.3283C45.9 44.7659 46.6667 45.8766 46.6667 47.1219C46.6667 47.1219 40 46.9537 39 46.6171L31.0667 43.958L28.9667 50.3532L36.9 53.0122C38.6 53.5844 40.3667 53.8537 42.1667 53.8537H60C61.3 53.8537 62.4667 54.6615 63 55.7722L43.2333 61.9654Z" fill="#D9D9D9"/>
            </svg>        
            <p class="font-bold text-[15px] leading-[17px] text-[#666666]">적립 내역이 없습니다.</p>
        </div>';
}

echo $result;

?>