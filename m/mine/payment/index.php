<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
function isMobileDevice()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $mobileKeywords = array('mobile', 'android', 'iphone', 'ipod', 'blackberry', 'windows phone');

    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            return true;
        }
    }

    return false;
}

//카드정보얻기
$SQL_QUERY =    "SELECT 
                    A.*
                FROM 
                    `" . $Tname . "comm_member_pay` AS A
                WHERE
                    A.STR_USERID='$arr_Auth[0]'
                ORDER BY DTM_INDATE DESC
                LIMIT 1 ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$card_Data = mysql_fetch_assoc($arr_Rlt_Data);

// 사용자정보 얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_member AS A
                WHERE
                    A.STR_USERID="' . $arr_Auth[0] . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$user_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div class="mt-[30px] flex flex-col items-center w-full px-[14px]">
    <p class="font-extrabold text-lg leading-5 text-black">자동 결제 수단 등록</p>
    <?php
    if ($card_Data) {
    ?>
        <!-- 카드가 등록된 상태 -->
        <div class="flex flex-col items-center gap-8 w-full">
            <!-- 카드 -->
            <div class="mt-[22px] flex flex-col border border-solid border-black bg-[#2395FF] rounded-[10px] relative w-[280px] h-[165px]">
                <div class="flex p-[15px] h-[112px]">
                    <p class="font-bold text-xs leading-[14px] text-white"><?= fnc_card_kind($card_Data['STR_CARDCODE']) ?></p>
                </div>
                <hr class="border-t-[1px] border-white">
                <div class="flex-1 flex justify-end items-center px-[15px]">
                    <?php
                    $characters = str_split($card_Data['STR_CARDNO']);
                    $card_number_array = array_chunk($characters, 4);
                    ?>
                    <p class="font-bold text-xs leading-[10px] text-white">**** **** **** <?= $card_number_array[3] ?: '' ?></p>
                </div>
            </div>
            <!-- 대표 카드 변경 -->
            <button type="button" class="flex justify-center items-center w-full h-[45px] border-[0.72px] border-solid border-[#DDDDDD] bg-whtie" onclick="changeCard()">
                <p class="font-bold text-xs leading-[14px] text-[#666666]">대표 카드 변경</p>
            </button>
        </div>
    <?php
    } else {
    ?>
        <!-- 등록된 카드가 없는 상태 -->
        <div class="flex">
            <!-- 카드 -->
            <button type="button" class="mt-[22px] flex flex-col gap-[15px] justify-center items-center border border-solid border-[#DDDDDD] bg-white rounded-[10px] w-[280px] h-[165px]" onclick="addCard()">
                <div class="flex justify-center items-center w-[42px] h-[42px] bg-white border border-solid border-[#DDDDDD] rounded-full">
                    <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.17 0V7.84H16.8V9.31H9.17V17.64H7.63V9.31H0V7.84H7.63V0H9.17Z" fill="#DDDDDD" />
                    </svg>
                </div>
                <p class="font-bold text-sm leading-4 text-[#666666]">결제 카드를 등록해보세요.</p>
            </button>
        </div>
    <?php
    }
    ?>

    <div class="mt-[15px] flex flex-col gap-[7px] w-full px-[9px] py-[15px] bg-[#F5F5F5]">
        <p class="font-bold text-xs leading-[14px] text-black">자동 결제 수단 등록 안내</p>
        <p class="font-normal text-[10px] leading-4 text-[#999999]">
            -본인 명의의 카드만 등록 가능합니다.<br>
            -만 19세 이상 성인에게만 제공되는 서비스입니다.<br>
            -무이자 및 할부 혜택은 카드 일반 결제에서만 가능합니다.<br>
            -구독권 정기 결제는 무이자 및 할부 혜택을 받을 수 없습니다.<br>
        </p>
    </div>

    <?php
    if ($card_Data) {
    ?>
        <!-- 결제 내역 -->
        <div class="mt-[30px] flex flex-col w-full">
            <p class="font-extrabold text-sm leading-[15px] text-black">결제 내역</p>
            <hr class="mt-[14px] border-t-[0.5px] border-solid border-[#E0E0E0]" />
            <div class="mt-[15px] relative flex w-full">
                <select name="" id="filter_period" class="bg-white border-[0.72px] border-[#DDDDDD] rounded-[3px] px-2.5 w-full h-[45px] font-normal text-xs leading-[14px] text-[#666666]" onchange="changePeriod()">
                    <option value="3">최근 3개월</option>
                    <option value="6">최근 6개월</option>
                    <option value="12">최근 12개월</option>
                </select>
                <div class="absolute top-5 right-5 pointer-events-none">
                    <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.6398 1.67005L6.79074 5.86313C6.73301 5.9129 6.67047 5.94807 6.60312 5.96865C6.53578 5.98955 6.46362 6 6.38665 6C6.30968 6 6.23752 5.98955 6.17017 5.96865C6.10282 5.94807 6.04028 5.9129 5.98256 5.86313L1.11904 1.67005C0.98434 1.55392 0.916992 1.40876 0.916992 1.23456C0.916992 1.06037 0.989151 0.91106 1.13347 0.786636C1.27779 0.662212 1.44616 0.6 1.63858 0.6C1.83101 0.6 1.99938 0.662212 2.1437 0.786636L6.38665 4.4447L10.6296 0.786635C10.7643 0.670507 10.9302 0.612442 11.1272 0.612442C11.3246 0.612442 11.4955 0.674654 11.6398 0.799078C11.7841 0.923502 11.8563 1.06866 11.8563 1.23456C11.8563 1.40046 11.7841 1.54562 11.6398 1.67005Z" fill="#333333" />
                    </svg>
                </div>
            </div>
            <div id="pay_list" class="mt-2 flex flex-col w-full">
            </div>
        </div>
    <?php
    }
    ?>
</div>

<?php
$payment_url = isMobileDevice() ? '/payment/linux/auto_pay/mo/mobile_auth/order_mobile.php' : '/payment/linux/auto_pay/pc/sample/auth/request_key.php';
?>

<form name="add_card" action="<?= $payment_url ?>" method="post">
    <input type="hidden" name="str_userid" value="<?= $user_Data['STR_USERID'] ?>">
    <input type="hidden" name="ordr_idxx" value="">
    <input type="hidden" name="good_name" value="카드등록">
    <input type="hidden" name="good_mny" value="0">
    <input type="hidden" name="buyr_name" value="<?= $user_Data['STR_NAME'] ?>">
    <input type="hidden" name="buyr_mail" value="<?= $user_Data['STR_EMAIL'] ?>">
    <input type="hidden" name="buyr_tel1" value="<?= $user_Data['STR_TELEP'] ?>">
    <input type="hidden" name="buyr_tel2" value="<?= $user_Data['STR_HP'] ?>">
    <input type="hidden" name="kcp_group_id" value="">
</form>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    filter_period = '3';
    int_card = '<?= $card_Data['INT_NUMBER'] ?>';

    $(document).ready(function() {
        searchPay();
    });

    function searchPay(page = 0) {
        url = "get_pay_list.php";
        url += "?page=" + page;
        url += "&filter_period=" + filter_period;
        url += "&int_card=" + int_card;

        $.ajax({
            url: url,
            success: function(result) {
                $("#pay_list").html(result);
            }
        });
    }

    function changePeriod() {
        filter_period = document.getElementById("filter_period").value;
        searchPay();
    }

    function changeCard() {
        if (confirm("정말로 카드를 변경하시겠습니까?")) {
            document.forms.add_card.submit();
        }
    }

    function addCard() {
        document.forms.add_card.submit();
    }

    function deleteCard() {
        if (confirm("정말로 카드를 삭제하시겠습니까?")) {
            window.location.href = "delete_card_proc.php";
        }
    }
</script>