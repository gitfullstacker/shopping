<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/request.js"></script>


			<form id="frm" name="frm" target="_self" method="POST" action="request.php" enctype="multipart/form-data">
			<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
			<input type="hidden" name="int_gubun">

		<div class="con_width">
			
			<!-- <div class="tit_h2 mt25">
				<em>가방요청</em>
				<span class="tit_h2_desc">고객님께서 요청하신 가방입니다.</span>
			</div> -->
			

			<div class="tit_h3 pt15">내 요청 사항</div>
			<div class="t_cover01 mt10">
				<?
				$SQL_QUERY = "select a.*,b.str_code from ".$Tname."comm_member_requ a left join ".$Tname."comm_com_code b on a.int_brand=b.int_number where a.str_userid='$arr_Auth[0]' order by a.int_number desc ";
	
				$arr_Data=mysql_query($SQL_QUERY);
				$arr_Data_Cnt=mysql_num_rows($arr_Data);
				?>
				<table class="t_type">
					<colgroup>
						<col style="width:15%;" />
						<col style="width:85%;" />
					</colgroup>
					<tbody>
						<?if ($arr_Data_Cnt) {?>
						<?
							for($int_J = 0 ;$int_J < $arr_Data_Cnt; $int_J++) {
						?>
						<tr>
							<td class="r_line"><?=$arr_Data_Cnt-$int_J?></td>
							<td>
								<ul class="list_type01">
									<li><?if (mysql_result($arr_Data,$int_J,int_gubun)=="1") {?>사진으로 요청<?}else{?>브랜드으로 요청<?}?>  [<?=str_replace("-","-",substr(mysql_result($arr_Data,$int_J,dtm_indate),0,10))?>]</li>
									<?if (mysql_result($arr_Data,$int_J,int_gubun)=="1") {?>
									<li>
										브랜드 :
										<?=mysql_result($arr_Data,$int_J,str_code)?> 
										<?if (mysql_result($arr_Data,$int_J,str_ebrand)!=""){?> 
											(<?=mysql_result($arr_Data,$int_J,str_ebrand)?>)
										<?}?>
										가방 요청 이유 :
										<?switch (mysql_result($arr_Data,$int_J,int_reason)) {
											case  "1" : echo "잡지나 온라인에서 보게 됨"; break;
											case  "2" : echo "친구가 가지고 있었음"; break;
											case  "3" : echo "유명인이 사용하고 있었음 "; break;
											case  "4" : echo "기타"; break;
										}
										?>	
										<?if (mysql_result($arr_Data,$int_J,int_reason)=="4") {?>
											(<?=mysql_result($arr_Data,$int_J,str_reason)?>)
										<?}?>
									</li>
									<li>
										파일명 : <a href="request_dn.php?str_no=<?=mysql_result($arr_Data,$int_J,int_number)?>"><?=mysql_result($arr_Data,$int_J,str_image1)?>
									</li>
									<?}else{?>
									<li>
										<?
										$SQL_QUERY = "select a.*,b.str_code from ".$Tname."comm_member_requ_sub a left join ".$Tname."comm_com_code b on a.int_sbrand=b.int_number where a.int_number='".mysql_result($arr_Data,$int_J,int_number)."' order by a.int_sbrand asc ";
							
										$arr_sData=mysql_query($SQL_QUERY);
										$arr_sData_Cnt=mysql_num_rows($arr_sData);
										?>
										브랜드 :
										<?
											for($int_B = 0 ;$int_B < $arr_sData_Cnt; $int_B++) {
										?>
											<?=mysql_result($arr_sData,$int_B,str_code)?><?if ($int_B != ($arr_sData_Cnt-1)){?>, <?}?>
										<?
											}
										?>
										<?if (mysql_result($arr_Data,$int_J,str_ebrand)!=""){?> 
											(<?=mysql_result($arr_Data,$int_J,str_ebrand)?>)
										<?}?>
									<?}?>
									</li>
								</ul>
							</td>
						</tr>
						<?
							}
						?>
						<?}else{?>
						<tr>
							<td colspan="2">자료가 없습니다.</td>
						</tr>
						<?}?>
					</tbody>
				</table>
			</div>
			<div class="paging mt15" style="display:none;">
				<a href="#;" class="pg_nav pg_fir"></a>
				<a href="#;" class="pg_nav pg_prev"></a>
				<span class="num">
					<a href="#;">1</a>
					<a href="#;" class="on">2</a>
					<a href="#;">3</a>
					<a href="#;">4</a>
					<a href="#;">5</a>
				</span>
				<a href="#;" class="pg_nav pg_next"></a>
				<a href="#;" class="pg_nav pg_last"></a>
			</div>
			

			<script type="text/javascript">
				$(function () {	
					tab02('#tab02');	
				});

				function tab02(e){	
					
					var menu = $(e).children();
					var con = $(e+'_con').children();
					
					var select = $(menu).first();
					var i = 0;
					
					menu.click(function(){				
						if(select!==null){					// 활성화 된 탭메뉴 닫기
							select.removeClass("on");
							con.eq(i).hide();
						}
						
						select = $(this);					// 새 메뉴 index 받기
						i = $(this).index();
						
						select.addClass('on');				// 새 탭메뉴 활성화
						con.eq(i).show();				
					});
					
				}
			</script>
			
			
				<div class="request_tab mt25">
					<ul id="tab02">
						<li class="on">사진으로 요청</li>
						<li>브랜드 요청</li>
					</ul>
				</div>
				<div class="tab_con mt10 widget" id="tab02_con">
					<div>
						<div class="t_cover01">
							<table class="t_type">
								<colgroup>
									<col style="width:30%;" />
									<col style="width:70%;" />
								</colgroup>
								<tbody>
									<tr>
										<th>브랜드</th>
										<td>
											<?
											$SQL_QUERY = "select a.* from ".$Tname."comm_com_code a where a.str_service='Y' and a.int_gubun='6' order by a.int_number asc ";
								
											$arr_Data=mysql_query($SQL_QUERY);
											$arr_Data_Cnt=mysql_num_rows($arr_Data);
											?>
											<select name="int_brand" id="int_brand" class="selc w100p">
												<option value="">브랜드 선택</option>
												<?
													for($int_J = 0 ;$int_J < $arr_Data_Cnt; $int_J++) {
												?>
												<option value="<?=mysql_result($arr_Data,$int_J,int_number)?>"><?=mysql_result($arr_Data,$int_J,str_code)?></option>
												<?
													}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<th>기타브랜드<br /> /모델명</th>
										<td><input type="text" name="str_ebrand1" class="inp w100p" /></td>
									</tr>
									<tr>
										<th>가방 요청 이유</th>
										<td>
											<ul class="list_type01">
												<li>
													<label><input type="radio" name="int_reason" value="1" class="cform">잡지나 온라인에서 보게 됨</label>
												</li>
												<li>
													<label><input type="radio" name="int_reason" value="2" class="cform">친구가 가지고 있었음</label>
												</li>
												<li>
													<label><input type="radio" name="int_reason" value="3" class="cform">유명인이 사용하고 있었음</label>
												</li>
												<li>
													<label><input type="radio" name="int_reason" value="4" class="cform">기타 <input type="text" class="inp w70p" name="str_reason" /> </label>
												</li>
											</ul>
										</td>
									</tr>
									<tr>
										<th>사진 파일 등록</th>
										<td>
											<!-- <input type="file" class="inp w100p"/> -->
											<p class="file_bx">
												<input type="file" class="inp w100p" name="str_Image1" onChange="uploadImageCheck(this)" id="demo-1" />
											</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="btn_w mt15">
							<a href="javascript:Save_Click('1');" class="btn btn_l btn_ylw w100p f_bd">요청하기</a>
						</div>
						
					</div>
					<div style="display:none;">
						<div class="t_cover01">
							<table class="t_type">
								<colgroup>
									<col style="width:30%;" />
									<col style="width:70%;" />
								</colgroup>
								<tbody>
									<tr>
										<th>브랜드</th>
										<td>
											<!-- <ul class="list_type01"> -->
											<ul class="sc_list">
												<?
													for($int_J = 0 ;$int_J < $arr_Data_Cnt; $int_J++) {
												?>
												<li><label><input type="checkbox" name="int_sbrand[]" id="int_sbrand"  class="cform" value="<?=mysql_result($arr_Data,$int_J,int_number)?>" /> <?=mysql_result($arr_Data,$int_J,str_code)?></label></li>
												<?
													}
												?>
											</ul>
										</td>
									</tr>
									<tr>
										<th>기타브랜드<br />/모델명</th>
										<td><input type="text" name="str_ebrand2" class="inp w100p" /></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="btn_w mt15">
							<a href="javascript:Save_Click('2');" class="btn btn_l btn_ylw w100p f_bd">요청하기</a>
						</div>
						
						
					</div>
				</div>
				
				
				
				
				

			</form>
			

			

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