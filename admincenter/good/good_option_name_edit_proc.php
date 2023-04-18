<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");
	$str_oname = Fnc_Om_Conv_Default($_REQUEST[str_oname],"");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.int_gubun),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_goods_option_name a where a.str_goodcode='$str_goodcode' ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_goods_option_name (";
					$SQL_QUERY .= " STR_GOODCODE,INT_GUBUN,STR_ONAME,DTM_INDATE
											) VALUES (
												'$str_goodcode','$lastnumber','$str_oname','".date("Y-m-d H:i:s")."'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="good_option_name_edit.php?RetrieveFlag=UPDATE&str_no=<?=$lastnumber?>&str_goodcode=<?=$str_goodcode?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_goods_option_name SET ";
								$SQL_QUERY .= "STR_ONAME='$str_oname'
								WHERE
									STR_GOODCODE='$str_goodcode' AND INT_GUBUN='$str_no' ";

			$result=mysql_query($SQL_QUERY);
			?>
			<script language="javascript">
				window.location.href="good_option_name_edit.php?RetrieveFlag=UPDATE&str_no=<?=$str_no?>&str_goodcode=<?=$str_goodcode?>";
			</script>
			<?
			exit;
			break; 

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {
			
				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_goods_option_value_sub WHERE INT_GUBUN='$chkItem1[$i]' AND STR_GOODCODE='$str_goodcode' ";
				$result=mysql_query($SQL_QUERY);

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_goods_option_value WHERE INT_GUBUN='$chkItem1[$i]' AND STR_GOODCODE='$str_goodcode' ";
				$result=mysql_query($SQL_QUERY);

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_goods_option_name WHERE INT_GUBUN='$chkItem1[$i]' AND STR_GOODCODE='$str_goodcode' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="good_option_name_list.php?str_goodcode=<?=$str_goodcode?>";
			</script>
			<?
			exit;
			break;

	}

?>
