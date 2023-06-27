<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$product_type = $_GET['product_type'];
$per_page = 16;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$filter_discount = $_GET['filter_discount'] == 'true' ? true : false;
$filter_subscription = $_GET['filter_subscription'];
$filter_brands = json_decode($_GET['filter_brands'], true);
$filter_sizes = json_decode($_GET['filter_sizes'], true);
$filter_styles = json_decode($_GET['filter_styles'], true);
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$order_by = $_GET['order_by'];
$is_sub_membership = $_GET['is_sub_membership'] == 'true' ? true : false;

$FILTER_QUERY = 'A.STR_GOODCODE IS NOT NULL ';
$HAVING_QUERY = '';
if ($filter_discount == 'true') {
    $FILTER_QUERY .= 'AND A.INT_DISCOUNT IS NOT NULL ';
}
if ($filter_subscription == 'true') {
    $HAVING_QUERY .= 'HAVING COUNT(C.STR_SGOODCODE) > 0 ';
}
if (count($filter_brands) > 0) {
    $filter_brands_string = implode(',', $filter_brands);
    $FILTER_QUERY .= 'AND A.INT_BRAND IN (' . $filter_brands_string . ') ';
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
if ($start_date && $end_date) {
    $SQL_QUERY =    'SELECT 
                        A.STR_GOODCODE
                    FROM 
                        ' . $Tname . 'comm_goods_cart A
                    WHERE 
                        (STR_SDATE >= "' . $start_date . '" AND STR_EDATE <= "' . $end_date . '")
                        OR
                        (STR_SDATE <= "' . $start_date . '" AND STR_EDATE >= "' . $start_date . '")
                        OR
                        (STR_SDATE <= "' . $end_date . '" AND STR_EDATE >= "' . $end_date . '")
                        OR
                        (STR_SDATE <= "' . $start_date . '" AND STR_EDATE >= "' . $end_date . '")';

    $rented_list_result = mysql_query($SQL_QUERY);

    $str_goodcode_array = array();
    while ($row = mysql_fetch_assoc($rented_list_result)) {
        $str_goodcode_array[] = $row['STR_GOODCODE'];
    }

    $filter_rented_string = implode(',', $str_goodcode_array);

    if ($filter_rented_string) {
        $FILTER_QUERY .= 'AND A.STR_GOODCODE NOT IN (' . $filter_rented_string . ') ';
    }
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

// 금액정보 얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_site_info AS A
                WHERE
                    A.INT_NUMBER=1';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);

$SQL_QUERY =    'SELECT 
                    A.*, B.STR_CODE, COUNT(C.STR_SGOODCODE) AS RENT_NUM
                FROM 
                    ' . $Tname . 'comm_goods_master A
                LEFT JOIN
                    ' . $Tname . 'comm_com_code B
                ON
                    A.INT_BRAND=B.INT_NUMBER
                LEFT JOIN
                    ' . $Tname . 'comm_goods_master_sub C
                ON
                    A.STR_GOODCODE=C.STR_GOODCODE
                    AND C.STR_SGOODCODE NOT IN (SELECT DISTINCT(D.STR_SGOODCODE) FROM ' . $Tname . 'comm_goods_cart D WHERE D.INT_STATE NOT IN (0, 10, 11) AND D.STR_GOODCODE=A.STR_GOODCODE)
                    AND C.STR_SERVICE="Y"
                WHERE 
                    (A.STR_SERVICE="Y" OR A.STR_SERVICE="R") 
                    AND 
                    A.INT_TYPE=' . $product_type . ' 
                    AND 
                    ' . $FILTER_QUERY . '
                GROUP BY 
                    A.STR_GOODCODE
                ' . $HAVING_QUERY . '
                ORDER BY 
                    ' . $ORDERBY_QUERY . '
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$product_list_result = mysql_query($SQL_QUERY);

$result = '';
while ($row = mysql_fetch_assoc($product_list_result)) {
    $price = '';
    $color = '';

    $rented_content = '';
    if ($product_type == 1) {
        if ($row['RENT_NUM'] == 0) {
            $rented_content = '
                <div class="flex justify-center items-center w-full h-full bg-black bg-opacity-60 rounded-md absolute top-0 left-0">
                    <p class="font-bold text-xs leading-[14px] text-white text-center">RENTED</p>
                </div>
            ';
        } else {
            $rented_content = '';
        }
    }

    switch ($product_type) {
        case 1:
            $color = '#EEAC4C';
            
            if ($is_sub_membership) {
                $price = '';
            } else {
                $price = '
                    <div class="price-section w-full">
                        <p class="current-price"><span class="font-medium">월</span> ' . number_format($site_Data['INT_OPRICE1']) . '원</p>
                    </div>
                ';
            }

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
                ' . $rented_content . '
            </div>
            <p class="brand w-full">' . $row['STR_CODE'] . '</p>
            <p class="title w-full">' . $row['STR_GOODNAME'] . '</p>
            ' . $price . '
        </a>
    ';
}

echo $result;

?>