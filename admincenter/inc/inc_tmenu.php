			<?
			$SQL_QUERY =	" SELECT
						DISTINCT(A.STR_UNICODE),
						A.STR_MENUTYPE,
						A.INT_CHOSORT,
						A.STR_CHOCODE,
						A.INT_UNISORT,
						A.STR_MENUPATH,
						A.STR_IDXWORD,
						B.STR_BTMFLAG
					FROM ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_menu_idx A, ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_menu_con B, ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_menu_right C
					WHERE
						A.STR_MENUTYPE=B.STR_MENUTYPE
						AND
						A.STR_CHOCODE=B.STR_CHOCODE
						AND
						A.STR_UNICODE=B.STR_UNICODE
						AND
						A.STR_MENUTYPE=C.STR_MENUTYPE
						AND
						A.STR_CHOCODE=C.STR_CHOCODE
						AND
						A.STR_UNICODE=C.STR_UNICODE
						AND
						C.STR_IDXCODE='01'
						AND
						A.STR_UNICODE < '20000'
						AND
						C.STR_IDXNUM='$arr_Auth[3]'
						AND
						A.STR_SERVICE='Y'
					ORDER BY
						A.STR_MENUTYPE ASC,
						A.INT_CHOSORT ASC,
						A.STR_CHOCODE ASC,
						A.INT_UNISORT,
						A.STR_UNICODE ASC";

			$arr_Rlt_Menu=mysql_query($SQL_QUERY);
			?>
			<table  width="100%" border=0 cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td valign=bottom style="padding:10px 0 10px 40px;border-bottom:3px solid #248edf;background:url('/admincenter/img/bg_admin_gnb.gif') repeat-x;">
						<table border=0 cellpadding=0 cellspacing=0>
							<tr>
								<?
								while($row=mysql_fetch_array($arr_Rlt_Menu)){
								?>
								<td background="/admincenter/img/top_basic_title1<?if ($row[STR_CHOCODE]==substr($arr_Auth[7],0,2)) {?>_on<?}?>.png" width="95" height="27" valign="top" align="center"><a href="javascript:fnc_menu('<?=$row[STR_CHOCODE].$row[STR_UNICODE]?>','')" class="top_menu_font<?If ($row[STR_CHOCODE]==substr($arr_Auth[7],0,2)) {?>_on<?}?>"><?=$row[STR_IDXWORD]?></td>
								<?
								}
								?>
							</tr>
						</table>
					</td>
					<td width=13 align=right></td>
				</tr>
			</table>


