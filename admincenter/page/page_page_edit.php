<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"");

	$SQL_QUERY =	" SELECT
					FC.*
				FROM "
					.$Tname."comm_page_info AS FC
				WHERE
					FC.INT_GUBUN='$int_gubun' ";

	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	
	if ($arr_Data['DTM_INDATE']=="") {
		$RetrieveFlag = "INSERT";
	}else{
		$RetrieveFlag = "UPDATE";
	}
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script type="text/javascript" src="/_lib/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
<script language="javascript" src="js/page_page_edit.js"></script>
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

						<form id="frm" name="frm" target="_self" method="POST" action="page_page_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="int_gubun" value="<?=$int_gubun?>">
						<input type="hidden" name="Obj">

						<table class=tb>
							<?if ($RetrieveFlag=="UPDATE") {?>
							<col class=cellC style="width:12%"><col style="padding-left:10px;width:38%">
							<col class=cellC style="width:12%"><col style="padding-left:10px;width:38%">
							<?}else{?>
							<col class=cellC style="width:12%"><col style="padding-left:10px;width:88%">
							<?}?>
							<tr>
								<td>내용</td>
								<td colspan="3">
									<textarea name="str_contents" id="str_contents" rows="10" cols="100" style="width:100%; height:712px;"><?php echo stripslashes($arr_Data['STR_CONTENTS']); ?></textarea>
									<script type="text/javascript">
									var oEditors = [];
									
									nhn.husky.EZCreator.createInIFrame({
										oAppRef: oEditors,
										elPlaceHolder: "str_contents",
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
							<?if ($RetrieveFlag=="UPDATE") {?>
							<tr>
								<td>등록일자</td>
								<td class=noline><font class=def>
									<?=$arr_Data['DTM_INDATE']?>
								</td>
								<td>수정일자</td>
								<td class=noline><font class=def>
									<?=$arr_Data['DTM_ACDATE']?>
								</td>
							</tr>
							<?}?>
						</table>


						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
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
