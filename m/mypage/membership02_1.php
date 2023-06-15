<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();
?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],3);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);

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

	$SQL_QUERY = "select a.*,b.str_ptype,b.str_cardcode,b.str_cancel1,b.str_pass from ";
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
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/membership02_1.js"></script>
		
		<div class="con_width">
			
			<div class="tit_h2 mt100">
				<em>멤버십 정보</em>
			</div>

			<form id="frm" name="frm" target="_self" method="POST" action="membership02_1.php">
			<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="str_no">

			<div class="tit_h3 pt15">구독권 기간</div>

			<?
			$Sql_Query =	" SELECT 
							B.*,A.STR_PTYPE,A.STR_CANCEL1,A.STR_CARDCODE,A.STR_PASS
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
			<div class="membership_bx01 mt07">구독권 기간은 <?=substr(mysql_result($arr_Data,0,str_edate),0,4)?>년 <?=substr(mysql_result($arr_Data,0,str_edate),5,2)?>월 <?=substr(mysql_result($arr_Data,0,str_edate),8,2)?>일까지 입니다.</div>

			<?if (mysql_result($arr_Data,0,str_ptype)=="1"){?>
			<div class="mt08" style="text-align:center"> 카드 변경을 원하시면 고객센터로 문의해 주세요 </div>
			<div class="tit_h3 mt50">구독권</div>
			<div class="t_cover01 mt07">
				<table class="t_type">
					<colgroup>
						<col style="width:30%;" />
						<col />
						<col style="width:35%;" />
					</colgroup>
					<tbody>
						<tr>
							<th>카드 종류</th>
							<td><?=fnc_card_kind(mysql_result($arr_Data,0,str_cardcode))?></td>
							<td>
								<?if (mysql_result($arr_Data,0,str_pass)=="1") {?>
									<a href="#;" class="btn btn_ylw btn_ml f_bd w30p"><span>해지완료</span></a>
								<?}else{?>
									<?if (mysql_result($arr_Data,0,str_cancel1)=="1") {?>
										<a href="javascript:fnc_cancel('<?=mysql_result($arr_Data,0,int_number)?>');" class="btn btn_ylw btn_ml f_bd w100p"><span>해지신청 취소하기</span></a>
									<?}else{?>
										<a href="javascript:fnc_mse('<?=mysql_result($arr_Data,0,int_number)?>');" class="btn btn_ylw btn_ml f_bd w100p"><span>해지신청하기</span></a>
									<?}?>
								<?}?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="mt08" style="text-align:center">  구독권을 해지하실 경우, 가방 반납은 별도 신청하셔야 하며 </br> 반납이 지연될 경우 연체료(10,000원/일)가 발생합니다. </div>
			<div class="right mt15"></div>
			<?}?>
			
			
			<?
			$Sql_Query =	" SELECT 
							B.*,A.STR_PTYPE,A.STR_CANCEL1,A.STR_CARDCODE,A.STR_PASS
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
			<div class="center mt10">
				<a href="javascript:fnc_mpay();" class="btn btn_l btn_bk w50p f_bd">정기권으로 연장하기</a>
				<!--<a href="javascript:alert('정기권은 PC에서 신청 부탁드립니다.');" class="btn btn_l btn_bk w50p f_bd">정기권으로 연장하기</a>//-->
			</div>
			<?}?>
			<?}?>
			

			<div class="tit_h3 mt50">등록 된 배송지</div>
			
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
				<div class="t_cover01 mt07">
					<table class="t_type">
						<colgroup>
							<col style="width:30%;" />
							<col style="width:70%;" />
						</colgroup>
						<tbody>
							<tr>
								<th>개인정보<br />배송지 </th>
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
									<p><input type="text" name="str_spost" id="str_spost" readonly value="<?=$arr_mem_Data['STR_SPOST']?>" class="inp w50p" /> <a href="javascript:execDaumPostcode();" class="btn btn_sm btn_bk w w30p">우편번호</a></p>
									<p class="mt05"><input type="text" name="str_saddr1" id="str_saddr1" readonly value="<?=$arr_mem_Data['STR_SADDR1']?>" class="inp w100p" /></p>
									<p class="mt05"><input type="text" name="str_saddr2" id="str_saddr2" value="<?=$arr_mem_Data['STR_SADDR2']?>" class="inp w100p" /></p>
								</td>
							</tr>
							<tr>
								<th>맡길 곳</th>
								<td>
									<div class="t_cover02">
										<table>
											<colgroup>
												<col style="width:40%;" />
												<col style="width:60%;" />
											</colgroup>
											<tbody>
												<tr>
													<th>경비실</th>
													<td>
														<label><input type="radio" class="cform" name="str_splace1" value="1" <?if (Fnc_Om_Conv_Default($arr_mem_Data['STR_SPLACE1'],"")=="1") {?>checked<?}?>> 있다</label>
														<label class="pl15"><input type="radio" class="cform"  name="str_splace1" value="0" <?if (Fnc_Om_Conv_Default($arr_mem_Data['STR_SPLACE1'],"")=="0") {?>checked<?}?>> 없다</label>
													</td>
												</tr>
												<tr>
													<th>무인택배함</th>
													<td>
														<label><input type="radio" class="cform" name="str_splace2" value="1" <?if (Fnc_Om_Conv_Default($arr_mem_Data['STR_SPLACE2'],"")=="1") {?>checked<?}?>> 있다</label>
														<label class="pl15"><input type="radio" class="cform"  name="str_splace2" value="0" <?if (Fnc_Om_Conv_Default($arr_mem_Data['STR_SPLACE2'],"")=="0") {?>checked<?}?>> 없다</label>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<p class="txt_indent10 mt05">※ 경비실/무인 택배함 모두 없으신 고객님께서는 가방 분실의 위험을 줄이기 위해 직장 등 택배를 직접 수령할 수 있는 주소를 기재해 주세요.</p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="mt15"><a href="javascript:Save_Click();" class="btn btn_ylw btn_ml f_bd w100p">등록하기</a></div>

			<div class="tit_h3 mt50">결제 내역</div>
			<div class="t_cover01 mt07">
				<table class="t_type01">
					<colgroup>
						<col style="width:40%;" />
						<col />
					</colgroup>
					<thead>
						<tr>
							<th class="f_bd line_r">결제일자/구분</th>
							<th class="f_bd">결제 내역</th>
						</tr>
					</thead>
					<tbody>
						<?$count=0;?>
						<?if($total_record_limit!=0){?>
						<?$article_num = $total_record - $displayrow*($page-1) ;?>
						<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
						<tr>
							<td class="line_r">
								<p>
									<?switch (mysql_result($result,$i,str_ptype)) {
										case  "1" : echo "멥버십회원"; break;
										case  "2" : echo "1개월권회원"; break;
									}
									?>
								</p>
								<p><?=mysql_result($result,$i,dtm_indate)?></p>
							</td>
							<td class="left">
								<p><span class="f_bd f_bk">결제금액 : </span><?=number_format(mysql_result($result,$i,int_sprice))?>원  <?=fnc_card_kind(mysql_result($result,$i,str_cardcode))?></p>
								<p><span class="f_bd f_bk">취소신청 : </span>
									<?if (mysql_result($result,$i,str_ptype)=="2") {?>
										<?if (mysql_result($result,$i,str_pass)=="0") {?>
											<?if (mysql_result($result,$i,str_cancel1)=="0") {?>
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
								</p>
								<p><span class="f_bd f_bk">결제구분 : </span>
									<?switch (mysql_result($result,$i,str_pass)) {
										case  "0" : echo "결제완료"; break;
										case  "1" : echo "결제취소"; break;
									}
									?>
								</p>
								<p><span class="f_bd f_bk">유효기간 : </span> <?=mysql_result($result,$i,str_sdate)?>~<?=mysql_result($result,$i,str_edate)?></p>
							</td>
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
							<td colspan="2" align="center">내역이 없습니다.</td>
						</tr>
						<?}?>
						<input type="hidden" name="txtRows" value="<?=$count?>">
					</tbody>
				</table>
			</div>
			<div class="paging mt15" style="margin-bottom: 15px;">
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
					<a href="Javascript:MovePage4('1');" class="pg_nav pg_fir"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_fir"></a>
				<?}

				if($block > 1) {
				   $my_page = $first_page;
				?>
					<a href="Javascript:MovePage4('<?=$my_page?>');" class="pg_nav pg_prev"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_prev"></a>
				<?}
				?>
				<span class="num">
				<?
				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				   if($page == $direct_page) {?>
				      	<a href="#;" class="on"><?=$direct_page?></a>
				   <?} else {?>
				    	<a href="Javascript:MovePage4('<?=$direct_page?>');"><?=$direct_page?></a>
				   <?}
				}

				if($block < $total_block) {
				   	$my_page = $last_page+1;?>
				    <a href="Javascript:MovePage4('<?=$my_page?>');" class="pg_nav pg_next"></a>
				<?}else{ ?>
					<a href="#;" class="pg_nav pg_next"></a>
				<?}
				?>
				</span>
				<?
				if($page < $total_page) {?>
					<a href="Javascript:MovePage4('<?=$total_page?>');" class="pg_nav pg_last"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_last"></a>
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