<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/Snoopy.class.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_String = Fnc_Om_Conv_Default($_REQUEST[str_String],"");
	$int_idx = Fnc_Om_Conv_Default($_REQUEST[int_idx],"0");
	$int_order = Fnc_Om_Conv_Default($_REQUEST[int_order],"0");
	$int_level = Fnc_Om_Conv_Default($_REQUEST[int_level],"0");
	$str_cont = Fnc_Om_Conv_Default($_REQUEST[str_cont],"");
	$str_del_img1 = Fnc_Om_Conv_Default($_REQUEST[str_del_img1],"N");
	
	$str_email = Fnc_Om_Conv_Default($_REQUEST[str_email],"");

	$str_dimage1 = Fnc_Om_Conv_Default($_REQUEST[str_dimage1],"");
	$str_Image1=$_FILES['str_Image1']['tmp_name'];
	$str_Image1_name=$_FILES['str_Image1']['name'];
	$str_sImage1 = $_FILES['str_sImage1'];

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	$str_Add_Tag = $_SERVER['DOCUMENT_ROOT']."/admincenter/files/qna/";

	if (!is_dir($str_Add_Tag)){
		mkdir($str_Add_Tag,0777);
	}


	switch($RetrieveFlag){
     	case "RINSERT" :

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
			$arr_Set_Data[1]		= $str_muserid;
			$arr_Set_Data[2]		= $int_idx;
			
			$SQL_QUERY = "UPDATE ".$Tname."comm_member_qna SET int_order=int_order-1 WHERE str_muserid='".$str_muserid."' AND int_idx='$int_idx' AND int_order<'".$int_order."' ";
			mysql_query($SQL_QUERY);
			
			$arr_Set_Data[3]		= $int_order-1;
			$arr_Set_Data[4]		= $int_level+1;
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
			
			
			$snoopy = new snoopy; 
			$snoopy->fetch("http://".$loc_I_Pg_Domain."/mailing/mailing_qna.html?str_no=".urlencode($lastnumber)); 
			$body = $snoopy->results; 
			
			Fnc_Om_Sendmail("문의하신 내용에 대한 답변을 드립니다.",$body,Fnc_Om_Store_Info(2),$str_email);
			
			?>
			<script language="javascript">
				parent.document.frm.submit();
			</script>
			<?
			exit;
			break;
			
		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	" SELECT
								STR_IMAGE1
							FROM "
								.$Tname."comm_member_qna
							WHERE
								INT_NUMBER='$chkItem1[$i]' ";

				$arr_img_Data=mysql_query($SQL_QUERY);
				$rcd_cnt=mysql_num_rows($arr_img_Data);

				if($rcd_cnt){
				   	if (mysql_result($arr_img_Data,0,STR_IMAGE1) !="") {
				   		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data,0,STR_IMAGE1));
				   	}
				}

				$SQL_QUERY = "DELETE FROM ".$Tname."comm_member_qna WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);


			}
			?>
			<script language="javascript">
				window.location.href="memb_qna_list.php<?=$str_String?>";
			</script>
			<?
			exit;
			break;

    }

?>