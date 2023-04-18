<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"1");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_bcode = Fnc_Om_Conv_Default($_REQUEST[str_bcode],"");
	$str_url1 = Fnc_Om_Conv_Default($_REQUEST[str_url1],"");
	$str_target1 = Fnc_Om_Conv_Default($_REQUEST[str_target1],"1");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"N");
	
	$str_del_img1 = Fnc_Om_Conv_Default($_REQUEST[str_del_img1],"N");

	$str_dimage1 = Fnc_Om_Conv_Default($_REQUEST[str_dimage1],"");
	$str_image1=$_FILES['str_image1']['tmp_name'];
	$str_image1_name=$_FILES['str_image1']['name'];

	$str_Add_Tag = $_SERVER['DOCUMENT_ROOT']."/admincenter/files/bann/";

	if (!is_dir($str_Add_Tag)){
		mkdir($str_Add_Tag,0777);
	}

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$str_Temp=Fnc_Om_File_Save($str_image1,$str_image1_name,$str_dimage1,0,0,"",$str_Add_Tag);

			if ($str_Temp[0] == "0") {
				?>
				<script language="javascript">
					alert("업로드에 실패하셨습니다.");
					history.back();
				</script>
				<?
				exit;
			}
			$arr_Temp=$str_Temp[1];

			$str_dimage1=$arr_Temp[0];
			$s_pto_width1=$arr_Temp[1];
			$s_pto_height1=$arr_Temp[2];

			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_banner a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_banner (";
					$SQL_QUERY .= " INT_GUBUN,INT_NUMBER,STR_BCODE,STR_URL1,STR_TARGET1,STR_IMAGE1,DTM_INDATE,STR_SERVICE
											) VALUES (
												'$int_gubun','$lastnumber','$str_bcode','$str_url1','$str_target1','$str_dimage1','".date("Y-m-d H:i:s")."','$str_service'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="bann_stamp_edit.php?RetrieveFlag=UPDATE&int_gubun=<?=$int_gubun?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$str_Temp=Fnc_Om_File_Save($str_image1,$str_image1_name,$str_dimage1,0,0,$str_del_img1,$str_Add_Tag);

			if ($str_Temp[0] == "0") {
				?>
				<script language="javascript">
					alert("업로드에 실패하셨습니다.");
					history.back();
				</script>
				<?
				exit;
			}

			$arr_Temp=$str_Temp[1];

			$str_dimage1=$arr_Temp[0];
			$s_pto_width1=$arr_Temp[1];
			$s_pto_height1=$arr_Temp[2];

			$SQL_QUERY = " UPDATE ".$Tname."comm_banner SET ";
								$SQL_QUERY .= "STR_URL1='$str_url1'
									,STR_TARGET1='$str_target1'
									,STR_IMAGE1='$str_dimage1'
									,STR_SERVICE='$str_service'
								WHERE
									INT_GUBUN='$int_gubun'
									AND
									STR_BCODE='$str_bcode' ";

			$result=mysql_query($SQL_QUERY);
			?>
			<script language="javascript">
				window.location.href="bann_stamp_edit.php?RetrieveFlag=UPDATE&int_gubun=<?=$int_gubun?>";
			</script>
			<?
			exit;
			break;


	}

?>
