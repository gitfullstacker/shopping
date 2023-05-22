<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<script language="javascript" src="js/index.js"></script>

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
                    ' . $Tname . 'comm_review A
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                AND 
                    A.STR_GOODCODE IS NOT NULL';

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
                    A.*, C.STR_GOODNAME, C.STR_IMAGE1 AS GOOD_IMAGE, C.INT_TYPE, D.STR_CODE
                FROM 
                    ' . $Tname . 'comm_review A
                LEFT JOIN
                    ' . $Tname . 'comm_goods_cart B
                ON
                    A.STR_CART=B.INT_NUMBER
                LEFT JOIN
                    ' . $Tname . 'comm_goods_master C
                ON
                    A.STR_GOODCODE=C.STR_GOODCODE
                LEFT JOIN
                    ' . $Tname . 'comm_com_code D
                ON
                    C.INT_BRAND=D.INT_NUMBER
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                AND A.STR_GOODCODE IS NOT NULL
                ORDER BY A.DTM_EDIT_DATE DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$arr_Data = mysql_query($SQL_QUERY);
$arr_Data_Cnt = mysql_num_rows($arr_Data);

$result = '<div class="flex flex-col gap-[15px] w-full border-t-[0.5px] border-[#E0E0E0] pt-[15px]">';
for ($int_J = 0; $int_J < $arr_Data_Cnt; $int_J++) {
    $result .= '
        <div class="flex flex-col gap-[15px] w-full border-b-[0.5px] border-[#E0E0E0] pb-[21px]">
            <div class="flex gap-[11px]">
                <div class="flex justify-center items-center w-[91px] h-[91px] bg-[#F9F9F9] p-2">
                    <img src="/admincenter/files/good/' . mysql_result($arr_Data, $int_J, 'GOOD_IMAGE') . '" alt="">
                </div>
                <div class="grow flex flex-col justify-center">
                    <div class="w-[25px] h-[14px] flex justify-center items-center bg-[' . (mysql_result($arr_Data, $int_J, 'INT_TYPE') == 1 ? '#EEAC4C' : (mysql_result($arr_Data, $int_J, 'INT_TYPE') == 2 ? '#00402F' : '#7E6B5A')) . ']">
                        <p class="font-normal text-[8px] leading-[9px] text-center text-white">' . (mysql_result($arr_Data, $int_J, 'INT_TYPE') == 1 ? '구독' : (mysql_result($arr_Data, $int_J, 'INT_TYPE') == 2 ? '렌트' : '빈티지')) . '</p>
                    </div>
                    <p class="mt-1.5 font-bold text-[11px] leading-[12px] text-black">' . mysql_result($arr_Data, $int_J, 'STR_CODE') . '</p>
                    <p class="mt-1 font-bold text-[9px] leading-[10px] text-[#666666]">' . mysql_result($arr_Data, $int_J, 'STR_GOODNAME') . '</p>
                    <div class="mt-2.5 flex gap-1">
                        <a href="edit.php?int_review=' . mysql_result($arr_Data, $int_J, 'INT_NUMBER') . '" class="w-[95px] h-[30px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                            <p class="font-bold text-[9px] leading-[10px] text-[#666666]">수정</p>
                        </a>
                        <button class="w-[95px] h-[30px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]" onclick="deleteClick(' . mysql_result($arr_Data, $int_J, 'INT_NUMBER') . ')">
                            <p class="font-bold text-[9px] leading-[10px] text-[#666666]">삭제</p>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-[9px] w-full">
                <div class="flex justify-between items-center">
                    <p>
                    ' . str_repeat('★', mysql_result($arr_Data, $int_J, 'INT_STAR')) . '
                    </p>
                    <button class="flex gap-[2.7px] px-[11px] py-1 items-center justify-center border-[0.6px] border-solid border-[#DDDDDD] rounded-full">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.00156 4.61921C0.996567 4.56168 1.00358 4.50374 1.02217 4.44907C1.04076 4.39439 1.0705 4.34418 1.10952 4.30161C1.14855 4.25904 1.19599 4.22505 1.24885 4.20179C1.3017 4.17854 1.35882 4.16652 1.41656 4.1665H2.21219C2.32269 4.1665 2.42867 4.2104 2.50681 4.28854C2.58495 4.36668 2.62885 4.47266 2.62885 4.58317V8.5415C2.62885 8.65201 2.58495 8.75799 2.50681 8.83613C2.42867 8.91427 2.32269 8.95817 2.21219 8.95817H1.76094C1.65665 8.9582 1.55615 8.91911 1.47927 8.84864C1.4024 8.77817 1.35475 8.68144 1.34573 8.57754L1.00156 4.61921ZM3.87885 4.45296C3.87885 4.27879 3.98719 4.12296 4.14448 4.04879C4.48802 3.88671 5.07323 3.56109 5.33719 3.12088C5.6774 2.55338 5.74156 1.52817 5.75198 1.29338C5.75344 1.26046 5.7526 1.22754 5.75698 1.19504C5.81344 0.788169 6.59865 1.26338 6.89969 1.76588C7.06323 2.03838 7.08406 2.3965 7.06698 2.67629C7.04844 2.97546 6.96073 3.26442 6.87469 3.5515L6.69135 4.16338H8.95323C9.0176 4.16337 9.08111 4.17829 9.13875 4.20695C9.1964 4.23561 9.24662 4.27723 9.28547 4.32856C9.32433 4.37989 9.35076 4.43953 9.3627 4.50279C9.37463 4.56605 9.37175 4.63121 9.35427 4.69317L8.23552 8.65484C8.21082 8.74221 8.15826 8.81913 8.08583 8.87388C8.0134 8.92864 7.92507 8.95823 7.83427 8.95817H4.29552C4.18501 8.95817 4.07903 8.91427 4.00089 8.83613C3.92275 8.75799 3.87885 8.65201 3.87885 8.5415V4.45296Z" stroke="#666666" stroke-width="0.833333" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="font-bold text-[9px] leading-[9px] text-[#666666]">0</p>
                    </button>
                </div>
                <div class="flex gap-5 items-center">
                    <p class="font-bold text-xs leading-[12px] text-[#666666]">' . substr(mysql_result($arr_Data, $int_J, 'STR_USERID'), 0, 3) . '***' . '</p>
                    <p class="font-bold text-xs leading-[12px] text-[#999999]">' . date('Y/m/d', strtotime(mysql_result($arr_Data, $int_J, 'DTM_EDIT_DATE'))) . '</p>
                </div>
                <p class="font-bold text-xs leading-[17px] text-[#666666]">' . mysql_result($arr_Data, $int_J, 'STR_CONTENT') . '</p>
                <div class="grid grid-cols-3">
                    <img class="w-[120px] h-[120px] ' . (mysql_result($arr_Data, $int_J, 'STR_IMAGE1') ? 'flex' : 'hidden') . '" src="/admincenter/files/boad/2/' . mysql_result($arr_Data, $int_J, 'STR_IMAGE1') . '" alt="product">
                    <img class="w-[120px] h-[120px] ' . (mysql_result($arr_Data, $int_J, 'STR_IMAGE2') ? 'flex' : 'hidden') . '" src="/admincenter/files/boad/2/' . mysql_result($arr_Data, $int_J, 'STR_IMAGE2') . '" alt="product">
                    <img class="w-[120px] h-[120px] ' . (mysql_result($arr_Data, $int_J, 'STR_IMAGE3') ? 'flex' : 'hidden') . '" src="/admincenter/files/boad/2/' . mysql_result($arr_Data, $int_J, 'STR_IMAGE3') . '" alt="product">
                </div>
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