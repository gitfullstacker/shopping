<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>

<?php
$good_mny = Fnc_Om_Conv_Default($_REQUEST['good_mny'], "");
$batch_key = Fnc_Om_Conv_Default($_REQUEST['batch_key'], "");
$res_cd = Fnc_Om_Conv_Default($_REQUEST['res_cd'], "");
$res_msg = Fnc_Om_Conv_Default($_REQUEST['res_msg'], "");
$ordr_idxx = Fnc_Om_Conv_Default($_REQUEST['ordr_idxx'], "");
$card_cd = Fnc_Om_Conv_Default($_REQUEST['card_cd'], "");
$card_name = Fnc_Om_Conv_Default($_REQUEST['card_name'], "");

// 이전 카드 비활성화
$SQL_QUERY =    'UPDATE ' . $Tname . 'comm_member_pay SET STR_PASS="1" WHERE STR_USERID="' . $arr_Auth[0] . '"';

$arr_Set_Data = array();
$arr_Column_Name = array();

$arr_Column_Name[1]        = "STR_USERID";
$arr_Column_Name[2]        = "STR_PTYPE";
$arr_Column_Name[3]        = "STR_PAYMETHOD";
$arr_Column_Name[4]        = "STR_PDATE";
$arr_Column_Name[5]        = "INT_PRICE";
$arr_Column_Name[6]        = "STR_PCARDCODE";
$arr_Column_Name[7]        = "STR_BILLCODE";
$arr_Column_Name[8]        = "STR_RESCD";
$arr_Column_Name[9]        = "STR_RESMEG";
$arr_Column_Name[10]        = "STR_ORDERIDX";
$arr_Column_Name[11]        = "STR_CARDCODE";
$arr_Column_Name[12]        = "STR_CARDNAME";
$arr_Column_Name[13]        = "DTM_INDATE";
$arr_Column_Name[14]        = "STR_CANCEL1";
$arr_Column_Name[15]        = "STR_PASS";

$arr_Set_Data[1]        = $arr_Auth[0];
$arr_Set_Data[2]        = "1";
$arr_Set_Data[3]        = "bill";
$arr_Set_Data[4]        = date("Y-m-d");
$arr_Set_Data[5]        = $good_mny;
$arr_Set_Data[6]        = "";
$arr_Set_Data[7]        = $batch_key;
$arr_Set_Data[8]        = $res_cd;
$arr_Set_Data[9]        = $res_msg;
$arr_Set_Data[10]        = $ordr_idxx;
$arr_Set_Data[11]        = $card_cd;
$arr_Set_Data[12]        = $card_name;
$arr_Set_Data[13]        = date("Y-m-d H:i:s");
$arr_Set_Data[14]        = "0";
$arr_Set_Data[15]        = "0";

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
    window.location.href = "index.php";
</script>