<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php

function isMobileDevice()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $mobileKeywords = array('mobile', 'android', 'iphone', 'ipod', 'blackberry', 'windows phone');

    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            return true;
        }
    }

    return false;
}

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
$discount_area = Fnc_Om_Conv_Default($_REQUEST['discount_area'], 0);
$discount_membership = Fnc_Om_Conv_Default($_REQUEST['discount_membership'], 0);
$coupon = Fnc_Om_Conv_Default($_REQUEST['coupon'], 0);
$int_coupon = Fnc_Om_Conv_Default($_REQUEST['int_coupon'], null);
$mileage = Fnc_Om_Conv_Default($_REQUEST['mileage'], 0);

$return_date = Fnc_Om_Conv_Default($_REQUEST['return_date'], '');
$return_product = Fnc_Om_Conv_Default($_REQUEST['return_product'], '');
$start_date = Fnc_Om_Conv_Default($_REQUEST['start_date'], '');
$end_date = Fnc_Om_Conv_Default($_REQUEST['end_date'], '');
$count = Fnc_Om_Conv_Default($_REQUEST['count'], 1);
$card_type = Fnc_Om_Conv_Default($_REQUEST['card_type'], 1);

if ($int_type == 1 || $int_type == 3) {
    // 구독할 상품이 있는지 검색
    $SQL_QUERY =    'SELECT
                        A.STR_SGOODCODE
                    FROM 
                        ' . $Tname . 'comm_goods_master_sub AS A
                    WHERE
                        A.STR_SERVICE = "Y"
                        AND A.STR_GOODCODE = "' . $str_goodcode . '"
                        AND A.STR_SGOODCODE NOT IN (SELECT DISTINCT D.STR_SGOODCODE FROM ablanc_comm_goods_cart D WHERE D.INT_STATE IN (1, 2, 3, 4, 5) AND D.STR_GOODCODE = "' . $str_goodcode . '")
                    LIMIT 1';

    $arr_Rlt_Data = mysql_query($SQL_QUERY);
    $rent_Data = mysql_fetch_assoc($arr_Rlt_Data);

    if (!$rent_Data['STR_SGOODCODE']) {
?>
        <script language="javascript">
            alert("죄송합니다. 해당 가방은 방금 RENTED되었습니다.\n다른 가방을 GET 해주세요!");
            window.location.href = "/m/product/detail.php?str_goodcode=<?= $str_goodcode ?>";
        </script>
    <?
        exit;
    }
} else {
    // 렌트할 상품이 있는지 검색
    $SQL_QUERY =    'SELECT
                        A.STR_SGOODCODE
                    FROM 
                        ' . $Tname . 'comm_goods_master_sub AS A
                    WHERE
                        A.STR_SERVICE = "Y"
                        AND A.STR_GOODCODE = "' . $str_goodcode . '"
                    LIMIT 1';

    $arr_Rlt_Data = mysql_query($SQL_QUERY);
    $rent_Data = mysql_fetch_assoc($arr_Rlt_Data);
    if (!$rent_Data['STR_SGOODCODE']) {
    ?>
        <script language="javascript">
            alert("죄송합니다. 해당 가방은 방금 RENTED되었습니다.\n다른 가방을 GET 해주세요!");
            window.location.href = "/m/product/detail.php?str_goodcode=<?= $str_goodcode ?>";
        </script>
    <?
        exit;
    }
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

//카드정보얻기
$SQL_QUERY =    "SELECT 
                    A.STR_BILLCODE, A.INT_NUMBER
                FROM 
                    `" . $Tname . "comm_member_pay` AS A
                WHERE
                    A.STR_USERID='$arr_Auth[0]'
                    AND A.STR_USING='Y'
                ORDER BY DTM_INDATE DESC
                LIMIT 1 ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$card_Data = mysql_fetch_assoc($arr_Rlt_Data);

// 구독인 경우 이미 이용중인 구독상품 모두 반납
if ($int_type == 1 && $return_date && $return_product) {
    $Sql_Query = "UPDATE `" . $Tname . "comm_goods_cart` SET INT_STATE=5, STR_RDATE='" . $return_date . "' WHERE STR_GOODCODE='" . $return_product . "' AND STR_USERID='" . $arr_Auth[0] . "' AND INT_STATE=4";
    mysql_query($Sql_Query);
}

// 1: 접수, 2: 관리자확인, 3: 발송, 4: 배송완료, 5: 반납접수, 10: 반납완료, 11: 취소
$int_state = 1;

if ($int_type == 1) {
    $start_date = date("Y-m-d");
    $end_date = date("Y-m-d", strtotime("+1 month"));
    $int_state = 1;
} else {
    $int_state = 0;
}

// 주문번호 생성
$today = new DateTime();
$year = $today->format('Y');
$month = $today->format('m');
$date = $today->format('d');
$time = $today->getTimestamp();

if (intval($month) < 10) {
    $month = $month;
}

if (intval($date) < 10) {
    $date = $date;
}

$order_idxx = $year . "" . $month . "" . $date . "" . $time;
$ipgm_date = $year . "" . $month . "" . $date;

$arr_Set_Data = array();
$arr_Column_Name = array();

$arr_Column_Name[0]        = "INT_NUMBER";
$arr_Column_Name[1]        = "STR_USERID";
$arr_Column_Name[2]        = "STR_NAME";
$arr_Column_Name[3]        = "STR_POST";
$arr_Column_Name[4]        = "STR_ADDR1";
$arr_Column_Name[5]        = "STR_ADDR2";
$arr_Column_Name[6]        = "STR_PLACE1";
$arr_Column_Name[7]        = "STR_PLACE2";
$arr_Column_Name[8]        = "STR_MEMO";
$arr_Column_Name[9]        = "STR_GOODCODE";
$arr_Column_Name[10]        = "STR_SGOODCODE";
$arr_Column_Name[11]        = "STR_SDATE";
$arr_Column_Name[12]        = "STR_EDATE";
$arr_Column_Name[13]        = "STR_REDATE";
$arr_Column_Name[14]        = "DTM_INDATE";
$arr_Column_Name[15]        = "INT_STATE";
$arr_Column_Name[16]        = "STR_RPOST";
$arr_Column_Name[17]        = "STR_RADDR1";
$arr_Column_Name[18]        = "STR_RADDR2";
$arr_Column_Name[19]        = "STR_METHOD";
$arr_Column_Name[20]        = "STR_RDATE";
$arr_Column_Name[21]        = "STR_RMEMO";
$arr_Column_Name[22]        = "INT_DELICODE";
$arr_Column_Name[23]        = "STR_DELICODE";
$arr_Column_Name[24]        = "STR_AMEMO";
$arr_Column_Name[25]        = "DTM_EDIT_DATE";
$arr_Column_Name[26]        = "STR_TELEP";
$arr_Column_Name[27]        = "STR_HP";
$arr_Column_Name[28]        = "INT_COUNT";
$arr_Column_Name[29]        = "INT_TPRICE";
$arr_Column_Name[30]        = "INT_PRICE";
$arr_Column_Name[31]        = "INT_PDISCOUNT";
$arr_Column_Name[32]        = "INT_ADISCOUNT";
$arr_Column_Name[33]        = "INT_MDISCOUNT";
$arr_Column_Name[34]        = "INT_COUPON";
$arr_Column_Name[35]        = "INT_CDISCOUNT";
$arr_Column_Name[36]        = "INT_MILEAGE";

$arr_Set_Data[0]        = $order_idxx;
$arr_Set_Data[1]        = $arr_Auth[0];
$arr_Set_Data[2]        = $delivery_name;
$arr_Set_Data[3]        = $delivery_postal;
$arr_Set_Data[4]        = $delivery_address1;
$arr_Set_Data[5]        = $delivery_address2;
$arr_Set_Data[6]        = '';
$arr_Set_Data[7]        = '';
$arr_Set_Data[8]        = $delivery_memo;
$arr_Set_Data[9]        = $str_goodcode;
$arr_Set_Data[10]        = $rent_Data['STR_SGOODCODE'] ?: '';
$arr_Set_Data[11]        = $start_date;
$arr_Set_Data[12]        = $end_date;
$arr_Set_Data[13]        = '';
$arr_Set_Data[14]        = date("Y-m-d H:i:s");
$arr_Set_Data[15]        = $int_state;
$arr_Set_Data[16]        = '';
$arr_Set_Data[17]        = '';
$arr_Set_Data[18]        = '';
$arr_Set_Data[19]        = '';
$arr_Set_Data[20]        = '';
$arr_Set_Data[21]        = '';
$arr_Set_Data[22]        = 0;
$arr_Set_Data[23]        = '';
$arr_Set_Data[24]        = '';
$arr_Set_Data[25]        = date("Y-m-d H:i:s");
$arr_Set_Data[26]        = $delivery_telep;
$arr_Set_Data[27]        = $delivery_hp;
$arr_Set_Data[28]        = $count;
$arr_Set_Data[29]        = $total_price;
$arr_Set_Data[30]        = $price;
$arr_Set_Data[31]        = $discount_product;
$arr_Set_Data[32]        = $discount_area;
$arr_Set_Data[33]        = $discount_membership;
$arr_Set_Data[34]        = $int_coupon;
$arr_Set_Data[35]        = $coupon;
$arr_Set_Data[36]        = $mileage;

$arr_Sub1 = "";
$arr_Sub2 = "";

for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

    if ($int_I != 0) {
        $arr_Sub1 .=  ",";
        $arr_Sub2 .=  ",";
    }
    $arr_Sub1 .=  $arr_Column_Name[$int_I];
    $arr_Sub2 .=  $arr_Set_Data[$int_I] == null ? "NULL" : "'" . $arr_Set_Data[$int_I] . "'";
}

$SQL_QUERY = "INSERT INTO `" . $Tname . "comm_goods_cart` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
mysql_query($SQL_QUERY);

if ($int_type != 1) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body onload="submitPay();">
        <form name="pay_form" action="" method="post">
            <input type="hidden" name="ordr_idxx" value="<?= $order_idxx ?>">
            <input type="hidden" name="ipgm_date" value="<?= $ipgm_date ?>">
            <input type="hidden" name="good_name" value="<?= $product_Data['STR_GOODNAME'] ?>">
            <input type="hidden" name="good_mny" value="<?= $total_price ?>">
            <input type="hidden" name="buyr_name" value="<?= $user_Data['STR_NAME'] ?>">
            <input type="hidden" name="buyr_mail" value="">
            <input type="hidden" name="buyr_tel1" value="<?= $user_Data['STR_TELEP'] ?>">
            <input type="hidden" name="buyr_tel2" value="<?= $user_Data['STR_HP'] ?>">
            <input type="hidden" name="bt_batch_key" value="<?= $card_Data['STR_BILLCODE'] ?>">
            <input type="hidden" name="quotaopt" value="00">
            <input type="hidden" name="card_type" value="<?= $card_type ?>">
            <input type="hidden" name="int_cart" value="<?= $order_idxx ?>">
            <input type="hidden" name="str_goodcode" value="<?= $str_goodcode ?>">
        </form>

        <script language="javascript">
            function submitPay() {
                if (<?= $int_type ?> == 2) {
                    document.forms.pay_form.action = "/payment/linux/auto_pay/mo/payx/order.php";
                } else {
                    if (<?= isMobileDevice() ? 'true' : 'false' ?>) {
                        document.forms.pay_form.action = "/payment/linux/manual_pay/mobile_sample/order_mobile.php";
                    } else {
                        document.forms.pay_form.action = "/payment/linux/manual_pay/sample/order.php";
                    }
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
        document.location.href = "paid.php?int_number=<?= $order_idxx ?>";
    </script>
<?php
}

exit;
?>