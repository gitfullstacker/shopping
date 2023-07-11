<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$per_page = 8;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$last_page = 0;
$start_page = 1;
$end_page = 1;

$SQL_QUERY =    'SELECT 
                    COUNT(A.BD_SEQ)
                FROM 
                    `' . $Tname . 'b_bd_data@01` AS A
                WHERE 
                    A.CONF_SEQ=1
                AND
                    A.BD_ID_KEY IS NOT NULL';

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
                    A.BD_TITLE, A.BD_CONT, A.BD_REG_DATE
                FROM 
                    `' . $Tname . 'b_bd_data@01` AS A
                WHERE 
                    A.CONF_SEQ=1
                AND
                    A.BD_ID_KEY IS NOT NULL
                ORDER BY
                    A.BD_SEQ DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$notification_list_result = mysql_query($SQL_QUERY);

$result = '<div class="flex flex-col w-full border-t-[0.5px] border-[#E0E0E0]">';
while ($row = mysql_fetch_assoc($notification_list_result)) {
    $description = str_replace('\"', '', $row['BD_CONT']);
    $description = str_replace('font-family:', '', $description);
    $description = str_replace('font-size:', '', $description);

    $result .= '
        <div x-data="{ isCollapsed: true }" class="flex flex-col w-full">
            <div class="flex justify-between items-center py-[15px] border-b-[0.5px] border-[#E0E0E0] cursor-pointer" x-on:click="isCollapsed = !isCollapsed">
                <div class="flex flex-col gap-[3px]">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">' . date('Y.m.d', strtotime($row['BD_REG_DATE'])) . '</p>
                    <p class="font-bold text-xs leading-[14px] text-black">[공지] ' . $row['BD_TITLE'] . '</p>
                </div>
                <div class="pr-[7px]">
                    <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.6932 1.18894L5.85752 5.84793C5.79995 5.90323 5.73759 5.9423 5.67042 5.96516C5.60326 5.98839 5.5313 6 5.45455 6C5.37779 6 5.30583 5.98839 5.23867 5.96516C5.1715 5.9423 5.10914 5.90323 5.05157 5.84793L0.201487 1.18894C0.0671621 1.05991 -2.22989e-07 0.898617 -2.31449e-07 0.705069C-2.39909e-07 0.51152 0.0719594 0.345622 0.215879 0.207373C0.359798 0.0691242 0.527704 -4.99904e-07 0.719597 -5.08292e-07C0.911489 -5.1668e-07 1.0794 0.0691242 1.22331 0.207373L5.45454 4.27189L9.68578 0.207373C9.8201 0.0783406 9.98551 0.013824 10.182 0.013824C10.3789 0.013824 10.5493 0.0829482 10.6932 0.221197C10.8371 0.359446 10.9091 0.520736 10.9091 0.705068C10.9091 0.8894 10.8371 1.05069 10.6932 1.18894Z" fill="#333333" />
                    </svg>
                </div>
            </div>
            <div x-show="!isCollapsed" class="items-center bg-[#F5F5F5] p-[22px] font-normal text-xs leading-[14px] text-[#666666]">
            ' . $description . '
            </div>
        </div>';
}
$result .= '</div>';

// Pagination
if ($end_page) {
    $result .= '
        <div class="mt-[30px] flex gap-[23px] justify-center items-center">
            <button type="button" onclick="searchNotification(' . (($page - 1) < 0 ? '0' : $page - 1) . ')">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z" fill="black" />
                </svg>
            </button>
            <div class="flex gap-[9.6px] items-center">';
    for ($i = $start_page; $i <= $end_page; $i++) {
        $result .= '
            <button type="button" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] ' . ($i == $page ? 'bg-black' : 'bg-white') . '" onclick="searchNotification(' . $i . ')">
                <p class="font-bold text-xs leading-[14px] text-center ' . ($i == $page ? 'text-white' : 'text-black') . '">' . $i . '</p>
            </button>';
    }
    $result .= '
            </div>
            <button type="button" onclick="searchNotification(' . (($page + 1) > $last_page ? $last_page : $page + 1) . ')">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.280895 15.6874L1.19642 16.4055L7.31785 8.59663L1.21437 0.787764L0.280895 1.46992L5.88173 8.59663L0.280895 15.6874Z" fill="black" />
                </svg>
            </button>
        </div>';
}

echo $result;

?>