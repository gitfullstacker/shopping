<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>

<?php
$SQL_QUERY = 'DELETE FROM ' . $Tname . 'comm_member_seen WHERE STR_USERID="' . $arr_Auth[0] . '"';

mysql_query($SQL_QUERY);

exit;