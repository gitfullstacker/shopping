<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	//Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/logi_login.js"></script>
</head>
<body style="margin:0" onload="document.getElementById('str_userid').focus()">
<form method=post name="frm" action="/admincenter/logi/logi_login_chk.asp" onsubmit="return fncSendData()">
<table height=100% width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td width="50%" style="background:url(/admincenter/img/login_bg_left.gif) repeat-x left top"></td>
					<td align=center>
						<table cellpadding=0 cellspacing=0 border=0>
							<tr>
								<td valign=top height=100% style="padding:0 0 150 0">
									<table height=100% cellpadding=0 cellspacing=0 border=0>
										<tr>
											<td><img src="/admincenter/img/login_top.gif"></td>
										</tr>
										<tr>
											<td height=100%>
												<table cellpadding=5 cellspacing=0>
													<col><col style="padding-left:10px">
													<tr>
														<td height=28><img src="/admincenter/img/login/login_id.gif"></td>
														<td background="/admincenter/img/login_linebg.gif">
														<input type=text name=str_userid id=str_userid style="width:214px;background:transparent;border:0px;font:8pt verdana;color:333333">
														</td>
													</tr>
													<tr>
														<td height=28><img src="/admincenter/img/login/login_password.gif"></td>
														<td background="/admincenter/img/login_linebg.gif">
															<input type=password name=str_passwd style="width:214px;background:transparent;border:0px;font:8pt verdana;color:333333">
														</td>
													</tr>
													<tr><td height=10></td></tr>
													<tr>
														<td></td>
														<td><input type=image src="/admincenter/img/login/login_bu.gif"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td style="padding-top:40" align="center"><font class=small color=616161><?=Fnc_Om_Store_Info("7")?></font><!--<img src="/admincenter/img/login/login_copyright.gif">//--></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td width="50%" style="background:url(/admincenter/img/login_bg_right.gif) repeat-x left top;"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
</body>
</html>