<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], '');
$int_cart = Fnc_Om_Conv_Default($_REQUEST['int_cart'], '');
$d_date = Fnc_Om_Conv_Default($_REQUEST['d_date'], '');

switch ($RetrieveFlag) {
    case "CANCELORDER":
        $Sql_Query = "UPDATE `" . $Tname . "comm_goods_cart` SET INT_STATE=11, DTM_EDIT_DATE='" . date("Y-m-d H:i:s") . "' WHERE INT_NUMBER=" . $int_cart;
        mysql_query($Sql_Query);
        echo 'successful';

        exit;
        break;

    case "RETURNORDER":
        $Sql_Query = "UPDATE `" . $Tname . "comm_goods_cart` SET INT_STATE=5, STR_RDATE='" . $d_date . "', DTM_EDIT_DATE='" . date("Y-m-d H:i:s") . "' WHERE INT_NUMBER=" . $int_cart;
        mysql_query($Sql_Query);
        echo 'successful';

        exit;
        break;
    case "RECEIVEDORDER":
        $Sql_Query = "UPDATE `" . $Tname . "comm_goods_cart` SET INT_STATE=6 WHERE INT_NUMBER=" . $int_cart . ", DTM_EDIT_DATE='" . date("Y-m-d H:i:s") . "'";
        mysql_query($Sql_Query);
        echo 'successful';

        exit;
        break;
}

?>