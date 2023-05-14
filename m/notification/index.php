<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">공지사항</p>
    </div>
    <div class="mt-[15px] flex flex-col w-full border-t-[0.5px] border-[#E0E0E0]">
        <?php
        for ($i = 0; $i < 10; $i++) {
        ?>
            <div x-data="{ isCollapsed: true }" class="flex flex-col w-full">
                <div class="flex justify-between items-center py-[15px] border-b-[0.5px] border-[#E0E0E0]">
                    <div class="flex flex-col gap-[3px]">
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">2023.02.09</p>
                        <p class="font-bold text-xs leading-[14px] text-black">[공지] 사이트 리뉴얼 안내</p>
                    </div>
                    <div class="pr-[7px]" x-on:click="isCollapsed = !isCollapsed">
                        <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.6932 1.18894L5.85752 5.84793C5.79995 5.90323 5.73759 5.9423 5.67042 5.96516C5.60326 5.98839 5.5313 6 5.45455 6C5.37779 6 5.30583 5.98839 5.23867 5.96516C5.1715 5.9423 5.10914 5.90323 5.05157 5.84793L0.201487 1.18894C0.0671621 1.05991 -2.22989e-07 0.898617 -2.31449e-07 0.705069C-2.39909e-07 0.51152 0.0719594 0.345622 0.215879 0.207373C0.359798 0.0691242 0.527704 -4.99904e-07 0.719597 -5.08292e-07C0.911489 -5.1668e-07 1.0794 0.0691242 1.22331 0.207373L5.45454 4.27189L9.68578 0.207373C9.8201 0.0783406 9.98551 0.013824 10.182 0.013824C10.3789 0.013824 10.5493 0.0829482 10.6932 0.221197C10.8371 0.359446 10.9091 0.520736 10.9091 0.705068C10.9091 0.8894 10.8371 1.05069 10.6932 1.18894Z" fill="#333333" />
                        </svg>
                    </div>
                </div>
                <div x-show="!isCollapsed" class="flex justify-center items-center bg-[#F5F5F5] p-[22px]">
                    <p class="font-bold text-xs leading-[17px] text-[#666666]">
                        에이블랑에서는 많은 고객님들께 보다 만족스러운 렌탈을 제공해
                        드리기 위해 렌탈 횟수를 제한하고 있습니다.

                        동일인(동일 고객 정보)로 2개 이상 렌탈 시
                        주문건이 자동 취소 될 수 있는 점 참고 부탁드립니다.
                    </p>
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

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>