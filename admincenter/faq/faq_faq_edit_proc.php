<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"1");
	$str_quest = Fnc_Om_Conv_Default($_REQUEST[str_quest],"");
	$str_answer = Fnc_Om_Conv_Default($_REQUEST[str_answer],"");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"Y");
	$str_mservice = Fnc_Om_Conv_Default($_REQUEST[str_mservice],"N");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_faq a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_faq (";
					$SQL_QUERY .= " INT_NUMBER,INT_GUBUN,STR_QUEST,STR_ANSWER,DTM_INDATE,STR_SERVICE,STR_MSERVICE
											) VALUES (
												'$lastnumber','$int_gubun','$str_quest','$str_answer','".date("Y-m-d H:i:s")."','$str_service','$str_mservice'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="faq_faq_edit.php?RetrieveFlag=UPDATE&str_no=<?=$lastnumber?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_faq SET ";
								$SQL_QUERY .= "STR_QUEST='$str_quest'
									,INT_GUBUN='$int_gubun'
									,STR_ANSWER='$str_answer'
									,STR_SERVICE='$str_service'
									,STR_MSERVICE='$str_mservice'
								WHERE
									INT_NUMBER='$str_no' ";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="faq_faq_edit.php?RetrieveFlag=UPDATE&str_no=<?=$str_no?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_faq WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="faq_faq_list.php";
			</script>
			<?
			exit;
			break;

	}

?>
