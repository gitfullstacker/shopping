<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$hide_header = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>
<div class="flex flex-col px-[14px]">
    <div class="flex flex-row justify-between py-5">
        <a href="/m/guide/index.php" class="flex flex-col gap-[9px] items-center">
            <img src="../images/menu_item1.png" class="w-[76.39px] h-[76.39px] rounded-full" alt="" />
            <p class="font-bold text-[13px] leading-[15px] text-[#444444]">이용안내</p>
        </a>
        <a href="/m/benefits/index.php" class="flex flex-col gap-[9px] items-center">
            <img src="../images/menu_item2.png" class="w-[76.39px] h-[76.39px] rounded-full" alt="" />
            <p class="font-bold text-[13px] leading-[15px] text-[#444444]">신규혜택</p>
        </a>
        <a href="/m/mine/notification/index.php" class="flex flex-col gap-[9px] items-center">
            <img src="../images/menu_item3.png" class="w-[76.39px] h-[76.39px] rounded-full" alt="" />
            <p class="font-bold text-[13px] leading-[15px] text-[#444444]">공지사항</p>
        </a>
        <a href="/m/faq/index.php" class="flex flex-col gap-[9px] items-center">
            <img src="../images/menu_item5.png" class="w-[76.39px] h-[76.39px] rounded-full" alt="" />
            <p class="font-bold text-[13px] leading-[15px] text-[#444444]">FAQ</p>
        </a>
    </div>
    <div class="flex flex-col gap-[39px] w-full py-5 border-t-[0.5px] border-b-[0.5px] border-[#E0E0E0] px-2">
        <a href="/m/main/" class="font-bold text-[19px] leading-[22px]">홈</a>
        <a href="/m/product/index.php?product_type=2" class="font-bold text-[19px] leading-[22px]">명품렌트</a>
        <a href="/m/product/index.php?product_type=1" class="font-bold text-[19px] leading-[22px]">명품구독</a>
        <a href="/m/product/index.php?product_type=3" class="font-bold text-[19px] leading-[22px]">중고명품</a>
        <a href="/m/eventzone/index.php" class="font-bold text-[19px] leading-[22px]">이벤트존</a>
    </div>
    <div class="flex flex-row gap-1 items-center px-2 py-5 w-full">
        <?php if (!$arr_Auth[0]) { ?>
            <a class="font-bold text-[19px] leading-[22px] text-[#333333]" href="/m/memberjoin/join.php">JOIN US</a>
            <p class="font-bold text-[19px] leading-[22px] text-[#333333]"> / </p>
            <a class="font-bold text-[19px] leading-[22px] text-[#333333]" href="/m/memberjoin/login.php">LOGIN</a>
        <?php } ?>
    </div>
    <div class="w-full">
        <a href="/m/eventzone/detail.php?int_number=2">
            <img class="min-w-full" src="../images/menu_bottom.png" alt="">
        </a>
    </div>
    <div class="mt-[62px] flex flex-row-reverse items-center gap-[11.5px] px-2">
        <button class="w-[23px] h-[23px]">
            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.5 5.98C10.4082 5.98 9.34101 6.30374 8.43325 6.91029C7.52549 7.51683 6.81798 8.37894 6.40019 9.38759C5.98239 10.3962 5.87308 11.5061 6.08607 12.5769C6.29906 13.6477 6.82479 14.6312 7.59677 15.4032C8.36876 16.1752 9.35233 16.7009 10.4231 16.9139C11.4939 17.1269 12.6038 17.0176 13.6124 16.5998C14.6211 16.182 15.4832 15.4745 16.0897 14.5667C16.6963 13.659 17.02 12.5918 17.02 11.5C17.02 10.036 16.4384 8.63197 15.4032 7.59677C14.368 6.56157 12.964 5.98 11.5 5.98ZM11.5 15.18C10.7722 15.18 10.0607 14.9642 9.4555 14.5598C8.85033 14.1554 8.37865 13.5807 8.10012 12.9083C7.82159 12.2358 7.74872 11.4959 7.89071 10.7821C8.0327 10.0682 8.38319 9.4125 8.89785 8.89785C9.4125 8.38319 10.0682 8.0327 10.7821 7.89071C11.4959 7.74872 12.2358 7.82159 12.9083 8.10012C13.5807 8.37865 14.1554 8.85033 14.5598 9.4555C14.9642 10.0607 15.18 10.7722 15.18 11.5C15.177 12.4751 14.7883 13.4093 14.0988 14.0988C13.4093 14.7883 12.4751 15.177 11.5 15.18ZM16.56 0H6.44C4.73201 0 3.09397 0.678498 1.88623 1.88623C0.678498 3.09397 0 4.73201 0 6.44V16.56C0 18.268 0.678498 19.906 1.88623 21.1138C3.09397 22.3215 4.73201 23 6.44 23H16.56C18.268 23 19.906 22.3215 21.1138 21.1138C22.3215 19.906 23 18.268 23 16.56V6.44C23 4.73201 22.3215 3.09397 21.1138 1.88623C19.906 0.678498 18.268 0 16.56 0ZM21.16 16.56C21.16 17.1641 21.041 17.7622 20.8098 18.3203C20.5787 18.8784 20.2398 19.3855 19.8127 19.8127C19.3855 20.2398 18.8784 20.5787 18.3203 20.8098C17.7622 21.041 17.1641 21.16 16.56 21.16H6.44C5.83592 21.16 5.23775 21.041 4.67966 20.8098C4.12156 20.5787 3.61446 20.2398 3.18731 19.8127C2.76016 19.3855 2.42133 18.8784 2.19015 18.3203C1.95898 17.7622 1.84 17.1641 1.84 16.56V6.44C1.84 5.22 2.32464 4.04998 3.18731 3.18731C4.04998 2.32464 5.22 1.84 6.44 1.84H16.56C17.1641 1.84 17.7622 1.95898 18.3203 2.19015C18.8784 2.42133 19.3855 2.76016 19.8127 3.18731C20.2398 3.61446 20.5787 4.12156 20.8098 4.67966C21.041 5.23775 21.16 5.83592 21.16 6.44V16.56ZM18.86 5.52C18.86 5.79294 18.7791 6.05975 18.6274 6.28669C18.4758 6.51363 18.2603 6.69051 18.0081 6.79495C17.7559 6.8994 17.4785 6.92673 17.2108 6.87348C16.9431 6.82024 16.6972 6.6888 16.5042 6.49581C16.3112 6.30281 16.1798 6.05692 16.1265 5.78922C16.0733 5.52153 16.1006 5.24406 16.205 4.9919C16.3095 4.73973 16.4864 4.52421 16.7133 4.37257C16.9403 4.22094 17.2071 4.14 17.48 4.14C17.846 4.14 18.197 4.28539 18.4558 4.54419C18.7146 4.80299 18.86 5.154 18.86 5.52Z" fill="#999999" />
            </svg>
        </button>
        <button class="w-[25px] h-[20px]">
            <svg width="27" height="21" viewBox="0 0 27 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.9966 4.10465C22.8994 3.72388 22.6234 3.43638 22.3078 3.34821C21.7494 3.19104 19.0278 2.83327 13.2778 2.83327C7.52778 2.83327 4.80867 3.19104 4.24517 3.34821C3.93339 3.4351 3.65739 3.7226 3.559 4.10465C3.41972 4.64643 3.05556 6.91704 3.05556 10.4999C3.05556 14.0828 3.41972 16.3522 3.559 16.8965C3.65611 17.276 3.93211 17.5635 4.24644 17.6504C4.80867 17.8088 7.52778 18.1666 13.2778 18.1666C19.0278 18.1666 21.7482 17.8088 22.3104 17.6517C22.6222 17.5648 22.8982 17.2773 22.9966 16.8952C23.1358 16.3534 23.5 14.0777 23.5 10.4999C23.5 6.92215 23.1358 4.64771 22.9966 4.10465ZM25.4716 3.4696C26.0556 5.7466 26.0556 10.4999 26.0556 10.4999C26.0556 10.4999 26.0556 15.2533 25.4716 17.5303C25.1471 18.7889 24.1977 19.7792 22.9953 20.1139C20.8116 20.7222 13.2778 20.7222 13.2778 20.7222C13.2778 20.7222 5.74783 20.7222 3.56028 20.1139C2.35278 19.774 1.40467 18.785 1.08394 17.5303C0.5 15.2533 0.5 10.4999 0.5 10.4999C0.5 10.4999 0.5 5.7466 1.08394 3.4696C1.4085 2.21099 2.35789 1.22071 3.56028 0.885932C5.74783 0.27771 13.2778 0.27771 13.2778 0.27771C13.2778 0.27771 20.8116 0.27771 22.9953 0.885932C24.2028 1.22582 25.1509 2.21482 25.4716 3.4696ZM10.7222 14.9722V6.02771L18.3889 10.4999L10.7222 14.9722Z" fill="#999999" />
            </svg>
        </button>
    </div>
</div>
<?php
$hide_footer = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>