<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();
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
<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/header.php"; ?>
<script language="javascript" src="js/user_info.js"></script>

		
		<div class="con_width">
			
			
			<div class="request_tab pt15">
				<ul id="tab02">
					<li class="on"><a href="#;">개인정보 수정</a></li>
					<li><a href="/m/mypage/withdraw.php">회원탈퇴</a></li>
				</ul>
			</div>

			<div class="tit_h2 mt10">
				<em>개인정보수정</em>
			</div>

          	<form id="frm" name="frm" target="_self" method="POST">
          	<input type="hidden" name="RetrieveFlag">
          	<input type="hidden" name="int_gubun" value="<?=$arr_Data['INT_GUBUN']?>">
          	<input type="hidden" name="str_cert" value="<?=$arr_Data['STR_CERT']?>">

			<p class="notice_bx02 mt01">궁금하신 점은 언제든지 1:1문의를 통해 요청해주시면 답변드리겠습니다.</p>
			<div class="tit_h3 mt15">비밀번호</div>
			<div class="t_cover01 mt05">
				<table class="t_type">
					<colgroup>
						<col style="width:30%;" />
						<col style="width:70%;" />
					</colgroup>
					<tbody>
						<tr>
							<th>기존 비밀번호</th>
							<td><input type="password" name="str_opasswd" maxlength="12" class="inp w100P"/></td>
						</tr>
						<tr>
							<th>새 비밀번호</th>
							<td>
								<p><input type="password" name="str_passwd1" maxlength="12" class="inp w100P"/></p>
								<p class="mt05">새 비밀번호입력/ 비밀번호는 6~12자 영문, 숫자 조합하여 입력 가능</p>
							</td>
						</tr>
						<tr>
							<th>새 비밀번호 확인</th>
							<td>
								<p><input type="password" name="str_passwd2" maxlength="12" class="inp w100P"/></p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="mt15">
				<a href="javascript:Save_Pw();" class="btn btn_bk btn_ml w100p f_bd">비밀번호 수정</a>
			</div>
 			<div class="tit_h3 mt50">배송지</div>
 				<a href="/m/mypage/membership.php" class="btn btn_bk btn_ml w100p f_bd mt10">배송지 수정</a>
 			
			<div class="tit_h3 mt50">개인정보</div>
			<div class="t_cover01 mt05">
				<table class="t_type">
					<colgroup>
						<col style="width:30%;" />
						<col style="width:70%;" />
					</colgroup>
					<tbody>
						<tr>
							<th>*이름</th>
							<td><?=$arr_Data['STR_NAME']?></td>
						</tr>
						<tr>
							<th>*아이디</th>
							<td><?=$arr_Data['STR_USERID']?></td>
						</tr>
						<tr>
							<th>*H.P</th>
							<td>
								<p class="phone_bx">
									<!--
									<span class="phone01">
										<select name="" id="" class="selc w100p">
											<option value="">선택</option>
										</select>
									</span>
									<span class="phone04">-</span>
									<span class="phone02"><input type="text"  class="inp w100p"/></span>
									<span class="phone04">-</span>
									<span class="phone03"><input type="text"  class="inp w100p"/></span>
									//-->
									<?=$arr_Data['STR_HP']?>
								</p>
								<p class="mt05">
									<?if ($arr_Data['STR_CERT']=="M") {?>
									<a href="javascript:fnc_Auth();" class="btn btn_sm btn_ylw w100p">휴대폰재인증</a>
									<?}else{?>
									<a href="javascript:fnc_Auth();" class="btn btn_sm btn_ylw w100p">휴대폰인증</a>
									<?}?>
								</p>
							</td>
						</tr>
						<tr style="display:none;">
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
								
								<p><input type="text" class="inp w50p" value="<?=$arr_Data['STR_POST']?>" name="str_post" id="str_post" readonly /> <a href="javascript:execDaumPostcode();" class="btn btn_sm btn_bk w w30p">우편번호</a></p>
								<p class="mt05"><input type="text" name="str_addr1" id="str_addr1" readonly value="<?=$arr_Data['STR_ADDR1']?>" class="inp w100p" /></p>
								<p class="mt05"><input type="text" name="str_addr2" id="str_addr2" value="<?=$arr_Data['STR_ADDR2']?>" class="inp w100p" /></p>
							</td>
						</tr>
						<tr>
							<th>*이메일</th>
							<td>
								<p class="email_bx">
									<?$sTemp=Split("@",Fnc_Om_Conv_Default($arr_Data['STR_EMAIL'],"@"))?>
									<span class="email01"><input type="text" name="str_email1" value="<?=$sTemp[0]?>" class="inp w100p"/></span>
									<span class="email02">@</span>
									<span class="email01"><input type="text" name="str_email2" value="<?=$sTemp[1]?>" class="inp w100p"/></span>
									<span class="email03" style="width:100%;padding-top:5px;">
										<select title="이메일 도메인 선택" onChange="fnc_semail1(this.value)" class="selc w100p">
											<option value="">직접입력</option>	
											<option value="gmail.com">gmail.com</option>
											<option value="naver.com">naver.com</option>
											<option value="hanmail.net">hanmail.net</option>
											<option value="nate.com">nate.com</option>
											<option value="hotmail.com">hotmail.com</option>
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
								<p class="f_size_s mt05"><label><input type="checkbox" class="cform" name="str_mail_f" value="Y" <?if ($arr_Data['STR_MAIL_F']=="Y"){?> checked<?}?> /> 뉴스레터 및 안내 메일 수신 동의</label></p>
							</td>
						</tr>
						<tr style="display:none;">
							<th>추천인ID</th>
							<td>
								<p><input type="text"  class="inp w100p"/></p>
								<p class="f_size_s mt05">추천인ID 입력 고객과 해당하는 고객께는 <br />각각 <span class="f_red">스탬프 1개씩 적립!</span></p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div class="mt15">
				<p class="fl3_1"><a href="javascript:Save_Click();" class="btn btn_bk btn_ml w100p f_bd" style="margin-bottom: 15px;">개인정보 수정</a></p>
		
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

<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/footer.php"; ?>


<link rel="styleSheet" href="/css/sumoselect.css">
<script type="text/javascript" src="/js/custominputfile.min.js"></script>
<script type="text/javascript">
	$('#demo-1').custominputfile({
		theme: 'blue-grey',
		//icon : 'fa fa-upload'
	});
	$('#demo-2').custominputfile({
		theme: 'red',
		icon : 'fa fa-file'
	});
</script>


