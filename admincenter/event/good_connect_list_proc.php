<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_sgoodcode = Fnc_Om_Conv_Default($_REQUEST[str_sgoodcode],"");
	$page1 = Fnc_Om_Conv_Default($_REQUEST[page1],1);
	$page2 = Fnc_Om_Conv_Default($_REQUEST[page2],1);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_number = Fnc_Om_Conv_Default($_REQUEST[int_number],"");

	switch($RetrieveFlag){
     	case "INSERT" :
     	
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "STR_GOODCODE";

			$arr_Set_Data[0]		= $int_number;
			$arr_Set_Data[1]		= $str_no;

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

			$Sql_Query = "INSERT INTO `".$Tname."comm_event_link` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
			mysql_query($Sql_Query);
			
			?>
			<script language="javascript">
				window.location.href="good_connect_list.php?page1=<?=$page1?>&page2=<?=$page2?>&int_number=<?=$int_number?>";
			</script>
			<?
			exit;
			break;
			
		case "DELETE" :
		
			$SQL_QUERY = "DELETE FROM ".$Tname."comm_event_link WHERE INT_NUMBER='$int_number' AND STR_GOODCODE='$str_no' ";
			mysql_query($SQL_QUERY);
			?>
			<script language="javascript">
				window.location.href="good_connect_list.php?page1=<?=$page1?>&page2=<?=$page2?>&int_number=<?=$int_number?>";
			</script>
			<?
			exit;
			break;
			
	}
?>