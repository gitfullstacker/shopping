<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
$int_type = $_GET['int_type'];

//구독멤버십정보얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_membership AS A
                WHERE
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.INT_TYPE=' . $int_type . '
                    AND CURDATE() BETWEEN A.DTM_SDATE AND A.DTM_EDATE';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div class="mt-[30px] flex flex-col items-center w-full px-[14px]">
    <div x-data="{ type: 1 }" class="flex flex-col items-center w-full">
        <p class="font-extrabold text-lg leading-5 text-black">멤버십 취소</p>
        <p class="mt-[22px] font-medium text-[15px] leading-[19px] text-[#6A696C] text-center">
            에이블랑 <?= $int_type == 1 ? '정기 구독' : '블랑 렌트' ?> 멤버십을<br>
            <span class="text-black">해지</span>하실 건가요?
        </p>
        <div class="mt-[13px] flex py-3 justify-center border-t-[0.5px] border-b-[0.5px] border-[#E0E0E0] w-full">
            <p class="font-semibold text-[15px] leading-[18px] text-[#6A696C]">
                이용권 종료 예정일: <span class="text-black"><?= date('Y. m. d', strtotime($arr_Data['DTM_EDATE'])) ?></span>
            </p>
        </div>
        <div class="mt-[15px] flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
            <p class="font-bold text-[10px] leading-[140%] text-black">구독권 연장/취소 안내</p>
            <p class="font-bold text-[10px] leading-[140%] text-[#999999]">
                -구독권 연장은 자동 결제 수단으로 등록된 카드로 자동 결제됩니다.<br>
                (홈 > 마이페이지 > 에이블랑 결제관리 페이지 참조)<br>
                -구독권 취소 관련 조항은 아래 문단 확인 부탁드립니다.<br>
                -구독권 정기 결제는 무이자 및 할부 혜택을 받을 수 없습니다.<br>
                -카드 등록이 안될 시 각 카드사에 문의 부탁드립니다.
            </p>
        </div>
        <div class="mt-8 flex gap-[5px] w-full">
            <button type="reset" class="flex justify-center items-center border border-solid border-[#DDDDDD] bg-white w-full h-[45px]" onclick="cancelMembership()">
                <p class="font-bold text-xs leading-[14px] text-[#666666]">해지하기</p>
            </button>
            <a href="/m/mine/membership/index.php" class="flex justify-center items-center border border-solid border-[#DDDDDD] bg-black w-full h-[45px]">
                <p class="font-bold text-xs leading-[14px] text-white">유지하기</p>
            </a>
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
        document.getElementById('result_dialog').classList.remove('hidden');
    }
</script>