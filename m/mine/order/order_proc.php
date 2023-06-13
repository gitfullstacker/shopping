<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], '');
$int_cart = Fnc_Om_Conv_Default($_REQUEST['int_cart'], '');

switch ($RetrieveFlag) {
    case "CANCELORDER":
        $Sql_Query = "UPDATE `" . $Tname . "comm_goods_cart` SET INT_STATE=11 WHERE INT_NUMBER=" . $int_cart;
        mysql_query($Sql_Query);
        echo 'successful';

        exit;
        break;

    case "RETURNORDER":
        $SQL_QUERY =    "select * 
                        FROM " . $Tname . "comm_goods_cart A
						WHERE
                            A.INT_NUMBER=" . $int_cart;

        $arr_sub_Data = mysql_query($SQL_QUERY);
        $order_Data = mysql_num_rows($arr_sub_Data);

        echo $order_Data['STR_EDATE'];

        exit;
        break;
    case "RECEIVEDORDER":
        $Sql_Query = "UPDATE `" . $Tname . "comm_goods_cart` SET INT_STATE=6 WHERE INT_NUMBER=" . $int_cart;
        mysql_query($Sql_Query);
        echo 'successful';

        exit;
        break;
}

?>