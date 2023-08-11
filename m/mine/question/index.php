<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div x-data="{ menu: 1 }" class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">1:1 문의</p>
    </div>
    <div class="mt-[14px] flex flex-col px-[15px] py-[17px] bg-white border border-solid border-[#DDDDDD]">
        <p class="font-extrabold text-[13px] leading-[15px] text-black">CUSTOMER CENTER</p>
        <p class="mt-[13px] font-bold text-xs leading-[14px] text-black">CS NUMBER : 02-6013-6733</p>
        <p class="mt-[5px] font-bold text-xs leading-[14px] text-black">KAKAOTALK : @에이블랑컴퍼니</p>
        <p class="mt-[15px] font-medium text-[9px] leading-[10px] text-[#999999]">※ 운영시간: 평일 09:00 ~ 17:30 (점심시간 12:00~13:00) / 주말 및 공휴일 휴무</p>
    </div>
    <a href="create.php" class="mt-[15px] w-full h-[45px] flex justify-center items-center bg-black border border-solid border-[#DDDDDD]">
        <p class="font-bold text-xs leading-[12px] text-white">1:1 문의 작성하기</p>
    </a>
    <div class="mt-[23px] flex flex-col w-full" id="qna_list">
    </div>
</div>

<?php
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    $(document).ready(function() {
        searchQna();
    });

    function searchQna(page = 0) {
        url = "get_qna_list.php";
        url += "?page=" + page;

        $.ajax({
            url: url,
            success: function(result) {
                $("#qna_list").html(result);
            }
        });
    }
</script>