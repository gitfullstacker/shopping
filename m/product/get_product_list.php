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

$product_list_result = mysql_query($SQL_QUERY);

$result = '';
while ($row = mysql_fetch_assoc($product_list_result)) {
    $price = '';
    $color = '';
    switch ($product_type) {
        case 1:
            $color = '#EEAC4C';
            $price = '
                <div class="price-section w-full">
                    <p class="current-price"><span class="font-medium">월</span> ' . number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) . '원</p>
                    <p class="origin-price ' . ($row['INT_DISCOUNT'] ? '' : 'hidden') . '">' . number_format($row['INT_PRICE']) . '원</p>
                </div>
            ';
            break;
        case 2:
            $color = '#00402F';
            $price = '
                <div class="price-section w-full">
                    <p class="current-price"><span class="font-medium">일</span> ' . number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) . '원</p>
                    <p class="origin-price ' . ($row['INT_DISCOUNT'] ? '' : 'hidden') . '">' . number_format($row['INT_PRICE']) . '원</p>
                </div>
            ';
            break;
        case 3:
            $color = '#7E6B5A';
            $price = '
                <div class="price-section w-full">
                    <p class="current-price">' . number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) . '원</p>
                    <p class="origin-price ' . ($row['INT_DISCOUNT'] ? '' : 'hidden') . '">' . number_format($row['INT_PRICE']) . '원</p>
                </div>
            ';
            break;
    }

    $result .= '
        <a href="detail.php?str_goodcode=' . $row['STR_GOODCODE'] . '" class="global-product-item">
            <div class="relative flex justify-center items-center w-[176px] h-[176px] p-2.5 bg-[#F9F9F9] rounded-md">
                <img class="w-full" src="/admincenter/files/good/' . $row['STR_IMAGE1'] . '" alt="">
                <div class="absolute top-2 left-2 w-[30px] h-[30px] flex justify-center items-center bg-[' . $color . '] ' . ($row['INT_DISCOUNT'] ? '' : 'hidden') . '">
                    <p class="font-extrabold text-[9px] leading-[10px] text-white">' . $row['INT_DISCOUNT'] . '%</p>
                </div>
            </div>
            <p class="brand w-full">' . $row['STR_CODE'] . '</p>
            <p class="title w-full">' . $row['STR_GOODNAME'] . '</p>
            ' . $price . '
        </a>
    ';
}

echo $result;

?>