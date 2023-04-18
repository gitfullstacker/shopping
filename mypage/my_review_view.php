<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   내가 쓴 이용후기</p>
					<div class="lnb_tab mt10">
						<? require_once $_SERVER['DOCUMENT_ROOT']."/mypage/tab.php"; ?>
					</div>
					<div class="tit_h2_2 mt45">내가 쓴 이용후기</div>
					<p class="tit_desc mt20">고객님의 소중한 후기로 많은 분들이 좋은 선택을 할 수 있게 도와주세요.</p>
					
					<div class="notice_bx mt45">고객님의 소중한 이용후기를 기다립니다. 근거 없는 욕설, 비방, 미풍양속을 저해하는 글은 고객님의 동의 없이 삭제될 수 있습니다.</div>

					<div class="t_cover02 mt50">
						<table class="t_type01">
							<colgroup>
								<col style="width:185px;" />
								<col style="width:370px;" />
								<col style="width:185px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">이용가방</th>
									<td class="left" colspan="3">
										<div class="prd_bx">
											<p class="img">
												<img src="../images/main/ex01.jpg" style="width:120px;height:120px;" alt="" />
											</p>
											<div class="f_bd f_bk">
												<p>브랜드명 출력 영역 </p>
												<p>가방명 출력 영역 </p>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<th class="left">아이디</th>
									<td class="left line_r">master</td>
									<th class="left">성명</th>
									<td class="left">홍길동</td>
								</tr>
								<tr>
									<th class="left">만족도</th>
									<td class="left" colspan="3">
										<img src="../images/board/icn_star1.gif" alt="" />
										<img src="../images/board/icn_star1.gif" alt="" />
										<img src="../images/board/icn_star1.gif" alt="" />
										<img src="../images/board/icn_star1.gif" alt="" />
										<img src="../images/board/icn_star0.gif" alt="" />
									</td>
								</tr>
								<tr>
									<th class="left">제목</th>
									<td class="left f_bk f_bd" colspan="3">맘에 쏘옥 드는 핸드백이 왔어요^^</td>
								</tr>
								<tr>
									<th class="left">내용</th>
									<td class="left" colspan="3">
										<p>
											<img src="../images/main/ex01.jpg" alt="" />
										</p>
										<p>맘에 쏘옥 드는 핸드백이 왔어요^^<br />맘에 쏘옥 드는 핸드백이 왔어요^^</p>
									</td>
								</tr>
								<tr>
									<th class="left">업로드</th>
									<td class="left" colspan="3"> </td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="center mt30">
						<a href="#;" class="btn btn_l btn_bk w w270 f_bd">수정하기</a>
						<a href="#;" class="btn btn_l btn_wt w w270 f_bd">목록</a>
						<a href="#;" class="btn btn_l btn_bk w w270 f_bd">삭제</a>
					</div>
				
					
					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
