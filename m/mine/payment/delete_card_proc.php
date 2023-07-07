<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>

<?php
// $SQL_QUERY =    'UPDATE ' . $Tname . 'comm_member_pay SET STR_PASS="1" WHERE STR_USERID="' . $arr_Auth[0] . '"';
// mysql_query($Sql_Query);
?>
<script language="javascript">
    window.location.href = "index.php";
</script>