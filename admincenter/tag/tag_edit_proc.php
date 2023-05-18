<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag], "INSERT");

$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no], "");
$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun], "1");
$str_tag = Fnc_Om_Conv_Default($_REQUEST[str_tag], "");
$str_ktag = Fnc_Om_Conv_Default($_REQUEST[str_ktag], "");

$str_dimage = Fnc_Om_Conv_Default($_REQUEST[str_dimage], "");
$str_Image = $_FILES['str_Image']['tmp_name'];
$str_Image_name = $_FILES['str_Image']['name'];

$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'] . "/admincenter/files/tag/";

if (!is_dir($str_Add_Tag)) {
	mkdir($str_Add_Tag, 0777);
}

switch ($RetrieveFlag) {
	case "INSERT":

		$str_Temp = Fnc_Om_File_Save($str_Image, $str_Image_name, $str_dimage, '', '', $str_del_img, $str_Add_Tag);
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

		$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
		$SQL_QUERY .= $Tname;
		$SQL_QUERY .= "comm_tag a ";

		$arr_max_Data = mysql_query($SQL_QUERY);
		$lastnumber = mysql_result($arr_max_Data, 0, lastnumber);

		$SQL_QUERY = "INSERT INTO " . $Tname . "comm_tag (";
		$SQL_QUERY .= " INT_NUMBER,INT_GUBUN,STR_TAG,STR_KTAG,STR_IMAGE,DTM_INDATE
					) VALUES (
						'$lastnumber','$int_gubun','$str_tag','$str_ktag','$str_dimage','" . date("Y-m-d H:i:s") . "'
					)";

		mysql_query($SQL_QUERY);

		if ($str_default == "1") {
			$SQL_QUERY = " UPDATE " . $Tname . "comm_tag SET STR_DEFAULT='0' WHERE INT_GUBUN='$int_gubun' ";
			mysql_query($SQL_QUERY);

			$SQL_QUERY = " UPDATE " . $Tname . "comm_tag SET STR_DEFAULT='1' WHERE INT_NUMBER='$lastnumber' ";
			mysql_query($SQL_QUERY);
		}

		?>
		<script language="javascript">
			window.location.href = "tag_edit.php?RetrieveFlag=UPDATE&int_gubun=<?= $int_gubun ?>&str_no=<?= $lastnumber ?>";
		</script>
		<?
		exit;
		break;

	case "UPDATE":

		$str_Temp = Fnc_Om_File_Save($str_Image, $str_Image_name, $str_dimage, '', '', $str_del_img, $str_Add_Tag);
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

		$SQL_QUERY = " UPDATE " . $Tname . "comm_tag SET ";
		$SQL_QUERY .= "INT_GUBUN='$int_gubun'
									,STR_TAG='$str_tag'
									,STR_KTAG='$str_ktag'
									,STR_IMAGE='$str_dimage'
								WHERE
									INT_NUMBER='$str_no' ";

		mysql_query($SQL_QUERY);

		if ($str_default == "1") {
			$SQL_QUERY = " UPDATE " . $Tname . "comm_tag SET STR_DEFAULT='0' WHERE INT_GUBUN='$int_gubun' ";
			mysql_query($SQL_QUERY);

			$SQL_QUERY = " UPDATE " . $Tname . "comm_tag SET STR_DEFAULT='1' WHERE INT_NUMBER='$str_no' ";
			mysql_query($SQL_QUERY);
		}
		?>
		<script language="javascript">
			window.location.href = "tag_edit.php?RetrieveFlag=UPDATE&int_gubun=<?= $int_gubun ?>&str_no=<?= $str_no ?>";
		</script>
	<?
		exit;
		break;

	case "ADELETE":

		for ($i = 0; $i < count($chkItem1); $i++) {

			$SQL_QUERY =	" SELECT
								STR_IMAGE,
							FROM "
				. $Tname . "comm_tag
							WHERE
								INT_NUMBER='$chkItem1[$i]' ";

			$arr_img_Data = mysql_query($SQL_QUERY);
			$rcd_cnt = mysql_num_rows($arr_img_Data);

			if ($rcd_cnt) {
				if (mysql_result($arr_img_Data, 0, STR_IMAGE) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE));
				}
			}

			$SQL_QUERY =	"DELETE FROM " . $Tname . "comm_tag WHERE INT_NUMBER='$chkItem1[$i]' ";
			mysql_query($SQL_QUERY);
		}
	?>
		<script language="javascript">
			window.location.href = "tag_list.php?int_gubun=<?= $int_gubun ?>";
		</script>
<?
		exit;
		break;
}

?>