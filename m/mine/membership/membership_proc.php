<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "");
$ordr_idxx = Fnc_Om_Conv_Default($_REQUEST['ordr_idxx'], "");
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], "");
$int_number = Fnc_Om_Conv_Default($_REQUEST['int_number'], "");
$good_mny = Fnc_Om_Conv_Default($_REQUEST['good_mny'], "");

switch ($RetrieveFlag) {
    case "JOIN":
        $SQL_QUERY =    "SELECT 
                            A.INT_NUMBER, A.STR_PTYPE, A.STR_CANCEL1, A.STR_CANCEL2, A.STR_CARDCODE, A.STR_PASS
                        FROM 
                            `" . $Tname . "comm_member_pay` AS A
                        WHERE
                            A.STR_PTYPE='1'
                            AND A.STR_PASS='0' 
                            AND A.STR_USERID='$arr_Auth[0]'
                        ORDER BY DTM_INDATE
                        LIMIT 1 ";

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
        ?>
        <script language="javascript">
            window.location.href = "index.php?int_type=<?= $int_type ?>";
        </script>

<?php
        exit;
        break;

    case "CANCEL":
        switch ($int_type) {
            case 1:
                $SET_QUERY = 'STR_CANCEL1="1"';
                break;
            case 2:
                $SET_QUERY = 'STR_CANCEL2="1"';
                break;
        }
        $SQL_QUERY =    'UPDATE 
                            ' . $Tname . 'comm_member_pay 
                        SET 
                            ' . $SET_QUERY . ' 
                        WHERE 
                            INT_NUMBER=' . $int_number;

        mysql_query($SQL_QUERY);

        echo 'successful';

        exit;
        break;

    case "RESTORE":
        switch ($int_type) {
            case 1:
                $SET_QUERY = 'STR_CANCEL1="0"';
                break;
            case 2:
                $SET_QUERY = 'STR_CANCEL2="0"';
                break;
        }
        $SQL_QUERY =    'UPDATE 
                                ' . $Tname . 'comm_member_pay 
                            SET 
                                ' . $SET_QUERY . ' 
                            WHERE 
                                INT_NUMBER=' . $int_number;

        mysql_query($SQL_QUERY);

        echo 'successful';

        exit;
        break;
}
?>