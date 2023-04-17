<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");

	$Txt_gbn = Fnc_Om_Conv_Default($_REQUEST[Txt_gbn],"1");
	$str_gubun = Fnc_Om_Conv_Default($_REQUEST[str_gubun],"1");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_store = Fnc_Om_Conv_Default($_REQUEST[int_store],"0");
	$str_pass = Fnc_Om_Conv_Default($_REQUEST[str_pass],"0");
	$str_memo = Fnc_Om_Conv_Default($_REQUEST[str_memo],"");
	$str_doc = Fnc_Om_Conv_Default($_REQUEST[str_doc],"");
	$str_sdate = Fnc_Om_Conv_Default($_REQUEST[str_sdate],"");
	$str_edate = Fnc_Om_Conv_Default($_REQUEST[str_edate],"");
	$int_price = Fnc_Om_Conv_Default($_REQUEST[int_price],"0");
	$int_rate = Fnc_Om_Conv_Default($_REQUEST[int_rate],"0");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_requ SET ";
								$SQL_QUERY .= "INT_STORE='$int_store',STR_PASS='$str_pass',STR_MEMO='".addslashes($str_memo)."'
								,STR_DOC='$str_doc'
								,STR_SDATE='$str_sdate'
								,STR_EDATE='$str_edate'
								,INT_PRICE='$int_price'
								,INT_RATE='$int_rate'
								WHERE
									INT_NUMBER='$str_no' ";

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
				window.location.href="requ_requ2_list.php?Txt_gbn=<?=$Txt_gbn?>";
			</script>
			<?
			exit;
			break;

		case "CAL" :

			
			if ($str_sdate <= date("Y-m-d")) {
				$sdate = $str_sdate;
//				if (date("Y-m-d") > $str_edate) {
					$edate = $str_edate;
//				}else{
//					$edate = date("Y-m-d");
//				}
				if ($edate!="") {?>[기준 : <?=$edate?>]<?}?> <?$sDay=((strtotime($edate) - strtotime($sdate))/86400)+1?> <?=number_format($int_price * (($int_rate/100) * $sDay /365),0)?>원
			<?}else{?>
				-
			<?}
	}

?>
