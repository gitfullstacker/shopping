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

switch ($good_name) {
    case '구독멤버십':
        $int_type = 1;
        break;
    case '렌트멥버십':
        $int_type = 2;
        break;
}

if ($res_cd == "0000") {
    // 사용자정보 얻기
    $SQL_QUERY =    'SELECT
                        A.*
                    FROM 
                        ' . $Tname . 'comm_member AS A
                    WHERE
                        A.STR_EMAIL="' . $buyr_mail . '"
                        AND A.STR_NAME="' . $buyr_name . '"';

    $arr_Rlt_Data = mysql_query($SQL_QUERY);
    $user_Data = mysql_fetch_assoc($arr_Rlt_Data);

    $SQL_QUERY =    'SELECT 
                        A.INT_NUMBER, A.STR_PTYPE, A.STR_CANCEL1, A.STR_CANCEL2, A.STR_CARDCODE, A.STR_PASS
                    FROM 
                        `' . $Tname . 'comm_member_pay` AS A
                    WHERE
                        A.STR_PTYPE="1"
                        AND A.STR_PASS="0" 
                        AND A.STR_USERID="' . $user_Data['STR_USERID'] . '"
                    ORDER BY DTM_INDATE
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
    $arr_Column_Name[4] = "STR_OIDXCODE";
    $arr_Column_Name[5] = "DTM_INDATE";
    $arr_Column_Name[6] = "INT_TYPE";

    $arr_Set_Data[0] = $card_Data['INT_NUMBER'];
    $arr_Set_Data[1] = $good_mny;
    $arr_Set_Data[2] = date('Y-m-d');
    $arr_Set_Data[3] = date('Y-m-d', strtotime("+1 month -1 day"));
    $arr_Set_Data[4] = $ordr_idxx;
    $arr_Set_Data[5] = date("Y-m-d H:i:s");
    $arr_Set_Data[6] = $int_type;

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
    $Sql_Query = "DELETE FROM  `" . $Tname . "comm_membership` WHERE STR_USERID = '" . $user_Data['STR_USERID'] . "' AND INT_TYPE=" . $int_type;
    mysql_query($Sql_Query);

    // 멤버십 등록
    $arr_Set_Data = array();
    $arr_Column_Name = array();

    $arr_Column_Name[0] = "STR_USERID";
    $arr_Column_Name[1] = "DTM_SDATE";
    $arr_Column_Name[2] = "DTM_EDATE";
    $arr_Column_Name[3] = "INT_TYPE";
    $arr_Column_Name[4] = "DTM_INDATE";

    $arr_Set_Data[0] = $user_Data['STR_USERID'];
    $arr_Set_Data[1] = date('Y-m-d H:i:s');
    $arr_Set_Data[2] = date('Y-m-d H:i:s', strtotime("+1 month -1 day"));
    $arr_Set_Data[3] = $int_type;
    $arr_Set_Data[4] = date("Y-m-d H:i:s");

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

    // 사용한 금액체크
    if ($user_Data['STR_GRADE'] != 'B') {
        $total_spent_money = getSpentMoney($user_Data['STR_USERID']);

        if ($total_spent_money >= 2000000) {
            addBlackCoupons($user_Data['STR_USERID']);
        }
    }
    ?>
    <script language="javascript">
        alert('멤버십결제가 성공하였습니다.');
        window.location.href = "index.php?int_type=<?= $int_type ?>";
    </script>
<?php
    exit;
} else {
?>
    <script language="javascript">
        alert('멤버십결제가 실패하였습니다. <?= $res_cd ?>');
        window.location.href = "index.php";
    </script>
<?php
    exit;
}
