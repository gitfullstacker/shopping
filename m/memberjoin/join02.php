<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	$str_cert = Fnc_Om_Conv_Default($_REQUEST[str_cert],$_SESSION['USERJ_CERT']);
	$str_name = Fnc_Om_Conv_Default($_REQUEST[str_name],$_SESSION['USERJ_NAME']);
	$str_hp = Fnc_Om_Conv_Default($_REQUEST[str_hp],$_SESSION['USERJ_HP']);
	$str_birth = Fnc_Om_Conv_Default($_REQUEST[str_birth],$_SESSION['USERJ_BIRTH']);
	$str_sex = Fnc_Om_Conv_Default($_REQUEST[str_sex],$_SESSION['USERJ_SEX']);
	
	// If ($str_name=="") {
	// 	?>
	// 	<script language="javascript">
	// 		alert("비정상적 접속입니다.");
	// 		window.location.href="/m/main/index.php";
	// 	</script>
	// 	<?
	// 	exit;
	// }
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/join02.js"></script>
		
		<div class="con_width">
			
			<p class="f_bk mt15">에이블랑에 회원 가입하시면 다양한 서비스와 풍성한 혜택을 누리실 수 있습니다.</p>
			<p class="right mt15">* 별표는 필수 입력 정보이오니 정확하게 입력해 주세요.</p>
			
			
	      	<form name="frm" method="post" enctype="multipart/form-data">
	      	<input type="hidden" name="RetrieveFlag">
	      	<input type="hidden" name="str_cert" value="<?=$str_cert?>">
	      	<input type="hidden" name="str_birth" value="<?=$str_birth?>">
	      	<input type="hidden" name="str_sex" value="<?=$str_sex?>">
			
			<div class="t_cover01 mt05">
				<table class="t_type">
					<colgroup>
						<col style="width:30%;" />
						<col style="width:70%;" />
					</colgroup>
					<tbody>
						<tr>
							<th>*이름</th>
							<td>
								<?if ($str_name=="") {?>
									<input type="text" name="str_name" class="inp w100P" />
								<?}else{?>
									<input type="hidden" name="str_name" value="<?=$str_name?>" />
									<?=$str_name?>
								<?}?>
							</td>
						</tr>
						<tr>
							<th>*아이디</th>
							<td>
								<p><input type="text" name="str_userid" id="str_userid" maxlength="12" onKeyUp="fnc_idcheck();str_userid_check2();" class="inp w100P" /></p>
								<span class="f_size_s mt05" id="idView_Proc">
									<input type="hidden" name="str_userid_chk" id="str_userid_chk" value="0" />
								</span>

							</td>
						</tr>
						<tr>
							<th>*비밀번호</th>
							<td>
								<p><input type="password" name="str_passwd1" maxlength="12" onKeyUp="input_cal_byte(this, 12);" class="inp w100P"/></p>
								<p class="f_size_s mt05">비밀번호는 6~12자 영문, 숫자 조합하여 입력 가능 합니다.</p>
							</td>
						</tr>
						<tr>
							<th>*비밀번호 확인</th>
							<td>
								<p><input type="password" name="str_passwd2" maxlength="12" onKeyUp="input_cal_byte(this, 12);" class="inp w100P"/></p>
							</td>
						</tr>
						<tr>
							<th>*H.P</th>
							<td>
								<p class="phone_bx">
									<?if ($str_hp!=""){?>
										<?=$str_hp?>
										<?$sTemp=Split("-",Fnc_Om_Conv_Default($str_hp,"--"))?>
										<input type="hidden" name="str_hp1" value="<?=$sTemp[0]?>" /> 
										<input type="hidden" name="str_hp2" value="<?=$sTemp[1]?>" /> 
										<input type="hidden" name="str_hp3" value="<?=$sTemp[2]?>" />
									<?}else{?>
									<span class="phone01">
										<select name="str_hp1" class="selc w100p">
											<option value="">선택</option>
											<option value="010">010</option>
											<option value="011">011</option>
											<option value="016">016</option>
											<option value="017">017</option>
											<option value="018">018</option>
											<option value="019">019</option>
										</select> 
									</span>
									<span class="phone04">-</span>
									<span class="phone02"><input type="text" name="str_hp2" maxlength="4"  class="inp w100p"/></span>
									<span class="phone04">-</span>
									<span class="phone03"><input type="text" name="str_hp3" maxlength="4"  class="inp w100p"/></span>
									<?}?>
								</p>
							</td>
						</tr>
						<tr>
							<th>*이메일</th>
							<td>
								<p class="email_bx">
									<span class="email01"><input type="text" name="str_email1" class="inp w100p"/></span>
									<span class="email02">@</span>
									<span class="email01"><input type="text" name="str_email2" class="inp w100p"/></span>
									<span class="email03" style="width:100%;padding-top:5px;">
										<select title="이메일 도메인 선택" onChange="fnc_semail1(this.value)" class="selc w100p">
											<option value="">직접입력</option>
											<option value="naver.com">naver.com</option>
											<option value="hanmail.net">hanmail.net</option>
											<option value="nate.com">nate.com</option>
											<option value="hotmail.com">hotmail.com</option>
											<option value="gmail.com">gmail.com</option>
											<option value="chollian.net">chollian.net</option>
											<option value="dreamwiz.com">dreamwiz.com</option>
											<option value="empal.com">empal.com</option>
											<option value="freechal.com">freechal.com</option>
											<option value="hananet.net">hananet.net</option>
											<option value="hanafos.com">hanafos.com</option>
											<option value="hitel.net">hitel.net</option>
											<option value="hanmir.com">hanmir.com</option>
											<option value="intizen.com">intizen.com</option>
											<option value="kebi.com">kebi.com</option>
											<option value="korea.com">korea.com</option>
											<option value="kornet.net">kornet.net</option>
											<option value="lycos.co.kr">lycos.co.kr</option>
											<option value="msn.com">msn.com</option>
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
								</p>
								<p class="f_size_s mt05"><label><input type="checkbox" name="str_mail_f" value="Y" class="cform" /> 뉴스레터 및 안내 메일 수신 동의</label></p>
							</td>
						</tr>
						<tr>
							<th>주소</th>
							<td>
								<div id="layer" style="display:none;border:5px solid;position:fixed;width:300px;height:400px;left:50%;margin-left:-155px;top:50%;margin-top:-145px;overflow:hidden;-webkit-overflow-scrolling:touch;z-index:2000000000000000000000">
								<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1;width:20px;height:20px;" onclick="closeDaumPostcode()" alt="닫기 버튼">
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
								
								<p><input type="text" class="inp w50p" name="str_post" id="str_post" readonly /> <a href="javascript:execDaumPostcode();" class="btn btn_sm btn_bk w w30p">우편번호</a></p>
								<p class="mt05"><input type="text" name="str_addr1" id="str_addr1" readonly class="inp w100p" /></p>
								<p class="mt05"><input type="text" name="str_addr2" id="str_addr2" class="inp w100p" /></p>
							</td>
						</tr>
						<tr>
							<th>추천인ID</th>
							<td>
								<p><input type="text" name="str_tuserid" class="inp w100p"/></p>
								<p class="f_size_s mt05">추천인ID 입력 고객과 해당하는 고객께는 <br />각각 <span class="f_bk f_bd">스탬프 1개씩 적립!</span></p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="btn_w mt10">
				<span class="f_left"><a href="#;" class="btn btn_m btn_gray02 w100p">개인정보 취급방침 내용 보기</a></span>
				<span class="f_right"><a href="#;" class="btn btn_m btn_gray02 w100p">이용약관 내용 보기 </a></span>
			</div>
			<div class="center f_bk mt15"><label>개인정보취급방침과 이용약관에 동의합니다. <input type="checkbox" name="" class="cform"/></label></div>
			<div class="btn_w mt25">
				<span class="f_left"><a href="/m/main/index.php" class="btn btn_l btn_bk w100p f_bd">취소하기</a></span>
				<span class="f_right"><a href="javascript:Save_Click();" class="btn btn_l btn_ylw w100p f_bd">회원가입하기</a></span>
			</div>
			
			</form>

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/footer.php"; ?>

