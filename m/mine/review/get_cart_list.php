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
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.INT_STATE IN (4, 5, 6, 10)';

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
                    A.*, B.STR_GOODNAME, B.STR_IMAGE1, B.INT_TYPE, C.STR_CODE, D.BD_SEQ 
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
                    `' . $Tname . 'b_bd_data@01` D
                ON
                    A.INT_NUMBER=D.INT_CART
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.INT_STATE IN (4, 5, 6, 10)
                ORDER BY A.DTM_INDATE DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$cart_list_result = mysql_query($SQL_QUERY);

// 금액정보 얻기
$SQL_QUERY =	" SELECT
						*
                FROM 
                    " . $Tname . "comm_site_info
                WHERE
                    INT_NUMBER=1 ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);

if ($end_page > 0) {
    $result = '
        <div class="mt-[15px] mb-[23px] flex flex-col gap-[7px] px-[9px] py-[15px] bg-[#F5F5F5]">
            <p class="font-bold text-sm leading-[14px] text-black">후기 작성 안내</p>
            <p class="font-normal text-[10px] leading-[14px] text-[#999999]">
                -사진 후기 ' . number_format($site_Data['INT_STAMP2']) . '원, 글 후기 ' . number_format($site_Data['INT_STAMP1']) . '원 적립금이 지급됩니다.<br />
                -작성 시 기준에 맞는 적립금이 자동으로 지급됩니다.<br />
                -등급에 따라 차등으로 적립 혜택이 달라질 수 있습니다.<br />
                -주간 베스트 후기로 선정 시 ' . number_format($site_Data['INT_STAMP3']) . '원이 추가로 적립됩니다.<br />
                -후기 작성은 배송완료일로부터 30일 이내 가능합니다.
            </p>
        </div>
        <div class="flex flex-col gap-[15px] w-full border-t-[0.5px] border-[#E0E0E0] pt-[15px]">';
    while ($row = mysql_fetch_assoc($cart_list_result)) {
        $endDate = date('Y-m-d', strtotime($row['DTM_EDIT_DATE'] . ' +30 days'));
        $d_day = (strtotime($endDate) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
        $d_day = round($d_day);

        $result .= '
            <div class="flex flex-col gap-[15px] w-full border-b-[0.5px] border-[#E0E0E0] pb-[21px]">
                <p class="font-bold text-[13px] leading-[15px] text-[#999999]">구매확정일 ' . substr($row['DTM_INDATE'], 0, 10) . '</p>
                <div class="flex gap-[11px]">
                    <div class="flex justify-center items-center w-[120px] h-[120px] bg-[#F9F9F9] p-2.5">
                        <img src="/admincenter/files/good/' . $row['STR_IMAGE1'] . '" alt="">
                    </div>
                    <div class="grow flex flex-col justify-center">
                        <div class="w-[34px] h-[18px] flex justify-center items-center bg-[' . ($row['INT_TYPE'] == 1 ? '#EEAC4C' : ($row['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A')) . ']">
                            <p class="font-normal text-[10px] leading-[11px] text-center text-white">' . ($row['INT_TYPE'] == 1 ? '구독' : ($row['INT_TYPE'] == 2 ? '렌트' : '빈티지')) . '</p>
                        </div>
                        <p class="mt-1.5 font-bold text-[15px] leading-[17px] text-black">' . $row['STR_CODE'] . '</p>
                        <p class="mt-[2px] font-bold text-xs leading-[14px] text-[#666666]">' . $row['STR_GOODNAME'] . '</p>
                        <p class="mt-[9px] font-medium text-xs leading-[14px] text-[#999999]">기간: ' . date('Y.m.d', strtotime($row['STR_SDATE'])) . ' ~ ' . date('Y.m.d', strtotime($row['STR_EDATE'])) . '</p>
                    </div>
                </div>
                <div class="mt-[14px] flex gap-[35px] items-center w-full">
                    <div class="flex flex-col gap-[5px]">
                        <p class="font-bold text-xs leading-[14px] text-black">텍스트 리뷰: ' . number_format($site_Data['INT_STAMP1']) . '₩ / 포토 리뷰: ' . number_format($site_Data['INT_STAMP2']) . '₩</p>
                        <p class="font-medium text-xs leading-[14px] text-[#999999]">' . ($row['BD_SEQ'] ? '작성 완료' : ('작성기한 D-' . $d_day . '(' . date('Y.m.d', strtotime($endDate)) . ')')) . '</p>
                    </div>
                    <a href="' . ($row['BD_SEQ'] ? '#' : ('create.php?int_cart=' . $row['INT_NUMBER'])) . '" class="grow flex justify-center items-center h-10 bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                        <p class="font-bold text-xs leading-[14px] text-black">' . ($row['BD_SEQ'] ? '리뷰 작성 완료' : '리뷰 작성') . '</p>
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
        <div class="flex flex-col gap-5 items-center mt-[77px]">
            <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M71.156 12.3614L59.6386 0.844011C59.0927 0.303321 58.3554 0 57.587 0C56.8187 0 56.0814 0.303321 55.5355 0.844011L20.9833 35.3962C20.4485 35.9448 20.1511 36.6817 20.1555 37.4478V48.9652C20.1555 49.7288 20.4588 50.4612 20.9988 51.0012C21.5388 51.5412 22.2712 51.8445 23.0348 51.8445H34.5522C35.3183 51.8489 36.0552 51.5515 36.6038 51.0167L71.156 16.4645C71.6967 15.9186 72 15.1813 72 14.413C72 13.6446 71.6967 12.9073 71.156 12.3614ZM33.3645 46.0858H25.9142V38.6355L48.949 15.6007L56.3993 23.051L33.3645 46.0858ZM60.4664 18.9839L53.0161 11.5336L57.587 6.96263L65.0374 14.413L60.4664 18.9839ZM69.1044 34.5684V66.2413C69.1044 67.7686 68.4977 69.2333 67.4178 70.3133C66.3378 71.3933 64.873 72 63.3457 72H5.7587C4.2314 72 2.76665 71.3933 1.68669 70.3133C0.606719 69.2333 0 67.7686 0 66.2413V8.65425C0 7.12695 0.606719 5.6622 1.68669 4.58223C2.76665 3.50227 4.2314 2.89555 5.7587 2.89555H37.4316C38.1952 2.89555 38.9276 3.19891 39.4676 3.73889C40.0076 4.27888 40.3109 5.01125 40.3109 5.7749C40.3109 6.53855 40.0076 7.27093 39.4676 7.81091C38.9276 8.35089 38.1952 8.65425 37.4316 8.65425H5.7587V66.2413H63.3457V34.5684C63.3457 33.8048 63.6491 33.0724 64.1891 32.5324C64.7291 31.9924 65.4614 31.6891 66.2251 31.6891C66.9887 31.6891 67.7211 31.9924 68.2611 32.5324C68.8011 33.0724 69.1044 33.8048 69.1044 34.5684Z" fill="#D9D9D9"/>
            </svg>        
            <p class="font-bold text-[15px] leading-[17px] text-[#666666]">작성 가능한 리뷰가 없습니다.</p>
        </div>';
}

echo $result;

?>