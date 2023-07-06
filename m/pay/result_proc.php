<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$res_cd = Fnc_Om_Conv_Default($_REQUEST['res_cd'], "");
$res_msg = Fnc_Om_Conv_Default($_REQUEST['res_msg'], "");
$ordr_idxx = Fnc_Om_Conv_Default($_REQUEST['ordr_idxx'], "");
$amount = Fnc_Om_Conv_Default($_REQUEST['amount'], "0");
$card_cd = Fnc_Om_Conv_Default($_REQUEST['card_cd'], "");
$card_name = Fnc_Om_Conv_Default($_REQUEST['card_name'], "");

$SQL_QUERY =    'SELECT
                    A.*, B.INT_TYPE
                FROM 
                    ' . $Tname . 'comm_goods_cart AS A
                LEFT JOIN
                    ' . $Tname . 'comm_goods_master AS B
                ON
                    A.STR_GOODCODE = B.STR_GOODCODE
                WHERE
                    A.INT_NUMBER="' . $ordr_idxx . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}

$cart_Data = mysql_fetch_assoc($arr_Rlt_Data);

if ($res_cd == "0000") {
    // 사용자정보 얻기
    $SQL_QUERY =    'SELECT
                        A.*
                    FROM 
                        ' . $Tname . 'comm_member AS A
                    WHERE
                        A.STR_USERID="' . $cart_Data['STR_USERID'] . '"';

    $arr_Rlt_Data = mysql_query($SQL_QUERY);
    $user_Data = mysql_fetch_assoc($arr_Rlt_Data);

    $arr_Set_Data = array();
    $arr_Column_Name = array();

    $arr_Column_Name[0]        = "STR_USERID";
    $arr_Column_Name[1]        = "STR_GOODCODE";
    $arr_Column_Name[2]        = "INT_PRICE";
    $arr_Column_Name[3]        = "STR_RESCD";
    $arr_Column_Name[4]        = "STR_RESMEG";
    $arr_Column_Name[5]        = "STR_ORDERIDX";
    $arr_Column_Name[6]        = "STR_CARDCODE";
    $arr_Column_Name[7]        = "STR_CARDNAME";
    $arr_Column_Name[8]        = "DTM_INDATE";
    $arr_Column_Name[9]        = "INT_CART";

    $arr_Set_Data[0]        = $cart_Data['STR_USERID'];
    $arr_Set_Data[1]        = $cart_Data['STR_GOODCODE'];
    $arr_Set_Data[2]        = $amount;
    $arr_Set_Data[3]        = $res_cd;
    $arr_Set_Data[4]        = $res_msg;
    $arr_Set_Data[5]        = $ordr_idxx;
    $arr_Set_Data[6]        = $card_cd;
    $arr_Set_Data[7]        = $card_name;
    $arr_Set_Data[8]        = date("Y-m-d H:i:s");
    $arr_Set_Data[9]        = $ordr_idxx;

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

    $Sql_Query = "INSERT INTO `" . $Tname . "comm_good_pay` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
    mysql_query($Sql_Query);

    // 마일리지 사용한 경우
    if ($cart_Data['INT_MILEAGE']) {
        // 마일리지 제거
        $Sql_Query = "UPDATE `" . $Tname . "comm_member` SET INT_MILEAGE=(INT_MILEAGE - " . $cart_Data['INT_MILEAGE'] . ") WHERE STR_USERID='" . $cart_Data['STR_USERID'] . "'";
        mysql_query($Sql_Query);

        // 마일리지 제거 등록
        $arr_Set_Data = array();
        $arr_Column_Name = array();

        $arr_Column_Name[0]        = "STR_USERID";
        $arr_Column_Name[1]        = "STR_INCOME";
        $arr_Column_Name[2]        = "DTM_INDATE";
        $arr_Column_Name[3]        = "STR_ORDERIDX";
        $arr_Column_Name[4]        = "INT_VALUE";
        $arr_Column_Name[5]        = "INT_CART";

        $arr_Set_Data[0]        = $cart_Data['STR_USERID'];
        $arr_Set_Data[1]        = "N";
        $arr_Set_Data[2]        = date("Y-m-d H:i:s");
        $arr_Set_Data[3]        = $str_orderidx;
        $arr_Set_Data[4]        = $cart_Data['INT_MILEAGE'];
        $arr_Set_Data[5]        = $cart_Data['INT_NUMBER'];

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

        $SQL_QUERY = "INSERT INTO `" . $Tname . "comm_mileage_history` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
        mysql_query($SQL_QUERY);
    }

    // 쿠폰 사용한 경우
    if ($cart_Data['INT_COUPON']) {
        $Sql_Query = "UPDATE `" . $Tname . "comm_member_coupon` SET STR_USED='Y' WHERE INT_NUMBER=" . $cart_Data['INT_COUPON'];
        mysql_query($Sql_Query);
    }

    // 결제상태 반영
    $Sql_Query = "UPDATE `" . $Tname . "comm_goods_cart` SET INT_STATE=1 WHERE INT_NUMBER='" . $cart_Data['INT_NUMBER'] . "'";
    mysql_query($Sql_Query);

    // 사용한 금액체크
    if ($user_Data['STR_GRADE'] != 'B') {
        $total_spent_money = getSpentMoney($cart_Data['STR_USERID']);

        if ($total_spent_money >= 2000000) {
            addBlackCoupons($cart_Data['STR_USERID']);
        }
    }
?>
    <script language="javascript">
        alert('결제가 성공하였습니다.');
        window.location.href = "paid.php?int_number=<?= $cart_Data['INT_NUMBER'] ?>";
    </script>
<?php
    exit;
} else {
    $Sql_Query = "DELETE FROM `" . $Tname . "comm_goods_cart` WHERE INT_NUMBER='" . $cart_Data['INT_NUMBER'] . "'";
    mysql_query($Sql_Query);
?>
    <script language="javascript">
        alert('결제가 실패하였습니다. <?= $res_cd ?>');
        window.location.href = "index.php?int_type=<?= $cart_Data['INT_TYPE'] ?>&str_goodcode=<?= $cart_Data['STR_GOODCODE'] ?>";
    </script>
<?php
    exit;
}
