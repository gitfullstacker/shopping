<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$product_type = $_GET['product_type'];
$per_page = 16;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$filter_discount = $_GET['filter_discount'];
$filter_brands = json_decode($_GET['filter_brands'], true);
$filter_sizes = json_decode($_GET['filter_sizes'], true);
$filter_styles = json_decode($_GET['filter_styles'], true);

$order_by = $_GET['order_by'];

$FILTER_QUERY = 'A.STR_GOODCODE IS NOT NULL ';
if ($filter_discount == 'true') {
    $FILTER_QUERY .= 'AND INT_DISCOUNT IS NOT NULL ';
}
if (count($filter_brands) > 0) {
    $filter_brands_string = implode(',', $filter_brands);
    $FILTER_QUERY .= 'AND INT_BRAND IN (' . $filter_brands_string . ') ';
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

$SQL_QUERY = 'SELECT 
                A.*, B.STR_CODE
                FROM 
                ' . $Tname . 'comm_goods_master A
                LEFT JOIN
                ' . $Tname . 'comm_com_code B
                ON
                A.INT_BRAND=B.INT_NUMBER
                WHERE 
                (A.STR_SERVICE="Y" OR A.STR_SERVICE="R") 
                AND 
                A.INT_TYPE=' . $product_type . ' 
                AND 
                ' . $FILTER_QUERY . '
                ORDER BY 
                ' . $ORDERBY_QUERY . '
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$arr_Data = mysql_query($SQL_QUERY);
$arr_Data_Cnt = mysql_num_rows($arr_Data);

$result = '';
for ($int_J = 0; $int_J < $arr_Data_Cnt; $int_J++) {
    switch ($product_type) {
        case 1:
            $price = '
                <div class="price-section w-full">
                    <p class="current-price">일 ' . number_format(mysql_result($arr_Data, $int_J, 'INT_PRICE') * (mysql_result($arr_Data, $int_J, 'INT_DISCOUNT') ?: 1)) . '원</p>
                    <p class="origin-price ' . (mysql_result($arr_Data, $int_J, 'INT_DISCOUNT') ? '' : 'hidden') . '">' . number_format(mysql_result($arr_Data, $int_J, 'INT_PRICE')) . '원</p>
                </div>
            ';
            break;
        case 2:
            $price = '
                <div class="price-section w-full">
                    <p class="current-price">월 ' . number_format(mysql_result($arr_Data, $int_J, 'INT_PRICE')) . '원</p>
                </div>
            ';
            break;
        case 3:
            $price = '
                <div class="price-section w-full">
                    <p class="current-price">' . number_format(mysql_result($arr_Data, $int_J, 'INT_PRICE') * (mysql_result($arr_Data, $int_J, 'INT_DISCOUNT') ?: 1)) . '원</p>
                    <p class="origin-price ' . (mysql_result($arr_Data, $int_J, 'INT_DISCOUNT') ? '' : 'hidden') . '">' . number_format(mysql_result($arr_Data, $int_J, 'INT_PRICE')) . '원</p>
                </div>
            ';
            break;
    }

    $result .= '
        <a href="detail.php?str_goodcode=' . mysql_result($arr_Data, $int_J, 'STR_GOODCODE') . '" class="global-product-item">
            <div class="relative flex justify-center items-center w-[176px] h-[176px] p-2.5 bg-[#F9F9F9] rounded-md">
                <img class="w-full" src="/admincenter/files/good/' . mysql_result($arr_Data, $int_J, 'STR_IMAGE1') . '" alt="">
                <div class="absolute top-2 left-2 w-[25px] h-[25px] flex justify-center items-center bg-[#00402F] ' . (mysql_result($arr_Data, $int_J, 'INT_DISCOUNT') ? '' : 'hidden') . '">
                    <p class="font-extrabold text-[9px] leading-[10px] text-white">' . mysql_result($arr_Data, $int_J, 'INT_DISCOUNT') . '%</p>
                </div>
            </div>
            <p class="brand w-full">' . mysql_result($arr_Data, $int_J, 'STR_CODE') . '</p>
            <p class="title w-full">' . mysql_result($arr_Data, $int_J, 'STR_GOODNAME') . '</p>
            ' . $price . '
        </a>
    ';
}

echo $result;

?>