<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_cont = Fnc_Om_Conv_Default($_REQUEST[str_cont],"");
	$str_del_img1 = Fnc_Om_Conv_Default($_REQUEST[str_del_img1],"N");

	$str_dimage1 = Fnc_Om_Conv_Default($_REQUEST[str_dimage1],"");
	$str_Image1=$_FILES['str_Image1']['tmp_name'];
	$str_Image1_name=$_FILES['str_Image1']['name'];
	$str_sImage1 = $_FILES['str_sImage1'];

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	$str_Add_Tag = $_SERVER[DOCUMENT_ROOT]."/admincenter/files/qna/";

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

			$SQL_QUERY = "select ifnull(max(int_number),0)+1 as lastnumber from ".$Tname."comm_member_qna " ;
			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "STR_MUSERiD";
			$arr_Column_Name[2]		= "INT_IDX";
			$arr_Column_Name[3]		= "INT_ORDER";
			$arr_Column_Name[4]		= "INT_LEVEL";
			$arr_Column_Name[5]		= "STR_USERID";
			$arr_Column_Name[6]		= "STR_NAME";
			$arr_Column_Name[7]		= "STR_CONT";
			$arr_Column_Name[8]		= "STR_IMAGE1";
			$arr_Column_Name[9]		= "DTM_INDATE";
			
			$arr_Set_Data[0]		= $lastnumber;
			$arr_Set_Data[1]		= $arr_Auth[0];
			$arr_Set_Data[2]		= $lastnumber;
			$arr_Set_Data[3]		= $lastnumber * 100;
			$arr_Set_Data[4]		= "0";
			$arr_Set_Data[5]		= $arr_Auth[0];
			$arr_Set_Data[6]		= $arr_Auth[2];
			$arr_Set_Data[7]		= $str_cont;
			$arr_Set_Data[8]		= $str_dimage1;
			$arr_Set_Data[9]		= date("Y-m-d H:i:s");
			
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
			
			$Sql_Query = "INSERT INTO `".$Tname."comm_member_qna` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
			mysql_query($Sql_Query);
			?>
			<script language="javascript">
				parent.document.frm.submit();
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
			$arr_Column_Name[1]		= "STR_CONT";
			$arr_Column_Name[2]		= "STR_IMAGE1";
			
			$arr_Set_Data[0]		= $str_no;
			$arr_Set_Data[1]		= $str_cont;
			$arr_Set_Data[2]		= $str_dimage1;

			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";

			}

			$Sql_Query = "UPDATE `".$Tname."comm_member_qna` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE INT_NUMBER='".$str_no."' ";
			mysql_query($Sql_Query);

			?>
			<script language="javascript">
				parent.document.frm.submit();
			</script>
			<?
			exit;
			break;
			
			
		case "ADELETE" :

			$SQL_QUERY =	" SELECT
							STR_IMAGE1
						FROM "
							.$Tname."comm_member_qna
						WHERE
							INT_NUMBER='$str_no' AND STR_USERID='$arr_Auth[0]' ";

			$arr_img_Data=mysql_query($SQL_QUERY);
			$rcd_cnt=mysql_num_rows($arr_img_Data);

			if($rcd_cnt){
			   	if (mysql_result($arr_img_Data,0,STR_IMAGE1) !="") {
			   		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data,0,STR_IMAGE1));
			   	}
			}

			$SQL_QUERY = "DELETE FROM ".$Tname."comm_member_qna WHERE INT_NUMBER='$str_no' AND STR_USERID='$arr_Auth[0]' ";
			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="my_qna.php<?=$str_String?>";
			</script>
			<?
			exit;
			break;
    }

?>