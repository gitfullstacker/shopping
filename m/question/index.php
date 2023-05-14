<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div x-data="{ menu: 1 }" class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">1:1 문의</p>
    </div>
    <div class="mt-[14px] flex flex-col px-[15px] py-[17px] bg-white border border-solid border-[#DDDDDD]">
        <p class="font-extrabold text-[13px] leading-[15px] text-black">CUSTOMER CENTER</p>
        <p class="mt-[13px] font-bold text-xs leading-[14px] text-black">CS NUMBER : 02-6013-0616</p>
        <p class="mt-[5px] font-bold text-xs leading-[14px] text-black">KAKAOTALK : @빈느</p>
        <p class="mt-[15px] font-bold text-[9px] leading-[10px] text-[#999999]">※ 운영시간: 평일 09:00 ~ 17:30 (점심시간 12:00~13:00) / 주말 및 공휴일 휴무</p>
    </div>
    <a href="create.php" class="mt-[15px] w-full h-[45px] flex justify-center items-center bg-black border border-solid border-[#DDDDDD]">
        <p class="font-bold text-xs leading-[12px] text-white">1:1 문의 작성하기</p>
    </a>
    <div class="mt-[23px] flex flex-col w-full">
        <div class="flex flex-col gap-[15px] w-full">
            <?php
            for ($i = 0; $i < 5; $i++) {
            ?>
                <a href="detail.php" class="flex justify-between items-center pb-[15px] border-b-[0.5px] border-[#E0E0E0]">
                    <div class="flex flex-col gap-1.5">
                        <p class="font-bold text-[10px] leading-[11px] text-[#999999]">2023.02.12</p>
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">[상품문의]</p>
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">렌트 상품이 수거가 되고 있지 않습니다.</p>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-black">답변완료</p>
                </a>
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
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>