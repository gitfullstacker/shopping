<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?php

$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "INSERT");

$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'] . "/admincenter/files/review/";

if (!is_dir($str_Add_Tag)) {
    mkdir($str_Add_Tag, 0777);
}

switch ($RetrieveFlag) {
    case "INSERT":
        $str_images = array();

        for ($i = 0; $i < count($_FILES['str_image']['tmp_name']); $i++) {
            $obj_File = $_FILES['str_image']['tmp_name'][$i];
            $obj_File_name = $_FILES['str_image']['name'][$i];
            $obj_File_size = $_FILES['str_image']['size'][$i];

            $full_name = explode(".", "$obj_File_name");

            $str_Temp = Fnc_Om_File_Save($obj_File, $obj_File_name, "", 0, 0, "", $str_Add_Tag);
            $str_images[$i] = $str_Temp[1][0];
        }

        $arr_Get_Data = array();
        $arr_Column_Name = array();

        $arr_Column_Name[0]     =     "STR_GOODCODE";
        $arr_Column_Name[1]     =     "STR_CART";
        $arr_Column_Name[2]     =     "STR_USERID";
        $arr_Column_Name[3]     =     "INT_GOOD_TYPE";
        $arr_Column_Name[4]     =     "STR_CONTENT";
        $arr_Column_Name[5]     =     "STR_IMAGE1";
        $arr_Column_Name[6]     =     "STR_IMAGE2";
        $arr_Column_Name[7]     =     "STR_IMAGE3";
        $arr_Column_Name[8]     =     "DTM_REG_DATE";
        $arr_Column_Name[9]     =     "DTM_EDIT_DATE";
        $arr_Column_Name[10]    =     "INT_STAR";
        $arr_Column_Name[11]    =     "INT_USE_REVIEW";
        $arr_Column_Name[12]    =     "INT_PACKAGE_REVIEW";
        $arr_Column_Name[13]    =     "INT_DELIVERY_REVIEW";

        $arr_Set_Data[0]        = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], "");
        $arr_Set_Data[1]        = Fnc_Om_Conv_Default($_REQUEST['int_cart'], "");
        $arr_Set_Data[2]        = Fnc_Om_Conv_Default($_REQUEST['str_userid'], "");
        $arr_Set_Data[3]        = Fnc_Om_Conv_Default($_REQUEST['int_good_type'], 1);
        $arr_Set_Data[4]        = Fnc_Om_Conv_Default($_REQUEST['str_content'], "");
        $arr_Set_Data[5]        = $str_images[0] ?: "";
        $arr_Set_Data[6]        = $str_images[1] ?: "";
        $arr_Set_Data[7]        = $str_images[2] ?: "";
        $arr_Set_Data[8]        = date("Y-m-d H:i:s");
        $arr_Set_Data[9]        = date("Y-m-d H:i:s");
        $arr_Set_Data[10]       = Fnc_Om_Conv_Default($_REQUEST['int_star'], 5);
        $arr_Set_Data[11]       = Fnc_Om_Conv_Default($_REQUEST['int_use_review'], 3);
        $arr_Set_Data[12]       = Fnc_Om_Conv_Default($_REQUEST['int_package_review'], 3);
        $arr_Set_Data[13]       = Fnc_Om_Conv_Default($_REQUEST['int_delivery_review'], 3);

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

        $Sql_Query = "INSERT INTO `" . $Tname . "_comm_review` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
        mysql_query($Sql_Query);
?>
        <script language="javascript">
            window.location.href = "index.php";
        </script>
    <?
        exit;
        break;

    case "UPDATE":
        $int_review = Fnc_Om_Conv_Default($_REQUEST['int_review'], "");

        if ($int_review) {
            $SQL_QUERY =    'SELECT
                                STR_IMAGE1,
                                STR_IMAGE2,
                                STR_IMAGE3
                            FROM 
                                ' . $Tname . 'comm_review
                            WHERE
                                INT_NUMBER=' . $int_review;

            $arr_img_Data = mysql_query($SQL_QUERY);

            $str_images = array();

            if (mysql_result($arr_img_Data, 0, 'STR_IMAGE1') != "") {
                $str_images[0] = mysql_result($arr_img_Data, 0, 'STR_IMAGE1');

                if (Fnc_Om_Conv_Default($_REQUEST['str_dimage1'], "") == "true") {
                    Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, 'STR_IMAGE1'));
                    $str_images[0] = "";
                }
            }

            if (mysql_result($arr_img_Data, 0, 'STR_IMAGE2') != "") {
                $str_images[1] = mysql_result($arr_img_Data, 0, 'STR_IMAGE2');

                if (Fnc_Om_Conv_Default($_REQUEST['str_dimage2'], "") == "true") {
                    Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, 'STR_IMAGE2'));
                    $str_images[1] = "";
                }
            }

            if (mysql_result($arr_img_Data, 0, 'STR_IMAGE3') != "") {
                $str_images[2] = mysql_result($arr_img_Data, 0, 'STR_IMAGE3');

                if (Fnc_Om_Conv_Default($_REQUEST['str_dimage3'], "") == "true") {
                    Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, 'STR_IMAGE3'));
                    $str_images[2] = "";
                }
            }

            for ($i = 0; $i < count($_FILES['str_image']['tmp_name']); $i++) {
                if ($str_images[0] != "" && $str_images[1] != "" && $str_images[2] != "")
                    break;

                $obj_File = $_FILES['str_image']['tmp_name'][$i];
                $obj_File_name = $_FILES['str_image']['name'][$i];
                $obj_File_size = $_FILES['str_image']['size'][$i];

                $full_name = explode(".", "$obj_File_name");

                $str_Temp = Fnc_Om_File_Save($obj_File, $obj_File_name, "", 0, 0, "", $str_Add_Tag);

                for ($j = 0; $j < 3; $j++) {
                    if (!$str_images[$j]) {
                        $str_images[$j] = $str_Temp[1][0];
                        break;
                    }
                }
            }

            $arr_Get_Data = array();
            $arr_Column_Name = array();

            $arr_Column_Name[0]     =     "STR_CONTENT";
            $arr_Column_Name[1]     =     "STR_IMAGE1";
            $arr_Column_Name[2]     =     "STR_IMAGE2";
            $arr_Column_Name[3]     =     "STR_IMAGE3";
            $arr_Column_Name[4]     =     "DTM_EDIT_DATE";
            $arr_Column_Name[5]    =     "INT_STAR";
            $arr_Column_Name[6]    =     "INT_USE_REVIEW";
            $arr_Column_Name[7]    =     "INT_PACKAGE_REVIEW";
            $arr_Column_Name[8]    =     "INT_DELIVERY_REVIEW";

            $arr_Set_Data[0]        = Fnc_Om_Conv_Default($_REQUEST['str_content'], "");
            $arr_Set_Data[1]        = $str_images[0] ?: "";
            $arr_Set_Data[2]        = $str_images[1] ?: "";
            $arr_Set_Data[3]        = $str_images[2] ?: "";
            $arr_Set_Data[4]        = date("Y-m-d H:i:s");
            $arr_Set_Data[5]       = Fnc_Om_Conv_Default($_REQUEST['int_star'], 5);
            $arr_Set_Data[6]       = Fnc_Om_Conv_Default($_REQUEST['int_use_review'], 3);
            $arr_Set_Data[7]       = Fnc_Om_Conv_Default($_REQUEST['int_package_review'], 3);
            $arr_Set_Data[8]       = Fnc_Om_Conv_Default($_REQUEST['int_delivery_review'], 3);

            $arr_Sub = "";

            for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

                if ($int_I != 0) {
                    $arr_Sub .=  ",";
                }
                $arr_Sub .=  $arr_Column_Name[$int_I] . "=" . ($arr_Set_Data[$int_I] ? "'" . $arr_Set_Data[$int_I] . "' " : 'null ');
            }

            $Sql_Query = "UPDATE `" . $Tname . "comm_review` SET ";
            $Sql_Query .= $arr_Sub;
            $Sql_Query .= " WHERE INT_NUMBER=" . $int_review;

            mysql_query($Sql_Query);
        }

    ?>
        <script language="javascript">
            window.location.href = "index.php?view_mode=review";
        </script>
    <?
        exit;
        break;

    case "DELETE":
        $int_review = Fnc_Om_Conv_Default($_REQUEST['int_review'], "");

        if ($int_review) {
            $SQL_QUERY =    'SELECT
                                STR_IMAGE1,
                                STR_IMAGE2,
                                STR_IMAGE3
                            FROM 
                                ' . $Tname . 'comm_review
                            WHERE
                                INT_NUMBER=' . $int_review;

            $arr_img_Data = mysql_query($SQL_QUERY);
            if (mysql_result($arr_img_Data, 0, 'STR_IMAGE1') != "") {

                Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, 'STR_IMAGE1'));
            }

            if (mysql_result($arr_img_Data, 0, 'STR_IMAGE2') != "") {
                Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, 'STR_IMAGE2'));
            }

            if (mysql_result($arr_img_Data, 0, 'STR_IMAGE3') != "") {
                Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, 'STR_IMAGE3'));
            }

            $SQL_QUERY = "DELETE FROM " . $Tname . "comm_review WHERE INT_NUMBER='$int_review' ";
            mysql_query($SQL_QUERY);
        }
    ?>
        <script language="javascript">
            window.location.href = "index.php";
        </script>
<?
        exit;
        break;
}
?>