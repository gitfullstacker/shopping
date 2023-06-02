<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
$int_number = Fnc_Om_Conv_Default($_REQUEST['int_number'], '');

$SQL_QUERY =    'SELECT
                    A.*, B.INT_NUMBER AS A_INT_NUMBER, B.DTM_INDATE AS A_DTM_INDATE, B.STR_CONT AS A_STR_CONT
                FROM 
                    ' . $Tname . 'comm_member_qna AS A
                LEFT JOIN
                    ' . $Tname . 'comm_member_qna AS B
                ON
                    A.INT_NUMBER=B.INT_IDX
                    AND B.INT_LEVEL=1
                WHERE
                    A.INT_NUMBER=' . $int_number;

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div x-data="{ menu: 1 }" class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">1:1 문의</p>
    </div>

    <hr class="mt-[15px] border-t-[0.5px] border-[#E0E0E0]" />

    <div class="mt-[15px] flex flex-col gap-[7px] w-full pb-[15px] border-b-[0.5px] border-[#E0E0E0]">
        <p class="font-bold text-[10px] leading-[11px]"><?= date('Y.m.d', strtotime($arr_Data['DTM_INDATE'])) ?></p>
        <div class="flex justify-between items-center">
            <div class="flex flex-col gap-1.5">
                <p class="font-bold text-xs leading-[14px] text-[#666666]">[상품문의]</p>
                <p class="font-bold text-xs leading-[14px] text-[#666666]"><?= $arr_Data['STR_TITLE'] ?></p>
            </div>
            <a href="remove_qna_list.php?int_number=<?= $arr_Data['INT_NUMBER'] ?>" class="flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-[3px] w-[50px] h-[25px]">
                <p class="font-bold text-[9px] leading-[9px] text-[#666666]">삭제</p>
            </a>
        </div>
    </div>

    <div class="mt-4 flex flex-col w-full">
        <img class="w-full" src="/admincenter/files/qna/<?= $arr_Data['STR_IMAGE1'] ?>" alt="">
        <p class="mt-5 font-bold text-xs leading-[19px] text-[#666666]">
            <?= $arr_Data['STR_CONT'] ?>
        </p>
    </div>

    <hr class="mt-[29px] border-t-[0.5px] border-[#E0E0E0]" />

    <?php
    if ($arr_Data['A_INT_NUMBER']) {
    ?>
        <div class="mt-[15px] flex flex-col gap-[7px] w-full pb-[15px] border-b-[0.5px] border-[#E0E0E0]">
            <p class="font-bold text-[10px] leading-[11px]"><?= date('Y.m.d', strtotime($arr_Data['A_DTM_INDATE'])) ?></p>
            <div class="flex justify-between items-center">
                <div class="flex flex-col gap-1.5">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">[상품문의]</p>
                    <p class="font-bold text-xs leading-[14px] text-[#666666]"><?= $arr_Data['A_STR_CONT'] ?></p>
                </div>
                <p class="font-bold text-xs leading-[14px] text-black">답변완료</p>
            </div>
        </div>
        <p class="mt-5 font-bold text-xs leading-[19px] text-[#666666]">
            <?= $arr_Data['STR_CONT'] ?>
        </p>
    <?php
    }
    ?>

    <a href="index.php" class="mt-[27px] flex justify-center items-center w-full h-[45px] bg-black border border-solid border-[#DDDDDD]">
        <p class="font-bold text-xs leading-[12px] text-white">목록으로 돌아가기</p>
    </a>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>