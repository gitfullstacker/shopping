<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/Snoopy.class.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_sdate = Fnc_Om_Conv_Default($_REQUEST[str_sdate],"");
	$str_edate = Fnc_Om_Conv_Default($_REQUEST[str_edate],"");
	
	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_member_pay_info SET ";
								$SQL_QUERY .= "STR_SDATE='$str_sdate',STR_EDATE='$str_edate' ";
			$SQL_QUERY .= " WHERE INT_SNUMBER='$str_no' ";

			mysql_query($SQL_QUERY);
			?>
			<script language="javascript">
				alert("처리되었습니다.");
				parent.document.frm.submit();
			</script>
			<?
			exit;
			break;

	}

?>
