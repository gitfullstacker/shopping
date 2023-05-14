<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div class="mt-[30px] flex flex-col gap-[15px] w-full">
    <p class="font-extrabold text-lg leading-5 text-center text-black">FAQ</p>
    <div class="px-[14px]">
        <div class="relative w-full">
            <input type="text" class="w-full h-[50px] bg-white border border-solid border-[#DDDDDD] pl-4 pr-7 font-bold text-xs leading-[14px] placeholder:text-[#666666]" name="" id="brand_search" placeholder="궁금한 점을 검색해보세요!">
            <button class="absolute top-4 right-[18px]">
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.2675 17.4201L12.6013 11.7539C13.6807 10.4566 14.2184 8.79307 14.1027 7.10939C13.987 5.42571 13.2268 3.85142 11.9801 2.71388C10.7334 1.57635 9.09628 0.963123 7.40908 1.00172C5.72187 1.04031 4.11446 1.72776 2.92111 2.92111C1.72776 4.11446 1.04031 5.72186 1.00172 7.40907C0.963123 9.09627 1.57636 10.7334 2.71389 11.9801C3.85143 13.2268 5.42571 13.987 7.10939 14.1027C8.79307 14.2184 10.4566 13.6807 11.7539 12.6013L17.4815 18.3289C17.5946 18.437 17.7457 18.4966 17.9022 18.4949C18.0587 18.4931 18.2084 18.4301 18.3191 18.3194C18.4298 18.2087 18.4928 18.0591 18.4945 17.9025C18.4963 17.746 18.4367 17.595 18.3285 17.4818L18.2675 17.4201ZM3.76748 11.3483C2.90084 10.4625 2.36777 9.30397 2.25891 8.06957C2.15005 6.83517 2.47212 5.60117 3.17038 4.57744C3.86863 3.5537 4.89994 2.80345 6.08891 2.45425C7.27788 2.10506 8.5511 2.1785 9.69204 2.66207C10.833 3.14565 11.7712 4.00951 12.3471 5.10673C12.923 6.20396 13.1011 7.46679 12.851 8.68049C12.601 9.89419 11.9382 10.9838 10.9755 11.764C10.0128 12.5442 8.80951 12.9669 7.57034 12.9601C6.86139 12.9562 6.16024 12.8117 5.50748 12.535C4.85473 12.2584 4.26331 11.855 3.76748 11.3483Z" fill="black" stroke="black" stroke-width="0.247219" stroke-miterlimit="10" />
                </svg>
            </button>
        </div>
    </div>

    <!-- 메뉴 -->
    <div class="flex overflow-x-auto px-[14px] py-[13px] border-t-[0.5px] border-b-[0.5px] border-[#E0E0E0]">
        <div x-data="{ menu: 1 }" class="flex gap-[35px] items-center">
            <p class="whitespace-nowrap font-bold text-xs leading-[14px] text-center" x-bind:class="menu == 1 ? 'text-black underline' : 'text-[#999999]'" x-on:click="menu = 1">자주찾는질문</p>
            <p class="whitespace-nowrap font-bold text-xs leading-[14px] text-center" x-bind:class="menu == 2 ? 'text-black underline' : 'text-[#999999]'" x-on:click="menu = 2">주문결제</p>
            <p class="whitespace-nowrap font-bold text-xs leading-[14px] text-center" x-bind:class="menu == 3 ? 'text-black underline' : 'text-[#999999]'" x-on:click="menu = 3">배송관련</p>
            <p class="whitespace-nowrap font-bold text-xs leading-[14px] text-center" x-bind:class="menu == 4 ? 'text-black underline' : 'text-[#999999]'" x-on:click="menu = 4">취소/환불</p>
            <p class="whitespace-nowrap font-bold text-xs leading-[14px] text-center" x-bind:class="menu == 5 ? 'text-black underline' : 'text-[#999999]'" x-on:click="menu = 5">교환/반품</p>
            <p class="whitespace-nowrap font-bold text-xs leading-[14px] text-center" x-bind:class="menu == 6 ? 'text-black underline' : 'text-[#999999]'" x-on:click="menu = 6">기타문의</p>
        </div>
    </div>

    <!-- 내용 -->
    <div class="flex flex-col px-[14px] w-full">
        <div class="flex flex-col w-full border-t-[0.5px] border-[#E0E0E0]">
            <?php
            for ($i = 0; $i < 10; $i++) {
            ?>
                <div x-data="{ isCollapsed: true }" class="flex flex-col w-full">
                    <div class="flex justify-between py-[15px] border-b-[0.5px] border-[#E0E0E0] pr-[7px]">
                        <div class="flex gap-2.5 items-center">
                            <p class="font-bold text-xs leading-[14px] text-black">주문/결제</p>
                            <p class="font-bold text-xs leading-[14px] text-[#666666]">구독 시 렌트 수량은 어떻게 되나요?</p>
                        </div>
                        <div x-on:click="isCollapsed = !isCollapsed">
                            <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.6932 1.18894L5.85752 5.84793C5.79995 5.90323 5.73759 5.9423 5.67042 5.96516C5.60326 5.98839 5.5313 6 5.45455 6C5.37779 6 5.30583 5.98839 5.23867 5.96516C5.1715 5.9423 5.10914 5.90323 5.05157 5.84793L0.201487 1.18894C0.0671621 1.05991 -2.22989e-07 0.898617 -2.31449e-07 0.705069C-2.39909e-07 0.51152 0.0719594 0.345622 0.215879 0.207373C0.359798 0.0691242 0.527704 -4.99904e-07 0.719597 -5.08292e-07C0.911489 -5.1668e-07 1.0794 0.0691242 1.22331 0.207373L5.45454 4.27189L9.68578 0.207373C9.8201 0.0783406 9.98551 0.013824 10.182 0.013824C10.3789 0.013824 10.5493 0.0829482 10.6932 0.221197C10.8371 0.359446 10.9091 0.520736 10.9091 0.705068C10.9091 0.8894 10.8371 1.05069 10.6932 1.18894Z" fill="#333333" />
                            </svg>
                        </div>
                    </div>
                    <div x-show="!isCollapsed" class="flex bg-[#F5F5F5] p-[22px]">
                        <p class="font-bold text-xs leading-[140%] text-[#666666]">
                            에이블랑에서는 많은 고객님들께 보다 만족스러운 렌탈을
                            제공해드리기 위해 렌탈 횟수를 제한하고 있습니다.

                            동일인(동일 고객 정보)로 2개 이상 렌탈 시
                            주문건이 자동 취소 될 수 있는 점 참고 부탁드립니다.
                        </p>
                    </div>
                </div>
            <?php
            } ?>

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
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>