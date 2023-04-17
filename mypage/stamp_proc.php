<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
	
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$int_prod = Fnc_Om_Conv_Default($_REQUEST[int_prod],"");
	$int_ustamp = Fnc_Om_Conv_Default($_REQUEST[int_ustamp],"0");

	switch($RetrieveFlag){
     	case "LOG" :
			if ($arr_Auth[0]=="") {
				echo "0";
			} else {
				echo "1＾";
			}
		
			exit;
			break;
			
     	case "BUY" :
     	
			if ($int_ustamp > Fnc_Om_Stamp($arr_Auth[0])) {
				echo "0";
				exit;
			} else {
			
				$arr_Set_Data= Array();
				$arr_Column_Name = Array();
				
				$arr_Column_Name[0]		= "INT_NUMBER";
				$arr_Column_Name[1]		= "STR_USERID";
				$arr_Column_Name[2]		= "INT_PROD";
				$arr_Column_Name[3]		= "DTM_INDATE";
				$arr_Column_Name[4]		= "STR_PASS";
				
				$SQL_QUERY = "select ifnull(max(int_number),0)+1 as lastnumber from ".$Tname."comm_stamp_order " ;
				$arr_max_Data=mysql_query($SQL_QUERY);
				$lastnumber = mysql_result($arr_max_Data,0,lastnumber);
				
				$arr_Set_Data[0]		= $lastnumber;
				$arr_Set_Data[1]		= $arr_Auth[0];
				$arr_Set_Data[2]		= $int_prod;
				$arr_Set_Data[3]		= date("Y-m-d H:i:s");
				$arr_Set_Data[4]		= "0";
	
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
				
				$SQL_QUERY =	" SELECT
								A.*
							FROM "
								.$Tname."comm_stamp_prod AS A
							WHERE
								A.INT_PROD='$int_prod' ";
		
				$arr_Rlt_Data=mysql_query($SQL_QUERY);
				if (!$arr_Rlt_Data) {
		    		echo 'Could not run query: ' . mysql_error();
		    		exit;
				}
				$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
				
				
				
				$Sql_Query = "INSERT INTO `".$Tname."comm_stamp_order` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
				mysql_query($Sql_Query);
				
				Fnc_Om_Stamp_In($arr_Auth[0],"5","-".$int_ustamp,"스탬프상품[".$arr_Data['STR_PROD']."]구매");
				
				echo "1";
				exit;
				
			}
		
			exit;
			break;
			

			
	}
?>
