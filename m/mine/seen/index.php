<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
$header_title = '최근 본 상품';
$hide_header = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>

<?php
$SQL_QUERY =    'SELECT
                    A.DTM_INDATE AS SEEN_DATE, B.*, C.STR_CODE, (SELECT COUNT(D.STR_GOODCODE) FROM ' . $Tname . 'comm_member_like AS D WHERE B.STR_GOODCODE=D.STR_GOODCODE AND D.STR_USERID="' . ($arr_Auth[0] ?: 'NULL') . '") AS IS_LIKE
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
    $date = date('Y-m-d', strtotime($row['SEEN_DATE']));

    // Check if the date already exists in the productSeenByDate array
    if (array_key_exists($date, $productSeenByDate)) {
        // Add the current record to the existing date key
        $productSeenByDate[$date][] = $row;
    } else {
        // Create a new key with the current date and add the record
        $productSeenByDate[$date] = array($row);
    }
}

// 금액정보얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_site_info AS A
                WHERE
                    A.INT_NUMBER=1';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div x-data="{ noData: <?= mysql_num_rows($seen_list_result) > 0 ? 'false' : 'true' ?> }" class="mt-[6px] flex flex-col w-full">
    <div class="flex justify-end px-[14px]">
        <button type="button" onclick="deleteAll()">
            <p class="font-bold text-xs leading-[14px] underline text-[#666666]">전체삭제</p>
        </button>
    </div>

    <div x-show="noData" id="no_list" class="flex flex-col gap-5 items-center mt-[77px]">
        <svg width="60" height="70" viewBox="0 0 60 70" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M52.93 20L40 7.07V20H52.93ZM55 25H35V5H5V65H55V25ZM2.5 0H40L60 20V67.5C60 68.163 59.7366 68.7989 59.2678 69.2678C58.7989 69.7366 58.163 70 57.5 70H2.5C1.83696 70 1.20107 69.7366 0.732234 69.2678C0.263393 68.7989 0 68.163 0 67.5V2.5C0 1.83696 0.263393 1.20107 0.732234 0.732233C1.20107 0.263392 1.83696 0 2.5 0ZM26.64 42.68L19.57 35.6L23.105 32.065L30.18 39.135L37.25 32.07L40.785 35.605L33.715 42.68L40.785 49.75L37.25 53.285L30.18 46.215L23.105 53.285L19.57 49.75L26.64 42.68Z" fill="#D9D9D9" />
        </svg>
        <p class="font-bold text-[15px] leading-[17px] text-[#666666]">최근 본 상품이 없습니다.</p>
    </div>

    <div x-show="!noData" id="seen_list" class="mt-6 flex flex-col gap-6 w-full">
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
                                    <div class="flex justify-center items-center w-[30px] h-4 bg-[<?= ($seenInfo['INT_TYPE'] == 1 ? '#EEAC4C' : ($seenInfo['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                                        <p class="font-normal text-[9px] leading-[9px] text-center text-white">
                                            <?= ($seenInfo['INT_TYPE'] == 1 ? '구독' : ($seenInfo['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?>
                                        </p>
                                    </div>
                                    <p class="mt-1.5 font-extrabold text-xs leading-[14px] text-black"><?= $seenInfo['STR_CODE'] ?></p>
                                    <p class="mt-1 font-medium text-xs leading-[14px] text-[#666666]"><?= $seenInfo['STR_GOODNAME'] ?></p>
                                    <?php
                                    switch ($seenInfo['INT_TYPE']) {
                                        case 1:
                                    ?>
                                            <div class="mt-2.5 flex flex-col gap-[3.4px]">
                                                <p class="font-medium text-xs leading-[14px] text-[#999999]">월정액 구독 전용</p>
                                                <p class="font-bold text-[13px] leading-[15px] text-black"><span class="font-medium text-[#EEAC4C]">월</span> <?= number_format($site_Data['INT_OPRICE1']) ?>원</p>
                                            </div>
                                        <?php
                                            break;

                                        case 2:
                                        ?>
                                            <div class="mt-2.5 flex flex-col gap-[3.4px]">
                                                <p class="font-bold text-xs leading-[14px] text-[#999999] line-through <?= $seenInfo['INT_DISCOUNT'] ? '' : 'hidden' ?>">일 <?= number_format($seenInfo['INT_PRICE']) ?>원</p>
                                                <div class="flex gap-1 items-center">
                                                    <p class="font-extrabold text-[13px] leading-[15px] text-[#00402F]"><?= $seenInfo['INT_DISCOUNT'] ? $seenInfo['INT_DISCOUNT'] . '%' : '' ?></p>
                                                    <p class="font-bold text-[13px] leading-[15px] text-black"><span class="font-medium">일</span> <?= number_format($seenInfo['INT_PRICE'] - $seenInfo['INT_PRICE'] * $seenInfo['INT_DISCOUNT'] / 100) ?>원</p>
                                                </div>
                                            </div>
                                        <?php
                                            break;
                                        case 3:
                                        ?>
                                            <div class="mt-2.5 flex flex-col gap-[3.4px]">
                                                <p class="font-bold text-xs leading-[14px] text-[#999999] line-through <?= $seenInfo['INT_DISCOUNT'] ? '' : 'hidden' ?>"><?= number_format($seenInfo['INT_PRICE']) ?>원</p>
                                                <div class="flex gap-1 items-center">
                                                    <p class="font-extrabold text-[13px] leading-[15px] text-[#7E6B5A]"><?= $seenInfo['INT_DISCOUNT'] ? $seenInfo['INT_DISCOUNT'] . '%' : '' ?></p>
                                                    <p class="font-bold text-[13px] leading-[15px] text-black"><span class="font-medium"></span> <?= number_format($seenInfo['INT_PRICE'] - $seenInfo['INT_PRICE'] * $seenInfo['INT_DISCOUNT'] / 100) ?>원</p>
                                                </div>
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
                    
                    const str_url = encodeURIComponent(window.location.pathname + window.location.search);
                    document.location.href = "/m/memberjoin/login.php?loc=" + str_url;
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

    function deleteAll() {
        $.ajax({
            url: "delete_all.php",
            success: function(resultString) {
                $("#seen_list").hide();
                $("#no_list").show();
            }
        });
    }
</script>