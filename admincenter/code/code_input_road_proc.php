<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_menutype = Fnc_Om_Conv_Default($_REQUEST[str_menutype],"01");
	$str_chocode = Fnc_Om_Conv_Default($_REQUEST[str_chocode],"00");
	$str_unicode = Fnc_Om_Conv_Default($_REQUEST[str_unicode],"00000");
	$str_idxword = Fnc_Om_Conv_Default($_REQUEST[str_idxword],"");
	$str_menupath = Fnc_Om_Conv_Default($_REQUEST[str_menupath],"");
	$str_sort = Fnc_Om_Conv_Default($_REQUEST[str_sort],"0");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"Y");

	switch($RetrieveFlag){
     	case "INSERT" :

     		if ($str_chocode=="00") {

				$SQL_QUERY = "select ifnull(max(A.str_chocode),0)+1 as lastnumber from ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_idx A
						WHERE
							A.STR_MENUTYPE='$str_menutype'
							ORDER BY A.STR_CHOCODE ASC" ;

				$arr_max_Data=mysql_query($SQL_QUERY);

				$lastnumber = Fnc_Om_Add_Zero(mysql_result($arr_max_Data,0,lastnumber),2);


				$SQL_QUERY = "insert into ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_idx
							(str_menutype,str_chocode,str_unicode,str_idxword,str_menupath,int_chosort,int_unisort,dtm_indate,str_service)
							values
							('$str_menutype','$lastnumber','10001','$str_idxword','$str_menupath','$str_sort',0,'".date("Y-m-d H:i:s")."','$str_service') ";

				$result=mysql_query($SQL_QUERY);

				$SQL_QUERY = "insert into ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_con
							(str_menutype,str_chocode,str_unicode,str_btmcode,str_btmflag,str_topcode,str_topflag)
							values
							('$str_menutype','$lastnumber','10001','00000','0','00000','0')";

				$result=mysql_query($SQL_QUERY);

				$SQL_QUERY = "insert into ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_con
							(str_menutype,str_chocode,str_unicode,str_btmcode,str_btmflag,str_topcode,str_topflag)
							values
							('$str_menutype','$lastnumber','00000','10001','1','00000','0')";

				$result=mysql_query($SQL_QUERY);

				$BtmCho=$lastnumber;
				$BtmUni="10001" ;

     		}else{

				$SQL_QUERY = "select ifnull(max(a.str_unicode),0) as str_unicode from ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_idx a
						WHERE
							a.str_menutype='$str_menutype'
							and a.str_chocode='$str_chocode'
							and a.str_unicode > '".(substr($str_unicode,0,1)+1)."0000"."'
							and a.str_unicode < '".(substr($str_unicode,0,1)+2)."0000"."' ";

				$arr_max_Data=mysql_query($SQL_QUERY);

				if (mysql_result($arr_max_Data,0,str_unicode)=="0") {
					$lastnumber = (substr($str_unicode,0,1)+1)."0001";
				} else {
					$lastnumber = mysql_result($arr_max_Data,0,str_unicode)+1;
				}

				$SQL_QUERY = "select * from ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_idx
						where
							str_menutype = '$str_menutype'
							and str_chocode = '$str_chocode'
							and str_unicode = '$str_unicode' ";

				$arr_code_Data=mysql_query($SQL_QUERY);

				$SQL_QUERY = "insert into ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_idx
							(str_menutype,str_chocode,str_unicode,str_idxword,str_contents,str_menupath,int_chosort,int_unisort,dtm_indate,str_service)
							values
							('$str_menutype','$str_chocode','$lastnumber','$str_idxword','','$str_menupath','".mysql_result($arr_code_Data,0,int_chosort)."','$str_sort','".date("Y-m-d H:i:s")."','$str_service') ";

				$result=mysql_query($SQL_QUERY);

				$SQL_QUERY = "insert into ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_con
							(str_menutype,str_chocode,str_unicode,str_btmcode,str_btmflag,str_topcode,str_topflag)
							values
							('$str_menutype','$str_chocode','$lastnumber','00000','0','$str_unicode','1')"
;

				$result=mysql_query($SQL_QUERY);

				$SQL_QUERY = "select * from ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_idx a, ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_con b
						where
							a.str_menutype=b.str_menutype and a.str_chocode=b.str_chocode and a.str_unicode=b.str_unicode
							and a.str_menutype='$str_menutype' and a.str_chocode='$str_chocode'
							and a.str_unicode > '".(substr($str_unicode,0,1)+1)."0000"."'
							and a.str_unicode < '".(substr($str_unicode,0,1)+2)."0000"."' and b.str_topcode='$str_unicode'";

				$arr_code_Data=mysql_query($SQL_QUERY);
				$rcd_cnt=mysql_num_rows($arr_code_Data);

				if($rcd_cnt){
					if ($rcd_cnt==1) {

						$SQL_QUERY = "update ";
								$SQL_QUERY .= $Tname;
								$SQL_QUERY .= "comm_menu_con
								set str_btmcode='$lastnumber',str_btmflag='1'
								where str_menutype='$str_menutype'
								and str_chocode='$str_chocode'
								and str_unicode='$str_unicode' ";

						$result=mysql_query($SQL_QUERY);

					} else {

						$SQL_QUERY = "select str_topcode from ";
								$SQL_QUERY .= $Tname;
								$SQL_QUERY .= "comm_menu_con
								where str_menutype='$str_menutype'
								and str_chocode='$str_chocode'
								and str_unicode='$str_unicode' ";
						$arr_top_Data=mysql_query($SQL_QUERY);

						$SQL_QUERY = "insert into ";
								$SQL_QUERY .= $Tname;
								$SQL_QUERY .= "comm_menu_con
								(str_menutype,str_chocode,str_unicode,str_btmcode,str_btmflag,str_topcode,str_topflag)
								values
								('$str_menutype','$str_chocode','$str_unicode','$lastnumber','1','".mysql_result($arr_top_Data,0,str_topcode)."','1')";

						$result=mysql_query($SQL_QUERY);
					}

				}

				$BtmCho=$str_chocode;
				$BtmUni=$lastnumber;

     		}

			//최하위 코드 관리 시작
			$TopFcho = $BtmCho;
			$TopFuni = $BtmUni
;

			$SQL_QUERY = "insert into ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_menu_btm
						(str_menutype,str_chocode,str_unicode,str_btmcho,str_btmuni)
						values
						('$str_menutype','$BtmCho','$BtmUni','$BtmCho','$BtmUni')";

			$result=mysql_query($SQL_QUERY);

			while($TopTop!="00000") {

				$SQL_QUERY = "select a.str_idxword,a.str_chocode,a.str_unicode,b.str_topcode from ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_idx a, ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_con b
						where
							a.str_menutype=b.str_menutype and a.str_chocode=b.str_chocode and a.str_unicode=b.str_unicode
							and a.str_menutype='$str_menutype'
							and a.str_chocode='$TopFcho'
							and a.str_unicode = '$TopFuni'";

				$arr_code_Data=mysql_query($SQL_QUERY);

				$TopTop = mysql_result($arr_code_Data,0,str_topcode);
				$TopFcho = mysql_result($arr_code_Data,0,str_chocode);
				$TopFuni = mysql_result($arr_code_Data,0,str_topcode);

				$SQL_QUERY = "insert into ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_btm
							(str_menutype,str_chocode,str_unicode,str_btmcho,str_btmuni)
							values
							('$str_menutype','$TopFcho','$TopTop','$BtmCho','$BtmUni')";

				$result=mysql_query($SQL_QUERY);
				//최하위 코드 관리 종료

				//전체 코드 계산시작
				$SQL_QUERY = "SELECT
							B.STR_IDXWORD,
							B.INT_CHOSORT,
							B.INT_UNISORT,
							B.STR_UNICODE
						FROM ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_btm A ";
							$SQL_QUERY .= "INNER JOIN ";
					$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_idx AS B
							ON
							A.STR_MENUTYPE=B.STR_MENUTYPE
							AND
							A.STR_CHOCODE=B.STR_CHOCODE
							AND
							A.STR_UNICODE=B.STR_UNICODE
						WHERE
							A.STR_MENUTYPE='$str_menutype'
							AND
							A.STR_CHOCODE='$BtmCho'
							AND
							A.STR_BTMUNI='$BtmUni'";

				$arr_sub_Data=mysql_query($SQL_QUERY);

				$sTemp="";
				$sTemp2="";
				$sTemp3="00000|";

				while($rows=mysql_fetch_array($arr_sub_Data)){
					$sTemp.=$rows[STR_IDXWORD]."|";
					$sTemp2.=Fnc_Om_Add_Zero($rows[INT_CHOSORT],4)."|".Fnc_Om_Add_Zero($rows[INT_UNISORT],4)."|";
					$sTemp3.=$rows[STR_UNICODE]."|";
				}

				$SQL_QUERY = " UPDATE ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_menu_idx
							SET
								FULL_NAME='$sTemp'
								,FULL_SORT='$sTemp2'
								,FULL_CODE='$sTemp3'
							WHERE
								STR_MENUTYPE='$str_menutype'
								AND
								STR_CHOCODE='$BtmCho'
								AND
								STR_UNICODE='$BtmUni'";

				$result = mysql_query($SQL_QUERY);
				//전체 코드 계산종료

			}
			?>
			<script language="javascript">
				parent._TreeView.location.href='/admincenter/code/code_vi_road.php?str_menutype=<?=$str_menutype?>&str_chocode=<?=$BtmCho?>&str_unicode=<?=$BtmUni?>';
				parent.fuc_set('/admincenter/code/code_input_road.php?RetrieveFlag=UPDATE&str_menutype=<?=$str_menutype?>&str_chocode=<?=$BtmCho?>&str_unicode=<?=$BtmUni?>','_Incode');
				parent.table_design_load();
			</script>
     		<?
			break;

     	case "UPDATE" :

			$SQL_QUERY = "update ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_menu_idx
						set str_idxword='$str_idxword',str_menupath='$str_menupath',str_service='$str_service' ";

						if (substr($str_unicode,0,1) == "1") {
							$SQL_QUERY .= " ,int_chosort = '$str_sort',int_unisort=0 ";
						}else{
							$SQL_QUERY .= " ,int_unisort = '$str_sort' ";
						}
						$SQL_QUERY .= " where str_menutype='$str_menutype'
						and str_chocode='$str_chocode'
						and str_unicode='$str_unicode' ";

			$result = mysql_query($SQL_QUERY);

			if (substr($str_unicode,0,1) == "1") {
				$SQL_QUERY = "update  ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_menu_idx
						set int_chosort='$str_sort'
						where str_menutype='$str_menutype'
						and str_chocode='$str_chocode' ";

				$result = mysql_query($SQL_QUERY);
			}



			//전체 코드 계산시작
			fnc_sorting($str_menutype);

			//전체 코드 계산종료




			?>
			<script language="javascript">
				parent._TreeView.location.href='/admincenter/code/code_vi_road.php?str_menutype=<?=$str_menutype?>&str_chocode=<?=$str_chocode?>&str_unicode=<?=$str_unicode?>';
				parent.fuc_set('/admincenter/code/code_input_road.php?RetrieveFlag=UPDATE&str_menutype=<?=$str_menutype?>&str_chocode=<?=$str_chocode?>&str_unicode=<?=$str_unicode?>','_Incode');
				parent.table_design_load();
			</script>
			<?

			break;

     	case "DELETE" :

			$SQL_QUERY = "select str_btmcode,str_topcode
					from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_menu_con
					where
						str_menutype='$str_menutype'
						and str_chocode='$str_chocode'
						and str_unicode = '$str_unicode' ";

			$arr_code_Data=mysql_query($SQL_QUERY);

			$str_btmcode = mysql_result($arr_code_Data,0,str_btmcode);
			$str_topcode = mysql_result($arr_code_Data,0,str_topcode);

			if ($str_btmcode=="00000") {

				$SQL_QUERY = "select * from ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_con
						where
							str_menutype='$str_menutype'
							and str_chocode='$str_chocode'
							and str_topcode = '$str_topcode'";

				$arr_sub_Data=mysql_query($SQL_QUERY);
				$rcd_cnt=mysql_num_rows($arr_sub_Data);

				if($rcd_cnt){
					if ($rcd_cnt==1) {

						$SQL_QUERY = "update ";
								$SQL_QUERY .= $Tname;
								$SQL_QUERY .= "comm_menu_con
								set str_btmcode='00000',str_btmflag='0'
							where
								str_menutype='$str_menutype'
								and str_chocode='$str_chocode'
								and str_unicode='$str_topcode' ";

						$result = mysql_query($SQL_QUERY);

					}else{

						$SQL_QUERY = "delete from ";
								$SQL_QUERY .= $Tname;
								$SQL_QUERY .= "comm_menu_con
							where
								str_menutype='$str_menutype'
								and str_chocode='$str_chocode'
								and str_unicode='$str_topcode'
								and str_btmcode='$str_unicode' ";

						$result = mysql_query($SQL_QUERY);

					}
				}

				$SQL_QUERY = "delete from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_menu_con
					where
						str_menutype='$str_menutype'
						and str_chocode='$str_chocode'
						and str_unicode='$str_unicode' ";

				$result = mysql_query($SQL_QUERY);

				$SQL_QUERY = "delete from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_menu_btm
					where
						str_menutype='$str_menutype'
						and str_btmcho='$str_chocode'
						and str_btmuni='$str_unicode' ";

				$result = mysql_query($SQL_QUERY);

				$SQL_QUERY = "delete from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_menu_right
					where
						str_menutype='$str_menutype'
						and str_chocode='$str_chocode'
						and str_unicode='$str_unicode' ";

				$result = mysql_query($SQL_QUERY);

				$SQL_QUERY = "delete from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_menu_idx
					where
						str_menutype='$str_menutype'
						and str_chocode='$str_chocode'
						and str_unicode='$str_unicode' ";

				$result = mysql_query($SQL_QUERY);

				?>
				<script language="javascript">
					parent._TreeView.location.href='/admincenter/code/code_vi_road.php?str_menutype=<?=$str_menutype?>&str_chocode=<?=$str_chocode?>&str_unicode=<?=$str_topcode?>';

					<?
					$SQL_QUERY = "select * from ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_idx
						where
							str_menutype='$str_menutype' ";

					$arr_sub_Data=mysql_query($SQL_QUERY);
					$rcd_cnt=mysql_num_rows($arr_sub_Data);

					if($rcd_cnt){?>
					parent.fuc_set('/admincenter/code/code_input_road.php?RetrieveFlag=UPDATE&str_menutype=<?=$str_menutype?>&str_chocode=<?=$str_chocode?>&str_unicode=<?=$str_topcode?>','_Incode');
					parent.table_design_load();
					<?}else{?>
					parent.fuc_set('/admincenter/code/code_input_road.php?RetrieveFlag=INSERT&str_menutype=<?=$str_menutype?>&str_chocode=00&str_unicode=00000','_Incode');
					parent.table_design_load();
					<?}?>

				</script>
				<?

			} else {?>
			<script language="javascript">
				parent.Fnc_Message("\n최하위 뎁스가 아닙니다.\n다시 한번 확인해 주세요");
			</script>
			<?}

			break;
	}
	
	
	Function fnc_sorting($str_menutype) {
	
		global $Tname;
	
			$Sql_Query =	" SELECT
							A.*
						FROM 
							".$Tname."comm_menu_idx AS A
						WHERE
							A.STR_MENUTYPE='".$str_menutype."' 
						ORDER BY
							A.STR_CHOCODE ASC ";

			$arr_Data=mysql_query($Sql_Query);
			$arr_Data_Cnt=mysql_num_rows($arr_Data);
			
			for($int_I = 0 ;$int_I < $arr_Data_Cnt; $int_I++) {
	
				$SQL_QUERY = "SELECT
							B.STR_IDXWORD,
							B.INT_CHOSORT,
							B.INT_UNISORT,
							B.STR_UNICODE
						FROM ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_btm A ";
							$SQL_QUERY .= "INNER JOIN ";
					$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_menu_idx AS B
							ON
							A.STR_MENUTYPE=B.STR_MENUTYPE
							AND
							A.STR_CHOCODE=B.STR_CHOCODE
							AND
							A.STR_UNICODE=B.STR_UNICODE
						WHERE
							A.STR_MENUTYPE='".mysql_result($arr_Data,$int_I,str_menutype)."'
							AND
							A.STR_CHOCODE='".mysql_result($arr_Data,$int_I,str_chocode)."'
							AND
							A.STR_BTMUNI='".mysql_result($arr_Data,$int_I,str_unicode)."' ";
	
				$arr_sub_Data=mysql_query($SQL_QUERY);
				
	
				$sTemp="";
				$sTemp2="";
				$sTemp3="00000|";
	
				while($rows=mysql_fetch_array($arr_sub_Data)){
					$sTemp.=$rows[STR_IDXWORD]."|";
					$sTemp2.=Fnc_Om_Add_Zero($rows[INT_CHOSORT],4)."|".Fnc_Om_Add_Zero($rows[INT_UNISORT],4)."|";
					$sTemp3.=$rows[STR_UNICODE]."|";
				}
	
				$SQL_QUERY = " UPDATE ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_menu_idx
							SET
								FULL_NAME='$sTemp'
								,FULL_SORT='$sTemp2'
								,FULL_CODE='$sTemp3'
							WHERE
								STR_MENUTYPE='".mysql_result($arr_Data,$int_I,str_menutype)."'
								AND
								STR_CHOCODE='".mysql_result($arr_Data,$int_I,str_chocode)."'
								AND
								STR_UNICODE='".mysql_result($arr_Data,$int_I,str_unicode)."' ";
	
				$result = mysql_query($SQL_QUERY);
	
			}
	}
	
?>