<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div class="mt-[30px] flex flex-col items-center w-full">
    <p class="font-extrabold text-lg leading-5 text-black">주문 내역 상세</p>

    <div class="mt-[22px] flex flex-col gap-[35px] w-full">
        <!-- 주문상품 -->
        <div class="flex flex-col w-full">
            <p class="font-bold text-[15px] leading-[17px] text-black px-[14px]">주문상품</p>
            <hr class="mt-3 border-t border-[#E0E0E0]" />
            <div class="mt-3 flex flex-row gap-[11px] w-full px-[14px]">
                <div class="w-[120px] h-[120px] flex justify-center items-center p-2 bg-[#F9F9F9]">
                    <img class="w-full" src="images/mockup/product.png" alt="">
                </div>
                <div class="flex-1 flex flex-col justify-center w-full">
                    <div class="flex justify-center items-center w-[34px] h-[18px] bg-[#00402F]">
                        <p class="font-normal text-[10px] leading-[11px] text-center text-white">렌트</p>
                    </div>
                    <p class="mt-1.5 font-bold text-[15px] leading-[17px] text-black">CHANEL</p>
                    <p class="mt-0.5 font-bold text-xs leading-[14px] text-[#666666]">코코핸들 스몰</p>
                    <p class="mt-[9px] font-bold text-xs leading-[14px] text-[#999999]">기간: 2023.02.10 ~ 2023.02.13</p>
                    <p class="mt-[3px] font-bold text-xs leading-[14px] text-black">156,000원</p>
                </div>
            </div>
            <div class="mt-2.5 flex gap-[26px] items-center px-[14px]">
                <p class="font-bold text-xs leading-[14px] text-[#999999]">배송중</p>
                <p class="font-bold text-xs leading-[14px] text-black underline">우체국택배(40406184567)</p>
            </div>
            <div class="mt-[15px] grid grid-cols-2 gap-[5px] px-[14px]">
                <div class="w-full h-[35px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                    <p class="font-bold text-[11px] leading-[12px] text-center text-[#666666]">배송 조회</p>
                </div>
                <div class="w-full h-[35px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                    <p class="font-bold text-[11px] leading-[12px] text-center text-[#666666]">1:1 문의</p>
                </div>
                <div class="col-span-2 w-full h-[35px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                    <p class="font-bold text-[11px] leading-[12px] text-center text-[#666666]">기간 연장</p>
                </div>
            </div>
        </div>
        <!-- 주문정보 -->
        <div class="flex flex-col w-full">
            <p class="font-bold text-[15px] leading-[17px] text-black px-[14px]">주문정보</p>
            <hr class="mt-3 border-t border-[#E0E0E0]" />
            <div class="flex flex-col w-full px-[14px]">
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">주문번호</p>
                    <p class="font-bold text-xs leading-[14px] text-[#000000]">20230208010</p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">주문일자</p>
                    <p class="font-bold text-xs leading-[14px] text-[#000000]">2023. 02. 08</p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">주문자</p>
                    <p class="font-bold text-xs leading-[14px] text-[#000000]">송지혜</p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">주문처리상태</p>
                    <p class="font-bold text-xs leading-[14px] text-[#000000]">배송완료</p>
                </div>
            </div>
        </div>
        <!-- 결제정보 -->
        <div class="flex flex-col w-full">
            <p class="font-bold text-[15px] leading-[17px] text-black px-[14px]">결제정보</p>
            <hr class="mt-3 border-t border-[#E0E0E0]" />
            <div class="flex flex-col w-full px-[14px]">
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">결제수단</p>
                    <p class="font-bold text-xs leading-[14px] text-[#000000]">ABLANC PAY(자동결제)</p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">상품금액</p>
                    <p class="font-bold text-xs leading-[14px] text-[#000000]">156,000원</p>
                </div>
                <div class="flex flex-col gap-2.5 w-full py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <div class="flex items-center justify-between">
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">상품할인금액</p>
                        <p class="font-bold text-xs leading-[14px] text-[#000000]">30,000원</p>
                    </div>
                    <div class="flex flex-col gap-2.5 w-full">
                        <div class="flex items-center justify-between">
                            <p class="font-bold text-[11px] leading-3 text-[#666666]">ㄴ 금액할인</p>
                            <p class="font-bold text-[11px] leading-3 text-[#000000]">-20,000원</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="font-bold text-[11px] leading-3 text-[#666666]">ㄴ 멤버십할인</p>
                            <p class="font-bold text-[11px] leading-3 text-[#000000]">-10,000원</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">상품할인금액</p>
                        <p class="font-bold text-xs leading-[14px] text-[#000000]">30,000원</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">쿠폰할인</p>
                        <p class="font-bold text-xs leading-[14px] text-[#000000]">-1,000원</p>
                    </div>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#DA2727]">적립금사용</p>
                    <p class="font-extrabold text-[15px] leading-[17px] text-[#000000]">배송완료</p>
                </div>
            </div>
        </div>
        <!-- 배송정보 -->
        <div class="flex flex-col w-full">
            <p class="font-bold text-[15px] leading-[17px] text-black px-[14px]">배송정보</p>
            <hr class="mt-3 border-t border-[#E0E0E0]" />
            <div class="flex flex-col w-full px-[14px]">
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">받는 분</p>
                    <p class="font-bold text-xs leading-[14px] text-[#000000]">송지혜</p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">핸드폰번호</p>
                    <p class="font-bold text-xs leading-[14px] text-[#000000]">010-1234-5678</p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">전화번호</p>
                    <p class="font-bold text-xs leading-[14px] text-[#000000]">031-000-0000</p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">주소</p>
                    <p class="font-bold text-xs leading-[14px] text-[#000000]">(03697) 서울특별시 서대문 연희로 27길 16</p>
                </div>
                <div class="flex items-center justify-between py-3 border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">배송메세지</p>
                    <p class="font-bold text-xs leading-[14px] text-[#000000]">문 앞에 두고 가주세요.</p>
                </div>
            </div>
        </div>

        <!-- 주문목록 보기 -->
        <div class="flex px-[14px]">
            <a href="/m/mine/order/index.php" class="w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                <p class="font-bold text-xs leading-[14px] text-[#666666]">주문목록 보기</p>
            </a>
        </div>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>