<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();

	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_spost = Fnc_Om_Conv_Default($_REQUEST[str_spost],"");
	$str_saddr1 = Fnc_Om_Conv_Default($_REQUEST[str_saddr1],"");
	$str_saddr2 = Fnc_Om_Conv_Default($_REQUEST[str_saddr2],"");
	$str_splace1 = Fnc_Om_Conv_Default($_REQUEST[str_splace1],"");
	$str_splace2 = Fnc_Om_Conv_Default($_REQUEST[str_splace2],"");

	switch($RetrieveFlag){
		case "UPDATE" :

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "STR_SPOST";
			$arr_Column_Name[1]		= "STR_SADDR1";
			$arr_Column_Name[2]		= "STR_SADDR2";
			$arr_Column_Name[3]		= "STR_SPLACE1";
			$arr_Column_Name[4]		= "STR_SPLACE2";
			
			$arr_Set_Data[0]		= $str_spost;
			$arr_Set_Data[1]		= $str_saddr1;
			$arr_Set_Data[2]		= $str_saddr2;			
			$arr_Set_Data[3]		= $str_splace1;
			$arr_Set_Data[4]		= $str_splace2;

			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";
 
			}

			$Sql_Query = "UPDATE `".$Tname."comm_member` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE STR_USERID='".$arr_Auth[0]."' ";
			mysql_query($Sql_Query);

			?>
			<script language="javascript">
				alert("정상 수정되었습니다.");
				parent.document.frm.action = "membership02_1.php";
				parent.document.frm.target = "_self";
				parent.document.frm.submit();
			</script>
			<?
			exit;
			break;

		case "ES1" :
		
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "STR_CANCEL";
			
			$arr_Set_Data[0]		= "1";

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
				parent.document.frm.action = "membership02_1.php";
				parent.document.frm.target = "_self";
				parent.document.frm.submit();
			</script>
			<?
		
			exit;
			break;		

	}

?>
