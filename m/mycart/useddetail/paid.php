<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<!-- 주문완료 -->
<div class="mt-[30px] flex flex-col items-center w-full">
    <p class="font-extrabold text-lg leading-5 text-center text-[#333333]">주문완료</p>
    <div class="mt-[25px] w-[280px] h-[163px]">
        <img class="w-full h-full" src="images/paid.png" alt="successful">
    </div>
    <p class="mt-5 font-bold text-[15px] leading-[17px] text-center text-black">주문이 완료되었습니다.</p>
    <p class="mt-2.5 font-bold text-xs leading-[140%] text-center text-[#666666]">2023. 02. 21 주문하신 상품의 주문번호는 <br /> <b>20230221100</b> 입니다.</p>
    <button class="mt-5 flex justify-center items-center w-[178px] h-[45px] bg-white border border-solid border-[#DDDDDD]">
        <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">주문 상세보기</p>
    </button>
</div>

<!-- 구분선 -->
<hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

<!-- 주문정보 -->
<div class="mt-[15px] px-[14px]">
    <p class="font-extrabold text-lg leading-5 text-[#333333]">주문정보</p>
    <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-black">DIOR</p>
    <div class="mt-3 flex gap-[11px]">
        <div class="w-[120px] h-[120px] flex justify-center items-center bg-[#F9F9F9] p-2.5">
            <img class="w-full" src="images/mockup/product1.png" alt="">
        </div>
        <div class="flex flex-col">
            <div class="flex justify-center items-center max-w-[38px] px-2 py-1 w-auto bg-[#EEAC4C]">
                <p class="font-normal text-[10px] leading-[11px] text-center text-white">구독</p>
            </div>
            <p class="mt-[15px] font-bold text-xs leading-[14px] text-[#666666]">북토트 미듐</p>
            <p class="mt-2.5 font-bold text-xs leading-[14px] text-[#999999]">월정액 구독 전용</p>
            <p class="mt-1.5 font-bold text-xs leading-[14px] text-black"><span class="text-[#EEAC4C]">월</span> 89,000원</p>
        </div>
    </div>
    <!-- 구분선 -->
    <hr class="mt-5 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />
    <div class="mt-[15px] flex flex-col gap-1.5">
        <div class="flex gap-5">
            <p class="font-bold text-xs leading-[14px] text-[#999999]">이용날짜</p>
            <p class="font-bold text-xs leading-[14px] text-[#666666]">2023. 02. 19</p>
        </div>
        <div class="flex gap-5">
            <p class="font-bold text-xs leading-[14px] text-[#999999]">배송분류</p>
            <p class="font-bold text-xs leading-[14px] text-[#666666]">무료배송</p>
        </div>
        <div class="flex gap-5">
            <p class="font-bold text-xs leading-[14px] text-[#999999]">등급할인</p>
            <p class="font-bold text-xs leading-[14px] text-[#666666]">미해당</p>
        </div>
    </div>
</div>

<!-- 구분선 -->
<hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

<!-- 결제금액 -->
<div x-data="{ isCollapsed: false }" class="mt-[15px] flex flex-col w-full px-[14px]">
    <div class="flex items-center justify-between">
        <p class="font-extrabold text-lg leading-5 text-[#333333]">결제금액</p>
        <div x-on:click="isCollapsed = !isCollapsed">
            <svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.2576 1.58525L7.81002 7.79723C7.73327 7.87097 7.65012 7.92307 7.56057 7.95355C7.47102 7.98452 7.37507 8 7.27273 8C7.17038 8 7.07444 7.98452 6.98489 7.95355C6.89534 7.92307 6.81218 7.87097 6.73543 7.79724L0.268649 1.58525C0.0895495 1.41321 -2.97318e-07 1.19816 -3.08598e-07 0.940092C-3.19879e-07 0.682027 0.0959459 0.46083 0.287838 0.276498C0.479731 0.0921659 0.703606 -3.07556e-08 0.959462 -4.19394e-08C1.21532 -5.31233e-08 1.43919 0.0921659 1.63109 0.276498L7.27273 5.69585L12.9144 0.276497C13.0935 0.104454 13.314 0.0184325 13.576 0.0184325C13.8385 0.0184325 14.0657 0.110598 14.2576 0.29493C14.4495 0.479262 14.5455 0.694316 14.5455 0.940091C14.5455 1.18587 14.4495 1.40092 14.2576 1.58525Z" fill="#333333" />
            </svg>
        </div>
    </div>
    <div x-show="!isCollapsed" class="mt-[15px] flex flex-col gap-2.5 w-full">
        <div class="flex items-center justify-between">
            <p class="font-bold text-[15px] leading-[17px] text-black">주문금액</p>
            <p class="font-bold text-[15px] leading-[17px] text-black">3,900,000원</p>
        </div>
        <div class="flex items-center justify-between">
            <p class="font-bold text-[15px] leading-[17px] text-black">상품 할인금액</p>
            <p class="font-bold text-[15px] leading-[17px] text-black">3,860,000원</p>
        </div>
        <div class="flex items-center justify-between">
            <p class="font-bold text-[11px] leading-3 text-[#666666]">ㄴ 금액할인</p>
            <p class="font-bold text-[11px] leading-3 text-[#666666]">-30,000원</p>
        </div>
        <div class="flex items-center justify-between">
            <p class="font-bold text-[11px] leading-3 text-[#666666]">ㄴ 멤버십할인</p>
            <p class="font-bold text-[11px] leading-3 text-[#666666]">-10,000원</p>
        </div>
        <div class="flex items-center justify-between">
            <p class="font-bold text-[15px] leading-[17px] text-black">쿠폰할인</p>
            <p class="font-bold text-[15px] leading-[17px] text-black">5,000원</p>
        </div>
        <div class="flex items-center justify-between">
            <p class="font-bold text-[15px] leading-[17px] text-black">적립금사용</p>
            <p class="font-bold text-[15px] leading-[17px] text-black">1,000원</p>
        </div>
        <hr class="mt-[5px] w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />
        <div class="mt-[5px] flex items-center justify-between">
            <p class="font-extrabold text-[15px] leading-[17px] text-[#DA2727]">총 결제예정금액</p>
            <p class="font-extrabold text-[15px] leading-[17px] text-right text-black">3,854,000원</p>
        </div>
    </div>
</div>

<!-- 구분선 -->
<hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php"; ?>