<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$search_menu = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>

<div class="flex flex-col w-full">
    <div class="flex items-center justify-between px-[14px] border-b border-[#E0E0E0] h-[38px]">
        <div class="flex gap-[3px] items-center">
            <p class="font-bold text-xs leading-[14px] text-black">검색 결과</p>
            <p class="font-bold text-[10px] leading-[11px] text-[#9D9D9D]">(23)</p>
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
            <button class="w-[58px] h-[25px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                <p class="font-bold text-[11px] leading-3 flex items-center text-center text-[#666666]">FILTER</p>
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
    <div class="mt-[6px] grid grid-cols-2 gap-x-[13.5px] gap-y-[30px] w-full px-[14px]">
        <?php
        for ($i = 0; $i < 12; $i++) {
        ?>
            <!-- 상품 -->
            <div class="flex flex-col w-full">
                <div class="relative flex justify-center items-center w-full p-2.5 bg-[#F9F9F9] rounded-[10px]">
                    <img src="images/mockup/product.png" alt="product">
                    <div x-data="{ isFavorite: false }" class="absolute top-[11px] right-[11px] flex justify-center items-center w-4 h-4" x-on:click="isFavorite = !isFavorite">
                        <svg width="16" height="15" viewBox="0 0 16 15" x-bind:fill="isFavorite ? '#FF1F4B' : 'none'" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.07838 13.6647L7.07788 13.6642C5.01112 11.7493 3.32341 10.1829 2.14831 8.71393C0.977275 7.25002 0.35 5.92416 0.35 4.49591C0.35 2.15659 2.13596 0.35 4.4 0.35C5.68336 0.35 6.92305 0.962301 7.732 1.92538L8 2.24445L8.268 1.92538C9.07695 0.962301 10.3166 0.35 11.6 0.35C13.864 0.35 15.65 2.15659 15.65 4.49591C15.65 5.92416 15.0227 7.25002 13.8517 8.71393C12.6766 10.1829 10.9889 11.7493 8.92212 13.6642L8.92162 13.6647L8 14.522L7.07838 13.6647Z" stroke="#666666" stroke-width="0.7" />
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

<?
$hide_footer_content = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>