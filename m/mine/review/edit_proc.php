<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>

<?php
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "INSERT");

$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'] . "/admincenter/files/boad/2/";

if (!is_dir($str_Add_Tag)) {
    mkdir($str_Add_Tag, 0777);
}

switch ($RetrieveFlag) {
    case "INSERT":
        // ID 얻기
        $Sql_Query = "SELECT IFNULL(MAX(BD_SEQ), 0)+1 AS SEQ FROM `" . $Tname . "b_bd_data@01`";
        $result = mysql_query($Sql_Query);
        if (!result) {
            error("QUERY_ERROR");
            exit;
        }
        $new_id = mysql_result($result, 0, 0);

        // BD_ID_KEY 생성
        $bd_id_key = Fnc_Om_Id_Key_Create();

        $arr_Get_Data = array();
        $arr_Column_Name = array();

        $arr_Column_Name[0]     =     "BD_SEQ";
        $arr_Column_Name[1]     =     "CONF_SEQ";
        $arr_Column_Name[2]     =     "BD_ID_KEY";
        $arr_Column_Name[3]     =     "BD_IDX";
        $arr_Column_Name[4]     =     "BD_ORDER";
        $arr_Column_Name[5]     =     "MEM_ID";
        $arr_Column_Name[6]     =     "BD_CONT";
        $arr_Column_Name[7]     =     "BD_REG_DATE";
        $arr_Column_Name[8]     =     "BD_EDIT_DATE";
        $arr_Column_Name[9]     =     "INT_USTAR";
        $arr_Column_Name[10]    =     "INT_PSTAR";
        $arr_Column_Name[11]    =     "INT_DSTAR";
        $arr_Column_Name[12]    =     "BD_ITEM1";
        $arr_Column_Name[13]    =     "BD_ITEM2";
        $arr_Column_Name[14]    =     "INT_CART";

        $arr_Set_Data[0]        = $new_id;
        $arr_Set_Data[1]        = 2;
        $arr_Set_Data[2]        = $bd_id_key;
        $arr_Set_Data[3]        = $new_id;
        $arr_Set_Data[4]        = $new_id * 100;
        $arr_Set_Data[5]        = $arr_Auth[0];
        $arr_Set_Data[6]        = Fnc_Om_Conv_Default($_REQUEST['str_content'], "");
        $arr_Set_Data[7]        = date("Y-m-d H:i:s");
        $arr_Set_Data[8]        = date("Y-m-d H:i:s");
        $arr_Set_Data[9]        = Fnc_Om_Conv_Default($_REQUEST['int_ustar'], 3);
        $arr_Set_Data[10]       = Fnc_Om_Conv_Default($_REQUEST['int_pstar'], 3);
        $arr_Set_Data[11]       = Fnc_Om_Conv_Default($_REQUEST['int_dstar'], 3);
        $arr_Set_Data[12]       = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], "");
        $arr_Set_Data[13]       = Fnc_Om_Conv_Default($_REQUEST['int_star'], "5");
        $arr_Set_Data[14]       = Fnc_Om_Conv_Default($_REQUEST['int_cart'], "");

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

        $Sql_Query = "INSERT INTO `" . $Tname . "b_bd_data@01` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
        mysql_query($Sql_Query);

        // 이미지 등록
        $str_images = array();
        $img_align = 1;

        for ($i = 0; $i < count($_FILES['str_image']['tmp_name']); $i++) {
            $obj_File = $_FILES['str_image']['tmp_name'][$i];
            $obj_File_name = $_FILES['str_image']['name'][$i];
            $obj_File_size = $_FILES['str_image']['size'][$i];

            $full_name = explode(".", "$obj_File_name");

            $str_Temp = Fnc_Om_File_Save($obj_File, $obj_File_name, "", 0, 0, "", $str_Add_Tag);
            $str_images[$i] = $str_Temp[1][0];

            if ($str_images[$i]) {
                // ID 얻기
                $Sql_Query = "SELECT IFNULL(MAX(IMG_SEQ), 0)+1 AS SEQ FROM `" . $Tname . "b_img_data@01`";
                $result = mysql_query($Sql_Query);
                if (!result) {
                    error("QUERY_ERROR");
                    exit;
                }
                $new_img_id = mysql_result($result, 0, 0);

                $arr_Get_Data = array();
                $arr_Column_Name = array();

                $arr_Column_Name[0]     =     "IMG_SEQ";
                $arr_Column_Name[1]     =     "BD_SEQ";
                $arr_Column_Name[2]     =     "CONF_SEQ";
                $arr_Column_Name[3]     =     "IMG_ID_KEY";
                $arr_Column_Name[4]     =     "IMG_ALIGN";
                $arr_Column_Name[5]     =     "IMG_F_NAME";
                $arr_Column_Name[6]     =     "IMG_F_NICK";
                $arr_Column_Name[7]     =     "IMG_REG_DATE";

                $arr_Set_Data[0]        = $new_img_id;
                $arr_Set_Data[1]        = $new_id;
                $arr_Set_Data[2]        = 2;
                $arr_Set_Data[3]        = $bd_id_key;
                $arr_Set_Data[4]        = $img_align;
                $arr_Set_Data[5]        = $str_images[$i];
                $arr_Set_Data[6]        = $str_images[$i];
                $arr_Set_Data[7]        = date("Y-m-d H:i:s");

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

                $Sql_Query = "INSERT INTO `" . $Tname . "b_img_data@01` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
                mysql_query($Sql_Query);

                $img_align++;
            }
        }

        // 마일리지 지급
        $SQL_QUERY =    'SELECT
                            A.INT_MILEAGE, A.STR_PMILEAGE, A.INT_PRICE
                        FROM 
                            ' . $Tname . 'comm_goods_master AS A
                        WHERE
                            A.STR_GOODCODE="' . $_REQUEST['str_goodcode'] . '"';

        $arr_Rlt_Data = mysql_query($SQL_QUERY);

        if (!$arr_Rlt_Data) {
            echo 'Could not run query: ' . mysql_error();
            exit;
        }
        $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

        $mileage = 0;

        if ($arr_Data['STR_PMILEAGE'] == 'Y') {
            $mileage = $arr_Data['INT_PRICE'] * $arr_Data['INT_MILEAGE'] / 100;
        } else {
            $mileage = $arr_Data['INT_MILEAGE'];
        }

        $SQL_QUERY =    "UPDATE `" . $Tname . "comm_member` SET INT_MILEAGE = INT_MILEAGE+" . $mileage . " WHERE STR_USERID='" . $arr_Auth[0] . "'";
        $arr_Rlt_Data = mysql_query($SQL_QUERY);

        $arr_Get_Data = array();
        $arr_Column_Name = array();

        $arr_Column_Name[0]     =     "STR_USERID";
        $arr_Column_Name[1]     =     "STR_INCOME";
        $arr_Column_Name[2]     =     "DTM_INDATE";
        $arr_Column_Name[3]     =     "STR_ORDERIDX";
        $arr_Column_Name[4]     =     "INT_VALUE";
        $arr_Column_Name[5]     =     "INT_CART";

        $arr_Set_Data[0]        = $arr_Auth[0];
        $arr_Set_Data[1]        = "Y";
        $arr_Set_Data[2]        = date("Y-m-d H:i:s");
        $arr_Set_Data[3]        = "";
        $arr_Set_Data[4]        = $mileage;
        $arr_Set_Data[5]        = $_REQUEST['int_cart'];

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
?>
        <script language="javascript">
            window.location.href = "index.php";
        </script>
    <?
        exit;
        break;

    case "UPDATE":
        $bd_seq = Fnc_Om_Conv_Default($_REQUEST['bd_seq'], "");

        if ($bd_seq) {
            $arr_Get_Data = array();
            $arr_Column_Name = array();

            $arr_Column_Name[0]     =     "BD_CONT";
            $arr_Column_Name[1]     =     "BD_EDIT_DATE";
            $arr_Column_Name[2]     =     "INT_USTAR";
            $arr_Column_Name[3]    =     "INT_PSTAR";
            $arr_Column_Name[4]    =     "INT_DSTAR";
            $arr_Column_Name[5]    =     "BD_ITEM2";

            $arr_Set_Data[0]        = Fnc_Om_Conv_Default($_REQUEST['str_content'], "");
            $arr_Set_Data[1]        = date("Y-m-d H:i:s");
            $arr_Set_Data[2]        = Fnc_Om_Conv_Default($_REQUEST['int_ustar'], 3);
            $arr_Set_Data[3]       = Fnc_Om_Conv_Default($_REQUEST['int_pstar'], 3);
            $arr_Set_Data[4]       = Fnc_Om_Conv_Default($_REQUEST['int_dstar'], 3);
            $arr_Set_Data[5]       = Fnc_Om_Conv_Default($_REQUEST['int_star'], "5");

            $arr_Sub = "";

            for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

                if ($int_I != 0) {
                    $arr_Sub .=  ",";
                }
                $arr_Sub .=  $arr_Column_Name[$int_I] . "=" . ($arr_Set_Data[$int_I] ? "'" . $arr_Set_Data[$int_I] . "' " : 'null ');
            }

            $Sql_Query = "UPDATE `" . $Tname . "b_bd_data@01` SET ";
            $Sql_Query .= $arr_Sub;
            $Sql_Query .= " WHERE BD_SEQ=" . $bd_seq;

            mysql_query($Sql_Query);

            // 이미지 업뎃
            $SQL_QUERY =    'SELECT
                                A.*
                            FROM 
                                `' . $Tname . 'b_img_data@01` AS A
                            WHERE
                                A.BD_SEQ=' . $bd_seq;

            $img_list_result = mysql_query($SQL_QUERY);

            // Delete images
            while ($row = mysql_fetch_assoc($img_list_result)) {
                $str_images[$index] = $row['IMG_F_NAME'];

                if (Fnc_Om_Conv_Default($_REQUEST['str_dimage' . $row['IMG_ALIGN']], "") == "true") {
                    Fnc_Om_File_Delete($str_Add_Tag, $row['IMG_F_NAME']);

                    $SQL_QUERY =    'DELETE FROM `' . $Tname . 'b_img_data@01` WHERE IMG_SEQ=' . $row['IMG_SEQ'];
                    mysql_query($SQL_QUERY);
                }

                $index++;
            }

            $index = 0;
            for ($i = 0; $i < count($_FILES['str_image']['tmp_name']); $i++) {
                for ($j = $index; $j < 3; $j++) {
                    $SQL_QUERY =    'SELECT
                                        COUNT(A.IMG_SEQ) AS NUM
                                    FROM 
                                        `' . $Tname . 'b_img_data@01` AS A
                                    WHERE
                                        A.BD_SEQ=' . $bd_seq . '
                                        AND A.IMG_ALIGN=' . ($j + 1);

                    $arr_Rlt_Data = mysql_query($SQL_QUERY);
                    $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

                    if ($arr_Data['NUM'] == 0) {
                        $obj_File = $_FILES['str_image']['tmp_name'][$i];
                        $obj_File_name = $_FILES['str_image']['name'][$i];
                        $obj_File_size = $_FILES['str_image']['size'][$i];

                        $full_name = explode(".", "$obj_File_name");

                        $str_Temp = Fnc_Om_File_Save($obj_File, $obj_File_name, "", 0, 0, "", $str_Add_Tag);

                        // ID 얻기
                        $Sql_Query = "SELECT IFNULL(MAX(IMG_SEQ), 0)+1 AS SEQ FROM `" . $Tname . "b_img_data@01`";
                        $result = mysql_query($Sql_Query);
                        if (!result) {
                            error("QUERY_ERROR");
                            exit;
                        }
                        $new_img_id = mysql_result($result, 0, 0);

                        // BD_ID_KEY 생성
                        $bd_id_key = Fnc_Om_Id_Key_Create();

                        $arr_Get_Data = array();
                        $arr_Column_Name = array();

                        $arr_Column_Name[0]     =     "IMG_SEQ";
                        $arr_Column_Name[1]     =     "BD_SEQ";
                        $arr_Column_Name[2]     =     "CONF_SEQ";
                        $arr_Column_Name[3]     =     "IMG_ID_KEY";
                        $arr_Column_Name[4]     =     "IMG_ALIGN";
                        $arr_Column_Name[5]     =     "IMG_F_NAME";
                        $arr_Column_Name[6]     =     "IMG_F_NICK";
                        $arr_Column_Name[7]     =     "IMG_REG_DATE";

                        $arr_Set_Data[0]        = $new_img_id;
                        $arr_Set_Data[1]        = $bd_seq;
                        $arr_Set_Data[2]        = 2;
                        $arr_Set_Data[3]        = $bd_id_key;
                        $arr_Set_Data[4]        = ($j + 1);
                        $arr_Set_Data[5]        = $str_Temp[1][0];
                        $arr_Set_Data[6]        = $str_Temp[1][0];
                        $arr_Set_Data[7]        = date("Y-m-d H:i:s");

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

                        $Sql_Query = "INSERT INTO `" . $Tname . "b_img_data@01` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
                        mysql_query($Sql_Query);
                    } else {
                        $index++;
                    }
                }
            }
        }

    ?>
        <script language="javascript">
            window.location.href = "index.php?view_mode=review";
        </script>
    <?
        exit;
        break;

    case "DELETE":
        $bd_seq = Fnc_Om_Conv_Default($_REQUEST['bd_seq'], "");

        if ($bd_seq) {
            // 이미지 지우기
            $SQL_QUERY =    'DELETE FROM `' . $Tname . 'b_img_data@01` WHERE BD_SEQ=' . $bd_seq;
            mysql_query($SQL_QUERY);

            // 리뷰 지우기
            $SQL_QUERY =    'DELETE FROM `' . $Tname . 'b_bd_data@01` WHERE BD_SEQ=' . $bd_seq;
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