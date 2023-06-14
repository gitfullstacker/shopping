<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?php

$str_goodcode = $_GET['str_goodcode'];

$result = array(
    "status" => 200,
    "data" => 0
);

if ($arr_Auth[0] == "") {
    $result["status"] = 401;
} else {
    $SQL_QUERY =    'DELETE FROM 
                        ' . $Tname . 'comm_member_basket A 
                    WHERE A.STR_USERID="' . $arr_Auth[0] . '"
                        AND A.STR_GOODCODE="' . $str_goodcode . '"';
    mysql_query($SQL_QUERY);
    $result["data"] = true;

    $result["status"] = 200;
}

echo json_encode($result);
