<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
		$SQL_QUERY = "select ifnull(max(a.str_edate),'') as lastnumber from ".$Tname."comm_member_pay_info a inner join ".$Tname."comm_member_pay b on a.int_number=b.int_number where b.str_pass='0' and b.str_userid='joilya7' " ;
		$arr_max_Data=mysql_query($SQL_QUERY);
		$lastnumber = mysql_result($arr_max_Data,0,lastnumber);
		
		if ($lastnumber=="") {
			$day = date("Y-m-d");
			$lastnumber = date("Y-m-d", strtotime($day."-1day"));
			echo "a";
		}
		
		$lastnumber1=date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastnumber))."1day"));
		$lastnumber2=date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastnumber1))."1month"));
		$lastnumber3=date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastnumber2))."-1day"));

		echo $lastnumber1;
		
?>	