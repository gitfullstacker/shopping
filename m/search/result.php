<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$search_menu = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>

<?php
$filter_categories = json_decode($_GET['filter_categories'], true);
$filter_brands = json_decode($_GET['filter_brands'], true);
$filter_sizes = json_decode($_GET['filter_sizes'], true);
$filter_styles = json_decode($_GET['filter_styles'], true);

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

$SQL_QUERY = 'SELECT 
                COUNT(A.STR_GOODCODE)
                FROM 
                ' . $Tname . 'comm_goods_master A
                WHERE 
                (A.STR_SERVICE="Y" OR A.STR_SERVICE="R") 
                AND 
                ' . $FILTER_QUERY;

$result = mysql_query($SQL_QUERY);

if (!$result) {
    error("QUERY_ERROR");
    exit;
}

$total_record = mysql_result($result, 0, 0);
?>

<div class="flex flex-col w-full">
    <div class="flex items-center justify-between px-[14px] border-b border-[#E0E0E0] h-[38px]">
        <div class="flex gap-[3px] items-center">
            <p class="font-bold text-xs leading-[14px] text-black">검색 결과</p>
            <p class="font-bold text-[10px] leading-[11px] text-[#9D9D9D]">(<?= $total_record ?>)</p>
        </div>
        <div class="flex gap-[15px]">
            <div class="relative flex items-center">
                <select class="block appearance-none w-full pr-3 active:outline-none focus-visible:outline-none">
                    <option>추천순</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pointer-events-none">
                    <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576043 0.435356 4.59757e-07 0.593667 4.53547e-07C0.751979 4.47336e-07 0.890501 0.0576043 1.00923 0.172811L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.011521 8.40016 0.011521C8.56259 0.011521 8.70317 0.0691244 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587557C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#999999" />
                    </svg>
                </div>
            </div>
            <button type="button" class="w-[58px] h-[25px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full" onclick="openFilter()">
                <p class="font-bold text-[11px] leading-[11px] flex items-center text-center text-[#666666]">FILTER</p>
            </button>
        </div>
    </div>
    <div class="flex items-center w-full gap-[5px] px-[14px] py-3">
        <?php
        for ($i = 0; $i < 5; $i++) {
        ?>
            <div class="flex justify-center items-center px-[15px] py-[7px] bg-white border border-solid border-[#DDDDDD] rounded-full">
                <p class="font-bold text-[11.7px] leading-[13px] flex items-center text-center text-[#666666]">렌트</p>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="mt-[6px] grid grid-cols-2 gap-x-[13.5px] gap-y-[30px] w-full px-[14px]" id="product_list">
    </div>
</div>

<?
$hide_footer_content = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    current_page = 1;
    window.filter_categories = <?= $_GET['filter_categories'] ?: '[]' ?>;
    window.filter_brands = <?= $_GET['filter_brands'] ?: '[]' ?>;
    window.filter_sizes = <?= $_GET['filter_sizes'] ?: '[]' ?>;
    window.filter_styles = <?= $_GET['filter_styles'] ?: '[]' ?>;
    order_by = 'favorite';

    $(document).ready(function() {
        searchProduct();
    });

    function searchProduct(append = false) {
        url = "get_product_list.php";
        url += "?page=" + current_page;
        url += "&filter_categories=" + encodeURIComponent(JSON.stringify(filter_categories));
        url += "&filter_brands=" + encodeURIComponent(JSON.stringify(filter_brands));
        url += "&filter_sizes=" + encodeURIComponent(JSON.stringify(filter_sizes));
        url += "&filter_styles=" + encodeURIComponent(JSON.stringify(filter_styles));
        url += "&order_by=" + order_by;

        $.ajax({
            url: url,
            success: function(result) {
                if (append) {
                    $("#product_list").append(result);
                } else {
                    $("#product_list").html(result);
                }
            }
        });
    }

    function seeMoreClick() {
        current_page++;

        searchProduct(true);
    }

    function setProductLike(str_goodcode) {
        $.ajax({
            url: "/m/product/set_like.php",
            data: {
                str_goodcode: str_goodcode
            },
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');
                    return;
                }
                if (result['status'] == 200) {
                    Alpine.$data.liked = 'false';
                    if (result['data'] == true) {
                        $("#is_like_no").hide();
                        $("#is_like_yes").show();
                    }
                    if (result['data'] == false) {
                        $("#is_like_no").show();
                        $("#is_like_yes").hide();
                    }
                }
            }
        });
    }

    function openFilter() {
        url = "index.php";
        url += "?filter_categories=" + encodeURIComponent(JSON.stringify(filter_categories));
        url += "&filter_brands=" + encodeURIComponent(JSON.stringify(filter_brands));
        url += "&filter_sizes=" + encodeURIComponent(JSON.stringify(filter_sizes));
        url += "&filter_styles=" + encodeURIComponent(JSON.stringify(filter_styles));
        
        location.href = url;
    }
</script>