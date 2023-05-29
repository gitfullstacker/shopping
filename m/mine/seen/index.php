<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
$hide_right_menu = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
$SQL_QUERY =    'SELECT
                    A.DTM_INDATE, B.*, C.STR_CODE, (SELECT COUNT(D.STR_GOODCODE) FROM ' . $Tname . 'comm_member_like AS D WHERE B.STR_GOODCODE=D.STR_GOODCODE AND D.STR_USERID="' . ($arr_Auth[0] ?: 'NULL') . '") AS IS_LIKE
                FROM 
                    ' . $Tname . 'comm_member_seen A
                JOIN
                    ' . $Tname . 'comm_goods_master B
                ON
                    A.STR_GOODCODE=B.STR_GOODCODE
                JOIN
                    ' . $Tname . 'comm_com_code C
                ON
                    B.INT_BRAND=C.INT_NUMBER
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                ORDER BY A.DTM_INDATE DESC';

$seen_list_result = mysql_query($SQL_QUERY);

$productSeenByDate = array();

// 날짜별로 구분화
while ($row = mysql_fetch_assoc($seen_list_result)) {
    // Get the date from the datetime value
    $date = date('Y-m-d', strtotime($row['DTM_INDATE']));

    // Check if the date already exists in the productSeenByDate array
    if (array_key_exists($date, $productSeenByDate)) {
        // Add the current record to the existing date key
        $productSeenByDate[$date][] = $row;
    } else {
        // Create a new key with the current date and add the record
        $productSeenByDate[$date] = array($row);
    }
}
?>

<div class="mt-[6px] flex flex-col w-full">
    <div class="flex justify-end px-[14px]">
        <button>
            <p class="font-bold text-xs leading-[14px] underline text-[#666666]">전체삭제</p>
        </button>
    </div>

    <div class="mt-6 flex flex-col gap-6 w-full">
        <?php
        $split_date = '';
        foreach ($productSeenByDate as $date => $seenData) {
        ?>
            <div class="flex flex-col gap-[30px] w-full">
                <div class="flex justify-center py-[6px] border-b-[0.5px] border-[#E0E0E0]">
                    <p class="font-extrabold text-lg leading-5 text-center text-[#333333]"><?= date('Y. m. d', strtotime($date)) ?></p>
                </div>
                <div class="flex flex-col gap-[15px] w-full px-[14px]">
                    <?php
                    foreach ($seenData as $seenInfo) {
                    ?>
                        <div class="flex flex-row gap-2.5">
                            <div class="w-[91px] h-[91px] flex justify-center items-center p-2 bg-[#F9F9F9] rounded-[4px]">
                                <img src="/admincenter/files/good/<?= $seenInfo['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="product">
                            </div>
                            <div class="grow flex justify-between py-1">
                                <div class="flex flex-col w-full">
                                    <div class="flex justify-center items-center w-[25px] h-[14px] bg-[<?= ($seenInfo['INT_TYPE'] == 1 ? '#EEAC4C' : ($seenInfo['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                                        <p class="font-normal text-[8px] leading-[9px] text-center text-white">
                                            <?= ($seenInfo['INT_TYPE'] == 1 ? '구독' : ($seenInfo['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?>
                                        </p>
                                    </div>
                                    <p class="mt-1.5 font-bold text-[11px] leading-3 text-black"><?= $seenInfo['STR_CODE'] ?></p>
                                    <p class="mt-1 font-bold text-[9px] leading-[10px] text-[#666666]"><?= $seenInfo['STR_GOODNAME'] ?></p>
                                    <?php
                                    switch ($seenInfo['INT_TYPE']) {
                                        case 1:
                                    ?>
                                            <p class="mt-2.5 font-bold text-[9px] text-[#999999]">월정액 구독 전용</p>
                                            <div class="mt-[3.39px] flex gap-2 items-center">
                                                <p class="font-bold text-[9px] text-black"><span class="text-[#EEAC4C]">월</span> <?= number_format($seenInfo['INT_PRICE']) ?>원</p>
                                            </div>
                                        <?php
                                            break;

                                        case 2:
                                        ?>
                                            <p class="mt-2.5 font-bold text-[9px] line-through text-[#999999]"><?= $seenInfo['INT_DISCOUNT'] ? ('일 ' . number_format($seenInfo['INT_PRICE']) . '원') : '' ?></p>
                                            <div class="mt-[3.39px] flex gap-2 items-center">
                                                <p class="font-bold text-[9px] text-[#00402F]"><?= $seenInfo['INT_DISCOUNT'] ? (number_format($seenInfo['INT_DISCOUNT']) . '%') : '' ?></p>
                                                <p class="font-extrabold text-[9px] text-black">일 <?= $seenInfo['INT_DISCOUNT'] ? number_format($seenInfo['INT_PRICE'] * $seenInfo['INT_DISCOUNT'] / 100) : number_format($seenInfo['INT_PRICE']) ?>원</p>
                                            </div>
                                        <?php
                                            break;
                                        case 3:
                                        ?>
                                            <p class="mt-2.5 font-bold text-[9px] line-through text-[#999999]"><?= $seenInfo['INT_DISCOUNT'] ? (number_format($seenInfo['INT_PRICE']) . '원') : '' ?></p>
                                            <div class="mt-[3.39px] flex gap-2 items-center">
                                                <p class="font-bold text-[9px] text-[#7E6B5A]"><?= $seenInfo['INT_DISCOUNT'] ? (number_format($seenInfo['INT_DISCOUNT']) . '%') : '' ?></p>
                                                <p class="font-extrabold text-[9px] text-black"><?= $seenInfo['INT_DISCOUNT'] ? number_format($seenInfo['INT_PRICE'] * $seenInfo['INT_DISCOUNT'] / 100) : number_format($seenInfo['INT_PRICE']) ?>원</p>
                                            </div>
                                    <?php
                                            break;
                                    }
                                    ?>
                                </div>
                                <div class="flex justify-center items-center w-[15px] h-[15px]" onclick="setLike('<?= $seenInfo['STR_GOODCODE'] ?>')">
                                    <svg id="is_like_no_<?= $seenInfo['STR_GOODCODE'] ?>" style="<?= $seenInfo['IS_LIKE'] > 0 ? 'display:none;' : '' ?>" width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.07838 13.6647L7.07788 13.6642C5.01112 11.7493 3.32341 10.1829 2.14831 8.71393C0.977275 7.25002 0.35 5.92416 0.35 4.49591C0.35 2.15659 2.13596 0.35 4.4 0.35C5.68336 0.35 6.92305 0.962301 7.732 1.92538L8 2.24445L8.268 1.92538C9.07695 0.962301 10.3166 0.35 11.6 0.35C13.864 0.35 15.65 2.15659 15.65 4.49591C15.65 5.92416 15.0227 7.25002 13.8517 8.71393C12.6766 10.1829 10.9889 11.7493 8.92212 13.6642L8.92162 13.6647L8 14.522L7.07838 13.6647Z" stroke="#666666" stroke-width="0.7" />
                                    </svg>
                                    <svg id="is_like_yes_<?= $seenInfo['STR_GOODCODE'] ?>" style="<?= $seenInfo['IS_LIKE'] > 0 ? '' : 'display:none;' ?>" width="16" height="15" viewBox="0 0 16 15" fill="#FF1F4B" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.07838 13.6647L7.07788 13.6642C5.01112 11.7493 3.32341 10.1829 2.14831 8.71393C0.977275 7.25002 0.35 5.92416 0.35 4.49591C0.35 2.15659 2.13596 0.35 4.4 0.35C5.68336 0.35 6.92305 0.962301 7.732 1.92538L8 2.24445L8.268 1.92538C9.07695 0.962301 10.3166 0.35 11.6 0.35C13.864 0.35 15.65 2.15659 15.65 4.49591C15.65 5.92416 15.0227 7.25002 13.8517 8.71393C12.6766 10.1829 10.9889 11.7493 8.92212 13.6642L8.92162 13.6647L8 14.522L7.07838 13.6647Z" stroke="#666666" stroke-width="0.7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?
$hide_footer_content = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    function setLike(str_goodcode) {
        $.ajax({
            url: "/m/product/set_like.php",
            data: {
                str_goodcode: str_goodcode
            },
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');
                    return;
                }
                if (result['status'] == 200) {
                    if (result['data'] == true) {
                        $("#is_like_no_" + str_goodcode).hide();
                        $("#is_like_yes_" + str_goodcode).show();
                    }
                    if (result['data'] == false) {
                        $("#is_like_no_" + str_goodcode).show();
                        $("#is_like_yes_" + str_goodcode).hide();
                    }
                }
            }
        });
    }
</script>