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
						A.*
					FROM "
						.$Tname."comm_member AS A
					WHERE
						A.STR_USERID='$str_no' ";

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
<script language="javascript" src="js/memb_user_edit.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_logo_info.php";?>
		<td width=100%>
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu_info.php";?>
		</td>
	</tr>
	<tr>
		<td colspan="3"><?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu.php";?></td>
	</tr>
	<tr>
		<td valign=top id=leftMenu>
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_lmenu_info.php";?>
		</td>
		<td colspan=2 valign=top height=100%> 
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_stitle_info.php";?>
			<table width=100%>
				<tr>
					<td style="padding:10px">
						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>

						<form id="frm" name="frm" target="_self" method="POST" action="memb_user_edit.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">

						<table class=tb>
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<tr>
								<td>회원구분</td>
								<td colspan="3">
									<input type="radio" value="1" name="int_gubun" class=null <?if (Fnc_Om_Conv_Default($arr_Data['INT_GUBUN'],"1")=="1") {?>checked<?}?>> 일반회원
								</td>
							</tr>
							<tr>
								<td>생년월일</td>
								<td>
									<?if ($arr_Data['STR_BIRTH']!=""){?>
										<?$str_birth=substr($arr_Data['STR_BIRTH'],0,4)."-".substr($arr_Data['STR_BIRTH'],4,2)."-".substr($arr_Data['STR_BIRTH'],6,2)?>
									<?}?>
									<input type=text name="str_birth" value="<?=$str_birth?>" id="str_birth" onclick="displayCalendar(document.frm.str_birth ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.str_birth ,'yyyy-mm-dd',document.frm.str_birth)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.str_birth.value=''";>
								</td>
								<td>성별</td>
								<td>
									<input type="radio" value="1" name="str_sex" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SEX'],"1")=="1") {?>checked<?}?>> 남자
									<input type="radio" value="2" name="str_sex" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SEX'],"1")=="2") {?>checked<?}?>> 여자
								</td>
							</tr>
						</table>
						<br>


						<table class=tb>
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<tr>
								<td>아이디</td>
								<td>
									<?If ($RetrieveFlag=="UPDATE") {?>
										<b><?=$arr_Data['STR_USERID']?></b><input type=hidden name=str_userid value="<?=$arr_Data['STR_USERID']?>">
										<input type="hidden" name="str_userid_chk" value="1">
									<?}else{?>
										<span id="idView_Proc">
										<input type=text name=str_userid value="<?=$arr_Data['STR_USERID']?>" maxlength="12" onKeyUp="fnc_idcheck()"> <font class=small color=6d6d6d>영문입력 / <a href="javascript:fnc_idchk('1');"><b>중복체크</b></font>
										<input type="hidden" name="str_userid_chk" value="0">
										</span>
									<?}?></td>
								<td>승인</td>
								<td class=noline><font class=def>
									<input type="radio" value="A" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="A") {?>checked<?}?>> 대기
									<input type="radio" value="Y" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="Y") {?>checked<?}?>> 승인
									<input type="radio" value="N" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="N") {?>checked<?}?>> 미승인
									<input type="radio" value="E" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="E") {?>checked<?}?>> 탈퇴
								</td>
							</tr>
							<tr>
								<td>이름</td>
								<td colspan="3"><input type=text name=str_name value="<?=$arr_Data['STR_NAME']?>"></td>
							</tr>
							<tr>
								<td>비밀번호</td>
								<td colspan=3><font class=def>
								<?If ($RetrieveFlag=="UPDATE") {?>
								<input type=hidden name=str_opasswd value="<?=$arr_Data['STR_PASSWD']?>">
								<div style="float:left;" class=noline><input type=checkbox name=str_modpass value="Y" onclick="openLayer('pass')"> 변경</div>
								<div style="float:left;margin-left:10;display:none;" id="pass">
									새비밀번호 : <input type=password name=str_passwd1 maxlength="12"> &nbsp;&nbsp;
									비밀번호확인 : <input type=password name=str_passwd2 maxlength="12">
								</div>
								<?}else{?>
									비밀번호 : <input type=password name=str_passwd1 maxlength="12"> &nbsp;&nbsp;
									비밀번호확인 : <input type=password name=str_passwd2 maxlength="12">
								<?}?>
								</td>
							</tr>
							<tr>
								<?$sTemp=Split("-",Fnc_Om_Conv_Default($arr_Data['STR_TELEP'],"--"))?>
								<td>전화번호</td>
								<td><font class=def>
								<input type=text name=str_telep1 value="<?=$sTemp[0]?>" size=4 maxlength=4> -
								<input type=text name=str_telep2 value="<?=$sTemp[1]?>" size=4 maxlength=4> -
								<input type=text name=str_telep3 value="<?=$sTemp[2]?>" size=4 maxlength=4>
								</td>
								<?$sTemp=Split("-",Fnc_Om_Conv_Default($arr_Data['STR_HP'],"--"))?>
								<td>핸드폰</td>
								<td colspan=3><font class=def>
								<input type=text name=str_hp1 value="<?=$sTemp[0]?>" size=4 maxlength=4> -
								<input type=text name=str_hp2 value="<?=$sTemp[1]?>" size=4 maxlength=4> -
								<input type=text name=str_hp3 value="<?=$sTemp[2]?>" size=4 maxlength=4>
								</td>
							</tr>
							<tr>
								<td>주소</td>
								<td colspan="3">
									<table border=0 cellpadding=0 cellspacing=0 class="mytable2">
										<tr>
											<td style="border:0px;padding:0px;height:25px;"><font class=def>
											<script src="//dmaps.daum.net/map_js_init/postcode.v2.js"></script>
											<script>
											    function execDaumPostcode() {
											        new daum.Postcode({
											            oncomplete: function(data) {
											                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
											
											                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
											                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
											                var fullAddr = ''; // 최종 주소 변수
											                var extraAddr = ''; // 조합형 주소 변수
											
											                // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
											                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
											                    fullAddr = data.roadAddress;
											
											                } else { // 사용자가 지번 주소를 선택했을 경우(J)
											                    fullAddr = data.jibunAddress;
											                }
											
											                // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
											                if(data.userSelectedType === 'R'){
											                    //법정동명이 있을 경우 추가한다.
											                    if(data.bname !== ''){
											                        extraAddr += data.bname;
											                    }
											                    // 건물명이 있을 경우 추가한다.
											                    if(data.buildingName !== ''){
											                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
											                    }
											                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
											                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
											                }
											
											                // 우편번호와 주소 정보를 해당 필드에 넣는다.
											                document.getElementById('str_post').value = data.zonecode; //5자리 새우편번호 사용
											                document.getElementById('str_addr1').value = fullAddr;
											
											                // 커서를 상세주소 필드로 이동한다.
											                document.getElementById('str_addr2').focus();
											            }
											        }).open();
											    }
											</script>
											<input type=text name=str_post id=str_post size=6 readonly value="<?=$arr_Data['STR_POST']?>">
											<a href="javascript:execDaumPostcode()"><img src="/admincenter/img/btn_zipcode.gif" align=absmiddle></a>
											</td>
										</tr>
										<tr>
											<td style="border:0px;padding:0px;height:25px;"><font class=def>
											<input type=text name=str_addr1 id=str_addr1 value="<?=$arr_Data['STR_ADDR1']?>" readonlY size=60>
											<input type=text name=str_addr2 id=str_addr2 value="<?=$arr_Data['STR_ADDR2']?>" size=50>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>이메일</td>
								<td colspan="3"><font class=def><input type=text name=str_email value="<?=$arr_Data['STR_EMAIL']?>" size=50></td>
							</tr>
							<tr>
								<td>추천아이디</td>
								<td colspan="3"><font class=def><input type=text name=str_tuserid value="<?=$arr_Data['STR_TUSERID']?>" size=20></td>
							</tr>
							<tr>
								<td>메일수신여부</td>
								<td>
									<input type="radio" value="Y" name="str_mail_f" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_MAIL_F'],"N")=="Y") {?>checked<?}?>> 수신함
									<input type="radio" value="N" name="str_mail_f" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_MAIL_F'],"N")=="N") {?>checked<?}?>> 수신안함
								</td>
								<td>SMS수신여부</td>
								<td>
									<input type="radio" value="Y" name="str_sms_f" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SMS_F'],"N")=="Y") {?>checked<?}?>> 수신함
									<input type="radio" value="N" name="str_sms_f" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SMS_F'],"N")=="N") {?>checked<?}?>> 수신안함
								</td>
							</tr>
							<?If ($RetrieveFlag=="UPDATE") {?>
							<tr>
								<td>회원가입일</td>
								<td><font class=ver8><?=$arr_Data['DTM_INDATE']?></td>
								<td>최종로그인</td>
								<td><font class=ver8><?=$arr_Data['DTM_ACDATE']?> &nbsp;&nbsp; 방문 <?=$arr_Data['INT_LOGIN']?> 회</td>
							</tr>
							<?}?>
						</table>
						<br>
						
						<div class="title">등록 된 배송지</div>
						<table class=tb>
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:38%;">
							<tr>
								<td>주소</td>
								<td colspan="3">
									<table border=0 cellpadding=0 cellspacing=0 class="mytable2">
										<tr>
											<td style="border:0px;padding:0px;height:25px;"><font class=def>
											<script src="//dmaps.daum.net/map_js_init/postcode.v2.js"></script>
											<script>
											    function execDaumPostcode2() {
											        new daum.Postcode({
											            oncomplete: function(data) {
											                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
											
											                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
											                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
											                var fullAddr = ''; // 최종 주소 변수
											                var extraAddr = ''; // 조합형 주소 변수
											
											                // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
											                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
											                    fullAddr = data.roadAddress;
											
											                } else { // 사용자가 지번 주소를 선택했을 경우(J)
											                    fullAddr = data.jibunAddress;
											                }
											
											                // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
											                if(data.userSelectedType === 'R'){
											                    //법정동명이 있을 경우 추가한다.
											                    if(data.bname !== ''){
											                        extraAddr += data.bname;
											                    }
											                    // 건물명이 있을 경우 추가한다.
											                    if(data.buildingName !== ''){
											                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
											                    }
											                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
											                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
											                }
											
											                // 우편번호와 주소 정보를 해당 필드에 넣는다.
											                document.getElementById('str_spost').value = data.zonecode; //5자리 새우편번호 사용
											                document.getElementById('str_saddr1').value = fullAddr;
											
											                // 커서를 상세주소 필드로 이동한다.
											                document.getElementById('str_saddr2').focus();
											            }
											        }).open();
											    }
											</script>
											<input type=text name=str_spost id=str_spost size=6 readonly value="<?=$arr_Data['STR_SPOST']?>">
											<a href="javascript:execDaumPostcode2()"><img src="/admincenter/img/btn_zipcode.gif" align=absmiddle></a>
											</td>
										</tr>
										<tr>
											<td style="border:0px;padding:0px;height:25px;"><font class=def>
											<input type=text name=str_saddr1 id=str_saddr1 value="<?=$arr_Data['STR_SADDR1']?>" readonlY size=60>
											<input type=text name=str_saddr2 id=str_saddr2 value="<?=$arr_Data['STR_SADDR2']?>" size=50>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>경비실</td>
								<td>
									<input type="radio" value="1" name="str_splace1" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SPLACE1'],"")=="1") {?>checked<?}?>> 있다
									<input type="radio" value="0" name="str_splace1" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SPLACE1'],"")=="0") {?>checked<?}?>> 없다
								</td>
								<td>무인택배함</td>
								<td>
									<input type="radio" value="1" name="str_splace2" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SPLACE2'],"")=="1") {?>checked<?}?>> 있다
									<input type="radio" value="0" name="str_splace2" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SPLACE2'],"")=="0") {?>checked<?}?>> 없다
								</td>
							</tr>
						</table>
						<br>

						<?If ($RetrieveFlag=="UPDATE") {?>
						<div class="title">탈퇴시</div>
						<table class=tb>
							<col class=cellC style="width:12%;"><col style="padding-left:10px;width:88%;">
							<tr>
								<td>탈퇴사유</td>
								<td colspan="3">
									<?
									$SQL_QUERY = "select a.* from ";
									$SQL_QUERY.=$Tname;
									$SQL_QUERY.="comm_com_code a ";
									$SQL_QUERY.="where a.int_gubun='1' and a.str_service='Y' ";
									$SQL_QUERY.="order by a.int_number asc ";

									$arr_Code_Menu = mysql_query($SQL_QUERY);
									?>
									<select name=str_escecode style="width:200px;">
										<option value="0">선택
										<?while($row=mysql_fetch_array($arr_Code_Menu)){?>
										<option value="<?=$row[INT_NUMBER]?>" <?if ($row[INT_NUMBER]==$arr_Data['STR_ESCECODE']) {?>selected<?}?>><?=$row[STR_CODE]?>
										<?}?>
									</select>
								
								</td>
							</tr>
							<tr>
								<td>고객님의충고</td>
								<td colspan="3"><textarea name=str_drcontents style="width:100%;height:100px;"><?=$arr_Data['STR_DRCONTENTS']?></textarea></td>
							</tr>
						</table>
						<br />
						<?}?>


						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						<a href='memb_user_list.php'><img src='/admincenter/img/btn_list.gif'></a>
						</div>

						</form>

						<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_btip_info.php";?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr><td height=3 bgcolor="#E6E6E6" colspan=2></td></tr>
	<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_copyright_info.php";?>
</table>
<script>table_design_load();</script>
</body>
</html>
