<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], 1);
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], '');

$arr_Set_Data = array();
$arr_Column_Name = array();

$arr_Column_Name[0]        = "STR_USERID";
$arr_Column_Name[1]        = "STR_GOODCODE";
$arr_Column_Name[2]        = "DTM_INDATE";

$arr_Set_Data[0]        = $arr_Auth[0];
$arr_Set_Data[1]        = $str_goodcode;
$arr_Set_Data[2]        = date("Y-m-d H:i:s");

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

$SQL_QUERY = "INSERT INTO `" . $Tname . "comm_member_subscription` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
mysql_query($SQL_QUERY);
?>

<script language="javascript">
    window.location.href = "paid.php?int_type=<?= $int_type ?>&str_goodcode=<?= $str_goodcode ?>";
</script>

<?php
exit;
?>
