<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>

<?php
$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'] . "/admincenter/files/qna/";

if (!is_dir($str_Add_Tag)) {
    mkdir($str_Add_Tag, 0777);
}

// 이미지 등록
$obj_File = $_FILES['str_image']['tmp_name'];
$obj_File_name = $_FILES['str_image']['name'];
$obj_File_size = $_FILES['str_image']['size'];

$full_name = explode(".", "$obj_File_name");

$str_Temp = Fnc_Om_File_Save($obj_File, $obj_File_name, "", 0, 0, "", $str_Add_Tag);

$SQL_QUERY = "SELECT IFNULL(max(INT_NUMBER),0)+1 AS lastnumber FROM " . $Tname . "comm_member_qna ";
$arr_max_Data = mysql_query($SQL_QUERY);
$lastnumber = mysql_result($arr_max_Data, 0, lastnumber);

$arr_Set_Data = array();
$arr_Column_Name = array();

$arr_Column_Name[0] = "STR_MUSERID";
$arr_Column_Name[1] = "INT_IDX";
$arr_Column_Name[2] = "INT_ORDER";
$arr_Column_Name[3] = "INT_LEVEL";
$arr_Column_Name[4] = "STR_USERID";
$arr_Column_Name[5] = "STR_NAME";
$arr_Column_Name[6] = "STR_CONT";
$arr_Column_Name[7] = "STR_IMAGE1";
$arr_Column_Name[8] = "DTM_INDATE";
$arr_Column_Name[9] = "STR_TITLE";
$arr_Column_Name[10] = "INT_TYPE";
$arr_Column_Name[11] = "INT_CART";

$arr_Set_Data[0] = $arr_Auth[0];
$arr_Set_Data[1] = $lastnumber;
$arr_Set_Data[2] = $lastnumber * 100;
$arr_Set_Data[3] = '0';
$arr_Set_Data[4] = $arr_Auth[0];
$arr_Set_Data[5] = $arr_Auth[2];
$arr_Set_Data[6] = $_POST['str_cont'];
$arr_Set_Data[7] = $str_Temp[1][0];
$arr_Set_Data[8] = date("Y-m-d H:i:s");
$arr_Set_Data[9] = $_POST['str_title'];
$arr_Set_Data[10] = $_POST['int_type'];
$arr_Set_Data[11] = $_POST['int_cart'];

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

$Sql_Query = "INSERT INTO `" . $Tname . "comm_member_qna` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
mysql_query($Sql_Query);
?>

<script language="javascript">
    window.location.href = "index.php";
</script>

<?
exit;
?>