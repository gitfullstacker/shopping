<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();
	
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	
	$SQL_QUERY =	" SELECT
					A.*,B.*
				FROM "
					.$Tname."comm_goods_cart AS A
					INNER JOIN
					".$Tname."comm_goods_master AS B
					ON
					A.STR_GOODCODE=B.STR_GOODCODE
				WHERE
					A.INT_STATE IN ('4') AND STR_USERID='$arr_Auth[0]' ORDER BY A.DTM_INDATE DESC LIMIT 1 ";
	
	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
			echo 'Could not run query: ' . mysql_error();
			exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	
	$SQL_QUERY =	" SELECT
					A.*,B.*
				FROM "
					.$Tname."comm_goods_cart AS A
					INNER JOIN
					".$Tname."comm_goods_master AS B
					ON
					A.STR_GOODCODE=B.STR_GOODCODE
				WHERE
					A.INT_STATE IN ('0') AND STR_USERID='$arr_Auth[0]' AND INT_NUMBER='$str_no' ";
	
	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
			echo 'Could not run query: ' . mysql_error();
			exit;
	}
	$arr_Data2 = mysql_fetch_assoc($arr_Rlt_Data);
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/return.js"></script>	
		
		<div class="con_width">
			
			<!-- <div class="tit_h2 mt25">
				<em>반납</em>
				<span class="tit_h2_desc">신청해 주시면 빠르게 처리해 드리겠습니다. </span>
			</div> -->

			<form id="frm" name="frm" target="_self" method="POST">
          	<input type="hidden" name="RetrieveFlag">
          	<input type="hidden" name="str_rno" value="<?=$arr_Data["INT_NUMBER"]?>">
          	<input type="hidden" name="str_no" value="<?=$str_no?>">
          	<input type="hidden" name="str_place1" value="<?=$arr_Data["STR_PLACE1"]?>">
          	<input type="hidden" name="str_place2" value="<?=$arr_Data["STR_PLACE2"]?>">
		          	
		          	
			<?if ($arr_Data["INT_NUMBER"]=="") {?>	
			<p class="center pt15" style="margin-bottom: 300px; margin-top: 350px;" >반납하실 가방이 존재하지 않습니다.<br />반납 중인 가방 정보는 [마이 페이지 - 가방 내역] 에서 <br />확인하실 수 있습니다.</p>
			<?}else{?>
		          	
		        <?if ($arr_Data["INT_NUMBER"]!="") {?>	
				<div class="t_cover01 mt10">
					<div class="get_item_tit">반납 예정 가방</div>
					<ul class="item_list">
						<li>
							<a href="#;">
								<p class="item_img"><?if ($arr_Data["STR_IMAGE1"]!="") {?><img src="/admincenter/files/good/<?=$arr_Data["STR_IMAGE1"]?>" alt="" /><?}?></p>
								<div class="item_info">
									<p class="f_bd f_bk "><?=$arr_Data["STR_GOODNAME"]?></p>
									<p><?=$arr_Data["STR_EGOODNAME"]?></p>
								</div>
							</a>
						</li>
					</ul>
				</div>
				
				<?if ($arr_Data2["INT_NUMBER"]!="") {?>
				<div class="t_cover01 mt10">
					<div class="get_item_tit">교환 예정 가방</div>
					<ul class="item_list">
						<li>
							<a href="#;">
								<p class="item_img"><?if ($arr_Data2["STR_IMAGE1"]!="") {?><img src="/admincenter/files/good/<?=$arr_Data2["STR_IMAGE1"]?>" alt="" /><?}?></p>
								<div class="item_info">
									<p class="f_bd f_bk"><?=$arr_Data2["STR_GOODNAME"]?></p>
									<p><?=$arr_Data2["STR_EGOODNAME"]?></p>
								</div>
							</a>
						</li>
					</ul>
				</div>
				<?}?>
				<?}?>
				
				<div class="t_cover01 mt15">
					<table class="t_type">
						<colgroup>
							<col style="width:30%;" />
							<col style="width:70%;" />
						</colgroup>
						<tbody>
							<tr>
								<th>이름</th>
								<td><?=$arr_Data['STR_NAME']?></td>
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
									<p><input type="text" name="str_post" id="str_post" readonly value="<?=Fnc_Om_Conv_Default($arr_Data['STR_POST'],$arr_Mem_Data['STR_SPOST'])?>" class="inp w50p" /> <a href="javascript:execDaumPostcode();" class="btn btn_sm btn_bk w w30p">우편번호</a></p>
									<p class="mt05"><input type="text" name="str_addr1" id="str_addr1" readonly value="<?=Fnc_Om_Conv_Default($arr_Data['STR_ADDR1'],$arr_Mem_Data['STR_SADDR1'])?>" class="inp w100p" /></p>
									<p class="mt05"><input type="text" name="str_addr2" id="str_addr2" value="<?=Fnc_Om_Conv_Default($arr_Data['STR_ADDR2'],$arr_Mem_Data['STR_SADDR2'])?>" class="inp w100p" /></p>
								</td>
							</tr>
							<tr>
								<th>반납 방법</th>
								<td>
									<ul class="list_type01">
										<li><label><input type="radio" value="1" name="str_method" class="cform" /> 직접 수령지에서</label></li>
										<li><label><input type="radio" value="2" name="str_method" class="cform" /> 경비실에 맡긴다</label></li>
										<li><label><input type="radio" value="3" name="str_method" class="cform" /> 무인택배함</label></li>
									</ul>
								</td>
							</tr>
							<tr>
								<th>반납 날짜/시간</th>
								<td>
									<?
									$str = date("H", mktime());
									if ($str <  22) {
										$int_M=1;
									}else{
										$int_M=2;
									}
									?>
									<select name="str_rdate" id="str_rdate" class="selc w100p">
										<option value="">반납 날짜</option>
										<?=$int_J=0?>
										<?for ($int_I=$int_M;$int_I<=10;$int_I++){?>
										<?if (date("w", strtotime($day.$int_I."day"))!=0&&date("w", strtotime($day.$int_I."day"))!=6) {?>
											<?if ($int_J<2) {?>
											<option value="<?=date("Y-m-d", strtotime($day.$int_I."day"))?>"><?=date("Y-m-d", strtotime($day.$int_I."day"))?> 
											<?}?>
											<?$int_J++;?>
										<?}?>
										<?}?>
									</select>
								</td>
							</tr>
							<tr>
								<th>기타 메모</th>
								<td><input type="text" name="str_rmemo" class="inp w100p" /></td>
							</tr>
						</tbody>
					</table>
				</div>
				<dl class="get_info_txt mt10">
					<dt>반납 시 유의사항 :<br />
					반납일에 우체국 기사님이 방문 예정이며, 가방/구성품을 모두 포장해주세요.<br />
					가방들의 안전을 위해, 기사님의 연락을 받으실 경우에만 반납이 진행됩니다. </dt>
					<dd><label><input type="checkbox" name="str_agree" class="cform" /> 확인 하였습니다.</label> </dd>
				</dl>
				<div class="center mt15">
					
					<?if ($arr_Data2["INT_NUMBER"]!="") {?>
					<a href="javascript:Click_Change();;" class="btn btn_l btn_bk w w100p f_bd">교환 확정</a>
					<?}else{?>
					<a href="javascript:Click_Return();;" class="btn btn_l btn_bk w w100p f_bd">반납 확정</a>
					<?}?>
					
				</div>
			</form>
			
			<?}?>

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/footer.php"; ?>



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