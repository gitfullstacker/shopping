
						<table class=tb>
							<col class=cellL style="width:10%;text-align:center;">
							<col class=cellL style="width:90%;text-align:center;">
							<?for($i = 1; $i <= $last_day; $i++) {?>
							<tr>
								<td style="text-align:center;"><?=$i?>일</td>
								<td>
									<?
									$str_date = $year."-".Fnc_Om_Add_Zero($month,2)."-".Fnc_Om_Add_Zero($i,2);
									?>
									<?=fnc_cal2($str_date)?>
								</td>
							</tr>
							<?}?>
							<input type="hidden" name="txtRows" value="<?=$count?>">
						</table>
						<br>
						<div style="float:left;">
						<img src="/admincenter/img/btn_allselect_s.gif" alt="전체선택"  border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('1');">
						<img src="/admincenter/img/btn_alldeselect_s.gif" alt="선택해제"  border="0" align='absmiddle' style="cursor:hand" onclick="javascript:selectItem('2');">
						<img src="/admincenter/img/btn_alldelet_s.gif" alt="선택삭제" border="0" align='absmiddle' style="cursor:hand" onclick="javaScript:Adelete_Click();">
						</div>

						<div style="float:right;">
						<img src="/admincenter/img/btn_regist_s.gif" alt="등록" border=0 align=absmiddle style="cursor:hand" onClick="AddNew();">
						</div>
						