<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_idxcode  = Fnc_Om_Conv_Default($_REQUEST[str_idxcode],"04");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						FC.STR_IDXNUM,
						FC.STR_IDXWORD,
						FC.STR_CONTENTS,
						FC.INT_PERSENT,
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
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/code_pw_edit.js"></script>
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

						<form id="frm" name="frm" target="_self" method="POST" action="code_pw_edit.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_idxcode" value="<?=$str_idxcode?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>
						<table class=tb>
							<col class=cellC><col class=cellL>
							<tr>
								<td nowrap>힌트</td>
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


						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						<a href='code_pw_list.php?str_idxcode=<?=$str_idxcode?>'><img src='/admincenter/img/btn_list.gif'></a>
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
</body>
</html>

</body>
</html>