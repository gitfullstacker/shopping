<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"1");
	$str_title = Fnc_Om_Conv_Default($_REQUEST[str_title],"");
	$int_xpoint = Fnc_Om_Conv_Default($_REQUEST[int_xpoint],"0");
	$int_ypoint = Fnc_Om_Conv_Default($_REQUEST[int_ypoint],"0");
	$int_xsize = Fnc_Om_Conv_Default($_REQUEST[int_xsize],"100");
	$int_ysize = Fnc_Om_Conv_Default($_REQUEST[int_ysize],"100");
	$str_sdate = Fnc_Om_Conv_Default($_REQUEST[str_sdate],"");
	$str_edate = Fnc_Om_Conv_Default($_REQUEST[str_edate],"");
	$str_contents = Fnc_Om_Conv_Default($_REQUEST[str_contents],"");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :
     	
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "INT_GUBUN";
			$arr_Column_Name[2]		= "STR_TITLE";
			$arr_Column_Name[3]		= "INT_XPOINT";
			$arr_Column_Name[4]		= "INT_YPOINT";
			$arr_Column_Name[5]		= "INT_XSIZE";
			$arr_Column_Name[6]		= "INT_YSIZE";
			$arr_Column_Name[7]		= "STR_SDATE";
			$arr_Column_Name[8]		= "STR_EDATE";
			$arr_Column_Name[9]		= "STR_CONTENTS";
			$arr_Column_Name[10]		= "DTM_INDATE";
			$arr_Column_Name[11]		= "DTM_MODATE";
			$arr_Column_Name[12]		= "STR_INUSERID";
			$arr_Column_Name[13]		= "STR_MOUSERID";
			$arr_Column_Name[14]		= "STR_SERVICE";


			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_popup_info a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);
			
			$arr_Set_Data[0]		= $lastnumber;
			$arr_Set_Data[1]		= $int_gubun;
			$arr_Set_Data[2]		= $str_title;
			$arr_Set_Data[3]		= $int_xpoint;
			$arr_Set_Data[4]		= $int_ypoint;
			$arr_Set_Data[5]		= $int_xsize;
			$arr_Set_Data[6]		= $int_ysize;
			$arr_Set_Data[7]		= $str_sdate;
			$arr_Set_Data[8]		= $str_edate;
			$arr_Set_Data[9]		= $str_contents;
			$arr_Set_Data[10]		= date("Y-m-d H:i:s");
			$arr_Set_Data[11]		= date("Y-m-d H:i:s");
			$arr_Set_Data[12]		= $arr_Auth[0];
			$arr_Set_Data[13]		= $arr_Auth[0];
			$arr_Set_Data[14]		= $str_service;
			
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
			
			$Sql_Query = "INSERT INTO `".$Tname."comm_popup_info` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
			mysql_query($Sql_Query);

			?>
			<script language="javascript">
				window.location.href="popu_popup_edit.php?RetrieveFlag=UPDATE&int_gubun=<?=$int_gubun?>&str_no=<?=$lastnumber?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "INT_GUBUN";
			$arr_Column_Name[2]		= "STR_TITLE";
			$arr_Column_Name[3]		= "INT_XPOINT";
			$arr_Column_Name[4]		= "INT_YPOINT";
			$arr_Column_Name[5]		= "INT_XSIZE";
			$arr_Column_Name[6]		= "INT_YSIZE";
			$arr_Column_Name[7]		= "STR_SDATE";
			$arr_Column_Name[8]		= "STR_EDATE";
			$arr_Column_Name[9]		= "STR_CONTENTS";
			$arr_Column_Name[10]		= "DTM_MODATE";
			$arr_Column_Name[11]		= "STR_MOUSERID";
			$arr_Column_Name[12]		= "STR_SERVICE";
			
			$arr_Set_Data[0]		= $str_no;
			$arr_Set_Data[1]		= $int_gubun;
			$arr_Set_Data[2]		= $str_title;
			$arr_Set_Data[3]		= $int_xpoint;
			$arr_Set_Data[4]		= $int_ypoint;
			$arr_Set_Data[5]		= $int_xsize;
			$arr_Set_Data[6]		= $int_ysize;
			$arr_Set_Data[7]		= $str_sdate;
			$arr_Set_Data[8]		= $str_edate;
			$arr_Set_Data[9]		= $str_contents;
			$arr_Set_Data[10]		= date("Y-m-d H:i:s");
			$arr_Set_Data[11]		= $arr_Auth[0];
			$arr_Set_Data[12]		= $str_service;
			
			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";

			}

			$Sql_Query = "UPDATE `".$Tname."comm_popup_info` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE INT_NUMBER='".$str_no."' ";
			mysql_query($Sql_Query);
			?>
			<script language="javascript">
				window.location.href="popu_popup_edit.php?RetrieveFlag=UPDATE&int_gubun=<?=$int_gubun?>&str_no=<?=$str_no?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_popup_info WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="popu_popup_list.php?int_gubun=<?=$int_gubun?>";
			</script>
			<?
			exit;
			break;

	}

?>
