<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="JavaScript" src="js/idpw_search.js"></script>

		<form id="frm" name="frm" target="_self" method="POST">
		<input type="hidden" name="RetrieveFlag">
		<input type="hidden" name="gbn">
		
		<div class="con_width">
			<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/submenu_memberjoin.php"; ?>
			<div class="idpw_bx">
				<div class="idpw_tit">아이디 찾기</div>
				<div class="idpw_f">
					<p><input type="text" name="str_name" class="inp w100p" placeholder="이름" /></p>
					<p class="phone_bx mt10">
						<span class="phone01">
							<select name="str_hp1" id="str_hp1" class="selc w100p">
								<option value="">휴대폰국번</option>
								<option value="010">010</option>
								<option value="011">011</option>
								<option value="016">016</option>
								<option value="017">017</option>
								<option value="018">018</option>
								<option value="019">019</option>
							</select>
						</span>
						<span class="phone04">-</span>
						<span class="phone02"><input type="text" name="str_hp2" maxlength=4 class="inp w100p" /></span>
						<span class="phone04">-</span>
						<span class="phone03"><input type="text" name="str_hp3" maxlength=4 class="inp w100p" /></span>
					</p>
				</div>
				<div class="mt15"><a href="javascript:CheckValue('1');" class="btn btn_bk btn_l f_bd w100p">아이디 찾기</a></div>
			</div>

			<div class="idpw_bx">
				<div class="idpw_tit">비밀번호 찾기</div>
				<div class="idpw_f">
					<p><input type="text" name="str_userid" class="inp w100p" placeholder="아이디" /></p>
					<p class="mt10"><input type="text" class="inp w100p" placeholder="이름" /></p>
					<p class="phone_bx mt10">
						<span class="phone01">
							<select name="str_rhp1" id="str_rhp1" class="selc w100p">
								<option value="">휴대폰국번</option>
								<option value="010">010</option>
								<option value="011">011</option>
								<option value="016">016</option>
								<option value="017">017</option>
								<option value="018">018</option>
								<option value="019">019</option>
							</select>
						</span>
						<span class="phone04">-</span>
						<span class="phone02"><input type="text" name="str_rhp2" maxlength=4 class="inp w100p" /></span>
						<span class="phone04">-</span>
						<span class="phone03"><input type="text" name="str_rhp3" maxlength=4 class="inp w100p" /></span>
					</p>
				</div>
				<div class="mt15"><a href="javascript:CheckValue('2');" class="btn btn_bk btn_l f_bd w100p">비밀번호 찾기</a></div>
			</div>

		</div>
		
		<table border="0" style="display:none;">
			<tr>
				<td id="obj_Lbl" colspan="2" height="0"></td>
			</tr>
		</table>
		
		</form>

<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/footer.php"; ?>