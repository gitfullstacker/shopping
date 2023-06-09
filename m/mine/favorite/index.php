<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
$header_title = '찜 입고 알림 내역/찜한 상품';
$hide_header = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>

<?php
$SQL_QUERY =    'SELECT 
                    A.*, B.STR_CODE
                FROM 
                    ' . $Tname . 'comm_goods_master A
                LEFT JOIN
                    ' . $Tname . 'comm_com_code B
                ON
                    A.INT_BRAND=B.INT_NUMBER
                LEFT JOIN
                    ' . $Tname . 'comm_member_like C
                ON
                    A.STR_GOODCODE=C.STR_GOODCODE
                WHERE 
                    (A.STR_SERVICE="Y" OR A.STR_SERVICE="R") 
                AND 
                    C.STR_USERID="' . $arr_Auth[0] . '"';

$product_result = mysql_query($SQL_QUERY);
?>

<div class="mt-1.5 flex flex-col w-full h-screen px-[14px]">
    <div x-data="{ type: 1 }" class="flex flex-col w-full">
        <div class="flex justify-between">
            <div class="flex gap-[7px] items-center">
                <button class="flex px-[15px] py-[7px] bg-white border border-solid rounded-full" x-bind:class="type == 1 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="type = 1">
                    <p class="font-bold text-xs leading-[14px] flex items-center text-center" x-bind:class="type == 1 ? 'text-black' : 'text-[#666666]'">입고알림</p>
                </button>
                <button class="flex px-[15px] py-[7px] bg-white border border-solid rounded-full" x-bind:class="type == 2 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="type = 2">
                    <p class="font-bold text-xs leading-[14px] flex items-center text-center" x-bind:class="type == 2 ? 'text-black' : 'text-[#666666]'">찜</p>
                </button>
            </div>
            <button type="button" onclick="removeLikeAll()">
                <p class="font-bold text-xs leading-[14px] underline text-[#666666]">전체삭제</p>
            </button>
        </div>


        <!-- 입고알람 -->
        <div x-data="{ noData: true }" x-show="type == 1" class="mt-[18px] flex flex-col w-full" style="display: none;">
            <div x-show="noData" id="no_alert_list" class="flex flex-col gap-5 items-center mt-[77px]">
                <svg width="65" height="71" viewBox="0 0 65 71" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M49.6053 37.1905C45.5223 37.1905 41.6066 38.7934 38.7195 41.6466C35.8325 44.4999 34.2105 48.3697 34.2105 52.4048C34.2105 56.4398 35.8325 60.3097 38.7195 63.1629C41.6066 66.0161 45.5223 67.619 49.6053 67.619C53.6882 67.619 57.6039 66.0161 60.491 63.1629C63.3781 60.3097 65 56.4398 65 52.4048C65 48.3697 63.3781 44.4999 60.491 41.6466C57.6039 38.7934 53.6882 37.1905 49.6053 37.1905ZM49.6053 42.2619C52.3272 42.2619 54.9377 43.3305 56.8624 45.2327C58.7871 47.1348 59.8684 49.7147 59.8684 52.4048C59.8497 54.1908 59.354 55.9402 58.4316 57.4762L44.4737 43.6819C46.0279 42.7703 47.7981 42.2805 49.6053 42.2619ZM40.7789 47.3333L54.7368 61.1276C53.1827 62.0392 51.4125 62.5291 49.6053 62.5476C46.8833 62.5476 44.2728 61.479 42.3481 59.5768C40.4234 57.6747 39.3421 55.0948 39.3421 52.4048C39.3609 50.6187 39.8565 48.8693 40.7789 47.3333ZM30.7895 0C27.0263 0 23.9474 3.04286 23.9474 6.7619V7.74238C14.0947 10.6162 6.84211 19.6771 6.84211 30.4286V50.7143L0 57.4762V60.8571H29.0789C28.1837 58.7017 27.6409 56.4192 27.4711 54.0952H13.6842V30.4286C13.6842 25.9452 15.4864 21.6454 18.6942 18.4751C21.9021 15.3048 26.2529 13.5238 30.7895 13.5238C35.3261 13.5238 39.6769 15.3048 42.8847 18.4751C46.0926 21.6454 47.8947 25.9452 47.8947 30.4286C48.4647 30.4069 49.0353 30.4069 49.6053 30.4286C51.3339 30.4336 53.0561 30.6379 54.7368 31.0371V30.4286C54.7368 19.6771 47.4842 10.6162 37.6316 7.74238V6.7619C37.6316 4.96854 36.9107 3.24862 35.6276 1.98052C34.3444 0.712413 32.6041 0 30.7895 0ZM23.9474 64.2381C23.9474 66.0315 24.6682 67.7514 25.9514 69.0195C27.2345 70.2876 28.9748 71 30.7895 71C32.5 71 34.1079 70.3576 35.3395 69.3095C33.603 67.854 32.1031 66.1436 30.8921 64.2381H23.9474Z" fill="#D9D9D9" />
                </svg>
                <p class="font-bold text-[15px] leading-[17px] text-[#666666]">입고알림 상품이 없습니다.</p>
            </div>
            <div x-show="!noData" id="alert_list" class="grid grid-cols-2 gap-x-[13.5px] gap-y-[30px]">
            </div>
        </div>

        <!-- 찜목록 -->
        <div x-data="{ noData: <?= mysql_num_rows($product_result) > 0 ? 'false' : 'true' ?> }" x-show="type == 2" class="mt-[18px] flex flex-col w-full" style="display: none;">
            <div x-show="noData" id="no_product_list" class="flex flex-col gap-5 items-center mt-[77px]">
                <svg width="74" height="69" viewBox="0 0 74 69" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M39.479 66.0226L37 68.2929L31.635 63.3803C12.58 46 0 34.5 0 20.4693C0 8.96926 8.954 0 20.35 0C26.788 0 32.967 3.01456 37 7.7411C41.033 3.01456 47.212 0 53.65 0C65.046 0 74 8.96926 74 20.4693C74 25.7913 72.15 30.7411 68.894 35.7654C66.6 34.6489 64.047 33.9045 61.383 33.644C64.75 29.0291 66.6 24.7492 66.6 20.4693C66.6 13.0259 61.05 7.44337 53.65 7.44337C47.952 7.44337 42.402 11.165 40.441 16.2265H33.559C31.598 11.165 26.048 7.44337 20.35 7.44337C12.95 7.44337 7.4 13.0259 7.4 20.4693C7.4 31.2249 19.018 41.8317 36.593 57.8722L37 58.2443L37.148 58.0955C37.444 60.9239 38.258 63.6036 39.479 66.0226ZM67.044 42.6505L59.2 50.5777L51.356 42.6877L46.139 47.9353L53.983 55.8252L46.139 63.7152L51.356 69L59.2 61.0728L67.044 69L72.298 63.7152L64.417 55.8252L72.298 47.9353L67.044 42.6505Z" fill="#D9D9D9" />
                </svg>
                <p class="font-bold text-[15px] leading-[17px] text-[#666666]">찜한 상품이 없습니다.</p>
            </div>
            <div x-show="!noData" id="product_list" class="grid grid-cols-2 gap-x-[13.5px] gap-y-[30px]">
                <?php
                while ($row = mysql_fetch_assoc($product_result)) {
                ?>
                    <!-- 상품 -->
                    <div class="flex flex-col w-full" id="product_item_<?= $row['STR_GOODCODE'] ?>">
                        <div class="relative flex justify-center items-center w-full h-[176px] p-2.5 bg-[#F9F9F9] rounded-[6px]">
                            <img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" alt="product">
                            <div class="absolute top-[11px] right-[11px] flex justify-center items-center w-4 h-4" onclick="setLike(<?= $row['STR_GOODCODE'] ?>)">
                                <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 15L6.84 13.921C2.72 10.1035 0 7.57766 0 4.49591C0 1.97003 1.936 0 4.4 0C5.792 0 7.128 0.662125 8 1.70027C8.872 0.662125 10.208 0 11.6 0C14.064 0 16 1.97003 16 4.49591C16 7.57766 13.28 10.1035 9.16 13.921L8 15Z" fill="#FF1F4B" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-[5.5px] font-extrabold text-xs leading-[14px] text-[#666666]"><?= $row['STR_CODE'] ?></p>
                        <p class="mt-[3px] font-medium text-xs leading-[14px] text-[#333333]"><?= $row['STR_GOODNAME'] ?></p>
                        <?php
                        switch ($row['INT_TYPE']) {
                            case 1:
                        ?>
                                <div class="mt-[8.4px] flex gap-1 items-center">
                                    <p class="font-extrabold text-[13px] leading-[15px] text-[#EEAC4C]"><?= $row['INT_DISCOUNT'] ? $row['INT_DISCOUNT'] . '%' : '' ?></p>
                                    <p class="font-bold text-[13px] leading-[15px] text-black"><span class="font-medium">월</span> <?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원</p>
                                </div>
                                <div class="mt-[10.5px] flex justify-center items-center w-[30px] h-4 bg-[#EEAC4C]">
                                    <p class="font-normal text-[9px] leading-[9px] text-center text-white">구독</p>
                                </div>
                            <?php
                                break;

                            case 2:
                            ?>
                                <div class="mt-[8.4px] flex gap-1 items-center">
                                    <p class="font-extrabold text-[13px] leading-[15px] text-[#00402F]"><?= $row['INT_DISCOUNT'] ? $row['INT_DISCOUNT'] . '%' : '' ?></p>
                                    <p class="font-bold text-[13px] leading-[15px] text-black"><span class="font-medium">일</span> <?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원</p>
                                </div>
                                <div class="mt-[10.5px] flex justify-center items-center w-[30px] h-4 bg-[#00402F]">
                                    <p class="font-normal text-[9px] leading-[9px] text-center text-white">렌트</p>
                                </div>
                            <?php
                                break;
                            case 3:
                            ?>
                                <div class="mt-[8.4px] flex gap-1 items-center">
                                    <p class="font-extrabold text-[13px] leading-[15px] text-[#7E6B5A]"><?= $row['INT_DISCOUNT'] ? $row['INT_DISCOUNT'] . '%' : '' ?></p>
                                    <p class="font-bold text-[13px] leading-[15px] text-black"><?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원</p>
                                </div>
                                <div class="mt-[10.5px] flex justify-center items-center w-[30px] h-4 bg-[#7E6B5A]">
                                    <p class="font-normal text-[9px] leading-[9px] text-center text-white">빈티지</p>
                                </div>
                        <?php
                                break;
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    function setLike(str_goodcode) {
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
                    if (result['data'] == false) {
                        $("#product_item_" + str_goodcode).hide();
                    }
                }
            }
        });
    }

    function removeLikeAll() {
        $.ajax({
            url: "/m/product/set_like.php",
            data: {
                type: 'removeAll'
            },
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');
                    return;
                }
                if (result['status'] == 200) {
                    if (result['data'] == true) {
                        $("#product_list").hide();
                        $("#no_product_list").show();
                    }
                }
            }
        });
    }
</script>