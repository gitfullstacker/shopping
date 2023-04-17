<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();

	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	switch($RetrieveFlag){
     	case "LOG" :
			if ($arr_Auth[0]=="") {
				echo "0";
			} else {
				echo "1＾";
			}
		
			exit;
			break;
			
     	case "UPDATE" :
     	
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_STATE";
			
			$arr_Set_Data[0]		= "0";

			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";

			}

			$Sql_Query = "UPDATE `".$Tname."comm_goods_cart` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE INT_NUMBER='".$str_no."' AND STR_USERID='".$arr_Auth[0]."' ";
			mysql_query($Sql_Query);
			
			echo "1";
		
			exit;
			break;
			
	}
?>
