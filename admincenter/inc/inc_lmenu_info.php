			<table height=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td style="border-right:1px solid #b4b4b4;" height=100% valign=top>
						<?
						$SQL_QUERY =	" SELECT
										DISTINCT(A.Str_UNICODE),
										A.Str_MENUTYPE,
										A.INT_CHOSORT,
										A.Str_CHOCODE,
										A.INT_UNISORT,
										A.Str_MENUPATH,
										A.Str_IDXWORD,
										B.Str_BTMFLAG
									FROM ";
										$SQL_QUERY .= $Tname;
										$SQL_QUERY .= "comm_menu_idx A, ";
										$SQL_QUERY .= $Tname;
										$SQL_QUERY .= "comm_menu_con B, ";
										$SQL_QUERY .= $Tname;
										$SQL_QUERY .= "comm_menu_right C
									WHERE
										A.Str_MENUTYPE=B.Str_MENUTYPE
										AND
										A.Str_CHOCODE=B.Str_CHOCODE
										AND
										A.Str_UNICODE=B.Str_UNICODE
										AND
										A.Str_MENUTYPE=C.Str_MENUTYPE
										AND
										A.Str_CHOCODE=C.Str_CHOCODE
										AND
										A.Str_UNICODE=C.Str_UNICODE
										AND
										C.Str_IDXCODE='01'
										AND
										A.Str_CHOCODE='".substr($arr_Auth[7],0,2)."'
										AND
										A.Str_UNICODE > '20000'
										AND
										A.Str_UNICODE < '30000'
										AND
										C.Str_IDXNUM='$arr_Auth[3]'
										AND
										A.Str_SERVICE='Y'
									ORDER BY
										A.Str_MENUTYPE ASC,
										A.INT_CHOSORT ASC,
										A.Str_CHOCODE ASC,
										A.INT_UNISORT,
										A.Str_UNICODE ASC";

						$arr_Rlt_Menu=mysql_query($SQL_QUERY);
						?>
						<div align=left>
						<table width=190 cellpadding=0 cellspacing=0>
							<?while($row=mysql_fetch_array($arr_Rlt_Menu)){?>
							<tr>
								<td height=40 style="color:#252525;font-weight:bold;padding-left:26px;background:#dedede url('/admincenter/img/blet_admin_menutit.gif') no-repeat 160px 50%;"><?=$row[Str_IDXWORD]?></td>
							</tr>
							<?
							$SQL_QUERY =	" SELECT
											DISTINCT(A.Str_UNICODE),
											A.Str_MENUTYPE,
											A.INT_CHOSORT,
											A.Str_CHOCODE,
											A.INT_UNISORT,
											A.Str_MENUPATH,
											A.Str_IDXWORD,
											B.Str_BTMFLAG
										FROM ";
											$SQL_QUERY .= $Tname;
											$SQL_QUERY .= "comm_menu_idx A, ";
											$SQL_QUERY .= $Tname;
											$SQL_QUERY .= "comm_menu_con B, ";
											$SQL_QUERY .= $Tname;
											$SQL_QUERY .= "comm_menu_right C
										WHERE
											A.Str_MENUTYPE=B.Str_MENUTYPE
											AND
											A.Str_CHOCODE=B.Str_CHOCODE
											AND
											A.Str_UNICODE=B.Str_UNICODE
											AND
											A.Str_MENUTYPE=C.Str_MENUTYPE
											AND
											A.Str_CHOCODE=C.Str_CHOCODE
											AND
											A.Str_UNICODE=C.Str_UNICODE
											AND
											C.Str_IDXCODE='01'
											AND
											A.Str_CHOCODE='".substr($arr_Auth[7],0,2)."'
											AND
											A.Str_UNICODE > '30000'
											AND
											A.Str_UNICODE < '40000'
											AND
											B.Str_CHOCODE='$row[Str_CHOCODE]'
											AND
											B.Str_TOPCODE='$row[Str_UNICODE]'
											AND
											C.Str_IDXNUM='$arr_Auth[3]'
											AND
											A.Str_SERVICE='Y'
										ORDER BY
											A.Str_MENUTYPE ASC,
											A.INT_CHOSORT ASC,
											A.Str_CHOCODE ASC,
											A.INT_UNISORT,
											A.Str_UNICODE ASC";

							$arr_Rlt_Sub=mysql_query($SQL_QUERY);
							$tot=mysql_num_rows($arr_Rlt_Sub);
							?>
							<?
							if($tot){
							?>
							<tr>
								<td bgcolor=#f6f6f6 style="padding:9px 0 9px 28px; border-bottom:1px solid #cacaca;">
									<table>
										<?while($srow=mysql_fetch_array($arr_Rlt_Sub)){?>
										<tr><td style="font:11px/22px dotum;letter-spacing:-1px;padding-left:10px;background:url('/admincenter/img/blet_admin_menu.gif') no-repeat 0 8px;"><a href="javascript:fnc_menu('<?=$srow[Str_CHOCODE].$srow[Str_UNICODE]?>','')" name=navi><?If ($arr_Auth[7]==$srow[Str_CHOCODE].$srow[Str_UNICODE]) {?><b style="color:#248edf;"><?=$srow[Str_IDXWORD]?></b><?}else{?><?=$srow[Str_IDXWORD]?><?}?></a></td></tr> 
										<?}?>
									</table>
								</td>
							</tr>
							<?}?>
							<?}?>
							<tr>
								<td height=10></td>
							</tr>
						</table>
						</div>

					</td>
				</tr>
			</table>
			
			