<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
$SQL_QUERY =    'SELECT
                    A.INT_NUMBER, A.STR_SDATE, A.STR_EDATE, B.*, C.STR_CODE
                FROM 
                    ' . $Tname . 'comm_goods_cart A
                LEFT JOIN
                    ' . $Tname . 'comm_goods_master B
                ON
                    A.STR_GOODCODE=B.STR_GOODCODE
                LEFT JOIN
                    ' . $Tname . 'comm_com_code C
                ON
                    B.INT_BRAND=C.INT_NUMBER
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div class="flex flex-col w-full">
    <!-- 주문/배송현황 -->
    <div class="mt-[30px] flex flex-col gap-[14px] px-[14px]">

        <p class="font-extrabold text-lg leading-5 text-black">주문/배송현황</p>
        <div class="flex flex-row items-center justify-between bg-[#F5F5F5] px-4 py-3">
            <div class="flex flex-col gap-[5px] items-center">
                <?php
                $SQL_QUERY =    'SELECT
                                    COUNT(A.INT_NUMBER) AS NUM
                                FROM 
                                    ' . $Tname . 'comm_goods_cart A
                                WHERE 
                                    A.INT_STATE=1
                                    AND A.STR_USERID="' . $arr_Auth[0] . '"';

                $arr_Rlt_Data = mysql_query($SQL_QUERY);

                if (!$arr_Rlt_Data) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
                ?>
                <p class="font-bold text-[25px] leading-7 text-center text-black"><?= $arr_Data['NUM'] ?></p>
                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">주문접수</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <?php
                $SQL_QUERY =    'SELECT
                                    COUNT(A.INT_NUMBER) AS NUM
                                FROM 
                                    ' . $Tname . 'comm_goods_cart A
                                WHERE 
                                    A.INT_STATE=2
                                    AND A.STR_USERID="' . $arr_Auth[0] . '"';

                $arr_Rlt_Data = mysql_query($SQL_QUERY);

                if (!$arr_Rlt_Data) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
                ?>
                <p class="font-bold text-[25px] leading-7 text-center text-black"><?= $arr_Data['NUM'] ?></p>
                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">상품준비</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <?php
                $SQL_QUERY =    'SELECT
                                    COUNT(A.INT_NUMBER) AS NUM
                                FROM 
                                    ' . $Tname . 'comm_goods_cart A
                                WHERE 
                                    A.INT_STATE=3
                                    AND A.STR_USERID="' . $arr_Auth[0] . '"';

                $arr_Rlt_Data = mysql_query($SQL_QUERY);

                if (!$arr_Rlt_Data) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
                ?>
                <p class="font-bold text-[25px] leading-7 text-center text-black"><?= $arr_Data['NUM'] ?></p>
                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">배송중</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <?php
                $SQL_QUERY =    'SELECT
                                    COUNT(A.INT_NUMBER) AS NUM
                                FROM 
                                    ' . $Tname . 'comm_goods_cart A
                                WHERE 
                                    A.INT_STATE=4
                                    AND A.STR_USERID="' . $arr_Auth[0] . '"';

                $arr_Rlt_Data = mysql_query($SQL_QUERY);

                if (!$arr_Rlt_Data) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
                ?>
                <p class="font-bold text-[25px] leading-7 text-center text-black"><?= $arr_Data['NUM'] ?></p>
                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">배송완료</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <?php
                $SQL_QUERY =    'SELECT
                                    COUNT(A.INT_NUMBER) AS NUM
                                FROM 
                                    ' . $Tname . 'comm_goods_cart A
                                WHERE 
                                    A.INT_STATE=5
                                    AND A.STR_USERID="' . $arr_Auth[0] . '"';

                $arr_Rlt_Data = mysql_query($SQL_QUERY);

                if (!$arr_Rlt_Data) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
                ?>
                <p class="font-bold text-[25px] leading-7 text-center text-black"><?= $arr_Data['NUM'] ?></p>
                <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">반납</p>
            </div>
        </div>
    </div>

    <!-- 배송조회/이용내역 -->
    <div class="mt-[30px] flex flex-col">
        <p class="font-extrabold text-lg leading-5 text-[#333333] px-[14px]">배송조회/이용내역</p>
        <div class="mt-[23px] flex flex-col gap-[30px] w-full" id="order_list">
        </div>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    $(document).ready(function() {
        searchOrder();
    });

    function searchOrder(page = 0) {
        url = "get_order_list.php";
        url += "?page=" + page;

        $.ajax({
            url: url,
            success: function(result) {
                $("#order_list").html(result);
            }
        });
    }
</script>