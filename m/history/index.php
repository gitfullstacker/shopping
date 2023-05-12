<?
$hide_right_menu = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div class="mt-[6px] flex flex-col w-full">
    <div class="flex justify-end px-[14px]">
        <button>
            <p class="font-bold text-xs leading-[14px] underline text-[#666666]">전체삭제</p>
        </button>
    </div>

    <div class="mt-6 flex flex-col gap-6 w-full">
        <?php
        for ($i = 0; $i < 5; $i++) {
        ?>
            <div class="flex flex-col gap-[30px] w-full">
                <div class="flex justify-center py-[6px] border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-extrabold text-lg leading-5 text-center text-[#333333]">2023. 02. 07</p>
                </div>
                <div class="flex flex-col gap-[15px] w-full px-[14px]">
                    <?php
                    for ($j = 0; $j < 3; $j++) {
                    ?>
                        <div class="flex flex-row gap-2.5">
                            <div class="w-[91px] h-[91px] flex justify-center items-center p-2 bg-[#F9F9F9] rounded-[4px]">
                                <img src="images/mockup/product.png" alt="product">
                            </div>
                            <div class="grow flex justify-between py-1">

                                <div class="flex flex-col w-full">
                                    <div class="flex justify-center items-center w-[25px] h-[14px] bg-[#00402F]">
                                        <p class="font-normal text-[8px] leading-[9px] text-center text-white">렌트</p>
                                    </div>
                                    <p class="mt-1.5 font-bold text-[11px] leading-3 text-black">CHANEL</p>
                                    <p class="mt-1 font-bold text-[9px] leading-[10px] text-[#666666]">코코핸들 스몰</p>
                                    <p class="mt-2.5 font-bold text-[9px] leading-[10px] line-through text-[#999999]">일 38,000원</p>
                                    <p class="mt-1 font-bold text-[9px] leading-[10px] text-[#00402F]">
                                        <span class="text-[#00402F]">30%</span> 일 27,000원
                                    </p>
                                </div>
                                <div x-data="{ isFavorite: false }" class="flex justify-center items-center w-[15px] h-[15px]" x-on:click="isFavorite = !isFavorite">
                                    <svg width="16" height="15" viewBox="0 0 16 15" x-bind:fill="isFavorite ? '#FF1F4B' : 'none'" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.07838 13.6647L7.07788 13.6642C5.01112 11.7493 3.32341 10.1829 2.14831 8.71393C0.977275 7.25002 0.35 5.92416 0.35 4.49591C0.35 2.15659 2.13596 0.35 4.4 0.35C5.68336 0.35 6.92305 0.962301 7.732 1.92538L8 2.24445L8.268 1.92538C9.07695 0.962301 10.3166 0.35 11.6 0.35C13.864 0.35 15.65 2.15659 15.65 4.49591C15.65 5.92416 15.0227 7.25002 13.8517 8.71393C12.6766 10.1829 10.9889 11.7493 8.92212 13.6642L8.92162 13.6647L8 14.522L7.07838 13.6647Z" stroke="#666666" stroke-width="0.7" />
                                    </svg>
                                </div>

                            </div>
                        </div>
                    <?php
                    }
                    ?>
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