<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_idxword = Fnc_Om_Conv_Default($_REQUEST[str_idxword],"");
	$str_contents = Fnc_Om_Conv_Default($_REQUEST[str_contents],"");
	$str_idxcode = Fnc_Om_Conv_Default($_REQUEST[str_idxcode],"01");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"Y");

	$str_menutype = Fnc_Om_Conv_Default($_REQUEST[str_menutype],"N");
	$str_chocode = Fnc_Om_Conv_Default($_REQUEST[str_chocode],"");
	$str_unicode = Fnc_Om_Conv_Default($_REQUEST[str_unicode],"");
	$chkSvcFlag = Fnc_Om_Conv_Default($_REQUEST[chkSvcFlag],"");
	$str_idxnum = Fnc_Om_Conv_Default($_REQUEST[str_idxnum],"");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(cast(max(A.str_idxnum) as decimal(7,0)),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_fun_code A
					WHERE
						A.STR_IDXCODE='$str_idxcode' ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = Fnc_Om_Add_Zero(mysql_result($arr_max_Data,0,lastnumber),2);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_fun_code (";
					$SQL_QUERY .= " STR_IDXCODE ,STR_IDXNUM ,STR_IDXWORD
												,STR_CONTENTS ,DTM_INDATE ,STR_SERVICE
											) VALUES (
												'$str_idxcode','$lastnumber','$str_idxword'
												,'$str_contents','".date("Y-m-d H:i:s")."','$str_service'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="code_input_right.php?RetrieveFlag=UPDATE&page=1&str_no=<?=$lastnumber?>&str_idxcode=<?=$str_idxcode?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_fun_code SET ";
								$SQL_QUERY .= "STR_IDXWORD='$str_idxword'
									,STR_CONTENTS='$str_contents'
									,STR_SERVICE='$str_service'
								WHERE
									STR_IDXCODE='$str_idxcode' AND STR_IDXNUM='$str_no' ";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="code_input_right.php?RetrieveFlag=UPDATE&page=<?=$page?>&str_idxcode=<?=$str_idxcode?>&str_no=<?=$str_no?>";
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
				window.location.href="code_li_right.php?str_idxcode=<?=$str_idxcode?>";
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
				window.location.href="code_li_right.php?str_idxcode=<?=$str_idxcode?>";
			</script>
			<?
			exit;
			break;

     	case "SERVICE" :

     		If ($chkSvcFlag=="Y") {
				$SQL_QUERY =	 "INSERT INTO ".$Tname."comm_menu_right (
					STR_MENUTYPE,STR_CHOCODE
					,STR_UNICODE,STR_IDXCODE,STR_IDXNUM
					) values(
					'$str_menutype','$str_chocode','$str_unicode','$str_idxcode','$str_idxnum') ";
			}else{
				$SQL_QUERY =	 "DELETE FROM ".$Tname."comm_menu_right
					WHERE
						STR_MENUTYPE='$str_menutype' AND STR_CHOCODE='$str_chocode' AND STR_UNICODE='$str_unicode' AND STR_IDXCODE='$str_idxcode' AND STR_IDXNUM='$str_idxnum' ";
			}
			$result=mysql_query($SQL_QUERY);

			break;
	}

?>
