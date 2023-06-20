<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$hide_header = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>

<?php
$filter_categories = json_decode($_GET['filter_categories'], true);
$filter_brands = json_decode($_GET['filter_brands'], true);
$filter_sizes = json_decode($_GET['filter_sizes'], true);
$filter_styles = json_decode($_GET['filter_styles'], true);
$search_key = $_GET['search_key'] ?: '';

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
    $FILTER_QUERY .= 'AND A.STR_GOODNAME LIKE "%' . $search_key . '%" ';
}

$SQL_QUERY = 'SELECT 
                COUNT(A.STR_GOODCODE) AS COUNT
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
    <div class="px-[12.5px] py-[13px] w-full bg-white border-b-[0.5px] border-solid border-[#E0E0E0]">
        <div x-data="{
            searchKey: '<?= $_GET['search_key'] ?: '' ?>',
            search() {
                window.search_key = this.searchKey;
                window.current_page = 1;
                searchProduct();
            }
        }" class="relative w-full">
            <input type="text" class="w-full h-[38px] bg-[#F8F8F8] border border-solid border-[#E0E0E0] rounded-[4px] pl-3 pr-7 font-bold text-xs leading-[14px] placeholder:text-[#C4C4C4]" x-model="searchKey" x-on:keydown.enter="search()" placeholder="검색어를 입력해주세요.">
            <button type="button" class="absolute top-2.5 right-[10.5px]" x-on:click="search()">
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.2675 17.4201L12.6013 11.7539C13.6807 10.4566 14.2184 8.79307 14.1027 7.10939C13.987 5.42571 13.2268 3.85142 11.9801 2.71388C10.7334 1.57635 9.09628 0.963123 7.40908 1.00172C5.72187 1.04031 4.11446 1.72776 2.92111 2.92111C1.72776 4.11446 1.04031 5.72186 1.00172 7.40907C0.963123 9.09627 1.57636 10.7334 2.71389 11.9801C3.85143 13.2268 5.42571 13.987 7.10939 14.1027C8.79307 14.2184 10.4566 13.6807 11.7539 12.6013L17.4815 18.3289C17.5946 18.437 17.7457 18.4966 17.9022 18.4949C18.0587 18.4931 18.2084 18.4301 18.3191 18.3194C18.4298 18.2087 18.4928 18.0591 18.4945 17.9025C18.4963 17.746 18.4367 17.595 18.3285 17.4818L18.2675 17.4201ZM3.76748 11.3483C2.90084 10.4625 2.36777 9.30397 2.25891 8.06957C2.15005 6.83517 2.47212 5.60117 3.17038 4.57744C3.86863 3.5537 4.89994 2.80345 6.08891 2.45425C7.27788 2.10506 8.5511 2.1785 9.69204 2.66207C10.833 3.14565 11.7712 4.00951 12.3471 5.10673C12.923 6.20396 13.1011 7.46679 12.851 8.68049C12.601 9.89419 11.9382 10.9838 10.9755 11.764C10.0128 12.5442 8.80951 12.9669 7.57034 12.9601C6.86139 12.9562 6.16024 12.8117 5.50748 12.535C4.85473 12.2584 4.26331 11.855 3.76748 11.3483Z" fill="black" stroke="black" stroke-width="0.247219" stroke-miterlimit="10" />
                </svg>
            </button>
        </div>
    </div>
    <div class="flex items-center justify-between px-[14px] border-b border-[#E0E0E0] h-[38px]">
        <div class="flex gap-[3px] items-center">
            <p class="font-bold text-xs leading-[14px] text-black">검색 결과</p>
            <p class="font-bold text-[10px] leading-[11px] text-[#9D9D9D]">(<?= $total_record ?>)</p>
        </div>
        <div class="flex gap-[15px]">
            <div x-data="{ 
                    showOrderBy: false,
                    selectedValue: 'favorite',
                    selectedTitle: '인기순',
                    orderList: [
                        {
                            value: 'favorite',
                            title: '인기순'
                        },
                        {
                            value: 'new',
                            title: '신상품순'
                        },
                        {
                            value: 'recommend',
                            title: '추천순'
                        },
                        {
                            value: 'price_low',
                            title: '낮은가격순'
                        },
                        {
                            value: 'price_high',
                            title: '높은가격순'
                        }
                    ],
                    changeOrderItem(value, title) {
                        this.selectedValue = value;
                        this.selectedTitle = title;
                        this.showOrderBy = false;

                        window.order_by = this.selectedValue;
                        window.current_page = 1;
                        searchProduct();
                    }
                }" class="flex gap-1 items-center relative">
                <p class="font-bold text-xs leading-[14px] text-[#999999]" x-text="selectedTitle" x-on:click="showOrderBy = true">
                    인기순
                </p>
                <div class="w-[9px] h-[9px] flex justify-center items-center">
                    <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576043 0.435356 4.59757e-07 0.593667 4.53547e-07C0.751979 4.47336e-07 0.890501 0.0576043 1.00923 0.172811L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.011521 8.40016 0.011521C8.56259 0.011521 8.70317 0.0691244 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587557C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#999999" />
                    </svg>
                </div>
                <div x-show="showOrderBy" class="absolute top-6 right-0 flex flex-col gap-1 items-center w-24 bg-white shadow-md z-10" style="display: none;" x-on:click.away="showOrderBy = false">
                    <template x-for="item in orderList">
                        <div class="flex justify-center py-1 font-bold text-xs leading-[14px] items-center text-[#999999]" x-text="item.title" x-on:click="changeOrderItem(item.value, item.title)">인기순</div>
                    </template>
                </div>
            </div>
            <button type="button" class="w-[58px] h-[25px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full" onclick="openFilter()">
                <p class="font-bold text-[11px] leading-[11px] flex items-center text-center text-[#666666]">FILTER</p>
            </button>
        </div>
    </div>
    <div class="flex items-center w-full gap-[5px] px-[14px] py-3 overflow-auto">
        <!-- 캐테고리 목록 -->
        <?php
        for ($i = 0; $i < count($filter_categories); $i++) {
        ?>
            <div class="flex-none flex justify-center items-center px-[15px] py-[7px] bg-white border border-solid border-[#DDDDDD] rounded-full">
                <p class="font-bold text-[11.7px] leading-[13px] flex items-center text-center text-[#666666]">
                    <?php
                    switch ($filter_categories[$i]) {
                        case 1:
                            echo '구독';
                            break;
                        case 2:
                            echo '렌트';
                            break;
                        case 3:
                            echo '중고';
                            break;
                    }
                    ?>
                </p>
            </div>
        <?php
        }
        ?>
        <!-- 브랜드 목록 -->
        <?php
        if (count($filter_brands) > 0) {
            $SQL_QUERY =    'SELECT 
                            A.STR_CODE
                        FROM 
                            ' . $Tname . 'comm_com_code A
                        WHERE 
                            A.INT_NUMBER IN (' . implode(',', $filter_brands) . ')';

            $brand_list_result = mysql_query($SQL_QUERY);

            while ($row = mysql_fetch_assoc($brand_list_result)) {
        ?>
                <div class="flex-none flex justify-center items-center px-[15px] py-[7px] bg-white border border-solid border-[#DDDDDD] rounded-full">
                    <p class="font-bold text-[11.7px] leading-[13px] flex items-center text-center text-[#666666]"><?= $row['STR_CODE'] ?></p>
                </div>
        <?php
            }
        }
        ?>
        <!-- 사이즈 목록 -->
        <?php
        for ($i = 0; $i < count($filter_sizes); $i++) {
        ?>
            <div class="flex-none flex justify-center items-center px-[15px] py-[7px] bg-white border border-solid border-[#DDDDDD] rounded-full">
                <p class="font-bold text-[11.7px] leading-[13px] flex items-center text-center text-[#666666]">
                    <?php
                    switch ($filter_sizes[$i]) {
                        case 'mini':
                            echo '미니';
                            break;
                        case 'small':
                            echo '스몰';
                            break;
                        case 'medium':
                            echo '미듐';
                            break;
                        case 'large':
                            echo '라지';
                            break;
                        case 'clutch':
                            echo '클러치';
                            break;
                    }
                    ?>
                </p>
            </div>
        <?php
        }
        ?>
        <!-- 스타일 목록 -->
        <?php
        for ($i = 0; $i < count($filter_styles); $i++) {
        ?>
            <div class="flex-none flex justify-center items-center px-[15px] py-[7px] bg-white border border-solid border-[#DDDDDD] rounded-full">
                <p class="font-bold text-[11.7px] leading-[13px] flex items-center text-center text-[#666666]">
                    <?php
                    switch ($filter_styles[$i]) {
                        case 'tote':
                            echo '토트백';
                            break;
                        case 'shoulder':
                            echo '숄더백';
                            break;
                        case 'top':
                            echo '탑 핸들백';
                            break;
                        case 'bucket':
                            echo '버킷백';
                            break;
                        case 'hobo':
                            echo '호보백';
                            break;
                    }
                    ?>
                </p>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="mt-[6px] grid grid-cols-2 gap-x-[13.5px] gap-y-[30px] w-full px-[14px]" id="product_list">
    </div>
    <?php
    if ($total_record > 0) {
    ?>
        <div class="mt-5 flex px-[14px] w-full" id="see_more_btn">
            <button class="w-full flex gap-[3px] justify-center items-center h-[38px] border-[0.7px] border-solid border-[#DDDDDD] bg-white rounded" onclick="seeMoreClick()">
                <span class="text-bold text-[11px] leading-[11px] text-black">더보기</span>
                <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.14661 1.33063L5.15716 5.21312C5.10967 5.2592 5.05822 5.29176 5.00281 5.31081C4.9474 5.33017 4.88803 5.33984 4.82471 5.33984C4.76138 5.33984 4.70202 5.33017 4.64661 5.31081C4.5912 5.29176 4.53975 5.2592 4.49225 5.21312L0.490934 1.33063C0.380116 1.2231 0.324707 1.08869 0.324707 0.927402C0.324707 0.766111 0.384074 0.627863 0.502807 0.512655C0.621541 0.397448 0.760063 0.339844 0.918374 0.339844C1.07669 0.339844 1.21521 0.397448 1.33394 0.512655L4.82471 3.89975L8.31547 0.512655C8.42629 0.405128 8.56275 0.351365 8.72486 0.351365C8.88729 0.351365 9.02787 0.408968 9.14661 0.524176C9.26534 0.639383 9.32471 0.773791 9.32471 0.927401C9.32471 1.08101 9.26534 1.21542 9.14661 1.33063Z" fill="#333333" />
                </svg>
            </button>
        </div>
    <?php
    }
    ?>
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
    order_by = '<?= $_GET['order_by'] ?: 'favorite' ?>';
    search_key = '<?= $_GET['search_key'] ?: '' ?>';

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
        url += "&search_key=" + search_key;

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

        if (<?= $total_record ?: 0 ?> <= (current_page * 16)) {
            document.getElementById('see_more_btn').classList.add('hidden');
        } else {
            document.getElementById('see_more_btn').classList.remove('hidden');
        }
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

                    const str_url = encodeURIComponent(window.location.pathname + window.location.search);
                    document.location.href = "/m/memberjoin/login.php?loc=" + str_url;
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
        url = "filter.php";
        url += "?filter_categories=" + encodeURIComponent(JSON.stringify(filter_categories));
        url += "&filter_brands=" + encodeURIComponent(JSON.stringify(filter_brands));
        url += "&filter_sizes=" + encodeURIComponent(JSON.stringify(filter_sizes));
        url += "&filter_styles=" + encodeURIComponent(JSON.stringify(filter_styles));

        location.href = url;
    }
</script>