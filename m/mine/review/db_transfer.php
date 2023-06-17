<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$SQL_QUERY = 'SELECT A.*, B.IMG_F_NAME FROM `ablanc_b_bd_data@01` AS A LEFT JOIN `ablanc_b_img_data@01` AS B ON A.BD_SEQ = B.BD_SEQ;';

$arr_Data = mysql_query($SQL_QUERY);
$arr_Data_Cnt = mysql_num_rows($arr_Data);

for ($i = 0; $i < $arr_Data_Cnt; $i++) {
    $arr_Column_Name[0]     =     "STR_GOODCODE";
    $arr_Column_Name[1]     =     "INT_CART";
    $arr_Column_Name[2]     =     "STR_USERID";
    $arr_Column_Name[3]     =     "INT_GOOD_TYPE";
    $arr_Column_Name[4]     =     "STR_CONTENT";
    $arr_Column_Name[5]     =     "STR_IMAGE1";
    $arr_Column_Name[6]     =     "STR_IMAGE2";
    $arr_Column_Name[7]     =     "STR_IMAGE3";
    $arr_Column_Name[8]     =     "DTM_REG_DATE";
    $arr_Column_Name[9]     =     "DTM_EDIT_DATE";
    $arr_Column_Name[10]    =     "INT_VIEW";
    $arr_Column_Name[11]    =     "INT_STAR";
    $arr_Column_Name[12]    =     "INT_USE_REVIEW";
    $arr_Column_Name[13]    =     "INT_PACKAGE_REVIEW";
    $arr_Column_Name[14]    =     "INT_DELIVERY_REVIEW";

    $arr_Set_Data[0]        = mysql_result($arr_Data, $i, 'BD_ITEM1');
    $arr_Set_Data[1]        = null;
    $arr_Set_Data[2]        = mysql_result($arr_Data, $i, 'MEM_ID');
    $arr_Set_Data[3]        = 1;
    $arr_Set_Data[4]        = mysql_result($arr_Data, $i, 'BD_CONT');
    $arr_Set_Data[5]        = mysql_result($arr_Data, $i, 'IMG_F_NAME');
    $arr_Set_Data[6]        = null;
    $arr_Set_Data[7]        = null;
    $arr_Set_Data[8]        = mysql_result($arr_Data, $i, 'BD_REG_DATE');
    $arr_Set_Data[9]        = mysql_result($arr_Data, $i, 'BD_EDIT_DATE');
    $arr_Set_Data[10]       = mysql_result($arr_Data, $i, 'BD_VIEW_CNT');
    $arr_Set_Data[11]       = mysql_result($arr_Data, $i, 'BD_ITEM2');
    $arr_Set_Data[12]       = null;
    $arr_Set_Data[13]       = null;
    $arr_Set_Data[14]       = null;

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

    $Sql_Query = "INSERT INTO `ablanc_comm_review` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
    mysql_query($Sql_Query);
}
