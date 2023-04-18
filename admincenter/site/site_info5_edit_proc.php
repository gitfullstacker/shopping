<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'],"");

	$str_url1 = Fnc_Om_Conv_Default($_REQUEST['str_url1'],"");
	$str_url2 = Fnc_Om_Conv_Default($_REQUEST['str_url2'],"");

	switch($RetrieveFlag){
     	case "UPDATE" :
			
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "STR_URL1";
			$arr_Column_Name[2]		= "STR_URL2";

			$arr_Set_Data[0]		= "1";
			$arr_Set_Data[1]		= $str_url1;
			$arr_Set_Data[2]		= $str_url2;
			
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
				window.location.href="site_info5_edit.php";
			</script>
			<?
			exit;


	}


?>