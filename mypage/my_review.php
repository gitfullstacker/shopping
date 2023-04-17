<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   내가 쓴 이용후기</p>
					<div class="lnb_tab mt10">
						<? require_once $_SERVER[DOCUMENT_ROOT]."/mypage/tab.php"; ?>
					</div>
					<!-- <div class="tit_h2_2 mt45">내가 쓴 이용후기</div>
					<p class="tit_desc mt20">고객님의 소중한 후기로 많은 분들이 좋은 선택을 할 수 있게 도와주세요.</p> -->
					
					<div class="notice_bx mt45">고객님의 소중한 이용후기를 기다립니다. 근거 없는 욕설, 비방, 미풍양속을 저해하는 글은 고객님의 동의 없이 삭제될 수 있습니다.</div>

					<div class="tit_h3 mt60">작성 가능한 이용 내역</div>
					<p class="mt05">(이용후기는 가방 이용 후 작성 가능합니다.)</p>
					<div class="t_cover01 mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:150px;" />
								<col style="width:300px;" />
								<col style="width:120px;" />
								<col style="width:250px;" />
								<col />
							</colgroup>
							<thead>
								<tr>
									<th>발송일</th>
									<th>이용 내역 번호</th>
									<th colspan="2">이용 가방</th>
									<th>이용후기작성</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>2016.08.30</td>
									<td>2016083025512</td>
									<td><img src="../images/main/ex01.jpg" style="width:120px;height:120px;" alt="" /></td>
									<td class="left v_top no_pd02">
										<div class="mt15 f_bd f_bk">
											<p>브랜드명 출력 영역 </p>
											<p>가방명 출력 영역 </p>
										</div>
									</td>
									<td><a href="#;" class="btn btn_bk btn_m w95">작성하기</a></td>
								</tr>
								<tr>
									<td colspan="5">작성 가능한 이용 내역이 없습니다. 이용후기는 이용 후에 작성하실 수 있습니다.</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<div class="tit_h3 mt60">고객님께서 작성한 이용후기</div>
					<div class="t_cover01 mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:170px;" />
								<col style="width:200px;" />
								<col />
								<col style="width:140px;" />
								<col style="width:140px;" />
							</colgroup>
							<thead>
								<tr>
									<th colspan="2">가방정보</th>
									<th>이용후기</th>
									<th>등록일</th>
									<th>만족도</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><img src="../images/main/ex01.jpg" style="width:120px;height:120px;" alt="" /></td>
									<td class="left02 v_top no_pd02">
										<div class="mt15 f_bd f_bk">
											<p>브랜드명 출력 영역 </p>
											<p>가방명 출력 영역 </p>
										</div>
									</td>
									<td class="left"><a href="my_review_view.php" class="f_bd f_bk">맘에 쏘옥 드는 핸드백이 왔어요^^</a></td>
									<td>2016.08.30</td>
									<td>
										<img src="../images/board/icn_star1.gif" alt="" />
										<img src="../images/board/icn_star1.gif" alt="" />
										<img src="../images/board/icn_star1.gif" alt="" />
										<img src="../images/board/icn_star1.gif" alt="" />
										<img src="../images/board/icn_star0.gif" alt="" />
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					
				
					
					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"; ?>
