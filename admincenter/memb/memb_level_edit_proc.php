<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_idxword = Fnc_Om_Conv_Default($_REQUEST[str_idxword],"");
	$str_contents = Fnc_Om_Conv_Default($_REQUEST[str_contents],"");
	$str_idxcode = Fnc_Om_Conv_Default($_REQUEST[str_idxcode],"06");
	$int_persent = Fnc_Om_Conv_Default($_REQUEST[int_persent],"0");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"Y");
	$str_idxnum = Fnc_Om_Conv_Default($_REQUEST[str_idxnum],"");

	$str_level = Fnc_Om_Conv_Default($_REQUEST[str_level],"00");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.str_idxnum),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_fun_code a
					WHERE
						a.str_idxcode='$str_idxcode' ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = Fnc_Om_Add_Zero(mysql_result($arr_max_Data,0,lastnumber),2);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_fun_code (";
					$SQL_QUERY .= " STR_IDXCODE ,STR_IDXNUM ,STR_IDXWORD
												,STR_CONTENTS, INT_PERSENT, DTM_INDATE ,STR_SERVICE
											) VALUES (
												'$str_idxcode','$lastnumber','$str_idxword'
												,'$str_contents','$int_persent','".date("Y-m-d H:i:s")."','$str_service'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="memb_level_edit.php?RetrieveFlag=UPDATE&page=1&str_no=<?=$lastnumber?>&str_idxcode=<?=$str_idxcode?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_fun_code SET ";
								$SQL_QUERY .= "STR_IDXWORD='$str_idxword'
									,STR_CONTENTS='$str_contents'
									,INT_PERSENT='$int_persent'
									,STR_SERVICE='$str_service'
								WHERE
									STR_IDXCODE='$str_idxcode' AND STR_IDXNUM='$str_no' ";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="memb_level_edit.php?RetrieveFlag=UPDATE&page=<?=$page?>&str_idxcode=<?=$str_idxcode?>&str_no=<?=$str_no?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_menu_right WHERE STR_IDXCODE='$str_idxcode' AND STR_IDXNUM='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_fun_code WHERE STR_IDXCODE='$str_idxcode' AND STR_IDXNUM='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="memb_level_list.php?str_idxcode=<?=$str_idxcode?>";
			</script>
			<?
			exit;
			break;

		case "DELETE" :

			$SQL_QUERY =	"DELETE FROM ".$Tname."comm_menu_right WHERE STR_IDXCODE='$str_idxcode' AND STR_IDXNUM='$str_idxnum' ";
			$result=mysql_query($SQL_QUERY);

			$SQL_QUERY =	"DELETE FROM ".$Tname."comm_fun_code WHERE STR_IDXCODE='$str_idxcode' AND STR_IDXNUM='$str_idxnum' ";
			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="memb_level_list.php?str_idxcode=<?=$str_idxcode?>";
			</script>
			<?
			exit;
			break;

		case "LEVEL1" :

			$SQL_QUERY =	"UPDATE ".$Tname."comm_site_info SET STR_LEVEL1='$str_level' WHERE INT_NUMBER='1' ";
			$result=mysql_query($SQL_QUERY);

			break;

		case "LEVEL2" :

			$SQL_QUERY =	"UPDATE ".$Tname."comm_site_info SET STR_LEVEL2='$str_level' WHERE INT_NUMBER='1' ";
			$result=mysql_query($SQL_QUERY);

			break;

	}

?>
