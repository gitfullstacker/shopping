<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?
$title = "FILTER";
$hide_right_showOption = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
$filter_categories = json_decode($_GET['filter_categories'], true) ?: array();
$filter_brands = json_decode($_GET['filter_brands'], true) ?: array();
$filter_sizes = json_decode($_GET['filter_sizes'], true) ?: array();
$filter_styles = json_decode($_GET['filter_styles'], true) ?: array();

$query = "SELECT * FROM " . $Tname . "comm_com_code where str_service = 'Y' and int_gubun = 2";
$brand_list_result = mysql_query($query);
?>

<div x-data="{
    showOption: 1,
    content: [
        {
            searchKey: '',
            list: []
        },
        {
            searchKey: '',
            list: [
                {
                    value: 2,
                    title: 'Rent',
                    ktitle: '렌트',
                    checked: false
                },
                {
                    value: 1,
                    title: 'Subscription',
                    ktitle: '구독',
                    checked: false
                },
                {
                    value: 3,
                    title: 'Used',
                    ktitle: '중고',
                    checked: false
                }
            ]
        },
        {
            searchKey: '',
            list: [
                <?php
                while ($row = mysql_fetch_assoc($brand_list_result)) {
                ?>
                    {
                        value: <?= $row['INT_NUMBER'] ?>,
                        title: '<?= $row['STR_CODE'] ?>',
                        ktitle: '<?= $row['STR_KCODE'] ?>',
                        checked: false
                    },
                <?php
                }
                ?>
            ]
        },
        {
            searchKey: '',
            list: [
                {
                    value: 'mini',
                    title: 'MINI',
                    ktitle: '미니',
                    checked: false
                },
                {
                    value: 'small',
                    title: 'SMALL',
                    ktitle: '스몰',
                    checked: false
                },
                {
                    value: 'medium',
                    title: 'MEDIUM',
                    ktitle: '미듐',
                    checked: false
                },
                {
                    value: 'large',
                    title: 'LARGE',
                    ktitle: '라지',
                    checked: false
                },
                {
                    value: 'clutch',
                    title: 'CLUTCH',
                    ktitle: '클러치',
                    checked: false
                }
            ]
        },
        {
            searchKey: '',
            list: [
                {
                    value: 'tote',
                    title: 'TOTE BAG',
                    ktitle: '토트백',
                    checked: false
                },
                {
                    value: 'shoulder',
                    title: 'SHOULDER BAG',
                    ktitle: '숄더백',
                    checked: false
                },
                {
                    value: 'top',
                    title: 'TOP HANDLE BAG',
                    ktitle: '탑 핸들백',
                    checked: false
                },
                {
                    value: 'bucket',
                    title: 'BUCKET BAG',
                    ktitle: '버킷백',
                    checked: false
                },
                {
                    value: 'hobo',
                    title: 'HOBO BAG',
                    ktitle: '호보백',
                    checked: false
                },
            ]
        }
    ],
    selectItem(index) {
        this.content[this.showOption].list[index].checked = !this.content[this.showOption].list[index].checked;

        if (this.content[this.showOption].list[index].checked) {
            switch (this.showOption) {
                case 1:
                    window.filter_categories.push(this.content[this.showOption].list[index].value);
                    break;
                case 2:
                    window.filter_brands.push(this.content[this.showOption].list[index].value);
                    break;
                case 3:
                    window.filter_sizes.push(this.content[this.showOption].list[index].value);
                    break;
                case 4:
                    window.filter_styles.push(this.content[this.showOption].list[index].value);
                    break;
            }
        } else {
            switch (this.showOption) {
                case 1:
                    window.filter_categories = window.filter_categories.filter(item => item !== this.content[this.showOption].list[index].value);
                    break;
                case 2:
                    window.filter_brands = window.filter_brands.filter(item => item !== this.content[this.showOption].list[index].value);
                    break;
                case 3:
                    window.filter_sizes = window.filter_sizes.filter(item => item !== this.content[this.showOption].list[index].value);
                    break;
                case 4:
                    window.filter_styles = window.filter_styles.filter(item => item !== this.content[this.showOption].list[index].value);
                    break;
            }
        }
    },
    removeSelectedItem(index) {
        this.content[this.showOption].list[index].checked = false;
    },
    initSelectedItem() {
        window.filter_categories = [];
        window.filter_brands = [];
        window.filter_sizes = [];
        window.filter_styles = [];
        for (var i = 1; i <= 4; i++) {
            this.content[i].list.forEach(function(item) {
                item.checked = false;
            });
        }
    },
    init() {
        selectedList = [
            [],
            <?= str_replace('"', "'", json_encode($filter_categories)) ?>,
            <?= str_replace('"', "'", json_encode($filter_brands)) ?>,
            <?= str_replace('"', "'", json_encode($filter_sizes)) ?>,
            <?= str_replace('"', "'", json_encode($filter_styles)) ?>
        ];
        for (var i = 1; i <= 4; i++) {
            this.content[i].list.forEach(function(item) {
                if (selectedList[i].includes(item.value)) {
                    item.checked = true;
                }
            });
        }
    }
}" class="flex flex-col w-full" style="height: calc(100vh - 56px);">
    <div class="flex flex-row w-full">
        <div class="flex flex-col w-[100px] h-full bg-[#F5F5F5]">
            <div class="w-full h-[52px] flex justify-center items-center border-b border-white" x-bind:class="showOption == 1 ? 'bg-white' : 'bg-[#F5F5F5]'" x-on:click="showOption = 1">
                <p class="font-bold text-base leading-[18px] text-center text-[#666666]">카테고리</p>
            </div>
            <div class="w-full h-[52px] flex justify-center items-center border-b border-white" x-bind:class="showOption == 2 ? 'bg-white' : 'bg-[#F5F5F5]'" x-on:click="showOption = 2">
                <p class="font-bold text-base leading-[18px] text-center text-[#666666]">브랜드</p>
            </div>
            <div class="w-full h-[52px] flex justify-center items-center border-b border-white" x-bind:class="showOption == 3 ? 'bg-white' : 'bg-[#F5F5F5]'" x-on:click="showOption = 3">
                <p class="font-bold text-base leading-[18px] text-center text-[#666666]">사이즈</p>
            </div>
            <div class="w-full h-[52px] flex justify-center items-center border-b border-white" x-bind:class="showOption == 4 ? 'bg-white' : 'bg-[#F5F5F5]'" x-on:click="showOption = 4">
                <p class="font-bold text-base leading-[18px] text-center text-[#666666]">스타일</p>
            </div>
        </div>
        <div class="flex flex-col grow">
            <div class="flex flex-col w-full px-[15px]">
                <template x-if="showOption == 2">
                    <div class="w-full h-[52px] flex justify-start items-center">
                        <div class="relative w-full">
                            <input type="text" class="w-full h-[38px] bg-[#F8F8F8] border border-solid border-[#E0E0E0] rounded-[4px] pl-3 pr-7 font-medium text-xs leading-[14px] placeholder:text-[#C4C4C4]" name="" id="brand_search" placeholder="브랜드를 검색하세요" x-model="content[showOption].searchKey">
                            <button class="absolute top-2.5 right-[10.5px]">
                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.2675 17.4201L12.6013 11.7539C13.6807 10.4566 14.2184 8.79307 14.1027 7.10939C13.987 5.42571 13.2268 3.85142 11.9801 2.71388C10.7334 1.57635 9.09628 0.963123 7.40908 1.00172C5.72187 1.04031 4.11446 1.72776 2.92111 2.92111C1.72776 4.11446 1.04031 5.72186 1.00172 7.40907C0.963123 9.09627 1.57636 10.7334 2.71389 11.9801C3.85143 13.2268 5.42571 13.987 7.10939 14.1027C8.79307 14.2184 10.4566 13.6807 11.7539 12.6013L17.4815 18.3289C17.5946 18.437 17.7457 18.4966 17.9022 18.4949C18.0587 18.4931 18.2084 18.4301 18.3191 18.3194C18.4298 18.2087 18.4928 18.0591 18.4945 17.9025C18.4963 17.746 18.4367 17.595 18.3285 17.4818L18.2675 17.4201ZM3.76748 11.3483C2.90084 10.4625 2.36777 9.30397 2.25891 8.06957C2.15005 6.83517 2.47212 5.60117 3.17038 4.57744C3.86863 3.5537 4.89994 2.80345 6.08891 2.45425C7.27788 2.10506 8.5511 2.1785 9.69204 2.66207C10.833 3.14565 11.7712 4.00951 12.3471 5.10673C12.923 6.20396 13.1011 7.46679 12.851 8.68049C12.601 9.89419 11.9382 10.9838 10.9755 11.764C10.0128 12.5442 8.80951 12.9669 7.57034 12.9601C6.86139 12.9562 6.16024 12.8117 5.50748 12.535C4.85473 12.2584 4.26331 11.855 3.76748 11.3483Z" fill="black" stroke="black" stroke-width="0.247219" stroke-miterlimit="10" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
                <div class="flex flex-col w-full overflow-auto" style="height: calc(100vh - 108px);">
                    <template x-for="(item, index) in content[showOption].list">
                        <template x-if="item.title.toLowerCase().includes(content[showOption].searchKey.toLowerCase()) || item.ktitle.toLowerCase().includes(content[showOption].searchKey.toLowerCase())">
                            <div class="w-full h-[52px] flex justify-start gap-[5px] items-center border-b border-[#E0E0E0] flex-none" x-on:click="selectItem(index);">
                                <div class="h-[14px] w-[14px] flex justify-center items-center border-[0.7px] border-solid border-[#DDDDDD] bg-white">
                                    <svg x-show="item.checked" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.91111 10.2667L11.3944 4.78333L10.3056 3.69444L5.91111 8.08889L3.69444 5.87222L2.60556 6.96111L5.91111 10.2667ZM0 14V0H14V14H0Z" fill="black" />
                                    </svg>
                                </div>
                                <template x-if="showOption == 1">
                                    <p class="font-bold text-base leading-[18px] text-[#666666]" x-text="item.ktitle">렌트</p>
                                </template>
                                <template x-if="showOption != 1">
                                    <div class="flex flex-col gap-[1.8px]">
                                        <label class="font-bold text-xs leading-[14px] text-black" x-text="item.title">렌트</label>
                                        <label class="font-semibold text-[10px] leading-[11px] text-[#9D9D9D]" x-text="item.ktitle">발렌시아가</label>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- 하단 메뉴 -->
    <div class="fixed bottom-0 w-full h-[66px] flex gap-[5px] px-[5px] py-2 bg-white border-t border-[#F4F4F4] max-w-[410px]">
        <button type="button" class="w-[50px] h-[50px] flex justify-center items-center bg-white border border-solid border-[#D9D9D9]" x-on:click="initSelectedItem()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.4078 0.913446C8.86371 0.310389 10.4241 0 12 0C15.9476 0 19.4589 1.90797 21.6 4.8582V1.2H24V9.6H15.6V7.2H20.2516C18.6653 4.34106 15.5658 2.4 12 2.4C10.7393 2.4 9.49096 2.64831 8.32624 3.13076C7.16151 3.6132 6.10322 4.32033 5.21178 5.21177C4.32033 6.10322 3.6132 7.16151 3.13076 8.32624C2.64831 9.49096 2.4 10.7393 2.4 12C2.4 13.2607 2.64831 14.509 3.13076 15.6738C3.6132 16.8385 4.32033 17.8968 5.21178 18.7882C6.10322 19.6797 7.16151 20.3868 8.32624 20.8692C9.49096 21.3517 10.7393 21.6 12 21.6C14.5461 21.6 16.9879 20.5886 18.7882 18.7882C20.5886 16.9879 21.6 14.5461 21.6 12H24C24 15.1826 22.7357 18.2348 20.4853 20.4853C18.2348 22.7357 15.1826 24 12 24C10.4241 24 8.86371 23.6896 7.4078 23.0866C5.95189 22.4835 4.62902 21.5996 3.51472 20.4853C2.40042 19.371 1.5165 18.0481 0.913446 16.5922C0.310389 15.1363 0 13.5759 0 12C0 10.4241 0.310389 8.86371 0.913446 7.4078C1.5165 5.95189 2.40042 4.62902 3.51472 3.51472C4.62902 2.40042 5.95189 1.5165 7.4078 0.913446Z" fill="black" />
            </svg>
        </button>
        <button type="button" class="grow h-[50px] flex justify-center items-center bg-black border border-solid border-[#D9D9D9]" onclick="searchProduct()">
            <p class="font-extrabold text-lg leading-5 text-center text-white">적용하기</p>
        </button>
    </div>
</div>
<script>
    window.filter_categories = <?= json_encode($filter_categories) ?>;
    window.filter_brands = <?= json_encode($filter_brands) ?>;
    window.filter_sizes = <?= json_encode($filter_sizes) ?>;
    window.filter_styles = <?= json_encode($filter_styles) ?>;

    function searchProduct() {
        url = "result.php";
        url += "?filter_categories=" + encodeURIComponent(JSON.stringify(filter_categories));
        url += "&filter_brands=" + encodeURIComponent(JSON.stringify(filter_brands));
        url += "&filter_sizes=" + encodeURIComponent(JSON.stringify(filter_sizes));
        url += "&filter_styles=" + encodeURIComponent(JSON.stringify(filter_styles));

        document.location.href = url;
    }
</script>