<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	//Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$SQL_QUERY =	" SELECT
				DISTINCT(A.STR_UNICODE),
				A.STR_MENUTYPE,
				A.INT_CHOSORT,
				A.STR_CHOCODE,
				A.INT_UNISORT,
				A.STR_MENUPATH,
				A.STR_IDXWORD,
				B.STR_BTMFLAG
			FROM ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_menu_idx A, ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_menu_con B 
			WHERE
				A.STR_MENUTYPE=B.STR_MENUTYPE
				AND
				A.STR_CHOCODE=B.STR_CHOCODE
				AND
				A.STR_UNICODE=B.STR_UNICODE
				AND
				A.STR_UNICODE < '20000'
				AND
				A.STR_MENUTYPE='03'
				AND
				A.STR_SERVICE='Y'
			ORDER BY
				A.STR_MENUTYPE ASC,
				A.INT_CHOSORT ASC,
				A.STR_CHOCODE ASC,
				A.INT_UNISORT,
				A.STR_UNICODE ASC";
				
	$arr_Data=mysql_query($SQL_QUERY);
	$arr_Data_Cnt=mysql_num_rows($arr_Data);
	
	if ($arr_Data_Cnt) {
		$str_bcode=mysql_result($arr_Data,0,str_menutype).mysql_result($arr_Data,0,str_chocode).mysql_result($arr_Data,0,str_unicode);
	}
	$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode],$str_bcode);
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/good_ranking_edit.js"></script>
<script type="text/javascript" src="/_lib/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_logo_info.php";?>
		<td width=100%>
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu_info.php";?>
		</td>
	</tr>
	<tr>
		<td valign=top id=leftMenu>
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_lmenu_info.php";?>
		</td>
		<td colspan=2 valign=top height=100%>
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_stitle_info.php";?>
			<table width=100%>
				<tr>
					<td style="padding:10px">

						<form id="frm" name="frm" target="_self" method="POST" action="good_ranking_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="Txt_bcode" value="<?=$Txt_bcode?>">

						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>

						<table width=100% border=0>
							<tr>
								<td valign=top width=100% style="padding-left:10px">

									<table class=tb>
										<col class=cellC style="width:12%;"><col style="padding-left:10px;width:88%;">
										<tr>
											<td>카테고리</td>
											<td colspan="3">
												<table class=tb>
													<?
														for($int_I = 0 ;$int_I < $arr_Data_Cnt; $int_I++) {
													?>
													<col style="padding-left:10px;width:<?=100/$arr_Data_Cnt?>%;">
													<?
														}
													?>
													<tr>
													<?
														for($int_I = 0 ;$int_I < $arr_Data_Cnt; $int_I++) {
													?>
													<td>
														<a href="good_ranking_edit.php?Txt_bcode=<?=mysql_result($arr_Data,$int_I,str_menutype).mysql_result($arr_Data,$int_I,str_chocode).mysql_result($arr_Data,$int_I,str_unicode)?>">
														<?if ($Txt_bcode==mysql_result($arr_Data,$int_I,str_menutype).mysql_result($arr_Data,$int_I,str_chocode).mysql_result($arr_Data,$int_I,str_unicode)) {?>
															<b><?=mysql_result($arr_Data,$int_I,str_idxword)?></b>
														<?}else{?>
															<?=mysql_result($arr_Data,$int_I,str_idxword)?>
														<?}?>
														</a>
													</td>
													<?
														}
													?>
													</tr>
												</table>
											</td>
										</tr>
										<?
											for($int_I = 0 ;$int_I < 8; $int_I++) {
										?>
										<tr> 
											<td>BEST<?=$int_I+1?></td>
											<td colspan="3">
												<?
												$SQL_QUERY =	" SELECT
																A.*,B.STR_GOODNAME
															FROM "
																.$Tname."comm_goods_ranking AS A
																INNER JOIN
																".$Tname."comm_goods_master AS B
																ON
																A.STR_GOODCODE=B.STR_GOODCODE
															WHERE
																A.STR_BCODE='$Txt_bcode' AND A.INT_GUBUN='".($int_I+1)."' ";
										
												$arr_Rlt_Data=mysql_query($SQL_QUERY);
												
												if (!$arr_Rlt_Data) {
										    		echo 'Could not run query: ' . mysql_error();
										    		exit;
												}
												$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
												?>
												<input type=text name="str_goodname<?=$int_I+1?>" value="<?=$arr_Data['STR_GOODNAME']?>" style="width:350px;" readonly>
												<a href="javascript:popupLayer('good_list.php?obj1=frm&obj2=str_goodname<?=$int_I+1?>&obj3=str_goodcode<?=$int_I+1?>',500,600)"><img src="/admincenter/img/btn_s_search.gif" align="absmiddle"></a>
												<a href="javascript:fnc_blank('frm', 'str_goodname<?=$int_I+1?>', 'str_goodcode<?=$int_I+1?>')"><img src="/admincenter/img/btn_s_del.gif" align="absmiddle"></a>
											</td>
										</tr>
										<input type="hidden" name="str_goodcode<?=$int_I+1?>" value="<?=$arr_Data['STR_GOODCODE']?>">
										<?
											}
										?>
									</table>
								</td>
							</tr>
						</table>

						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						</div>

						</form>

						<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_btip_info.php";?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="border-right:3px solid #06372B;font-size:0px">&nbsp;</td>
		<td height=3 bgcolor=#323232 colspan=2></td>
	</tr>
	<tr><td height=10></td></tr>
	<tr><td height=3 bgcolor="#E6E6E6" colspan=2></td></tr>
	<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_copyright_info.php";?>
</table>
<script>table_design_load();</script>
<table border="0" style="display:none;">
	<tr>
		<td id="obj_Lbl" colspan="2" height="0"></td>
	</tr>
</table>
</body>
</html>

</body>
</html>