<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],5);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],5);

	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member_pay_info a inner join ".$Tname."comm_member_pay b on a.int_number=b.int_number where a.int_number is not null and b.str_userid='$arr_Auth[0]' ";
	$SQL_QUERY.=$Str_Query;
	$result = mysql_query($SQL_QUERY);

	if(!result){
	   error("QUERY_ERROR");
	   exit;
	}
	$total_record = mysql_result($result,0,0);

	if(!$total_record){
		$first = 1;
		$last = 0;
	}else{
	  	$first = $displayrow *($page-1) ;
	  	$last = $displayrow *$page;

	  	$IsNext = $total_record - $last ;
	  	if($IsNext > 0){
			$last -= 1;
	  	}else{
	   		$last = $total_record -1 ;
	  	}
	}
	$total_page = ceil($total_record/$displayrow);

	$f_limit=$first;
	$l_limit=$last + 1 ;

	$SQL_QUERY = "select a.*,b.str_ptype,b.str_cardcode,b.str_cancel,b.str_pass from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member_pay_info a inner join ".$Tname."comm_member_pay b on a.int_number=b.int_number ";
	$SQL_QUERY.="where a.int_number is not null and b.str_userid='$arr_Auth[0]' ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.int_snumber desc ";
	$SQL_QUERY.="limit $f_limit,$l_limit";

	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>
<script language="javascript" src="js/membership02_1.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   구독권 정보</p>
					<div class="lnb_tab mt10">
						<? require_once $_SERVER['DOCUMENT_ROOT']."/mypage/tab.php"; ?>
					</div>
					<!-- <div class="tit_h2_2 mt45">멤버십 정보</div> -->
					<div class="tit_h3 mt45">구독권 현황</div>
					<p class="mt10">카드 변경을 원하시면 고객센터로 문의해주세요. </p>
					
					<form id="frm" name="frm" target="_self" method="POST" action="membership02_1.php">
					<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
					<input type="hidden" name="page" value="<?=$page?>">
					<input type="hidden" name="str_no">

					<?
					$Sql_Query =	" SELECT 
									B.*,A.STR_PTYPE,A.STR_CANCEL,A.STR_CARDCODE,A.STR_PASS
								FROM `"
									.$Tname."comm_member_pay` AS A
									INNER JOIN
									`".$Tname."comm_member_pay_info` AS B
									ON
									A.INT_NUMBER=B.INT_NUMBER
									AND 
									A.STR_PASS='0' 
									AND
									date_format(B.STR_SDATE, '%Y-%m-%d') <= '".date("Y-m-d")."'
									AND
									date_format(B.STR_EDATE, '%Y-%m-%d') >= '".date("Y-m-d")."' 
									AND
									A.STR_USERID='$arr_Auth[0]' ";
			
					$arr_Data=mysql_query($Sql_Query);
					$arr_Data_Cnt=mysql_num_rows($arr_Data);
					?>					
					<div class="membership_bx01 mt15">
						구독권 기간은 <?=substr(mysql_result($arr_Data,0,str_edate),0,4)?>년<?=substr(mysql_result($arr_Data,0,str_edate),5,2)?>월 <?=substr(mysql_result($arr_Data,0,str_edate),8,2)?>일까지 입니다.
					</div>
					
					<?if (mysql_result($arr_Data,0,str_ptype)=="1"){?>
					<div class="tit_h3 mt60">구독권</div>
					<div class="t_mypage mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:185px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">카드종류</th>
									<td class="left">
										<span class="f_bk f_bd"><?=fnc_card_kind(mysql_result($arr_Data,0,str_cardcode))?></span>
									</td>
								</tr>
							</tbody>
						</table>
						<p class="request_btn02">
							<?if (mysql_result($arr_Data,0,str_pass)=="1") {?>
								<a href="#;" class="btn btn_ylw"><span>해지완료</span></a>
							<?}else{?>
								<?if (mysql_result($arr_Data,0,str_cancel)=="1") {?>
									<a href="javascript:fnc_cancel('<?=mysql_result($arr_Data,0,int_number)?>');" class="btn btn_ylw"><span>해지신청중</span></a>
								<?}else{?>
									<a href="javascript:fnc_mse('<?=mysql_result($arr_Data,0,int_number)?>');" class="btn btn_ylw"><span>해지신청하기</span></a>
								<?}?>
							<?}?>
						</p>
					</div>
					<p class="mt10">구독권을 해지하실 경우, 가방 반납은 별도 신청하셔야 하며 반납이 지연될 경우 연체료(10,000원/일)가 발생합니다. </p>
					<?}?>

					<?if (mysql_result($arr_Data,0,str_ptype)=="2"){?>
					<!--
					<div class="tit_h3 mt60">등록 된 카드</div>
					<div class="t_mypage mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:185px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">카드종류</th>
									<td class="left">
										<span class="f_bk f_bd"><?=mysql_result($arr_Data,0,str_cardcode)?></span>
									</td>
								</tr>
							</tbody>
						</table>
						<p class="request_btn02"><a href="membership.php?str_repay=1" class="btn btn_ylw"><span>갱신하기</span></a></p>
					</div>
					//-->
					<?}?>
					
					
					<?
					$Sql_Query =	" SELECT 
									B.*,A.STR_PTYPE,A.STR_CANCEL,A.STR_CARDCODE,A.STR_PASS
								FROM `"
									.$Tname."comm_member_pay` AS A
									INNER JOIN
									`".$Tname."comm_member_pay_info` AS B
									ON
									A.INT_NUMBER=B.INT_NUMBER
									AND 
									A.STR_PASS='0' 
									AND
									A.STR_PTYPE='1' 
									AND
									A.STR_USERID='$arr_Auth[0]' ";
			
					$arr_MemData=mysql_query($Sql_Query);
					$arr_MemData_Cnt=mysql_num_rows($arr_MemData);
					?>		
					
					<?if (!$arr_MemData_Cnt) {?>
					<?if (mysql_result($arr_Data,0,str_ptype)=="2"){?>
					<div class="center mt45">
						<a href="javascript:fnc_mpay();" class="btn btn_l btn_bk w w270 f_bd">정기권으로 연장하기</a>
					</div>
					<?}?>
					<?}?>

					<div class="tit_h3 mt60">등록 된 배송지</div>
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
											<input type="text" class="inp01 w75" name="str_spost" id="str_spost" readonly value="<?=$arr_mem_Data['STR_SPOST']?>"/>
											<a href="javascript:execDaumPostcode();" class="btn btn_bk btn_m w95">우편번호</a>
										</div>
										<div class="mt15">
											<input type="text" class="inp01 w325" name="str_saddr1" id="str_saddr1" readonly value="<?=$arr_mem_Data['STR_SADDR1']?>" /> 
											<input type="text" class="inp01 w325" name="str_saddr2" id="str_saddr2" value="<?=$arr_mem_Data['STR_SADDR2']?>" />
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
						


					<div class="tit_h3 mt60">결제 내역</div>
					<div class="t_cover01 mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:120px;" />
								<col style="width:200px;" />
								<col style="width:150px;" />
								<col style="width:150px;" />
								<col style="width:100px;" />
								<col style="width:180px;" />
								<col />
							</colgroup>
							<thead>
								<tr>
									<th>구분</th>
									<th>결제일자</th>
									<th>결제금액</th>
									<th>카드종류</th>
									<th>취소신청</th>
									<th>결제구분</th>
									<th>유효기간</th>
								</tr>
							</thead>
							<tbody>
								<?$count=0;?>
								<?if($total_record_limit!=0){?>
								<?$article_num = $total_record - $displayrow*($page-1) ;?>
								<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
								<tr>
									<td>
										<?switch (mysql_result($result,$i,str_ptype)) {
											case  "1" : echo "멥버십회원"; break;
											case  "2" : echo "1개월권회원"; break;
										}
										?>
									</td>
									<td><?=mysql_result($result,$i,dtm_indate)?></td>
									<td><?=number_format(mysql_result($result,$i,int_sprice))?>원</td>
									<td><?=fnc_card_kind(mysql_result($result,$i,str_cardcode))?></td>
									<td>
										<?if (mysql_result($result,$i,str_ptype)=="2") {?>
											<?if (mysql_result($result,$i,str_pass)=="0") {?>
												<?if (mysql_result($result,$i,str_cancel)=="0") {?>
													<a href="javascript:fnc_es('<?=mysql_result($result,$i,int_number)?>')">취소신청</a>
												<?}else{?>
													취소신청중
												<?}?>
											<?}else{?>
												-
											<?}?>
										<?}else{?>
											-
										<?}?>
									</td>
									<td>
									<?switch (mysql_result($result,$i,str_pass)) {
										case  "0" : echo "결제완료"; break;
										case  "1" : echo "결제취소"; break;
									}
									?>
									</td>
									<td><?=mysql_result($result,$i,str_sdate)?>~<?=mysql_result($result,$i,str_edate)?></td>
								</tr>
								<?$count++;?>
								<?
								$article_num--;
								if($article_num==0){
									break;
								}
								?>
								<?}?>
								<?}else{?>
								<tr>
									<td colspan="6">내역이 없습니다.</td>
								</tr>
								<?}?>
								<input type="hidden" name="txtRows" value="<?=$count?>">
							</tbody>
						</table>
					</div>
					<div class="paging02 mt30">
						<?
						$total_block = ceil($total_page/$displaypage);
						$block = ceil($page/$displaypage);

						$first_page = ($block-1)*$displaypage;
						$last_page = $block*$displaypage;

						if($total_block <= $block) {
   							$last_page = $total_page;
						}

						$file_link= basename($PHP_SELF);
						$link="$file_link?$param";

						if($page > 1) {?>
							<a href="Javascript:MovePage4('1');" class="img_b"><img src="../images/board/btn_page_first.gif" alt="" /></a>
						<?}else{?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_first.gif" alt="" /></a>
						<?}

						if($block > 1) {
						   $my_page = $first_page;
						?>
							<a href="Javascript:MovePage4('<?=$my_page?>');" class="img_b"><img src="../images/board/btn_page_prev.gif" alt="" /></a>
						<?}else{?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_prev.gif" alt="" /></a>
						<?}

						for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
						   if($page == $direct_page) {?>
						      	<a href="#;" class="on"><?=$direct_page?></a>
						   <?} else {?>
						    	<a href="Javascript:MovePage4('<?=$direct_page?>');"><?=$direct_page?></a>
						   <?}
						}

						if($block < $total_block) {
						   	$my_page = $last_page+1;?>
						    <a href="Javascript:MovePage4('<?=$my_page?>');" class="img_b"><img src="../images/board/btn_page_next.gif" alt="" /></a>
						<?}else{ ?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_next.gif" alt="" /></a>
						<?}

						if($page < $total_page) {?>
							<a href="Javascript:MovePage4('<?=$total_page?>');" class="img_b"><img src="../images/board/btn_page_last.gif" alt="" /></a>
						<?}else{?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_last.gif" alt="" /></a>
						<?}
						?>
					</div>
					
					</form>
					
					<table border="0" style="display:none;">
						<tr>
							<td id="obj_Lbl" colspan="2" height="0"></td>
						</tr>
					</table>
					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
