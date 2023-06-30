<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$per_page = 5;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$last_page = 0;
$start_page = 1;
$end_page = 1;

$SQL_QUERY =    'SELECT 
                    COUNT(A.BD_SEQ)
                FROM 
                    `' . $Tname . 'b_bd_data@01` A
                WHERE 
                    A.CONF_SEQ=2
                    AND A.BD_ID_KEY IS NOT NULL
                    AND A.MEM_ID="' . $arr_Auth[0] . '"';

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
                    A.INT_CART,
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
                    AND A.MEM_ID="' . $arr_Auth[0] . '"
                ORDER BY A.BD_ORDER DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$review_list_result = mysql_query($SQL_QUERY);

// 금액정보 얻기
$SQL_QUERY =    " SELECT
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
            $images .= '<img class="min-w-full object-cover" src="/admincenter/files/boad/2/' . $image_row['IMG_F_NAME'] . '" x-bind:class="selectedImage == ' . $index . ' ? \'h-[410px] object-fill\' : (selectedImage == 0 ? \'h-[120px]\' : \'hidden\')" onerror="this.style.display = \'none\'" alt="" x-on:click="selectedImage == ' . $index . ' ? (selectedImage = 0) : (selectedImage = ' . $index . ')">';
        }

        $result .= '
            <div class="flex flex-col gap-[15px] w-full border-b-[0.5px] border-[#E0E0E0] pb-[21px]">
                <div class="flex gap-[11px]">
                    <div class="flex justify-center items-center w-[91px] h-[91px] bg-[#F9F9F9] p-2">
                        <img src="/admincenter/files/good/' . $row['STR_IMAGE1'] . '" onerror="this.style.display = \'none\'" alt="">
                    </div>
                    <div class="grow flex flex-col justify-center">
                        <div class="w-[25px] h-[14px] flex justify-center items-center bg-[' . ($row['INT_TYPE'] == 1 ? '#EEAC4C' : ($row['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A')) . ']">
                            <p class="font-normal text-[9px] leading-[11px] text-center text-white">' . ($row['INT_TYPE'] == 1 ? '구독' : ($row['INT_TYPE'] == 2 ? '렌트' : '빈티지')) . '</p>
                        </div>
                        <p class="mt-1.5 font-bold text-xs leading-[14px] text-black">' . $row['STR_CODE'] . '</p>
                        <p class="mt-1 font-bold text-xs leading-[14px] text-[#666666]">' . $row['STR_GOODNAME'] . '</p>
                        <div class="mt-2.5 flex gap-1">
                            <a href="edit.php?bd_seq=' . $row['BD_SEQ'] . '" class="w-[95px] h-[30px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                                <p class="font-bold text-xs leading-[14px] text-[#666666]">수정</p>
                            </a>
                            <button class="w-[95px] h-[30px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]" onclick="deleteClick(\'' . $row['BD_SEQ'] . '\',\'' . $row['INT_CART'] . '\')">
                                <p class="font-bold text-xs leading-[14px] text-[#666666]">삭제</p>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-[9px] w-full">
                    <div class="flex justify-between items-center">
                        <p class="font-bold text-xs leading-[14px] text-black">
                        ' . str_repeat('★', $row['BD_ITEM2']) . '
                        </p>
                        <button class="flex gap-[2.7px] px-[11px] py-1 items-center justify-center border-[0.6px] border-solid border-[#DDDDDD] rounded-full" onclick="setLike(' . $row['BD_SEQ'] . ')">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.00156 4.61921C0.996567 4.56168 1.00358 4.50374 1.02217 4.44907C1.04076 4.39439 1.0705 4.34418 1.10952 4.30161C1.14855 4.25904 1.19599 4.22505 1.24885 4.20179C1.3017 4.17854 1.35882 4.16652 1.41656 4.1665H2.21219C2.32269 4.1665 2.42867 4.2104 2.50681 4.28854C2.58495 4.36668 2.62885 4.47266 2.62885 4.58317V8.5415C2.62885 8.65201 2.58495 8.75799 2.50681 8.83613C2.42867 8.91427 2.32269 8.95817 2.21219 8.95817H1.76094C1.65665 8.9582 1.55615 8.91911 1.47927 8.84864C1.4024 8.77817 1.35475 8.68144 1.34573 8.57754L1.00156 4.61921ZM3.87885 4.45296C3.87885 4.27879 3.98719 4.12296 4.14448 4.04879C4.48802 3.88671 5.07323 3.56109 5.33719 3.12088C5.6774 2.55338 5.74156 1.52817 5.75198 1.29338C5.75344 1.26046 5.7526 1.22754 5.75698 1.19504C5.81344 0.788169 6.59865 1.26338 6.89969 1.76588C7.06323 2.03838 7.08406 2.3965 7.06698 2.67629C7.04844 2.97546 6.96073 3.26442 6.87469 3.5515L6.69135 4.16338H8.95323C9.0176 4.16337 9.08111 4.17829 9.13875 4.20695C9.1964 4.23561 9.24662 4.27723 9.28547 4.32856C9.32433 4.37989 9.35076 4.43953 9.3627 4.50279C9.37463 4.56605 9.37175 4.63121 9.35427 4.69317L8.23552 8.65484C8.21082 8.74221 8.15826 8.81913 8.08583 8.87388C8.0134 8.92864 7.92507 8.95823 7.83427 8.95817H4.29552C4.18501 8.95817 4.07903 8.91427 4.00089 8.83613C3.92275 8.75799 3.87885 8.65201 3.87885 8.5415V4.45296Z" stroke="#666666" stroke-width="0.833333" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p id="like_count_' . $row['BD_SEQ'] . '" class="font-bold text-[9px] leading-[9px] text-[#666666]">0</p>
                        </button>
                    </div>
                    <div class="flex gap-5 items-center">
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">' . substr($row['MEM_ID'], 0, 3) . '***' . '</p>
                        <p class="font-medium text-xs leading-[14px] text-[#999999]">' . date('Y/m/d', strtotime($row['BD_REG_DATE'])) . '</p>
                    </div>
                    <div x-data="{
                            isCollapsed: true,
                            showButton: true,
                            init() {
                                this.showButton = $refs.contents.scrollHeight > 54 ? true : false;
                            }
                        }" class="flex flex-col w-full gap-2.5">
                        <p x-ref="contents" class="font-medium text-xs leading-[18px] text-[#666666]" x-bind:class="isCollapsed ? \'line-clamp-3\' : \'\'">' . $row['BD_CONT'] . '</p>
                        <button x-show="isCollapsed && showButton" class="flex flex-row gap-[3px] items-center" x-on:click="isCollapsed = false">
                            <p class="font-bold text-[11px] leading-[12px] text-black">더보기</p>
                            <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576043 0.435356 4.59757e-07 0.593667 4.53547e-07C0.751979 4.47336e-07 0.890501 0.0576043 1.00923 0.172811L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.011521 8.40016 0.011521C8.56259 0.011521 8.70317 0.0691244 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587557C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#333333"/>
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
                </div>
            </div>';
    }
    $result .= '</div>';

    // Pagination
    $result .= '
        <div class="mt-[30px] flex gap-[23px] justify-center items-center">
            <button type="button" onclick="searchReview(' . (($page - 1) < 0 ? '0' : $page - 1) . ')">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z" fill="black" />
                </svg>
            </button>
            <div class="flex gap-[9.6px] items-center">';
    for ($i = $start_page; $i <= $end_page; $i++) {
        $result .= '
            <button type="button" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] ' . ($i == $page ? 'bg-black' : 'bg-white') . '" onclick="searchReview(' . $i . ')">
                <p class="font-bold text-xs leading-[14px] text-center ' . ($i == $page ? 'text-white' : 'text-black') . '">' . $i . '</p>
            </button>';
    }
    $result .= '
            </div>
            <button type="button" onclick="searchReview(' . (($page + 1) > $last_page ? $last_page : $page + 1) . ')">
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
            <p class="font-bold text-[15px] leading-[17px] text-[#666666]">작성한 리뷰가 없습니다.</p>
        </div>';
}

echo $result;

?>