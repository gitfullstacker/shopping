<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?php
$bd_seq = Fnc_Om_Conv_Default($_REQUEST['bd_seq'], '');

$result = array(
    "status" => 200,
    "data" => 0
);

if ($arr_Auth[0] == "") {
    $result["status"] = 401;
} else {
    $SQL_QUERY = 'SELECT COUNT(A.BD_SEQ) AS COUNT FROM 
                    ' . $Tname . 'comm_review_like AS A
                WHERE
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.BD_SEQ=' . $bd_seq;

    $arr_Rlt_Data = mysql_query($SQL_QUERY);

    if (!$arr_Rlt_Data) {
        $result["status"] = 500;
    } else {
        $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

        if ($arr_Data['COUNT'] == 0) {
            $SQL_QUERY = 'INSERT ' . $Tname . 'comm_review_like (STR_USERID, BD_SEQ) VALUES ("' . $arr_Auth[0] . '", ' . $bd_seq . ')';
            mysql_query($SQL_QUERY);
        } else {
            $SQL_QUERY = 'DELETE FROM ' . $Tname . 'comm_review_like WHERE STR_USERID="' . $arr_Auth[0] . '" AND BD_SEQ=' . $bd_seq;
            mysql_query($SQL_QUERY);
        }

        $SQL_QUERY =    'SELECT COUNT(A.BD_SEQ) AS COUNT FROM 
                            ' . $Tname . 'comm_review_like AS A
                        WHERE
                            A.BD_SEQ=' . $bd_seq;

        $arr_Rlt_Data = mysql_query($SQL_QUERY);
        $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

        $result["status"] = 200;
        $result["data"] = $arr_Data['COUNT'];
    }
}

echo json_encode($result);
