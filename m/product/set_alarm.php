<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?php
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], '');
$type = Fnc_Om_Conv_Default($_REQUEST['type'], '');

$result = array(
    "status" => 200,
    "data" => 0
);

if ($arr_Auth[0] == "") {
    $result["status"] = 401;
} else {
    if ($type == "removeAll") {
        $SQL_QUERY = 'DELETE FROM ' . $Tname . 'comm_member_alarm WHERE STR_USERID="' . $arr_Auth[0] . '"';
        mysql_query($SQL_QUERY);
        $result["data"] = true;

        $result["status"] = 200;
    } else {
        $SQL_QUERY =    'SELECT 
                            COUNT(A.INT_NUMBER) AS COUNT_NUM 
                        FROM 
                            ' . $Tname . 'comm_member_alarm AS A
                        WHERE
                            A.STR_USERID="' . $arr_Auth[0] . '"
                            AND A.STR_GOODCODE="' . $str_goodcode . '"';

        $arr_Rlt_Data = mysql_query($SQL_QUERY);

        if (!$arr_Rlt_Data) {
            $result["status"] = 500;
        } else {
            $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

            if ($arr_Data['COUNT_NUM'] == 0) {
                // 마감값 얻기
                $SQL_QUERY =    'SELECT 
                                    COALESCE(MAX(INT_NUMBER), 0) + 1 AS LAST_NUM 
                                FROM 
                                    ' . $Tname . 'comm_member_alarm AS A
                                WHERE
                                    A.STR_GOODCODE="' . $str_goodcode . '"';

                $arr_Rlt_Data = mysql_query($SQL_QUERY);
                $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

                $SQL_QUERY = 'INSERT ' . $Tname . 'comm_member_alarm (STR_USERID, STR_GOODCODE, INT_NUMBER, DTM_INDATE) VALUES ("' . $arr_Auth[0] . '", "' . $str_goodcode . '", ' . $arr_Data['LAST_NUM'] . ', "' . date("Y-m-d H:i:s") . '")';
                mysql_query($SQL_QUERY);
                $result["data"] = true;
            } else {
                $SQL_QUERY = 'DELETE FROM ' . $Tname . 'comm_member_alarm WHERE STR_USERID="' . $arr_Auth[0] . '" AND STR_GOODCODE="' . $str_goodcode . '"';
                mysql_query($SQL_QUERY);
                $result["data"] = false;
            }

            $result["status"] = 200;
        }
    }
}

echo json_encode($result);
