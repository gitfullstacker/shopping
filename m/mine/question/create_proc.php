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

$Sql_Query = "INSERT INTO `" . $Tname . "comm_member_qna` (STR_MUSERID, INT_IDX, INT_ORDER, INT_LEVEL, STR_USERID, STR_NAME, STR_CONT, STR_IMAGE1, DTM_INDATE, STR_TITLE, INT_TYPE, STR_CART) VALUES ('" . $arr_Auth[0] . "', LAST_INSERT_ID(), NULL, 0, '" . $arr_Auth[0] . "', '', '" . $_POST['str_cont'] . "', '" . $str_Temp[1][0] . "', '" . date("Y-m-d H:i:s") . "', '" . $_POST['str_title'] . "', " . $_POST['int_type'] . ", " . ($_POST['int_cart'] ? "'" . $_POST['int_cart'] . "'" : "NULL") . ") ";
mysql_query($Sql_Query);

?>

<script language="javascript">
    window.location.href = "index.php";
</script>

<?
exit;
?>