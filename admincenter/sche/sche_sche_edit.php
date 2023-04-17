<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	//Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$sgbn = Fnc_Om_Conv_Default($_REQUEST[sgbn],"1");
	$year = Fnc_Om_Conv_Default($_REQUEST[year],"");
	$month = Fnc_Om_Conv_Default($_REQUEST[month],"");
	$day = Fnc_Om_Conv_Default($_REQUEST[day],"");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						A.*
					FROM "
						.$Tname."comm_sche AS A
					WHERE
						A.INT_NUMBER='$str_no' ";

		$arr_Rlt_Data=mysql_query($SQL_QUERY);
		if (!$arr_Rlt_Data) {
    		echo 'Could not run query: ' . mysql_error();
    		exit;
		}
		$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	}

	$str_String = "?Page=".$page."&sgbn=".urlencode($sgbn)."&year=".urlencode($year)."&month=".urlencode($month)."&day=".urlencode($day);
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<link rel="stylesheet" type="text/css" href="/comm/js/jquery-ui/themes/base/jquery-ui.css" />
<script type="text/javascript" src="/comm/js/jquery.min.js"></script>
<script type="text/javascript" src="/comm/js/jquery-ui/ui/jquery-ui.js"></script>
<script type="text/javascript" src="/_lib/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
<script language="javascript" src="js/sche_sche_edit.js"></script>
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

						<form id="frm" name="frm" target="_self" method="POST" action="sche_sche_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="str_String" value="<?=$str_String?>">
						<input type="hidden" name="sgbn" value="<?=$sgbn?>">
						<input type="hidden" name="year" value="<?=$year?>">
						<input type="hidden" name="month" value="<?=$month?>">
						<input type="hidden" name="day" value="<?=$day?>">				
						<input type="hidden" name="Obj">

						<table width=100% border=0>
							<tr>
								<td valign=top width=100% style="padding-left:10px">

									<table class=tb>
										<col class=cellC style="width:12%;"><col style="padding-left:10px;width:88%;">
										<tr>
											<td>일자/시간</td>
											<td colspan="3">
												<input type=text name=str_date value="<?=Fnc_Om_Conv_Default($arr_Data['STR_DATE'],date("Y-m-d"))?>" id="str_date" onclick="displayCalendar(document.frm.str_date ,'yyyy-mm-dd',this)">
												<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.str_date ,'yyyy-mm-dd',document.frm.str_date)">
												<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.str_date.value=''";>
												/
												<select name="str_time1">
													<option value="">선택
													<?for ($i = 0; $i <= 23; $i++) {?>
													<option value="<?=Fnc_Om_Add_Zero($i,2)?>" <?If (Trim(Fnc_Om_Add_Zero($i,2))==trim(substr($arr_Data['STR_TIME'],0,2))) {?>selected<?}?>><?=Fnc_Om_Add_Zero($i,2)?>
													<?}?>
												</select>
												시
												<select name="str_time2">
													<option value="">선택
													<option value="00" <?If ("00"==trim(substr($arr_Data['STR_TIME'],3,2))) {?>selected<?}?>>00
													<option value="30" <?If ("30"==trim(substr($arr_Data['STR_TIME'],3,2))) {?>selected<?}?>>30
												</select>
												분
											</td>
										</tr>
										<tr> 
											<td>제목</td>
											<td colspan="3"><input type=text name=str_title value="<?=stripslashes($arr_Data['STR_TITLE'])?>" style="width:350px;"></td>
										</tr>
										<tr>
											<td>출력여부</td>
											<td colspan="3">
												<input type="radio" value="A" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="A") {?>checked<?}?>> 접수
												<input type="radio" value="Y" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="Y") {?>checked<?}?>> 출력
												<input type="radio" value="N" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="N") {?>checked<?}?>> 미출력
											</td>
										</tr>
										<tr>
											<td>내용</td>
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
										<tr>
											<td>첨부파일
												<span class="dfBtnEff" id="labSchAdd1">
													<img src="/admincenter/img/btn_s_add.gif" alt="" align="absmiddle" style="cursor:pointer"/>
												</span>
											</td>
											<td colspan="3">
												<span id="idView_File"></span>
									 			
												<script language="javascript">
													fuc_set('sche_sche_edit_proc.php?RetrieveFlag=Load&str_no=<?=$str_no?>','_File');
												</script>
											

												<table class=tb id="labCopyTable1">
													<thead>
													<col width=90% align=left>
													<col width=10% align=center>
													</thead>
													<tbody>
													<tr style="display:none;">
														<td>
															<input type=file name=str_sImage1[] style="width:200;" onChange="uploadImageCheck1(this)"> 
															<input type="hidden" name="int_fnumber">
														</td>
														<td style="text-align:center;">
															<span class="dfBtnEff" onclick="remSchedule1(this);">
																<img src="/admincenter/img/btn_s_del.gif" align="absmiddle" style="cursor:pointer"/>
															</span>
														</td>
													</tr>

												</table>
											
											
											
											</td>
										</tr>
										<tr>
											<td>출처
												<span class="dfBtnEff" id="labSchAdd2">
													<img src="/admincenter/img/btn_s_add.gif" alt="" align="absmiddle" style="cursor:pointer"/>
												</span>
											</td>
											<td colspan="3">

												<table class=tb id="labCopyTable2">
													<thead>
													<tr class=rndbg>
														<th>출처</th>
														<th>제목</th>
														<th>연결주소</th>
														<th>삭제</th>
													</tr>
													<col width=20% align=left>
													<col width=30% align=center>
													<col width=40% align=center>
													<col width=10% align=center>
													</thead>
													<tbody>
													<tr style="display:none;">
														<td>
															<input type="text" name=str_source[] style="width:100%;"> 
															<input type="hidden" name="int_nnumber[]">
														</td>
														<td>
															<input type="text" name=str_stitle[] style="width:100%;"> 
														</td>
														<td>
															<input type="text" name=str_url[] style="width:100%;"> 
														</td>
														<td style="text-align:center;">
															<span class="dfBtnEff" onclick="remSchedule2(this);">
																<img src="/admincenter/img/btn_s_del.gif" align="absmiddle" style="cursor:pointer"/>
															</span>
														</td>
													</tr>
													<?
													$SQL_QUERY = "select * from ";
																$SQL_QUERY .= $Tname;
																$SQL_QUERY .= "comm_sche_news
															where
																int_number='".$str_no."'
															order by int_nnumber asc " ;
									
													$arr_sub_Data=mysql_query($SQL_QUERY);
													?>
													<?while($row=mysql_fetch_array($arr_sub_Data)){?>
													<tr>
														<td>
															<input type="text" name=str_source[] style="width:100%;" value="<?=stripslashes($row[STR_SOURCE])?>">
															<input type="hidden" name="int_nnumber" value="<?=$row[INT_NNUMBER]?>">
														</td>
														<td>
															<input type="text" name=str_stitle[] style="width:100%;" value="<?=stripslashes($row[STR_STITLE])?>">
														</td>
														<td>
															<input type="text" name=str_url[] style="width:100%;" value="<?=$row[STR_URL]?>">
														</td>
														<td style="text-align:center;">
															<span class="dfBtnEff" onclick="remSchedule2(this);">
																<img src="/admincenter/img/btn_s_del.gif" align="absmiddle" style="cursor:pointer"/>
															</span>
														</td>
													</tr>
													<?}?>
												</table>
											
											
											
											</td>
										</tr>
										<tr>
											<td>등록일자</td>
											<td colspan="3">
												<input type=text name=str_indate1 value="<?=substr(Fnc_Om_Conv_Default($arr_Data['DTM_INDATE'],date("Y-m-d")),0,10)?>" id="str_indate1" onclick="displayCalendar(document.frm.str_indate1 ,'yyyy-mm-dd',this)">
												<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.str_indate1 ,'yyyy-mm-dd',document.frm.str_date)">
												<!--<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.str_indate1.value=''";>//-->
												/
												<select name="str_indate2">
													<?for ($i = 0; $i <= 23; $i++) {?>
													<option value="<?=Fnc_Om_Add_Zero($i,2)?>" <?If (Trim(Fnc_Om_Add_Zero($i,2))==trim(Fnc_Om_Conv_Default(substr($arr_Data['DTM_INDATE'],11,2),Fnc_Om_Add_Zero(date("H"),2)))) {?>selected<?}?>><?=Fnc_Om_Add_Zero($i,2)?>
													<?}?>
												</select>
												시
												<select name="str_indate3">
													<?for ($i = 0; $i <= 59; $i++) {?>
													<option value="<?=Fnc_Om_Add_Zero($i,2)?>" <?If (Trim(Fnc_Om_Add_Zero($i,2))==trim(Fnc_Om_Conv_Default(substr($arr_Data['DTM_INDATE'],14,2),Fnc_Om_Add_Zero(date("i"),2)))) {?>selected<?}?>><?=Fnc_Om_Add_Zero($i,2)?>
													<?}?>
												</select>
												분
											</td>
										</tr>
										<?if ($RetrieveFlag=="UPDATE") {?>
										<tr>
											<td>수정일자</td>
											<td colspan="3"><font class=ver8><?=$arr_Data['DTM_MODATE']?></td>
										</tr>
										<tr>
											<td>등록자</td>
											<td colspan="3"><font class=ver8><?=$arr_Data['STR_INUSERID']?></td>
										</tr>
										<tr>
											<td>수정자</td>
											<td colspan="3"><font class=ver8><?=$arr_Data['STR_MOUSERID']?></td>
										</tr>
										<?}?>
									</table>
								</td>
							</tr>
						</table>

						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						<a href='sche_sche_list.php<?=$str_String?>'><img src='/admincenter/img/btn_list.gif'></a>
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
<script type="text/javascript">

	$('#labSchAdd1').click(function(){
		$("#labCopyTable1").append('<tr>'+$("#labCopyTable1 tbody tr:first").html()+'</tr>');
	});
	function remSchedule1(obj)
	{
		$(obj).parent().parent().remove();
	}	
	$('#labSchAdd2').click(function(){
		$("#labCopyTable2").append('<tr>'+$("#labCopyTable2 tbody tr:first").html()+'</tr>');
	});
	function remSchedule2(obj)
	{
		$(obj).parent().parent().remove();
	}
</script>