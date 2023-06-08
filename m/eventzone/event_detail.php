<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php"; ?>

<?php
$int_number = Fnc_Om_Conv_Default($_REQUEST['int_number'], '');

$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_event AS A
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
    <p class="font-extrabold text-lg leading-5 text-[#333333]">EVENT</p>
</div>

<div class="flex flex-col w-full">
    <div class="flex flex-col gap-[9px] px-[14px] py-5">
        <p class="font-extrabold text-lg leading-5 text-[#333333]"><?= $arr_Data['STR_TITLE'] ?></p>
        <p class="font-bold text-xs leading-[14px] text-[#333333]"><?= $arr_Data['STR_CONT'] ?></p>
    </div>

    <div class="mt-5 flex w-full">
        <img src="/admincenter/files/event/<?= $arr_Data['STR_IMAGE'] ?>" onerror="this.style.display = 'none'" alt="event">
    </div>
    
    <!-- 알람 -->
    <div class="mt-10 flex flex-col w-full gap-10">
        <div class="flex flex-col gap-[5px] w-full bg-[#EAEAEA] px-[14px] py-5">
            <div class="flex items-center gap-1">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 0.000128502C9.48913 0.000128502 11.3967 0.790269 12.8033 2.19678C14.2099 3.6033 15 5.51105 15 7.50006C15 9.48908 14.2099 11.3968 12.8033 12.8033C11.3968 14.2099 9.48903 15 7.5 15C5.51097 15 3.60327 14.2099 2.19668 12.8033C0.790148 11.3968 2.52514e-07 9.48908 2.52514e-07 7.50006C0.00213476 5.5116 0.79304 3.60529 2.19905 2.19903C3.60519 0.793033 5.51142 0.00212144 7.50013 0L7.5 0.000128502ZM7.5 12.0001C7.69889 12.0001 7.88974 11.9211 8.03037 11.7804C8.17099 11.6397 8.24997 11.449 8.24997 11.2501C8.24997 11.0511 8.17099 10.8604 8.03037 10.7198C7.88974 10.5791 7.6989 10.5 7.5 10.5C7.3011 10.5 7.11026 10.5791 6.96964 10.7198C6.82901 10.8604 6.75003 11.0511 6.75003 11.2501C6.75003 11.449 6.82901 11.6397 6.96964 11.7804C7.11026 11.9211 7.3011 12.0001 7.5 12.0001ZM6.75003 9.00012C6.75003 9.26806 6.89292 9.51566 7.12495 9.64963C7.35699 9.7836 7.64301 9.7836 7.87505 9.64963C8.10709 9.51566 8.24997 9.26806 8.24997 9.00012V3.74987C8.24997 3.48193 8.10708 3.23433 7.87505 3.10036C7.64302 2.96638 7.357 2.96638 7.12495 3.10036C6.89291 3.23433 6.75003 3.48193 6.75003 3.74987V9.00012Z" fill="#333333" />
                </svg>
                <p class="font-extrabold text-[15px] leading-[17px] text-[#333333]">꼭 확인해주세요</p>
            </div>
            <p class="font-bold text-xs leading-[23px] text-[#333333]">
                <?php
                for ($i = 0; $i < 5; $i++) {
                ?>
                    ・본 이벤트는 2023.01부터 2023.02까지 진행됩니다.<br>
                <?php
                }
                ?>
            </p>
        </div>
    </div>

    <!-- 관련 상품 -->
    <div class="mt-5 flex flex-col gap-5 px-[14px]">
        <p class="font-extrabold text-lg leading-5 text-[#333333]">관련 상품</p>
        <div class="grid grid-cols-2 gap-x-[13.5px] gap-y-[30.45px] w-full">
            <?php
            $SQL_QUERY =    'SELECT 
                                A.*, B.STR_CODE
                            FROM 
                                ' . $Tname . 'comm_goods_master A
                            LEFT JOIN
                                ' . $Tname . 'comm_com_code B
                            ON
                                A.INT_BRAND=B.INT_NUMBER
                            LEFT JOIN
                                ' . $Tname . 'comm_member_basket C
                            ON
                                A.STR_GOODCODE=C.STR_GOODCODE
                                AND C.STR_USERID="' . $arr_Auth[0] . '"
                            WHERE 
                                C.STR_USERID IS NULL
                            ORDER BY A.INT_VIEW DESC
                            LIMIT 4';

            $product_result = mysql_query($SQL_QUERY);

            while ($row = mysql_fetch_assoc($product_result)) {
            ?>
                <a href="/m/product/detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="flex flex-col w-full">
                    <div class="w-full flex justify-center items-center relative px-2.5 bg-[#F9F9F9] rounded-[5px] h-[176px]">
                        <!-- 타그 -->
                        <div class="justify-center items-center w-[25px] h-[25px] bg-[#00402F] absolute top-2 left-2 <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>">
                            <p class="font-extrabold text-[9px] text-center text-white"><?= $row['INT_DISCOUNT'] ?>%</p>
                        </div>
                        <img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
                    </div>
                    <p class="mt-[5.52px] font-extrabold text-[9px] text-[#666666]"><?= $row['STR_CODE'] ?></p>
                    <p class="mt-[3.27px] font-bold text-[9px] text-[#333333]"><?= $row['STR_GOODNAME'] ?></p>
                    <div class="mt-[7.87px] flex gap-[3px] items-center">
                        <p class="font-bold text-xs text-black">일 <?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원</p>
                        <p class="font-bold text-[10px] line-through text-[#666666] <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>"><?= number_format($row['INT_PRICE']) ?>원</p>
                    </div>
                </a>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php"; ?>