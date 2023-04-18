<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/withdraw.js"></script>
		
		<div class="con_width">
			
			
			<div class="request_tab pt15">
				<ul id="tab02">
					<li><a href="/m/mypage/user_info.php">개인정보 수정</a></li>
					<li class="on"><a href="#;">회원탈퇴</a></li>
				</ul>
			</div>

			<div class="tit_h2 mt25">
				<em>회원탈퇴</em>
			</div>
			
          	<form id="frm" name="frm" target="_self" method="POST">
          	<input type="hidden" name="RetrieveFlag">

			<p class="notice_bx02 mt10">에이블랑을 탈퇴하시는 이유를 말씀해주시면, 참고하여 보다 나은 서비스를 위해 노력하겠습니다.</p>
			
			<div class="t_cover01 mt05">
				<table class="t_type">
					<colgroup>
						<col style="width:30%;" />
						<col style="width:70%;" />
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
								<input type="password" name="str_passwd" maxlength="12" class="inp w100p" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="membership_bx10 mt10">
				<ul class="list_type01">
					<?
					$SQL_QUERY = "select a.* from ";
					$SQL_QUERY.=$Tname;
					$SQL_QUERY.="comm_com_code a ";
					$SQL_QUERY.="where a.int_gubun='1' and a.str_service='Y' ";
					$SQL_QUERY.="order by a.int_number asc ";

					$arr_Code_Menu = mysql_query($SQL_QUERY);
					?>
					<?while($row=mysql_fetch_array($arr_Code_Menu)){?>
					<li><label><input type="radio" class="cform" value="<?=$row[INT_NUMBER]?>" name=str_escecode /> <?=$row[STR_CODE]?></label></li>
					<?}?>
				</ul>
			</div>
			<div class="membership_bx10 mt10">
				<textarea name="str_drcontents" cols="30" rows="10"></textarea>
			</div>
			
			<div class="btn_w mt15" style="padding-bottom: 15px;">
				<p class="f_left"><a href="javascript:Save_Click();" class="btn btn_l btn_ylw w100p f_bd">탈퇴하기</a></p>
				<p class="f_right"><a href="/m/mypage/user_info.php" class="btn btn_l btn_bk w100p f_bd">개인정보수정으로 가기</a></p>
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