<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<div class="mt-[30px] flex flex-col w-full px-[14px] gap-[15px] min-h-screen">
    <p class="font-extrabold text-lg leading-5 text-black">개인정보 제3자 제공</p>
    <div class="flex flex-col gap-5 w-full">
        <p class="font-bold text-xs leading-[17px] text-[#666666]">
            (주)에이블랑컴퍼니는 서비스 및 상품을 구매하고자 할 경우
            거래 당사자간 원활한 의사소통 및 배송, 상담 등 거래 이행을 위하여
            판매자에게 아래와 같이 개인정보를 제공하고 있습니다.
            아래의 내용을 확인 후 동의하여 주시기 바랍니다.
        </p>
        <table class="w-full border-collapse">
            <tr>
                <td class="w-1/2 border border-solid border-[#DDDDDD] #F8F8F8 px-2 py-3">
                    <p class="font-bold text-[10px] leading-[14px] text-[#666666]">유형</p>
                </td>
                <td class="w-1/2 border border-solid border-[#DDDDDD] px-2 py-3">
                    <p class="font-bold text-[10px] leading-[14px] text-[#666666]">필수</p>
                </td>
            </tr>
            <tr>
                <td class="w-1/2 border border-solid border-[#DDDDDD] #F8F8F8 px-2 py-3">
                    <p class="font-bold text-[10px] leading-[14px] text-[#666666]">제공받는 자</p>
                </td>
                <td class="w-1/2 border border-solid border-[#DDDDDD] px-2 py-3">
                    <p class="font-bold text-[10px] leading-[14px] text-black underline">에이블랑</p>
                </td>
            </tr>
            <tr>
                <td class="w-1/2 border border-solid border-[#DDDDDD] #F8F8F8 px-2 py-3">
                    <p class="font-bold text-[10px] leading-[14px] text-[#666666]">제공 목적</p>
                </td>
                <td class="w-1/2 border border-solid border-[#DDDDDD] px-2 py-3">
                    <div class="flex flex-col gap-[5px]">
                        <p class="font-bold text-[10px] leading-[14px] text-black underline">-주문 상품 및 서비스 제공 및 계약 이행</p>
                        <p class="font-bold text-[10px] leading-[14px] text-black underline">-고객 상담 및 불만, 민원 사무 처리</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="w-1/2 border border-solid border-[#DDDDDD] #F8F8F8 px-2 py-3">
                    <p class="font-bold text-[10px] leading-[14px] text-[#666666]">제공 항목</p>
                </td>
                <td class="w-1/2 border border-solid border-[#DDDDDD] px-2 py-3">
                    <div class="flex flex-col gap-[5px]">
                        <p class="font-bold text-[10px] leading-[14px] text-[#666666]">성명, 휴대폰 번호, 이메일 주소, 주소</p>
                        <p class="font-bold text-[10px] leading-[14px] text-[#666666]">
                            <span class="underline">구매자와 수령자가 다를 경우</span>
                            수령자정보
                            (성명, 주소, 휴대폰 번호,전화번호)
                        </p>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="w-1/2 border border-solid border-[#DDDDDD] #F8F8F8 px-2 py-3">
                    <p class="font-bold text-[10px] leading-[14px] text-[#666666]">보유 및 이용기간</p>
                </td>
                <td class="w-1/2 border border-solid border-[#DDDDDD] px-2 py-3">
                    <div class="flex flex-col gap-3">
                        <p class="font-bold text-[10px] leading-[14px] text-black underline">재화 또는 서비스 제공 목적 달성 후 폐기</p>
                        <p class="font-bold text-[10px] leading-[14px] text-black underline">
                            단, 관계 법령에 따라 일정 기간
                            보관해야 하는 항목은 해당 기간 보관 후
                            파기합니다.
                        </p>
                    </div>
                </td>
            </tr>
        </table>
        <p class="font-bold text-xs leading-[17px] text-[#666666]">
            필수적인 개인정보 제 3자 제공에 동의하지 않을 권리가 있습니다.
            다만, 동의하지 않을 경우 거래가 제한됩니다.
        </p>
    </div>
</div>

<?php
$hide_footer_menu = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>