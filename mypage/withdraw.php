<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>
<script language="javascript" src="js/withdraw.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   개인정보</p>
					<div class="lnb_tab mt10">
						<? require_once $_SERVER['DOCUMENT_ROOT']."/mypage/tab.php"; ?>
					</div>

					<div class="tab_type02 mt50">
						<a href="user_info.php">개인정보 수정</a>
						<a href="withdraw.php" class="on">회원탈퇴</a>
					</div>

					<!-- <div class="tit_h2_2 mt45">회원탈퇴</div> -->
					
					<div class="notice_bx02 mt45">
						<p class="f_bk f_bd center">에이블랑을 탈퇴하시는 이유를 말씀해주시면, 참고하여 보다 나은 서비스를 위해 노력하겠습니다.</p>
					</div>

		          	<form id="frm" name="frm" target="_self" method="POST">
		          	<input type="hidden" name="RetrieveFlag">

					<div class="tit_h3 mt45">비밀번호 확인</div>
					<div class="t_cover02 mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:185px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">아이디</th>
									<td class="left">
										<?=$arr_Auth[0]?>
									</td>
								</tr>
								<tr>
									<th class="left">비밀번호</th>
									<td class="left">
										<input type="password" name="str_passwd" maxlength="12" class="inp01 w310" />
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="withdraw_bx01 mt40">
						<ul>
							<?
							$SQL_QUERY = "select a.* from ";
							$SQL_QUERY.=$Tname;
							$SQL_QUERY.="comm_com_code a ";
							$SQL_QUERY.="where a.int_gubun='1' and a.str_service='Y' ";
							$SQL_QUERY.="order by a.int_number asc ";

							$arr_Code_Menu = mysql_query($SQL_QUERY);
							?>
							<?while($row=mysql_fetch_array($arr_Code_Menu)){?>
							<li><label><input type="radio" value="<?=$row[INT_NUMBER]?>" name=str_escecode /> <?=$row[STR_CODE]?></label></li>
							<?}?>
						</ul>
					</div>
					<div class="withdraw_bx02 mt30">
						<textarea name="str_drcontents" cols="30" rows="10"></textarea>
					</div>

					<div class="center mt30">
						<a href="javascript:Save_Click();" class="btn btn_l btn_ylw w w270 f_bd">탈퇴하기</a>
						<a href="/mypage/user_info.php" class="btn btn_l btn_bk w w270 f_bd">개인정보수정으로 가기</a>
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
