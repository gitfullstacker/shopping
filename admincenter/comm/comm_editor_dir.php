<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?   
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="JavaScript" src="js/comm_editor_dir.js"></script>
</head>
<body class=scroll>

			<table width=100%>
				<tr>
					<td style="padding:10px">
					
						<div class="title title_top">폴더관리</div>

						<form id="frm" name="frm" target="_self" method="POST" action="comm_editor_list_proc.php" enctype="MULTIPART/FORM-DATA">
						<input type="hidden" name="RetrieveFlag">
						<input type="hidden" name="str_location" value="/admincenter/files/data/">

						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr><td class=rnd colspan=2></td></tr>
							<tr class=rndbg>
								<th colspan="2" align="center">폴더명을 넣어주세요.</th>
							</tr>
							<tr><td class=rnd colspan=2></td></tr>
							<col width=30% align=center>
							<col width=70% align=left>
							<tr><td colspan=2 class=rndline></td></tr>
							<tr bgcolor="#ffffff">
								<td height="25" align="center"  width="80"><b>폴더명</b></td>
								<td><input type="text" name="str_dir" value="" size="24"></td>
							</tr>
							<tr><td colspan=2 class=rndline></td></tr>
							<tr bgcolor="#ffffff">
								<td colspan="2" height="30" align="center">
									<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_regist_s.gif"></a>
								</td>
							</tr>
						</table>
						
						</form>
						
					</td>
				</tr>
			</table>

</body>
</html>