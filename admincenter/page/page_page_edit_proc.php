<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$str_String = Fnc_Om_Conv_Default($_REQUEST[str_String],"");
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"");
	$str_url = Fnc_Om_Conv_Default($_REQUEST[str_url],"");
	$str_contents = Fnc_Om_Conv_Default($_REQUEST[str_contents],"");

	switch($RetrieveFlag){
		case "INSERT" :

			$SQL_QUERY = "INSERT INTO ".$Tname."comm_page_info (";
					$SQL_QUERY .= "INT_GUBUN,STR_CONTENTS,DTM_INDATE,DTM_ACDATE
											) VALUES (
												'$int_gubun','".addslashes($str_contents)."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."'
											)";

			$result=mysql_query($SQL_QUERY);
			?>
			<script language="javascript">
				window.location.href="page_page_edit.php?RetrieveFlag=UPDATE&int_gubun=<?=$int_gubun?>";
			</script>
			<?
			exit;
			break;
	
		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."comm_page_info SET ";
								$SQL_QUERY .= " STR_CONTENTS='".addslashes($str_contents)."',DTM_ACDATE='".date("Y-m-d H:i:s")."'
								WHERE
									INT_GUBUN='$int_gubun' ";

			$result=mysql_query($SQL_QUERY);
			?>
			<script language="javascript">
				window.location.href="page_page_edit.php?RetrieveFlag=UPDATE&int_gubun=<?=$int_gubun?>";
			</script>
			<?
			exit;
			break;

	}

?>
