<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag], "");
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode], "");

switch ($RetrieveFlag) {
	case "LOG":
		if ($arr_Auth[0] == "") {
			echo "0";
		} else {
			echo "1＾";
		}

		exit;
		break;

	case "INSERT":

		$SQL_QUERY = "SELECT A.* FROM " . $Tname . "comm_member_like A WHERE A.STR_USERID='" . $arr_Auth[0] . "' AND A.STR_GOODCODE='" . $str_goodcode . "' ";
		$arr_Data = mysql_query($SQL_QUERY);
		$arr_Data_Cnt = mysql_num_rows($arr_Data);

		$SQL_QUERY = "select ifnull(count(A.str_userid),0) as cnt FROM " . $Tname . "comm_member_like A WHERE A.STR_GOODCODE='" . $str_goodcode . "' ";
		$arr_max_Data = mysql_query($SQL_QUERY);
		$Cnt = mysql_result($arr_max_Data, 0, cnt);


		if ($arr_Data_Cnt) {
			echo "1＾" . $Cnt;
		} else {


			$arr_Set_Data = array();
			$arr_Column_Name = array();

			$arr_Column_Name[0]		= "STR_USERID";
			$arr_Column_Name[1]		= "STR_GOODCODE";

			$arr_Set_Data[0]		= $arr_Auth[0];
			$arr_Set_Data[1]		= $str_goodcode;

			$arr_Sub1 = "";
			$arr_Sub2 = "";

			for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

				if ($int_I != 0) {
					$arr_Sub1 .=  ",";
					$arr_Sub2 .=  ",";
				}
				$arr_Sub1 .=  $arr_Column_Name[$int_I];
				$arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";
			}

			$Sql_Query = "INSERT INTO `" . $Tname . "comm_member_like` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
			mysql_query($Sql_Query);


			echo "2＾" . $Cnt;
		}

		exit;
		break;

	case "CART":

		if (fnc_pay_info() == 0) {
			echo "-1＾0";
			exit;
		}


		if (fnc_cart_info($str_goodcode) == 0) {
			echo "00＾";
			exit;
		} else {

			$int_state = "0";

			$SQL_QUERY = "select ifnull(count(int_number),0) as lastnumber from " . $Tname . "comm_goods_cart where str_userid='$arr_Auth[0]' and int_state in ('1','2','3','4','5') ";
			$arr_max_Data = mysql_query($SQL_QUERY);
			$mTcnt = mysql_result($arr_max_Data, 0, lastnumber);

			if ($mTcnt > 0) {

				$Sql_Query =	" SELECT 
									A.*
								FROM `"
					. $Tname . "comm_goods_cart` AS A
								WHERE
									A.str_userid='$arr_Auth[0]' and A.int_state in ('1','2','3','4','5') 
								ORDER BY
									A.INT_NUMBER DESC LIMIT 1 ";

				$arr_Rlt_Data = mysql_query($Sql_Query);
				if (!$arr_Rlt_Data) {
					echo 'Could not run query: ' . mysql_error();
					exit;
				}
				$arr_Data3 = mysql_fetch_assoc($arr_Rlt_Data);

				if ($arr_Data3['INT_STATE'] != "4" && $arr_Data3['INT_STATE'] != "5") {
					echo $arr_Data3['INT_STATE'] . "＾";
					exit;
				} else {
					$int_state = $arr_Data3['INT_STATE'];
				}
			}


			$SQL_QUERY = "select ifnull(max(int_number),0)+1 as lastnumber from " . $Tname . "comm_goods_cart where int_number like '" . date("Ymd") . "%' ";
			$arr_max_Data = mysql_query($SQL_QUERY);
			$lastnumber = date("Ymd") . Fnc_Om_Add_Zero(right(mysql_result($arr_max_Data, 0, lastnumber), 7), 7);

			$SQL_QUERY = "select a.str_sgoodcode from " . $Tname . "comm_goods_master_sub a where a.str_goodcode='$str_goodcode' and a.str_service='Y' and a.str_sgoodcode not in (select b.str_sgoodcode from " . $Tname . "comm_goods_cart b where b.str_goodcode='$str_goodcode' and (b.int_state<>'0' and b.int_state<>'10' and b.int_state<>'11')) order by a.str_sgoodcode asc limit 1 ";
			$arr_max_Data = mysql_query($SQL_QUERY);
			$str_sgoodcode = mysql_result($arr_max_Data, 0, str_sgoodcode);

			$Sql_Query =	" SELECT 
									B.*, A.STR_PTYPE
								FROM 
									`" . $Tname . "comm_member_pay` AS A
								INNER JOIN
									`" . $Tname . "comm_member_pay_info` AS B
								ON
									A.INT_NUMBER=B.INT_NUMBER
									AND date_format(B.STR_SDATE, '%Y-%m-%d') <= '" . date("Y-m-d") . "'
									AND date_format(B.STR_EDATE, '%Y-%m-%d') >= '" . date("Y-m-d") . "' 
									AND A.STR_USERID='$arr_Auth[0]' ";

			$arr_Rlt_Data = mysql_query($Sql_Query);
			if (!$arr_Rlt_Data) {
				echo 'Could not run query: ' . mysql_error();
				exit;
			}
			$arr_Data2 = mysql_fetch_assoc($arr_Rlt_Data);

			$arr_Set_Data = array();
			$arr_Column_Name = array();

			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "STR_USERID";
			$arr_Column_Name[2]		= "STR_NAME";
			$arr_Column_Name[3]		= "STR_POST";
			$arr_Column_Name[4]		= "STR_ADDR1";
			$arr_Column_Name[5]		= "STR_ADDR2";
			$arr_Column_Name[6]		= "STR_PLACE1";
			$arr_Column_Name[7]		= "STR_PLACE2";
			$arr_Column_Name[8]		= "STR_MEMO";
			$arr_Column_Name[9]		= "STR_GOODCODE";
			$arr_Column_Name[10]		= "STR_SGOODCODE";
			$arr_Column_Name[11]		= "STR_SDATE";
			$arr_Column_Name[12]		= "STR_EDATE";
			$arr_Column_Name[13]		= "DTM_INDATE";
			$arr_Column_Name[14]		= "INT_STATE";
			$arr_Column_Name[15]		= "STR_RPOST";
			$arr_Column_Name[16]		= "STR_RADDR1";
			$arr_Column_Name[17]		= "STR_RADDR2";
			$arr_Column_Name[18]		= "STR_METHOD";
			$arr_Column_Name[19]		= "STR_RDATE";
			$arr_Column_Name[20]		= "STR_RMEMO";

			$arr_Set_Data[0]		= $lastnumber;
			$arr_Set_Data[1]		= $arr_Auth[0];
			$arr_Set_Data[2]		= $arr_Auth[2];
			$arr_Set_Data[3]		= "";
			$arr_Set_Data[4]		= "";
			$arr_Set_Data[5]		= "";
			$arr_Set_Data[6]		= "";
			$arr_Set_Data[7]		= "";
			$arr_Set_Data[8]		= "";
			$arr_Set_Data[9]		= $str_goodcode;
			$arr_Set_Data[10]		= $str_sgoodcode;
			$arr_Set_Data[11]		= date("Y-m-d");

			if ($arr_Data2['STR_PTYPE'] == "1") {
				$lastnumber1 = date("Y-m-d");
				$lastnumber2 = date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastnumber1)) . "1month"));
				$lastnumber3 = date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastnumber2)) . "-1day"));
				$str_edate = $lastnumber3;
			} else {
				$str_edate = $arr_Data2['STR_EDATE'];
			}

			$arr_Set_Data[12]		= $str_edate;
			$arr_Set_Data[13]		= date("Y-m-d H:i:s");
			$arr_Set_Data[14]		= "0";
			$arr_Set_Data[15]		= "";
			$arr_Set_Data[16]		= "";
			$arr_Set_Data[17]		= "";
			$arr_Set_Data[18]		= "";
			$arr_Set_Data[19]		= "";
			$arr_Set_Data[20]		= "";

			$arr_Sub1 = "";
			$arr_Sub2 = "";

			for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

				if ($int_I != 0) {
					$arr_Sub1 .=  ",";
					$arr_Sub2 .=  ",";
				}
				$arr_Sub1 .=  $arr_Column_Name[$int_I];
				$arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";
			}

			$Sql_Query = "INSERT INTO `" . $Tname . "comm_goods_cart` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
			mysql_query($Sql_Query);

			echo $int_state . "＾" . $lastnumber;
		}

		exit;
		break;

	case "ALARM":

		$SQL_QUERY = "select ifnull(count(int_number),0) as lastnumber from " . $Tname . "comm_member_alarm where str_userid='$arr_Auth[0]' and str_goodcode='$str_goodcode' ";
		$arr_max_Data = mysql_query($SQL_QUERY);
		$mTcnt = mysql_result($arr_max_Data, 0, lastnumber);

		if ($mTcnt > 0) {
			echo "0＾0";
			exit;
		} else {

			$SQL_QUERY = "select ifnull(count(int_number),0) as lastnumber from " . $Tname . "comm_member_alarm where str_userid='$arr_Auth[0]' ";
			$arr_max_Data = mysql_query($SQL_QUERY);
			$Tcnt = mysql_result($arr_max_Data, 0, lastnumber);

			if ($Tcnt >= 3) {

				echo "-1＾" . $Tcnt;
				exit;
			} else {

				$SQL_QUERY = "select ifnull(count(int_number),0) as lastnumber from " . $Tname . "comm_member_alarm where str_goodcode='$str_goodcode' ";
				$arr_max_Data = mysql_query($SQL_QUERY);
				$mTcnt = mysql_result($arr_max_Data, 0, lastnumber);

				echo "1＾" . $mTcnt;
				exit;
			}
		}


		exit;
		break;

	case "ALARMIN":

		$SQL_QUERY = "select ifnull(count(int_number),0) as lastnumber from " . $Tname . "comm_member_alarm where str_userid='$arr_Auth[0]' and str_goodcode='$str_goodcode' ";
		$arr_max_Data = mysql_query($SQL_QUERY);
		$mTcnt = mysql_result($arr_max_Data, 0, lastnumber);

		if ($mTcnt > 0) {
			echo "0";
			exit;
		} else {

			$arr_Set_Data = array();
			$arr_Column_Name = array();

			$arr_Column_Name[0]		= "STR_GOODCODE";
			$arr_Column_Name[1]		= "INT_NUMBER";
			$arr_Column_Name[2]		= "STR_USERID";
			$arr_Column_Name[3]		= "DTM_INDATE";

			$SQL_QUERY = "select ifnull(max(int_number),0)+1 as lastnumber from " . $Tname . "comm_member_alarm where str_goodcode='$str_goodcode' ";
			$arr_max_Data = mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data, 0, lastnumber);

			$arr_Set_Data[0]		= $str_goodcode;
			$arr_Set_Data[1]		= $lastnumber;
			$arr_Set_Data[2]		= $arr_Auth[0];
			$arr_Set_Data[3]		= date("Y-m-d H:i:s");

			$arr_Sub1 = "";
			$arr_Sub2 = "";

			for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

				if ($int_I != 0) {
					$arr_Sub1 .=  ",";
					$arr_Sub2 .=  ",";
				}
				$arr_Sub1 .=  $arr_Column_Name[$int_I];
				$arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";
			}

			$Sql_Query = "INSERT INTO `" . $Tname . "comm_member_alarm` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
			mysql_query($Sql_Query);

			echo "1";
			exit;
		}


		exit;
		break;
}
?>
