<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], 1);
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], '');

// 주문정보
$delivery_name = Fnc_Om_Conv_Default($_REQUEST['delivery_name'], '');
$delivery_address1 = Fnc_Om_Conv_Default($_REQUEST['delivery_address1'], '');
$delivery_address2 = Fnc_Om_Conv_Default($_REQUEST['delivery_address2'], '');
$delivery_postal = Fnc_Om_Conv_Default($_REQUEST['delivery_postal'], '');
$delivery_memo_type = Fnc_Om_Conv_Default($_REQUEST['delivery_memo_type'], '');
$delivery_memo = $delivery_memo_type == '0' ? Fnc_Om_Conv_Default($_REQUEST['delivery_memo'], '') : $delivery_memo_type;
$delivery_telep = Fnc_Om_Conv_Default($_REQUEST['delivery_telep'], '');
$delivery_hp = Fnc_Om_Conv_Default($_REQUEST['delivery_hp'], '');

// 결제금액
$total_price = Fnc_Om_Conv_Default($_REQUEST['total_price'], 0);
$price = Fnc_Om_Conv_Default($_REQUEST['price'], 0);
$discount_product = Fnc_Om_Conv_Default($_REQUEST['discount_product'], 0);
$discount_membership = Fnc_Om_Conv_Default($_REQUEST['discount_membership'], 0);
$coupon = Fnc_Om_Conv_Default($_REQUEST['coupon'], 0);
$int_coupon = Fnc_Om_Conv_Default($_REQUEST['int_coupon'], '');
$mileage = Fnc_Om_Conv_Default($_REQUEST['mileage'], 0);

$start_date = Fnc_Om_Conv_Default($_REQUEST['start_date'], '');
$end_date = Fnc_Om_Conv_Default($_REQUEST['end_date'], '');
$count = Fnc_Om_Conv_Default($_REQUEST['count'], 1);
$card_type = Fnc_Om_Conv_Default($_REQUEST['card_type'], 1);

$str_orderidx = Fnc_Om_Conv_Default($_REQUEST['str_orderidx'], '');

// 구독할 상품이 있는지 검색
$SQL_QUERY =    'SELECT
                        A.STR_SGOODCODE
                    FROM 
                        ' . $Tname . 'comm_goods_master_sub AS A
                    WHERE
                        A.STR_SERVICE = "Y"
                        AND A.STR_GOODCODE = "' . $str_goodcode . '"
                        AND A.STR_SGOODCODE NOT IN (SELECT DISTINCT D.STR_SGOODCODE FROM ablanc_comm_goods_cart D WHERE D.INT_STATE NOT IN (0, 10, 11) AND D.STR_GOODCODE = "' . $str_goodcode . '")
                    LIMIT 1';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$rent_Data = mysql_fetch_assoc($arr_Rlt_Data);

if (!$rent_Data['STR_SGOODCODE'] && ($int_type == 1 || $int_type == 3)) {
?>
    <script language="javascript">
        alert("죄송합니다. 해당 가방은 방금 RENTED되었습니다.\n다른 가방을 GET 해주세요!");
        window.location.href = "/m/product/detail?str_goodcode=<?= $str_goodcode ?>";
    </script>
<?
    exit;
}

$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_goods_master AS A
                WHERE
                    A.STR_GOODCODE="' . $str_goodcode . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$product_Data = mysql_fetch_assoc($arr_Rlt_Data);

// 사용자정보 얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_member AS A
                WHERE
                    A.STR_USERID="' . $arr_Auth[0] . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$user_Data = mysql_fetch_assoc($arr_Rlt_Data);

// 1: 접수, 2: 관리자확인, 3: 발송, 4: 배송완료, 5: 반납접수, 10: 반납완료, 11: 취소
$int_state = 1;

if ($int_type == 1) {
    $start_date = date("Y-m-d");
    $end_date = date("Y-m-d", strtotime("+1 month"));
    $str_paid = "Y";
} else {
    $str_paid = "N";
}

$arr_Set_Data = array();
$arr_Column_Name = array();

$arr_Column_Name[0]        = "STR_USERID";
$arr_Column_Name[1]        = "STR_NAME";
$arr_Column_Name[2]        = "STR_POST";
$arr_Column_Name[3]        = "STR_ADDR1";
$arr_Column_Name[4]        = "STR_ADDR2";
$arr_Column_Name[5]        = "STR_PLACE1";
$arr_Column_Name[6]        = "STR_PLACE2";
$arr_Column_Name[7]        = "STR_MEMO";
$arr_Column_Name[8]        = "STR_GOODCODE";
$arr_Column_Name[9]        = "STR_SGOODCODE";
$arr_Column_Name[10]        = "STR_SDATE";
$arr_Column_Name[11]        = "STR_EDATE";
$arr_Column_Name[12]        = "STR_REDATE";
$arr_Column_Name[13]        = "DTM_INDATE";
$arr_Column_Name[14]        = "INT_STATE";
$arr_Column_Name[15]        = "STR_RPOST";
$arr_Column_Name[16]        = "STR_RADDR1";
$arr_Column_Name[17]        = "STR_RADDR2";
$arr_Column_Name[18]        = "STR_METHOD";
$arr_Column_Name[19]        = "STR_RDATE";
$arr_Column_Name[20]        = "STR_RMEMO";
$arr_Column_Name[21]        = "INT_DELICODE";
$arr_Column_Name[22]        = "STR_DELICODE";
$arr_Column_Name[23]        = "STR_AMEMO";
$arr_Column_Name[24]        = "DTM_EDIT_DATE";
$arr_Column_Name[25]        = "STR_TELEP";
$arr_Column_Name[26]        = "STR_HP";
$arr_Column_Name[27]        = "INT_COUNT";
$arr_Column_Name[28]        = "INT_TPRICE";
$arr_Column_Name[29]        = "INT_PRICE";
$arr_Column_Name[30]        = "INT_PDISCOUNT";
$arr_Column_Name[31]        = "INT_MDISCOUNT";
$arr_Column_Name[32]        = "INT_COUPON";
$arr_Column_Name[33]        = "INT_MILEAGE";
$arr_Column_Name[34]        = "STR_PAID";

$arr_Set_Data[0]        = $arr_Auth[0];
$arr_Set_Data[1]        = $delivery_name;
$arr_Set_Data[2]        = $delivery_postal;
$arr_Set_Data[3]        = $delivery_address1;
$arr_Set_Data[4]        = $delivery_address2;
$arr_Set_Data[5]        = '';
$arr_Set_Data[6]        = '';
$arr_Set_Data[7]        = $delivery_memo;
$arr_Set_Data[8]        = $str_goodcode;
$arr_Set_Data[9]        = $rent_Data['STR_SGOODCODE'] ?: '';
$arr_Set_Data[10]        = $start_date;
$arr_Set_Data[11]        = $end_date;
$arr_Set_Data[12]        = '';
$arr_Set_Data[13]        = date("Y-m-d H:i:s");
$arr_Set_Data[14]        = $int_state;
$arr_Set_Data[15]        = '';
$arr_Set_Data[16]        = '';
$arr_Set_Data[17]        = '';
$arr_Set_Data[18]        = '';
$arr_Set_Data[19]        = '';
$arr_Set_Data[20]        = '';
$arr_Set_Data[21]        = 0;
$arr_Set_Data[22]        = '';
$arr_Set_Data[23]        = '';
$arr_Set_Data[24]        = date("Y-m-d H:i:s");
$arr_Set_Data[25]        = $delivery_telep;
$arr_Set_Data[26]        = $delivery_hp;
$arr_Set_Data[27]        = $count;
$arr_Set_Data[28]        = $total_price;
$arr_Set_Data[29]        = $price;
$arr_Set_Data[30]        = $discount_product;
$arr_Set_Data[31]        = $discount_membership;
$arr_Set_Data[32]        = $coupon;
$arr_Set_Data[33]        = $mileage;
$arr_Set_Data[34]        = $str_paid;

$arr_Sub1 = "";
$arr_Sub2 = "";

for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

    if ($int_I != 0) {
        $arr_Sub1 .=  ",";
        $arr_Sub2 .=  ",";
    }
    $arr_Sub1 .=  $arr_Column_Name[$int_I];
    $arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";
}

$SQL_QUERY = "INSERT INTO `" . $Tname . "comm_goods_cart` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
mysql_query($SQL_QUERY);

$SQL_QUERY = "SELECT MAX(INT_NUMBER) AS last_number FROM `" . $Tname . "comm_goods_cart`";
$result = mysql_query($SQL_QUERY);
$last_Data = mysql_fetch_assoc($result);

if ($int_type != 1) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body onload="init_orderid();submitPay();">
        <form name="pay_form" action="/payment/windows/manual_pay/mobile_sample/order_mobile.php" method="post">
            <input type="hidden" name="ordr_idxx" value="">
            <input type="hidden" name="ipgm_date" value="">
            <input type="hidden" name="good_name" value="<?= $product_Data['STR_GOODNAME'] ?>">
            <input type="hidden" name="good_mny" value="<?= $total_price ?>">
            <input type="hidden" name="buyr_name" value="<?= $user_Data['STR_NAME'] ?>">
            <input type="hidden" name="buyr_mail" value="<?= $user_Data['STR_EMAIL'] ?>">
            <input type="hidden" name="buyr_tel1" value="<?= $user_Data['STR_TELEP'] ?>">
            <input type="hidden" name="buyr_tel2" value="<?= $user_Data['STR_HP'] ?>">
            <input type="hidden" name="bt_batch_key" value="<?= $card_Data['STR_BILLCODE'] ?>">
            <input type="hidden" name="quotaopt" value="00">
            <input type="hidden" name="card_type" value="<?= $card_type ?>">
            <input type="hidden" name="int_cart" value="<?= $last_Data['last_number'] ?>">
            <input type="hidden" name="int_coupon" value="<?= $int_coupon ?>">
        </form>

        <script language="javascript">
            function init_orderid() {
                var today = new Date();
                var year = today.getFullYear();
                var month = today.getMonth() + 1;
                var date = today.getDate();
                var time = today.getTime();

                if (parseInt(month) < 10)
                    month = "0" + month;

                if (parseInt(date) < 10)
                    date = "0" + date;

                var order_idxx = "TEST" + year + "" + month + "" + date + "" + time;
                var ipgm_date = year + "" + month + "" + date;

                document.forms.pay_form.ordr_idxx.value = order_idxx;
                document.forms.pay_form.ipgm_date.value = ipgm_date;
            }

            function submitPay() {
                if (<?= $int_type ?> == 2) {
                    document.forms.pay_form.action = "/payment/linux/auto_pay/mobile_auth/order_mobile.php";
                } else {
                    document.forms.pay_form.action = "/payment/linux/manual_pay/mobile_sample/order_mobile.php";
                }

                document.forms.pay_form.submit();
            }
        </script>
    </body>

    </html>
<?php
} else {
    ?>
    <script>
        document.location.href = "paid.php?int_number=<?= $last_Data['last_number'] ?>";
    </script>
    <?php
}

exit;
?>