<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"1");
	$str_code = Fnc_Om_Conv_Default($_REQUEST[str_code],"");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"N");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_code a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_code (";
					$SQL_QUERY .= " INT_NUMBER,INT_GUBUN,STR_CODE,DTM_INDATE,STR_SERVICE
											) VALUES (
												'$lastnumber','$int_gubun','$str_code','".date("Y-m-d H:i:s")."','$str_service'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="memb_cen_edit.php?RetrieveFlag=UPDATE&int_gubun=<?=$int_gubun?>&str_no=<?=$lastnumber?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_code SET ";
								$SQL_QUERY .= "INT_GUBUN='$int_gubun'
									,STR_CODE='$str_code'
									,STR_SERVICE='$str_service'
								WHERE
									INT_NUMBER='$str_no' ";

			$result=mysql_query($SQL_QUERY);
			?>
			<script language="javascript">
				window.location.href="memb_cen_edit.php?RetrieveFlag=UPDATE&int_gubun=<?=$int_gubun?>&str_no=<?=$str_no?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_code WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="memb_cen_list.php?int_gubun=<?=$int_gubun?>";
			</script>
			<?
			exit;
			break;

	}

?>
