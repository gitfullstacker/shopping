<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php"; ?>

<?php
$int_number = Fnc_Om_Conv_Default($_REQUEST['int_number'], '');

$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_plan AS A
                WHERE
                    A.INT_NUMBER=' . $int_number;

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<!-- Header -->
<div class="flex justify-center items-center h-[57px] border-b-[0.5px] border-[#E0E0E0] relative">
    <a href="index.php" class="absolute left-[29px] top-[22px]">
        <svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.41475 14.2576L0.202765 7.81002C0.129032 7.73327 0.0769276 7.65012 0.0464514 7.56057C0.0154837 7.47102 0 7.37507 0 7.27273C0 7.17038 0.0154837 7.07444 0.0464514 6.98489C0.0769276 6.89534 0.129032 6.81218 0.202765 6.73543L6.41475 0.268649C6.58679 0.0895498 6.80184 0 7.05991 0C7.31797 0 7.53917 0.0959463 7.7235 0.287839C7.90783 0.479731 8 0.703606 8 0.959463C8 1.21532 7.90783 1.43919 7.7235 1.63109L2.30415 7.27273L7.7235 12.9144C7.89555 13.0935 7.98157 13.314 7.98157 13.576C7.98157 13.8385 7.8894 14.0657 7.70507 14.2576C7.52074 14.4495 7.30568 14.5455 7.05991 14.5455C6.81413 14.5455 6.59908 14.4495 6.41475 14.2576Z" fill="#333333" />
        </svg>
    </a>
    <p class="font-extrabold text-lg leading-5 text-[#333333]">NEWS LETTER</p>
</div>

<div class="flex flex-col w-full">
    <div class="flex flex-col gap-[9px] px-[14px] py-5">
        <p class="font-extrabold text-lg leading-5 text-[#333333]"><?= $arr_Data['STR_TITLE'] ?></p>
        <p class="font-bold text-xs leading-[14px] text-[#333333]"><?= $arr_Data['STR_CONT'] ?></p>
    </div>
</div>

<div class="mt-5 flex w-full">
    <img class="min-w-full" src="/admincenter/files/plan/<?= $arr_Data['STR_IMAGE'] ?>" onerror="this.style.display = 'none'" alt="event">
</div>

<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php"; ?>