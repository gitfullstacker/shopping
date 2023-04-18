<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   이용내역</p>
					<div class="tit_h2 mt10">마이페이지</div>
					<div class="lnb_tab">
						<ul>
							<li><a href="get.php">GET한 가방</a></li>
							<li><a href="return.php">반납</a></li>
							<li><a href="stocked.php">입고 알림 가방</a></li>
							<li><a href="request.php">가방요청</a></li>
							<li class="on"><a href="use_list.php">이용내역</a></li>
							<li><a href="membership.php">멤버십 등록</a></li>
							<li><a href="like.php">좋아요 가방</a></li>
							<li><a href="stamp.php">내 스탬프</a></li>
							<li><a href="my_qna.php">문의하기(Q&amp;A)</a></li>
							<li><a href="my_review.php">내가 쓴 이용후기</a></li>
							<li><a href="user_info.php">개인정보</a></li>
						</ul>
					</div>
					<div class="tit_h2_2 mt45">이용 내역</div>
					<p class="tit_desc mt20">고객님이 이용하신 내역을 확인하실 수 있습니다.</p>
					
					<div class="use_list_bx mt50">
						<div class="use_list_con">내용</div>
					</div>

					<div class="tit_h3 mt60">대여 내역</div>
					<div class="t_cover01 mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:100px;" />
								<col style="width:220px;" />
								<col style="width:220px;" />
								<col style="width:220px;" />
								<col style="width:180px;" />
								<col />
							</colgroup>
							<thead>
								<tr>
									<th>회차</th>
									<th>출고</th>
									<th>고객수령</th>
									<th>입고(예정)일</th>
									<th>회수완료</th>
									<th>유효기간</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>회차</td>
									<td>출고</td>
									<td>고객수령</td>
									<td>입고예정일</td>
									<td>회수완료</td>
									<td>유효기간</td>
								</tr>
								<tr>
									<td colspan="6">내역이 없습니다.</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="paging02 mt30">
						<a href="#;" class="img_b"><img src="../images/board/btn_page_first.gif" alt="" /></a>
						<a href="#;" class="img_b"><img src="../images/board/btn_page_prev.gif" alt="" /></a>
						<a href="#;" class="on">1</a>
						<a href="#;">2</a>
						<a href="#;">3</a>
						<a href="#;">4</a>
						<a href="#;">5</a>
						<a href="#;">6</a>
						<a href="#;">7</a>
						<a href="#;">8</a>
						<a href="#;">9</a>
						<a href="#;">10</a>
						<a href="#;" class="img_b"><img src="../images/board/btn_page_next.gif" alt="" /></a>
						<a href="#;" class="img_b"><img src="../images/board/btn_page_last.gif" alt="" /></a>
					</div>

					<div class="tit_h3 mt60">결제 내역</div>
					<div class="t_cover01 mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:100px;" />
								<col style="width:220px;" />
								<col style="width:220px;" />
								<col style="width:220px;" />
								<col style="width:180px;" />
								<col />
							</colgroup>
							<thead>
								<tr>
									<th>회차</th>
									<th>출고</th>
									<th>고객수령</th>
									<th>입고(예정)일</th>
									<th>회수완료</th>
									<th>유효기간</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>회차</td>
									<td>출고</td>
									<td>고객수령</td>
									<td>입고예정일</td>
									<td>회수완료</td>
									<td>유효기간</td>
								</tr>
								<tr>
									<td colspan="6">내역이 없습니다.</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="paging02 mt30">
						<a href="#;" class="img_b"><img src="../images/board/btn_page_first.gif" alt="" /></a>
						<a href="#;" class="img_b"><img src="../images/board/btn_page_prev.gif" alt="" /></a>
						<a href="#;" class="on">1</a>
						<a href="#;">2</a>
						<a href="#;">3</a>
						<a href="#;">4</a>
						<a href="#;">5</a>
						<a href="#;">6</a>
						<a href="#;">7</a>
						<a href="#;">8</a>
						<a href="#;">9</a>
						<a href="#;">10</a>
						<a href="#;" class="img_b"><img src="../images/board/btn_page_next.gif" alt="" /></a>
						<a href="#;" class="img_b"><img src="../images/board/btn_page_last.gif" alt="" /></a>
					</div>
					
					
					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
