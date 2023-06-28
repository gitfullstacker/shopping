<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$per_page = 5;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$last_page = 0;
$start_page = 1;
$end_page = 1;

$str_goodcode = $_GET['str_goodcode'];

$SQL_QUERY =    'SELECT 
                    COUNT(A.BD_SEQ)
                FROM 
                    `' . $Tname . 'b_bd_data@01` A
                LEFT JOIN
                    `' . $Tname . 'b_img_data@01` B
                ON
                    A.CONF_SEQ=B.CONF_SEQ
                    AND
                    A.BD_SEQ=B.BD_SEQ
                    AND
                    B.IMG_ALIGN=1
                LEFT JOIN
                    ' . $Tname . 'comm_goods_master C
                ON
                    A.BD_ITEM1=C.STR_GOODCODE
                LEFT JOIN
                    ' . $Tname . 'comm_com_code D
                ON
                    C.INT_BRAND=D.INT_NUMBER
                WHERE 
                    A.CONF_SEQ=2
                    AND A.BD_ID_KEY IS NOT NULL
                    AND (A.BD_HIDE=0 OR A.MEM_ID="' . $arr_Auth[0] . '")
                    AND C.STR_GOODCODE=' . $str_goodcode;

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
                    A.BD_SEQ,
					A.CONF_SEQ,
					A.MEM_ID,
					A.BD_CONT,
					A.BD_REG_DATE,
                    A.BD_ITEM2,
					C.STR_GOODNAME,
					C.STR_IMAGE1,
                    C.INT_DISCOUNT,
                    C.INT_PRICE,
                    C.INT_TYPE,
					D.STR_CODE,
                    (SELECT COUNT(STR_USERID) FROM `' . $Tname . 'comm_review_like` A1 WHERE A1.BD_SEQ=A.BD_SEQ) AS COUNT_LIKE
                FROM 
                    `' . $Tname . 'b_bd_data@01` A
                LEFT JOIN
                    ' . $Tname . 'comm_goods_master C
                ON
                    A.BD_ITEM1=C.STR_GOODCODE
                LEFT JOIN
                    ' . $Tname . 'comm_com_code D
                ON
                    C.INT_BRAND=D.INT_NUMBER
                WHERE 
                    A.CONF_SEQ=2
                    AND A.BD_ID_KEY IS NOT NULL
                    AND (A.BD_HIDE=0 OR A.MEM_ID="' . $arr_Auth[0] . '")
                    AND C.STR_GOODCODE="' . $str_goodcode . '"
                ORDER BY A.BD_REG_DATE DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$review_list_result = mysql_query($SQL_QUERY);

$result = '<div class="flex flex-col gap-[15px] w-full border-t-[0.5px] border-[#E0E0E0] pt-[15px]">';
while ($row = mysql_fetch_assoc($review_list_result)) {

    $SQL_QUERY =    'SELECT 
                        IFNULL(B.IMG_F_NAME, "") AS IMG_F_NAME
                    FROM 
                        `' . $Tname . 'b_bd_data@01` A
                    LEFT JOIN
                        `' . $Tname . 'b_img_data@01` B
                    ON
                        A.CONF_SEQ=B.CONF_SEQ
                        AND
                        A.BD_SEQ=B.BD_SEQ
                    WHERE 
                        A.BD_SEQ=' . $row['BD_SEQ'];

    $review_img_list_result = mysql_query($SQL_QUERY);

    $images = '';
    $index = 0;
    while ($image_row = mysql_fetch_assoc($review_img_list_result)) {
        $index++;
        $images .= '<img class="min-w-full object-cover" src="/admincenter/files/boad/2/' . $image_row['IMG_F_NAME'] . '" x-bind:class="selectedImage == ' . $index . ' ? \'w-full object-fill\' : (selectedImage == 0 ? \'h-[120px]\' : \'hidden\')" onerror="this.style.display = \'none\'" alt="" x-on:click="selectedImage == ' . $index . ' ? (selectedImage = 0) : (selectedImage = ' . $index . ')">';
    }

    $result .= '
        <div class="flex flex-col gap-[9px] pb-[15px] border-b-[0.5px] border-[#E0E0E0]">
            <div class="flex justify-between items-center">
                <p>' . str_repeat('★', $row['BD_ITEM2']) . '</p>
                <button class="flex justify-center items-center gap-[2.76px] w-10 h-[17px] rounded-full border-[0.68px] border-solid border-[#DDDDDD]" onclick="setReviewLike(\'' . $row['BD_SEQ'] . '\')">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.00156 4.61921C0.996567 4.56168 1.00358 4.50374 1.02217 4.44907C1.04076 4.39439 1.0705 4.34418 1.10952 4.30161C1.14855 4.25904 1.19599 4.22505 1.24885 4.20179C1.3017 4.17854 1.35882 4.16652 1.41656 4.1665H2.21219C2.32269 4.1665 2.42867 4.2104 2.50681 4.28854C2.58495 4.36668 2.62885 4.47266 2.62885 4.58317V8.5415C2.62885 8.65201 2.58495 8.75799 2.50681 8.83613C2.42867 8.91427 2.32269 8.95817 2.21219 8.95817H1.76094C1.65665 8.9582 1.55615 8.91911 1.47927 8.84864C1.4024 8.77817 1.35475 8.68144 1.34573 8.57754L1.00156 4.61921ZM3.87885 4.45296C3.87885 4.27879 3.98719 4.12296 4.14448 4.04879C4.48802 3.88671 5.07323 3.56109 5.33719 3.12088C5.6774 2.55338 5.74156 1.52817 5.75198 1.29338C5.75344 1.26046 5.7526 1.22754 5.75698 1.19504C5.81344 0.788169 6.59865 1.26338 6.89969 1.76588C7.06323 2.03838 7.08406 2.3965 7.06698 2.67629C7.04844 2.97546 6.96073 3.26442 6.87469 3.5515L6.69135 4.16338H8.95323C9.0176 4.16337 9.08111 4.17829 9.13875 4.20695C9.1964 4.23561 9.24662 4.27723 9.28547 4.32856C9.32433 4.37989 9.35076 4.43953 9.3627 4.50279C9.37463 4.56605 9.37175 4.63121 9.35427 4.69317L8.23552 8.65484C8.21082 8.74221 8.15826 8.81913 8.08583 8.87388C8.0134 8.92864 7.92507 8.95823 7.83427 8.95817H4.29552C4.18501 8.95817 4.07903 8.91427 4.00089 8.83613C3.92275 8.75799 3.87885 8.65201 3.87885 8.5415V4.45296Z" stroke="#666666" stroke-width="0.833333" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p id="like_count_' . $row['BD_SEQ'] . '" class="font-bold text-[9px] flex items-center text-center text-[#666666]">' . $row['COUNT_LIKE'] . '</p>
                </button>
            </div>
            <div class="flex gap-5 items-center">
                <p class="font-bold text-xs text-[#666666]">' . substr($row['MEM_ID'], 0, 3) . '***</p>
                <p class="font-medium text-xs text-[#999999]">' . date('Y/m/d', strtotime($row['BD_REG_DATE'])) . '</p>
            </div>
            <div x-data="{
                    isCollapsed: true,
                    showButton: true,
                    init() {
                        this.showButton = $refs.contents.scrollHeight > 54 ? true : false;
                    }
                }" class="flex flex-col gap-2.5 w-full">
                <p x-ref="contents" class="font-medium text-xs leading-[18px] text-[#666666]" x-bind:class="isCollapsed ? \'line-clamp-3\' : \'\'">
                    ' . strip_tags($row['BD_CONT']) . '
                </p>
                <button x-show="isCollapsed && showButton" class="flex flex-row gap-[3px] items-center" x-on:click="isCollapsed = false">
                    <p class="font-bold text-[11px] leading-[12px] text-black">더보기</p>
                    <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576043 0.435356 4.59757e-07 0.593667 4.53547e-07C0.751979 4.47336e-07 0.890501 0.0576043 1.00923 0.172811L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.011521 8.40016 0.011521C8.56259 0.011521 8.70317 0.0691244 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587557C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#333333" />
                    </svg>
                </button>
                <button x-show="!isCollapsed && showButton" class="flex flex-row gap-[3px] items-center" x-on:click="isCollapsed = true">
                    <p class="font-bold text-[11px] leading-[12px] text-black">접기</p>
                    <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.1781 4.00922L4.16755 0.126728C4.21504 0.0806447 4.26649 0.0480795 4.3219 0.0290319C4.37731 0.00967705 4.43668 -2.42689e-07 4.5 -2.39322e-07C4.56332 -2.35954e-07 4.62269 0.00967706 4.6781 0.0290319C4.73351 0.0480795 4.78496 0.0806448 4.83245 0.126728L8.83377 4.00922C8.94459 4.11674 9 4.25115 9 4.41244C9 4.57373 8.94063 4.71198 8.8219 4.82719C8.70317 4.9424 8.56464 5 8.40633 5C8.24802 5 8.1095 4.9424 7.99077 4.82719L4.5 1.44009L1.00923 4.82719C0.898417 4.93471 0.761953 4.98848 0.599842 4.98848C0.437414 4.98848 0.296834 4.93087 0.1781 4.81567C0.0593667 4.70046 -8.36071e-08 4.56605 -7.68926e-08 4.41244C-7.01781e-08 4.25883 0.0593667 4.12442 0.1781 4.00922Z" fill="#333333" />
                    </svg>
                </button>
            </div>
            <div x-data="{ selectedImage: 0 }" class="grid gap-2 w-full" x-bind:class="selectedImage == 0 ? \'grid-cols-3\' : \'grid-cols-1\'">
                ' . $images . '
            </div>
        </div>';
}
$result .= '</div>';

// Pagination
if ($end_page) {
    $result .= '
        <div class="mt-[30px] flex gap-[23px] justify-center items-center">
            <button type="button" onclick="searchOwnReview(' . (($page - 1) < 0 ? '0' : $page - 1) . ')">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z" fill="black" />
                </svg>
            </button>
            <div class="flex gap-[9.6px] items-center">';
    for ($i = $start_page; $i <= $end_page; $i++) {
        $result .= '
            <button type="button" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] ' . ($i == $page ? 'bg-black' : 'bg-white') . '" onclick="searchOwnReview(' . $i . ')">
                <p class="font-bold text-xs leading-[14px] text-center ' . ($i == $page ? 'text-white' : 'text-black') . '">' . $i . '</p>
            </button>';
    }
    $result .= '
        </div>
            <button type="button" onclick="searchOwnReview(' . (($page + 1) > $last_page ? $last_page : $page + 1) . ')">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.280895 15.6874L1.19642 16.4055L7.31785 8.59663L1.21437 0.787764L0.280895 1.46992L5.88173 8.59663L0.280895 15.6874Z" fill="black" />
                </svg>
            </button>
        </div>';
}

echo $result;

?>