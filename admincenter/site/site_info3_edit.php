<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
		$SQL_QUERY =	" SELECT
						*
					FROM "
						.$Tname."comm_site_info
					WHERE
						INT_NUMBER=1 ";

		$arr_Rlt_Data=mysql_query($SQL_QUERY);
		if (!$arr_Rlt_Data) {
    		echo 'Could not run query: ' . mysql_error();
    		exit;
		}
		$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/site_info3_edit.js"></script>
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


						<form id="frm" name="frm" target="_self" method="POST" action="site_info_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">

						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<tr>
								<td>멤버쉽가입</td>
								<td>
									<select name=int_stamp1>
										<?for ($i = 0; $i <= 100; $i++) {?>
										<option value="<?=$i?>" <?If (Trim($i)==trim($arr_Data['INT_STAMP1'])) {?>selected<?}?>><?=$i?>개
										<?}?>
									</select>
								</td>
								<td>추천인ID</td>
								<td>
									<select name=int_stamp2>
										<?for ($i = 0; $i <= 100; $i++) {?>
										<option value="<?=$i?>" <?If (Trim($i)==trim($arr_Data['INT_STAMP2'])) {?>selected<?}?>><?=$i?>개
										<?}?>
									</select>
								</td>
							</tr>
							<tr>
								<td>이미지후기</td>
								<td>
									<select name=int_stamp3>
										<?for ($i = 0; $i <= 100; $i++) {?>
										<option value="<?=$i?>" <?If (Trim($i)==trim($arr_Data['INT_STAMP3'])) {?>selected<?}?>><?=$i?>개
										<?}?>
									</select>
								</td>
								<td>정기결제고객</td>
								<td>
									<select name=int_stamp4>
										<?for ($i = 0; $i <= 100; $i++) {?>
										<option value="<?=$i?>" <?If (Trim($i)==trim($arr_Data['INT_STAMP4'])) {?>selected<?}?>><?=$i?>개
										<?}?>
									</select>
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

	<tr><td height=3 bgcolor="#E6E6E6" colspan=2></td></tr>
	<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_copyright_info.php";?>
</table>
<script>table_design_load();</script>
</body>
</html>