<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");

	$int_stamp1 = Fnc_Om_Conv_Default($_REQUEST[int_stamp1],"0");
	$int_stamp2 = Fnc_Om_Conv_Default($_REQUEST[int_stamp2],"0");
	$int_stamp3 = Fnc_Om_Conv_Default($_REQUEST[int_stamp3],"0");
	$int_stamp4 = Fnc_Om_Conv_Default($_REQUEST[int_stamp4],"0");

	switch($RetrieveFlag){
     	case "UPDATE" :
			
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "INT_STAMP1";
			$arr_Column_Name[2]		= "INT_STAMP2";
			$arr_Column_Name[3]		= "INT_STAMP3";
			$arr_Column_Name[4]		= "INT_STAMP4";

			$arr_Set_Data[0]		= "1";
			$arr_Set_Data[1]		= $int_stamp1;
			$arr_Set_Data[2]		= $int_stamp2;
			$arr_Set_Data[3]		= $int_stamp3;
			$arr_Set_Data[4]		= $int_stamp4;
			
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
				window.location.href="site_info3_edit.php";
			</script>
			<?
			exit;


	}


?>