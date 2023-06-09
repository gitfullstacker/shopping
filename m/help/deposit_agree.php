<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<div class="mt-[30px] flex flex-col w-full px-[14px] gap-[15px] min-h-screen">
    <p class="font-extrabold text-lg leading-5 text-black">보증금 약관 동의하기</p>
    <div class="flex flex-col gap-2.5 w-full">
        <p class="font-bold text-xs leading-[17px] text-[#666666]">
            -에이블랑 렌트 이용 내역과 상품에 따라,
            주문 후 별도의 보증금이 발생할 수 있습니다.
        </p>
        <p class="font-bold text-xs leading-[17px] text-[#666666]">
            -보증금은 상품 판매가의 약 30~80%의 금액이 책정되며,
            에이블랑 렌트 정책과 개인 신용정보에 따라 상이하게 발생됩니다.
            보증금 발생 시, 입력하신 연락처로 안내드리도록 하겠습니다.
            이 과정에서 개인 정보를 요청할 수 있습니다.
        </p>
    </div>
</div>

<?php
$hide_footer_menu = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>