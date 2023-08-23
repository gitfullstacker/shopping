<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?php
$bd_seq = Fnc_Om_Conv_Default($_REQUEST['seq'], 0);

$result = array(
    "status" => 200,
    "data" => 0
);

$SQL_QUERY =    'SELECT 
                    A.BD_BEST, A.INT_CART, A.MEM_ID 
                FROM 
                    `' . $Tname . 'b_bd_data@01` AS A
                WHERE
                    A.BD_SEQ=' . $bd_seq;

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if ($arr_Rlt_Data) {
    $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

    $bd_best = $arr_Data['BD_BEST'] == 0 ? 1 : 0;

    $SQL_QUERY = 'UPDATE `' . $Tname . 'b_bd_data@01` SET BD_BEST=' . $bd_best . ' WHERE BD_SEQ=' . $bd_seq;
    mysql_query($SQL_QUERY);

    // 금액정보 얻기
    $SQL_QUERY =    " SELECT
                        *
                    FROM 
                        " . $Tname . "comm_site_info
                    WHERE
                        INT_NUMBER=1 ";

    $arr_Rlt_Data = mysql_query($SQL_QUERY);
    $site_Data = mysql_fetch_assoc($arr_Rlt_Data);

    if ($bd_best == 1) {
        // 적립금 지급
        $mileage = $site_Data['INT_STAMP3'];
        $str_gubun = '3';

        if ($mileage > 0) {
            $SQL_QUERY =    "UPDATE `" . $Tname . "comm_member` SET INT_MILEAGE = INT_MILEAGE+" . $mileage . " WHERE STR_USERID='" . $arr_Auth[0] . "'";
            var_dump($SQL_QUERY);
            exit;
            $arr_Rlt_Data = mysql_query($SQL_QUERY);

            if ($arr_Data['INT_CART']) {
                $arr_Get_Data = array();
                $arr_Column_Name = array();

                $arr_Column_Name[0]     =     "STR_USERID";
                $arr_Column_Name[1]     =     "STR_INCOME";
                $arr_Column_Name[2]     =     "DTM_INDATE";
                $arr_Column_Name[3]     =     "STR_ORDERIDX";
                $arr_Column_Name[4]     =     "INT_VALUE";
                $arr_Column_Name[5]     =     "INT_CART";
                $arr_Column_Name[6]     =     "STR_GUBUN";

                $arr_Set_Data[0]        = $arr_Data['MEM_ID'];
                $arr_Set_Data[1]        = "Y";
                $arr_Set_Data[2]        = date("Y-m-d H:i:s");
                $arr_Set_Data[3]        = "";
                $arr_Set_Data[4]        = $mileage;
                $arr_Set_Data[5]        = $arr_Data['INT_CART'];
                $arr_Set_Data[6]        = $str_gubun;

                $arr_Sub1 = "";
                $arr_Sub2 = "";
                for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {
                    if ($int_I != 0) {
                        $arr_Sub1 .=  ",";
                        $arr_Sub2 .=  ",";
                    }
                    $arr_Sub1 .=  $arr_Column_Name[$int_I];
                    $arr_Sub2 .=  $arr_Set_Data[$int_I] ? "'" . $arr_Set_Data[$int_I] . "'" : "null";
                }

                $Sql_Query = "INSERT INTO `" . $Tname . "comm_mileage_history` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
                mysql_query($Sql_Query);
            }
        }
    } else {
        // // 적립금 삭제
        // if ($arr_Data['INT_CART']) {
        //     $Sql_Query = 'SELECT * FROM `' . $Tname . 'comm_mileage_history` WHERE STR_INCOME="Y" AND STR_USERID="' . $arr_Data['MEM_ID'] . '" AND INT_CART=' . $arr_Data['INT_CART'];
        //     $arr_Rlt_Data = mysql_query($Sql_Query);
        //     $hitory_Data = mysql_fetch_assoc($arr_Rlt_Data);

        //     if ($hitory_Data['INT_VALUE']) {
        //         if ($hitory_Data['INT_NUMBER']) {
        //             $SQL_QUERY =  'DELETE FROM `' . $Tname . 'comm_mileage_history` WHERE INT_NUMBER=' . $hitory_Data['INT_NUMBER'];
        //             mysql_query($SQL_QUERY);
        //         }
        //     }
        // }

        // $SQL_QUERY =  'UPDATE `' . $Tname . 'comm_member` SET INT_MILEAGE = INT_MILEAGE-' . $site_Data['INT_STAMP3'] . ' WHERE STR_USERID="' . $arr_Data['MEM_ID'] . '"';
        // mysql_query($SQL_QUERY);
    }

    $result["status"] = 200;
    $result["data"] = $bd_best;
} else {
    $result["status"] = 500;
}



echo json_encode($result);
