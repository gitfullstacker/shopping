<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div x-data="{ menu: 1 }" class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">쿠폰 현황</p>
    </div>
    <div class="mt-[14px] flex justify-center items-center gap-16 w-full">
        <div class="px-1 pb-[3px] border-[#6A696C]" x-bind:class="menu == 1 ? 'border-b' : ''" x-on:click="menu = 1">
            <p class="font-bold text-xs leading-[14px]" x-bind:class="menu == 1 ? 'text-[#6A696C]' : 'text-[#999999]'">나의 쿠폰</p>
        </div>
        <div class="px-1 pb-[3px] border-[#6A696C]" x-bind:class="menu == 2 ? 'border-b' : ''" x-on:click="menu = 2">
            <p class="font-bold text-xs leading-[14px]" x-bind:class="menu == 2 ? 'text-[#6A696C]' : 'text-[#999999]'">쿠폰 등록</p>
        </div>
    </div>

    <div x-show="menu == 1" class="flex flex-col w-full" id="coupon_list">
    </div>

    <div x-show="menu == 2" class="flex flex-col w-full">
        <form class="mt-[15px] flex gap-[5px] items-center w-full" action="add_coupon_proc.php" method="post" onsubmit="return checkVal()">
            <input type="text" class="grow px-[15px] h-[45px] bg-white border border-solid border-[#DDDDDD] rounded-[3px] font-bold text-xs leading-[12px] placeholder:text-[#666666]" id="str_num" name="str_num" placeholder="쿠폰 번호를 입력해주세요">
            <button type="submit" class="w-[97px] h-[45px] flex justify-center items-center bg-black border border-solid border-[#DDDDDD] rounded-[3px]">
                <p class="font-bold text-xs leading-[12px] text-white">발급받기</p>
            </button>
        </form>

        <hr class="mt-[23px] border-t-[0.5px] broder-[#E0E0E0]" />

        <div class="mt-[15px] flex flex-col gap-[7px] px-[9px] py-[15px] bg-[#F5F5F5]">
            <p class="font-bold text-[10px] leading-[14px] text-black">쿠폰 발급 안내</p>
            <p class="font-bold text-[10px] leading-[14px] text-[#999999]">
                -에이블랑의 회원이어야 발급 받을 수 있습니다.<br />
                -쿠폰의 발급 기간 및 유효 기간을 꼭 확인해주세요.<br />
                -쿠폰 사용시 최소 구매금액이 있으며, 일부 상품은 사용에 제한이 있을 수 있습니다.<br />
                -등록한 쿠폰은 ‘MY PAGE > 쿠폰 현황 > 나의 쿠폰’ 에서 확인하실 수 있습니다.
            </p>
        </div>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    $(document).ready(function() {
        searchCoupon();
    });

    function searchCoupon(page = 0) {
        url = "get_coupon_list.php";
        url += "?page=" + page;

        $.ajax({
            url: url,
            success: function(result) {
                $("#coupon_list").html(result);
            }
        });
    }

    function checkVal() {
        if (document.getElementById('str_num').value == '') {
            alert('쿠폰번호를 넣어주세요.');
            return false;
        }

        return true;
    }
</script>