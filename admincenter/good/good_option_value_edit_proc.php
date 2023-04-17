<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"");
	$str_option = Fnc_Om_Conv_Default($_REQUEST[str_option],"");
	$int_aprice = Fnc_Om_Conv_Default($_REQUEST[int_aprice],"0");
	$str_skunum = Fnc_Om_Conv_Default($_REQUEST[str_skunum],"");
	$str_manum = Fnc_Om_Conv_Default($_REQUEST[str_manum],"");
	
	$int_snumber = Fnc_Om_Conv_Default($_REQUEST[int_snumber],"");
	$str_soption = Fnc_Om_Conv_Default($_REQUEST[str_soption],"");
	$int_saprice = Fnc_Om_Conv_Default($_REQUEST[int_saprice],"");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_goods_option_value a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_goods_option_value (";
					$SQL_QUERY .= " INT_NUMBER,STR_GOODCODE,INT_GUBUN,STR_OPTION,INT_APRICE,STR_SKUNUM,STR_MANUM,DTM_INDATE
											) VALUES (
												'$lastnumber','$str_goodcode','$int_gubun','$str_option','$int_aprice','$str_skunum','$str_manum','".date("Y-m-d H:i:s")."'
											)";

			$result=mysql_query($SQL_QUERY);
			
			?>
			<script language="javascript">
				window.location.href="good_option_value_edit.php?RetrieveFlag=UPDATE&str_no=<?=$lastnumber?>&str_goodcode=<?=$str_goodcode?>&int_gubun=<?=$int_gubun?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_goods_option_value SET ";
								$SQL_QUERY .= "STR_OPTION='$str_option',INT_APRICE='$int_aprice',STR_SKUNUM='$str_skunum',STR_MANUM='$str_manum'
								WHERE
									STR_GOODCODE='$str_goodcode' AND INT_GUBUN='$int_gubun' AND INT_NUMBER='$str_no' ";

			$result=mysql_query($SQL_QUERY);
			
			?>
			<script language="javascript">
				window.location.href="good_option_value_edit.php?RetrieveFlag=UPDATE&str_no=<?=$str_no?>&str_goodcode=<?=$str_goodcode?>&int_gubun=<?=$int_gubun?>";
			</script>
			<?
			exit;
			break; 

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {


				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_goods_option_value WHERE INT_NUMBER='$chkItem1[$i]' AND STR_GOODCODE='$str_goodcode' AND INT_GUBUN='$int_gubun' ";
				$result=mysql_query($SQL_QUERY);

			}
			?>
			<script language="javascript">
				window.location.href="good_option_value_list.php?str_goodcode=<?=$str_goodcode?>&int_gubun=<?=$int_gubun?>";
			</script>
			<?
			exit;
			break;

	}

?>
