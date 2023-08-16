<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
// Set a higher maximum execution time (e.g., 600 seconds)
set_time_limit(600);

// $SQL_QUERY =    'SELECT 
//                     A.*, B.*
//                 FROM 
//                     `' . $Tname . 'comm_member_pay1` A
//                 LEFT JOIN
//                     `' . $Tname . 'comm_member_pay_info1` B
//                 ON
//                     A.INT_NUMBER = B.INT_NUMBER
//                 WHERE 
//                     CURDATE() BETWEEN B.STR_SDATE AND B.STR_EDATE';

$SQL_QUERY =    'SELECT 
                    A.*, B.*
                FROM 
                    `' . $Tname . 'comm_member_pay1` A
                LEFT JOIN
                    `' . $Tname . 'comm_member_pay_info1` B
                ON
                    A.INT_NUMBER = B.INT_NUMBER';

$pay_list_result = mysql_query($SQL_QUERY);

var_dump($SQL_QUERY);
exit;

while ($row = mysql_fetch_assoc($pay_list_result)) {
    // 카드등록
    $arr_Set_Data = array();
    $arr_Column_Name = array();

    $arr_Column_Name[0]        = "STR_USERID";
    $arr_Column_Name[1]        = "STR_PTYPE";
    $arr_Column_Name[2]        = "STR_PAYMETHOD";
    $arr_Column_Name[3]        = "STR_PDATE";
    $arr_Column_Name[4]        = "INT_PRICE";
    $arr_Column_Name[5]        = "STR_PCARDCODE";
    $arr_Column_Name[6]        = "STR_BILLCODE";
    $arr_Column_Name[7]        = "STR_RESCD";
    $arr_Column_Name[8]        = "STR_RESMEG";
    $arr_Column_Name[9]        = "STR_ORDERIDX";
    $arr_Column_Name[10]        = "STR_CARDCODE";
    $arr_Column_Name[11]        = "STR_CARDNAME";
    $arr_Column_Name[12]        = "DTM_INDATE";
    $arr_Column_Name[13]        = "STR_CANCEL1";
    $arr_Column_Name[14]        = "STR_PASS1";
    $arr_Column_Name[15]        = "STR_CANCEL2";
    $arr_Column_Name[16]        = "STR_PASS2";
    $arr_Column_Name[17]        = "STR_CARDNO";
    $arr_Column_Name[18]        = "DTM_LAST_USED";
    $arr_Column_Name[19]        = "STR_USING";

    $arr_Set_Data[0]        = $row['STR_USERID'];
    $arr_Set_Data[1]        = $row['STR_PTYPE'];
    $arr_Set_Data[2]        = $row['STR_PAYMETHOD'];
    $arr_Set_Data[3]        = $row['STR_PDATE'];
    $arr_Set_Data[4]        = $row['INT_PRICE'];
    $arr_Set_Data[5]        = $row['STR_PCARDCODE'];
    $arr_Set_Data[6]        = $row['STR_BILLCODE'];
    $arr_Set_Data[7]        = $row['STR_RESCD'];
    $arr_Set_Data[8]        = $row['STR_RESMEG'];
    $arr_Set_Data[9]        = $row['STR_ORDERIDX'];
    $arr_Set_Data[10]        = $row['STR_CARDCODE'];
    $arr_Set_Data[11]        = $row['STR_CARDNAME'];
    $arr_Set_Data[12]        = $row['DTM_INDATE'];
    $arr_Set_Data[13]        = $row['STR_CANCEL'];
    $arr_Set_Data[14]        = $row['STR_PASS'];
    $arr_Set_Data[15]        = "0";
    $arr_Set_Data[16]        = "0";
    $arr_Set_Data[17]        = "";
    $arr_Set_Data[18]        = $row['DTM_INDATE'];
    $arr_Set_Data[19]        = "Y";

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

    $Sql_Query = "INSERT INTO `" . $Tname . "comm_member_pay` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
    $result = mysql_query($Sql_Query);

    if ($result) {
        // Get the last inserted ID
        $last_id = mysql_insert_id();

        // 결제리력 등록
        $arr_Set_Data = array();
        $arr_Column_Name = array();

        $arr_Column_Name[0] = "INT_NUMBER";
        $arr_Column_Name[1] = "INT_SPRICE";
        $arr_Column_Name[2] = "STR_SDATE";
        $arr_Column_Name[3] = "STR_EDATE";
        $arr_Column_Name[4] = "STR_ORDERIDX";
        $arr_Column_Name[5] = "DTM_INDATE";
        $arr_Column_Name[6] = "INT_TYPE";

        $arr_Set_Data[0] = $last_id;
        $arr_Set_Data[1] = $row['INT_SPRICE'];
        $arr_Set_Data[2] = $row['STR_SDATE'];
        $arr_Set_Data[3] = $row['STR_EDATE'];
        $arr_Set_Data[4] = $row['STR_OIDXCODE'];
        $arr_Set_Data[5] = $row['DTM_INDATE'];
        $arr_Set_Data[6] = "1";

        $arr_Sub1 = "";
        $arr_Sub2 = "";

        for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

            if ($int_I != 0) {
                $arr_Sub1 .=  ",";
                $arr_Sub2 .=  ",";
            }
            $arr_Sub1 .=  $arr_Column_Name[$int_I];
            $arr_Sub2 .=  $arr_Set_Data[$int_I] ? "'" . $arr_Set_Data[$int_I] . "'" : 'null ';
        }

        $Sql_Query = "INSERT INTO `" . $Tname . "comm_member_pay_info` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
        mysql_query($Sql_Query);

        $startDateTimestamp = strtotime($row['STR_SDATE']);
        $endDateTimestamp = strtotime($row['STR_EDATE']);
        $currentTimestamp = time();

        if ($currentTimestamp >= $startDateTimestamp && $currentTimestamp <= $endDateTimestamp) {
            // 멤버십 등록
            $arr_Set_Data = array();
            $arr_Column_Name = array();

            $arr_Column_Name[0] = "STR_USERID";
            $arr_Column_Name[1] = "DTM_SDATE";
            $arr_Column_Name[2] = "DTM_EDATE";
            $arr_Column_Name[3] = "INT_TYPE";
            $arr_Column_Name[4] = "DTM_INDATE";
            $arr_Column_Name[5] = "STR_ORDERIDX";

            $arr_Set_Data[0] = $row['STR_USERID'];
            $arr_Set_Data[1] = $row['STR_SDATE'];
            $arr_Set_Data[2] = $row['STR_EDATE'];
            $arr_Set_Data[3] = "1";
            $arr_Set_Data[4] = $row['DTM_INDATE'];
            $arr_Set_Data[5] = $row['STR_OIDXCODE'];

            $arr_Sub1 = "";
            $arr_Sub2 = "";

            for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

                if ($int_I != 0) {
                    $arr_Sub1 .=  ",";
                    $arr_Sub2 .=  ",";
                }
                $arr_Sub1 .=  $arr_Column_Name[$int_I];
                $arr_Sub2 .=  $arr_Set_Data[$int_I] ? "'" . $arr_Set_Data[$int_I] . "'" : 'null ';
            }

            $Sql_Query = "INSERT INTO `" . $Tname . "comm_membership` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
            mysql_query($Sql_Query);
        }
    }
}
?>