						<div style="padding-top:35;"></div>
						<div id=MSG01>
						<table width="100%" cellpadding=1 cellspacing=0 border=0>
							<tr>
								<td width="50%" style="padding-left:10px;"><img src='/admincenter/img/icn_chkpoint.gif'></td>
								<td width="50%" align="right" style="padding-right:10px;"><?If ($arr_Auth[1]=="91") {?><a href="javascript:popupLayer('/admincenter/comm/comm_tip_list.php?str_filename=<?=URLEncode($loc_I_Pg_File)?>',700,550);"><img src='/admincenter/img/btn_viewbbs.gif' align="absmiddle"></a><?}?></td>
							</tr>
						</table>
						<span id="idView_Tip"></span>
			 			
						<script language="javascript">
							fuc_set('/admincenter/comm/comm_tip_edit_proc.php?RetrieveFlag=Load?RetrieveFlag=Load&str_filename=<?=URLEncode($loc_I_Pg_File)?>','_Tip');
						</script>

						</div>
						<script>cssRound('MSG01','#F7F7F7')</script>
						<br>
