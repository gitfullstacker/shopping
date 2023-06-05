<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$card_cd = $_POST['card_cd'];
$card_name = $_POST['card_name'];
$batch_key = $_POST['batch_key'];

//카드정보얻기
$SQL_QUERY =    'SELECT
                    COUNT(A.INT_NUMBER) AS NUM
                FROM 
                    ' . $Tname . 'comm_member_payment AS A
                WHERE
                    A.STR_USERID="' . $arr_Auth[0] . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$card_Data = mysql_fetch_assoc($arr_Rlt_Data);

if ($card_Data['NUM'] > 0) {
    $SQL_QUERY =    'UPDATE ' . $Tname . 'comm_member_payment SET STR_CARD_CD="' . $card_cd . '", SET STR_CARD_NAME="' . $card_name . '", SET STR_BATCH_KEY="' . $batch_key . '" WHERE STR_USERID="' . $arr_Auth[0] . '"';
} else {
    $SQL_QUERY =    'INSERT INTO ' . $Tname . 'comm_member_payment (STR_CARD_CD, STR_CARD_NAME, STR_BATCH_KEY, STR_USERID, DTM_INDATE) VALUES ("' . $card_cd . '", "' . $card_name . '", "' . $batch_key . '", "' . $arr_Auth[0] . '", "' . date("Y-m-d H:i:s") . '")';
}

mysql_query($SQL_QUERY);

?>
<script language="javascript">
    window.location.href = "index.php";
</script>
<?
exit;
