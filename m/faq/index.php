<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div x-data="{ menu: 0 }" class="mt-[30px] flex flex-col gap-[15px] w-full">
    <?php
    $SQL_QUERY =   'SELECT 
                        A.*
                    FROM 
                        ' . $Tname . 'comm_com_code A
                    WHERE 
                        A.INT_NUMBER IS NOT NULL AND A.INT_GUBUN=3';

    $code_list_result = mysql_query($SQL_QUERY);
    ?>
    <p class="font-extrabold text-lg leading-5 text-center text-black">FAQ</p>
    <div x-data="{
            searchKey: '<?= $_GET['search_key'] ?: '' ?>',
            search() {
                window.search_key = this.searchKey;
                searchAskWithKey();
            }
        }" class="px-[14px]">
        <div class="relative w-full">
            <input type="text" class="w-full h-[50px] bg-white border border-solid border-[#DDDDDD] pl-4 pr-7 font-bold text-xs leading-[14px] placeholder:text-[#666666]" x-model="searchKey" x-on:keydown.enter="search()" placeholder="궁금한 점을 검색해보세요!">
            <button class="absolute top-4 right-[18px]" x-on:click="search()">
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.2675 17.4201L12.6013 11.7539C13.6807 10.4566 14.2184 8.79307 14.1027 7.10939C13.987 5.42571 13.2268 3.85142 11.9801 2.71388C10.7334 1.57635 9.09628 0.963123 7.40908 1.00172C5.72187 1.04031 4.11446 1.72776 2.92111 2.92111C1.72776 4.11446 1.04031 5.72186 1.00172 7.40907C0.963123 9.09627 1.57636 10.7334 2.71389 11.9801C3.85143 13.2268 5.42571 13.987 7.10939 14.1027C8.79307 14.2184 10.4566 13.6807 11.7539 12.6013L17.4815 18.3289C17.5946 18.437 17.7457 18.4966 17.9022 18.4949C18.0587 18.4931 18.2084 18.4301 18.3191 18.3194C18.4298 18.2087 18.4928 18.0591 18.4945 17.9025C18.4963 17.746 18.4367 17.595 18.3285 17.4818L18.2675 17.4201ZM3.76748 11.3483C2.90084 10.4625 2.36777 9.30397 2.25891 8.06957C2.15005 6.83517 2.47212 5.60117 3.17038 4.57744C3.86863 3.5537 4.89994 2.80345 6.08891 2.45425C7.27788 2.10506 8.5511 2.1785 9.69204 2.66207C10.833 3.14565 11.7712 4.00951 12.3471 5.10673C12.923 6.20396 13.1011 7.46679 12.851 8.68049C12.601 9.89419 11.9382 10.9838 10.9755 11.764C10.0128 12.5442 8.80951 12.9669 7.57034 12.9601C6.86139 12.9562 6.16024 12.8117 5.50748 12.535C4.85473 12.2584 4.26331 11.855 3.76748 11.3483Z" fill="black" stroke="black" stroke-width="0.247219" stroke-miterlimit="10" />
                </svg>
            </button>
        </div>
    </div>

    <!-- 메뉴 -->
    <div class="flex overflow-x-auto px-[14px] py-[13px] border-t-[0.5px] border-b-[0.5px] border-[#E0E0E0]">
        <div class="flex gap-[35px] items-center">
            <p class="whitespace-nowrap font-bold text-xs leading-[14px] text-center" x-bind:class="menu == 0 ? 'text-black underline' : 'text-[#999999]'" x-on:click="menu = 0">자주찾는질문</p>
            <?php
            while ($row = mysql_fetch_assoc($code_list_result)) {
            ?>
                <p class="whitespace-nowrap font-bold text-xs leading-[14px] text-center" x-bind:class="menu == <?= $row['INT_NUMBER'] ?> ? 'text-black underline' : 'text-[#999999]'" x-on:click="menu = <?= $row['INT_NUMBER'] ?>"><?= $row['STR_CODE'] ?></p>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- 자주찾는질문 -->
    <div x-show="menu == 0" class="flex flex-col px-[14px] w-full" id="ask_list_0">
    </div>

    <?php
    mysql_data_seek($code_list_result, 0);
    while ($row = mysql_fetch_assoc($code_list_result)) {
    ?>
        <div x-show="menu == <?= $row['INT_NUMBER'] ?>" class="flex flex-col px-[14px] w-full" id="ask_list_<?= $row['INT_NUMBER'] ?>">
        </div>
    <?php
    }
    ?>
</div>

<?
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    filter_type = 'all';
    window.search_key = '';

    $(document).ready(function() {
        searchAsk(0, 0);
        <?php
        mysql_data_seek($code_list_result, 0);
        while ($row = mysql_fetch_assoc($code_list_result)) {
        ?>
            searchAsk(0, <?= $row['INT_NUMBER'] ?>);
        <?php
        }
        ?>
    });

    function searchAsk(page = 0, int_gubun = 0) {
        url = "get_ask_list.php";
        url += "?page=" + page;
        url += "&int_gubun=" + int_gubun;
        url += "&search_key=" + search_key;

        $.ajax({
            url: url,
            success: function(result) {
                $("#ask_list_" + int_gubun).html(result);
            }
        });
    }

    function searchAskWithKey() {
        searchAsk(0, 0);
        <?php
        mysql_data_seek($code_list_result, 0);
        while ($row = mysql_fetch_assoc($code_list_result)) {
        ?>
            searchAsk(0, <?= $row['INT_NUMBER'] ?>);
        <?php
        }
        ?>
    }
</script>