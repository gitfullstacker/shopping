<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$int_gubun = Fnc_Om_Conv_Default($_REQUEST['int_gubun'], "1");
$sub_goods_array = Fnc_Om_Conv_Default($_REQUEST['sub_goods'], array());
$ren_goods_array = Fnc_Om_Conv_Default($_REQUEST['ren_goods'], array());
$vin_goods_array = Fnc_Om_Conv_Default($_REQUEST['vin_goods'], array());

$str_sub_good1 = $sub_goods_array[0];
$str_sub_good2 = $sub_goods_array[1];
$str_sub_good3 = $sub_goods_array[2];

$str_ren_good1 = $ren_goods_array[0];
$str_ren_good2 = $ren_goods_array[1];
$str_ren_good3 = $ren_goods_array[2];

$str_vin_good1 = $vin_goods_array[0];
$str_vin_good2 = $vin_goods_array[1];
$str_vin_good3 = $vin_goods_array[2];

$SQL_QUERY = " UPDATE " . $Tname . "comm_com_code SET ";
$SQL_QUERY .= "STR_SUB_GOOD1='$str_sub_good1'
					,STR_SUB_GOOD2='$str_sub_good2'
					,STR_SUB_GOOD3='$str_sub_good3'
					,STR_REN_GOOD1='$str_ren_good1'
					,STR_REN_GOOD2='$str_ren_good2'
					,STR_REN_GOOD3='$str_ren_good3'
					,STR_VIN_GOOD1='$str_vin_good1'
					,STR_VIN_GOOD2='$str_vin_good2'
					,STR_VIN_GOOD3='$str_vin_good3'
				WHERE
					INT_NUMBER='$str_no' ";

mysql_query($SQL_QUERY);

?>

<script language="javascript">
	window.location.href = "com_com_list.php?int_gubun=<?= $int_gubun ?>";
</script>