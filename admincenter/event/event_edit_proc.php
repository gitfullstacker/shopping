<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "INSERT");

$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$str_title = Fnc_Om_Conv_Default($_REQUEST['str_title'], "");
$str_cont = Fnc_Om_Conv_Default($_REQUEST['str_cont'], "");
$str_service = Fnc_Om_Conv_Default($_REQUEST['str_service'], "N");

$str_dimage = Fnc_Om_Conv_Default($_REQUEST['str_dimage'], "");
$str_Image = $_FILES['str_Image']['tmp_name'];
$str_Image_name = $_FILES['str_Image']['name'];

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST['chkItem1'], "");

$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'] . "/admincenter/files/event/";

if (!is_dir($str_Add_Tag)) {
	mkdir($str_Add_Tag, 0777);
}

switch ($RetrieveFlag) {
	case "INSERT":

		$str_Temp = Fnc_Om_File_Save($str_Image, getRandomFileName($str_Image_name), $str_dimage, '', '', $str_del_img, $str_Add_Tag);
		if ($str_Temp[0] == "0") {
?>
			<script language="javascript">
				alert("업로드에 실패하셨습니다.");
				history.back();
			</script>
		<?
			exit;
		}
		$arr_Temp = $str_Temp[1];
		$str_dimage = $arr_Temp[0];

		$SQL_QUERY = 	"INSERT INTO " . $Tname . "comm_event 
							(STR_TITLE, STR_CONT, STR_IMAGE, DTM_INDATE, STR_SERVICE, STR_GOODCODES) 
						VALUES 
							('$str_title', '$str_cont', '$str_dimage', '" . date("Y-m-d H:i:s") . "','$str_service', '')";

		mysql_query($SQL_QUERY);

		// Get the last inserted ID
		$lastnumber = mysql_insert_id();
		?>
		<script language="javascript">
			window.location.href = "event_edit.php?RetrieveFlag=UPDATE&str_no=<?= $lastnumber ?>";
		</script>
		<?
		exit;
		break;

	case "UPDATE":

		$str_Temp = Fnc_Om_File_Save($str_Image, getRandomFileName($str_Image_name), $str_dimage, '', '', $str_del_img, $str_Add_Tag);
		if ($str_Temp[0] == "0") {
		?>
			<script language="javascript">
				alert("업로드에 실패하셨습니다.");
				history.back();
			</script>
		<?
			exit;
		}
		$arr_Temp = $str_Temp[1];
		$str_dimage = $arr_Temp[0];

		$SQL_QUERY = " UPDATE " . $Tname . "comm_event SET ";
		$SQL_QUERY .= 	"STR_TITLE='$str_title'
						,STR_CONT='$str_cont'
						,STR_IMAGE='$str_dimage'
						,STR_SERVICE='$str_service'
						,STR_GOODCODES=''
					WHERE
						INT_NUMBER='$str_no' ";

		mysql_query($SQL_QUERY);
		?>
		<script language="javascript">
			window.location.href = "event_edit.php?RetrieveFlag=UPDATE&str_no=<?= $str_no ?>";
		</script>
	<?
		exit;
		break;

	case "ADELETE":

		for ($i = 0; $i < count($chkItem1); $i++) {

			$SQL_QUERY =	" SELECT
								STR_IMAGE
							FROM "
				. $Tname . "comm_event
							WHERE
								INT_NUMBER='$chkItem1[$i]' ";

			$arr_img_Data = mysql_query($SQL_QUERY);
			$rcd_cnt = mysql_num_rows($arr_img_Data);

			if ($rcd_cnt) {
				if (mysql_result($arr_img_Data, 0, STR_IMAGE) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE));
				}
			}

			$SQL_QUERY =	"DELETE FROM " . $Tname . "comm_event WHERE INT_NUMBER='$chkItem1[$i]' ";
			mysql_query($SQL_QUERY);
		}
	?>
		<script language="javascript">
			window.location.href = "event_list.php";
		</script>
<?
		exit;
		break;
}

?>