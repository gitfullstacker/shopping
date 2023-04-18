<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>
<script language="JavaScript" src="js/idpw_search.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   MEMBER JOIN    >   로그인</p>
					<div class="lnb_tab lnb_tab5 mt20">
						<ul>
							<li><a href="login.php">로그인</a></li>
							<li><a href="join.php">회원가입</a></li>
							<li class="on"><a href="idpw_search.php">ID/비밀번호 찾기</a></li>
							<li><a href="use.php">이용약관</a></li>
							<li><a href="privaty.php">개인정보취급방침</a></li>
						</ul>
					</div>
					
					<form id="frm" name="frm" target="_self" method="POST">
					<input type="hidden" name="RetrieveFlag">
					<input type="hidden" name="gbn">
					
					<div class="idpw_search_w mt45">
						<div class="id_a">
							<div class="idpw_bx">
								<div class="idpw_tit">아이디 찾기</div>
								<div class="idpw_f">
									<p><input type="text" name="str_name" class="inp01 w265" placeholder="이름" /></p>
									<p class="mt10">
										<select name="str_hp1" id="str_hp1" class="SlectBox">
											<option value="">휴대폰국번</option>
											<option value="010">010</option>
											<option value="011">011</option>
											<option value="016">016</option>
											<option value="017">017</option>
											<option value="018">018</option>
											<option value="019">019</option>
										</select>
										<input type="text" name="str_hp2" class="inp01 w125" maxlength=4 />
										<input type="text" name="str_hp3" class="inp01 w125" maxlength=4 />
									</p>
								</div>
								<div class="idpw_btn"><a href="javascript:CheckValue('1');" class="btn btn_bk btn_l f_bd">아이디 찾기</a></div>
							</div>
						</div>
						<div class="pw_a">
							<div class="idpw_bx">
								<div class="idpw_tit">비밀번호 찾기</div>
								<div class="idpw_f">
									<p><input type="text" name="str_userid" class="inp01 w265" placeholder="아이디" /></p>
									<p class="mt10"><input type="text" name="str_rname" class="inp01 w265" placeholder="이름" /></p>
									<p class="mt10">
										<select name="str_rhp1" id="str_rhp1" class="SlectBox">
											<option value="">휴대폰국번</option>
											<option value="010">010</option>
											<option value="011">011</option>
											<option value="016">016</option>
											<option value="017">017</option>
											<option value="018">018</option>
											<option value="019">019</option>
										</select>
										<input type="text" name="str_rhp2" class="inp01 w125" maxlength=4 />
										<input type="text" name="str_rhp3" class="inp01 w125" maxlength=4 />
									</p>
								</div>
								<div class="idpw_btn"><a href="javascript:CheckValue('2');" class="btn btn_bk btn_l f_bd">비밀번호 찾기</a></div>
							</div>
						</div>
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
