<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div x-data="{ menu: 1 }" class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">쿠폰 현황</p>
    </div>
    <div class="mt-[14px] flex justify-center items-center gap-16 w-full">
        <div class="px-1 pb-[3px] border-[#6A696C]" x-bind:class="menu == 1 ? 'border-b' : ''" x-on:click="menu = 1">
            <p class="font-bold text-xs leading-[14px]" x-bind:class="menu == 1 ? 'text-[#6A696C]' : 'text-[#999999]'">나의 쿠폰</p>
        </div>
        <div class="px-1 pb-[3px] border-[#6A696C]" x-bind:class="menu == 2 ? 'border-b' : ''" x-on:click="menu = 2">
            <p class="font-bold text-xs leading-[14px]" x-bind:class="menu == 2 ? 'text-[#6A696C]' : 'text-[#999999]'">쿠폰 등록</p>
        </div>
    </div>

    <div x-show="menu == 1" class="flex flex-col w-full">
        <div class="flex flex-col w-full divide-y-[0.5px] divide-[#E0E0E0]">
            <?php
            for ($i = 0; $i < 5; $i++) {
            ?>
                <div class="flex w-full py-[15px]">
                    <div class="flex flex-col w-full bg-white border border-solid border-[#DDDDDD] divide-y-[0.5px] divide-[#E0E0E0]">
                        <div class="px-[15px] py-3 flex flex-col">
                            <p class="font-extrabold text-xl leading-[23px] text-black">15%</p>
                            <p class="mt-[1px] font-bold text-xs leading-[14px] text-[#666666]">렌트 15% 추가 할인</p>
                            <p class="mt-2.5 font-bold text-xs leading-[14px] text-[#999999]">2023.02.15 ~ 2023.02.18 23:59 까지</p>
                        </div>
                        <div class="px-[15px] py-3 flex items-center">
                            <p class="font-bold text-[10px] leading-[11px] text-[#999999]">렌트 카테고리 상품 40,000원 이상 결제시(일부 상품 제외)</p>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="mt-[30px] flex gap-[23px] justify-center items-center">
            <a href="#">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z" fill="black" />
                </svg>
            </a>
            <div class="flex gap-[9.6px] items-center">
                <?php
                for ($i = 0; $i < 5; $i++) {
                ?>
                    <a href="#" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] <?= $i == 0 ? 'bg-black' : 'bg-white' ?>">
                        <p class="font-bold text-xs leading-[14px] text-center <?= $i == 0 ? 'text-white' : 'text-black' ?>"><?= $i + 1 ?></p>
                    </a>
                <?php
                }
                ?>
            </div>
            <a href="#">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.280895 15.6874L1.19642 16.4055L7.31785 8.59663L1.21437 0.787764L0.280895 1.46992L5.88173 8.59663L0.280895 15.6874Z" fill="black" />
                </svg>
            </a>
        </div>
    </div>

    <div x-show="menu == 2" class="flex flex-col w-full">
        <div class="mt-[15px] flex gap-[5px] items-center w-full">
            <input type="text" class="grow px-[15px] h-[45px] bg-white border border-solid border-[#DDDDDD] rounded-[3px] font-bold text-xs leading-[12px] placeholder:text-[#666666]" placeholder="쿠폰 번호를 입력해주세요">
            <button class="w-[97px] h-[45px] flex justify-center items-center bg-black border border-solid border-[#DDDDDD] rounded-[3px]">
                <p class="font-bold text-xs leading-[12px] text-white">발급받기</p>
            </button>
        </div>

        <hr class="mt-[23px] border-t-[0.5px] broder-[#E0E0E0]" />

        <div class="mt-[15px] flex flex-col gap-[7px] px-[9px] py-[15px] bg-[#F5F5F5]">
            <p class="font-bold text-[10px] leading-[14px] text-black">쿠폰 발급 안내</p>
            <p class="font-bold text-[10px] leading-[14px] text-[#999999]">
                -에이블랑의 회원이어야 발급 받을 수 있습니다.<br />
                -쿠폰의 발급 기간 및 유효 기간을 꼭 확인해주세요.<br />
                -쿠폰 사용시 최소 구매금액이 있으며, 일부 상품은 사용에 제한이 있을 수 있습니다.<br />
                -등록한 쿠폰은 ‘MY PAGE > 쿠폰 현황 > 나의 쿠폰’ 에서 확인하실 수 있습니다.
            </p>
        </div>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>