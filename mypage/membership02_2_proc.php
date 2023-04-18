<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();

	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_esce = Fnc_Om_Conv_Default($_REQUEST[int_esce],"");
	$str_escont = Fnc_Om_Conv_Default($_REQUEST[str_escont],"");

	switch($RetrieveFlag){
		case "ESC" :
		
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "STR_CANCEL";
			$arr_Column_Name[1]		= "INT_ESCE";
			$arr_Column_Name[2]		= "STR_ESCONT";
			
			$arr_Set_Data[0]		= "1";
			$arr_Set_Data[1]		= $int_esce;
			$arr_Set_Data[2]		= $str_escont;

			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";
 
			}

			$Sql_Query = "UPDATE `".$Tname."comm_member_pay` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE STR_USERID='".$arr_Auth[0]."' AND INT_NUMBER='$str_no' ";
			mysql_query($Sql_Query);		
		
			?>
			<script language="javascript">
				alert("신청 되었습니다.");
				window.location.href = "membership.php";
			</script>
			<?
		
			exit;
			break;		

		case "CESC" :

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "STR_CANCEL";
			$arr_Column_Name[1]		= "INT_ESCE";
			$arr_Column_Name[2]		= "STR_ESCONT";
			
			$arr_Set_Data[0]		= "0";
			$arr_Set_Data[1]		= "0";
			$arr_Set_Data[2]		= "";

			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";
 
			}

			$Sql_Query = "UPDATE `".$Tname."comm_member_pay` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE STR_USERID='".$arr_Auth[0]."' AND INT_NUMBER='$str_no' ";
			mysql_query($Sql_Query);		
		
			?>
			<script language="javascript">
				alert("처리 되었습니다.");
				window.location.href = "membership.php";
			</script>
			<?

			exit;
			break;		
	}

?>
