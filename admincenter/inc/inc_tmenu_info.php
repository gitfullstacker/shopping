			<table width="100%" border=0 cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td align=right style="padding-right:20px;" >
						<table border=0 cellpadding=0 cellspacing=0>
							<tr valign=top>
								<td width=93></td>
								<td width=93></td>
								<td width=93></td>
								<td align=right style="line-height:28px;"><b><font color="#248edf"><?=$arr_Auth[2]?>(<?=$arr_Auth[0]?>)</font></b> 회원님 방문해 주셔서 감사합니다</td>
								<td width=10></td>
								<td><?If (Trim(Fnc_Om_Store_Info(3))!="") {?><a href="http://<?=Fnc_Om_Store_Info(3)?>" target=_blank><?}?><img src="/admincenter/img/goshop.gif" border=0></a></td>
								<td><a href="javascript:popupLayer('/admincenter/comm/comm_passwd.php', 400, 200);"><img src="/admincenter/img/change_pw.gif" border=0 alt="비밀번호 변경"></a></td>
								<td></td>
								<td></td>
								<td></td>
								<td><a href="/admincenter/logi/logi_logout.php"><img src="/admincenter/img/logout.gif" border=0></a></td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			