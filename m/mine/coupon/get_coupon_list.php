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
                    ' . $Tname . 'comm_member_stamp A
                WHERE 
                    A.STR_USED="N"
                    AND A.STR_USERID="' . $arr_Auth[0] . '"
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
                    A.DTM_SDATE, A.DTM_EDATE, B.*
                FROM 
                    ' . $Tname . 'comm_member_stamp A
                LEFT JOIN
                    ' . $Tname . 'comm_stamp_prod B
                ON
                    A.INT_STAMP=B.INT_PROD
                WHERE 
                    A.STR_USED="N"
                    AND A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.DTM_SDATE <= "' . date("Y-m-d H:i:s") . '"
                    AND A.DTM_EDATE >= "' . date("Y-m-d H:i:s") . '"
                ORDER BY A.DTM_INDATE DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$order_list_result = mysql_query($SQL_QUERY);

$result = '<div class="flex flex-col w-full divide-y-[0.5px] divide-[#E0E0E0]">';
while ($row = mysql_fetch_assoc($order_list_result)) {
    $result .= '
    <div class="flex w-full py-[15px]">
        <div class="flex flex-col w-full bg-white border border-solid border-[#DDDDDD] divide-y-[0.5px] divide-[#E0E0E0]">
            <div class="px-[15px] py-3 flex flex-col">
                <p class="font-extrabold text-xl leading-[23px] text-black">' . ($row['INT_PRICE'] ? number_format($row['INT_PRICE']) . '원' : number_format($row['INT_PERCENT']) . '%') . '</p>
                <p class="mt-[1px] font-bold text-xs leading-[14px] text-[#666666]">' . $row['STR_PROD'] . '</p>
                <p class="mt-2.5 font-bold text-xs leading-[14px] text-[#999999]">' . date('Y.m.d', strtotime($row['DTM_SDATE'])) . ' ~ ' . date('Y.m.d H:i:s', strtotime($row['DTM_SDATE'])) . ' 까지</p>
            </div>
            <div class="px-[15px] py-3 flex items-center">
                <p class="font-bold text-[10px] leading-[11px] text-[#999999]">렌트 카테고리 상품 40,000원 이상 결제시(일부 상품 제외)</p>
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
    $result .=
        '<button type="button" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] ' . ($i == $page ? 'bg-black' : 'bg-white') . '" onclick="searchCoupon(' . $i . ')">
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

echo $result;

?>