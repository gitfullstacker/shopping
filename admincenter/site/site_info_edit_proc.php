<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_sitename = Fnc_Om_Conv_Default($_REQUEST[str_sitename],"");
	$str_memail = Fnc_Om_Conv_Default($_REQUEST[str_memail],"");
	$str_siteurl = Fnc_Om_Conv_Default($_REQUEST[str_siteurl],"");
	$str_company = Fnc_Om_Conv_Default($_REQUEST[str_company],"");
	$str_item1 = Fnc_Om_Conv_Default($_REQUEST[str_item1],"");
	$str_item2 = Fnc_Om_Conv_Default($_REQUEST[str_item2],"");
	$str_post = Fnc_Om_Conv_Default($_REQUEST[str_post],"");
	$str_addr1 = Fnc_Om_Conv_Default($_REQUEST[str_addr1],"");
	$str_addr2 = Fnc_Om_Conv_Default($_REQUEST[str_addr2],"");
	$str_license = Fnc_Om_Conv_Default($_REQUEST[str_license],"");
	$str_name = Fnc_Om_Conv_Default($_REQUEST[str_name],"");
	$str_mname = Fnc_Om_Conv_Default($_REQUEST[str_mname],"");
	$str_telep = Fnc_Om_Conv_Default($_REQUEST[str_telep1],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_telep2],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_telep3],"");
	$str_fax = Fnc_Om_Conv_Default($_REQUEST[str_fax1],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_fax2],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_fax3],"");
	$str_selnum = Fnc_Om_Conv_Default($_REQUEST[str_selnum],"");
	$str_toptitle = Fnc_Om_Conv_Default($_REQUEST[str_toptitle],"");
	$str_copyright = Fnc_Om_Conv_Default($_REQUEST[str_copyright],"");

	$imsi_str_logo = Fnc_Om_Conv_Default($_REQUEST[imsi_str_logo],"");
	$str_logo=$_FILES['str_logo']['tmp_name'];
	$str_logo_name=$_FILES['str_logo']['name'];

	$str_Add_Tag = $_SERVER[DOCUMENT_ROOT]."/admincenter/files/site/";

	if (!is_dir($str_Add_Tag)){
		mkdir($str_Add_Tag,0777);
	}

	switch($RetrieveFlag){
     	case "UPDATE" :

			if($str_logo){
				if (strcmp($str_logo,"none")) {
					if (Fnc_Om_File_Exp($str_logo_name)) {

						$imsi_img = $imsi_str_logo;
						$imsi_str_logo = Fnc_Om_File_Fexist($str_logo_name,$str_Add_Tag);

					   	if(!copy($str_logo,$str_Add_Tag.iconv( "UTF-8", "EUC-KR", $imsi_str_logo))){
						  	echo "UPLOAD_COPY_FAILURE";
						  	exit;
					   	}
					   	if(!unlink($str_logo)) {
						  	echo "임시파일을 삭제하는데 실패했습니다.";
						  	exit;
					   	}
					   	Fnc_Om_File_Delete($str_Add_Tag, $imsi_img);

					}else{
					   echo"
					   <script>
					   		window.alert('선택한 파일은 업로드가 금지되어 있습니다.');
					   		history.back()
					   </script>";
					   exit;
					}
				}
			}
			
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "STR_SITENAME";
			$arr_Column_Name[2]		= "STR_MEMAIL";
			$arr_Column_Name[3]		= "STR_SITEURL";
			$arr_Column_Name[4]		= "STR_COMPANY";
			$arr_Column_Name[5]		= "STR_ITEM1";
			$arr_Column_Name[6]		= "STR_ITEM2";
			$arr_Column_Name[7]		= "STR_POST";
			$arr_Column_Name[8]		= "STR_ADDR1";
			$arr_Column_Name[9]		= "STR_ADDR2";
			$arr_Column_Name[10]		= "STR_LICENSE";
			$arr_Column_Name[11]		= "STR_NAME";
			$arr_Column_Name[12]		= "STR_MNAME";
			$arr_Column_Name[13]		= "STR_TELEP";
			$arr_Column_Name[14]		= "STR_FAX";
			$arr_Column_Name[15]		= "STR_SELNUM";
			$arr_Column_Name[16]		= "STR_TOPTITLE";
			$arr_Column_Name[17]		= "STR_COPYRIGHT";
			$arr_Column_Name[18]		= "STR_LOGO";
			$arr_Column_Name[19]		= "DTM_INDATE";
			
			$arr_Set_Data[0]		= "1";
			$arr_Set_Data[1]		= $str_sitename;
			$arr_Set_Data[2]		= $str_memail;
			$arr_Set_Data[3]		= $str_siteurl;
			$arr_Set_Data[4]		= $str_company;
			$arr_Set_Data[5]		= $str_item1;
			$arr_Set_Data[6]		= $str_item2;
			$arr_Set_Data[7]		= $str_post;
			$arr_Set_Data[8]		= $str_addr1;
			$arr_Set_Data[9]		= $str_addr2;
			$arr_Set_Data[10]		= $str_license;
			$arr_Set_Data[11]		= $str_name;
			$arr_Set_Data[12]		= $str_mname;
			$arr_Set_Data[13]		= $str_telep;
			$arr_Set_Data[14]		= $str_fax;
			$arr_Set_Data[15]		= $str_selnum;
			$arr_Set_Data[16]		= $str_toptitle;
			$arr_Set_Data[17]		= $str_copyright;
			$arr_Set_Data[18]		= $imsi_str_logo;
			$arr_Set_Data[19]		= date("Y-m-d H:i:s");
			
			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";

			}

			$Sql_Query = "UPDATE `".$Tname."comm_site_info` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE INT_NUMBER='1' ";
			mysql_query($Sql_Query);

			?>
			<script language="javascript">
				window.location.href="site_info_edit.php";
			</script>
			<?
			exit;


	}


?>