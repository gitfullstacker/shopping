<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_String = Fnc_Om_Conv_Default($_REQUEST[str_String],"");

	$str_del_img1 = Fnc_Om_Conv_Default($_REQUEST[str_del_img1],"N");
	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");
	
	$str_dimage1 = Fnc_Om_Conv_Default($_REQUEST[str_dimage1],"");
	$str_Image1=$_FILES['str_Image1']['tmp_name'];
	$str_Image1_name=$_FILES['str_Image1']['name'];
	$str_sImage1 = $_FILES['str_sImage1'];

	$str_Add_Tag = $_SERVER['DOCUMENT_ROOT']."/admincenter/files/img/";

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

			$SQL_QUERY = "select ifnull(max(int_number),0)+1 as lastnumber from ".$Tname."comm_image_info " ;
			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "STR_IMAGE1";
			$arr_Column_Name[2]		= "STR_PATH";
			$arr_Column_Name[3]		= "DTM_INDATE";
			
			$arr_Set_Data[0]		= $lastnumber;
			$arr_Set_Data[1]		= $str_dimage1;
			$arr_Set_Data[2]		= "/admincenter/files/img/";
			$arr_Set_Data[3]		= date("Y-m-d H:i:s");
			
			$arr_Sub1 = "";
			$arr_Sub2 = "";
			
			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub1 .=  ",";
					$arr_Sub2 .=  ",";
				}
				$arr_Sub1 .=  $arr_Column_Name[$int_I];
				$arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";

			}
			
			$Sql_Query = "INSERT INTO `".$Tname."comm_image_info` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
			mysql_query($Sql_Query);
	
			?>
			<script language="javascript">
				window.location.href="imgi_imgi_edit.php<?=$str_String?>&RetrieveFlag=UPDATE&str_no=<?=$lastnumber?>";
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

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "STR_IMAGE1";
			$arr_Column_Name[2]		= "STR_PATH";
			
			$arr_Set_Data[0]		= $str_no;
			$arr_Set_Data[1]		= $str_dimage1;
			$arr_Set_Data[2]		= "/admincenter/files/img/";
			
			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";

			}

			$Sql_Query = "UPDATE `".$Tname."comm_image_info` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE INT_NUMBER='".$str_no."' ";
			mysql_query($Sql_Query);
			
			?>
			<script language="javascript">
				window.location.href="imgi_imgi_edit.php<?=$str_String?>&RetrieveFlag=UPDATE&str_no=<?=$str_no?>";
			</script>
			<?

			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	" SELECT
								STR_IMAGE1
							FROM "
								.$Tname."comm_image_info
							WHERE
								INT_NUMBER='$chkItem1[$i]' ";

				$arr_img_Data=mysql_query($SQL_QUERY);
				$rcd_cnt=mysql_num_rows($arr_img_Data);

				if($rcd_cnt){
				   	if (mysql_result($arr_img_Data,0,STR_IMAGE1) !="") {
				   		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data,0,STR_IMAGE1));
				   	}
				}

				$SQL_QUERY = "DELETE FROM ".$Tname."comm_image_info WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);


			}
			?>
			<script language="javascript">
				window.location.href="imgi_imgi_list.php<?=$str_String?>";
			</script>
			<?
			exit;
			break;

    }

?>