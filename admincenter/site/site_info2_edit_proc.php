<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");

	$int_oprice1 = Fnc_Om_Conv_Default($_REQUEST[int_oprice1],"0");
	$int_oprice2 = Fnc_Om_Conv_Default($_REQUEST[int_oprice2],"0");
	$int_price1 = Fnc_Om_Conv_Default($_REQUEST[int_price1],"0");
	$int_price2 = Fnc_Om_Conv_Default($_REQUEST[int_price2],"0");
	$str_event1 = Fnc_Om_Conv_Default($_REQUEST[str_event1],"");
	$str_event2 = Fnc_Om_Conv_Default($_REQUEST[str_event2],"");

	switch($RetrieveFlag){
     	case "UPDATE" :
			
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "INT_OPRICE1";
			$arr_Column_Name[2]		= "INT_OPRICE2";
			$arr_Column_Name[3]		= "INT_PRICE1";
			$arr_Column_Name[4]		= "INT_PRICE2";
			$arr_Column_Name[5]		= "STR_EVENT1";
			$arr_Column_Name[6]		= "STR_EVENT2";

			$arr_Set_Data[0]		= "1";
			$arr_Set_Data[1]		= $int_oprice1;
			$arr_Set_Data[2]		= $int_oprice2;
			$arr_Set_Data[3]		= $int_price1;
			$arr_Set_Data[4]		= $int_price2;
			$arr_Set_Data[5]		= $str_event1;
			$arr_Set_Data[6]		= $str_event2;
			
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
				window.location.href="site_info2_edit.php";
			</script>
			<?
			exit;


	}


?>