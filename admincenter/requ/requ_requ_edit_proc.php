<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");

	$str_gubun = Fnc_Om_Conv_Default($_REQUEST[str_gubun],"1");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_store = Fnc_Om_Conv_Default($_REQUEST[int_store],"0");
	$str_pass = Fnc_Om_Conv_Default($_REQUEST[str_pass],"0");
	$int_price = Fnc_Om_Conv_Default($_REQUEST[int_price],"0");
	$str_memo = Fnc_Om_Conv_Default($_REQUEST[str_memo],"");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_requ SET ";
								$SQL_QUERY .= "INT_STORE='$int_store',STR_PASS='$str_pass',INT_PRICE='$int_price',STR_MEMO='".addslashes($str_memo)."' ";
			if ($str_pass=="2") {
				$sDate=date("Y-m-d");
				$eDate=date("Y-m-d", strtotime(date("Y-m-d", strtotime($month."1month"))."-1 days"));
				$SQL_QUERY .= ",STR_SDATE='$sDate',STR_EDATE='$eDate',INT_RATE='2.325',DTM_MDATE='".date("Y-m-d H:i:s")."' ";
			}
			$SQL_QUERY .= " WHERE INT_NUMBER='$str_no' ";

			$result=mysql_query($SQL_QUERY);
			?>
			<script language="javascript">
				alert("처리되었습니다.");
				parent.document.frm.submit();
			</script>
			<?
			exit;
			break;
			

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_requ_sub WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_requ WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="requ_requ_list.php?str_gubun=<?=$str_gubun?>";
			</script>
			<?
			exit;
			break;

	}

?>
