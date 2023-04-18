<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_userid = Fnc_Om_Conv_Default($_REQUEST[str_userid],"");
	$str_gubun = Fnc_Om_Conv_Default($_REQUEST[str_gubun],"1");
	$int_stamp = Fnc_Om_Conv_Default($_REQUEST[int_stamp],"0");
	$str_cont = Fnc_Om_Conv_Default($_REQUEST[str_cont],"");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_member_stamp a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_member_stamp (";
					$SQL_QUERY .= " INT_NUMBER,STR_USERID,STR_GUBUN,INT_STAMP,STR_CONT,DTM_INDATE
											) VALUES (
												'$lastnumber','$str_userid','$str_gubun','$int_stamp','$str_cont','".date("Y-m-d H:i:s")."'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="memb_user_stamp_edit.php?RetrieveFlag=UPDATE&str_userid=<?=$str_userid?>&str_no=<?=$lastnumber?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_member_stamp SET ";
								$SQL_QUERY .= "STR_GUBUN='$str_gubun'
									,INT_STAMP='$int_stamp'
									,STR_CONT='$str_cont'
								WHERE
									INT_NUMBER='$str_no' ";

			$result=mysql_query($SQL_QUERY);
			?>
			<script language="javascript">
				window.location.href="memb_user_stamp_edit.php?RetrieveFlag=UPDATE&str_userid=<?=$str_userid?>&str_no=<?=$str_no?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_member_stamp WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="memb_user_stamp_list.php?str_userid=<?=$str_userid?>";
			</script>
			<?
			exit;
			break;

	}

?>
