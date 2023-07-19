<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$res_cd = Fnc_Om_Conv_Default($_REQUEST['res_cd'], "");
$res_msg = Fnc_Om_Conv_Default($_REQUEST['res_msg'], "");
$ordr_idxx = Fnc_Om_Conv_Default($_REQUEST['ordr_idxx'], "");
$good_mny = Fnc_Om_Conv_Default($_REQUEST['good_mny'], "");
$good_name = Fnc_Om_Conv_Default($_REQUEST['good_name'], "");
$buyr_name = Fnc_Om_Conv_Default($_REQUEST['buyr_name'], "");
$buyr_mail = Fnc_Om_Conv_Default($_REQUEST['buyr_mail'], "");
$card_cd = Fnc_Om_Conv_Default($_REQUEST['card_cd'], "");
$card_name = Fnc_Om_Conv_Default($_REQUEST['card_name'], "");

$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_membership_cart AS A
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

    //카드정보얻기
    $SQL_QUERY =    'SELECT 
                        A.*
                    FROM 
                        `' . $Tname . 'comm_member_pay` AS A
                    WHERE
                        A.STR_USERID="' . $cart_Data['STR_USERID'] . '"
                        AND A.STR_USING <> "N"
                    ORDER BY DTM_INDATE DESC
                    LIMIT 1 ';

    $arr_Rlt_Data = mysql_query($SQL_QUERY);
    $card_Data = mysql_fetch_assoc($arr_Rlt_Data);

    if (!$card_Data) {
?>
        <script language="javascript">
            alert('등록된 카드가 없습니다.');
            window.location.href = "/m/mine/payment/index.php";
        </script>

    <?php
        exit;
    }

    // 페이 리력기록
    $arr_Set_Data = array();
    $arr_Column_Name = array();

    $arr_Column_Name[0] = "INT_NUMBER";
    $arr_Column_Name[1] = "INT_SPRICE";
    $arr_Column_Name[2] = "STR_SDATE";
    $arr_Column_Name[3] = "STR_EDATE";
    $arr_Column_Name[4] = "STR_ORDERIDX";
    $arr_Column_Name[5] = "DTM_INDATE";
    $arr_Column_Name[6] = "INT_TYPE";

    $arr_Set_Data[0] = $card_Data['INT_NUMBER'];
    $arr_Set_Data[1] = $good_mny;
    $arr_Set_Data[2] = date('Y-m-d');
    $arr_Set_Data[3] = date('Y-m-d', strtotime("+1 month -1 day"));
    $arr_Set_Data[4] = $ordr_idxx;
    $arr_Set_Data[5] = date("Y-m-d H:i:s");
    $arr_Set_Data[6] = $cart_Data['INT_TYPE'];

    $arr_Sub1 = "";
    $arr_Sub2 = "";

    for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

        if ($int_I != 0) {
            $arr_Sub1 .=  ",";
            $arr_Sub2 .=  ",";
        }
        $arr_Sub1 .=  $arr_Column_Name[$int_I];
        $arr_Sub2 .=  $arr_Set_Data[$int_I] ? "'" . $arr_Set_Data[$int_I] . "'" : 'null ';
    }

    $Sql_Query = "INSERT INTO `" . $Tname . "comm_member_pay_info` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
    mysql_query($Sql_Query);

    // 이전 멤버십 삭제
    $Sql_Query = "DELETE FROM  `" . $Tname . "comm_membership` WHERE STR_USERID = '" . $cart_Data['STR_USERID'] . "' AND INT_TYPE=" . $cart_Data['INT_TYPE'];
    mysql_query($Sql_Query);

    // 멤버십 등록
    $arr_Set_Data = array();
    $arr_Column_Name = array();

    $arr_Column_Name[0] = "STR_USERID";
    $arr_Column_Name[1] = "DTM_SDATE";
    $arr_Column_Name[2] = "DTM_EDATE";
    $arr_Column_Name[3] = "INT_TYPE";
    $arr_Column_Name[4] = "DTM_INDATE";
    $arr_Column_Name[5] = "STR_ORDERIDX";

    $arr_Set_Data[0] = $cart_Data['STR_USERID'];
    $arr_Set_Data[1] = date('Y-m-d H:i:s');
    $arr_Set_Data[2] = date('Y-m-d H:i:s', strtotime("+1 month -1 day"));
    $arr_Set_Data[3] = $cart_Data['INT_TYPE'];
    $arr_Set_Data[4] = date("Y-m-d H:i:s");
    $arr_Set_Data[5] = $ordr_idxx;

    $arr_Sub1 = "";
    $arr_Sub2 = "";

    for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

        if ($int_I != 0) {
            $arr_Sub1 .=  ",";
            $arr_Sub2 .=  ",";
        }
        $arr_Sub1 .=  $arr_Column_Name[$int_I];
        $arr_Sub2 .=  $arr_Set_Data[$int_I] ? "'" . $arr_Set_Data[$int_I] . "'" : 'null ';
    }

    $Sql_Query = "INSERT INTO `" . $Tname . "comm_membership` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
    mysql_query($Sql_Query);

    // 카드 결제완료와 신청취소 기정으로 표시
    switch ($cart_Data['INT_TYPE']) {
        case 1:
            $SET_QUERY = "STR_PASS1='0', STR_CANCEL1='0', DTM_LAST_USED='" . date("Y-m-d H:i:s") . "'";
            break;
        case 2:
            $SET_QUERY = "STR_PASS2='0', STR_CANCEL2='0', DTM_LAST_USED='" . date("Y-m-d H:i:s") . "'";
            break;
    }
    $Sql_Query = "UPDATE `" . $Tname . "comm_member_pay` SET " . $SET_QUERY . " WHERE INT_NUMBER=" . $card_Data['INT_NUMBER'];
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
    $Sql_Query = "UPDATE `" . $Tname . "comm_membership_cart` SET INT_STATE=1 WHERE INT_NUMBER='" . $cart_Data['INT_NUMBER'] . "'";
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
        alert('멤버십결제가 성공하였습니다.');
        window.location.href = "index.php?int_type=<?= $cart_Data['INT_TYPE'] ?>";
    </script>
<?php
    exit;
} else {
    $Sql_Query = "DELETE FROM `" . $Tname . "comm_membership_cart` WHERE INT_NUMBER='" . $cart_Data['INT_NUMBER'] . "'";
    mysql_query($Sql_Query);
?>
    <script language="javascript">
        alert('멤버십결제가 실패하였습니다. <?= $res_cd ?>: <?= $res_msg ?>');
        window.location.href = "index.php";
    </script>
<?php
    exit;
}
