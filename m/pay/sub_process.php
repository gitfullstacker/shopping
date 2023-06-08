<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], 1);
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], '');
$delivery_name = Fnc_Om_Conv_Default($_REQUEST['delivery_name'], '');
$delivery_address1 = Fnc_Om_Conv_Default($_REQUEST['delivery_address1'], '');
$delivery_address2 = Fnc_Om_Conv_Default($_REQUEST['delivery_address2'], '');
$delivery_postal = Fnc_Om_Conv_Default($_REQUEST['delivery_postal'], '');
$delivery_memo_type = Fnc_Om_Conv_Default($_REQUEST['delivery_memo_type'], '');
$delivery_memo = $delivery_memo_type == '0' ? Fnc_Om_Conv_Default($_REQUEST['delivery_memo'], '') : $delivery_memo_type;
$delivery_telep = Fnc_Om_Conv_Default($_REQUEST['delivery_telep'], '');
$delivery_hp = Fnc_Om_Conv_Default($_REQUEST['delivery_hp'], '');

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
$int_state = $int_type == 1 ? 4 : 0;

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

$arr_Set_Data[0]        = $arr_Auth[0];
$arr_Set_Data[1]        = $delivery_name;
$arr_Set_Data[2]        = $delivery_postal;
$arr_Set_Data[3]        = $delivery_address1;
$arr_Set_Data[4]        = $delivery_address2;
$arr_Set_Data[5]        = '';
$arr_Set_Data[6]        = '';
$arr_Set_Data[7]        = $delivery_memo;
$arr_Set_Data[8]        = $str_goodcode;
$arr_Set_Data[9]        = $str_goodcode . "001";
$arr_Set_Data[10]        = date("Y-m-d");
$arr_Set_Data[11]        = date("Y-m-d", strtotime("+1 month"));
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

?>

<script language="javascript">
    window.location.href = "paid.php?int_number=<?= $last_Data['last_number'] ?>";
</script>

<?php
exit;
?>
