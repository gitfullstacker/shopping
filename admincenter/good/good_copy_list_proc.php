<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");

	switch($RetrieveFlag){
     	case "COPY" :
     	
			$Sql_Query =	" SELECT
							A.*
						FROM `"
							.$Tname."comm_goods_option_name` AS A
						WHERE
							A.STR_GOODCODE='".$str_no."'
						ORDER BY
							A.INT_GUBUN ASC ";
		
			$arr_Data1=mysql_query($Sql_Query);
			$arr_Data1_Cnt=mysql_num_rows($arr_Data1);
			
			
			for($int_I = 0 ;$int_I < $arr_Data1_Cnt; $int_I++) {
			
				$SQL_QUERY = "select ifnull(max(a.int_gubun),0)+1 as lastnumber from ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_goods_option_name a where a.str_goodcode='$str_goodcode' ";
	
				$arr_max_Data=mysql_query($SQL_QUERY);
				$lastnumber = mysql_result($arr_max_Data,0,lastnumber);
	
				$SQL_QUERY = "INSERT INTO ".$Tname."comm_goods_option_name (";
						$SQL_QUERY .= " STR_GOODCODE,INT_GUBUN,STR_ONAME,DTM_INDATE
												) VALUES (
													'$str_goodcode','$lastnumber','".mysql_result($arr_Data1,$int_I,str_oname)."','".date("Y-m-d H:i:s")."'
												)";
				mysql_query($SQL_QUERY);
				
				$Sql_Query =	" SELECT
								A.*
							FROM `"
								.$Tname."comm_goods_option_value` AS A
							WHERE
								A.STR_GOODCODE='".mysql_result($arr_Data1,$int_I,str_goodcode)."'
								AND
								A.INT_GUBUN='".mysql_result($arr_Data1,$int_I,int_gubun)."'
							ORDER BY
								A.INT_NUMBER ASC ";
			
				$arr_Data2=mysql_query($Sql_Query);
				$arr_Data2_Cnt=mysql_num_rows($arr_Data2);
				
				for($int_J = 0 ;$int_J < $arr_Data2_Cnt; $int_J++) {
				
					$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
								$SQL_QUERY .= $Tname;
								$SQL_QUERY .= "comm_goods_option_value a ";
		
					$arr_max_Data=mysql_query($SQL_QUERY);
					$lastnumber2 = mysql_result($arr_max_Data,0,lastnumber);
		
					$SQL_QUERY = "INSERT INTO ".$Tname."comm_goods_option_value (";
							$SQL_QUERY .= " INT_NUMBER,STR_GOODCODE,INT_GUBUN,STR_OPTION,INT_APRICE,DTM_INDATE
													) VALUES (
														'$lastnumber2','$str_goodcode','$lastnumber','".mysql_result($arr_Data2,$int_J,str_option)."','".mysql_result($arr_Data2,$int_J,int_aprice)."','".date("Y-m-d H:i:s")."'
													)";
		
					mysql_query($SQL_QUERY);
					
				
				}
			
			}
     	

			?>
			<script language="javascript">
				alert("복사되었습니다.");
				parent.document.frm.submit();
				//window.location.href="good_option_value_edit.php?RetrieveFlag=UPDATE&str_no=<?=$lastnumber?>&str_goodcode=<?=$str_goodcode?>&int_gubun=<?=$int_gubun?>";
			</script>
			<?
			exit;
			break;


	}

?>
