<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_filename = Fnc_Om_Conv_Default($_REQUEST[str_filename],"");
	$str_title = Fnc_Om_Conv_Default($_REQUEST[str_title],"");
	$str_contents = Fnc_Om_Conv_Default($_REQUEST[str_contents],"");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	Switch($RetrieveFlag){
       	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_check_tip a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_check_tip (";
					$SQL_QUERY .= " INT_NUMBER ,STR_FILENAME ,STR_TITLE
												,STR_CONTENTS, DTM_INDATE
											) VALUES (
												'$lastnumber','$str_filename','$str_title'
												,'$str_contents','".date("Y-m-d H:i:s")."'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				parent.fuc_set('/admincenter/comm/comm_tip_edit_proc.php?RetrieveFlag=Load&str_filename=<?=urlencode($str_filename)?>','_Tip');
				window.location.href="comm_tip_edit.php?RetrieveFlag=UPDATE&page=1&str_filename=<?=$str_filename?>&str_no=<?=$lastnumber?>";
			</script>
			<?
			break;

       	case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_check_tip SET ";
								$SQL_QUERY .= "STR_TITLE='$str_title'
									,STR_CONTENTS='$str_contents'
									,DTM_INDATE='".date("Y-m-d H:i:s")."'
								WHERE
									INT_NUMBER='$str_no' ";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				parent.fuc_set('/admincenter/comm/comm_tip_edit_proc.php?RetrieveFlag=Load&str_filename=<?=urlencode($str_filename)?>','_Tip');
				window.location.href="comm_tip_edit.php?RetrieveFlag=UPDATE&page=1&str_filename=<?=$str_filename?>&str_no=<?=$str_no?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_check_tip WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				parent.fuc_set('/admincenter/comm/comm_tip_edit_proc.php?RetrieveFlag=Load&str_filename=<?=urlencode($str_filename)?>','_Tip');
				window.location.href="comm_tip_list.php?page=1&str_filename=<?=$str_filename?>";
			</script>
			<?
			exit;
			break;

       	case "Load" :

			$SQL_QUERY = "SELECT
						A.INT_NUMBER,
						A.STR_FILENAME,
						A.STR_TITLE,
						A.STR_CONTENTS,
						A.DTM_INDATE
					FROM ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_check_tip A
					WHERE
						A.STR_FILENAME='$str_filename'
						ORDER BY A.INT_NUMBER ASC" ;

			$arr_Tip_Data=mysql_query($SQL_QUERY);
			$rcd_cnt=mysql_num_rows($arr_Tip_Data);
			?>
						<table width="100%" cellpadding=1 cellspacing=0 border=0 class=small_tip>
						<?if($rcd_cnt){?>
							<?while($row=mysql_fetch_array($arr_Tip_Data)){?>
							<tr>
								<td width="10%" style="padding-left:10px;" valign="top"><img src="/admincenter/img/icon_list.gif" align=absmiddle><font color=0074BA><?=$row[STR_TITLE]?></font></td>
							 	<td width="1%" valign="top">:</td>
							 	<td width="89%" valign="top"><?=$row[STR_CONTENTS]?></td>
							</tr>
							<?}?>
						<?}Else{?>
							<tr><td>&nbsp;</td></tr>
						<?}?>
						</table>

			<?
			break;
	}
?>
