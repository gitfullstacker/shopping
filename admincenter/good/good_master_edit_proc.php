<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
Fnc_Acc_Admin();
?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag], "INSERT");

$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no], "");
$str_String = Fnc_Om_Conv_Default($_REQUEST[str_String], "");
$str_goodname = Fnc_Om_Conv_Default($_REQUEST[str_goodname], "");
$str_egoodname = Fnc_Om_Conv_Default($_REQUEST[str_egoodname], "");
$int_price = Fnc_Om_Conv_Default($_REQUEST[int_price], "0");
$int_discount = Fnc_Om_Conv_Default($_REQUEST[int_discount], "0");
$int_brand = Fnc_Om_Conv_Default($_REQUEST[int_brand], "0");
$int_bsu = Fnc_Om_Conv_Default($_REQUEST[int_bsu], "1");
$str_material = Fnc_Om_Conv_Default($_REQUEST[str_material], "");
$str_size = Fnc_Om_Conv_Default($_REQUEST[str_size], "");
$str_tsize = implode(",", Fnc_Om_Conv_Default($_REQUEST[str_tsize], array()));
$str_style = implode(",", Fnc_Om_Conv_Default($_REQUEST[str_style], array()));
$str_length = Fnc_Om_Conv_Default($_REQUEST[str_length], "");
$str_origin = Fnc_Om_Conv_Default($_REQUEST[str_origin], "");
$int_used = Fnc_Om_Conv_Default($_REQUEST[int_used], "0");
$str_color = Fnc_Om_Conv_Default($_REQUEST[str_color], "");
$str_contents = Fnc_Om_Conv_Default($_REQUEST[str_contents], "");
$int_like = Fnc_Om_Conv_Default($_REQUEST[int_like], "0");
$str_re_f = Fnc_Om_Conv_Default($_REQUEST[str_re_f], "N");
$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service], "N");
$str_myn = Fnc_Om_Conv_Default($_REQUEST[str_myn], "N");
$str_mmyn = Fnc_Om_Conv_Default($_REQUEST[str_mmyn], "N");
$int_mileage = Fnc_Om_Conv_Default($_REQUEST[int_mileage], "0");
$str_pmileage = Fnc_Om_Conv_Default($_REQUEST[str_pmileage], "N");
$to_int_type = Fnc_Om_Conv_Default($_REQUEST[to_int_type], "0");
$int_type = Fnc_Om_Conv_Default($_REQUEST[int_type], "1");
$int_grade = Fnc_Om_Conv_Default($_REQUEST[int_grade], "1");
$str_color_val = Fnc_Om_Conv_Default($_REQUEST[str_color_val], "");

$str_del_img1 = Fnc_Om_Conv_Default($_REQUEST[str_del_img1], "N");
$str_del_img2 = Fnc_Om_Conv_Default($_REQUEST[str_del_img2], "N");
$str_del_img3 = Fnc_Om_Conv_Default($_REQUEST[str_del_img3], "N");
$str_del_img4 = Fnc_Om_Conv_Default($_REQUEST[str_del_img4], "N");
$str_del_img5 = Fnc_Om_Conv_Default($_REQUEST[str_del_img5], "N");
$str_del_img6 = Fnc_Om_Conv_Default($_REQUEST[str_del_img6], "N");
$str_del_img7 = Fnc_Om_Conv_Default($_REQUEST[str_del_img7], "N");
$str_del_img8 = Fnc_Om_Conv_Default($_REQUEST[str_del_img8], "N");
$str_del_img9 = Fnc_Om_Conv_Default($_REQUEST[str_del_img9], "N");
$str_del_img10 = Fnc_Om_Conv_Default($_REQUEST[str_del_img10], "N");
$str_del_img11 = Fnc_Om_Conv_Default($_REQUEST[str_del_img11], "N");
$str_del_img12 = Fnc_Om_Conv_Default($_REQUEST[str_del_img12], "N");
$str_del_timg = Fnc_Om_Conv_Default($_REQUEST[str_del_timg], "N");

$str_bcode = Fnc_Om_Conv_Default($_REQUEST[str_bcode], "");
$str_sgoodcode = Fnc_Om_Conv_Default($_REQUEST[str_sgoodcode], "");
$str_sservice = Fnc_Om_Conv_Default($_REQUEST[str_sservice], "Y");

$str_usercode = Fnc_Om_Conv_Default($_REQUEST[str_usercode], "");

$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1], "");
$chkItem2 = Fnc_Om_Conv_Default($_REQUEST[chkItem2], "");

$str_dimage1 = Fnc_Om_Conv_Default($_REQUEST[str_dimage1], "");
$str_Image1 = $_FILES['str_Image1']['tmp_name'];
$str_Image1_name = $_FILES['str_Image1']['name'];
$str_sImage1 = $_FILES['str_sImage1'];

$str_dimage2 = Fnc_Om_Conv_Default($_REQUEST[str_dimage2], "");
$str_Image2 = $_FILES['str_Image2']['tmp_name'];
$str_Image2_name = $_FILES['str_Image2']['name'];
$str_sImage2 = $_FILES['str_sImage2'];

$str_dimage3 = Fnc_Om_Conv_Default($_REQUEST[str_dimage3], "");
$str_Image3 = $_FILES['str_Image3']['tmp_name'];
$str_Image3_name = $_FILES['str_Image3']['name'];
$str_sImage3 = $_FILES['str_sImage3'];

$str_dimage4 = Fnc_Om_Conv_Default($_REQUEST[str_dimage4], "");
$str_Image4 = $_FILES['str_Image4']['tmp_name'];
$str_Image4_name = $_FILES['str_Image4']['name'];
$str_sImage4 = $_FILES['str_sImage4'];

$str_dimage5 = Fnc_Om_Conv_Default($_REQUEST[str_dimage5], "");
$str_Image5 = $_FILES['str_Image5']['tmp_name'];
$str_Image5_name = $_FILES['str_Image5']['name'];
$str_sImage5 = $_FILES['str_sImage5'];

$str_dimage6 = Fnc_Om_Conv_Default($_REQUEST[str_dimage6], "");
$str_Image6 = $_FILES['str_Image6']['tmp_name'];
$str_Image6_name = $_FILES['str_Image6']['name'];
$str_sImage6 = $_FILES['str_sImage6'];

$str_dimage7 = Fnc_Om_Conv_Default($_REQUEST[str_dimage7], "");
$str_Image7 = $_FILES['str_Image7']['tmp_name'];
$str_Image7_name = $_FILES['str_Image7']['name'];
$str_sImage7 = $_FILES['str_sImage7'];

$str_dimage8 = Fnc_Om_Conv_Default($_REQUEST[str_dimage8], "");
$str_Image8 = $_FILES['str_Image8']['tmp_name'];
$str_Image8_name = $_FILES['str_Image8']['name'];
$str_sImage8 = $_FILES['str_sImage8'];

$str_dimage9 = Fnc_Om_Conv_Default($_REQUEST[str_dimage9], "");
$str_Image9 = $_FILES['str_Image9']['tmp_name'];
$str_Image9_name = $_FILES['str_Image9']['name'];
$str_sImage9 = $_FILES['str_sImage9'];

$str_dimage10 = Fnc_Om_Conv_Default($_REQUEST[str_dimage10], "");
$str_Image10 = $_FILES['str_Image10']['tmp_name'];
$str_Image10_name = $_FILES['str_Image10']['name'];
$str_sImage10 = $_FILES['str_sImage10'];

$str_dimage11 = Fnc_Om_Conv_Default($_REQUEST[str_dimage11], "");
$str_Image11 = $_FILES['str_Image11']['tmp_name'];
$str_Image11_name = $_FILES['str_Image11']['name'];
$str_sImage11 = $_FILES['str_sImage11'];

$str_dimage12 = Fnc_Om_Conv_Default($_REQUEST[str_dimage12], "");
$str_Image12 = $_FILES['str_Image12']['tmp_name'];
$str_Image12_name = $_FILES['str_Image12']['name'];
$str_sImage12 = $_FILES['str_sImage12'];

$str_dtimage = Fnc_Om_Conv_Default($_REQUEST[str_dtimage], "");
$str_Timage = $_FILES['str_Timage']['tmp_name'];
$str_Timage_name = $_FILES['str_Timage']['name'];
$str_sTimage = $_FILES['str_sTimage'];

$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'] . "/admincenter/files/good/";

if (!is_dir($str_Add_Tag)) {
	mkdir($str_Add_Tag, 0777);
}


switch ($RetrieveFlag) {
	case "INSERT":

		$str_Temp = Fnc_Om_File_Save($str_Image1, $str_Image1_name, $str_dimage1, '', '', $str_del_img1, $str_Add_Tag);
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

		$str_Temp = Fnc_Om_File_Save($str_Image2, $str_Image2_name, $str_dimage2, '', '', $str_del_img2, $str_Add_Tag);
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

		$str_Temp = Fnc_Om_File_Save($str_Image3, $str_Image3_name, $str_dimage3, '', '', $str_del_img3, $str_Add_Tag);
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
		$str_dimage3 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image4, $str_Image4_name, $str_dimage4, '', '', $str_del_img4, $str_Add_Tag);
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
		$str_dimage4 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image5, $str_Image5_name, $str_dimage5, '', '', $str_del_img5, $str_Add_Tag);
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
		$str_dimage5 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image6, $str_Image6_name, $str_dimage6, '', '', $str_del_img6, $str_Add_Tag);
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
		$str_dimage6 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image7, $str_Image7_name, $str_dimage7, '', '', $str_del_img7, $str_Add_Tag);
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
		$str_dimage7 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image8, $str_Image8_name, $str_dimage8, '', '', $str_del_img8, $str_Add_Tag);
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
		$str_dimage8 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image9, $str_Image9_name, $str_dimage9, '', '', $str_del_img9, $str_Add_Tag);
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
		$str_dimage9 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image10, $str_Image10_name, $str_dimage10, '', '', $str_del_img10, $str_Add_Tag);
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
		$str_dimage10 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image11, $str_Image11_name, $str_dimage11, '', '', $str_del_img11, $str_Add_Tag);
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
		$str_dimage11 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image12, $str_Image12_name, $str_dimage12, '', '', $str_del_img12, $str_Add_Tag);
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
		$str_dimage12 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Timage, $str_Timage_name, $str_dtimage, '', '', $str_del_timg, $str_Add_Tag);
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
		$str_dtimage = $arr_Temp[0];

		$SQL_QUERY = "select ifnull(max(str_goodcode),0)+1 as lastnumber from " . $Tname . "comm_goods_master where str_goodcode like '" . date("Ymd") . "%' ";
		$arr_max_Data = mysql_query($SQL_QUERY);
		$lastnumber = date("Ymd") . Fnc_Om_Add_Zero(right(mysql_result($arr_max_Data, 0, lastnumber), 4), 4);

		$SQL_QUERY = "select ifnull(max(int_sort),0)+1 as lastnumber from " . $Tname . "comm_goods_master ";
		$arr_max_Data = mysql_query($SQL_QUERY);
		$lastsort = mysql_result($arr_max_Data, 0, lastnumber);

		$arr_Set_Data = array();
		$arr_Column_Name = array();

		$arr_Column_Name[0] = "STR_GOODCODE";
		$arr_Column_Name[1] = "STR_GOODNAME";
		$arr_Column_Name[2] = "STR_EGOODNAME";
		$arr_Column_Name[3] = "INT_PRICE";
		$arr_Column_Name[4] = "STR_IMAGE1";
		$arr_Column_Name[5] = "STR_IMAGE2";
		$arr_Column_Name[6] = "STR_IMAGE3";
		$arr_Column_Name[7] = "STR_IMAGE4";
		$arr_Column_Name[8] = "STR_IMAGE5";
		$arr_Column_Name[9] = "STR_IMAGE6";
		$arr_Column_Name[10] = "STR_IMAGE7";
		$arr_Column_Name[11] = "STR_IMAGE8";
		$arr_Column_Name[12] = "STR_IMAGE9";
		$arr_Column_Name[13] = "STR_IMAGE10";
		$arr_Column_Name[14] = "STR_IMAGE11";
		$arr_Column_Name[15] = "STR_IMAGE12";
		$arr_Column_Name[16] = "INT_BRAND";
		$arr_Column_Name[17] = "INT_BSU";
		$arr_Column_Name[18] = "STR_MATERIAL";
		$arr_Column_Name[19] = "STR_SIZE";
		$arr_Column_Name[20] = "STR_LENGTH";
		$arr_Column_Name[21] = "STR_ORIGIN";
		$arr_Column_Name[22] = "INT_USED";
		$arr_Column_Name[23] = "STR_COLOR";
		$arr_Column_Name[24] = "STR_CONTENTS";
		$arr_Column_Name[25] = "INT_LIKE";
		$arr_Column_Name[26] = "STR_RE_F";
		$arr_Column_Name[27] = "DTM_INDATE";
		$arr_Column_Name[28] = "STR_SERVICE";
		$arr_Column_Name[29] = "STR_MYN";
		$arr_Column_Name[30] = "STR_MMYN";
		$arr_Column_Name[31] = "INT_SORT";
		$arr_Column_Name[32] = "INT_DISCOUNT";
		$arr_Column_Name[33] = "STR_TSIZE";
		$arr_Column_Name[34] = "STR_STYLE";
		$arr_Column_Name[35] = "INT_MILEAGE";
		$arr_Column_Name[36] = "STR_PMILEAGE";
		$arr_Column_Name[37] = "INT_VIEW";
		$arr_Column_Name[38] = "STR_TIMAGE";
		$arr_Column_Name[39] = "INT_TYPE";
		$arr_Column_Name[40] = "INT_GRADE";
		$arr_Column_Name[41] = "STR_COLOR_VAL";

		$arr_Set_Data[0] = $lastnumber;
		$arr_Set_Data[1] = addslashes($str_goodname);
		$arr_Set_Data[2] = addslashes($str_egoodname);
		$arr_Set_Data[3] = $int_price;
		$arr_Set_Data[4] = $str_dimage1;
		$arr_Set_Data[5] = $str_dimage2;
		$arr_Set_Data[6] = $str_dimage3;
		$arr_Set_Data[7] = $str_dimage4;
		$arr_Set_Data[8] = $str_dimage5;
		$arr_Set_Data[9] = $str_dimage6;
		$arr_Set_Data[10] = $str_dimage7;
		$arr_Set_Data[11] = $str_dimage8;
		$arr_Set_Data[12] = $str_dimage9;
		$arr_Set_Data[13] = $str_dimage10;
		$arr_Set_Data[14] = $str_dimage11;
		$arr_Set_Data[15] = $str_dimage12;
		$arr_Set_Data[16] = $int_brand;
		$arr_Set_Data[17] = $int_bsu;
		$arr_Set_Data[18] = $str_material;
		$arr_Set_Data[19] = $str_size;
		$arr_Set_Data[20] = $str_length;
		$arr_Set_Data[21] = $str_origin;
		$arr_Set_Data[22] = $int_used;
		$arr_Set_Data[23] = $str_color;
		$arr_Set_Data[24] = addslashes($str_contents);
		$arr_Set_Data[25] = $int_like;
		$arr_Set_Data[26] = "N";
		$arr_Set_Data[27] = date("Y-m-d H:i:s");
		$arr_Set_Data[28] = $str_service;
		$arr_Set_Data[29] = $str_myn;
		$arr_Set_Data[30] = $str_mmyn;
		$arr_Set_Data[31] = $lastsort;
		$arr_Set_Data[32] = $int_discount ?: null;
		$arr_Set_Data[33] = $str_tsize;
		$arr_Set_Data[34] = $str_style;
		$arr_Set_Data[35] = $int_mileage ?: null;
		$arr_Set_Data[36] = $str_pmileage;
		$arr_Set_Data[37] = 0;
		$arr_Set_Data[38] = $str_dtimage;
		$arr_Set_Data[39] = $int_type;
		$arr_Set_Data[40] = $int_grade;
		$arr_Set_Data[41] = $str_color_val;

		$arr_Sub1 = "";
		$arr_Sub2 = "";

		for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

			if ($int_I != 0) {
				$arr_Sub1 .=  ",";
				$arr_Sub2 .=  ",";
			}
			$arr_Sub1 .=  $arr_Column_Name[$int_I];
			$arr_Sub2 .=  $arr_Set_Data[$int_I] ? "'" . $arr_Set_Data[$int_I] . "'" : 'null ';
		}

		$Sql_Query = "INSERT INTO `" . $Tname . "comm_goods_master` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
		mysql_query($Sql_Query);

		$Sql_Query = "DELETE FROM `" . $Tname . "comm_goods_master_sub` WHERE STR_GOODCODE='" . $lastnumber . "' ";
		mysql_query($Sql_Query);

		for ($ii = 0; $ii < $int_bsu; $ii++) {

			$arr_Set_Data2 = array();
			$arr_Column_Name2 = array();

			$arr_Column_Name2[0]		= "STR_SGOODCODE";
			$arr_Column_Name2[1]		= "STR_GOODCODE";
			$arr_Column_Name2[2]		= "STR_SERVICE";

			$arr_Set_Data2[0]		= $lastnumber . Fnc_Om_Add_Zero($ii + 1, 3);
			$arr_Set_Data2[1]		= $lastnumber;
			$arr_Set_Data2[2]		= "Y";

			$arr_Sub1 = "";
			$arr_Sub2 = "";

			for ($int_I = 0; $int_I < count($arr_Column_Name2); $int_I++) {

				if ($int_I != 0) {
					$arr_Sub1 .=  ",";
					$arr_Sub2 .=  ",";
				}
				$arr_Sub1 .=  $arr_Column_Name2[$int_I];
				$arr_Sub2 .=  $arr_Set_Data2[$int_I] ? "'" . $arr_Set_Data2[$int_I] . "'" : 'null';
			}

			$Sql_Query = "INSERT INTO `" . $Tname . "comm_goods_master_sub` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
			mysql_query($Sql_Query);
		}


		$Sql_Query = "DELETE FROM `" . $Tname . "comm_goods_master_category` WHERE STR_GOODCODE='" . $lastnumber . "' ";
		mysql_query($Sql_Query);

		for ($ii = 0; $ii < count($str_bcode); $ii++) {
			if (!empty($str_bcode[$ii])) {

				$arr_Set_Data2 = array();
				$arr_Column_Name2 = array();

				$arr_Column_Name2[0]		= "STR_GOODCODE";
				$arr_Column_Name2[1]		= "STR_BCODE";

				$arr_Set_Data2[0]		= $lastnumber;
				$arr_Set_Data2[1]		= $str_bcode[$ii];

				$arr_Sub1 = "";
				$arr_Sub2 = "";

				for ($int_I = 0; $int_I < count($arr_Column_Name2); $int_I++) {

					if ($int_I != 0) {
						$arr_Sub1 .=  ",";
						$arr_Sub2 .=  ",";
					}
					$arr_Sub1 .=  $arr_Column_Name2[$int_I];
					$arr_Sub2 .=  "'" . $arr_Set_Data2[$int_I] . "'";
				}

				$Sql_Query = "INSERT INTO `" . $Tname . "comm_goods_master_category` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
				mysql_query($Sql_Query);
			}
		}

		?>
		<script language="javascript">
			window.location.href = "good_master_edit.php<?= $str_String ?>&RetrieveFlag=UPDATE&str_no=<?= $lastnumber ?>";
		</script>
		<?
		exit;
		break;

	case "UPDATE":

		$str_Temp = Fnc_Om_File_Save($str_Image1, $str_Image1_name, $str_dimage1, '', '', $str_del_img1, $str_Add_Tag);
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

		$str_Temp = Fnc_Om_File_Save($str_Image2, $str_Image2_name, $str_dimage2, '', '', $str_del_img2, $str_Add_Tag);
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

		$str_Temp = Fnc_Om_File_Save($str_Image3, $str_Image3_name, $str_dimage3, '', '', $str_del_img3, $str_Add_Tag);
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
		$str_dimage3 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image4, $str_Image4_name, $str_dimage4, '', '', $str_del_img4, $str_Add_Tag);
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
		$str_dimage4 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image5, $str_Image5_name, $str_dimage5, '', '', $str_del_img5, $str_Add_Tag);
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
		$str_dimage5 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image6, $str_Image6_name, $str_dimage6, '', '', $str_del_img6, $str_Add_Tag);
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
		$str_dimage6 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image7, $str_Image7_name, $str_dimage7, '', '', $str_del_img7, $str_Add_Tag);
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
		$str_dimage7 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image8, $str_Image8_name, $str_dimage8, '', '', $str_del_img8, $str_Add_Tag);
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
		$str_dimage8 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image9, $str_Image9_name, $str_dimage9, '', '', $str_del_img9, $str_Add_Tag);
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
		$str_dimage9 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image10, $str_Image10_name, $str_dimage10, '', '', $str_del_img10, $str_Add_Tag);
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
		$str_dimage10 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image11, $str_Image11_name, $str_dimage11, '', '', $str_del_img11, $str_Add_Tag);
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
		$str_dimage11 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Image12, $str_Image12_name, $str_dimage12, '', '', $str_del_img12, $str_Add_Tag);
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
		$str_dimage12 = $arr_Temp[0];

		$str_Temp = Fnc_Om_File_Save($str_Timage, $str_Timage_name, $str_dtimage, '', '', $str_del_timg, $str_Add_Tag);
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
		$str_dtimage = $arr_Temp[0];

		$arr_Set_Data = array();
		$arr_Column_Name = array();

		$arr_Column_Name[0] = "STR_GOODCODE";
		$arr_Column_Name[1] = "STR_GOODNAME";
		$arr_Column_Name[2] = "STR_EGOODNAME";
		$arr_Column_Name[3] = "INT_PRICE";
		$arr_Column_Name[4] = "STR_IMAGE1";
		$arr_Column_Name[5] = "STR_IMAGE2";
		$arr_Column_Name[6] = "STR_IMAGE3";
		$arr_Column_Name[7] = "STR_IMAGE4";
		$arr_Column_Name[8] = "STR_IMAGE5";
		$arr_Column_Name[9] = "STR_IMAGE6";
		$arr_Column_Name[10] = "STR_IMAGE7";
		$arr_Column_Name[11] = "STR_IMAGE8";
		$arr_Column_Name[12] = "STR_IMAGE9";
		$arr_Column_Name[13] = "STR_IMAGE10";
		$arr_Column_Name[14] = "STR_IMAGE11";
		$arr_Column_Name[15] = "STR_IMAGE12";
		$arr_Column_Name[16] = "INT_BRAND";
		$arr_Column_Name[17] = "STR_MATERIAL";
		$arr_Column_Name[18] = "STR_SIZE";
		$arr_Column_Name[19] = "STR_LENGTH";
		$arr_Column_Name[20] = "STR_ORIGIN";
		$arr_Column_Name[21] = "INT_USED";
		$arr_Column_Name[22] = "STR_COLOR";
		$arr_Column_Name[23] = "STR_CONTENTS";
		$arr_Column_Name[24] = "INT_LIKE";
		$arr_Column_Name[25] = "STR_SERVICE";
		$arr_Column_Name[26] = "STR_MYN";
		$arr_Column_Name[27] = "STR_MMYN";
		$arr_Column_Name[28] = "INT_DISCOUNT";
		$arr_Column_Name[29] = "STR_TSIZE";
		$arr_Column_Name[30] = "STR_STYLE";
		$arr_Column_Name[31] = "INT_MILEAGE";
		$arr_Column_Name[32] = "STR_PMILEAGE";
		$arr_Column_Name[33] = "STR_TIMAGE";
		$arr_Column_Name[34] = "INT_GRADE";
		$arr_Column_Name[35] = "STR_COLOR_VAL";

		$arr_Set_Data[0] = $str_no;
		$arr_Set_Data[1] = addslashes($str_goodname);
		$arr_Set_Data[2] = addslashes($str_egoodname);
		$arr_Set_Data[3] = $int_price;
		$arr_Set_Data[4] = $str_dimage1;
		$arr_Set_Data[5] = $str_dimage2;
		$arr_Set_Data[6] = $str_dimage3;
		$arr_Set_Data[7] = $str_dimage4;
		$arr_Set_Data[8] = $str_dimage5;
		$arr_Set_Data[9] = $str_dimage6;
		$arr_Set_Data[10] = $str_dimage7;
		$arr_Set_Data[11] = $str_dimage8;
		$arr_Set_Data[12] = $str_dimage9;
		$arr_Set_Data[13] = $str_dimage10;
		$arr_Set_Data[14] = $str_dimage11;
		$arr_Set_Data[15] = $str_dimage12;
		$arr_Set_Data[16] = $int_brand;
		$arr_Set_Data[17] = $str_material;
		$arr_Set_Data[18] = $str_size;
		$arr_Set_Data[19] = $str_length;
		$arr_Set_Data[20] = $str_origin;
		$arr_Set_Data[21] = $int_used;
		$arr_Set_Data[22] = $str_color;
		$arr_Set_Data[23] = addslashes($str_contents);
		$arr_Set_Data[24] = $int_like;
		$arr_Set_Data[25] = $str_service;
		$arr_Set_Data[26] = $str_myn;
		$arr_Set_Data[27] = $str_mmyn;
		$arr_Set_Data[28] = $int_discount ?: null;
		$arr_Set_Data[29] = $str_tsize;
		$arr_Set_Data[30] = $str_style;
		$arr_Set_Data[31] = $int_mileage ?: null;
		$arr_Set_Data[32] = $str_pmileage;
		$arr_Set_Data[33] = $str_dtimage;
		$arr_Set_Data[34] = $int_grade;
		$arr_Set_Data[35] = $str_color_val;

		$arr_Sub = "";

		for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

			if ($int_I != 0) {
				$arr_Sub .=  ",";
			}
			$arr_Sub .=  $arr_Column_Name[$int_I] . "=" . ($arr_Set_Data[$int_I] ? "'" . $arr_Set_Data[$int_I] . "' " : 'null ');
		}

		$Sql_Query = "UPDATE `" . $Tname . "comm_goods_master` SET ";
		$Sql_Query .= $arr_Sub;
		$Sql_Query .= " WHERE STR_GOODCODE='" . $str_no . "' ";
		mysql_query($Sql_Query);


		$Sql_Query = "DELETE FROM `" . $Tname . "comm_goods_master_category` WHERE STR_GOODCODE='" . $str_no . "' ";
		mysql_query($Sql_Query);

		for ($ii = 0; $ii < count($str_bcode); $ii++) {
			if (!empty($str_bcode[$ii])) {

				$arr_Set_Data2 = array();
				$arr_Column_Name2 = array();

				$arr_Column_Name2[0]		= "STR_GOODCODE";
				$arr_Column_Name2[1]		= "STR_BCODE";

				$arr_Set_Data2[0]		= $str_no;
				$arr_Set_Data2[1]		= $str_bcode[$ii];

				$arr_Sub1 = "";
				$arr_Sub2 = "";

				for ($int_I = 0; $int_I < count($arr_Column_Name2); $int_I++) {

					if ($int_I != 0) {
						$arr_Sub1 .=  ",";
						$arr_Sub2 .=  ",";
					}
					$arr_Sub1 .=  $arr_Column_Name2[$int_I];
					$arr_Sub2 .=  "'" . $arr_Set_Data2[$int_I] . "'";
				}

				$Sql_Query = "INSERT INTO `" . $Tname . "comm_goods_master_category` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
				mysql_query($Sql_Query);
			}
		}
		?>
		<script language="javascript">
			window.location.href = "good_master_edit.php<?= $str_String ?>&RetrieveFlag=UPDATE&str_no=<?= $str_no ?>";
		</script>
	<?

		exit;
		break;

	case "ADELETE":

		for ($i = 0; $i < count($chkItem1); $i++) {

			$SQL_QUERY =	" SELECT
								STR_IMAGE1,
								STR_IMAGE2,
								STR_IMAGE3,
								STR_IMAGE4,
								STR_IMAGE5,
								STR_IMAGE6,
								STR_IMAGE7,
								STR_IMAGE8,
								STR_IMAGE9,
								STR_IMAGE10,
								STR_IMAGE11,
								STR_IMAGE12,
								STR_TIMAGE
							FROM "
				. $Tname . "comm_goods_master
							WHERE
								STR_GOODCODE='$chkItem1[$i]' ";

			$arr_img_Data = mysql_query($SQL_QUERY);
			$rcd_cnt = mysql_num_rows($arr_img_Data);

			if ($rcd_cnt) {
				if (mysql_result($arr_img_Data, 0, STR_IMAGE1) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE1));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE2) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE2));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE3) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE3));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE4) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE4));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE5) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE5));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE6) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE6));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE7) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE7));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE8) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE8));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE9) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE9));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE10) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE10));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE11) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE11));
				}
				if (mysql_result($arr_img_Data, 0, STR_IMAGE12) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_IMAGE12));
				}
				if (mysql_result($arr_img_Data, 0, STR_TIMAGE) != "") {
					Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data, 0, STR_TIMAGE));
				}
			}

			$SQL_QUERY = "DELETE FROM " . $Tname . "comm_goods_master_link WHERE (STR_GOODCODE='" . $chkItem1[$i] . "' OR STR_SGOODCODE='" . $chkItem1[$i] . "') ";
			mysql_query($SQL_QUERY);

			$SQL_QUERY = "DELETE FROM " . $Tname . "comm_goods_master_sub WHERE STR_GOODCODE='" . $chkItem1[$i] . "' ";
			mysql_query($SQL_QUERY);

			$SQL_QUERY = "DELETE FROM " . $Tname . "comm_goods_master_category WHERE STR_GOODCODE='" . $chkItem1[$i] . "' ";
			mysql_query($SQL_QUERY);

			$SQL_QUERY = "DELETE FROM " . $Tname . "comm_goods_master WHERE STR_GOODCODE='$chkItem1[$i]' ";
			$result = mysql_query($SQL_QUERY);
		}
	?>
		<script language="javascript">
			window.location.href = "good_master_list.php<?= $str_String ?>";
		</script>
	<?
		exit;
		break;


	case "SORT":

		for ($i = 0; $i < count($chkItem2); $i++) {

			$SQL_QUERY = "UPDATE " . $Tname . "comm_goods_master SET INT_SORT='" . $int_sort[$i] . "' WHERE STR_GOODCODE='$chkItem2[$i]' ";
			mysql_query($SQL_QUERY);
		}
	?>
		<script language="javascript">
			//parent.document.frm.submit();
			window.location.href = "good_master_list.php<?= $str_String ?>";
		</script>
	<?
		exit;
		break;

	case "REF":

		$arr_Set_Data = array();
		$arr_Column_Name = array();

		$arr_Column_Name[0]		= "STR_GOODCODE";
		$arr_Column_Name[1]		= "STR_RE_F";

		$arr_Set_Data[0]		= $str_no;
		$arr_Set_Data[1]		= $str_re_f;

		$arr_Sub = "";

		for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

			if ($int_I != 0) {
				$arr_Sub .=  ",";
			}
			$arr_Sub .=  $arr_Column_Name[$int_I] . "=" . "'" . $arr_Set_Data[$int_I] . "' ";
		}

		$Sql_Query = "UPDATE `" . $Tname . "comm_goods_master` SET ";
		$Sql_Query .= $arr_Sub;
		$Sql_Query .= " WHERE STR_GOODCODE='" . $str_no . "' ";
		mysql_query($Sql_Query);

		exit;
		break;

	case "PRODCODE":

		$Sql_Query =	" SELECT
							A.*
						FROM `"
			. $Tname . "comm_goods_master_sub` AS A
						WHERE
							A.STR_GOODCODE='" . $str_no . "'
						ORDER BY
							A.STR_SGOODCODE ASC ";

		$arr_Data2 = mysql_query($Sql_Query);
		$arr_Data2_Cnt = mysql_num_rows($arr_Data2);
	?>
		<table class=tb>
			<tr>
				<td><? if ($arr_Data2_Cnt) { ?>상품리얼코드 [각 수량별 고유코드] <? } ?> <a href="javascript:fnc_addprod('<?= $str_no ?>');"><img src="/admincenter/img/i_add.gif" align="absmiddle"></a></td>
			</tr>
			<?
			for ($int_I = 0; $int_I < $arr_Data2_Cnt; $int_I++) {
			?>
				<tr>
					<td>
						<?= mysql_result($arr_Data2, $int_I, str_sgoodcode) ?>]
						사용자 코드 : <input type="text" name="str_usercode<?= mysql_result($arr_Data2, $int_I, str_sgoodcode) ?>" id="str_usercode<?= mysql_result($arr_Data2, $int_I, str_sgoodcode) ?>" style="width:200px;" value="<?= mysql_result($arr_Data2, $int_I, str_usercode) ?>"> <img src="/admincenter/img/i_edit.gif" align="absmiddle" onclick="fnc_usercode('<?= mysql_result($arr_Data2, $int_I, str_sgoodcode) ?>','str_usercode<?= mysql_result($arr_Data2, $int_I, str_sgoodcode) ?>')">
						<select name="str_sservice" onchange="fnc_sservice('<?= $str_no ?>','<?= mysql_result($arr_Data2, $int_I, str_sgoodcode) ?>',this.value);">
							<option value="Y" <? if (mysql_result($arr_Data2, $int_I, str_service) == "Y") { ?> selected<? } ?>>출력
							<option value="N" <? if (mysql_result($arr_Data2, $int_I, str_service) == "N") { ?> selected<? } ?>>미출력
						</select>
						<? if ($int_I != 0) { ?><a href="javascript:fnc_delprod('<?= $str_no ?>','<?= mysql_result($arr_Data2, $int_I, str_sgoodcode) ?>');"><img src="/admincenter/img/btn_s_del.gif" align="absmiddle"></a><? } ?>
					</td>
				</tr>
			<?
			}
			?>
		</table>
	<?
		exit;
		break;

	case "PINSERT":

		$arr_Column_Name2 = array();

		$arr_Column_Name2[0]		= "STR_SGOODCODE";
		$arr_Column_Name2[1]		= "STR_GOODCODE";
		$arr_Column_Name2[2]		= "STR_SERVICE";


		$SQL_QUERY = "select ifnull(max(str_sgoodcode),0)+1 as lastnumber from " . $Tname . "comm_goods_master_sub where str_goodcode = '" . $str_no . "' ";
		$arr_max_Data = mysql_query($SQL_QUERY);
		$lastnumber = mysql_result($arr_max_Data, 0, lastnumber);

		$arr_Set_Data2[0]		= $lastnumber;
		$arr_Set_Data2[1]		= $str_no;
		$arr_Set_Data2[2]		= "Y";

		$arr_Sub1 = "";
		$arr_Sub2 = "";

		for ($int_I = 0; $int_I < count($arr_Column_Name2); $int_I++) {

			if ($int_I != 0) {
				$arr_Sub1 .=  ",";
				$arr_Sub2 .=  ",";
			}
			$arr_Sub1 .=  $arr_Column_Name2[$int_I];
			$arr_Sub2 .=  "'" . $arr_Set_Data2[$int_I] . "'";
		}

		$Sql_Query = "INSERT INTO `" . $Tname . "comm_goods_master_sub` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
		mysql_query($Sql_Query);


		$SQL_QUERY = "select ifnull(count(str_sgoodcode),0) as lastnumber from " . $Tname . "comm_goods_master_sub where str_goodcode = '" . $str_no . "' ";
		$arr_max_Data = mysql_query($SQL_QUERY);
		$cnt = mysql_result($arr_max_Data, 0, lastnumber);

		$SQL_QUERY = "UPDATE " . $Tname . "comm_goods_master SET INT_BSU='" . $cnt . "' WHERE STR_GOODCODE='$str_no' ";
		mysql_query($SQL_QUERY);

		exit;
		break;

	case "PDELETE":

		$Sql_Query = "DELETE FROM `" . $Tname . "comm_goods_master_sub` WHERE STR_GOODCODE='" . $str_no . "' AND STR_SGOODCODE='" . $str_sgoodcode . "'  ";
		mysql_query($Sql_Query);

		$SQL_QUERY = "select ifnull(count(str_sgoodcode),0) as lastnumber from " . $Tname . "comm_goods_master_sub where str_goodcode = '" . $str_no . "' ";
		$arr_max_Data = mysql_query($SQL_QUERY);
		$cnt = mysql_result($arr_max_Data, 0, lastnumber);

		$SQL_QUERY = "UPDATE " . $Tname . "comm_goods_master SET INT_BSU='" . $cnt . "' WHERE STR_GOODCODE='$str_no' ";
		mysql_query($SQL_QUERY);

		exit;
		break;

	case "PUPDATE":

		$Sql_Query = "UPDATE `" . $Tname . "comm_goods_master_sub` SET STR_SERVICE='" . $str_sservice . "' WHERE STR_GOODCODE='" . $str_no . "' AND STR_SGOODCODE='" . $str_sgoodcode . "'  ";
		mysql_query($Sql_Query);

		exit;
		break;

	case "USERCODE":

		$Sql_Query = "UPDATE `" . $Tname . "comm_goods_master_sub` SET STR_USERCODE='" . $str_usercode . "' WHERE STR_SGOODCODE='" . $str_sgoodcode . "'  ";
		mysql_query($Sql_Query);

		exit;
		break;

	case "MYN":

		$Sql_Query = "UPDATE `" . $Tname . "comm_goods_master` SET STR_MYN='" . $str_myn . "' WHERE STR_GOODCODE='" . $str_no . "'  ";
		mysql_query($Sql_Query);

		exit;
		break;

	case "MMYN":

		$Sql_Query = "UPDATE `" . $Tname . "comm_goods_master` SET STR_MMYN='" . $str_mmyn . "' WHERE STR_GOODCODE='" . $str_no . "'  ";
		mysql_query($Sql_Query);

		exit;
		break;

	case "AMOVE":
		for ($i = 0; $i < count($chkItem1); $i++) {
			$arr_Set_Data = array();
			$arr_Column_Name = array();

			$arr_Column_Name[0]		= "INT_TYPE";

			$arr_Set_Data[0]		= $to_int_type;

			$arr_Sub = "";

			for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

				if ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I] . "=" . "'" . $arr_Set_Data[$int_I] . "' ";
			}

			$Sql_Query = "UPDATE `" . $Tname . "comm_goods_master` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE STR_GOODCODE='" . $chkItem1[$i] . "' ";
			mysql_query($Sql_Query);
		}
	?>
		<script language="javascript">
			window.location.href = "good_master_list.php<?= $str_String ?>";
		</script>
		<?
		exit;
		break;

	case "ACOPY":
		for ($i = 0; $i < count($chkItem1); $i++) {
			$Sql_Query = "SELECT * FROM `" . $Tname . "comm_goods_master` WHERE STR_GOODCODE = " . $chkItem1[$i];
			$result = mysql_query($Sql_Query);
			if (!$result) {
				die('Error in query: ' . mysql_error());
			}

			$row = mysql_fetch_assoc($result);

			$currentTimestamp = date('YmdHis');

			if ($row['STR_IMAGE1']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE1'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
		?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage1 = $newFileName;

			if ($row['STR_IMAGE2']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE2'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage2 = $newFileName;

			if ($row['STR_IMAGE3']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE3'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage3 = $newFileName;

			if ($row['STR_IMAGE4']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE4'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage4 = $newFileName;

			if ($row['STR_IMAGE5']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE5'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage5 = $newFileName;

			if ($row['STR_IMAGE6']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE6'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage6 = $newFileName;

			if ($row['STR_IMAGE7']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE7'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage7 = $newFileName;

			if ($row['STR_IMAGE8']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE8'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage8 = $newFileName;

			if ($row['STR_IMAGE9']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE9'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage9 = $newFileName;

			if ($row['STR_IMAGE10']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE10'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage10 = $newFileName;

			if ($row['STR_IMAGE11']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE11'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage11 = $newFileName;

			if ($row['STR_IMAGE12']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_IMAGE12'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
				<?
					exit;
				}
			}
			$str_dimage12 = $newFileName;

			if ($row['STR_TIMAGE']) {
				$sourceFilePath = $str_Add_Tag . $row['STR_TIMAGE'];
				$sourceFileName = pathinfo($sourceFilePath, PATHINFO_FILENAME);
				$sourceFileExtension = pathinfo($sourceFilePath, PATHINFO_EXTENSION);

				$newFileName = $sourceFileName . '_' . $currentTimestamp . '.' . $sourceFileExtension;
				$destinationFilePath = $str_Add_Tag . $newFileName;

				if (!copy($sourceFilePath, $destinationFilePath)) {
				?>
					<script language="javascript">
						alert("업로드에 실패하셨습니다.");
						history.back();
					</script>
		<?
					exit;
				}
			}
			$str_dtimage = $newFileName;

			$SQL_QUERY = "select ifnull(max(str_goodcode),0)+1 as lastnumber from " . $Tname . "comm_goods_master where str_goodcode like '" . date("Ymd") . "%' ";
			$arr_max_Data = mysql_query($SQL_QUERY);
			$lastnumber = date("Ymd") . Fnc_Om_Add_Zero(right(mysql_result($arr_max_Data, 0, lastnumber), 4), 4);

			$SQL_QUERY = "select ifnull(max(int_sort),0)+1 as lastnumber from " . $Tname . "comm_goods_master ";
			$arr_max_Data = mysql_query($SQL_QUERY);
			$lastsort = mysql_result($arr_max_Data, 0, lastnumber);

			$arr_Set_Data = array();
			$arr_Column_Name = array();

			$arr_Column_Name[0]		= "STR_GOODCODE";
			$arr_Column_Name[1]		= "STR_GOODNAME";
			$arr_Column_Name[2]		= "STR_EGOODNAME";
			$arr_Column_Name[3]		= "INT_PRICE";
			$arr_Column_Name[4]		= "STR_IMAGE1";
			$arr_Column_Name[5]		= "STR_IMAGE2";
			$arr_Column_Name[6]		= "STR_IMAGE3";
			$arr_Column_Name[7]		= "STR_IMAGE4";
			$arr_Column_Name[8]		= "STR_IMAGE5";
			$arr_Column_Name[9]		= "STR_IMAGE6";
			$arr_Column_Name[10]		= "STR_IMAGE7";
			$arr_Column_Name[11]		= "STR_IMAGE8";
			$arr_Column_Name[12]		= "STR_IMAGE9";
			$arr_Column_Name[12]		= "STR_IMAGE10";
			$arr_Column_Name[12]		= "STR_IMAGE11";
			$arr_Column_Name[12]		= "STR_IMAGE12";
			$arr_Column_Name[13]		= "INT_BRAND";
			$arr_Column_Name[14]		= "INT_BSU";
			$arr_Column_Name[15]		= "STR_MATERIAL";
			$arr_Column_Name[16]		= "STR_SIZE";
			$arr_Column_Name[17]		= "STR_LENGTH";
			$arr_Column_Name[18]		= "STR_ORIGIN";
			$arr_Column_Name[19]		= "INT_USED";
			$arr_Column_Name[20]		= "STR_COLOR";
			$arr_Column_Name[21]		= "STR_CONTENTS";
			$arr_Column_Name[22]		= "INT_LIKE";
			$arr_Column_Name[23]		= "STR_RE_F";
			$arr_Column_Name[24]		= "DTM_INDATE";
			$arr_Column_Name[25]		= "STR_SERVICE";
			$arr_Column_Name[26]		= "STR_MYN";
			$arr_Column_Name[27]		= "STR_MMYN";
			$arr_Column_Name[28]		= "INT_SORT";
			$arr_Column_Name[29]		= "INT_DISCOUNT";
			$arr_Column_Name[30]		= "STR_TSIZE";
			$arr_Column_Name[31]		= "STR_STYLE";
			$arr_Column_Name[32]		= "INT_MILEAGE";
			$arr_Column_Name[33]		= "INT_VIEW";
			$arr_Column_Name[34]		= "STR_TIMAGE";
			$arr_Column_Name[35]		= "INT_TYPE";
			$arr_Column_Name[36]		= "STR_COLOR_VAL";

			$arr_Set_Data[0]		= $lastnumber;
			$arr_Set_Data[1]		= $row['STR_GOODNAME'];
			$arr_Set_Data[2]		= $row['STR_EGOODNAME'];
			$arr_Set_Data[3]		= $row['INT_PRICE'] ?: null;
			$arr_Set_Data[4]		= $str_dimage1;
			$arr_Set_Data[5]		= $str_dimage2;
			$arr_Set_Data[6]		= $str_dimage3;
			$arr_Set_Data[7]		= $str_dimage4;
			$arr_Set_Data[8]		= $str_dimage5;
			$arr_Set_Data[9]		= $str_dimage6;
			$arr_Set_Data[10]		= $str_dimage7;
			$arr_Set_Data[11]		= $str_dimage8;
			$arr_Set_Data[12]		= $str_dimage9;
			$arr_Set_Data[12]		= $str_dimage10;
			$arr_Set_Data[12]		= $str_dimage11;
			$arr_Set_Data[12]		= $str_dimage12;
			$arr_Set_Data[13]		= $row['INT_BRAND'];
			$arr_Set_Data[14]		= $row['INT_BSU'];
			$arr_Set_Data[15]		= $row['STR_MATERIAL'];
			$arr_Set_Data[16]		= $row['STR_SIZE'];
			$arr_Set_Data[17]		= $row['STR_LENGTH'];
			$arr_Set_Data[18]		= $row['STR_ORIGIN'];
			$arr_Set_Data[19]		= $row['INT_USED'];
			$arr_Set_Data[20]		= $row['STR_COLOR'];
			$arr_Set_Data[21]		= $row['STR_CONTENTS'];
			$arr_Set_Data[22]		= $row['INT_LIKE'];
			$arr_Set_Data[23]		= $row['STR_RE_F'];
			$arr_Set_Data[24]		= $row['DTM_INDATE'];
			$arr_Set_Data[25]		= $row['STR_SERVICE'];
			$arr_Set_Data[26]		= $row['STR_MYN'];
			$arr_Set_Data[27]		= $row['STR_MMYN'];
			$arr_Set_Data[28]		= $lastsort;
			$arr_Set_Data[29]		= $row['INT_DISCOUNT'] ?: null;
			$arr_Set_Data[30]		= $row['STR_TSIZE'];
			$arr_Set_Data[31]		= $row['STR_STYLE'];
			$arr_Set_Data[32]		= $row['INT_MILEAGE'] ?: null;
			$arr_Set_Data[33]		= $row['INT_VIEW'] ?: null;
			$arr_Set_Data[34]		= $str_dtimage;
			$arr_Set_Data[35]		= $to_int_type;
			$arr_Set_Data[36]		= $str_color_val;

			$arr_Sub1 = "";
			$arr_Sub2 = "";

			for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

				if ($int_I != 0) {
					$arr_Sub1 .=  ",";
					$arr_Sub2 .=  ",";
				}
				$arr_Sub1 .=  $arr_Column_Name[$int_I];
				$arr_Sub2 .=  $arr_Set_Data[$int_I] ? "'" . $arr_Set_Data[$int_I] . "'" : 'null ';
			}

			$Sql_Query = "INSERT INTO `" . $Tname . "comm_goods_master` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
			mysql_query($Sql_Query);
		}
		?>
		<script language="javascript">
			window.location.href = "good_master_list.php<?= $str_String ?>";
		</script>
<?
		exit;
		break;
}

?>