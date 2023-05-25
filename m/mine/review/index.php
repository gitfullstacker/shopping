<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
$view_mode = Fnc_Om_Conv_Default($_REQUEST['view_mode'], "cart");
?>
<div x-data="{ menu: <?= $view_mode == 'cart' ? '1' : '2' ?> }" class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">나의 리뷰</p>
    </div>
    <div class="mt-[14px] flex justify-center items-center gap-16 w-full">
        <div class="px-1 pb-[3px] border-[#6A696C]" x-bind:class="menu == 1 ? 'border-b' : ''" x-on:click="menu = 1">
            <p class="font-bold text-xs leading-[14px]" x-bind:class="menu == 1 ? 'text-[#6A696C]' : 'text-[#999999]'">리뷰 작성</p>
        </div>
        <div class="px-1 pb-[3px] border-[#6A696C]" x-bind:class="menu == 2 ? 'border-b' : ''" x-on:click="menu = 2">
            <p class="font-bold text-xs leading-[14px]" x-bind:class="menu == 2 ? 'text-[#6A696C]' : 'text-[#999999]'">리뷰 내역</p>
        </div>
    </div>
    <div class="mt-[15px] flex flex-col gap-[7px] px-[9px] py-[15px] bg-[#F5F5F5]">
        <p class="font-bold text-[10px] leading-[14px] text-black">후기 작성 안내</p>
        <p class="font-bold text-[10px] leading-[14px] text-[#999999]">
            -사진 후기 100원, 글 후기 50원 적립금이 지급됩니다.<br />
            -작성 시 기준에 맞는 적립금이 자동으로 지급됩니다.<br />
            -등급에 따라 차등으로 적립 혜택이 달라질 수 있습니다.<br />
            -주간 베스트 후기로 선정 시 5,000원이 추가로 적립됩니다.<br />
            -후기 작성은 배송완료일로부터 30일 이내 가능합니다.
        </p>
    </div>

    <div x-show="menu == 1" class="flex flex-col w-full" id="cart_list">
    </div>

    <div x-show="menu == 2" class="flex flex-col w-full" id="review_list">
        <div class="flex flex-col gap-[15px] w-full border-t-[0.5px] border-[#E0E0E0] pt-[15px]">
            <div class="flex flex-col gap-[15px] w-full border-b-[0.5px] border-[#E0E0E0] pb-[21px]">
                <div class="flex gap-[11px]">
                    <div class="flex justify-center items-center w-[91px] h-[91px] bg-[#F9F9F9] p-2">
                        <img src="images/mockup/product.png" alt="product">
                    </div>
                    <div class="grow flex flex-col justify-center">
                        <div class="w-[25px] h-[14px] flex justify-center items-center bg-[#00402F]">
                            <p class="font-normal text-[8px] leading-[9px] text-center text-white">렌트</p>
                        </div>
                        <p class="mt-1.5 font-bold text-[11px] leading-[12px] text-black">CHANEL</p>
                        <p class="mt-1 font-bold text-[9px] leading-[10px] text-[#666666]">코코핸들 스몰</p>
                        <div class="mt-2.5 flex gap-1">
                            <button class="w-[95px] h-[30px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                                <p class="font-bold text-[9px] leading-[10px] text-[#666666]">수정</p>
                            </button>
                            <button class="w-[95px] h-[30px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px]">
                                <p class="font-bold text-[9px] leading-[10px] text-[#666666]">삭제</p>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-[9px] w-full">
                    <div class="flex justify-between items-center">
                        <p>★★★★★</p>
                        <button class="flex gap-[2.7px] px-[11px] py-1 items-center justify-center border-[0.6px] border-solid border-[#DDDDDD] rounded-full">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.00156 4.61921C0.996567 4.56168 1.00358 4.50374 1.02217 4.44907C1.04076 4.39439 1.0705 4.34418 1.10952 4.30161C1.14855 4.25904 1.19599 4.22505 1.24885 4.20179C1.3017 4.17854 1.35882 4.16652 1.41656 4.1665H2.21219C2.32269 4.1665 2.42867 4.2104 2.50681 4.28854C2.58495 4.36668 2.62885 4.47266 2.62885 4.58317V8.5415C2.62885 8.65201 2.58495 8.75799 2.50681 8.83613C2.42867 8.91427 2.32269 8.95817 2.21219 8.95817H1.76094C1.65665 8.9582 1.55615 8.91911 1.47927 8.84864C1.4024 8.77817 1.35475 8.68144 1.34573 8.57754L1.00156 4.61921ZM3.87885 4.45296C3.87885 4.27879 3.98719 4.12296 4.14448 4.04879C4.48802 3.88671 5.07323 3.56109 5.33719 3.12088C5.6774 2.55338 5.74156 1.52817 5.75198 1.29338C5.75344 1.26046 5.7526 1.22754 5.75698 1.19504C5.81344 0.788169 6.59865 1.26338 6.89969 1.76588C7.06323 2.03838 7.08406 2.3965 7.06698 2.67629C7.04844 2.97546 6.96073 3.26442 6.87469 3.5515L6.69135 4.16338H8.95323C9.0176 4.16337 9.08111 4.17829 9.13875 4.20695C9.1964 4.23561 9.24662 4.27723 9.28547 4.32856C9.32433 4.37989 9.35076 4.43953 9.3627 4.50279C9.37463 4.56605 9.37175 4.63121 9.35427 4.69317L8.23552 8.65484C8.21082 8.74221 8.15826 8.81913 8.08583 8.87388C8.0134 8.92864 7.92507 8.95823 7.83427 8.95817H4.29552C4.18501 8.95817 4.07903 8.91427 4.00089 8.83613C3.92275 8.75799 3.87885 8.65201 3.87885 8.5415V4.45296Z" stroke="#666666" stroke-width="0.833333" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="font-bold text-[9px] leading-[9px] text-[#666666]">0</p>
                        </button>
                    </div>
                    <div class="flex gap-5 items-center">
                        <p class="font-bold text-xs leading-[12px] text-[#666666]">xxs***</p>
                        <p class="font-bold text-xs leading-[12px] text-[#999999]">2023/01/25</p>
                    </div>
                    <p class="font-bold text-xs leading-[17px] text-[#666666]">가방 너무 이뻐요~ 역시 샤넬은 기다린 보람이 있어요! 멤버십 할인도 받아서 저렴하게 렌트했어요 :)</p>
                    <img class="w-[120px] h-[120px]" src="images/mockup/product.png" alt="product">
                </div>
            </div>
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

<script>
    $(document).ready(function() {
        searchCart();
        searchReview();
    });

    function searchCart(page = 0) {
        url = "get_cart_list.php";
        url += "?page=" + page;

        $.ajax({
            url: url,
            success: function(result) {
                $("#cart_list").html(result);
            }
        });
    }

    function searchReview(page = 0) {
        url = "get_review_list.php";
        url += "?page=" + page;

        $.ajax({
            url: url,
            success: function(result) {
                $("#review_list").html(result);
            }
        });
    }

    function setLike(bd_seq) {
        $.ajax({
            url: "/m/review/set_like.php",
            data: {
                bd_seq: bd_seq
            },
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');
                    return;
                }
                if (result['status'] == 200) {
                    $("#like_count_" + bd_seq).html(result['data']);
                }
            }
        });
    }
</script>