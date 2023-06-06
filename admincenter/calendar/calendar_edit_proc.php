<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "INSERT");

$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$str_title = Fnc_Om_Conv_Default($_REQUEST['str_title'], "");
$int_period = Fnc_Om_Conv_Default($_REQUEST['int_period'], "");
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], "");
$str_day = Fnc_Om_Conv_Default($_REQUEST['str_day'], "");
$str_date = Fnc_Om_Conv_Default($_REQUEST['str_date'], "");
$str_week = Fnc_Om_Conv_Default($_REQUEST['str_week'], "");
$int_dtype = Fnc_Om_Conv_Default($_REQUEST['int_dtype'], "");
$str_service = Fnc_Om_Conv_Default($_REQUEST['str_service'], "N");

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST['chkItem1'], "");

$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'] . "/admincenter/files/calendar/";

if (!is_dir($str_Add_Tag)) {
	mkdir($str_Add_Tag, 0777);
}

switch ($RetrieveFlag) {
	case "INSERT":

		$SQL_QUERY = 	"INSERT INTO " . $Tname . "comm_cal
							(STR_TITLE, INT_PERIOD, INT_TYPE, STR_DAY, STR_DATE, STR_WEEK, INT_DTYPE, DTM_INDATE, STR_SERVICE) 
						VALUES 
							('$str_title', '$int_period', '$int_type', '$str_day', '$str_date', '$str_week', '$int_dtype', '" . date("Y-m-d H:i:s") . "','$str_service')";

		mysql_query($SQL_QUERY);

		// Get the last inserted ID
		$lastnumber = mysql_insert_id();
		?>
		<script language="javascript">
			window.location.href = "calendar_edit.php?RetrieveFlag=UPDATE&str_no=<?= $lastnumber ?>";
		</script>
		<?
		exit;
		break;

	case "UPDATE":

		$SQL_QUERY = " UPDATE " . $Tname . "comm_cal SET ";
		$SQL_QUERY .= 	"STR_TITLE='$str_title'
						,INT_PERIOD='$int_period'
						,INT_TYPE='$int_type'
						,STR_DAY='$str_day'
						,STR_DATE='$str_date'
						,STR_WEEK='$str_week'
						,INT_DTYPE='$int_dtype'
						,STR_SERVICE='$str_service'
					WHERE
						INT_NUMBER='$str_no' ";

		mysql_query($SQL_QUERY);
		?>
		<script language="javascript">
			window.location.href = "calendar_edit.php?RetrieveFlag=UPDATE&str_no=<?= $str_no ?>";
		</script>
	<?
		exit;
		break;

	case "ADELETE":

		for ($i = 0; $i < count($chkItem1); $i++) {
			$SQL_QUERY =	"DELETE FROM " . $Tname . "comm_cal WHERE INT_NUMBER='$chkItem1[$i]' ";
			mysql_query($SQL_QUERY);
		}
	?>
		<script language="javascript">
			window.location.href = "cal_list.php";
		</script>
<?
		exit;
		break;
}

?>