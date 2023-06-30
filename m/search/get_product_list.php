<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$per_page = 16;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$filter_categories = json_decode($_GET['filter_categories'], true);
$filter_brands = json_decode($_GET['filter_brands'], true);
$filter_sizes = json_decode($_GET['filter_sizes'], true);
$filter_styles = json_decode($_GET['filter_styles'], true);
$search_key = $_GET['search_key'] ?: '';

$order_by = $_GET['order_by'] ?: '';

$FILTER_QUERY = 'A.STR_GOODCODE IS NOT NULL ';
if (count($filter_categories) > 0) {
    $filter_categories_string = implode(',', $filter_categories);
    $FILTER_QUERY .= 'AND INT_TYPE IN (' . $filter_categories_string . ') ';
}
if (count($filter_brands) > 0) {
    $filter_brands_string = implode(',', $filter_brands);
    $FILTER_QUERY .= 'AND INT_BRAND IN (' . $filter_brands_string . ') ';
}
if (count($filter_sizes) > 0) {
    $filter_sizes_array = array();

    foreach ($filter_sizes as $item) {
        array_push($filter_sizes_array, 'A.STR_TSIZE LIKE "%' . $item . '%"');
    }
    $filter_sizes_string = implode(' OR ', $filter_sizes_array);
    $FILTER_QUERY .= 'AND (' . $filter_sizes_string . ') ';
}
if (count($filter_styles) > 0) {
    $filter_styles_array = array();

    foreach ($filter_styles as $item) {
        array_push($filter_styles_array, 'A.STR_STYLE LIKE "%' . $item . '%"');
    }
    $filter_styles_string = implode(' OR ', $filter_styles_array);
    $FILTER_QUERY .= 'AND (' . $filter_styles_string . ') ';
}
if ($search_key) {
    $FILTER_QUERY .= 'AND (A.STR_GOODNAME LIKE "%' . $search_key . '%" || B.STR_KCODE LIKE "%' . $search_key . '%" || B.STR_CODE LIKE "%' . $search_key . '%") ';
}

$ORDERBY_QUERY = 'A.INT_LIKE DESC ';
switch ($order_by) {
    case 'favorite':
        $ORDERBY_QUERY = 'A.INT_LIKE DESC ';
        break;
    case 'new':
        $ORDERBY_QUERY = 'A.DTM_INDATE DESC ';
        break;
    case 'recommend':
        $ORDERBY_QUERY = 'A.INT_LIKE DESC ';
        break;
    case 'price_low':
        $ORDERBY_QUERY = 'A.INT_PRICE ASC ';
        break;
    case 'price_high':
        $ORDERBY_QUERY = 'A.INT_PRICE DESC ';
        break;
}

$SQL_QUERY =    'SELECT 
                    A.*, B.STR_CODE, (SELECT COUNT(C.STR_GOODCODE) FROM ' . $Tname . 'comm_member_like AS C WHERE A.STR_GOODCODE=C.STR_GOODCODE AND C.STR_USERID="' . ($arr_Auth[0] ?: 'NULL') . '") AS IS_LIKE
                FROM 
                    ' . $Tname . 'comm_goods_master A
                LEFT JOIN
                    ' . $Tname . 'comm_com_code B
                ON
                    A.INT_BRAND=B.INT_NUMBER
                WHERE 
                    (A.STR_SERVICE="Y" OR A.STR_SERVICE="R")
                    AND 
                    ' . $FILTER_QUERY . '
                ORDER BY 
                    ' . $ORDERBY_QUERY . '
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$product_list_result = mysql_query($SQL_QUERY);
var_dump($SQL_QUERY);
// 금액정보 얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_site_info AS A
                WHERE
                    A.INT_NUMBER=1';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);

$result = '';
while ($row = mysql_fetch_assoc($product_list_result)) {
    switch ($row['INT_TYPE']) {
        case 1:
            $price = '
                <div class="mt-[8.4px] flex gap-1 items-center">
                    <p class="font-extrabold text-xs leading-[14px] text-[#EEAC4C] ' . ($row['INT_DISCOUNT'] ? '' : 'hidden') . '">' . $row['INT_DISCOUNT'] . '%</p>
                    <p class="font-bold text-xs leading-[14px] text-black">월 ' . number_format($site_Data['INT_OPRICE1']) . '원</p>
                </div>
            ';
            break;
        case 2:
            $price = '
                <div class="mt-[8.4px] flex gap-1 items-center">
                    <p class="font-extrabold text-xs leading-[14px] text-[#00402F] ' . ($row['INT_DISCOUNT'] ? '' : 'hidden') . '">' . $row['INT_DISCOUNT'] . '%</p>
                    <p class="font-bold text-xs leading-[14px] text-black">일 ' . number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) . '원</p>
                </div>
            ';
            break;
        case 3:
            $price = '
                <div class="mt-[8.4px] flex gap-1 items-center">
                    <p class="font-extrabold text-xs leading-[14px] text-[#7E6B5A] ' . ($row['INT_DISCOUNT'] ? '' : 'hidden') . '">' . $row['INT_DISCOUNT'] . '%</p>
                    <p class="font-bold text-xs leading-[14px] text-black">' . number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) . '원</p>
                </div>
            ';
            break;
    }

    $result .= '
        <a href="/m/product/detail.php?str_goodcode=' . $row['STR_GOODCODE'] . '" class="flex flex-col w-full">
            <div class="relative flex justify-center items-center w-[176px] h-[176px] p-2.5 bg-[#F9F9F9] rounded-[10px]">
                <img src="/admincenter/files/good/' . $row['STR_IMAGE1'] . '" onerror="this.style.display=\'none\'" alt="">
                <div class="absolute top-[11px] right-[11px] flex justify-center items-center w-4 h-4" onclick="setProductLike(' . $row['STR_GOODCODE'] . ')">
                    <svg id="is_like_no" style="' . ($row['IS_LIKE'] > 0 ? 'display:none;' : '') .'" width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.78561 16.7712L8.78511 16.7707C6.20323 14.4295 4.0883 12.5088 2.61474 10.706C1.14504 8.90792 0.35 7.26994 0.35 5.5C0.35 2.60372 2.61288 0.35 5.5 0.35C7.13419 0.35 8.70844 1.11256 9.73441 2.30795L10 2.6174L10.2656 2.30795C11.2916 1.11256 12.8658 0.35 14.5 0.35C17.3871 0.35 19.65 2.60372 19.65 5.5C19.65 7.26994 18.855 8.90792 17.3853 10.706C15.9117 12.5088 13.7968 14.4295 11.2149 16.7707L11.2144 16.7712L10 17.8767L8.78561 16.7712Z" stroke="#666666" stroke-width="0.7" />
                    </svg>
                    <svg id="is_like_yes" style="' . ($row['IS_LIKE'] > 0 ? '' : 'display:none;') . '" width="20" height="19" viewBox="0 0 20 19" fill="#FF0000" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.78561 16.7712L8.78511 16.7707C6.20323 14.4295 4.0883 12.5088 2.61474 10.706C1.14504 8.90792 0.35 7.26994 0.35 5.5C0.35 2.60372 2.61288 0.35 5.5 0.35C7.13419 0.35 8.70844 1.11256 9.73441 2.30795L10 2.6174L10.2656 2.30795C11.2916 1.11256 12.8658 0.35 14.5 0.35C17.3871 0.35 19.65 2.60372 19.65 5.5C19.65 7.26994 18.855 8.90792 17.3853 10.706C15.9117 12.5088 13.7968 14.4295 11.2149 16.7707L11.2144 16.7712L10 17.8767L8.78561 16.7712Z" stroke="#666666" stroke-width="0.7" />
                    </svg>
                </div>
            </div>
            <p class="mt-[5.5px] font-extrabold text-[9px] leading-[10px] text-[#666666]">' . $row['STR_CODE'] . '</p>
            <p class="mt-[3px] font-bold text-[9px] leading-[10px] text-[#333333]">' . $row['STR_GOODNAME'] . '</p>
            ' . $price . '
            <div class="mt-[10.5px] flex justify-center items-center w-[30px] h-4 bg-[' . ($row['INT_TYPE'] == 1 ? '#EEAC4C' : ($row['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A')) . ']">
                <p class="font-normal text-[9px] leading-[9px] text-center text-white">' . ($row['INT_TYPE'] == 1 ? '구독' : ($row['INT_TYPE'] == 2 ? '렌트' : '빈티지')) . '</p>
            </div>
        </a>
    ';
}

echo $result;

?>