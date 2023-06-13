<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"1");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						FC.*
					FROM "
						.$Tname."comm_com_code AS FC
					WHERE
						FC.INT_NUMBER='$str_no' ";

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
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script type="text/javascript" src="/_lib/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
<script language="javascript" src="js/com_com_edit.js"></script>
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
		<td colspan="3"><?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu.php";?></td>
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
						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>

						<form id="frm" name="frm" target="_self" method="POST" action="com_com_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="int_gubun" value="<?=$int_gubun?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="str_dimage1" value="<?=$arr_Data['STR_IMAGE1']?>">
						<input type="hidden" name="str_dimage2" value="<?=$arr_Data['STR_IMAGE2']?>">
						<input type="hidden" name="str_dbanner1" value="<?=$arr_Data['STR_BANNER1']?>">
						<input type="hidden" name="str_dbanner2" value="<?=$arr_Data['STR_BANNER2']?>">
						<input type="hidden" name="str_dbanner3" value="<?=$arr_Data['STR_BANNER3']?>">
						<input type="hidden" name="str_dbanner4" value="<?=$arr_Data['STR_BANNER4']?>">
						<input type="hidden" name="str_dbanner5" value="<?=$arr_Data['STR_BANNER5']?>">
						<input type="hidden" name="str_dbanner6" value="<?=$arr_Data['STR_BANNER6']?>">
						<input type="hidden" name="str_dbanner7" value="<?=$arr_Data['STR_BANNER7']?>">
						<input type="hidden" name="Obj">

						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="padding-left:10px;width:88%">
							<tr>
								<td>코드명</td>
								<td colspan="3"><font class=def><input type=text name=str_code value="<?=$arr_Data['STR_CODE']?>" style="width:400px;"></td>
							</tr>
							<?if ($int_gubun=="2") {?>
							<tr>
								<td>코드명[국]</td>
								<td colspan="3"><font class=def><input type=text name=str_kcode value="<?=$arr_Data['STR_KCODE']?>" style="width:400px;"></td>
							</tr>							
							<?}?>
							<?if ($int_gubun=="2") {?>
							<tr>
								<td>로고이미지</td>
								<td colspan=3>
									<table class=tb>
										<tr>
											<td width="100%" align="center" valign="middle" height="20"><?=$arr_Data['STR_IMAGE1']?>&nbsp;</td>
											<!--<td width="50%" align="center" valign="middle" height="20"><?=$arr_Data['STR_IMAGE2']?>&nbsp;</td>//-->
										</tr>
										<tr>
											<td align="center" valign="middle" height="150"><?if ($RetrieveFlag=="UPDATE") {?><?if (!($arr_Data['STR_IMAGE1']=="")) {?><img src="/admincenter/files/com/<?=$arr_Data['STR_IMAGE1']?>" border="0"><?}else{?>&nbsp;<?}?><?}else{?>&nbsp;<?}?></td>
											<!--<td align="center" valign="middle" height="150"><?if ($RetrieveFlag=="UPDATE") {?><?if (!($arr_Data['STR_IMAGE2']=="")) {?><img src="/admincenter/files/com/<?=$arr_Data['STR_IMAGE2']?>" border="0"><?}else{?>&nbsp;<?}?><?}else{?>&nbsp;<?}?></td>//-->
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>로고이미지</td>
								<td colspan="3"><input type=file name=str_Image1 style="width:200;" onChange="uploadImageCheck(this)"> (가로 124 * 세로 63 이내) <?if (!($arr_Data['STR_IMAGE1']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_img1" value="Y" class="null"><?}?></td>
							</tr>
							<tr>
								<td>배너이미지1 (메인 탑 브랜드)</td>
								<td colspan="3"><input type=file name=str_Banner1 style="width:200;" onChange="uploadImageCheck(this)"> (가로 390 * 세로 302 이내) <?if (!($arr_Data['STR_BANNER1']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_banner1" value="Y" class="null"><?}?></td>
							</tr>
							<tr>
								<td>배너이미지2 (명품렌트 미니)</td>
								<td colspan="3"><input type=file name=str_Banner2 style="width:200;" onChange="uploadImageCheck(this)"> (가로 390 * 세로 302 이내) <?if (!($arr_Data['STR_BANNER2']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_banner2" value="Y" class="null"><?}?></td>
							</tr>
							<tr>
								<td>배너이미지3 (명품렌트 기본)</td>
								<td colspan="3"><input type=file name=str_Banner3 style="width:200;" onChange="uploadImageCheck(this)"> (가로 390 * 세로 302 이내) <?if (!($arr_Data['STR_BANNER3']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_banner3" value="Y" class="null"><?}?></td>
							</tr>
							<tr>
								<td>배너이미지4 (명품구독 미니)</td>
								<td colspan="3"><input type=file name=str_Banner4 style="width:200;" onChange="uploadImageCheck(this)"> (가로 390 * 세로 302 이내) <?if (!($arr_Data['STR_BANNER4']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_banner4" value="Y" class="null"><?}?></td>
							</tr>
							<tr>
								<td>배너이미지5 (명품구독 기본)</td>
								<td colspan="3"><input type=file name=str_Banner5 style="width:200;" onChange="uploadImageCheck(this)"> (가로 390 * 세로 302 이내) <?if (!($arr_Data['STR_BANNER5']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_banner5" value="Y" class="null"><?}?></td>
							</tr>
							<tr>
								<td>배너이미지6 (빈티지 미니)</td>
								<td colspan="3"><input type=file name=str_Banner6 style="width:200;" onChange="uploadImageCheck(this)"> (가로 390 * 세로 302 이내) <?if (!($arr_Data['STR_BANNER6']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_banner6" value="Y" class="null"><?}?></td>
							</tr>
							<tr>
								<td>배너이미지7 (빈티지 기본)</td>
								<td colspan="3"><input type=file name=str_Banner7 style="width:200;" onChange="uploadImageCheck(this)"> (가로 390 * 세로 302 이내) <?if (!($arr_Data['STR_BANNER7']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_banner7" value="Y" class="null"><?}?></td>
							</tr>
							<tr style="display:none;">
								<td>로고이미지2</td>
								<td colspan="3"><input type=file name=str_Image2 style="width:200;" onChange="uploadImageCheck(this)"> (가로 124 * 세로 63 이내) <?if (!($arr_Data['STR_IMAGE2']=="")) {?>- 삭제시 <input type="checkbox" name="str_del_img2" value="Y" class="null"><?}?></td>
							</tr>
							<?}?>
							<?if ($int_gubun=="5") {?>
							<tr>
								<td>배송추적URL</td>
								<td colspan="3"><font class=def><input type=text name=str_url1 value="<?=$arr_Data['STR_URL1']?>" style="width:600px;"></td>
							</tr>							
							<?}?>
							<tr>
								<td>출력유무</td>
								<td colspan=3>
									<input type="radio" value="Y" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="Y") {?>checked<?}?>> 출력
									<input type="radio" value="N" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="N") {?>checked<?}?>> 미출력
								</td>
							</tr>
							<tr>
								<td>메인출력유무</td>
								<td colspan=3>
									<input type="radio" value="Y" name="str_show_main" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SHOW_MAIN'],"Y")=="Y") {?>checked<?}?>> 출력
									<input type="radio" value="N" name="str_show_main" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SHOW_MAIN'],"Y")=="N") {?>checked<?}?>> 미출력
								</td>
							</tr>
							<tr>
								<td>구독출력유무</td>
								<td colspan=3>
									<input type="radio" value="Y" name="str_show_sub" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SHOW_SUB'],"Y")=="Y") {?>checked<?}?>> 출력
									<input type="radio" value="N" name="str_show_sub" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SHOW_SUB'],"Y")=="N") {?>checked<?}?>> 미출력
								</td>
							</tr>
							<tr>
								<td>렌트출력유무</td>
								<td colspan=3>
									<input type="radio" value="Y" name="str_show_ren" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SHOW_REN'],"Y")=="Y") {?>checked<?}?>> 출력
									<input type="radio" value="N" name="str_show_ren" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SHOW_REN'],"Y")=="N") {?>checked<?}?>> 미출력
								</td>
							</tr>
							<tr>
								<td>빈티지출력유무</td>
								<td colspan=3>
									<input type="radio" value="Y" name="str_show_vin" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SHOW_VIN'],"Y")=="Y") {?>checked<?}?>> 출력
									<input type="radio" value="N" name="str_show_vin" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SHOW_VIN'],"Y")=="N") {?>checked<?}?>> 미출력
								</td>
							</tr>
							<?if ($int_gubun=="5") {?>
							<tr>
								<td>출력유무</td>
								<td colspan=3>
									<input type="radio" value="0" name="str_default" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_DEFAULT'],"0")=="0") {?>checked<?}?>> 디폴트 미출력
									<input type="radio" value="1" name="str_default" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_DEFAULT'],"0")=="1") {?>checked<?}?>> 디폴트 출력
								</td>
							</tr>
							<?}?>
							<?if ($RetrieveFlag=="UPDATE") {?>
							<tr>
								<td>등록일자</td>
								<td colspan=3 class=noline><font class=def>
									<?=$arr_Data['DTM_INDATE']?>
								</td>
							</tr>
							<?}?>
						</table>


						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						<a href='com_com_list.php?int_gubun=<?=$int_gubun?>'><img src='/admincenter/img/btn_list.gif'></a>
						</div>

						</form>

						<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_btip_info.php";?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr><td height=3 bgcolor="#E6E6E6" colspan=2></td></tr>
	<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_copyright_info.php";?>
</table>
<script>table_design_load();</script>
</body>
</html>
