<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<script language="javascript" src="js/common.js"></script>

<?php
$per_page = 4;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$last_page = 0;
$start_page = 1;
$end_page = 1;

$SQL_QUERY = 'SELECT 
                    COUNT(A.INT_NUMBER)
                FROM 
                    ' . $Tname . 'comm_plan A
                WHERE 
                    A.STR_SERVICE="Y"';

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
                    ' . $Tname . 'comm_plan A
                WHERE 
                    A.STR_SERVICE="Y"
                ORDER BY A.DTM_INDATE DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$plan_list_result = mysql_query($SQL_QUERY);

$result = '<div class="flex flex-col gap-[13px] w-full">';
while ($row = mysql_fetch_assoc($plan_list_result)) {
    $result .= '
        <a href="plan_detail.php?int_number=' . $row['INT_NUMBER'] . '" class="flex flex-col w-full px-3 pb-[13.8px] border-b-[0.5px] border-[#E0E0E0]">
            <div class="flex w-full h-[177px] rounded-lg bg-gray-100">
                <img class="min-w-full object-cover rounded-lg" src="/admincenter/files/plan/' . $row['STR_IMAGE'] . '" onerror="this.style.display = \'none\'" alt="">
            </div>
            <p class="mt-[9px] font-extrabold text-sm leading-4 text-black">' . $row['STR_TITLE'] . '</p>
            <p class="mt-[3px] font-semibold text-xs leading-[14px] text-[#666666]">' . $row['STR_CONT'] . '</p>
        </a>';
}
$result .= '</div>';

// Pagination
$result .= '
    <div class="mt-[30px] flex gap-[23px] justify-center items-center">
        <button type="button" onclick="searchPlan(' . (($page - 1) < 0 ? '0' : $page - 1) . ')">
            <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z" fill="black" />
            </svg>
        </button>
        <div class="flex gap-[9.6px] items-center">';
for ($i = $start_page; $i <= $end_page; $i++) {
    $result .=
        '<button type="button" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] ' . ($i == $page ? 'bg-black' : 'bg-white') . '" onclick="searchPlan(' . $i . ')">
            <p class="font-bold text-xs leading-[14px] text-center ' . ($i == $page ? 'text-white' : 'text-black') . '">' . $i . '</p>
        </button>';
}
$result .= '
        </div>
        <button type="button" onclick="searchPlan(' . (($page + 1) > $last_page ? $last_page : $page + 1) . ')">
            <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.280895 15.6874L1.19642 16.4055L7.31785 8.59663L1.21437 0.787764L0.280895 1.46992L5.88173 8.59663L0.280895 15.6874Z" fill="black" />
            </svg>
        </button>
    </div>';

echo $result;

?>