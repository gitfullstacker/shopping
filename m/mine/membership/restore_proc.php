<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$int_number = $_GET['int_number'];

$SQL_QUERY =    'UPDATE 
                    ' . $Tname . 'comm_membership 
                SET 
                    INT_STATE=0 
                WHERE 
                    INT_NUMBER=' . $int_number . '
                    AND STR_USERID="' . $arr_Auth[0] . '"';

mysql_query($SQL_QUERY);

echo 'successful';

exit;
