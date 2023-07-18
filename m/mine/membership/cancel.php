<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
$int_type = $_GET['int_type'];

//멤버십정보얻기
$SQL_QUERY =    'SELECT 
                    A.*
                FROM 
                    `' . $Tname . 'comm_membership` A
                WHERE 
                    A.STR_USERID = "' . $arr_Auth[0] . '"
					AND NOW() BETWEEN A.DTM_SDATE AND A.DTM_EDATE
                    AND A.STR_PASS = "0"
                    AND A.INT_TYPE = ' . $int_type;

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

//카드정보얻기
$SQL_QUERY =    "SELECT 
                    A.STR_BILLCODE, A.INT_NUMBER
                FROM 
                    `" . $Tname . "comm_member_pay` AS A
                WHERE
                    A.STR_USERID='$arr_Auth[0]'
                    AND A.STR_USING <> 'N'
                ORDER BY DTM_INDATE DESC
                LIMIT 1 ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$card_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div class="mt-[30px] flex flex-col items-center w-full px-[14px]">
    <div x-data="{ type: 1 }" class="flex flex-col items-center w-full">
        <p class="font-extrabold text-lg leading-5 text-black">멤버십 취소</p>
        <p class="mt-[22px] font-medium text-[15px] leading-[19px] text-[#6A696C] text-center">
            <?= $int_type == 1 ? '구독' : '블랑 렌트' ?> 멤버십을 <span class="text-black">해지</span>하시겠습니까?
        </p>
        <div class="mt-[13px] flex py-3 justify-center border-t-[0.5px] border-b-[0.5px] border-[#E0E0E0] w-full">
            <p class="font-semibold text-[15px] leading-[18px] text-[#6A696C]">
                멤버십 종료 예정일: <span class="text-black"><?= date('Y. m. d', strtotime($arr_Data['DTM_EDATE'])) ?></span>
            </p>
        </div>
        <div class="mt-[15px] flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
            <?php
            if ($int_type == 1) {
            ?>
                <p class="font-bold text-xs leading-[14px] text-black">구독 멤버십 해지 안내</p>
                <p class="font-normal text-[10px] leading-4 text-[#999999]">
                    -구독 멤버십에 가입할 경우 에이블랑 구독 전용 상품들을 월 89,000원으로<br>
                    교환 횟수 제한 없이 이용할 수 있습니다.<br>
                    -멤버십을 해지할 경우 기간 종료일까지는 현재 이용중인 상품의 이용이 가능하며<br>
                    종료일 이후 자동결제가 이루어지지 않습니다.<br>
                    -구독 멤버십을 해지할 경우 멤버십 종료일에 맞추어 이용중인 상품의<br>
                    반납신청을 별도로 해주셔야 합니다.<br>
                    -멤버십 해지 이후 재가입을 원하실 경우 [멤버십 관리] 페이지를 이용해주세요.<br>
                </p>
            <?php
            } else {
            ?>
                <p class="font-bold text-xs leading-[14px] text-black">블랑 렌트 멤버십 해지 안내</p>
                <p class="font-normal text-[10px] leading-4 text-[#999999]">
                    -블랑 렌트 멤버십에 가입할 경우 에이블랑의 RENT 전용 상품들을<br>
                    30% 할인된 가격에 이용할 수 있습니다.<br>
                    -멤버십을 해지할 경우 기간 종료일까지는 멤버십 혜택이 적용되며,<br>
                    종료일 이후 자동결제가 이루어지지 않습니다.<br>
                    -멤버십 해지 이후 재가입을 원하실 경우 [멤버십 관리] 페이지를 이용해주세요.<br>
                </p>
            <?php
            }
            ?>
        </div>
        <div class="mt-8 flex gap-[5px] w-full">
            <button type="button" class="flex justify-center items-center border border-solid border-[#DDDDDD] bg-black w-full h-[45px]" onclick="document.getElementById('confirm_dialog').classList.remove('hidden');">
                <p class="font-bold text-xs leading-[14px] text-white">해지하기</p>
            </button>
        </div>
    </div>
</div>

<div id="confirm_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden" style="height: calc(100vh - 66px);">
    <div class="mt-[60%] flex flex-col items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
        <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('confirm_dialog').classList.add('hidden');">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <?php
        if ($int_type == 1) {
        ?>
            <p class="font-bold text-xs leading-[18px] text-[#666666] text-center">
                멤버십을 해지할 경우 이용권 종료 예정일에 맞추어<br>
                이용중인 상품의 반납신청을 해주셔야 합니다.<br>
            </p>
            <p class="font-bold text-[10px] leading-[18px] text-[#666666] text-center">
                *자동으로 반납신청 되지 않으니 반드시 별도의 반납신청 부탁드립니다.<br>
            </p>
        <?php
        } else {
        ?>
            <p class="font-bold text-xs leading-[18px] text-[#666666] text-center">
                블랑렌트 멤버십을 해지할 경우<br>
                RENT 전용 상품 30% 할인 혜택이 적용되지 않습니다.<br>
                멤버십 해지 신청을 하시겠습니까?<br>
            </p>
        <?php
        }
        ?>

        <div class="mt-[11px] flex justify-center gap-[5px]">
            <a href="/m/mine/membership/index.php" class="flex justify-center items-center gap-[4.69px] w-[90px] h-[30px] bg-white border-[0.84px] border-solid border-[#D9D9D9]">
                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.05856 9.0481L0.128288 4.95636C0.0816375 4.90765 0.0486715 4.85488 0.0293895 4.79805C0.0097964 4.74122 0 4.68033 0 4.61538C0 4.55044 0.0097964 4.48955 0.0293895 4.43272C0.0486715 4.37589 0.0816375 4.32312 0.128288 4.27441L4.05856 0.170489C4.16741 0.0568296 4.30347 0 4.46675 0C4.63002 0 4.76998 0.060889 4.8866 0.182667C5.00323 0.304445 5.06154 0.446519 5.06154 0.60889C5.06154 0.77126 5.00323 0.913335 4.8866 1.03511L1.45782 4.61538L4.8866 8.19566C4.99545 8.30932 5.04988 8.44928 5.04988 8.61555C5.04988 8.78214 4.99156 8.92632 4.87494 9.0481C4.75831 9.16988 4.62225 9.23077 4.46675 9.23077C4.31125 9.23077 4.17519 9.16988 4.05856 9.0481Z" fill="#666666" />
                </svg>
                <p class="font-bold text-[10px] leading-[11px] text-[#666666]">돌아가기</p>
            </a>
            <button class="flex justify-center items-center w-[90px] h-[30px] bg-black border-[0.84px] border-solid border-[#D9D9D9]" onclick="cancelMembership()">
                <p class="font-bold text-[10px] leading-[11px] text-white">해지하기</p>
            </button>
        </div>
    </div>
</div>

<div id="result_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden" style="height: calc(100vh - 66px);">
    <div class="mt-[60%] flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
        <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('result_dialog').classList.add('hidden');">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <p class="font-bold text-[15px] leading-[17px] text-black">해지 신청이 완료되었습니다.</p>
        <a href="/m/mine/membership/index.php" class="flex flex-row gap-[12.3px] items-center justify-center px-5 py-2.5 bg-white border-[0.84px] border-solid border-[#D9D9D9]">
            <p class="font-bold text-[10px] leading-[11px] text-[#666666]">멤버십 관리 바로가기</p>
            <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.52603 9.0481L5.45631 4.95636C5.50296 4.90765 5.53592 4.85488 5.55521 4.79805C5.5748 4.74122 5.58459 4.68033 5.58459 4.61538C5.58459 4.55044 5.5748 4.48955 5.55521 4.43272C5.53592 4.37589 5.50296 4.32312 5.45631 4.27441L1.52603 0.170489C1.41718 0.0568296 1.28112 0 1.11785 0C0.95457 0 0.814619 0.060889 0.697994 0.182667C0.581368 0.304445 0.523056 0.446519 0.523056 0.60889C0.523056 0.77126 0.581368 0.913335 0.697994 1.03511L4.12678 4.61538L0.697994 8.19566C0.589143 8.30932 0.534719 8.44928 0.534719 8.61555C0.534719 8.78214 0.593031 8.92632 0.709656 9.0481C0.826282 9.16988 0.962345 9.23077 1.11785 9.23077C1.27335 9.23077 1.40941 9.16988 1.52603 9.0481Z" fill="#666666" />
            </svg>
        </a>
    </div>
</div>


<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    function cancelMembership() {
        url = "membership_proc.php";
        url += "?RetrieveFlag=CANCEL";
        url += "&int_type=<?= $int_type ?>";

        $.ajax({
            url: url,
            success: function(result) {
                if (result == 'successful') {
                    document.getElementById('confirm_dialog').classList.add('hidden');
                    document.getElementById('result_dialog').classList.remove('hidden');
                } else {
                    alert(result);
                }
            }
        });
    }
</script>