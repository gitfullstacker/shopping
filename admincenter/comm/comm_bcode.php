<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_menutype = Fnc_Om_Conv_Default($_REQUEST[str_menutype],"03");
	$str_chocode = Fnc_Om_Conv_Default($_REQUEST[str_chocode],"00");
	$str_unicode = Fnc_Om_Conv_Default($_REQUEST[str_unicode],"00000");

	$obj1 = Fnc_Om_Conv_Default($_REQUEST[obj1],"");
	$obj2 = Fnc_Om_Conv_Default($_REQUEST[obj2],"");
	$obj3 = Fnc_Om_Conv_Default($_REQUEST[obj3],"");
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript">
	function fnc_om_set(str_bcode,str_bname) {
		parent.document.<?=$obj1?>.<?=$obj2?>.value = str_bcode;
		parent.document.<?=$obj1?>.<?=$obj3?>.value = unescape(str_bname);
		parent.closeLayer();
	}
</script>
</head>
<body class="scroll">
						<div align="center" style="HEIGHT:447px; overflow:auto; WIDTH:395">
						<table width=100% border=0>
							<tr>
								<td valign=top style="padding:10px;">
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
														AND
														A.STR_SERVICE='Y'
													ORDER BY
														A.FULL_SORT ASC ";

											$arr_menu_Data=mysql_query($SQL_QUERY);
											?>
											<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
														<?while($row=mysql_fetch_array($arr_menu_Data)){?>
														<tr>
															<td style="padding-left:<?=strlen($row[FULL_CODE])*4-40?>px;">
																<?if (strlen($row[FULL_CODE])/10==1) {?><img src="/pub/img/TreeIcons/Icons/Folder.gif" align="absMiddle" border="0"> <?}else{?><img src="/pub/img/TreeIcons/Icons/page.gif" align="absMiddle" border="0"> <?}?> <a href="javascript:fnc_om_set('<?=$row[STR_MENUTYPE].$row[STR_CHOCODE].$row[STR_UNICODE]?>','<?=str_replace("|","  > ",substr($row[FULL_NAME],0,strlen($row[FULL_NAME]) - 1))?>')"><?=$row[STR_IDXWORD]?></a></font> </a>
															</td>
														</tr>
														<?}?>
											</table>
										</div>
										<style type="text/css">
										<!--
										input.c {height:13px; width:13px; margin-left:0px; margin-right:6px; margin-bottom:0px; margin-top:1px;}
										-->
										</style>
								</td>
							</tr>
						</table>
						</div>
</body>
</html>