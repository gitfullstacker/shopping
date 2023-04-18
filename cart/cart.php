<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	$SQL_QUERY =	" SELECT
					A.*,B.STR_GOODNAME,B.STR_EGOODNAME,B.STR_IMAGE1
				FROM "
					.$Tname."comm_goods_cart AS A INNER JOIN ".$Tname."comm_goods_master AS B ON A.STR_GOODCODE=B.STR_GOODCODE
				WHERE
					A.INT_NUMBER='$str_no' AND A.STR_USERID='$arr_Auth[0]' AND A.INT_STATE='0' ";

	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	
	if ($arr_Data['INT_NUMBER']=="") {
		echo "<script language='javascript'>alert('상품이 없습니다.');window.location.href='/main/index.php';</script>";
		exit;
	}

	$SQL_QUERY =	" SELECT
					A.*
				FROM "
					.$Tname."comm_member AS A
				WHERE
					A.STR_USERID='$arr_Auth[0]' ";

	$arr_Me_Data=mysql_query($SQL_QUERY);
	if (!$arr_Me_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Mem_Data = mysql_fetch_assoc($arr_Me_Data);


?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>
<script language="javascript" src="js/cart.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   GET CART</p>
					<!-- <div class="tit_h2 mt10">GET CART</div> -->
					
		          	<form id="frm" name="frm" target="_self" method="POST">
		          	<input type="hidden" name="RetrieveFlag">
		          	<input type="hidden" name="str_no" value="<?=$str_no?>">
					
					<p class="tit_desc mt10">고객님께서 GET 하신 상품입니다. 배송 정보 확인 후 확정 부탁드려요. </p>
					<div class="cart_w mt35">
						<div class="cart_l">
							<div class="t_cover01 mt15">
								<table class="t_type01">
									<colgroup>
										<col style="width:125px;" />
										<col />
									</colgroup>
									<tbody>
										<tr>
											<th class="left">이름</th>
											<td class="left"><?=$arr_Data['STR_NAME']?></td>
										</tr>
										<tr>
											<th class="left">주소</th>
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
												<p><input type="text" name="str_post" id="str_post" readonly value="<?=Fnc_Om_Conv_Default($arr_Data['STR_POST'],$arr_Mem_Data['STR_SPOST'])?>" class="inp01 w75" /> <!-- <input type="text" class="inp01 w75" />//--> <a href="javascript:execDaumPostcode();" class="btn btn_bk btn_m w95">우편번호</a></p>
												<p class="mt15"><input type="text" name="str_addr1" id="str_addr1" readonly value="<?=Fnc_Om_Conv_Default($arr_Data['STR_ADDR1'],$arr_Mem_Data['STR_SADDR1'])?>" class="inp01 w270" /> <input type="text" name="str_addr2" id="str_addr2" value="<?=Fnc_Om_Conv_Default($arr_Data['STR_ADDR2'],$arr_Mem_Data['STR_SADDR2'])?>" class="inp01 w270" /></p>
											</td>
										</tr>
										<tr>
											<th class="left">맡길 곳</th>
											<td class="left">
												<div class="t_cover03 t_cart_in">
													<table class="t_type01">
														<colgroup>
															<col style="width:105px;" />
															<col style="width:170px;" />
															<col style="width:105px;" />
															<col />
														</colgroup>
														<tbody>
															<tr>
																<th>경비실</th>
																<td class="line_r">
																	<label><input type="radio" value="1" name="str_place1" <?if (Fnc_Om_Conv_Default($arr_Data['STR_PLACE1'],$arr_Mem_Data['STR_SPLACE1'])=="1") {?> checked<?}?> /> 있다</label>
																	<label><input type="radio" value="0" name="str_place1" <?if (Fnc_Om_Conv_Default($arr_Data['STR_PLACE1'],$arr_Mem_Data['STR_SPLACE1'])=="0") {?> checked<?}?> /> 없다</label>
																</td>
																<th>무인택배함</th>
																<td>
																	<label><input type="radio" value="1" name="str_place2" <?if (Fnc_Om_Conv_Default($arr_Data['STR_PLACE2'],$arr_Mem_Data['STR_SPLACE2'])=="1") {?> checked<?}?> /> 있다</label>
																	<label><input type="radio" value="0" name="str_place2" <?if (Fnc_Om_Conv_Default($arr_Data['STR_PLACE2'],$arr_Mem_Data['STR_SPLACE2'])=="0") {?> checked<?}?> /> 없다</label>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</td>
										</tr>
										<tr>
											<th class="left">기타 메모</th>
											<td class="left"><input type="text" name="str_memo" class="inp01 w545" /></td>
										</tr>
										<tr>
											<th class="left">기간</th>
											<td class="left"><?=$arr_Data['STR_SDATE']?> ~ <?=$arr_Data['STR_EDATE']?></td>
										</tr>
									</tbody>
								</table>
								<div class="get_check">
									<dl>
										<dt>* GET 확정시 유의사항 : <br />멤버십 기간 만료 하루 전까지 반납신청 해주셔야 하며, <br />가방 오염/파손 발생 시 절대 수선 및 세탁 하지 마시고 에이블랑에 알려주시기 바랍니다. </dt>
										<dd><label><input type="checkbox" name="str_agree" /> 확인하였습니다.</label></dd>
									</dl>
								</div>
							</div>
						</div>
						<div class="cart_r">
							<div class="t_cover01 mt15">
								<table class="t_type01">
									<colgroup>
										<col style="width:60px;" />
										<col style="width:120px;" />
										<col />
									</colgroup>
									<thead>
										<tr>
											<th colspan="3">GET 예정 상품</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<!--<td><input type="radio" /></td>//-->
											<td style="width:120px;height:120px;"><?if ($arr_Data['STR_IMAGE1']!=""){?><img src="/admincenter/files/good/<?=$arr_Data['STR_IMAGE1']?>" alt="" style="width:120px;height:120px;" class="img_bd" /><?}?></td>
											<td class="left v_top">
												<p class="f_bd f_bk mt10"><?=$arr_Data['STR_GOODNAME']?></p>
												<p class="mt10"><?=$arr_Data['STR_EGOODNAME']?></p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="center mt50"><a href="javascript:Save_Click();" class="btn btn_l btn_bk w w270 f_bd"><em>GET</em> 확정</a></div>
					
					</form>

					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
