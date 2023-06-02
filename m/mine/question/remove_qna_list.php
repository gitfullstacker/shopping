<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?php
$int_number = $_GET['int_number'];
$SQL_QUERY =    'DELETE FROM 
                    ' . $Tname . 'comm_member_qna A 
                WHERE A.INT_IDX=' . $int_number;
mysql_query($SQL_QUERY);
?>

<script language="javascript">
    window.location.href = "index.php";
</script>

<?php
exit;
