<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
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
						.$Tname."comm_code AS FC
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
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="JScript">
		var Editor_Root_Dir	=	"/pub/js/";
		var appName		= navigator.appName;
		var appVersion	= parseFloat(navigator.appVersion.split("MSIE")[1]);
		var bitUseEditor
			if(appName != "Microsoft Internet Explorer" || appVersion < 5.5){
				bitUseEditor	= false;
			}else{
				bitUseEditor	= true;
			}
		if(bitUseEditor){
			document.write('<scrip'+'t language="JScript" src="'+Editor_Root_Dir+'KNEditor.js"></scrip'+'t>');
		}
</script>
<script language="javascript" src="js/memb_cen_edit.js"></script>
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
		<td valign=top id=leftMenu>
			<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_lmenu_info.php";?>
		</td>
		<td colspan=2 valign=top height=100%>
			<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_stitle_info.php";?>
			<table width=100%>
				<tr>
					<td style="padding:10px">

						<form id="frm" name="frm" target="_self" method="POST" action="memb_cen_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="int_gubun" value="<?=$int_gubun?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="Obj">

						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>


						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="padding-left:10px;width:88%">
							<tr>
								<td>코드명</td>
								<td colspan="3"><font class=def><input type=text name=str_code value="<?=$arr_Data['STR_CODE']?>" size=40></td>
							</tr>
							<tr>
								<td>출력유무</td>
								<td colspan=3>
									<input type="radio" value="Y" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="Y") {?>checked<?}?>> 출력
									<input type="radio" value="N" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="N") {?>checked<?}?>> 미출력
								</td>
							</tr>
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
						<a href='memb_cen_list.php?int_gubun=<?=$int_gubun?>'><img src='/admincenter/img/btn_list.gif'></a>
						</div>

						</form>

						<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_btip_info.php";?>
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
	<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_copyright_info.php";?>
</table>
<script>table_design_load();</script>
</body>
</html>

</body>
</html>