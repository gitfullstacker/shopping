<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
?>
<?
	$SQL_QUERY =	" SELECT
					UR.*
				FROM "
					.$Tname."comm_member AS UR
				WHERE
					UR.STR_USERID='$arr_Auth[0]' ";

	$arr_Rlt_Data=mysql_query($SQL_QUERY);

	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>
<script language="javascript" src="js/user_info.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   개인정보</p>
					<div class="lnb_tab mt10">
						<? require_once $_SERVER[DOCUMENT_ROOT]."/mypage/tab.php"; ?>
					</div>
			

					<!-- <div class="tit_h2_2 mt45">개인정보수정</div> -->
					
					<div class="notice_bx02 mt45">
						<p class="f_bk">주문시 꼭 필요한 사항이므로, 개인정보가 변경되었을 때 꼭 수정 부탁드립니다. </p>
						<p class="p_r"><span class="f_ylw">*</span> 별표는 필수 입력 정보이오니 정확하게 입력해 주세요.</p>
					</div>
					
		          	<form id="frm" name="frm" target="_self" method="POST">
		          	<input type="hidden" name="RetrieveFlag">
		          	<input type="hidden" name="int_gubun" value="<?=$arr_Data['INT_GUBUN']?>">
		          	<input type="hidden" name="str_cert" value="<?=$arr_Data['STR_CERT']?>">

					<div class="tit_h3 mt45">비밀번호</div>
					<div class="t_cover02 mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:185px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">기존비밀번호</th>
									<td class="left">
										<input type="password" name="str_opasswd" maxlength="12" class="inp01 w310" />
										<span class="pl10">기존비밀번호 입력</span>
									</td>
								</tr>
								<tr>
									<th class="left">새비밀번호</th>
									<td class="left">
										<input type="password" name="str_passwd1" maxlength="12" class="inp01 w310" />
										<span class="pl10">새 비밀번호입력/ 비밀번호는 6~12자 영문, 숫자 조합하여 입력 가능 합니다.</span>
									</td>
								</tr>
								<tr>
									<th class="left">새비밀번호 확인</th>
									<td class="left">
										<input type="password" name="str_passwd2" maxlength="12" class="inp01 w310" />
										<span class="pl10">새 비밀번호 확인</span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="center mt30">
						<a href="javascript:Save_Pw();" class="btn btn_l btn_bk w w270 f_bd">비밀번호 변경</a>
					</div>
					
					<div class="tit_h3 mt60">배송지</div>
					<div class="center mt30">
						<a href="/mypage/membership.php" class="btn btn_l btn_bk w w270 f_bd">배송지 변경</a>
					</div>	
					
					
					
					<div class="tit_h3 mt60">개인정보 수정</div>
					<div class="t_cover02 mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:185px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left"><span class="f_ylw">*</span> 이름</th>
									<td class="left"><?=$arr_Data['STR_NAME']?></td>
								</tr>
								<tr>
									<th class="left"><span class="f_ylw">*</span> 아이디</th>
									<td class="left"><?=$arr_Data['STR_USERID']?></td>
								</tr>
								<tr>
									<th class="left"><span class="f_ylw">*</span> H.P</th>
									<td class="left">
									
										<!--
										<?$sTemp=Split("-",Fnc_Om_Conv_Default($arr_Data['STR_HP'],"--"))?>
										<span class="w95" >
										<select name="str_hp1" class="SlectBox">
											<option value="">선택</option>
											<option value="010"<?if ($sTemp[0]=="010"){?> selected<?}?>>010</option>
											<option value="011"<?if ($sTemp[0]=="011"){?> selected<?}?>>011</option>
											<option value="016"<?if ($sTemp[0]=="016"){?> selected<?}?>>016</option>
											<option value="017"<?if ($sTemp[0]=="017"){?> selected<?}?>>017</option>
											<option value="018"<?if ($sTemp[0]=="018"){?> selected<?}?>>018</option>
											<option value="019"<?if ($sTemp[0]=="019"){?> selected<?}?>>019</option>
										</select> 
										</span> -
										<input type="text" name="str_hp2" value="<?=$sTemp[1]?>" maxlength="4" class="inp01 w75" /> -
										<input type="text" name="str_hp3" value="<?=$sTemp[2]?>" maxlength="4" class="inp01 w75" />
										//-->
										<?=$arr_Data['STR_HP']?>
										<?if ($arr_Data['STR_CERT']=="M") {?>
										<a href="javascript:fnc_Auth();" class="btn btn_m btn_bk w110">휴대폰재인증</a>
										<?}else{?>
										<a href="javascript:fnc_Auth();" class="btn btn_m btn_bk w110">휴대폰인증</a>
										<?}?>
									</td>
								</tr>
								<tr style="display:none;">
									<th class="left"><span class="f_ylw">*</span> 주소</th>
									<td class="left">
										<div id="layer" style="display:none;border:5px solid;position:fixed;width:300px;height:400px;left:50%;margin-left:-155px;top:50%;margin-top:-145px;overflow:hidden;-webkit-overflow-scrolling:touch;z-index:2000000000000000000000">
										<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
										</div>
									
				
										<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
										<script>
										    // 우편번호 찾기 화면을 넣을 element
										    var element_layer = document.getElementById('layer');
										
										    function closeDaumPostcode() {
										        // iframe을 넣은 element를 안보이게 한다.
										        element_layer.style.display = 'none';
										    }
										
										    function execDaumPostcode() {
										        new daum.Postcode({
										            oncomplete: function(data) {
										                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
										
										                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
										                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
										                var fullAddr = data.address; // 최종 주소 변수
										                var extraAddr = ''; // 조합형 주소 변수
										
										                // 기본 주소가 도로명 타입일때 조합한다.
										                if(data.addressType === 'R'){
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
										
										                // 우편번호와 주소 및 영문주소 정보를 해당 필드에 넣는다.
										                //document.getElementById('str_post').value = data.postcode1+data.postcode2;
										                document.getElementById('str_post').value = data.zonecode; 
										                //document.getElementById('str_post2').value = data.postcode2;
										                document.getElementById('str_addr1').value = fullAddr;
										                //document.getElementById('sample2_addressEnglish').value = data.addressEnglish;
										                document.getElementById('str_addr2').focus();
										
										                // iframe을 넣은 element를 안보이게 한다.
										                element_layer.style.display = 'none';
										            },
										            width : '100%',
										            height : '100%'
										        }).embed(element_layer);
										
										        // iframe을 넣은 element를 보이게 한다.
										        element_layer.style.display = 'block';
										    }
										</script>
									
										<p>
											<input type="text" name="str_post" id="str_post" readonly value="<?=$arr_Data['STR_POST']?>" class="inp01 w75" /> 
											<a href="javascript:execDaumPostcode();" class="btn btn_m btn_bk w110">우편번호</a>
										</p>
										<p class="mt15">
											<input type="text" name="str_addr1" id="str_addr1" value="<?=$arr_Data['STR_ADDR1']?>" readonly class="inp01 w425" />  
											<input type="text" name="str_addr2" id="str_addr2" value="<?=$arr_Data['STR_ADDR2']?>" class="inp01 w425" />
										</p>
									</td>
								</tr>
								<tr>
									<th class="left"><span class="f_ylw">*</span> 이메일</th>
									<td class="left">
										<?$sTemp=Split("@",Fnc_Om_Conv_Default($arr_Data['STR_EMAIL'],"@"))?>
										<input type="text" name="str_email1" value="<?=$sTemp[0]?>" class="inp01 w265" /> @
										<input type="text" name="str_email2" value="<?=$sTemp[1]?>" class="inp01 w265" /> 
										<span class="w180">
											<select title="이메일 도메인 선택" onChange="fnc_semail1(this.value)" class="SlectBox">
												<option value="">직접입력</option>
												<option value="chollian.net">chollian.net</option>
												<option value="dreamwiz.com">dreamwiz.com</option>
												<option value="empal.com">empal.com</option>
												<option value="freechal.com">freechal.com</option>
												<option value="hananet.net">hananet.net</option>
												<option value="hanafos.com">hanafos.com</option>
												<option value="hanmail.net">hanmail.net</option>
												<option value="hitel.net">hitel.net</option>
												<option value="hanmir.com">hanmir.com</option>
												<option value="intizen.com">intizen.com</option>
												<option value="kebi.com">kebi.com</option>
												<option value="korea.com">korea.com</option>
												<option value="kornet.net">kornet.net</option>
												<option value="lycos.co.kr">lycos.co.kr</option>
												<option value="msn.com">msn.com</option>
												<option value="nate.com">nate.com</option>
												<option value="naver.com">naver.com</option>
												<option value="netsgo.com">netsgo.com</option>
												<option value="netian.com">netian.com</option>
												<option value="orgio.net">orgio.net</option>
												<option value="paran.com">paran.com</option>
												<option value="sayclub.com">sayclub.com</option>
												<option value="shinbiro.com">shinbiro.com</option>
												<option value="unitel.co.kr">unitel.co.kr</option>
												<option value="yahoo.co.kr">yahoo.co.kr</option>
												<option value="yahoo.com">yahoo.com</option>
											</select>
										</span>
										<br>
										<span class="pl20"><label><input type="checkbox" name="str_mail_f" value="Y" <?if ($arr_Data['STR_MAIL_F']=="Y"){?> checked<?}?> /> 뉴스레터 및 안내 메일 수신 개인정보</label></span>

									</td>
								</tr>
								<tr style="display:none;">
									<th class="left">추천인ID</th>
									<td class="left">
										<input type="password" class="inp01 w425" />
										<span class="pl20">추천인ID 입력 고객과 해당하는 고객께는 각각 <em class="f_org">5000스탬프 적립!</em></span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="center mt30">
						<a href="javascript:Save_Click();" class="btn btn_l btn_ylw w w225 f_bd">수정하기</a>
						<a href="/main/index.php" class="btn btn_l btn_wt w w225 f_bd">취소</a>
						
						<a href="/mypage/withdraw.php" class="btn btn_l btn_bk w w225 f_bd">회원탈퇴</a>
					</div>
					
					</form>
					
					<form name="form_chk" method="post">
						<input type="hidden" name="m" value="checkplusSerivce">						<!-- 필수 데이타로, 누락하시면 안됩니다. -->
						<input type="hidden" name="EncodeData" value="<?= $enc_data ?>">		<!-- 위에서 업체정보를 암호화 한 데이타입니다. -->
					    
					    <!-- 업체에서 응답받기 원하는 데이타를 설정하기 위해 사용할 수 있으며, 인증결과 응답시 해당 값을 그대로 송신합니다.
					    	 해당 파라미터는 추가하실 수 없습니다. -->
						<input type="hidden" name="param_r1" value="">
						<input type="hidden" name="param_r2" value="">
						<input type="hidden" name="param_r3" value="">
					</form>
					
					<table border="0" style="display:none;">
						<tr>
							<td id="obj_Lbl" colspan="2" height="0"></td>
						</tr>
					</table>
				
					
					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"; ?>
