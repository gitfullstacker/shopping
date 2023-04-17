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
											?>
											<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td><img src="/pub/img/TreeIcons/Icons/xpMyComp.gif"> <b>TOP</b> <a href=javascript:parent.fuc_set('/admincenter/code/code_input_road.php?RetrieveFlag=INSERT&str_menutype=<?=$str_menutype?>&str_chocode=00&str_unicode=00000','_Incode');parent.table_design_load();><img src=/pub/img/icons/but01.gif border=0 align=absmiddle alt=등록></a></td>
												</tr>
												<?while($row=mysql_fetch_array($arr_menu_Data)){?>
														<tr>
															<td style="padding-left:<?=strlen($row[FULL_CODE])*4-40?>px;">
																<?if (strlen($row[FULL_CODE])/10==1) {?><img src="/pub/img/TreeIcons/Icons/Folder.gif" align="absMiddle" border="0"> <?}else{?><img src="/pub/img/TreeIcons/Icons/page.gif" align="absMiddle" border="0"> <?}?><a href=javascript:parent.fuc_set('/admincenter/code/code_input_road.php?RetrieveFlag=INSERT&str_menutype=<?=$row[STR_MENUTYPE]?>&str_chocode=<?=$row[STR_CHOCODE]?>&str_unicode=<?=$row[STR_UNICODE]?>','_Incode');parent.table_design_load();><img src=/pub/img/icons/but01.gif border=0 align=absmiddle alt=등록></a></font><a href=javascript:parent.Delete_Click('/admincenter/code/code_input_road_proc.php?RetrieveFlag=DELETE&str_menutype=<?=$row[STR_MENUTYPE]?>&str_chocode=<?=$row[STR_CHOCODE]?>&str_unicode=<?=$row[STR_UNICODE]?>');parent.table_design_load();><img src=/pub/img/icons/but03.gif border=0 align=absmiddle alt=삭제></a>
																<?If (substr($row[STR_UNICODE],0,1)=="1") {?>
																	[<?=$row[INT_CHOSORT]?>]
																<?}else{?>
																	[<?=$row[INT_UNISORT]?>]
																<?}?>
															<a href=javascript:parent.fuc_set('/admincenter/code/code_input_road.php?RetrieveFlag=UPDATE&str_menutype=<?=$row[STR_MENUTYPE]?>&str_chocode=<?=$row[STR_CHOCODE]?>&str_unicode=<?=$row[STR_UNICODE]?>','_Incode');parent.table_design_load();><font color='000000'><?if ($row[STR_SERVICE]!="Y") {?><strike><?=$row[STR_IDXWORD]?></strike><?}else{?><?=$row[STR_IDXWORD]?><?}?></font></a>
															</td>
														</tr>
												<?}?>
											</table>

</body>
</html>