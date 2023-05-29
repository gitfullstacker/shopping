<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php

?>
<div class="flex flex-col w-full">
    <!-- 주문/배송현황 -->
    <div class="mt-[30px] flex flex-col gap-[14px] px-[14px]">
        <p class="font-extrabold text-lg leading-5 text-black">주문/배송현황</p>
        <div class="flex flex-row items-center justify-between bg-[#F5F5F5] px-4 py-3">
            <div class="flex flex-col gap-[5px] items-center">
                <p class="font-bold text-[25px] leading-7 text-center text-black">1</p>
                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">주문접수</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <p class="font-bold text-[25px] leading-7 text-center text-black">0</p>
                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">상품준비</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <p class="font-bold text-[25px] leading-7 text-center text-black">0</p>
                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">배송중</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <p class="font-bold text-[25px] leading-7 text-center text-black">0</p>
                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">배송완료</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <p class="font-bold text-[25px] leading-7 text-center text-black">4</p>
                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">반납</p>
            </div>
        </div>
    </div>

    <!-- 배송조회/이용내역 -->
    <div class="mt-[30px] flex flex-col">
        <p class="font-extrabold text-lg leading-5 text-[#333333] px-[14px]">배송조회/이용내역</p>
        <div class="mt-[23px] flex flex-col gap-[25px] w-full">
            <?php
            for ($i = 0; $i < 10; $i++) {
            ?>
                <div class="flex flex-col w-full">
                    <a href="detail.php" class="flex justify-between items-center px-[14px] pb-3 border-b-[0.5px] border-[#E0E0E0]">
                        <div class="flex gap-[5px] items-center">
                            <p class="font-bold text-[15px] leading-[17px] text-black">20230208010</p>
                            <p class="font-bold text-xs leading-[14px] text-[#999999]">2023.02.08</p>
                        </div>
                        <div class="pr-[5px]">
                            <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.511521 0 0.345622 0.0593668 0.207373 0.1781C0.0691246 0.296834 -1.19209e-07 0.435356 -1.19209e-07 0.593668C-1.19209e-07 0.751979 0.0691246 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.0783412 8.10158 0.0138248 8.23805 0.0138248 8.40016C0.0138248 8.56259 0.0829491 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.889401 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                            </svg>
                        </div>
                    </a>
                    <div class="flex flex-col px-[14px]">
                        <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-[#999999]">주문접수</p>
                        <div class="mt-3 flex gap-2.5 w-full">
                            <div class="flex justify-center items-center w-[120px] h-[120px] p-2.5 bg-[#F9F9F9] rounded-[6px]">
                                <img src="images/mockup/product.png" alt="product">
                            </div>
                            <div class="grow flex flex-col justify-center">
                                <div class="w-[34px] h-[18px] flex justify-center items-center bg-[#00402F]">
                                    <p class="font-normal text-[10px] leading-[11px] text-center text-white">렌트</p>
                                </div>
                                <p class="mt-1.5 font-bold text-[15px] leading-[17px] text-black">CHANEL</p>
                                <p class="mt-[2px] font-bold text-xs leading-[14px] text-[#666666]">코코핸들 스몰</p>
                                <p class="mt-[9px] font-bold text-xs leading-[14px] text-[#999999]">기간: 2023.02.10 ~ 2023.02.13</p>
                                <p class="mt-[3px] font-extrabold text-xs leading-[14px] text-black">156,000원</p>
                            </div>
                        </div>
                        <div class="mt-[15px] grid grid-cols-2 gap-[5px]">
                            <div class="w-full h-[35px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                                <p class="font-bold text-[11px] leading-[12px] text-center text-[#666666]">배송 조회</p>
                            </div>
                            <div class="w-full h-[35px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                                <p class="font-bold text-[11px] leading-[12px] text-center text-[#666666]">1:1 문의</p>
                            </div>
                            <div class="w-full h-[35px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                                <p class="font-bold text-[11px] leading-[12px] text-center text-[#666666]">기간 연장</p>
                            </div>
                            <div class="w-full h-[35px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                                <p class="font-bold text-[11px] leading-[12px] text-center text-[#666666]">취소 신청</p>
                            </div>
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
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>