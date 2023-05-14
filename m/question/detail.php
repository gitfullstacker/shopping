<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div x-data="{ menu: 1 }" class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">1:1 문의</p>
    </div>

    <hr class="mt-[15px] border-t-[0.5px] border-[#E0E0E0]" />

    <div class="mt-[15px] flex flex-col gap-[7px] w-full pb-[15px] border-b-[0.5px] border-[#E0E0E0]">
        <p class="font-bold text-[10px] leading-[11px]">2023.02.12</p>
        <div class="flex justify-between items-center">
            <div class="flex flex-col gap-1.5">
                <p class="font-bold text-xs leading-[14px] text-[#666666]">[상품문의]</p>
                <p class="font-bold text-xs leading-[14px] text-[#666666]">렌트 상품이 수거가 되고 있지 않습니다.</p>
            </div>
            <button class="flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px] w-[50px] h-[25px]">
                <p class="font-bold text-[9px] leading-[9px] text-[#666666]">삭제</p>
            </button>
        </div>
    </div>

    <div class="mt-4 flex flex-col w-full">
        <img class="w-full" src="images/mockup/product.png" alt="">
        <p class="mt-5 font-bold text-xs leading-[19px] text-[#666666]">
            안녕하세요 고객님. 아래 양식에 맞게 문의글 작성 부탁드립니다.

            폭언/욕설/비속어 등이 포함될 경우 답변이 제한되며,
            사전 안내없이 무통보 삭제되오니 작성 시 유의 부탁드립니다.

            -주문번호: 2023021010
            -휴대폰: 010-1234-5678
            -불량/AS 문의일 경우 반드시 사진첨부를 부탁드립니다.


            구매한 사이즈와 다른 사이즈가 도착했습니다.
            사진 첨부했으니 확인해주시고 답변부탁드립니다!
        </p>
    </div>

    <hr class="mt-[29px] border-t-[0.5px] border-[#E0E0E0]" />

    <div class="mt-[15px] flex flex-col gap-[7px] w-full pb-[15px] border-b-[0.5px] border-[#E0E0E0]">
        <p class="font-bold text-[10px] leading-[11px]">2023.02.12</p>
        <div class="flex justify-between items-center">
            <div class="flex flex-col gap-1.5">
                <p class="font-bold text-xs leading-[14px] text-[#666666]">[상품문의]</p>
                <p class="font-bold text-xs leading-[14px] text-[#666666]">렌트 상품이 수거가 되고 있지 않습니다.</p>
            </div>
            <p class="font-bold text-xs leading-[14px] text-black">답변완료</p>
        </div>
    </div>
    <p class="mt-5 font-bold text-xs leading-[19px] text-[#666666]">
        안녕하세요 고객님. 아래 양식에 맞게 문의글 작성 부탁드립니다.

        폭언/욕설/비속어 등이 포함될 경우 답변이 제한되며,
        사전 안내없이 무통보 삭제되오니 작성 시 유의 부탁드립니다.

        -주문번호: 2023021010
        -휴대폰: 010-1234-5678
        -불량/AS 문의일 경우 반드시 사진첨부를 부탁드립니다.


        구매한 사이즈와 다른 사이즈가 도착했습니다.
        사진 첨부했으니 확인해주시고 답변부탁드립니다!
    </p>
    <a href="index.php" class="mt-[27px] flex justify-center items-center w-full h-[45px] bg-black border border-solid border-[#DDDDDD]">
        <p class="font-bold text-xs leading-[12px] text-white">목록으로 돌아가기</p>
    </a>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>