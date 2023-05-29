<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], 1);
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], '');
$pay_price = Fnc_Om_Conv_Default($_REQUEST['pay_price'], 0);
?>

<script language="javascript">
    window.location.href = "result.php?int_type=<?= $int_type ?>&str_goodcode=<?= $str_goodcode ?>";
</script>

<?php
exit;
?>