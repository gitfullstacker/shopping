<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
$title = '입고 알림 내역/찜한 상품';
$hide_right_menu = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div class="mt-1.5 flex flex-col w-full px-[14px]">
    <div x-data="{ type: 1 }" class="flex flex-col w-full">
        <div class="flex justify-end">
            <button type="button" onclick="removeLikeAll()">
                <p class="font-bold text-xs leading-[14px] underline text-[#666666]">전체삭제</p>
            </button>
        </div>
        <div class="flex gap-[7px] items-center">
            <button class="flex px-[15px] py-[7px] bg-white border border-solid rounded-full" x-bind:class="type == 1 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="type = 1">
                <p class="font-bold text-xs leading-[14px] flex items-center text-center" x-bind:class="type == 1 ? 'text-black' : 'text-[#666666]'">입고알림</p>
            </button>
            <button class="flex px-[15px] py-[7px] bg-white border border-solid rounded-full" x-bind:class="type == 2 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="type = 2">
                <p class="font-bold text-xs leading-[14px] flex items-center text-center" x-bind:class="type == 2 ? 'text-black' : 'text-[#666666]'">찜</p>
            </button>
        </div>
        
        <!-- 입고알람 -->
        <div x-show="type == 1" class="mt-[18px] grid grid-cols-2 gap-x-[13.5px] gap-y-[30px]"></div>

        <!-- 찜목록 -->
        <div x-show="type == 2" class="mt-[18px] grid grid-cols-2 gap-x-[13.5px] gap-y-[30px]" id="product_list" style="display: none;">
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
            while ($row = mysql_fetch_assoc($product_result)) {
            ?>
                <!-- 상품 -->
                <div class="flex flex-col w-full" id="product_item_<?= $row['STR_GOODCODE'] ?>">
                    <div class="relative flex justify-center items-center w-full h-[176px] p-2.5 bg-[#F9F9F9] rounded-[6px]">
                        <img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" alt="product">
                        <div class="absolute top-[11px] right-[11px] flex justify-center items-center w-4 h-4" onclick="setLike(<?= $row['STR_GOODCODE'] ?>)">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-[5.5px] font-extrabold text-[9px] leading-[10px] text-[#666666]"><?= $row['STR_CODE'] ?></p>
                    <p class="mt-[3px] font-bold text-[9px] leading-[10px] text-[#333333]"><?= $row['STR_GOODNAME'] ?></p>
                    <div class="mt-[8.4px] flex gap-1 items-center">
                        <p class="font-extrabold text-xs leading-[14px] text-[#00402F]"><?= $row['INT_DISCOUNT'] ? $row['INT_DISCOUNT'] . '%' : '' ?></p>
                        <p class="font-bold text-xs leading-[14px] text-black"><?= '일 ' . ($row['INT_DISCOUNT'] ? number_format($row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) : number_format($row['INT_PRICE'])) ?>원</p>
                    </div>
                    <div class="mt-[10.5px] flex justify-center items-center w-[30px] h-4 bg-[<?= ($row['INT_TYPE'] == 1 ? '#EEAC4C' : ($row['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                        <p class="font-normal text-[9px] leading-[9px] text-center text-white"><?= ($row['INT_TYPE'] == 1 ? '구독' : ($row['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?
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
                    if(result['data'] == false) {
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
                    if(result['data'] == true) {
                        $("#product_list").hide();
                    }
                }
            }
        });
    }
</script>