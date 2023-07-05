<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?
$header_title = '검색';
$hide_header = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>

<div class="flex flex-col w-full px-[14px]">
    <div x-data="{
            searchKey: '',
            search() {
                searchByKey(this.searchKey);
            }
        }" class="mt-[11.26px] relative w-full">
        <input type="text" class="w-full h-[38px] bg-[#F8F8F8] border border-solid border-[#E0E0E0] rounded-[4px] pl-3 pr-7 font-medium text-xs leading-[14px] placeholder:text-[#C4C4C4]" x-model="searchKey" x-on:keydown.enter="search()" placeholder="검색어를 입력해주세요.">
        <button type="button" class="absolute top-2.5 right-[10.5px]" x-on:click="search()">
            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.2675 17.4201L12.6013 11.7539C13.6807 10.4566 14.2184 8.79307 14.1027 7.10939C13.987 5.42571 13.2268 3.85142 11.9801 2.71388C10.7334 1.57635 9.09628 0.963123 7.40908 1.00172C5.72187 1.04031 4.11446 1.72776 2.92111 2.92111C1.72776 4.11446 1.04031 5.72186 1.00172 7.40907C0.963123 9.09627 1.57636 10.7334 2.71389 11.9801C3.85143 13.2268 5.42571 13.987 7.10939 14.1027C8.79307 14.2184 10.4566 13.6807 11.7539 12.6013L17.4815 18.3289C17.5946 18.437 17.7457 18.4966 17.9022 18.4949C18.0587 18.4931 18.2084 18.4301 18.3191 18.3194C18.4298 18.2087 18.4928 18.0591 18.4945 17.9025C18.4963 17.746 18.4367 17.595 18.3285 17.4818L18.2675 17.4201ZM3.76748 11.3483C2.90084 10.4625 2.36777 9.30397 2.25891 8.06957C2.15005 6.83517 2.47212 5.60117 3.17038 4.57744C3.86863 3.5537 4.89994 2.80345 6.08891 2.45425C7.27788 2.10506 8.5511 2.1785 9.69204 2.66207C10.833 3.14565 11.7712 4.00951 12.3471 5.10673C12.923 6.20396 13.1011 7.46679 12.851 8.68049C12.601 9.89419 11.9382 10.9838 10.9755 11.764C10.0128 12.5442 8.80951 12.9669 7.57034 12.9601C6.86139 12.9562 6.16024 12.8117 5.50748 12.535C4.85473 12.2584 4.26331 11.855 3.76748 11.3483Z" fill="black" stroke="black" stroke-width="0.247219" stroke-miterlimit="10" />
            </svg>
        </button>
    </div>

    <!-- 최근 검색어 -->
    <div class="mt-[25.17px] flex flex-col w-full gap-5">
        <p class="font-extrabold text-lg leading-5 text-[#333333]">최근 검색어</p>
        <?php
        $searchHistory = isset($_COOKIE['SEARCH_KEY_DATA']) ? unserialize(stripslashes($_COOKIE['SEARCH_KEY_DATA'])) : array();

        if (count($searchHistory) > 0) {
        ?>
            <div class="grid grid-cols-2 gap-0.5 w-full">
                <?php
                foreach ($searchHistory as $key => $value) {
                ?>
                    <div class="flex w-full <?= $key % 2 == 1 ? 'border-l border-black' : '' ?>">
                        <button class="flex flex-col gap-0.5 px-3 py-[7px] w-full" onclick="searchByKey('<?= $value ?>')">
                            <p class="font-bold text-xs leading-[14px] text-black"><?= $value ?></p>
                        </button>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        } else {
        ?>
            <p class="font-semibold text-xs leading-[14px] text-[#9D9D9D]">최근 검색어가 없습니다.</p>
        <?php
        }
        ?>
    </div>

    <!-- BRAND -->
    <div class="mt-[46.57px] flex flex-col w-full gap-5">
        <p class="font-extrabold text-lg leading-5 text-[#333333]">BRAND</p>
        <div class="grid grid-cols-2 gap-0.5 w-full">
            <?php
            $query = "SELECT * FROM " . $Tname . "comm_com_code where str_service = 'Y' and int_gubun = 2";
            $brand_list_result = mysql_query($query);

            while ($row = mysql_fetch_assoc($brand_list_result)) {
            ?>
                <button class="flex flex-col gap-0.5 px-3 py-[7px] bg-[#F8F8F8]" onclick="searchProduct(<?= $row['INT_NUMBER'] ?>)">
                    <p class="font-bold text-xs leading-[14px] text-black"><?= $row['STR_CODE'] ?></p>
                    <p class="font-semibold text-[10px] leading-[11px] text-[#9D9D9D]"><?= $row['STR_KCODE'] ?></p>
                </button>
            <?php
            }
            ?>
        </div>
    </div>

    <img class="mt-[45px] min-w-full" src="images/search_banner.png" alt="">
</div>

<?
$hide_footer_content = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    current_page = 1;

    function searchByKey(search_key) {
        url = "result_before.php";
        url += "?search_key=" + search_key;

        document.location.href = url;
    }

    function searchProduct(int_brand = '') {
        url = "result.php";
        url += "?filter_brands=" + (int_brand ? encodeURIComponent(JSON.stringify([int_brand])) : '');

        document.location.href = url;
    }
</script>