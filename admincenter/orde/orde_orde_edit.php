<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
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
						A.*,B.STR_NAME,B.STR_HP,C.STR_GOODNAME,B.STR_EMAIL,D.STR_USERCODE
					FROM "
						.$Tname."comm_goods_cart AS A
						LEFT JOIN
						".$Tname."comm_member AS B
						ON
						A.STR_USERID=B.STR_USERID
						LEFT JOIN
						".$Tname."comm_goods_master AS C
						ON
						A.STR_GOODCODE=C.STR_GOODCODE
						LEFT JOIN 
						".$Tname."comm_goods_master_sub D
						on 
						A.STR_SGOODCODE=D.STR_SGOODCODE 
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
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/orde_orde_edit.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td colspan=2 valign=top height=100%>
			<table width=100%>
				<tr>
					<td style="padding:10px">

						<form id="frm" name="frm" target="_self" method="POST" action="orde_orde_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="str_email" value="<?=$arr_Data['STR_EMAIL']?>">
						<input type="hidden" name="Obj">

						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>
						<table class=tb>
							<col class=cellC style="width:15%"><col class=cellL style="width:35%">
							<col class=cellC style="width:15%"><col class=cellL style="width:35%">
							<tr>
								<td>아이디</td>
								<td><font class=def><?=$arr_Data['STR_USERID']?></td>
								<td>이름</td>
								<td><font class=def><?=$arr_Data['STR_NAME']?></td>
							</tr>
							<tr>
								<td>핸드폰</td>
								<td colspan="3"><font class=def><?=$arr_Data['STR_HP']?></td>
							</tr>
							<tr>
								<td>주소</td>
								<td colspan="3"><font class=def><?=$arr_Data['STR_POST']?>] <?=$arr_Data['STR_ADDR1']." ".$arr_Data['STR_ADDR2']?></td>
							</tr>
							<tr>
								<td>맡길 곳</td>
								<td colspan="3"><font class=def>
									경비실 : <?if ($arr_Data['STR_PLACE1']=="1") {?> 있다<?}?><?if ($arr_Data['STR_PLACE1']=="0") {?> 없다<?}?>
									/
									무인택배함 : <?if ($arr_Data['STR_PLACE2']=="1") {?> 있다<?}?><?if ($arr_Data['STR_PLACE2']=="0") {?> 없다<?}?>
								</td>
							</tr>
							<tr>
								<td>메모</td>
								<td colspan="3" style="height:50px;" valign="top"><font class=def><?=str_replace(chr(13),"<br>",Fnc_Om_Conv_Default($arr_Data['STR_MEMO'],""))?></td>
							</tr>
							<tr>
								<td>상품코드</td>
								<td colspan="3"><font class=def><?=$arr_Data['STR_USERCODE']?></td>
							</tr>
							<tr>
								<td>상품</td>
								<td colspan="3"><font class=def><?=$arr_Data['STR_GOODNAME']?></td>
							</tr>
							<tr>
								<td>기간</td>
								<td colspan="3">
									<input type=text name=str_sdate value="<?=$arr_Data['STR_SDATE']?>" id="str_sdate" onclick="displayCalendar(document.frm.str_sdate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.str_sdate ,'yyyy-mm-dd',document.frm.str_sdate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.str_sdate.value=''";>
									~
									<input type=text name=str_edate value="<?=$arr_Data['STR_EDATE']?>" id="str_edate" onclick="displayCalendar(document.frm.str_edate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.str_edate ,'yyyy-mm-dd',document.frm.str_edate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.str_edate.value=''";>
								</td>
							</tr>
							<tr>
								<td>상태</td>
								<td colspan=3>
									<input type="radio" value="1" name="int_state" class=null <?if (Fnc_Om_Conv_Default($arr_Data['INT_STATE'],"1")=="1") {?>checked<?}?>> 접수
									<input type="radio" value="2" name="int_state" class=null <?if (Fnc_Om_Conv_Default($arr_Data['INT_STATE'],"1")=="2") {?>checked<?}?>> 관리자확인
									<input type="radio" value="3" name="int_state" class=null <?if (Fnc_Om_Conv_Default($arr_Data['INT_STATE'],"1")=="3") {?>checked<?}?>> 발송
									<?
									$SQL_QUERY = "select a.* from ".$Tname."comm_com_code a where a.int_number is not null and a.int_gubun='5' and a.str_service='Y' order by a.int_number asc";
			
									$arr_Data2=mysql_query($SQL_QUERY);
									$arr_Data2_Cnt=mysql_num_rows($arr_Data2);
									?>
									<select name="int_delicode">
										<option value="0">발송업체선택
										<?if ($arr_Data['INT_DELICODE']!=""&&$arr_Data['INT_DELICODE']!="0") {?>
										<?
											for($int_J = 0 ;$int_J < $arr_Data2_Cnt; $int_J++) {
										?>
										<option value="<?=mysql_result($arr_Data2,$int_J,int_number)?>" <?if (mysql_result($arr_Data2,$int_J,int_number)==$arr_Data['INT_DELICODE']){?> selected<?}?>><?=mysql_result($arr_Data2,$int_J,str_code)?>
										<?
											}
										?>
										<?}else{?>
										<?
											for($int_J = 0 ;$int_J < $arr_Data2_Cnt; $int_J++) {
										?>
										<option value="<?=mysql_result($arr_Data2,$int_J,int_number)?>" <?if (mysql_result($arr_Data2,$int_J,str_default)=="1"){?> selected<?}?>><?=mysql_result($arr_Data2,$int_J,str_code)?>
										<?
											}
										?>										
										<?}?>
									</select>
									<input type=text name="str_delicode" value="<?=$arr_Data['STR_DELICODE']?>">
									
									<input type="radio" value="4" name="int_state" class=null <?if (Fnc_Om_Conv_Default($arr_Data['INT_STATE'],"1")=="4") {?>checked<?}?>> 배송완료<br>
									<input type="radio" value="5" name="int_state" class=null <?if (Fnc_Om_Conv_Default($arr_Data['INT_STATE'],"1")=="5") {?>checked<?}?>> 반납접수
									<input type="radio" value="6" name="int_state" class=null <?if (Fnc_Om_Conv_Default($arr_Data['INT_STATE'],"1")=="6") {?>checked<?}?>> 이용중
									<input type="radio" value="10" name="int_state" class=null <?if (Fnc_Om_Conv_Default($arr_Data['INT_STATE'],"1")=="10") {?>checked<?}?>> 반납완료
									<input type=text name=str_rdate value="<?=$arr_Data['STR_RDATE']?>" id="str_rdate" onclick="displayCalendar(document.frm.str_rdate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.str_rdate ,'yyyy-mm-dd',document.frm.str_rdate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.str_rdate.value=''";>
									<input type="radio" value="11" name="int_state" class=null <?if (Fnc_Om_Conv_Default($arr_Data['INT_STATE'],"1")=="11") {?>checked<?}?>> 취소
								</td>
							</tr>
							<tr>
								<td>관리자메모</td>
								<td colspan="3" style="height:50px;" valign="top"><textarea name="str_amemo" style="width:100%;height:80px;"><?=stripslashes(Fnc_Om_Conv_Default($arr_Data['STR_AMEMO'],""))?></textarea></td>
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

						<div class="title title_top">반납정보</div>
						<table class=tb>
							<col class=cellC style="width:15%"><col class=cellL style="width:85%">
							<tr>
								<td>주소</td>
								<td colspan="3"><font class=def><?=$arr_Data['STR_RPOST']?>] <?=$arr_Data['STR_RADDR1']." ".$arr_Data['STR_RADDR2']?></td>
							</tr>
							<tr>
								<td>반납 방법</td>
								<td colspan="3"><font class=def>
									<?switch ($arr_Data['STR_METHOD']) {
										case  "1" : echo "수령지에서"; break;
										case  "2" : echo "경비실에 맡긴다"; break;
										case  "3" : echo "무인택배함"; break;
									}
									?>	
								</td>
							</tr>
							<tr>
								<td>메모</td>
								<td colspan="3" style="height:50px;" valign="top"><font class=def><?=str_replace(chr(13),"<br>",Fnc_Om_Conv_Default($arr_Data['STR_RMEMO'],""))?></td>
							</tr>
						</table>
						<br>

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