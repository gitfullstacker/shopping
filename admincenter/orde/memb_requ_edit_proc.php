<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_state = Fnc_Om_Conv_Default($_REQUEST[int_state],"");
	$str_rdate = Fnc_Om_Conv_Default($_REQUEST[str_rdate],"");
	
	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_member_requ_sub WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_member_requ WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);
				
			}
			?>
			<script language="javascript">
				window.location.href="memb_requ_list.php";
			</script>
			<?
			exit;
			break;

	}

?>
