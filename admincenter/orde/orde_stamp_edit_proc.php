<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_pass = Fnc_Om_Conv_Default($_REQUEST[str_pass],"");
	
	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_stamp_order WHERE INT_NUMBER='$chkItem1[$i]' ";
				mysql_query($SQL_QUERY);
				
			}
			?>
			<script language="javascript">
				window.location.href="orde_stamp_list.php";
			</script>
			<?
			exit;
			break;
		
		case "PASS" :

			$SQL_QUERY =	"UPDATE ".$Tname."comm_stamp_order SET STR_PASS='$str_pass' WHERE INT_NUMBER='$str_no' ";
			mysql_query($SQL_QUERY);
				

	}

?>
