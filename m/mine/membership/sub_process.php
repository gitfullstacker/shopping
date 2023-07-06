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

$str_orderidx = Fnc_Om_Conv_Default($_REQUEST['str_orderidx'], '');

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
        <input type="hidden" name="ordr_idxx" value="<?= $str_orderidx ?>">
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