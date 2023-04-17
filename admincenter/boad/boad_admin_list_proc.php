<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_userid = Fnc_Om_Conv_Default($_REQUEST[str_userid],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.admin_seq),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "b_admin_bd where conf_seq='$str_no' ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = Fnc_Om_Add_Zero(mysql_result($arr_max_Data,0,lastnumber),2);

			$SQL_QUERY = "INSERT INTO ".$Tname."b_admin_bd (";
					$SQL_QUERY .= " ADMIN_SEQ ,CONF_SEQ ,MEM_ID
											) VALUES (
												'$lastnumber','$str_no','$str_userid'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				parent.fuc_set('/admincenter/boad/boad_board_edit_proc.php?RetrieveFlag=ADMINLOADING&str_no=<?=$str_no?>','_Admin');
				parent.closeLayer();
			</script>
			<?
			exit;
			break;

		case "DELETE" :

			$SQL_QUERY = "delete from ".$Tname."b_admin_bd where conf_seq = '$str_no' and mem_id ='$str_userid' ";
			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript" defer="true">
				fuc_set('/admincenter/boad/boad_board_edit_proc.php?RetrieveFlag=ADMINLOADING&str_no=<?=$str_no?>','_Admin');
			</script>
			<?
			exit;
			break;
	}
?>