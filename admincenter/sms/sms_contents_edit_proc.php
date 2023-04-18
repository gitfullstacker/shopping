<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_shp = Fnc_Om_Conv_Default($_REQUEST[str_shp1],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_shp2],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_shp3],"");
	$str_contents = Fnc_Om_Conv_Default($_REQUEST[str_contents],"");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_sms_master a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_sms_master (";
					$SQL_QUERY .= " INT_NUMBER,STR_SHP,STR_CONTENTS,DTM_INDATE
											) VALUES (
												'$lastnumber','$str_shp','$str_contents','".date("Y-m-d H:i:s")."'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="sms_contents_edit.php?RetrieveFlag=UPDATE&str_no=<?=$lastnumber?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_sms_master SET ";
								$SQL_QUERY .= "STR_SHP='$str_shp'
									,STR_CONTENTS='$str_contents'
								WHERE
									INT_NUMBER='$str_no' ";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="sms_contents_edit.php?RetrieveFlag=UPDATE&str_no=<?=$str_no?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_sms_master WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="sms_contents_list.php";
			</script>
			<?
			exit;
			break;

	}

?>
