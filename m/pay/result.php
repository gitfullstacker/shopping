<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], 1);
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], '');
$pay_price = Fnc_Om_Conv_Default($_REQUEST['pay_price'], 0);

$SQL_QUERY =    'DELETE
                FROM 
                    ' . $Tname . 'comm_membership AS A
                WHERE
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.INT_TYPE=' . $int_type;

mysql_query($SQL_QUERY);

$arr_Set_Data = array();
$arr_Column_Name = array();

$arr_Column_Name[0]        = "STR_USERID";
$arr_Column_Name[1]        = "DTM_SDATE";
$arr_Column_Name[2]        = "DTM_EDATE";
$arr_Column_Name[3]        = "INT_TYPE";
$arr_Column_Name[4]        = "DTM_INDATE";

$arr_Set_Data[0]        = $arr_Auth[0];
$arr_Set_Data[1]        = date('Y-m-d');
$arr_Set_Data[2]        = date('Y-m-d', strtotime('+30 days', strtotime(date('Y-m-d'))));
$arr_Set_Data[3]        = $int_type;
$arr_Set_Data[4]        = date("Y-m-d H:i:s");

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

$SQL_QUERY = "INSERT INTO `" . $Tname . "comm_membership` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
mysql_query($SQL_QUERY);
?>

<script language="javascript">
    window.location.href = "paid.php?int_type=<?= $int_type ?>&str_goodcode=<?= $str_goodcode ?>";
</script>

<?php
exit;
?>