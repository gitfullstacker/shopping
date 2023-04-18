<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_name = Fnc_Om_Conv_Default($_REQUEST[str_name],"");
	$str_email = Fnc_Om_Conv_Default($_REQUEST[str_email],"");
	$str_title = Fnc_Om_Conv_Default($_REQUEST[str_title],"");
	$str_contents = Fnc_Om_Conv_Default($_REQUEST[str_contents],"");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"N");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_mail_master a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_mail_master (";
					$SQL_QUERY .= " INT_NUMBER,STR_NAME,STR_EMAIL,STR_TITLE,STR_CONTENTS,DTM_INDATE
											) VALUES (
												'$lastnumber','$str_name','$str_email','$str_title','$str_contents','".date("Y-m-d H:i:s")."'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="mail_contents_edit.php?RetrieveFlag=UPDATE&str_no=<?=$lastnumber?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_mail_master SET ";
								$SQL_QUERY .= "STR_NAME='$str_name'
									,STR_EMAIL='$str_email'
									,STR_TITLE='$str_title'
									,STR_CONTENTS='$str_contents'
								WHERE
									INT_NUMBER='$str_no' ";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="mail_contents_edit.php?RetrieveFlag=UPDATE&str_no=<?=$str_no?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_mail_master WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="mail_contents_list.php";
			</script>
			<?
			exit;
			break;

	}

?>
