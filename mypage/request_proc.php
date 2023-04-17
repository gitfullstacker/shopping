<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"1");
	$int_brand = Fnc_Om_Conv_Default($_REQUEST[int_brand],"");
	$int_reason = Fnc_Om_Conv_Default($_REQUEST[int_reason],"");
	$str_reason = Fnc_Om_Conv_Default($_REQUEST[str_reason],"");
	$int_sbrand = Fnc_Om_Conv_Default($_REQUEST[int_sbrand],"0");
	$str_ebrand1 = Fnc_Om_Conv_Default($_REQUEST[str_ebrand1],"");
	$str_ebrand2 = Fnc_Om_Conv_Default($_REQUEST[str_ebrand2],"");

	$str_dimage1 = Fnc_Om_Conv_Default($_REQUEST[str_dimage1],"");
	$str_Image1=$_FILES['str_Image1']['tmp_name'];
	$str_Image1_name=$_FILES['str_Image1']['name'];
	$str_sImage1 = $_FILES['str_sImage1'];
	
	$str_Add_Tag = $_SERVER[DOCUMENT_ROOT]."/admincenter/files/requ/";

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
			
			$SQL_QUERY = "select ifnull(max(int_number),0)+1 as lastnumber from ".$Tname."comm_member_requ" ;
			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "STR_USERID";
			$arr_Column_Name[2]		= "INT_GUBUN";
			$arr_Column_Name[3]		= "INT_BRAND";
			$arr_Column_Name[4]		= "STR_EBRAND";
			$arr_Column_Name[5]		= "INT_REASON";
			$arr_Column_Name[6]		= "STR_REASON";
			$arr_Column_Name[7]		= "STR_IMAGE1";
			$arr_Column_Name[8]		= "DTM_INDATE";
			
			$arr_Set_Data[0]		= $lastnumber;
			$arr_Set_Data[1]		= $arr_Auth[0];
			$arr_Set_Data[2]		= $int_gubun;
			$arr_Set_Data[3]		= $int_brand;
			
			if ($int_gubun=="1") {
				$arr_Set_Data[4]		= $str_ebrand1;
			}else{
				$arr_Set_Data[4]		= $str_ebrand2;
			}
			
			$arr_Set_Data[5]		= $int_reason;
			$arr_Set_Data[6]		= $str_reason;
			$arr_Set_Data[7]		= $str_dimage1;
			$arr_Set_Data[8]		= date("Y-m-d H:i:s");
			
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
			
			$Sql_Query = "INSERT INTO `".$Tname."comm_member_requ` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
			mysql_query($Sql_Query);
			
			$Sql_Query = "DELETE FROM `".$Tname."comm_member_requ_sub` WHERE INT_NUMBER='".$lastnumber."' ";
			mysql_query($Sql_Query);
			
			for($ii = 0; $ii < count($int_sbrand); $ii++) {
				
				if(!empty($int_sbrand[$ii])) {
			
					$arr_Set_Data2= Array();
					$arr_Column_Name2 = Array();
					
					$arr_Column_Name2[0]		= "INT_NUMBER";
					$arr_Column_Name2[1]		= "INT_SBRAND";
					
					$arr_Set_Data2[0]		= $lastnumber;
					$arr_Set_Data2[1]		= $int_sbrand[$ii];
	
					$arr_Sub1 = "";
					$arr_Sub2 = "";
					
					for($int_I=0;$int_I<count($arr_Column_Name2);$int_I++) {
		
						If  ($int_I != 0) {
							$arr_Sub1 .=  ",";
							$arr_Sub2 .=  ",";
						}
						$arr_Sub1 .=  $arr_Column_Name2[$int_I];
						$arr_Sub2 .=  "'" . $arr_Set_Data2[$int_I] . "'";
		
					}				
					
					$Sql_Query = "INSERT INTO `".$Tname."comm_member_requ_sub` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
					mysql_query($Sql_Query);
				
				}
			
			}
			

			?>
			<script language="javascript">
				alert("접수되었습니다.");
				window.location.href="request.php";
			</script>
			<?
			exit;
			break;

    }

?>