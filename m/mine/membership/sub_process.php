<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], 1);

// 상품정보
$good_name = Fnc_Om_Conv_Default($_REQUEST['good_name'], '');

// 결제금액
$total_price = Fnc_Om_Conv_Default($_REQUEST['total_price'], 0);
$price = Fnc_Om_Conv_Default($_REQUEST['price'], 0);
$coupon = Fnc_Om_Conv_Default($_REQUEST['coupon'], 0);
$int_coupon = Fnc_Om_Conv_Default($_REQUEST['int_coupon'], null);
$mileage = Fnc_Om_Conv_Default($_REQUEST['mileage'], 0);

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
                    A.STR_PASS='0' 
                    AND A.STR_USERID='$arr_Auth[0]'
                ORDER BY DTM_INDATE
                LIMIT 1 ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$card_Data = mysql_fetch_assoc($arr_Rlt_Data);

$order_idxx = $year . "" . $month . "" . $date . "" . $time;
$ipgm_date = $year . "" . $month . "" . $date;

$arr_Set_Data = array();
$arr_Column_Name = array();

$arr_Column_Name[0]        = "INT_NUMBER";
$arr_Column_Name[1]        = "STR_USERID";
$arr_Column_Name[2]        = "DTM_INDATE";
$arr_Column_Name[3]        = "INT_STATE";
$arr_Column_Name[4]        = "DTM_EDIT_DATE";
$arr_Column_Name[5]        = "INT_TPRICE";
$arr_Column_Name[6]        = "INT_PRICE";
$arr_Column_Name[7]        = "INT_COUPON";
$arr_Column_Name[8]        = "INT_CDISCOUNT";
$arr_Column_Name[9]        = "INT_MILEAGE";
$arr_Column_Name[10]        = "INT_TYPE";

$arr_Set_Data[0]        = $order_idxx;
$arr_Set_Data[1]        = $arr_Auth[0];
$arr_Set_Data[2]        = date("Y-m-d H:i:s");
$arr_Set_Data[3]        = '0';
$arr_Set_Data[4]        = date("Y-m-d H:i:s");
$arr_Set_Data[5]        = $total_price;
$arr_Set_Data[6]        = $price;
$arr_Set_Data[7]        = $int_coupon;
$arr_Set_Data[8]        = $coupon;
$arr_Set_Data[9]        = $mileage;
$arr_Set_Data[10]        = $int_type;

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

$SQL_QUERY = "INSERT INTO `" . $Tname . "comm_membership_cart` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
mysql_query($SQL_QUERY);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body onload="submitPay();">
    <form name="pay_form" action="/payment/linux/auto_pay/mo/payx/order.php" method="post">
        <input type="hidden" name="ordr_idxx" value="<?= $order_idxx ?>">
        <input type="hidden" name="good_name" value="<?= $good_name ?>">
        <input type="hidden" name="good_mny" value="<?= $total_price ?>">
        <input type="hidden" name="buyr_name" value="<?= $user_Data['STR_NAME'] ?>">
        <input type="hidden" name="buyr_mail" value="<?= $user_Data['STR_EMAIL'] ?>">
        <input type="hidden" name="buyr_tel1" value="<?= $user_Data['STR_TELEP'] ?>">
        <input type="hidden" name="buyr_tel2" value="<?= $user_Data['STR_HP'] ?>">
        <input type="hidden" name="bt_batch_key" value="<?= $card_Data['STR_BILLCODE'] ?>">
        <input type="hidden" name="quotaopt" value="00">
    </form>

    <script language="javascript">
        function submitPay() {
            document.forms.pay_form.submit();
        }
    </script>
</body>

</html>
<?php
exit;
?>