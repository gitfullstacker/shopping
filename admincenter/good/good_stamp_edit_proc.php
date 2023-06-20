<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_String = Fnc_Om_Conv_Default($_REQUEST[str_String],"");
	$str_prod = Fnc_Om_Conv_Default($_REQUEST[str_prod],"");
	$int_ustamp = Fnc_Om_Conv_Default($_REQUEST[int_ustamp],"1");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"N");
	$int_price = Fnc_Om_Conv_Default($_REQUEST[int_price],"0");
	$int_percent = Fnc_Om_Conv_Default($_REQUEST[int_percent],"0");
	$int_months = Fnc_Om_Conv_Default($_REQUEST[int_months],"3");
	$str_num = Fnc_Om_Conv_Default($_REQUEST[str_num],"");

	$str_del_img1 = Fnc_Om_Conv_Default($_REQUEST[str_del_img1],"N");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	$str_dimage1 = Fnc_Om_Conv_Default($_REQUEST[str_dimage1],"");
	$str_Image1=$_FILES['str_Image1']['tmp_name'];
	$str_Image1_name=$_FILES['str_Image1']['name'];
	$str_sImage1 = $_FILES['str_sImage1'];
	
	$str_Add_Tag = $_SERVER['DOCUMENT_ROOT']."/admincenter/files/stamp/";

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
			
			$SQL_QUERY = "select ifnull(max(int_prod),0)+1 as lastnumber from ".$Tname."comm_stamp_prod " ;
			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "select ifnull(max(int_sort),0)+1 as lastnumber from ".$Tname."comm_stamp_prod " ;
			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastsort = mysql_result($arr_max_Data,0,lastnumber);

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_PROD";
			$arr_Column_Name[1]		= "STR_PROD";
			$arr_Column_Name[2]		= "INT_USTAMP";
			$arr_Column_Name[3]		= "STR_IMAGE1";
			$arr_Column_Name[4]		= "DTM_INDATE";
			$arr_Column_Name[5]		= "STR_SERVICE";
			$arr_Column_Name[6]		= "INT_PRICE";
			$arr_Column_Name[7]		= "INT_PERCENT";
			$arr_Column_Name[8]		= "INT_MONTHS";
			$arr_Column_Name[9]		= "STR_NUM";
			
			$arr_Set_Data[0]		= $lastnumber;
			$arr_Set_Data[1]		= addslashes($str_prod);
			$arr_Set_Data[2]		= $int_ustamp;
			$arr_Set_Data[3]		= $str_dimage1;
			$arr_Set_Data[4]		= date("Y-m-d H:i:s");
			$arr_Set_Data[5]		= $str_service;
			$arr_Set_Data[6]		= $int_price;
			$arr_Set_Data[7]		= $int_percent;
			$arr_Set_Data[8]		= $int_months;
			$arr_Set_Data[9]		= $str_num;
			
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
			
			$Sql_Query = "INSERT INTO `".$Tname."comm_stamp_prod` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
			mysql_query($Sql_Query);
			?>
			<script language="javascript">
				window.location.href="good_stamp_edit.php<?=$str_String?>&RetrieveFlag=UPDATE&str_no=<?=$lastnumber?>";
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
			
			$arr_Column_Name[0]		= "INT_PROD";
			$arr_Column_Name[1]		= "STR_PROD";
			$arr_Column_Name[2]		= "INT_USTAMP";
			$arr_Column_Name[3]		= "STR_IMAGE1";
			$arr_Column_Name[4]		= "STR_SERVICE";
			$arr_Column_Name[5]		= "INT_PRICE";
			$arr_Column_Name[6]		= "INT_PERCENT";
			$arr_Column_Name[7]		= "INT_MONTHS";
			$arr_Column_Name[8]		= "STR_NUM";

			$arr_Set_Data[0]		= $str_no;
			$arr_Set_Data[1]		= addslashes($str_prod);
			$arr_Set_Data[2]		= $int_ustamp;
			$arr_Set_Data[3]		= $str_dimage1;
			$arr_Set_Data[4]		= $str_service;
			$arr_Set_Data[5]		= $int_price;
			$arr_Set_Data[6]		= $int_percent;
			$arr_Set_Data[7]		= $int_months;
			$arr_Set_Data[8]		= $str_num;
			
			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";

			}

			$Sql_Query = "UPDATE `".$Tname."comm_stamp_prod` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE INT_PROD='".$str_no."' ";
			mysql_query($Sql_Query);

			?>
			<script language="javascript">
				window.location.href="good_stamp_edit.php<?=$str_String?>&RetrieveFlag=UPDATE&str_no=<?=$str_no?>";
			</script>
			<?

			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	" SELECT
								STR_IMAGE1
							FROM "
								.$Tname."comm_stamp_prod
							WHERE
								INT_PROD='$chkItem1[$i]' ";

				$arr_img_Data=mysql_query($SQL_QUERY);
				$rcd_cnt=mysql_num_rows($arr_img_Data);

				if($rcd_cnt){
				   	if (mysql_result($arr_img_Data,0,STR_IMAGE1) !="") {
				   		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data,0,STR_IMAGE1));
				   	}
				}

				$SQL_QUERY = "DELETE FROM ".$Tname."comm_stamp_prod WHERE INT_PROD='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);


			}
			?>
			<script language="javascript">
				window.location.href="good_stamp_list.php<?=$str_String?>";
			</script>
			<?
			exit;
			break;

    }

?>