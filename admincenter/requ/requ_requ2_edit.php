<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						A.*,B.STR_CODE
					FROM "
						.$Tname."comm_requ AS A
						LEFT JOIN
						".$Tname."comm_com_code AS B
						ON 
						A.INT_PERIOD=B.INT_NUMBER
					WHERE
						A.INT_NUMBER='$str_no' ";

		$arr_Rlt_Data=mysql_query($SQL_QUERY);
		if (!$arr_Rlt_Data) {
    		echo 'Could not run query: ' . mysql_error();
    		exit;
		}
		$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	}
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/requ_requ2_edit.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td colspan=2 valign=top height=100%>
			<table width=100%>
				<tr>
					<td style="padding:10px">

						<form id="frm" name="frm" target="_self" method="POST" action="requ_requ2_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_gubun" value="<?=$arr_Data['STR_GUBUN']?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="Obj">

						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>
						<table class=tb>
							<col class=cellC style="width:15%"><col class=cellL style="width:35%">
							<col class=cellC style="width:15%"><col class=cellL style="width:35%">
							<tr>
								<td>이름</td>
								<td><font class=def><?=$arr_Data['STR_NAME']?></td>
								<td>연락처</td>
								<td><font class=def><?=$arr_Data['STR_TELEP']?></td>
							</tr>
							<tr>
								<td>희망금액</td>
								<td colspan="3"><font class=def><?=number_format($arr_Data['STR_PRICE'])?></td>
							</tr>
							<tr>
								<td>의뢰품목</td>
								<td colspan="3"><font class=def><?=$arr_Data['INT_GUBUN']?></td>
							</tr>
							<?if ($arr_Data['STR_GUBUN']=="2"||$arr_Data['STR_GUBUN']=="3") {?>
							<tr>
								<td>구입시기</td>
								<td colspan="3"><font class=def>
								<?$sTemp=Split("-",Fnc_Om_Conv_Default($arr_Data['STR_PERIOD'],"-"))?>
								<?=$sTemp[0]?>년 <?=$sTemp[1]?>월
								</td>
							</tr>
							<?}?>
							<?if ($arr_Data['STR_GUBUN']=="1") {?>
							<tr>
								<td><?if ($arr_Data['INT_GUBUN']=="자동차") {?>차량번호<?}else{?>담보주소<?}?></td>
								<td colspan="3"><font class=def><?=$arr_Data['STR_ADDRESS']?></td>
							</tr>
							<?}?>
							<tr>
								<td><?if ($arr_Data['STR_GUBUN']=="1") {?>기타정보<?}else{?>제품정보<?}?></td>
								<td colspan="3"><font class=def><?=$arr_Data['STR_ETC']?></td>
							</tr>
							<tr>
								<td>상태</td>
								<td colspan=3>
									<input type="radio" value="0" name="str_pass" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_PASS'],"0")=="0") {?>checked<?}?>> 접수
									<input type="radio" value="1" name="str_pass" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_PASS'],"0")=="1") {?>checked<?}?>> 상담완료
									<input type="radio" value="2" name="str_pass" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_PASS'],"0")=="2") {?>checked<?}?>> 대출/매입고객
									<input type="radio" value="3" name="str_pass" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_PASS'],"0")=="3") {?>checked<?}?>> 상환완료고객
								</td>
							</tr>
							<tr>
								<td>계약서번호</td>
								<td colspan="3"><input type="text" name="str_doc" value="<?=$arr_Data['STR_DOC']?>" style="width:200px;"></td>
							</tr>
							<tr>
								<td>지점선택</td>
								<td colspan=3>
									<select name="int_store" style="width:300px;">
										<option value="0">선택</option>
										<?
										$Sql_Query =	" SELECT
														A.*
													FROM `"
														.$Tname."comm_com_code` AS A
													WHERE
														A.INT_GUBUN='6'
														AND
														A.STR_SERVICE='Y'
													ORDER BY
														A.INT_NUMBER ASC ";
									
										$arr_Data2=mysql_query($Sql_Query);
										$arr_Data2_Cnt=mysql_num_rows($arr_Data2);
										?>
										<?
											for($int_I = 0 ;$int_I < $arr_Data2_Cnt; $int_I++) {
										?>
										<option value="<?=mysql_result($arr_Data2,$int_I,int_number)?>" <?if (trim(mysql_result($arr_Data2,$int_I,int_number))==trim($arr_Data['INT_STORE'])) {?> selected<?}?>><?=mysql_result($arr_Data2,$int_I,str_code)?></option>
										<?
											}
										?>
									</select>
								</td>
							</tr>
							<?if ($arr_Data['STR_GUBUN']=="3"){?>
							<tr>
								<td>상품매일일</td>
								<td colspan="3">
									<input type=text name="str_sdate" value="<?=$arr_Data['STR_SDATE']?>" id="str_sdate" onclick="displayCalendar(document.frm.str_sdate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:hand" onclick="displayCalendar(document.frm.str_sdate ,'yyyy-mm-dd',document.frm.str_sdate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:hand" onclick="document.frm.str_sdate.value=''";>
								</td>
							</tr>
							<tr>
								<td>상품매입금액</td>
								<td colspan="3"><input type="text" name="int_price" value="<?=$arr_Data['INT_PRICE']?>" style="ime-mode:inactive;width:200px;" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()"></td>
							</tr>
							<?}else{?>
							<tr>
								<td>대출기간</td>
								<td colspan="3">
									<input type=text name="str_sdate" value="<?=$arr_Data['STR_SDATE']?>" id="str_sdate" onclick="displayCalendar(document.frm.str_sdate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:hand" onclick="displayCalendar(document.frm.str_sdate ,'yyyy-mm-dd',document.frm.str_sdate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:hand" onclick="document.frm.str_sdate.value=''";>
									 -
									<input type=text name="str_edate" value="<?=$arr_Data['STR_EDATE']?>" id="str_edate" onclick="displayCalendar(document.frm.str_edate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:hand" onclick="displayCalendar(document.frm.str_edate ,'yyyy-mm-dd',document.frm.str_edate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:hand" onclick="document.frm.str_edate.value=''";>
								</td>
							</tr>
							<tr>
								<td>대출금액</td>
								<td colspan="3"><input type="text" name="int_price" value="<?=$arr_Data['INT_PRICE']?>" style="ime-mode:inactive;width:200px;" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()"></td>
							</tr>
							<tr>
								<td>대출이율</td>
								<td colspan="3"><input type="text" name="int_rate" value="<?=$arr_Data['INT_RATE']?>" style="ime-mode:inactive;width:100px;" maxlength="5">
								
									<input type="button" value="이자계산" onclick="Cal_Click()">
								</td>
							</tr>
							<?}?>
							<tr>
								<td>메모</td>
								<td colspan="3"><textarea name="str_memo" style="width:100%;height:150px;"><?=stripslashes($arr_Data['STR_MEMO'])?></textarea></td>
							</tr>
							<?if ($RetrieveFlag=="UPDATE") {?>
							<tr>
								<td>등록일자</td>
								<td colspan=3 class=noline><font class=def>
									<?=$arr_Data['DTM_INDATE']?>
								</td>
							</tr>
							<?}?>
						</table>
						<br>
						
						<?if ($arr_Data['STR_GUBUN']=="1") {?>
						<div class="title">첨부서류</div>
						<table class=tb>
							<col class=cellC style="width:15%"><col class=cellL style="width:85%">
							<tr>
								<td>첨부서류</td>
								<td colspan="3"><font class=def>
									<?
									$Sql_Query =	" SELECT
													A.*,B.INT_NUMBER AS NUM
												FROM `"
													.$Tname."comm_com_code` AS A
													LEFT JOIN
													`".$Tname."comm_requ_sub` AS B
													ON
													A.INT_NUMBER=B.INT_CODE
													AND 
													B.INT_NUMBER='".$arr_Data['INT_NUMBER']."'
												WHERE
													A.INT_GUBUN='1'
													AND
													A.STR_SERVICE='Y'
												ORDER BY
													A.INT_NUMBER ASC ";
								
									$arr_Data=mysql_query($Sql_Query);
									$arr_Data_Cnt=mysql_num_rows($arr_Data);
									?>
									<?
										for($int_I = 0 ;$int_I < $arr_Data_Cnt; $int_I++) {
									?>
									<?If (mysql_result($arr_Data,$int_I,num)!="") {?><font color="red"><?}?>
									<?=$int_I+1?>.<?=mysql_result($arr_Data,$int_I,str_code)?><br>
									<?If (mysql_result($arr_Data,$int_I,num)!="") {?></font><?}?>
									<?
										}
									?>
								</td>
							</tr>
						</table>
						<br>
						<?}?>



						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						</div>

						</form>

					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script>table_design_load();</script>
</body>
</html>

</body>
</html>