<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<!-- 배송정보 -->
<div class="mt-[30px] flex flex-col w-full px-[14px]">
    <p class="font-extrabold text-lg leading-5 text-[#333333]">배송정보</p>
    <div x-data="{ type: 1 }" class="mt-1.5 flex gap-[7px]">
        <a href="#" class="flex justify-center items-center w-[86px] h-[29px] bg-white border border-solid rounded-[12.5px]" x-bind:class="type == 1 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="type = 1">
            <span class="font-bold text-xs leading-[14px] flex items-center text-center text-[#666666]">기본 배송지</span>
        </a>
        <a href="#" class="flex justify-center items-center w-[86px] h-[29px] bg-white border border-solid rounded-[12.5px]" x-bind:class="type == 2 ? 'border-black' : 'border-[#DDDDDD]'" x-on:click="type = 2">
            <span class="font-bold text-xs leading-[14px] flex items-center text-center text-[#666666]">신규 배송지</span>
        </a>
    </div>
    <p class="mt-[15px] font-bold text-[15px] leading-[17px] text-black">에이블랑</p>
    <p class="mt-[9px] font-bold text-xs leading-[14px] text-black">(03697) 서울특별시 서대문구 연희로27길 16 (연희동) 2층</p>
    <p class="mt-1.5 font-bold text-xs leading-[14px] text-[#666666]">010-9556-6439 / 031-572-6439</p>
    <div class="mt-3 relative flex w-full">
        <select name="" id="" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-md px-2.5 w-full h-[35px] font-bold text-[11px] leading-3 text-[#666666]">
            <option value="">배송시 요청사항을 선택해 주세요</option>
        </select>
        <div class="absolute top-[15px] right-[15px] pointer-events-none">
            <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576042 0.435356 5.34201e-07 0.593667 5.27991e-07C0.751979 5.2178e-07 0.890501 0.0576042 1.00923 0.172812L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.0115208 8.40016 0.0115208C8.56259 0.0115208 8.70317 0.0691245 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587558C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#666666" />
            </svg>
        </div>
    </div>
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
</div>

<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer_detail.php"; ?>