<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						*
					FROM "
						.$Tname."comm_faq AS A
					WHERE
						A.INT_NUMBER='$str_no' ";

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
<script language="javascript" src="js/faq_faq_edit.js"></script>
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

						<form id="frm" name="frm" target="_self" method="POST" action="faq_faq_edit.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">

						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="padding-left:10px;width:38%">
							<col class=cellC style="width:12%"><col class=cellL style="padding-left:10px;width:38%">
							<tr>
								<td>분류</td>
								<td colspan="3"><font class=def>
									<?
									$SQL_QUERY = "select a.* from ";
									$SQL_QUERY.=$Tname;
									$SQL_QUERY.="comm_com_code a ";
									$SQL_QUERY.="where a.int_gubun='3' and a.str_service='Y' ";
									$SQL_QUERY.="order by a.int_number asc ";

									$arr_Code_Menu = mysql_query($SQL_QUERY);
									?>
									<select name=int_gubun style="width:200px;">
										<option value="">선택
										<?while($row=mysql_fetch_array($arr_Code_Menu)){?>
										<option value="<?=$row[INT_NUMBER]?>" <?if ($row[INT_NUMBER]==$arr_Data['INT_GUBUN']) {?>selected<?}?>><?=$row[STR_CODE]?>
										<?}?>
									</select>
								</td>
							</tr>
							<tr>
								<td>질문</td>
								<td colspan="3"><font class=def><input type=text name=str_quest value="<?=$arr_Data['STR_QUEST']?>" size=80></td>
							</tr>
							<tr>
								<td>답변</td>
								<td colspan="3" style="padding-top:5px;padding-bottom:5px;">
									<textarea name="str_answer" id="str_answer" rows="10" cols="100" style="width:100%; height:412px; display:none;"><?php echo $arr_Data['STR_ANSWER']; ?></textarea>
									<script type="text/javascript">
									var oEditors = [];
									
									nhn.husky.EZCreator.createInIFrame({
										oAppRef: oEditors,
										elPlaceHolder: "str_answer",
										sSkinURI: "/_lib/smart/SmartEditor2Skin.html",	
										htParams : {
											bUseToolbar : true,				
											bUseVerticalResizer : true,	
											bUseModeChanger : true,	
											fOnBeforeUnload : function(){
												//alert("완료!");
											}
										}, //boolean
										fOnAppLoad : function(){
											//예제 코드
											//oEditors.getById["str_contents"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
										},
										fCreator: "createSEditor2"
									});
									</script>	
								</td>
							</tr>
							<tr>
								<td>출력유무</td>
								<td>
									<input type="radio" value="Y" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="Y") {?>checked<?}?>> 출력
									<input type="radio" value="N" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="N") {?>checked<?}?>> 미출력
								</td>
								<td>메인출력유무</td>
								<td>
									<input type="radio" value="Y" name="str_mservice" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_MSERVICE'],"N")=="Y") {?>checked<?}?>> 출력
									<input type="radio" value="N" name="str_mservice" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_MSERVICE'],"N")=="N") {?>checked<?}?>> 미출력
								</td>
							</tr>
							<?If ($RetrieveFlag=="UPDATE") {?>
							<tr>
								<td>등록일자</td>
								<td colspan="3"><font class=ver8><?=$arr_Data['DTM_INDATE']?></td>
							</tr>
							<?}?>
						</table>
						<script language="JSCript">
							//**	사용할 Textarea의 이름을 삽입
							if(bitUseEditor){
								Editor_New_Generate('str_answer');

							}
						</script>


						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						<a href='faq_faq_list.php'><img src='/admincenter/img/btn_list.gif'></a>
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
