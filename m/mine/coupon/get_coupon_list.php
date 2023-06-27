<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
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
                    ' . $Tname . 'comm_member_coupon A
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.DTM_SDATE <= "' . date("Y-m-d H:i:s") . '"
                    AND A.DTM_EDATE >= "' . date("Y-m-d H:i:s") . '"';

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
                    A.STR_USED, A.DTM_SDATE, A.DTM_EDATE, B.*
                FROM 
                    ' . $Tname . 'comm_member_coupon A
                LEFT JOIN
                    ' . $Tname . 'comm_coupon B
                ON
                    A.INT_COUPON=B.INT_NUMBER
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.DTM_SDATE <= "' . date("Y-m-d H:i:s") . '"
                    AND A.DTM_EDATE >= "' . date("Y-m-d H:i:s") . '"
                ORDER BY A.DTM_INDATE DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$coupon_list_result = mysql_query($SQL_QUERY);

if ($end_page > 0) {
    $result = '<div class="flex flex-col w-full divide-y-[0.5px] divide-[#E0E0E0]">';
    while ($row = mysql_fetch_assoc($coupon_list_result)) {
        $result .= '
        <div class="flex w-full py-[15px]">
            <div class="flex flex-col w-full bg-white border border-solid border-[#DDDDDD] divide-y-[0.5px] divide-[#E0E0E0] ' . ($row['STR_USED'] == 'Y' ? 'bg-[#f5f5f5] opacity-70' : '') . '">
                <div class="px-[15px] py-3 flex flex-col">
                    <p class="font-extrabold text-xl leading-[23px] text-black">' . (number_format($row['INT_VALUE']) . ($row['STR_PERCENT'] == 'N' ? '원' : '%')) . '</p>
                    <p class="mt-[1px] font-bold text-xs leading-[14px] text-[#666666]">' . $row['STR_TITLE'] . '</p>
                    <p class="mt-2.5 font-bold text-xs leading-[14px] text-[#999999]">' . date('Y.m.d', strtotime($row['DTM_SDATE'])) . ' ~ ' . date('Y.m.d H:i:s', strtotime($row['DTM_EDATE'])) . ' 까지</p>
                </div>
                <div class="px-[15px] py-3 flex items-center">
                    <p class="font-bold text-[10px] leading-[11px] text-[#999999]">' . $row['STR_DESC'] . '</p>
                </div>
            </div>
        </div>';
    }
    $result .= '</div>';

    // Pagination
    $result .= '
        <div class="mt-[30px] flex gap-[23px] justify-center items-center">
            <button type="button" onclick="searchCoupon(' . (($page - 1) < 0 ? '0' : $page - 1) . ')">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z" fill="black" />
                </svg>
            </button>
            <div class="flex gap-[9.6px] items-center">';
    for ($i = $start_page; $i <= $end_page; $i++) {
        $result .= '
            <button type="button" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] ' . ($i == $page ? 'bg-black' : 'bg-white') . '" onclick="searchCoupon(' . $i . ')">
                <p class="font-bold text-xs leading-[14px] text-center ' . ($i == $page ? 'text-white' : 'text-black') . '">' . $i . '</p>
            </button>';
    }
    $result .= '
            </div>
            <button type="button" onclick="searchCoupon(' . (($page + 1) > $last_page ? $last_page : $page + 1) . ')">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.280895 15.6874L1.19642 16.4055L7.31785 8.59663L1.21437 0.787764L0.280895 1.46992L5.88173 8.59663L0.280895 15.6874Z" fill="black" />
                </svg>
            </button>
        </div>';
} else {
    $result = '
    <div class="flex flex-col gap-5 items-center pt-[77px] pb-[181px]">
        <svg width="81" height="64" viewBox="0 0 81 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M51.84 16L56.7 20.8L29.16 48L24.3 43.2L51.84 16ZM8.1 0H72.9C77.3955 0 81 3.56 81 8V24C78.8518 24 76.7915 24.8429 75.2724 26.3431C73.7534 27.8434 72.9 29.8783 72.9 32C72.9 34.1217 73.7534 36.1566 75.2724 37.6569C76.7915 39.1571 78.8518 40 81 40V56C81 60.44 77.3955 64 72.9 64H8.1C5.95175 64 3.89148 63.1571 2.37243 61.6569C0.85339 60.1566 0 58.1217 0 56V40C4.4955 40 8.1 36.44 8.1 32C8.1 29.8783 7.24661 27.8434 5.72757 26.3431C4.20852 24.8429 2.14825 24 0 24V8C0 5.87827 0.85339 3.84344 2.37243 2.34315C3.89148 0.842854 5.95175 0 8.1 0ZM8.1 8V18.16C10.5611 19.5616 12.605 21.5786 14.0262 24.0082C15.4473 26.4378 16.1955 29.1941 16.1955 32C16.1955 34.8059 15.4473 37.5622 14.0262 39.9918C12.605 42.4214 10.5611 44.4384 8.1 45.84V56H72.9V45.84C70.4389 44.4384 68.395 42.4214 66.9738 39.9918C65.5527 37.5622 64.8045 34.8059 64.8045 32C64.8045 29.1941 65.5527 26.4378 66.9738 24.0082C68.395 21.5786 70.4389 19.5616 72.9 18.16V8H8.1ZM30.375 16C33.7365 16 36.45 18.68 36.45 22C36.45 25.32 33.7365 28 30.375 28C27.0135 28 24.3 25.32 24.3 22C24.3 18.68 27.0135 16 30.375 16ZM50.625 36C53.9865 36 56.7 38.68 56.7 42C56.7 45.32 53.9865 48 50.625 48C47.2635 48 44.55 45.32 44.55 42C44.55 38.68 47.2635 36 50.625 36Z" fill="#D9D9D9"/>
        </svg>    
        <p class="font-bold text-[15px] leading-[17px] text-[#666666]">사용 가능한 쿠폰이 없습니다.</p>
    </div>
    ';
}
echo $result;

?>