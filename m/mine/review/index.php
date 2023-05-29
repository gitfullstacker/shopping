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

    <div x-show="menu == 1" class="flex flex-col w-full" id="cart_list">
    </div>

    <div x-show="menu == 2" class="flex flex-col w-full" id="review_list">
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