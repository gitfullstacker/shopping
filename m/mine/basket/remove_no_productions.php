<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?php

$result = array(
    "status" => 200,
    "data" => 0
);

if ($arr_Auth[0] == "") {
    $result["status"] = 401;
} else {
    $SQL_QUERY =    'DELETE FROM 
                        ' . $Tname . 'comm_member_basket A 
                    LEFT JOIN
                        ' . $Tname . 'comm_goods_master B
                    ON
                        A.STR_GOODCODE=B.STR_GOODCODE 
                    WHERE A.STR_USERID="' . $arr_Auth[0] . '"
                        AND B.STR_SERVICE="N"
                        AND B.INT_TYPE=3';
    mysql_query($SQL_QUERY);
    $result["data"] = true;

    $result["status"] = 200;
}

echo json_encode($result);
