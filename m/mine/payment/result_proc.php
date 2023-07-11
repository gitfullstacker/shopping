<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
fnc_MLogin_Chk();

$res_cd = Fnc_Om_Conv_Default($_REQUEST['res_cd'], "");
$res_msg = Fnc_Om_Conv_Default($_REQUEST['res_msg'], "");
$ordr_idxx = Fnc_Om_Conv_Default($_REQUEST['ordr_idxx'], "");
$card_cd = Fnc_Om_Conv_Default($_REQUEST['card_cd'], "");
$card_name = Fnc_Om_Conv_Default($_REQUEST['card_name'], "");
$batch_key = Fnc_Om_Conv_Default($_REQUEST['batch_key'], "");
$card_mask_no = Fnc_Om_Conv_Default($_REQUEST['card_mask_no'], "");
$str_userid = Fnc_Om_Conv_Default($_REQUEST['str_userid'], $arr_Auth[0]);

if ($res_cd == "0000") {
    $SQL_QUERY =    'UPDATE ' . $Tname . 'comm_member_pay SET STR_PASS1="1", STR_PASS2="1" WHERE STR_USERID="' . $str_userid . '"';
    mysql_query($SQL_QUERY);

    $arr_Set_Data = array();
    $arr_Column_Name = array();

    $arr_Column_Name[0]        = "STR_USERID";
    $arr_Column_Name[1]        = "STR_PTYPE";
    $arr_Column_Name[2]        = "STR_PAYMETHOD";
    $arr_Column_Name[3]        = "STR_PDATE";
    $arr_Column_Name[4]        = "INT_PRICE";
    $arr_Column_Name[5]        = "STR_PCARDCODE";
    $arr_Column_Name[6]        = "STR_BILLCODE";
    $arr_Column_Name[7]        = "STR_RESCD";
    $arr_Column_Name[8]        = "STR_RESMEG";
    $arr_Column_Name[9]        = "STR_ORDERIDX";
    $arr_Column_Name[10]        = "STR_CARDCODE";
    $arr_Column_Name[11]        = "STR_CARDNAME";
    $arr_Column_Name[12]        = "DTM_INDATE";
    $arr_Column_Name[13]        = "STR_CANCEL1";
    $arr_Column_Name[14]        = "STR_PASS1";
    $arr_Column_Name[15]        = "STR_CANCEL2";
    $arr_Column_Name[16]        = "STR_PASS2";
    $arr_Column_Name[17]        = "STR_CARDNO";

    $arr_Set_Data[0]        = $str_userid;
    $arr_Set_Data[1]        = "1";
    $arr_Set_Data[2]        = "bill";
    $arr_Set_Data[3]        = date("Y-m-d");
    $arr_Set_Data[4]        = 0;
    $arr_Set_Data[5]        = "";
    $arr_Set_Data[6]        = $batch_key;
    $arr_Set_Data[7]        = $res_cd;
    $arr_Set_Data[8]        = $res_msg;
    $arr_Set_Data[9]        = $ordr_idxx;
    $arr_Set_Data[10]        = $card_cd;
    $arr_Set_Data[11]        = $card_name;
    $arr_Set_Data[12]        = date("Y-m-d H:i:s");
    $arr_Set_Data[13]        = "0";
    $arr_Set_Data[14]        = "0";
    $arr_Set_Data[15]        = "0";
    $arr_Set_Data[16]        = "0";
    $arr_Set_Data[17]        = $card_mask_no;

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

    $Sql_Query = "INSERT INTO `" . $Tname . "comm_member_pay` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
    mysql_query($Sql_Query);
?>
    <script language="javascript">
        alert('카드설정이 성공하였습니다.');
        window.location.href = "index.php";
    </script>
<?php
    exit;
} else {
?>
    <script language="javascript">
        alert('카드설정이 실패하였습니다. <?= $res_cd ?>');
        window.location.href = "index.php";
    </script>
<?php
    exit;
}
