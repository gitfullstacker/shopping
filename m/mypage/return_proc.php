<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();

	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$str_rno = Fnc_Om_Conv_Default($_REQUEST[str_rno],"");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_post = Fnc_Om_Conv_Default($_REQUEST[str_post],"");
	$str_addr1 = Fnc_Om_Conv_Default($_REQUEST[str_addr1],"");
	$str_addr2 = Fnc_Om_Conv_Default($_REQUEST[str_addr2],"");
	$str_place1 = Fnc_Om_Conv_Default($_REQUEST[str_place1],"");
	$str_place2 = Fnc_Om_Conv_Default($_REQUEST[str_place2],"");
	$str_method = Fnc_Om_Conv_Default($_REQUEST[str_method],"");
	$str_rdate = Fnc_Om_Conv_Default($_REQUEST[str_rdate],"");
	$str_rmemo = Fnc_Om_Conv_Default($_REQUEST[str_rmemo],"");

	switch($RetrieveFlag){
     	case "LOG" :
			if ($arr_Auth[0]=="") {
				echo "0";
			} else {
				echo "1＾";
			}
		
			exit;
			break;
     	case "EXCHANGE" :
     		
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "STR_RPOST";
			$arr_Column_Name[1]		= "STR_RADDR1";
			$arr_Column_Name[2]		= "STR_RADDR2";
			$arr_Column_Name[3]		= "STR_METHOD";
			$arr_Column_Name[4]		= "STR_RDATE";
			$arr_Column_Name[5]		= "STR_RMEMO";
			$arr_Column_Name[6]		= "INT_STATE";
			
			$arr_Set_Data[0]		= $str_post;
			$arr_Set_Data[1]		= $str_addr1;
			$arr_Set_Data[2]		= $str_addr2;
			$arr_Set_Data[3]		= $str_method;
			$arr_Set_Data[4]		= $str_rdate;
			$arr_Set_Data[5]		= $str_rmemo;
			$arr_Set_Data[6]		= "5";

			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";

			}

			$Sql_Query = "UPDATE `".$Tname."comm_goods_cart` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE INT_NUMBER='".$str_rno."' ";
			mysql_query($Sql_Query);
			
			
			//교환될 상품
			if ($str_no!="") {
			
				$arr_Set_Data= Array();
				$arr_Column_Name = Array();
				
				$arr_Column_Name[0]		= "STR_POST";
				$arr_Column_Name[1]		= "STR_ADDR1";
				$arr_Column_Name[2]		= "STR_ADDR2";
				$arr_Column_Name[3]		= "STR_PLACE1";
				$arr_Column_Name[4]		= "STR_PLACE2";
				$arr_Column_Name[5]		= "STR_MEMO";
				$arr_Column_Name[6]		= "INT_STATE";
				
				$arr_Set_Data[0]		= $str_post;
				$arr_Set_Data[1]		= $str_addr1;
				$arr_Set_Data[2]		= $str_addr2;
				$arr_Set_Data[3]		= $str_place1;
				$arr_Set_Data[4]		= $str_place2;
				$arr_Set_Data[5]		= $str_memo;
				$arr_Set_Data[6]		= "1";
	
				$arr_Sub = "";
	
				for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {
	
					If  ($int_I != 0) {
						$arr_Sub .=  ",";
					}
					$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";
	
				}
	
				$Sql_Query = "UPDATE `".$Tname."comm_goods_cart` SET ";
				$Sql_Query .= $arr_Sub;
				$Sql_Query .= " WHERE INT_NUMBER='".$str_no."' ";
				mysql_query($Sql_Query);
			
			}
			//교환될 상품
		
			?>
			<script language="javascript">
				window.location.href="/m/mypage/get.php";
			</script>
			<?
		
			exit;
			break;
			
     	case "EXRETURN" :
     		
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "STR_RPOST";
			$arr_Column_Name[1]		= "STR_RADDR1";
			$arr_Column_Name[2]		= "STR_RADDR2";
			$arr_Column_Name[3]		= "STR_METHOD";
			$arr_Column_Name[4]		= "STR_RDATE";
			$arr_Column_Name[5]		= "STR_RMEMO";
			$arr_Column_Name[6]		= "INT_STATE";
			
			$arr_Set_Data[0]		= $str_post;
			$arr_Set_Data[1]		= $str_addr1;
			$arr_Set_Data[2]		= $str_addr2;
			$arr_Set_Data[3]		= $str_method;
			$arr_Set_Data[4]		= $str_rdate;
			$arr_Set_Data[5]		= $str_rmemo;
			$arr_Set_Data[6]		= "5";

			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";

			}

			$Sql_Query = "UPDATE `".$Tname."comm_goods_cart` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE INT_NUMBER='".$str_rno."' ";
			mysql_query($Sql_Query);
			
		
			?>
			<script language="javascript">
				window.location.href="/m/mypage/get.php";
			</script>
			<?
		
			exit;
			break;

			
	}
?>
