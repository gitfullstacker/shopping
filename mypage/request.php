<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>
<script language="javascript" src="js/request.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   가방요청</p>
					<div class="lnb_tab mt10">
						<? require_once $_SERVER['DOCUMENT_ROOT']."/mypage/tab.php"; ?>
					</div>
					
					<form id="frm" name="frm" target="_self" method="POST" action="request.php" enctype="multipart/form-data">
					<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
					<input type="hidden" name="int_gubun">

					<div class="tit_h3 mt45">내 요청 사항</div>
					<div class="t_cover01 mt15">
						<?
						$SQL_QUERY = "select a.*,b.str_code from ".$Tname."comm_member_requ a left join ".$Tname."comm_com_code b on a.int_brand=b.int_number where a.str_userid='$arr_Auth[0]' order by a.int_number desc ";
			
						$arr_Data=mysql_query($SQL_QUERY);
						$arr_Data_Cnt=mysql_num_rows($arr_Data);
						?>
						<table class="t_type01">
							<colgroup>
								<col style="width:95px;" />
								<col style="width:200px;" />
								<col />
								<col style="width:145px;" />
							</colgroup>
							<thead>
								<tr>
									<th>No.</th>
									<th>요청 종류</th>
									<th>요청 내용</th>
									<th>요청일</th>
								</tr>
							</thead>
							<tbody>
								<?if ($arr_Data_Cnt) {?>
								<?
									for($int_J = 0 ;$int_J < $arr_Data_Cnt; $int_J++) {
								?>
								<tr>
									<td><?=$arr_Data_Cnt-$int_J?></td>
									<td class="f_bk"><?if (mysql_result($arr_Data,$int_J,int_gubun)=="1") {?>사진으로 요청<?}else{?>브랜드 요청<?}?></td>
									<td class="left f_bk">
										<?if (mysql_result($arr_Data,$int_J,int_gubun)=="1") {?>
											<?=mysql_result($arr_Data,$int_J,str_code)?> 
											<?if (mysql_result($arr_Data,$int_J,str_ebrand)!=""){?> 
												(<?=mysql_result($arr_Data,$int_J,str_ebrand)?>)
											<?}?>
											<i class="icn icn_bar"></i> 
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
											<i class="icn icn_bar"></i>  파일명 <a href="request_dn.php?str_no=<?=mysql_result($arr_Data,$int_J,int_number)?>"><?=mysql_result($arr_Data,$int_J,str_image1)?></a>
										<?}else{?>
											<?
											$SQL_QUERY = "select a.*,b.str_code from ".$Tname."comm_member_requ_sub a left join ".$Tname."comm_com_code b on a.int_sbrand=b.int_number where a.int_number='".mysql_result($arr_Data,$int_J,int_number)."' order by a.int_sbrand asc ";
								
											$arr_sData=mysql_query($SQL_QUERY);
											$arr_sData_Cnt=mysql_num_rows($arr_sData);
											?>
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
									</td>
									<td><?=str_replace("-",".",substr(mysql_result($arr_Data,$int_J,dtm_indate),0,10))?></td>
								</tr>
								<?
									}
								?>
								<?}else{?>
								<tr>
									<td colspan="3">자료가 없습니다.</td>
								</tr>
								<?}?>
							</tbody>
						</table>
					</div>

					<div class="tit_h3 mt60">사진으로 요청</div>
					<div class="t_mypage mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:185px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">브랜드</th>
									<td class="left">
										<?
										$SQL_QUERY = "select a.* from ".$Tname."comm_com_code a where a.str_service='Y' and a.int_gubun='6' order by a.int_number asc ";
							
										$arr_Data=mysql_query($SQL_QUERY);
										$arr_Data_Cnt=mysql_num_rows($arr_Data);
										?>
										<span class="w355">
											<select name="int_brand" id="int_brand" class="SlectBox">
												<option value="">브랜드 선택</option>
												<?
													for($int_J = 0 ;$int_J < $arr_Data_Cnt; $int_J++) {
												?>
												<option value="<?=mysql_result($arr_Data,$int_J,int_number)?>"><?=mysql_result($arr_Data,$int_J,str_code)?></option>
												<?
													}
												?>
											</select>
										</span>
									</td>
								</tr>
								<tr>
									<th class="left">기타브랜드 / 모델명</th>
									<td class="left">
										<input type="text" class="inp01 w580" name="str_ebrand1" style="width:628px;" />
									</td>
								</tr>
								<tr>
									<th class="left">가방 요청 이유</th>
									<td class="left">
										<label><input type="radio" name="int_reason" value="1" /> 잡지나 온라인에서 보게 됨</label>
										<label class="pl20"><input type="radio" name="int_reason" value="2" /> 친구가 가지고 있었음 </label>
										<label class="pl20"><input type="radio" name="int_reason" value="3" /> 유명인이 사용하고 있었음  </label>
										<div class="mt15"><label><input type="radio" name="int_reason" value="4" /> 기타</label> <input type="text" class="inp01 w580" name="str_reason" /></div>
									</td>
								</tr>
								<tr>
									<th class="left">사진 파일 등록</th>
									<td class="left">
										<input type="file" class="inp01 w500" name="str_Image1" onChange="uploadImageCheck(this)"  id="demo-1" />
										<!--<a href="#;" class="btn btn_bk btn_m w95">찾아보기</a>//-->
									</td>
								</tr>
							</tbody>
						</table>
						<p class="request_btn"><a href="javascript:Save_Click('1');" class="btn btn_ylw"><span>요청하기</span></a></p>
					</div>

					<div class="tit_h3 mt60">브랜드 요청</div>
					<div class="t_mypage mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:185px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">브랜드 명</th>
									<td class="left">
										<ul class="brand_list">
											<?
												for($int_J = 0 ;$int_J < $arr_Data_Cnt; $int_J++) {
											?>
											<li><label><input type="checkbox" name="int_sbrand[]" id="int_sbrand" value="<?=mysql_result($arr_Data,$int_J,int_number)?>" /> <?=mysql_result($arr_Data,$int_J,str_code)?></label></li>
											<?
												}
											?>
										</ul>
									</td>
								</tr>
								<tr>
									<th class="left">기타브랜드 / 모델명</th>
									<td class="left">
										<input type="text" class="inp01 w580" name="str_ebrand2" style="width:628px;" />
									</td>
								</tr>
							</tbody>
						</table>
						<p class="request_btn"><a href="javascript:Save_Click('2');" class="btn btn_ylw"><span>요청하기</span></a></p>
					</div>
					
					</form>

					
					
					
        
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
					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
