<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
//	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/comm_passwd.js"></script>
</head>
<body topmargin=5 margintop=5 leftmargin=10 rightmargin=10 marginwidth=10 marginheight=5 onLoad="document.frm.str_opasswd.focus();">

			<table width=100%>
				<tr>
					<td style="padding-top:10px;padding-left:10px;padding-right:10px;">

						<form id="frm" name="frm" target="_self" method="POST" action="comm_passwd.asp">
						<input type="hidden" name="RetrieveFlag" value="<%=RetrieveFlag%>">
						<div class="title title_top">비밀번호변경</div>
						<table class=tb>
							<col class=cellC><col style="padding-left:10px">
							<tr>
								<td>기존비밀번호</td>
								<td colspan=3><font class=def><input type=password name=str_opasswd maxlength="12"></td>
							</tr>
							<tr>
								<td>새비밀번호</td>
								<td colspan=3><font class=def><input type=password name=str_passwd1 maxlength="12"></td>
							</tr>
							<tr>
								<td>비밀번호확인</td>
								<td colspan=3><font class=def><input type=password name=str_passwd2 maxlength="12"></td>
							</tr>
						</table>
						<table border="0" style="display:none;">
							<tr>
								<td id="obj_Lbl" colspan="2" height="0"></td>
							</tr>
						</table>
						<br>
						<table border=0 cellspacing=0 cellpadding=0 align=center>
							<tr>
								<td align="center"><a href="javascript:Save_Pw();"><img src="/admincenter/img/btn_modify.gif"></a></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
<script>table_design_load();</script>
</body>
</html>