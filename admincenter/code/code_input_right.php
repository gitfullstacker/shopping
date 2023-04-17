<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_idxcode  = Fnc_Om_Conv_Default($_REQUEST[str_idxcode],"01");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						FC.STR_IDXNUM,
						FC.STR_IDXWORD,
						FC.STR_CONTENTS,
						FC.STR_SERVICE
					FROM "
						.$Tname."comm_fun_code AS FC
					WHERE
						FC.STR_IDXNUM='$str_no'
						AND
						FC.STR_IDXCODE='$str_idxcode' ";

		$arr_Rlt_Data=mysql_query($SQL_QUERY);
		if (!$arr_Rlt_Data) {
    		echo 'Could not run query: ' . mysql_error();
    		exit;
		}
		$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	}
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/code_input_right.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_logo_info.php";?>
		<td width=100%>
			<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_tmenu_info.php";?>
		</td>
	</tr>
	<tr>
		<td colspan="3"><?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_tmenu.php";?></td>
	</tr>
	<tr>
		<td valign=top id=leftMenu>
			<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_lmenu_info.php";?>
		</td>
		<td colspan=2 valign=top height=100%> 
			<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_stitle_info.php";?>
			<table width=100%>
				<tr>
					<td style="padding:10px">
						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>

						<form id="frm" name="frm" target="_self" method="POST" action="code_input_right.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_idxcode" value="<?=$str_idxcode?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">
						
						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:88%">
							<tr>
								<td nowrap>권한등급명</td>
								<td nowrap>
								<input name="str_idxword" value="<?=$arr_Data['STR_IDXWORD']?>" type="text" value="" style="width:300;">
								</td>
							</tr>
							<tr>
								<td nowrap>사용유무</td>
								<td nowrap>
									<input type="radio" value="Y" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="Y") {?>checked<?}?>> 사용
									<input type="radio" value="N" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="N") {?>checked<?}?>> 사용안함
								</td>
							</tr>
						</table>

						<?If ($RetrieveFlag=="UPDATE") {?>
						<span id="idView_Proc"></span>
						<div class="title"><?=$arr_Data['STR_IDXWORD']?> 메뉴접근설정</div>
						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:88%">
							<tr>
								<td nowrap>메뉴설정</td>
								<td nowrap valign="top">
									<div id=treeCategory2 class=scroll onmousewheel="return iciScroll(this)">
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
												A.STR_MENUTYPE='01'
												AND
												A.STR_SERVICE='Y'
											ORDER BY
												A.FULL_SORT ASC ";

									$arr_menu_Data=mysql_query($SQL_QUERY);
									?>
									<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" class="mytable3">
										<?while($row=mysql_fetch_array($arr_menu_Data)){?>
										<tr>
											<td style="padding-left:<?=strlen($row[FULL_CODE])*4-40?>px;">
												<?
													$SQL_QUERY = "select ifnull(count(str_menutype),0) as icheck from ".$Tname."comm_menu_right where str_idxcode='01' and str_idxnum='$str_no' and str_menutype='$row[STR_MENUTYPE]' and str_chocode='$row[STR_CHOCODE]' and str_unicode='$row[STR_UNICODE]'";
													$arr_code_Data=mysql_query($SQL_QUERY);
													$arr_sData = mysql_fetch_assoc($arr_code_Data);

													$Str_Flag="";
													$Html="";
													if ($arr_sData[icheck]=="1") {
														$Str_Flag=" checked='checked'";
													}
													$Html  = " <input class='null' type='checkbox' name='chkItem1' value='A".$row[STR_MENUTYPE].$row[STR_CHOCODE].$row[STR_UNICODE]."' ".$Str_Flag." onClick=javascript:fnc_service(this,'$row[STR_MENUTYPE]','$row[STR_CHOCODE]','$row[STR_UNICODE]','$str_idxcode','$str_no')>";
												?>
												<?if (strlen($row[FULL_CODE])/10==1) {?><img src="/pub/img/TreeIcons/Icons/Folder.gif" align="absMiddle" border="0"> <?}else{?><img src="/pub/img/TreeIcons/Icons/page.gif" align="absMiddle" border="0"> <?}?> <?=$Html?> <?=$row[STR_IDXWORD]?></a>
											</td>
										</tr>
										<?}?>
									</table>
									</div>
								</td>
							</tr>
						</table>
						<?}?>

						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						<a href='code_li_right.php?str_idxcode=<?=$str_idxcode?>'><img src='/admincenter/img/btn_list.gif'></a>
						</div>

						</form>

						<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_btip_info.php";?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr><td height=3 bgcolor="#E6E6E6" colspan=2></td></tr>
	<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_copyright_info.php";?>
</table>
<script>table_design_load();</script>
</body>
</html>
