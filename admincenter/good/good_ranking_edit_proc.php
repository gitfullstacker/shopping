<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode],"");


	$str_del_img1 = Fnc_Om_Conv_Default($_REQUEST[str_del_img1],"N");

	$int_sort = Fnc_Om_Conv_Default($_REQUEST[int_sort],"");
	$chkItem2 = Fnc_Om_Conv_Default($_REQUEST[chkItem2],"");
	

	switch($RetrieveFlag){
     	case "INSERT" :
     	
			$SQL_QUERY = "DELETE FROM ".$Tname."comm_goods_ranking WHERE STR_BCODE='".$Txt_bcode."' ";
			mysql_query($SQL_QUERY);
			
			for($int_I = 0 ;$int_I < 8; $int_I++) {

				if (Fnc_Om_Conv_Default($_REQUEST['str_goodcode'.($int_I+1)],"")!="") {
					$SQL_QUERY = "INSERT INTO ".$Tname."comm_goods_ranking (";
							$SQL_QUERY .= "STR_BCODE,INT_GUBUN,STR_GOODCODE
													) VALUES (
														'$Txt_bcode','".($int_I+1)."','".Fnc_Om_Conv_Default($_REQUEST['str_goodcode'.($int_I+1)],"")."'
													)";
		
					mysql_query($SQL_QUERY);			
				}
			
			}
			?>
			<script language="javascript">
				window.location.href="good_ranking_edit.php?Txt_bcode=<?=$Txt_bcode?>";
			</script>
			<?
			exit;
			break;

    }

?>