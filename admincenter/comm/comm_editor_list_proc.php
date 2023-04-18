<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$int_number = Fnc_Om_Conv_Default($_REQUEST[int_number],"");
	$str_dir = Fnc_Om_Conv_Default($_REQUEST[str_dir],"");
	$str_location = Fnc_Om_Conv_Default($_REQUEST[str_location],"");

	$str_Image=$_FILES['str_image']['tmp_name'];
	$str_Image_name=$_FILES['str_image']['name'];

	$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'].$str_location;

	switch($RetrieveFlag){
     	case "UPLOAD" :

			if (!is_dir($str_Add_Tag)){
				mkdir($str_Add_Tag,0777);
			}

			$str_Temp=Fnc_Om_File_Save($str_Image,$str_Image_name,"",0,0,"N",$str_Add_Tag);
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
			//$arr_Temp=Fnc_Om_File_Save($str_Image,$str_Image_name,"",0,0,"N",$str_Add_Tag);
			//$str_dimage1=$arr_Temp[0];
			$s_pto_width1=$arr_Temp[1];
			$s_pto_height1=$arr_Temp[2];

			$SQL_QUERY = "select ifnull(max(int_number),0)+1 as lastnumber from ".$Tname."comm_file " ;
			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_file (";
					$SQL_QUERY .= "INT_NUMBER,STR_PATH,DTM_INDATE,STR_FILE
											) VALUES (
												'$lastnumber','$str_location','".date("Y-m-d H:i:s")."','$str_dimage1'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="comm_editor_list.php?str_location=<?=urlencode($str_location)?>";
			</script>
			<?
			exit;
			break;

     	case "FDELETE" :

			$SQL_QUERY = "SELECT * FROM ".$Tname."comm_file WHERE INT_NUMBER='$int_number' ";

			$arr_file_Data=mysql_query($SQL_QUERY);
			$rcd_cnt=mysql_num_rows($arr_file_Data);

			if($rcd_cnt){
			   	if (mysql_result($arr_file_Data,0,str_file) !="") {
			   		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_file_Data,0,str_file));
			   	}
			}

			$SQL_QUERY = "DELETE FROM ".$Tname."comm_file WHERE INT_NUMBER='$int_number' ";
			$result=mysql_query($SQL_QUERY);


			?>
			<script language="javascript">
				window.location.href="comm_editor_list.php?str_location=<?=urlencode($str_location)?>";
			</script>
			<?
			exit;
			break;

		case "INSERT" :

			$SQL_QUERY = "SELECT * FROM ".$Tname."comm_dir WHERE STR_DIR='$str_dir' ";

			$arr_dir_Data=mysql_query($SQL_QUERY);
			$rcd_cnt=mysql_num_rows($arr_dir_Data);

			if($rcd_cnt){?>

				<script language=javascript>
					{
						alert("\폴더가 이미 생성되어 있습니다.\n다시한번 확인해 주세요")
						window.location="javascript: history.go(-1)"
					}
				</script>

			<?
				exit;
				break;
			}else{

				$SQL_QUERY = "select ifnull(max(int_number),0)+1 as lastnumber from ".$Tname."comm_dir " ;
				$arr_max_Data=mysql_query($SQL_QUERY);
				$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

				$SQL_QUERY = "INSERT INTO ".$Tname."comm_dir (";
						$SQL_QUERY .= "INT_NUMBER,STR_DIR,DTM_INDATE
												) VALUES (
													'$lastnumber','$str_dir','".date("Y-m-d H:i:s")."'
												)";

				$result=mysql_query($SQL_QUERY);

				$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'].$str_location.$str_dir."/";

				if (!is_dir($str_Add_Tag)){
					mkdir($str_Add_Tag,0777);
				}
				?>
				<script language="javascript">
					parent.location.href="comm_editor_list.php"
				</script>
				<?
				exit;
				break;
			}

			exit;
			break;

		case "DELETE" :

			$SQL_QUERY = "SELECT * FROM ".$Tname."comm_dir WHERE INT_NUMBER='$int_number' ";

			$arr_dir_Data=mysql_query($SQL_QUERY);
			$rcd_cnt=mysql_num_rows($arr_dir_Data);

			if($rcd_cnt){

				$str_Add_Tag = $_SERVER['DOCUMENT_ROOT']."/admincenter/files/data/".mysql_result($arr_dir_Data,0,str_dir)."/";
				Fnc_Om_Dir_Delete($str_Add_Tag);

			}

			$SQL_QUERY = "DELETE FROM ".$Tname."comm_file WHERE STR_PATH='".mysql_result($arr_dir_Data,0,str_dir)."' ";
			$result=mysql_query($SQL_QUERY);

			$SQL_QUERY = "DELETE FROM ".$Tname."comm_dir WHERE INT_NUMBER='$int_number' ";
			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				location.href="comm_editor_list.php"
			</script>
			<?
			exit;
			break;

   	}

?>