<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?php
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "DOWN");
$int_gubun = Fnc_Om_Conv_Default($_REQUEST['int_gubun'], "1");
$int_number = Fnc_Om_Conv_Default($_REQUEST['int_number'], "");

$SQL_QUERY = "SELECT IFNULL(A.INT_ORDER,0) AS ORDER_NUM FROM " . $Tname . "comm_banner A WHERE A.INT_NUMBER = " . $int_number;

$arr_Data = mysql_query($SQL_QUERY);
$current_order = mysql_result($arr_Data, 0, 'ORDER_NUM');

switch ($RetrieveFlag) {
    case 'UP':
        $next_order = $current_order - 1;
        break;
    case 'DOWN':
        $next_order = $current_order + 1;
        break;
}

if ($next_order >= 0) {
    $SQL_QUERY = "UPDATE " . $Tname . "comm_banner SET INT_ORDER = " . $next_order . " WHERE INT_NUMBER = " . $int_number;
    $arr_Data = mysql_query($SQL_QUERY);
}
?>
<script language="javascript">
    window.location.href = "bann_main_list.php?int_gubun=<?= $int_gubun ?>";
</script>
<?
exit;
