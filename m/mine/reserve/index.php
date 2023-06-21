<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
$SQL_QUERY =    'SELECT
                    A.INT_MILEAGE
                FROM 
                    ' . $Tname . 'comm_member A
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div x-data="{ menu: 1 }" class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-5 text-black">적립금 현황</p>
    </div>
    <div class="mt-[14px] flex flex-col w-full divide-y-[0.5px] divide-[#E0E0E0] bg-white border border-solid border-[#DDDDDD]">
        <div class="flex flex-col gap-[5px] px-[15px] py-5">
            <p class="font-bold text-sm leading-4 text-[#666666]">나의 적립금</p>
            <p class="font-extrabold text-[25px] leading-[28px] text-black"><?= number_format($arr_Data['INT_MILEAGE']) ?>원</p>
        </div>
        <div class="px-[15px] py-3">
            <p class="font-medium text-xs leading-[14px] text-[#999999]">소멸예정 적립금(30일 이내 소멸예정): <?= number_format($arr_Data['INT_MILEAGE']) ?>원</p>
        </div>
    </div>

    <hr class="mt-[15px] border-t-[0.5px] border-[#E0E0E0]">

    <div class="mt-[15px] flex flex-col gap-[23px] w-full">
        <div class="relative w-full">
            <select class="w-full h-[45px] pl-[15px] pr-[30px] bg-white border border-solid border-[#DDDDDD] font-normal text-xs leading-14px placeholder:text-[#666666]" onchange="handlePeriodChange(this.value)">
                <option value="3">최근 3개월</option>
                <option value="6">최근 6개월</option>
                <option value="12">최근 12개월</option>
            </select>
            <div class="absolute top-[19.6px] right-5">
                <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.6398 1.67005L6.79074 5.86313C6.73301 5.9129 6.67047 5.94807 6.60312 5.96865C6.53578 5.98955 6.46362 6 6.38665 6C6.30968 6 6.23752 5.98955 6.17017 5.96865C6.10282 5.94807 6.04028 5.9129 5.98256 5.86313L1.11904 1.67005C0.98434 1.55392 0.916992 1.40876 0.916992 1.23456C0.916992 1.06037 0.989151 0.91106 1.13347 0.786636C1.27779 0.662212 1.44616 0.6 1.63858 0.6C1.83101 0.6 1.99938 0.662212 2.1437 0.786636L6.38665 4.4447L10.6296 0.786635C10.7643 0.670507 10.9302 0.612442 11.1272 0.612442C11.3246 0.612442 11.4955 0.674654 11.6398 0.799078C11.7841 0.923502 11.8563 1.06866 11.8563 1.23456C11.8563 1.40046 11.7841 1.54562 11.6398 1.67005Z" fill="#333333" />
                </svg>
            </div>
        </div>
        <div class="flex flex-col w-full" id="reserve_list">
        </div>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    period = 3;

    $(document).ready(function() {
        searchReserve();
    });

    function searchReserve(page = 0) {
        url = "get_reserve_list.php";
        url += "?page=" + page;
        url += "&period=" + period;

        $.ajax({
            url: url,
            success: function(result) {
                $("#reserve_list").html(result);
            }
        });
    }

    function handlePeriodChange(period_value) {
        period = period_value;
        searchReserve();
    }
</script>