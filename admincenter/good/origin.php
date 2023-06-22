<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	//Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);

	$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key],"all");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
	$Txt_brand = Fnc_Om_Conv_Default($_REQUEST[Txt_brand],"");
	$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service],"");

	$Txt_bname = Fnc_Om_Conv_Default($_REQUEST[Txt_bname],"");
	$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						A.*,B.STR_CODE AS STR_BRAND
					FROM "
						.$Tname."comm_goods_master AS A
						LEFT JOIN
						".$Tname."comm_com_code AS B
						ON
						A.INT_BRAND=B.INT_NUMBER
					WHERE
						A.STR_GOODCODE='$str_no' ";

		$arr_Rlt_Data=mysql_query($SQL_QUERY);
		if (!$arr_Rlt_Data) {
    		echo 'Could not run query: ' . mysql_error();
    		exit;
		}
		$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	}

	$str_String = "?Page=".$page."&displayrow=".urlencode($displayrow)."&Txt_key=".urlencode($Txt_key)."&Txt_word=".urlencode($Txt_word)."&Txt_brand=".urlencode($Txt_brand)."&Txt_service=".urlencode($Txt_service)."&Txt_bname=".urlencode($Txt_bname)."&Txt_bcode=".urlencode($Txt_bcode)."&Txt_sindate=".urlencode($Txt_sindate)."&Txt_eindate=".urlencode($Txt_eindate);
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script type="text/javascript" src="/_lib/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
<script language="javascript" src="js/good_master_edit.js"></script>
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

						<form id="frm" name="frm" target="_self" method="POST" action="good_master_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="str_String" value="<?=$str_String?>">
						<input type="hidden" name="str_dimage1" value="<?=$arr_Data['STR_IMAGE1']?>">
						<input type="hidden" name="str_dimage2" value="<?=$arr_Data['STR_IMAGE2']?>">
						<input type="hidden" name="str_dimage3" value="<?=$arr_Data['STR_IMAGE3']?>">
						<input type="hidden" name="str_dimage4" value="<?=$arr_Data['STR_IMAGE4']?>">
						<input type="hidden" name="str_dimage5" value="<?=$arr_Data['STR_IMAGE5']?>">
						<input type="hidden" name="str_dimage6" value="<?=$arr_Data['STR_IMAGE6']?>">
						<input type="hidden" name="str_dimage7" value="<?=$arr_Data['STR_IMAGE7']?>">
						<input type="hidden" name="str_dimage8" value="<?=$arr_Data['STR_IMAGE8']?>">
						<input type="hidden" name="str_dimage9" value="<?=$arr_Data['STR_IMAGE9']?>">
						<input type="hidden" name="Obj">

						<table width=100% border=0>
							<tr>
								<td valign=top width=100% style="padding-left:10px">

									<table class=tb>
										<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
										<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
										<tr>
											<td>카테고리</td>
											<td colspan="3">

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
															A.STR_SERVICE,
															IFNULL(B.STR_BCODE,'') AS STR_BCODE
														FROM 
															".$Tname."comm_menu_idx A
															LEFT JOIN 
															".$Tname."comm_goods_master_category B
															ON 
															A.STR_MENUTYPE=substring(B.STR_BCODE,1,2)
															AND
															A.STR_CHOCODE=substring(B.STR_BCODE,3,2)
															AND
															A.STR_UNICODE=substring(B.STR_BCODE,5,5)
															AND
															B.STR_GOODCODE='$str_no'
														WHERE
															A.STR_MENUTYPE='03'
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
																	<input type="checkbox" name="str_bcode[]" value="<?=$row[STR_MENUTYPE].$row[STR_CHOCODE].$row[STR_UNICODE]?>" <?if ($row[STR_BCODE]!="") {?> checked<?}?>> <?=$row[STR_IDXWORD]?>
																</td>
															</tr>
													<?}?>
												</table>

											</td>
										</tr>
										<tr> 
											<td>상품명[국]</td>
											<td><input type=text name=str_goodname value="<?=$arr_Data['STR_GOODNAME']?>" style="width:350px;"></td>
											<td>상품명[영]</td>
											<td><input type=text name=str_egoodname value="<?=$arr_Data['STR_EGOODNAME']?>" style="width:350px;"></td>
										</tr>
										<tr> 
											<td>상품보유수량</td>
											<td colspan="3" id="idView_Prodcode">
												<?if ($RetrieveFlag=="INSERT") {?>
												<select name=int_bsu>
													<?for ($i = 1; $i <= 100; $i++) {?>
													<option value="<?=$i?>" <?If (Trim($i)==trim($arr_Data['INT_BSU'])) {?>selected<?}?>><?=$i?>개
													<?}?>
												</select>
												<?}else{?>
													<script language="javascript">
														fuc_set('good_master_edit_proc.php?RetrieveFlag=PRODCODE&str_no=<?=$str_no?>','_Prodcode');
													</script>
												<?}?>
											</td>
										</tr>
										<tr>
											<td>목록이미지</td>
											<td colspan=3>
												<table class=tb>
													<tr>
														<td width="50%" align="center" valign="middle" height="20"><?=$arr_Data['STR_IMAGE1']?>&nbsp;</td>
														<td width="50%" align="center" valign="middle" height="20"><?=$arr_Data['STR_IMAGE2']?>&nbsp;</td>
													</tr>
													<tr>
														<td align="center" valign="middle" height="320"><?if ($RetrieveFlag=="UPDATE") {?><?if (!($arr_Data['STR_IMAGE1']=="")) {?><img src="/admincenter/files/good/<?=$arr_Data['STR_IMAGE1']?>" width="320" height="320" border="0"><?}else{?>&nbsp;<?}?><?}else{?>&nbsp;<?}?></td>
														<td align="center" valign="middle" height="320"><?if ($RetrieveFlag=="UPDATE") {?><?if (!($arr_Data['STR_IMAGE2']=="")) {?><img src="/admincenter/files/good/<?=$arr_Data['STR_IMAGE2']?>" width="320" height="320" border="0"><?}else{?>&nbsp;<?}?><?}else{?>&nbsp;<?}?></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>목록이미지1</td>
											<td colspan="3"><input type=file name=str_Image1 style="width:200;" onChange="uploadImageCheck(this)"> (320*320) <?if (!($arr_Data['STR_IMAGE1']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_img1" value="Y" class="null"><?}?></td>
										</tr>
										<tr>
											<td>목록이미지2</td>
											<td colspan="3"><input type=file name=str_Image2 style="width:200;" onChange="uploadImageCheck(this)"> (320*320) <?if (!($arr_Data['STR_IMAGE2']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_img2" value="Y" class="null"><?}?></td>
										</tr>
										<tr>
											<td>상세이미지</td>
											<td colspan=3>
												<table class=tb>
													<tr>
														<td width="<?=100/7?>%" align="center" valign="middle" height="20"><?=$arr_Data['STR_IMAGE3']?>&nbsp;</td>
														<td width="<?=100/7?>%" align="center" valign="middle" height="20"><?=$arr_Data['STR_IMAGE4']?>&nbsp;</td>
														<td width="<?=100/7?>%" align="center" valign="middle" height="20"><?=$arr_Data['STR_IMAGE5']?>&nbsp;</td>
														<td width="<?=100/7?>%" align="center" valign="middle" height="20"><?=$arr_Data['STR_IMAGE6']?>&nbsp;</td>
														<td width="<?=100/7?>%" align="center" valign="middle" height="20"><?=$arr_Data['STR_IMAGE7']?>&nbsp;</td>
														<td width="<?=100/7?>%" align="center" valign="middle" height="20"><?=$arr_Data['STR_IMAGE8']?>&nbsp;</td>
														<td width="<?=100/7?>%" align="center" valign="middle" height="20"><?=$arr_Data['STR_IMAGE9']?>&nbsp;</td>
													</tr>
													<tr>
														<td align="center" valign="middle" height="160"><?if ($RetrieveFlag=="UPDATE") {?><?if (!($arr_Data['STR_IMAGE3']=="")) {?><img src="/admincenter/files/good/<?=$arr_Data['STR_IMAGE3']?>" width="150" height="150" border="0"><?}else{?>&nbsp;<?}?><?}else{?>&nbsp;<?}?></td>
														<td align="center" valign="middle" height="160"><?if ($RetrieveFlag=="UPDATE") {?><?if (!($arr_Data['STR_IMAGE4']=="")) {?><img src="/admincenter/files/good/<?=$arr_Data['STR_IMAGE4']?>" width="150" height="150" border="0"><?}else{?>&nbsp;<?}?><?}else{?>&nbsp;<?}?></td>
														<td align="center" valign="middle" height="160"><?if ($RetrieveFlag=="UPDATE") {?><?if (!($arr_Data['STR_IMAGE5']=="")) {?><img src="/admincenter/files/good/<?=$arr_Data['STR_IMAGE5']?>" width="150" height="150" border="0"><?}else{?>&nbsp;<?}?><?}else{?>&nbsp;<?}?></td>
														<td align="center" valign="middle" height="160"><?if ($RetrieveFlag=="UPDATE") {?><?if (!($arr_Data['STR_IMAGE6']=="")) {?><img src="/admincenter/files/good/<?=$arr_Data['STR_IMAGE6']?>" width="150" height="150" border="0"><?}else{?>&nbsp;<?}?><?}else{?>&nbsp;<?}?></td>
														<td align="center" valign="middle" height="160"><?if ($RetrieveFlag=="UPDATE") {?><?if (!($arr_Data['STR_IMAGE7']=="")) {?><img src="/admincenter/files/good/<?=$arr_Data['STR_IMAGE7']?>" width="150" height="150" border="0"><?}else{?>&nbsp;<?}?><?}else{?>&nbsp;<?}?></td>
														<td align="center" valign="middle" height="160"><?if ($RetrieveFlag=="UPDATE") {?><?if (!($arr_Data['STR_IMAGE8']=="")) {?><img src="/admincenter/files/good/<?=$arr_Data['STR_IMAGE8']?>" width="150" height="150" border="0"><?}else{?>&nbsp;<?}?><?}else{?>&nbsp;<?}?></td>
														<td align="center" valign="middle" height="160"><?if ($RetrieveFlag=="UPDATE") {?><?if (!($arr_Data['STR_IMAGE9']=="")) {?><img src="/admincenter/files/good/<?=$arr_Data['STR_IMAGE9']?>" width="150" height="150" border="0"><?}else{?>&nbsp;<?}?><?}else{?>&nbsp;<?}?></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>상세이미지1</td>
											<td colspan="3"><input type=file name=str_Image3 style="width:200;" onChange="uploadImageCheck(this)"> (700*700) <?if (!($arr_Data['STR_IMAGE3']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_img3" value="Y" class="null"><?}?></td>
										</tr>
										<tr>
											<td>상세이미지2</td>
											<td colspan="3"><input type=file name=str_Image4 style="width:200;" onChange="uploadImageCheck(this)"> (700*700) <?if (!($arr_Data['STR_IMAGE4']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_img4" value="Y" class="null"><?}?></td>
										</tr>
										<tr>
											<td>상세이미지3</td>
											<td colspan="3"><input type=file name=str_Image5 style="width:200;" onChange="uploadImageCheck(this)"> (700*700) <?if (!($arr_Data['STR_IMAGE5']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_img5" value="Y" class="null"><?}?></td>
										</tr>
										<tr>
											<td>상세이미지4</td>
											<td colspan="3"><input type=file name=str_Image6 style="width:200;" onChange="uploadImageCheck(this)"> (700*700) <?if (!($arr_Data['STR_IMAGE6']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_img6" value="Y" class="null"><?}?></td>
										</tr>
										<tr>
											<td>상세이미지5</td>
											<td colspan="3"><input type=file name=str_Image7 style="width:200;" onChange="uploadImageCheck(this)"> (700*700) <?if (!($arr_Data['STR_IMAGE7']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_img7" value="Y" class="null"><?}?></td>
										</tr>
										<tr>
											<td>상세이미지6</td>
											<td colspan="3"><input type=file name=str_Image8 style="width:200;" onChange="uploadImageCheck(this)"> (700*700) <?if (!($arr_Data['STR_IMAGE8']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_img8" value="Y" class="null"><?}?></td>
										</tr>
										<tr>
											<td>상세이미지7</td>
											<td colspan="3"><input type=file name=str_Image9 style="width:200;" onChange="uploadImageCheck(this)"> (700*700) <?if (!($arr_Data['STR_IMAGE9']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_img9" value="Y" class="null"><?}?></td>
										</tr>
										<tr>
											<td>브랜드</td>
											<td>
												<input type="text" name=str_brand value="<?=$arr_Data['STR_BRAND']?>" style="width:280px;background-Color:#eeeded;" readonly>
												<input type="hidden" name=int_brand value="<?=$arr_Data['INT_BRAND']?>">
												<a href="javascript:popupLayer('/admincenter/comm/comm_brand.php?obj1=frm&obj2=int_brand&obj3=str_brand&str_menutype=03',400,450)"><img src="/admincenter/img/i_search.gif" align=absmiddle></a>
												<a href="javascript:fnc_blank('frm','int_brand','str_brand')"><img src="/admincenter/img/i_del.gif" align=absmiddle></a>
											</td>
											<td>소재</td>
											<td><input type=text name=str_material value="<?=$arr_Data['STR_MATERIAL']?>"></td>
										</tr>
										<tr>
											<td>크기</td>
											<td><input type=text name=str_size value="<?=$arr_Data['STR_SIZE']?>"></td>
											<td>정가</td>
											<td><input type=text name=int_price value="<?=$arr_Data['INT_PRICE']?>" style="ime-mode:inactive" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()"></td>
										</tr>
										<tr>
											<td>스트랩길이</td>
											<td><input type=text name=str_length value="<?=$arr_Data['STR_LENGTH']?>"></td>
											<td>원산지</td>
											<td><input type=text name=str_origin value="<?=$arr_Data['STR_ORIGIN']?>"></td>
										</tr>
										<tr>
											<td>사용감</td>
											<td>
												<select name=int_used>
													<?for ($i = 0; $i <= 10; $i++) {?>
													<option value="<?=$i?>" <?If (Trim($i)==trim($arr_Data['INT_USED'])) {?>selected<?}?>><?=$i?>
													<?}?>
												</select>
											</td>
											<td>색상</td>
											<td><input type=text name=str_color value="<?=$arr_Data['STR_COLOR']?>"></td>
										</tr>
										<tr>
											<td>태그</td>
											<td colspan="3"><input type=text name=str_tag value="<?=$arr_Data['STR_TAG']?>" style="width:700px;"></td>
										</tr>
										<tr>
											<td>출력여부</td>
											<td>
												<input type="radio" value="Y" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="Y") {?>checked<?}?>> 출력
												<input type="radio" value="N" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="N") {?>checked<?}?>> 미출력
												<!--<input type="radio" value="R" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="R") {?>checked<?}?>> //-->
											</td>
											<td>메인출력여부</td>
											<td>
												PC 
												<input type="radio" value="Y" name="str_myn" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_MYN'],"N")=="Y") {?>checked<?}?>> 출력
												<input type="radio" value="N" name="str_myn" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_MYN'],"N")=="N") {?>checked<?}?>> 미출력
												/
												MOBILE
												PC 
												<input type="radio" value="Y" name="str_mmyn" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_MMYN'],"N")=="Y") {?>checked<?}?>> 출력
												<input type="radio" value="N" name="str_mmyn" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_MMYN'],"N")=="N") {?>checked<?}?>> 미출력
											</td>
										</tr>
										<tr>
											<td>제품설명</td>
											<td colspan="3" style="padding-top:5px;padding-bottom:5px;">
												<textarea name="str_contents" id="str_contents" rows="10" cols="100" style="width:100%; height:412px; display:none;"><?php echo stripslashes($arr_Data['STR_CONTENTS']); ?></textarea>
												<script type="text/javascript">
												var oEditors = [];
												
												// 추가 글꼴 목록
												//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];
												
												nhn.husky.EZCreator.createInIFrame({
													oAppRef: oEditors,
													elPlaceHolder: "str_contents",
													sSkinURI: "/_lib/smart/SmartEditor2Skin.html",	
													htParams : {
														bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
														bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
														bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
														//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
														fOnBeforeUnload : function(){
															//alert("완료!");
														}
													}, //boolean
													fOnAppLoad : function(){
												
													},
													fCreator: "createSEditor2"
												});
												</script>
											</td>
										</tr>
										<?if ($RetrieveFlag=="UPDATE") {?>
										<tr>
											<td>등록일자</td>
											<td colspan="3"><font class=ver8><?=$arr_Data['DTM_INDATE']?></td>
										</tr>
										<?}?>
									</table>
								</td>
							</tr>
						</table>

						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						<a href='good_master_list.php<?=$str_String?>'><img src='/admincenter/img/btn_list.gif'></a>
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
