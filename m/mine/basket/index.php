<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />

<div class="w-full flex flex-col">
    <?php
    $SQL_QUERY =    'SELECT 
                        B.*, C.STR_CODE
                    FROM 
                        ' . $Tname . 'comm_member_basket A
                    LEFT JOIN
                        ' . $Tname . 'comm_goods_master B
                    ON
                        A.STR_GOODCODE=B.STR_GOODCODE
                    LEFT JOIN
                        ' . $Tname . 'comm_com_code C
                    ON
                        B.INT_BRAND=C.INT_NUMBER
                    WHERE 
                        (B.STR_SERVICE="Y" OR B.STR_SERVICE="R") 
                        AND A.STR_USERID="' . $arr_Auth[0] . '"
                    ORDER BY B.INT_TYPE ASC, A.DTM_INDATE DESC';

    $product_result = mysql_query($SQL_QUERY);
    ?>

    <?php
    if (mysql_num_rows($product_result) == 0) {
    ?>
        <!-- 장바구니가 비였을때 -->
        <div class="w-full flex flex-col items-center pt-[83px] pb-[181px]">
            <img class="w-auto h-auto" src="images/empty-icon.png" alt="empty">
            <p class="font-bold text-[15px] leading-[17px] text-center text-[#666666] mt-[18px]">장바구니가 비어있어요!</p>
            <a href="/m/product/index.php" class="w-[200px] h-[45px] flex justify-center items-center mt-[22px] border-[0.72px] border-solid border-[#DDDDDD]">
                <span class="font-bold text-xs leading-[14px] text-center text-[#666666]">쇼핑하러 가기</span>
            </a>
        </div>

    <?php
    } else {
    ?>
        <div class="w-full flex flex-col px-3.5 pb-[30px]">
            <div class="flex flex-col gap-[7px] w-full pt-[30px] pb-2 border-b-[0.5px] border-b-[#E0E0E0] border-solid">
                <p class="font-extrabold text-lg leading-5 text-[#333333]">장바구니</p>
                <div class="flex justify-end">
                    <button type="button" class="flex justify-center items-center w-[86px] h-[29px] border rounded-[12.5px] border-solid border-[#DDDDDD] bg-white" onclick="deleteNoProductions()">
                        <span class="font-bold text-xs leading-[14px] flex items-center text-center text-[#666666]">품절상품 삭제</span>
                    </button>
                </div>
            </div>

            <div class="flex flex-col gap-7 w-full mt-7">
                <?php
                $temp_int_type = 0;
                while ($row = mysql_fetch_assoc($product_result)) {
                ?>
                    <?php
                    if ($temp_int_type != 0 && $temp_int_type != $row['INT_TYPE']) {
                    ?>
                        <!-- 구분 -->
                        <hr class="w-screen -ml-3.5 border-t-[0.5px] border-solid border-[#E0E0E0]" />
                    <?php
                    }
                    ?>

                    <div x-data="{
                        showProduct: true,
                        removeBacket(str_goodcode) {
                            removeProductBasket(str_goodcode);
                            this.showProduct = false;
                        }
                    }" x-show="showProduct" class="flex flex-col w-full">
                        <div class="flex justify-between items-center w-full">
                            <p class="font-bold text-[15px] leading-[17px] text-black"><?= $row['STR_CODE'] ?></p>
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" x-on:click="removeBacket('<?= $row['STR_GOODCODE'] ?>')">
                                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                            </svg>
                        </div>
                        <a href="/m/product/detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="flex flex-row gap-[11px] mt-3">
                            <div class="w-[120px] h-[120px] flex justify-center items-center rounded p-2 bg-[#F9F9F9]">
                                <img class="w-full" src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
                            </div>
                            <div class="flex-1 flex flex-col w-full items-start">
                                <div class="flex justify-center items-center w-[34px] h-[18px] bg-[<?= ($row['INT_TYPE'] == 1 ? '#EEAC4C' : ($row['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                                    <p class="font-normal text-[10px] leading-[11px] text-center text-white">
                                        <?= ($row['INT_TYPE'] == 1 ? '구독' : ($row['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?>
                                    </p>
                                </div>
                                <p class="font-bold text-xs leading-[14px] text-[#666666] mt-[15px]"><?= $row['STR_GOODNAME'] ?></p>
                                <p class="font-bold text-xs leading-[14px] line-through text-[#999999] mt-2.5 <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>">일 <?= number_format($row['INT_PRICE']) ?>원</p>
                                <p class="font-bold text-xs leading-[14px] text-black mt-1.5"><span class="text-[#00402F]"><?= $row['INT_DISCOUNT'] ? $row['INT_DISCOUNT'] . '%' : '' ?></span> 일 <?= $row['INT_DISCOUNT'] ? number_format($row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) : number_format($row['INT_PRICE']) ?>원</p>
                            </div>
                        </a>
                        <?php
                        switch ($row['INT_TYPE']) {
                            case 1:
                        ?>
                                <button class="flex justify-center items-center w-full h-[35px] rounded mt-[15px] bg-[#E5EAE3]">
                                    <span class="font-bold text-[11px] leading-3 text-center text-black">렌트하기</span>
                                </button>
                            <?php
                                break;
                            case 2:
                            ?>
                                <button class="flex justify-center items-center w-full h-[35px] rounded mt-[15px] bg-[#FFF5E5]">
                                    <span class="font-bold text-[11px] leading-3 text-center text-black">구독하기</span>
                                </button>
                            <?php
                                break;
                            case 3:
                            ?>
                                <button class="flex justify-center items-center w-full h-[35px] rounded mt-[15px] bg-[#FFFFFF]">
                                    <span class="font-bold text-[11px] leading-3 text-center text-black">구매하기</span>
                                </button>
                        <?php
                                break;
                        }
                        ?>

                    </div>
                <?php
                    $temp_int_type = $row['INT_TYPE'];
                }
                ?>
            </div>
        </div>
        <!-- 신규회원 가입혜택 -->
        <img class="welcome-image" src="images/welcome.png" alt="">

        <!-- Buy it with -->
        <div class="mt-5 flex flex-col gap-5 px-[14px]">
            <p class="font-extrabold text-lg leading-5 text-[#333333]">Buy it with</p>
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
                            WHERE 
                                (A.STR_SERVICE="Y" OR A.STR_SERVICE="R")
                            ORDER BY A.INT_VIEW DESC
                            LIMIT 4';

                $product_result = mysql_query($SQL_QUERY);

                while ($row = mysql_fetch_assoc($product_result)) {
                ?>
                    <a href="detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="flex flex-col w-full">
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
                            <p class="font-bold text-xs text-black">일 <?= $row['INT_DISCOUNT'] ? number_format($row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) : number_format($row['INT_PRICE']) ?>원</p>
                            <p class="font-bold text-[10px] line-through text-[#666666] <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>"><?= number_format($row['INT_PRICE']) ?>원</p>
                        </div>
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php"; ?>

<script>
    function removeProductBasket(str_goodcode) {
        $.ajax({
            url: "/m/product/set_basket.php",
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
                    if (result['data'] == false) {}
                }
            }
        });
    }

    function deleteNoProductions() {
        $.ajax({
            url: "remove_no_productions.php",
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');
                    return;
                }
                if (result['status'] == 200) {
                    location.href="/m/mine/basket/index.php";
                }
            }
        });
    }
</script>