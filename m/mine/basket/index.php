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

    // 금액정보 얻기
    $SQL_QUERY =    'SELECT
                        A.*
                    FROM 
                        ' . $Tname . 'comm_site_info AS A
                    WHERE
                        A.INT_NUMBER=1';

    $arr_Rlt_Data = mysql_query($SQL_QUERY);
    $site_Data = mysql_fetch_assoc($arr_Rlt_Data);
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
        <div x-data="{ menu: 1 }" class="w-full flex flex-col pb-[30px]">
            <div class="flex flex-col gap-[7px] w-full px-[14px] pt-[30px] pb-2 border-b-[0.5px] border-b-[#E0E0E0] border-solid">
                <p class="font-extrabold text-lg leading-5 text-[#333333]">장바구니</p>
                <div class="flex justify-between items-center">
                    <div class="flex flex-row gap-10 items-center">
                        <div class="flex justify-center items-center p-[3px] border-[#6A696C]" x-bind:class="menu == 1 ? 'border-b' : 'border-none'" x-on:click="menu = 1">
                            <p class="font-bold text-xs leading-[14px]" x-bind:class="menu == 1 ? 'text-[#6A696C]' : 'text-[#999999]'">렌트·구독</p>
                        </div>
                        <div class="flex justify-center items-center p-[3px] border-[#6A696C]" x-bind:class="menu == 2 ? 'border-b' : 'border-none'" x-on:click="menu = 2">
                            <p class="font-bold text-xs leading-[14px]" x-bind:class="menu == 2 ? 'text-[#6A696C]' : 'text-[#999999]'">빈티지</p>
                        </div>
                    </div>
                    <div class="flex flex-row gap-[7px] items-center">
                        <button x-show="menu == 2" type="button" class="flex justify-center items-center w-[86px] h-[29px] border rounded-[12.5px] border-solid border-[#DDDDDD] bg-white" onclick="deleteSelectedProducts()">
                            <span class="font-bold text-xs leading-[14px] flex items-center text-center text-[#666666]">선택상품 삭제</span>
                        </button>
                        <button type="button" class="flex justify-center items-center w-[86px] h-[29px] border rounded-[12.5px] border-solid border-[#DDDDDD] bg-white" onclick="deleteNoProductions()">
                            <span class="font-bold text-xs leading-[14px] flex items-center text-center text-[#666666]">품절상품 삭제</span>
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="menu == 2" class="flex flex-row gap-[5px] items-start px-[14px] py-2 border-b-[0.5px] border-b-[#E0E0E0]">
                <input type="checkbox" class="w-[14px] h-[14px] accent-black" id="select_all" onchange="selectAll()">
                <label for="select_all" class="font-bold text-xs leading-[14px] text-[#666666]">전체선택</label>
            </div>

            <!-- 렌트·구독 -->
            <div x-show="menu == 1" class="flex flex-col gap-7 px-[14px] w-full mt-7">
                <?php
                $temp_int_type = 0;
                while ($row = mysql_fetch_assoc($product_result)) {
                    if ($row['INT_TYPE'] != 3) {
                        // 렌트가능한 상품정보 얻기
                        $rent_number = fnc_cart_info($str_goodcode);
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
                                <div class="w-[120px] h-[120px] flex justify-center items-center rounded p-2 bg-[#F9F9F9] relative">
                                    <img class="w-full" src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
                                    <?php
                                    if ($rent_number == 0 && $row['INT_TYPE'] == 1 && false) {
                                    ?>
                                        <div class="flex justify-center items-center w-full h-full bg-black bg-opacity-60 rounded-md absolute top-0 left-0">
                                            <p class="font-bold text-xs leading-[14px] text-white text-center">RENTED</p>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="flex-1 flex flex-col w-full items-start">
                                    <?php
                                    switch ($row['INT_TYPE']) {
                                        case 1:
                                    ?>
                                            <div class="flex justify-center items-center w-[34px] h-[18px] bg-[#EEAC4C]">
                                                <p class="font-normal text-[10px] leading-[11px] text-center text-white">
                                                    구독
                                                </p>
                                            </div>
                                            <p class="font-bold text-xs leading-[14px] text-[#666666] mt-[15px]"><?= $row['STR_GOODNAME'] ?></p>
                                            <p class="font-bold text-xs leading-[14px] text-[#999999] mt-2.5">월정액 구독 전용</p>
                                            <p class="font-bold text-xs leading-[14px] text-black mt-1.5">
                                                <span class="text-[#EEAC4C]">월</span> <?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원
                                            </p>
                                        <?php
                                            break;
                                        case 2:
                                        ?>
                                            <div class="flex justify-center items-center w-[34px] h-[18px] bg-[#00402F]">
                                                <p class="font-normal text-[10px] leading-[11px] text-center text-white">
                                                    렌트
                                                </p>
                                            </div>
                                            <p class="font-bold text-xs leading-[14px] text-[#666666] mt-[15px]"><?= $row['STR_GOODNAME'] ?></p>
                                            <p class="font-bold text-xs leading-[14px] line-through text-[#999999] mt-2.5 <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>">일 <?= number_format($row['INT_PRICE']) ?>원</p>
                                            <p class="font-bold text-xs leading-[14px] text-black mt-1.5">
                                                <span class="text-[#00402F]"><?= $row['INT_DISCOUNT'] ? $row['INT_DISCOUNT'] . '%' : '' ?></span>
                                                일 <?= number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?>원
                                            </p>
                                    <?php
                                            break;
                                    }
                                    ?>
                                </div>
                            </a>
                            <?php
                            switch ($row['INT_TYPE']) {
                                case 1:
                            ?>
                                    <a href="/m/product/detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="flex justify-center items-center w-full h-[35px] rounded mt-[15px] bg-[#FFF5E5] border-[0.72px] border-solid border-[#DDDDDD]">
                                        <span class="font-bold text-[11px] leading-3 text-center text-black">구독하기</span>
                                    </a>
                                <?php
                                    break;
                                case 2:
                                ?>
                                    <a href="/m/product/detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="flex justify-center items-center w-full h-[35px] rounded mt-[15px] bg-[#E5EAE3] border-[0.72px] border-solid border-[#DDDDDD]">
                                        <span class="font-bold text-[11px] leading-3 text-center text-black">렌트하기</span>
                                    </a>
                            <?php
                                    break;
                            }
                            ?>

                        </div>
                <?php
                        $temp_int_type = $row['INT_TYPE'];
                    }
                }
                ?>
            </div>

            <!-- 빈티지 -->
            <div x-show="menu == 2" class="flex flex-col gap-7 px-[14px] w-full mt-7">
                <?php
                if (mysql_num_rows($product_result) > 0) {
                    mysql_data_seek($product_result, 0);
                }
                while ($row = mysql_fetch_assoc($product_result)) {
                    if ($row['INT_TYPE'] == 3) {
                ?>

                        <div x-data="{
                                showProduct: true,
                                removeBacket(str_goodcode) {
                                    removeProductBasket(str_goodcode);
                                    this.showProduct = false;
                                }
                            }" x-show="showProduct" id="product_item_<?= $row['STR_GOODCODE'] ?>" class="flex flex-col w-full">
                            <div class="flex justify-between items-center w-full">
                                <div class="flex flex-row gap-[5px] items-start">
                                    <input type="checkbox" class="w-[14px] h-[14px] accent-black" name="select_product" id="select_<?= $row['STR_GOODCODE'] ?>" value="<?= $row['STR_GOODCODE'] ?>">
                                    <label for="select_<?= $row['STR_GOODCODE'] ?>" class="font-bold text-[15px] leading-[17px] text-black"><?= $row['STR_CODE'] ?></label>
                                </div>
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" x-on:click="removeBacket('<?= $row['STR_GOODCODE'] ?>')">
                                    <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                                </svg>
                            </div>
                            <a href="/m/product/detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="flex flex-row gap-[11px] mt-3">
                                <div class="w-[120px] h-[120px] flex justify-center items-center rounded p-2 bg-[#F9F9F9]">
                                    <img class="w-full" src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
                                </div>
                                <div class="flex-1 flex flex-col w-full items-start">
                                    <div class="flex justify-center items-center w-[34px] h-[18px] bg-[#7E6B5A]">
                                        <p class="font-normal text-[10px] leading-[11px] text-center text-white">
                                            빈티지
                                        </p>
                                    </div>
                                    <p class="font-bold text-xs leading-[14px] text-[#666666] mt-[15px]"><?= $row['STR_GOODNAME'] ?></p>
                                    <p class="font-bold text-xs leading-[14px] line-through text-[#999999] mt-2.5 <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>">일 <?= number_format($row['INT_PRICE']) ?>원</p>
                                    <p class="font-extrabold text-xs text-[14px] text-[#7E6B5A]">
                                        <?= $row['INT_DISCOUNT'] ? $row['INT_DISCOUNT'] . '%' : '' ?>
                                    </p>
                                    <p class="font-bold text-xs leading-[14px] text-black mt-1.5">
                                        <?= $row ? (number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?: '0') . '원' : '' ?>
                                    </p>
                                </div>
                            </a>
                            <a href="/m/product/detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="flex justify-center items-center w-full h-[35px] rounded mt-[15px] bg-[#FFFFFF] border-[0.72px] border-solid border-[#DDDDDD]">
                                <span class="font-bold text-[11px] leading-3 text-center text-black">구매하기</span>
                            </a>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
        <!-- 신규회원 가입혜택 -->
        <img class="welcome-image min-w-full" src="images/welcome.png" alt="">

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
                            <?php
                            switch ($row['INT_TYPE']) {
                                case 1:
                            ?>
                                    <div class="justify-center items-center w-[25px] h-[25px] bg-[#EEAC4C] absolute top-2 left-2 <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>">
                                        <p class="font-extrabold text-[9px] text-center text-white"><?= $row['INT_DISCOUNT'] ?>%</p>
                                    </div>
                                <?php
                                    break;
                                case 2:
                                ?>
                                    <div class="justify-center items-center w-[25px] h-[25px] bg-[#00402F] absolute top-2 left-2 <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>">
                                        <p class="font-extrabold text-[9px] text-center text-white"><?= $row['INT_DISCOUNT'] ?>%</p>
                                    </div>
                                <?php
                                    break;
                                case 3:
                                ?>
                                    <div class="justify-center items-center w-[25px] h-[25px] bg-[#7E6B5A] absolute top-2 left-2 <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>">
                                        <p class="font-extrabold text-[9px] text-center text-white"><?= $row['INT_DISCOUNT'] ?>%</p>
                                    </div>
                            <?php
                                    break;
                            }
                            ?>


                            <img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
                        </div>
                        <p class="mt-[5.52px] font-extrabold text-[9px] text-[#666666]"><?= $row['STR_CODE'] ?></p>
                        <p class="mt-[3.27px] font-bold text-[9px] text-[#333333]"><?= $row['STR_GOODNAME'] ?></p>
                        <div class="mt-[7.87px] flex gap-[3px] items-center">
                            <?php
                            switch ($row['INT_TYPE']) {
                                case 2:
                            ?>
                                    <p class="font-bold text-xs leading-[14px] text-black">
                                        <?= $row ? '일 ' . (number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?: '0') . '원' : '' ?>
                                    </p>
                                    <p class="font-bold text-[10px] line-through text-[#666666] <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>"><?= number_format($row['INT_PRICE']) ?>원</p>
                                <?php
                                    break;
                                case 1:
                                ?>
                                    <p class="font-bold text-xs leading-[14px] text-black">
                                        <span class="text-[#EEAC4C]">월</span><?= $row ? (number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?: '0') . '원' : '' ?>
                                    </p>
                                    <p class="font-bold text-[10px] line-through text-[#666666] <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>"><?= number_format($row['INT_PRICE']) ?>원</p>
                                <?php
                                    break;
                                case 3:
                                ?>
                                    <p class="font-bold text-xs leading-[14px] text-black">
                                        <?= $row ? (number_format($row['INT_PRICE'] - $row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) ?: '0') . '원' : '' ?>
                                    </p>
                                    <p class="font-bold text-[10px] line-through text-[#666666] <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>"><?= number_format($row['INT_PRICE']) ?>원</p>
                            <?php
                                    break;
                            }
                            ?>
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

<?php
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

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

                    const str_url = encodeURIComponent(window.location.pathname + window.location.search);
                    document.location.href = "/m/memberjoin/login.php?loc=" + str_url;
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

                    const str_url = encodeURIComponent(window.location.pathname + window.location.search);
                    document.location.href = "/m/memberjoin/login.php?loc=" + str_url;
                }
                if (result['status'] == 200) {
                    location.href = "/m/mine/basket/index.php";
                }
            }
        });
    }

    function selectAll() {
        var check_action = false;
        var checkbox = document.getElementById('select_all');
        if (checkbox.checked) {
            check_action = true;
        } else {
            check_action = false;
        }

        var checkboxes = document.querySelectorAll('input[name="select_product"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = check_action;
        }
    }

    function deleteSelectedProducts() {
        var checkboxes = document.querySelectorAll('input[name="select_product"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                str_goodcode = checkboxes[i].value;
                $.ajax({
                    url: "remove_selected_productions.php?str_goodcode=" + str_goodcode,
                    success: function(resultString) {
                        result = JSON.parse(resultString);
                        if (result['status'] == 401) {
                            alert('사용자로그인을 하여야 합니다.');

                            const str_url = encodeURIComponent(window.location.pathname + window.location.search);
                            document.location.href = "/m/memberjoin/login.php?loc=" + str_url;
                        }
                        if (result['status'] == 200) {
                            document.getElementById('product_item_' + str_goodcode).classList.add('hidden');
                        }
                    }
                });
            }
        }
    }
</script>