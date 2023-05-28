<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
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
	$int_dstart1 = Fnc_Om_Conv_Default($_REQUEST[int_dstart1],null);
	$int_dend1 = Fnc_Om_Conv_Default($_REQUEST[int_dend1],null);
	$int_discount1 = Fnc_Om_Conv_Default($_REQUEST[int_discount1],null);
	$int_dstart2 = Fnc_Om_Conv_Default($_REQUEST[int_dstart2],null);
	$int_dend2 = Fnc_Om_Conv_Default($_REQUEST[int_dend2],null);
	$int_discount2 = Fnc_Om_Conv_Default($_REQUEST[int_discount2],null);
	$int_dstart3 = Fnc_Om_Conv_Default($_REQUEST[int_dstart3],null);
	$int_dend3 = Fnc_Om_Conv_Default($_REQUEST[int_dend3],null);
	$int_discount3 = Fnc_Om_Conv_Default($_REQUEST[int_discount3],null);
	$int_dstart4 = Fnc_Om_Conv_Default($_REQUEST[int_dstart4],null);
	$int_dend4 = Fnc_Om_Conv_Default($_REQUEST[int_dend4],null);
	$int_discount4 = Fnc_Om_Conv_Default($_REQUEST[int_discount4],null);
	$int_dstart5 = Fnc_Om_Conv_Default($_REQUEST[int_dstart5],null);
	$int_dend5 = Fnc_Om_Conv_Default($_REQUEST[int_dend5],null);
	$int_discount5 = Fnc_Om_Conv_Default($_REQUEST[int_discount5],null);

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
			$arr_Column_Name[7]		= "INT_DSTART1";
			$arr_Column_Name[8]		= "INT_DEND1";
			$arr_Column_Name[9]		= "INT_DISCOUNT1";
			$arr_Column_Name[10]		= "INT_DSTART2";
			$arr_Column_Name[11]		= "INT_DEND2";
			$arr_Column_Name[12]		= "INT_DISCOUNT2";
			$arr_Column_Name[13]		= "INT_DSTART3";
			$arr_Column_Name[14]		= "INT_DEND3";
			$arr_Column_Name[15]		= "INT_DISCOUNT3";
			$arr_Column_Name[16]		= "INT_DSTART4";
			$arr_Column_Name[17]		= "INT_DEND4";
			$arr_Column_Name[18]		= "INT_DISCOUNT4";
			$arr_Column_Name[19]		= "INT_DSTART5";
			$arr_Column_Name[20]		= "INT_DEND5";
			$arr_Column_Name[21]		= "INT_DISCOUNT5";

			$arr_Set_Data[0]		= "1";
			$arr_Set_Data[1]		= $int_oprice1;
			$arr_Set_Data[2]		= $int_oprice2;
			$arr_Set_Data[3]		= $int_price1;
			$arr_Set_Data[4]		= $int_price2;
			$arr_Set_Data[5]		= $str_event1;
			$arr_Set_Data[6]		= $str_event2;
			$arr_Set_Data[7]		= $int_dstart1;
			$arr_Set_Data[8]		= $int_dend1;
			$arr_Set_Data[9]		= $int_discount1;
			$arr_Set_Data[10]		= $int_dstart2;
			$arr_Set_Data[11]		= $int_dend2;
			$arr_Set_Data[12]		= $int_discount2;
			$arr_Set_Data[13]		= $int_dstart3;
			$arr_Set_Data[14]		= $int_dend3;
			$arr_Set_Data[15]		= $int_discount3;
			$arr_Set_Data[16]		= $int_dstart4;
			$arr_Set_Data[17]		= $int_dend4;
			$arr_Set_Data[18]		= $int_discount4;
			$arr_Set_Data[19]		= $int_dstart5;
			$arr_Set_Data[20]		= $int_dend5;
			$arr_Set_Data[21]		= $int_discount5;
			
			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				if (!isset($arr_Set_Data[$int_I])) {
					continue;
				}

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