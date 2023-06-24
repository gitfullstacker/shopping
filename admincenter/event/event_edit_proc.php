<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "INSERT");

$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], "");
$str_title = Fnc_Om_Conv_Default($_REQUEST['str_title'], "");
$str_stitle = Fnc_Om_Conv_Default($_REQUEST['str_stitle'], "");
$str_cont = Fnc_Om_Conv_Default($_REQUEST['str_cont'], "");
$str_bigo = Fnc_Om_Conv_Default($_REQUEST['str_bigo'], "");
$str_service = Fnc_Om_Conv_Default($_REQUEST['str_service'], "N");
$str_auto_good = Fnc_Om_Conv_Default($_REQUEST[str_auto_good], "N");

$str_del_img1 = Fnc_Om_Conv_Default($_REQUEST[str_del_img1], "N");
$str_del_img2 = Fnc_Om_Conv_Default($_REQUEST[str_del_img2], "N");

$str_dimage1 = Fnc_Om_Conv_Default($_REQUEST['str_dimage1'], "");
$str_Image1 = $_FILES['str_Image1']['tmp_name'];
$str_Image_name1 = $_FILES['str_Image1']['name'];
$str_dimage2 = Fnc_Om_Conv_Default($_REQUEST['str_dimage2'], "");
$str_Image2 = $_FILES['str_Image2']['tmp_name'];
$str_Image_name2 = $_FILES['str_Image2']['name'];

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST['chkItem1'], "");

$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'] . "/admincenter/files/event/";

if (!is_dir($str_Add_Tag)) {
	mkdir($str_Add_Tag, 0777);
}

switch ($RetrieveFlag) {
	case "INSERT":

		$str_Temp = Fnc_Om_File_Save($str_Image1, $str_Image_name1, $str_dimage1, '', '', $str_del_img1, $str_Add_Tag);
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
		$str_dimage1 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image2, $str_Image_name2, $str_dimage2, '', '', $str_del_img2, $str_Add_Tag);
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
		$str_dimage2 = $arr_Temp[0];

		$SQL_QUERY = 	"INSERT INTO " . $Tname . "comm_event 
							(STR_TITLE, STR_STITLE, STR_CONT, STR_BIGO, STR_IMAGE1, STR_IMAGE2, DTM_INDATE, STR_SERVICE, INT_TYPE) 
						VALUES 
							('$str_title', '$str_stitle', '$str_cont', '$str_bigo', '$str_dimage1', '$str_dimage2', '" . date("Y-m-d H:i:s") . "','$str_service', '$int_type')";

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

		$str_Temp = Fnc_Om_File_Save($str_Image1, $str_Image_name1, $str_dimage1, '', '', $str_del_img1, $str_Add_Tag);
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
		$str_dimage1 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image2, $str_Image_name2, $str_dimage2, '', '', $str_del_img2, $str_Add_Tag);
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
		$str_dimage2 = $arr_Temp[0];

		$SQL_QUERY = " UPDATE " . $Tname . "comm_event SET ";
		$SQL_QUERY .= 	"STR_TITLE='$str_title'
						,STR_STITLE='$str_stitle'
						,STR_CONT='$str_cont'
						,STR_BIGO='$str_bigo'
						,STR_IMAGE1='$str_dimage1'
						,STR_IMAGE2='$str_dimage2'
						,STR_SERVICE='$str_service'
						,INT_TYPE='$int_type'
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
								STR_IMAGE1,
								STR_IMAGE2
							FROM "
				. $Tname . "comm_event
							WHERE
								INT_NUMBER='$chkItem1[$i]' ";

			$arr_img_Data = mysql_query($SQL_QUERY);
			$rcd_cnt = mysql_num_rows($arr_img_Data);

			if ($rcd_cnt) {
				if (mysql_result($arr_img_Data, 0, STR_IMAGE1) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE1));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE2) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE2));
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
	case "REF":

		$arr_Set_Data = array();
		$arr_Column_Name = array();

		$arr_Column_Name[0]		= "STR_AUTO_GOOD";

		$arr_Set_Data[0]		= $str_auto_good;

		$arr_Sub = "";

		for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

			if ($int_I != 0) {
				$arr_Sub .=  ",";
			}
			$arr_Sub .=  $arr_Column_Name[$int_I] . "=" . "'" . $arr_Set_Data[$int_I] . "' ";
		}

		$Sql_Query = "UPDATE `" . $Tname . "comm_event` SET ";
		$Sql_Query .= $arr_Sub;
		$Sql_Query .= " WHERE INT_NUMBER='" . $str_no . "' ";
		mysql_query($Sql_Query);

		exit;
		break;
}

?>