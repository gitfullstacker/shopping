<?
$title = '입고 알림 내역/찜한 상품';
$hide_right_menu = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div class="mt-1.5 flex flex-col w-full px-[14px]">
    <div class="flex flex-col w-full">
        <div class="flex justify-end">
            <button>
                <p class="font-bold text-xs leading-[14px] underline text-[#666666]">전체삭제</p>
            </button>
        </div>
        <div x-data="{ type: 1 }" class="flex gap-[7px] items-center">
            <button class="flex px-[15px] py-[7px] bg-white border border-solid rounded-full" x-bind:class="type == 1 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="type = 1">
                <p class="font-bold text-xs leading-[14px] flex items-center text-center" x-bind:class="type == 1 ? 'text-black' : 'text-[#666666]'">입고알림</p>
            </button>
            <button class="flex px-[15px] py-[7px] bg-white border border-solid rounded-full" x-bind:class="type == 2 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="type = 2">
                <p class="font-bold text-xs leading-[14px] flex items-center text-center" x-bind:class="type == 2 ? 'text-black' : 'text-[#666666]'">입고알림</p>
            </button>
        </div>
        <div class="mt-[18px] grid grid-cols-2 gap-x-[13.5px] gap-y-[30px]">
            <?php
            for ($i = 0; $i < 12; $i++) {
            ?>
                <!-- 상품 -->
                <div class="flex flex-col w-full">
                    <div class="relative flex justify-center items-center w-full h-[176px] p-2.5 bg-[#F9F9F9] rounded-[6px]">
                        <img src="images/mockup/product.png" alt="product">
                        <div class="absolute top-[11px] right-[11px] flex justify-center items-center w-4 h-4">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-[5.5px] font-extrabold text-[9px] leading-[10px] text-[#666666]">CHANEL</p>
                    <p class="mt-[3px] font-bold text-[9px] leading-[10px] text-[#333333]">가브리엘 스몰 백팩</p>
                    <div class="mt-[8.4px] flex gap-1 items-center">
                        <p class="font-extrabold text-xs leading-[14px] text-[#00402F]">20%</p>
                        <p class="font-bold text-xs leading-[14px] text-black">일 35,920원</p>
                    </div>
                    <div class="mt-[10.5px] flex justify-center items-center w-[30px] h-4 bg-[#00402F]">
                        <p class="font-normal text-[9px] leading-[10px] text-center text-white">렌트</p>
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