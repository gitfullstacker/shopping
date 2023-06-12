<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], '');
$int_cart = Fnc_Om_Conv_Default($_REQUEST['int_cart'], '');

switch ($RetrieveFlag) {
    case "CANCELORDER":
        $Sql_Query = "UPDATE `" . $Tname . "comm_goods_cart` SET INT_STATE=0 WHERE INT_NUMBER=" . $int_cart;
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
    case "PWSET":

        $SQL_QUERY = "select * from ";
        $SQL_QUERY .= $Tname;
        $SQL_QUERY .= "comm_member
						where
							STR_USERID='$str_userid'
							AND 
							STR_NAME='$str_rname'
							AND 
							STR_HP='$str_rhp' ";

        $arr_sub_Data = mysql_query($SQL_QUERY);
        $rcd_cnt = mysql_num_rows($arr_sub_Data);

        if (!($rcd_cnt)) {
?>
            <script language="javascript">
                alert("회원정보가 일치하지 않습니다.");
                window.location.href = "idpw_search.php?menu=2&id_step=1";
            </script>
<?
        } else {
            $Sql_Query = "UPDATE `" . $Tname . "comm_member` SET STR_PASSWD=password('$str_password') WHERE STR_USERID='$str_userid' AND STR_NAME='$str_rname' AND STR_HP='$str_rhp'";
            mysql_query($Sql_Query);

            echo 'successful';
        }
        exit;
        break;
}

?>