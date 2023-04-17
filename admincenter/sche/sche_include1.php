
						<table class=tb>
							<col class=cellC style="width:14.2857142857143%">
							<col class=cellC style="width:14.2857142857143%">
							<col class=cellC style="width:14.2857142857143%">
							<col class=cellC style="width:14.2857142857143%">
							<col class=cellC style="width:14.2857142857143%">
							<col class=cellC style="width:14.2857142857143%">
							<col class=cellC style="width:14.2857142857143%">
							<tr>
								<td style="height:30px;text-align:center;"><font size="2"><b>일</b></font></td>
								<td style="height:30px;text-align:center;"><font size="2"><b>월</b></font></td>
								<td style="height:30px;text-align:center;"><font size="2"><b>화</b></font></td>
								<td style="height:30px;text-align:center;"><font size="2"><b>수</b></font></td>
								<td style="height:30px;text-align:center;"><font size="2"><b>목</b></font></td>
								<td style="height:30px;text-align:center;"><font size="2"><b>금</b></font></td>
								<td style="height:30px;text-align:center;"><font size="2"><b>토</b></font></td>
							</tr>
						</table>
						<br>
						<table class=tb>
							<col class=cellL style="width:14.2857142857143%;padding:5px;">
							<col class=cellL style="width:14.2857142857143%;padding:5px;">
							<col class=cellL style="width:14.2857142857143%;padding:5px;">
							<col class=cellL style="width:14.2857142857143%;padding:5px;">
							<col class=cellL style="width:14.2857142857143%;padding:5px;">
							<col class=cellL style="width:14.2857142857143%;padding:5px;">
							<col class=cellL style="width:14.2857142857143%;padding:5px;">
						    
						 	<?
						  	$start_weekdays = date("w", mktime(0, 0, 0, $month, 1, $year));
							for($i = 1; $i <= $start_weekdays; $i++) {echo "<td>&nbsp;</td>\n";}
						
							for($i = 1; $i <= $last_day; $i++) {
						
						 		$start_weekdays++; // 현재 요일값을 다음 요일값으로 증가.
						 		$now_week = $start_weekdays % 7; // 현재 요일을 값을 구한다.
								$to_style="";
								$day_style = "";
								if($i == $day) {$to_style = " class='written'";} // 현재일 (검색일)
								else {
								if($now_week == "1") {$day_style = "red";} // 일요일 표시
								else if(!$now_week) {$day_style = "blue";} // 토요일 표시 
								else if(in_array($month . "-" . $i, $vacation_day)) {$day_style = "red";} // 지정 휴일 표시 
								else {$day_style = "black";} // 평일 표시
							}
							echo "<td style=bgcolor:'FFFFFF' height='120' valign='top'><font color=".$day_style."><span><font size=2><b>".$i."</b></font></span></font>";
							?>
							<?
							$str_date = $year."-".Fnc_Om_Add_Zero($month,2)."-".Fnc_Om_Add_Zero($i,2);
							?>
								<br><br>
								<?=fnc_cal2($str_date)?>
							<?
							echo "</td>";
						
							if($now_week == 0 && $i != $last_day) {echo "</tr><tr>";}
						 	}
							if($now_week) {
						 		for($i = $now_week; $i < 7; $i++) {echo "<td>&nbsp;</td>";}
						 	}
						 	?>
							</tr>
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
						