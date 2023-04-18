<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_option = Fnc_Om_Conv_Default($_REQUEST[str_option],"");
	$int_aprice = Fnc_Om_Conv_Default($_REQUEST[int_aprice],"0");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(int_number),0)+1 as lastnumber from ".$Tname."comm_goods_option_value " ;
			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "INT_GUBUN";
			$arr_Column_Name[2]		= "STR_GOODCODE";
			$arr_Column_Name[3]		= "STR_OPTION";
			$arr_Column_Name[4]		= "INT_APRICE";
			$arr_Column_Name[5]		= "DTM_INDATE";

			$arr_Set_Data[0]		= $lastnumber;
			$arr_Set_Data[1]		= $int_gubun;
			$arr_Set_Data[2]		= $str_goodcode;
			$arr_Set_Data[3]		= $str_option;
			$arr_Set_Data[4]		= $int_aprice;
			$arr_Set_Data[5]		= date("Y-m-d H:i:s");

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

			$Sql_Query = "INSERT INTO `".$Tname."comm_goods_option_value` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
			mysql_query($Sql_Query);
			
			?>
			<script language="javascript">
				window.location.href="good_option_edit.php?page=1&int_gubun=<?=$int_gubun?>&str_goodcode=<?=$str_goodcode?>";
			</script>
			<?
			exit;
			break;
			
     	case "UPDATE" :

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "INT_GUBUN";
			$arr_Column_Name[2]		= "STR_GOODCODE";
			$arr_Column_Name[3]		= "STR_OPTION";
			$arr_Column_Name[4]		= "INT_APRICE";

			$arr_Set_Data[0]		= $str_no;
			$arr_Set_Data[1]		= $int_gubun;
			$arr_Set_Data[2]		= $str_goodcode;
			$arr_Set_Data[3]		= $str_option;
			$arr_Set_Data[4]		= $int_aprice;

			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";

			}

			$Sql_Query = "UPDATE `".$Tname."comm_goods_option_value` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE INT_NUMBER='".$str_no."' ";
			mysql_query($Sql_Query);
			
			?>
			<script language="javascript">
				window.location.href="good_option_edit.php?page=<?=$page?>&int_gubun=<?=$int_gubun?>&str_goodcode=<?=$str_goodcode?>";
			</script>
			<?
			exit;
			break;
			
		case "DELETE" :
		
			$SQL_QUERY = "DELETE FROM ".$Tname."comm_goods_option_value WHERE STR_GOODCODE='$str_goodcode' AND INT_NUMBER='$str_no' ";
			mysql_query($SQL_QUERY);
			?>
			<script language="javascript">
				window.location.href="good_option_edit.php?page=1&int_gubun=<?=$int_gubun?>&str_goodcode=<?=$str_goodcode?>";
			</script>
			<?
			exit;
			break;
	
			
	}
?>