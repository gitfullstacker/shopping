<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_sex = Fnc_Om_Conv_Default($_REQUEST[str_sex],"1");
	$str_email = Fnc_Om_Conv_Default($_REQUEST[str_email],"");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_newsle_info a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_newsle_info (";
					$SQL_QUERY .= " INT_NUMBER,STR_SEX,STR_EMAIL,DTM_INDATE
											) VALUES (
												'$lastnumber','$str_sex','$str_email','".date("Y-m-d H:i:s")."'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="news_news_edit.php?RetrieveFlag=UPDATE&str_no=<?=$lastnumber?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_newsle_info SET ";
								$SQL_QUERY .= "STR_SEX='$str_sex'
									,STR_EMAIL='$str_email'
								WHERE
									INT_NUMBER='$str_no' ";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="news_news_edit.php?RetrieveFlag=UPDATE&str_no=<?=$str_no?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_newsle_info WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="news_news_list.php";
			</script>
			<?
			exit;
			break;

	}

?>
