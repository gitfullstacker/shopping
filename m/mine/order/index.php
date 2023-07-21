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

// 반납불가일 얻기
$SQL_QUERY =    'SELECT A.STR_DAY FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=1 AND A.INT_DTYPE=2';
$end_days_result = mysql_query($SQL_QUERY);
$end_days_array = array();
while ($row = mysql_fetch_assoc($end_days_result)) {
    $end_days_array[] = $row['STR_DAY'];
}

$SQL_QUERY =    'SELECT A.STR_DATE FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=2 AND A.INT_DTYPE=2';
$end_dates_result = mysql_query($SQL_QUERY);
$end_dates_array = array();
while ($row = mysql_fetch_assoc($end_dates_result)) {
    $end_dates_array[] = $row['STR_DATE'];
}

$SQL_QUERY =    'SELECT A.STR_WEEK FROM  ' . $Tname . 'comm_cal A WHERE A.STR_SERVICE="Y" AND A.INT_TYPE=3 AND A.INT_DTYPE=2';
$end_weeks_result = mysql_query($SQL_QUERY);
$end_weeks_array = array();
while ($row = mysql_fetch_assoc($end_weeks_result)) {
    $end_weeks_array[] = $row['STR_WEEK'];
}
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
                <p class="font-semibold text-xs leading-[14px] text-center text-[#666666]">주문접수</p>
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
                <p class="font-semibold text-xs leading-[14px] text-center text-[#666666]">상품준비</p>
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
                <p class="font-semibold text-xs leading-[14px] text-center text-[#666666]">배송중</p>
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
                <p class="font-semibold text-xs leading-[14px] text-center text-[#666666]">배송완료</p>
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
                <p class="font-semibold text-xs leading-[14px] text-center text-[#666666]">반납</p>
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

<div id="cancel_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden" style="height: calc(100vh - 66px);">
    <div class="mt-[60%] flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
        <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('cancel_dialog').classList.add('hidden');">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <p class="font-bold text-[15px] leading-[17px] text-black">취소 신청이 완료되었습니다.</p>
        <a href="/m/product/index.php" id="cancel_dialog_btn" class="flex flex-row gap-[12.3px] items-center justify-center px-5 py-2.5 bg-white border-[0.84px] border-solid border-[#D9D9D9]">
            <p class="font-bold text-[10px] leading-[11px] text-[#666666]">다른 가방 렌트하기</p>
            <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.52603 9.0481L5.45631 4.95636C5.50296 4.90765 5.53592 4.85488 5.55521 4.79805C5.5748 4.74122 5.58459 4.68033 5.58459 4.61538C5.58459 4.55044 5.5748 4.48955 5.55521 4.43272C5.53592 4.37589 5.50296 4.32312 5.45631 4.27441L1.52603 0.170489C1.41718 0.0568296 1.28112 0 1.11785 0C0.95457 0 0.814619 0.060889 0.697994 0.182667C0.581368 0.304445 0.523056 0.446519 0.523056 0.60889C0.523056 0.77126 0.581368 0.913335 0.697994 1.03511L4.12678 4.61538L0.697994 8.19566C0.589143 8.30932 0.534719 8.44928 0.534719 8.61555C0.534719 8.78214 0.593031 8.92632 0.709656 9.0481C0.826282 9.16988 0.962345 9.23077 1.11785 9.23077C1.27335 9.23077 1.40941 9.16988 1.52603 9.0481Z" fill="#666666" />
            </svg>
        </a>
    </div>
</div>

<div id="return_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden" style="height: calc(100vh - 66px);">
    <div class="mt-[60%] flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
        <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('return_dialog').classList.add('hidden');">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <p class="font-bold text-[15px] leading-[17px] text-black">반납 날짜를 선택해주세요.</p>
        <div x-data="{
                selectedValue: '',
                showSelectPanel: false,
                selectItem(value) {
                    this.selectedValue = value;
                    this.showSelectPanel = false;
                    doReturnOrder(value);
                }
            }" class="w-[144px] h-[30px] flex justify-center items-center bg-white border-[0.72px] border-solid border-[#DDDDDD] relative">
            <div class="flex gap-[18px] items-center cursor-pointer" x-on:click="showSelectPanel = true" x-on:click.outside="showSelectPanel = false">
                <p value="font-bold text-[10px] leading-3 text-[#666666]" x-text="selectedValue == '' ? '반납 날짜' : selectedValue">반납 날짜</p>
                <svg class="absolute top-3 right-[25px]" width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7228 1.67005L5.87374 5.86313C5.81602 5.9129 5.75348 5.94807 5.68613 5.96865C5.61878 5.98955 5.54662 6 5.46965 6C5.39268 6 5.32053 5.98955 5.25318 5.96865C5.18583 5.94807 5.12329 5.9129 5.06556 5.86313L0.202045 1.67005C0.0673482 1.55392 -2.23606e-07 1.40876 -2.3209e-07 1.23456C-2.40574e-07 1.06037 0.0721588 0.91106 0.216477 0.786636C0.360795 0.662212 0.529166 0.6 0.72159 0.6C0.914014 0.6 1.08239 0.662212 1.2267 0.786636L5.46965 4.4447L9.71261 0.786635C9.8473 0.670507 10.0132 0.612442 10.2102 0.612442C10.4076 0.612442 10.5785 0.674654 10.7228 0.799078C10.8672 0.923502 10.9393 1.06866 10.9393 1.23456C10.9393 1.40046 10.8672 1.54562 10.7228 1.67005Z" fill="#333333" />
                </svg>
            </div>
            <div id="return_dates" x-show="showSelectPanel" class="absolute top-[30px] left-0 flex flex-col w-full bg-white border-[0.72px] border-solid border-[#DDDDDD]">
            </div>
        </div>
    </div>
</div>

<div id="return_result_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden" style="height: calc(100vh - 66px);">
    <div class="mt-[60%] flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
        <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('return_result_dialog').classList.add('hidden');document.location.href = 'index.php';">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <p class="font-bold text-[15px] leading-[17px] text-black">반납 신청이 완료되었습니다.</p>
        <a href="index.php" class="flex flex-row gap-[12.3px] items-center justify-center px-5 py-2.5 bg-white border-[0.84px] border-solid border-[#D9D9D9]">
            <p class="font-bold text-[10px] leading-[11px] text-[#666666]">확인</p>
        </a>
    </div>
</div>

<div id="show_delivery_dialog" class="w-full h-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden">
    <div class="mt-[30%] flex flex-col gap-[11px] items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
        <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('show_delivery_dialog').classList.add('hidden');">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <iframe id="delivery_frame" src="" frameborder="0"></iframe>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    current_page = 0;
    return_int_number = 0;

    $(document).ready(function() {
        searchOrder();
    });

    function searchOrder(page = 0) {
        current_page = page;
        url = "get_order_list.php";
        url += "?page=" + page;

        $.ajax({
            url: url,
            success: function(result) {
                $("#order_list").html(result);
            }
        });
    }

    function cancelOrder(int_cart, int_type) {
        url = "order_proc.php";
        url += "?RetrieveFlag=CANCELORDER";
        url += "&int_cart=" + int_cart;

        $.ajax({
            url: url,
            success: function(result) {
                document.getElementById('cancel_dialog').classList.remove('hidden');
                searchOrder(current_page);

                switch (int_type) {
                    case 1:
                        $('#cancel_dialog_btn').attr('href', '/m/product/index.php?product_type=1');
                        $('#cancel_dialog_btn p').html('다른 가방 구독하기');
                        break;
                    case 2:
                        $('#cancel_dialog_btn').attr('href', '/m/product/index.php?product_type=2');
                        $('#cancel_dialog_btn p').html('다른 가방 렌트하기');
                        break;
                    case 3:
                        $('#cancel_dialog_btn').attr('href', '/m/product/index.php?product_type=3');
                        $('#cancel_dialog_btn p').html('다른 가방 구매하기');
                        break;
                }
            }
        });
    }

    function returnOrder(int_number) {
        return_int_number = int_number;
        document.getElementById('return_dialog').classList.remove('hidden');

        var selectElement = document.getElementById("return_dates");

        var temp_date = new Date();
        var start_date = null;
        var end_date = null;

        if (new Date().getHours() < 17) {
            temp_date.setDate(temp_date.getDate() + 1);
        } else {
            temp_date.setDate(temp_date.getDate() + 2);
        }

        // 불가일 검사
        const endDDays = <?= str_replace('"', '\'', json_encode($end_days_array)) ?>;
        const endDWeeks = <?= str_replace('"', '\'', json_encode($end_weeks_array)) ?>;
        const endDDates = <?= str_replace('"', '\'', json_encode($end_dates_array)) ?>;

        do {
            var setted = true;
            const dateString = temp_date.getFullYear().toString() + '-' + (temp_date.getMonth() + 1).toString().padStart(2, '0') + '-' + temp_date.getDate().toString().padStart(2, '0');

            if (endDDays.includes(temp_date.getDate().toString())) {
                setted = false;
            } else if (endDWeeks.includes(temp_date.getDay().toString())) {
                setted = false;
            } else if (endDDates.includes(dateString)) {
                setted = false;
            }

            if (setted) {
                if (start_date == null) {
                    start_date = new Date(temp_date);
                    // 구독상품인 경우 당일에 기사님이 가므로 1일 연장
                    start_date.setDate(start_date.getDate() + 1);
                } else {
                    end_date = new Date(temp_date);
                    // 구독상품인 경우 당일에 기사님이 가므로 1일 연장
                    end_date.setDate(end_date.getDate() + 1);
                }
            }

            temp_date.setDate(temp_date.getDate() + 1);
        } while (start_date == null || end_date == null);

        while (selectElement.firstChild) {
            selectElement.removeChild(selectElement.firstChild);
        }

        var dateRange = getDateRange(start_date, end_date);

        for (var i = 0; i < dateRange.length; i++) {
            var button = document.createElement("button");
            button.className = "py-[17px] flex justify-center items-center hover:bg-gray-100";
            button.setAttribute("x-on:click", "selectItem('" + dateRange[i] + "')");

            var p = document.createElement("p");
            p.className = "font-bold text-[10px] leading-3 text-[#666666]";
            p.textContent = dateRange[i];

            button.appendChild(p);
            selectElement.appendChild(button);
        }
    }

    function doReturnOrder(d_date) {
        url = "order_proc.php";
        url += "?RetrieveFlag=RETURNORDER";
        url += "&int_cart=" + return_int_number;
        url += "&d_date=" + d_date;

        $.ajax({
            url: url,
            success: function(result) {
                document.getElementById('return_dialog').classList.add('hidden');
                document.getElementById('return_result_dialog').classList.remove('hidden');
            }
        });
    }

    function receivedOrder(int_cart) {
        url = "order_proc.php";
        url += "?RetrieveFlag=RECEIVEDORDER";
        url += "&int_cart=" + int_cart;

        $.ajax({
            url: url,
            success: function(result) {
                searchOrder(current_page);
            }
        });
    }

    function getDateRange(startDate, endDate) {
        var dateArray = [];
        var currentDate = startDate;

        while (currentDate <= endDate) {
            dateArray.push(currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1).toString().padStart(2, '0') + '-' + currentDate.getDate().toString().padStart(2, '0'));
            currentDate.setDate(currentDate.getDate() + 1);
        }

        return dateArray;
    }

    function openDeliveryDialog(delivery_id) {
        // Create the iframe element
        var iframe = document.getElementById('delivery_frame');

        // Set the iframe properties
        iframe.src = 'https://m.epost.go.kr/postal/mobile/mobile.trace.RetrieveDomRigiTraceList.comm?sid1=' + delivery_id; // Replace with your desired URL
        iframe.style.width = '300px'; // Set the width of the iframe
        iframe.style.height = '500px'; // Set the height of the iframe
        iframe.style.border = 'none'; // Remove iframe border

        document.getElementById('show_delivery_dialog').classList.remove('hidden');
    }
</script>