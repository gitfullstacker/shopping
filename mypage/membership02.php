<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
?>
<?
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"1");

	$SQL_QUERY =	" SELECT
					*
				FROM "
					.$Tname."comm_site_info
				WHERE
					INT_NUMBER=1 ";

	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>
<script language="javascript" src="js/membership02.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   멤버십 정보</p>
					<div class="lnb_tab mt10">
						<? require_once $_SERVER[DOCUMENT_ROOT]."/mypage/tab.php"; ?>
					</div>
					<!-- <div class="tit_h2_2 mt45">멤버십 정보</div> -->



					<form id="frm" name="frm" target="_self" method="POST">
					<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
					<input type="hidden" name="int_gubun" value="<?=$int_gubun?>">

					<div class="tit_h3 mt50">등록 된 배송지</div>
					<div class="t_mypage mt15">
						<?
						$SQL_QUERY =	" SELECT
										A.*
									FROM "
										.$Tname."comm_member AS A
									WHERE
										A.STR_USERID='$arr_Auth[0]' ";

						$arr_Rlt_Data=mysql_query($SQL_QUERY);
						if (!$arr_Rlt_Data) {
				    		echo 'Could not run query: ' . mysql_error();
				    		exit;
						}
						$arr_mem_Data = mysql_fetch_assoc($arr_Rlt_Data);
						?>
						<table class="t_type01">
							<colgroup>
								<col style="width:185px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">개인정보 배송지 </th>
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
										                document.getElementById('str_spost').value = data.zonecode; 
										                //document.getElementById('str_post2').value = data.postcode2;
										                document.getElementById('str_saddr1').value = fullAddr;
										                //document.getElementById('sample2_addressEnglish').value = data.addressEnglish;
										                document.getElementById('str_saddr2').focus();
										
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
										<div>
											<!--<input type="text" class="inp01 w75" /> //-->
											<input type="text" class="inp01 w75" name="str_spost" id="str_spost" readonly value="<?=Fnc_Om_Conv_Default($arr_mem_Data['STR_SPOST'],$arr_mem_Data['STR_POST'])?>"/>
											<a href="javascript:execDaumPostcode();" class="btn btn_bk btn_m w95">우편번호</a>
										</div>
										<div class="mt15">
											<input type="text" class="inp01 w325" name="str_saddr1" id="str_saddr1" readonly value="<?=Fnc_Om_Conv_Default($arr_mem_Data['STR_SADDR1'],$arr_mem_Data['STR_ADDR1'])?>" /> 
											<input type="text" class="inp01 w325" name="str_saddr2" id="str_saddr2" value="<?=Fnc_Om_Conv_Default($arr_mem_Data['STR_SADDR2'],$arr_mem_Data['STR_ADDR2'])?>" />
										</div>
										
									</td>
								</tr>
								<tr>
									<th class="left"><span class="f_org">부재 시 택배 보관 장소</span></th>
									<td class="left">
 										<div class="t_cover03 t_cart_in">
											<table class="t_type01">
												<colgroup>
													<col style="width:120px;" />
													<col style="width:200px;" />
													<col style="width:120px;" />
													<col />
												</colgroup>
												<tbody>
													<tr>
														<th>경비실</th>
														<td class="line_r">
															<label><input type="radio" name="str_splace1" value="1" <?if (Fnc_Om_Conv_Default($arr_mem_Data['STR_SPLACE1'],"")=="1") {?>checked<?}?>/> 있다</label>
															<label><input type="radio" name="str_splace1" value="0" <?if (Fnc_Om_Conv_Default($arr_mem_Data['STR_SPLACE1'],"")=="0") {?>checked<?}?>/> 없다</label>
														</td>
														<th>무인택배함</th>
														<td>
															<label><input type="radio" name="str_splace2" value="1" <?if (Fnc_Om_Conv_Default($arr_mem_Data['STR_SPLACE2'],"")=="1") {?>checked<?}?>/> 있다</label>
															<label><input type="radio" name="str_splace2" value="0" <?if (Fnc_Om_Conv_Default($arr_mem_Data['STR_SPLACE2'],"")=="0") {?>checked<?}?>/> 없다</label>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<p class="txt_indent10 mt10">※ 경비실/무인 택배함 모두 없으신 고객님께서는 가방 분실의 위험을 줄이기 위해 <br />직장 등 택배를 직접 수령할 수 있는 주소를 기재해 주세요.</p>
									</td>
								</tr>
							</tbody>
						</table>
						<p class="request_btn"><a href="javascript:Save_Click();" class="btn btn_ylw"><span>등록하기</span></a></p>
					</div>

					<div class="tit_h3 mt60" style="display:none;">카드 정보 등록</div>
					<div class="t_mypage mt15" style="display:none;">
						<table class="t_type01">
							<colgroup>
								<col style="width:185px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">카드번호</th>
									<td class="left">
										<input type="text" class="inp01 w100" /> 
										<input type="text" class="inp01 w100" />
										<input type="text" class="inp01 w100" /> 
										<input type="text" class="inp01 w100" />
									</td>
								</tr>
								<tr>
									<th class="left">유효기간</th>
									<td class="left">
										MONTH
										<span class="pl10"><input type="text" class="inp01 w65" /></span>
										<span class="pl10">/ YEAR</span>
										<span class="pl10"><input type="text" class="inp01 w65" /></span>
									</td>
								</tr>
								<tr>
									<th class="left">CVC</th>
									<td class="left">
										<input type="text" class="inp01 w100" /> 
									</td>
								</tr>
								<tr>
									<td colspan="2" class="left">
										<input type="checkbox" /> 서비스 이용 약정에 동의합니다 (최초 2회 연속 필수, 약정 이후 해지 가능)
									</td>
								</tr>
							</tbody>
						</table>
						<p class="request_btn"><a href="#" class="btn btn_ylw"><span>등록하기</span></a></p>
					</div>

					<div class="t_membership mt45">
						<table class="t_type01">
							<colgroup>
								<col style="width:300px;" />
								<col style="width:180px;" />
								<col />
							</colgroup>
							<thead>
								<tr>
									<th>이용요금</th>
									<th>왕복배송비</th>
									<th>배송비 할인</th>
								</tr>
							</thead>
							<tbody>
								<tr> 
									<td class="f_bd f_bk" style="height:110px;">
										<?if ($int_gubun=="1"){?>
										정기권<p>\<?=number_format($arr_Data['INT_PRICE1'])?></p>
										<?}else{?>
										1개월권<p>\<?=number_format($arr_Data['INT_PRICE2'])?></p>
										<?}?>
									</td>
									<td>20,000원</td>
									<td>-20,000원</td>
								</tr>
							</tbody>
						</table>
						<dl class="th_total">
							<dt>총 이용 요금</dt>
							<dd>
								<?if ($int_gubun=="1"){?>
								<?=number_format($arr_Data['INT_PRICE1'])?>원
								<?}else{?>
								<?=number_format($arr_Data['INT_PRICE2'])?>원
								<?}?>
							</dd>
						</dl>
					</div>
					<p class="mt15">* 정기권을 신청하신 회원은 매회 자동결제가 됩니다</p>
					<p class="mt10">* 정기권 등록 가능한 신용카드 [신한, 국민, 롯데, 현대, NH, 삼성] </p>
				
					

					<?if ($int_gubun=="1") {?>
						<? require_once $_SERVER[DOCUMENT_ROOT]."/mypage/inc_info1.php"; ?>
					<?}else{?>
						<? require_once $_SERVER[DOCUMENT_ROOT]."/mypage/inc_info2.php"; ?>
					<?}?>

					<table border="0" style="display:none;">
						<tr>
							<td id="obj_Lbl" colspan="2" height="0"></td>
						</tr>
					</table>

				
					

					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"; ?>
