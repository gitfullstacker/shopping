<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"1");
	$str_code = Fnc_Om_Conv_Default($_REQUEST[str_code],"");
	$str_kcode = Fnc_Om_Conv_Default($_REQUEST[str_kcode],"");
	$str_contents = Fnc_Om_Conv_Default($_REQUEST[str_contents],"");
	$str_url1 = Fnc_Om_Conv_Default($_REQUEST[str_url1],"");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"N");
	$str_default = Fnc_Om_Conv_Default($_REQUEST[str_default],"0");
	
	$str_dimage1 = Fnc_Om_Conv_Default($_REQUEST[str_dimage1],"");
	$str_Image1=$_FILES['str_Image1']['tmp_name'];
	$str_Image1_name=$_FILES['str_Image1']['name'];
	$str_sImage1 = $_FILES['str_sImage1'];
	
	$str_dimage2 = Fnc_Om_Conv_Default($_REQUEST[str_dimage2],"");
	$str_Image2=$_FILES['str_Image2']['tmp_name'];
	$str_Image2_name=$_FILES['str_Image2']['name'];
	$str_sImage2 = $_FILES['str_sImage2'];

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");
	
	$str_Add_Tag = $_SERVER[DOCUMENT_ROOT]."/admincenter/files/com/";

	if (!is_dir($str_Add_Tag)){
		mkdir($str_Add_Tag,0777);
	}

	switch($RetrieveFlag){
     	case "INSERT" :

			$str_Temp=Fnc_Om_File_Save($str_Image1,$str_Image1_name,$str_dimage1,'','',$str_del_img1,$str_Add_Tag);
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
			
			$str_Temp=Fnc_Om_File_Save($str_Image2,$str_Image2_name,$str_dimage2,'','',$str_del_img2,$str_Add_Tag);
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
			$str_dimage2=$arr_Temp[0];

			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_com_code a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_com_code (";
					$SQL_QUERY .= " INT_NUMBER,INT_GUBUN,STR_CODE,STR_KCODE,STR_IMAGE1,STR_IMAGE2,STR_CONTENTS,STR_URL1,DTM_INDATE,STR_SERVICE
											) VALUES (
												'$lastnumber','$int_gubun','$str_code','$str_kcode','$str_dimage1','$str_dimage2','$str_contents','$str_url1','".date("Y-m-d H:i:s")."','$str_service'
											)";

			mysql_query($SQL_QUERY);
			
			if ($str_default=="1") {
				$SQL_QUERY = " UPDATE ".$Tname."comm_com_code SET STR_DEFAULT='0' WHERE INT_GUBUN='$int_gubun' ";
				mysql_query($SQL_QUERY);

				$SQL_QUERY = " UPDATE ".$Tname."comm_com_code SET STR_DEFAULT='1' WHERE INT_NUMBER='$lastnumber' ";
				mysql_query($SQL_QUERY);
			}

			?>
			<script language="javascript">
				window.location.href="com_com_edit.php?RetrieveFlag=UPDATE&int_gubun=<?=$int_gubun?>&str_no=<?=$lastnumber?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$str_Temp=Fnc_Om_File_Save($str_Image1,$str_Image1_name,$str_dimage1,'','',$str_del_img1,$str_Add_Tag);
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
			
			$str_Temp=Fnc_Om_File_Save($str_Image2,$str_Image2_name,$str_dimage2,'','',$str_del_img2,$str_Add_Tag);
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
			$str_dimage2=$arr_Temp[0];

			$SQL_QUERY = " UPDATE ".$Tname."comm_com_code SET ";
								$SQL_QUERY .= "INT_GUBUN='$int_gubun'
									,STR_CODE='$str_code'
									,STR_KCODE='$str_kcode'
									,STR_IMAGE1='$str_dimage1'
									,STR_IMAGE2='$str_dimage2'
									,STR_CONTENTS='$str_contents'
									,STR_URL1='$str_url1'
									,STR_SERVICE='$str_service'
								WHERE
									INT_NUMBER='$str_no' ";

			mysql_query($SQL_QUERY);
			
			if ($str_default=="1") {
				$SQL_QUERY = " UPDATE ".$Tname."comm_com_code SET STR_DEFAULT='0' WHERE INT_GUBUN='$int_gubun' ";
				mysql_query($SQL_QUERY);

				$SQL_QUERY = " UPDATE ".$Tname."comm_com_code SET STR_DEFAULT='1' WHERE INT_NUMBER='$str_no' ";
				mysql_query($SQL_QUERY);
			}
			?>
			<script language="javascript">
				window.location.href="com_com_edit.php?RetrieveFlag=UPDATE&int_gubun=<?=$int_gubun?>&str_no=<?=$str_no?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {
			
				$SQL_QUERY =	" SELECT
								STR_IMAGE1,
								STR_IMAGE2
							FROM "
								.$Tname."comm_com_code
							WHERE
								INT_NUMBER='$chkItem1[$i]' ";

				$arr_img_Data=mysql_query($SQL_QUERY);
				$rcd_cnt=mysql_num_rows($arr_img_Data);

				if($rcd_cnt){
				   	if (mysql_result($arr_img_Data,0,STR_IMAGE1) !="") {
				   		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data,0,STR_IMAGE1));
				   	}
				   	if (mysql_result($arr_img_Data,0,STR_IMAGE2) !="") {
				   		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data,0,STR_IMAGE2));
				   	}
				}

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_com_code WHERE INT_NUMBER='$chkItem1[$i]' ";
				mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="com_com_list.php?int_gubun=<?=$int_gubun?>";
			</script>
			<?
			exit;
			break;

	}

?>
