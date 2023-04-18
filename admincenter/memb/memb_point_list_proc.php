<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_userid = Fnc_Om_Conv_Default($_REQUEST[str_userid],"");
	$int_point = Fnc_Om_Conv_Default($_REQUEST[int_point],"0");
	$str_contents = Fnc_Om_Conv_Default($_REQUEST[str_contents],"");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"Y");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_member_point a " ;

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_member_point (";
					$SQL_QUERY .= "INT_NUMBER, STR_USERiD, INT_POINT, STR_CONTENTS
												,DTM_INDATE, STR_SERVICE
											) VALUES (
												'$lastnumber','$str_userid','$int_point','$str_contents'
												,'".date("Y-m-d H:i:s")."','$str_service'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="memb_point_list.php?page=1&str_userid=<?=$str_userid?>";
			</script>
			<?
			break;

		case "DELETE" :

			$SQL_QUERY =	"DELETE FROM ".$Tname."comm_member_point WHERE INT_NUMBER='$str_no' ";
			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="memb_point_list.php?page=1&str_userid=<?=$str_userid?>";
			</script>
			<?
			break;

	}
?>