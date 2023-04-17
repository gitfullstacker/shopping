<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$str_menutype = Fnc_Om_Conv_Default($_REQUEST[str_menutype],"01");
	$str_chocode = Fnc_Om_Conv_Default($_REQUEST[str_chocode],"00");
	$str_unicode = Fnc_Om_Conv_Default($_REQUEST[str_unicode],"00000");
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<link rel="stylesheet" href="/admincenter/ncode/js/jquery.treeview.css" />
<link rel="stylesheet" href="/admincenter/ncode/js/red-treeview.css" />
<link rel="stylesheet" href="/admincenter/ncode/js/screen.css" />
<script src="/admincenter/ncode/lib/jquery.js" type="text/javascript"></script>
<script src="/admincenter/ncode/lib/jquery.cookie.js" type="text/javascript"></script>
<script src="/admincenter/ncode/js/jquery.treeview.js" type="text/javascript"></script>

	
	<script type="text/javascript">
		$(function() {

			$("#browser").treeview({
				collapsed: false,
				//animated: "medium",
				control:"#sidetreecontrol",
				persist: "location"
			});

		})
	</script>

</head>
<body>
											<?
											$SQL_QUERY = "SELECT
														A.STR_IDXWORD,
														A.INT_CHOSORT,
														A.INT_UNISORT,
														A.FULL_NAME,
														A.FULL_CODE,
														A.STR_MENUTYPE,
														A.STR_CHOCODE,
														A.STR_UNICODE,
														A.STR_SERVICE
													FROM ";
														$SQL_QUERY .= $Tname;
														$SQL_QUERY .= "comm_menu_idx A
													WHERE
														A.STR_MENUTYPE='$str_menutype'
													ORDER BY
														A.FULL_SORT ASC ";

											$arr_menu_Data=mysql_query($SQL_QUERY);
											
											$arr_Data=mysql_query($SQL_QUERY);
											$arr_Data_Cnt=mysql_num_rows($arr_Data);
											$sTemp=0;
											?>
											<ul id="browser" class="filetree">
												<li> <a href=javascript:parent.fuc_set('code_input_road.php?RetrieveFlag=INSERT&str_menutype=<?=$str_menutype?>&str_chocode=00&str_unicode=00000','_Incode');parent.table_design_load();><img src="/pub/img/icons/shape_square_edit.gif" align="absmiddle" style="width:15px;height:15px;"></a> HOME
												<?for($int_I = 0 ;$int_I < $arr_Data_Cnt; $int_I++) {?>
													<?if ($int_I!=0&&substr(mysql_result($arr_Data,($int_I-1),str_unicode),0,1)<substr(mysql_result($arr_Data,$int_I,str_unicode),0,1)) {?>
													<ul>
													<?}?>
														<li><span class="folder">
															<a href=javascript:parent.fuc_set('code_input_road.php?RetrieveFlag=INSERT&str_menutype=<?=mysql_result($arr_Data,$int_I,str_menutype)?>&str_chocode=<?=mysql_result($arr_Data,$int_I,str_chocode)?>&str_unicode=<?=mysql_result($arr_Data,$int_I,str_unicode)?>','_Incode');parent.table_design_load();><img src="/pub/img/icons/shape_square_add.gif" align="absmiddle" style="width:15px;height:15px;"></a></font><a href=javascript:parent.Delete_Click('code_input_road_proc.php?RetrieveFlag=DELETE&str_menutype=<?=mysql_result($arr_Data,$int_I,str_menutype)?>&str_chocode=<?=mysql_result($arr_Data,$int_I,str_chocode)?>&str_unicode=<?=mysql_result($arr_Data,$int_I,str_unicode)?>');parent.table_design_load();><img src="/pub/img/icons/shape_square_delete.gif" align="absmiddle" style="width:15px;height:15px;"></a>
															<a href=javascript:parent.fuc_set('code_input_road.php?RetrieveFlag=UPDATE&str_menutype=<?=mysql_result($arr_Data,$int_I,str_menutype)?>&str_chocode=<?=mysql_result($arr_Data,$int_I,str_chocode)?>&str_unicode=<?=mysql_result($arr_Data,$int_I,str_unicode)?>','_Incode');parent.table_design_load();>
															<?If (substr(mysql_result($arr_Data,$int_I,str_unicode),0,1)=="1") {?>
																[<?=mysql_result($arr_Data,$int_I,int_chosort)?>]
															<?}else{?>
																[<?=mysql_result($arr_Data,$int_I,int_unisort)?>]
															<?}?>
															<?if (mysql_result($arr_Data,$int_I,str_service)!="Y") {?>
															<font color="red">
															<?}?>
															<?=mysql_result($arr_Data,$int_I,str_idxword)?>
															</font>
															</a>
															</span>
													<?if ($int_I!=($arr_Data_Cnt-1)&&substr(mysql_result($arr_Data,$int_I+1,str_unicode),0,1)<substr(mysql_result($arr_Data,$int_I,str_unicode),0,1)) {?>
													<?for($int_J=0;$int_J< (substr(mysql_result($arr_Data,$int_I,str_unicode),0,1)-substr(mysql_result($arr_Data,$int_I+1,str_unicode),0,1));$int_J++) {?>
													</li>
													</ul>
													</li>
													<?}?>
													<?}?>
													<?if ($int_I!=($arr_Data_Cnt-1)&&substr(mysql_result($arr_Data,$int_I+1,str_unicode),0,1)==substr(mysql_result($arr_Data,$int_I,str_unicode),0,1)) {?>
													</li>
													<?}?>
													<?$sTemp=substr(mysql_result($arr_Data,$int_I,str_unicode),0,1)?>
												<?}?>
												
											<?for ($int_J=$sTemp;0<$int_J;$int_J--) {?>
											</li>
											</ul>											
											<?}?>
												
											<?if (!$arr_Data_Cnt) {?>
											</li>
											</ul>
											<?}?>


</body>
</html>