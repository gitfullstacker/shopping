<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
		
		
		<div class="con_width">
			
			<div class="tit_h2 mt25">
				<em>내가 쓴 이용후기</em>
				<span class="tit_h2_desc">고객님의 소중한 이용후기를 기다립니다. 근거 없는 욕설, 비방,  <br />미풍양속을 저해하는 글은 고객님의 동의 없이 삭제될 수 있습니다.</span>
			</div>

			<div class="t_cover01 mt10">
				<table class="t_type">
					<colgroup>
						<col style="width:30%;" />
						<col />
					</colgroup>
					<tbody>
						<tr>
							<th>이용가방</th>
							<td class="center">
								<p><img src="http://ablanc.co.kr/admincenter/files/good/13081_2[2].jpg" alt="" class="t_img"/></p>
								<p class="f_bk f_bd mt07">GUCCI</p>
								<p class="mt05">클래식 램스킨 미니 17cm</p>
							</td>
						</tr>
						<tr>
							<th>아이디</th>
							<td>master</td>
						</tr>
						<tr>
							<th>성명</th>
							<td>홍길동</td>
						</tr>
						<tr>
							<th>만족도</th>
							<td>
								<ul class="sc_list">
									<li>
										<label>
											<input type="radio" />
											<i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i>
										</label>
									</li>
									<li>
										<label>
											<input type="radio" />
											<i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star00"></i>
										</label>
									</li>
									<li>
										<label>
											<input type="radio" />
											<i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i>
										</label>
									</li>
									<li>
										<label>
											<input type="radio" />
											<i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i>
										</label>
									</li>
									<li>
										<label>
											<input type="radio" />
											<i class="icn icn_star01"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i>
										</label>
									</li>
								</ul>
							</td>
						</tr>
						<tr>
							<th>제목</th>
							<td><input type="text" class="inp w100p" /></td>
						</tr>
						<tr>
							<th>내용</th>
							<td><textarea name="" id="" cols="30" rows="10" class="tarea"></textarea></td>
						</tr>
						
						<tr>
							<th>파일선택</th>
							<td><p class="file_bx"><input type="file" class="inp w100p" id="demo-1" /></p></td>
						</tr>
								
					</tbody>
				</table>
			</div>
			<div class="btn_w mt15">
				<p class="f_left"><a href="#;" class="btn btn_l btn_ylw f_bd w100p">확인</a></p>
				<p class="f_right"><a href="#;" class="btn btn_l btn_bk f_bd w100p">취소</a></p>
			</div>
			

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