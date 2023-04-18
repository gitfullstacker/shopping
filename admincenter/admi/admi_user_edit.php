<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						A.*
					FROM "
						.$Tname."comm_member AS A
					WHERE
						A.STR_USERID='$str_no' ";

		$arr_Rlt_Data=mysql_query($SQL_QUERY);
		if (!$arr_Rlt_Data) {
    		echo 'Could not run query: ' . mysql_error();
    		exit;
		}
		$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	}
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/admi_user_edit.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_logo_info.php";?>
		<td width=100%>
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu_info.php";?>
		</td>
	</tr>
	<tr>
		<td colspan="3"><?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu.php";?></td>
	</tr>
	<tr>
		<td valign=top id=leftMenu>
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_lmenu_info.php";?>
		</td>
		<td colspan=2 valign=top height=100%> 
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_stitle_info.php";?>
			<table width=100%>
				<tr>
					<td style="padding:10px">
						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>


						<form id="frm" name="frm" target="_self" method="POST" action="admi_user_edit.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">

						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<tr>
								<td>아이디</td>
								<td>
									<?If ($RetrieveFlag=="UPDATE") {?>
										<b><?=$arr_Data['STR_USERID']?></b><input type=hidden name=str_userid value="<?=$arr_Data['STR_USERID']?>">
										<input type="hidden" name="str_userid_chk" value="1">
									<?}else{?>
										<span id="idView_Proc">
										<input type=text name=str_userid value="<?=$arr_Data['STR_USERID']?>" maxlength="12" onKeyUp="fnc_idcheck()"> <font class=small color=6d6d6d>영문입력 / <a href="javascript:fnc_idchk('1');"><b>중복체크</b></font>
										<input type="hidden" name="str_userid_chk" value="0">
										</span>
									<?}?>
								</td>
								<td>승인</td>
								<td class=noline><font class=def>
									<input type="radio" value="Y" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="Y") {?>checked<?}?>> 승인
									<input type="radio" value="N" name="str_service" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SERVICE'],"Y")=="N") {?>checked<?}?>> 미승인
								</td>
							</tr>
							<tr>
								<td>이름</td>
								<td><input type=text name=str_name value="<?=$arr_Data['STR_NAME']?>"></td>
								<td>권한그룹</td>
								<td>
									<?
									$SQL_QUERY = "select * from ";
												$SQL_QUERY .= $Tname;
												$SQL_QUERY .= "comm_fun_code
											where
												str_idxcode='01' and str_service='Y'
												order by str_idxnum desc" ;

									$arr_code_Data=mysql_query($SQL_QUERY);
									?>
									<select name="str_menu_level">
										<option value="00">↓그룹선택</option>
										<?while($row=mysql_fetch_array($arr_code_Data)){?>
										<option value="<?=$row[STR_IDXNUM]?>" <?if (trim($arr_Data['STR_MENU_LEVEL'])==trim($row[STR_IDXNUM])) {?>selected<?}?>><?=$row[STR_IDXWORD]?>
										<?}?>
									</select>
								</td>
							</tr>
							<tr>
								<td>비밀번호</td>
								<td colspan=3><font class=def>
								<?If ($RetrieveFlag=="UPDATE") {?>
								<input type=hidden name=str_opasswd value="<?=$arr_Data['STR_PASSWD']?>">
								<div style="float:left;" class=noline><input type=checkbox name=str_modpass value="Y" onclick="openLayer('pass')"> 변경</div>
								<div style="float:left;margin-left:10;display:none;" id="pass">
									새비밀번호 : <input type=password name=str_passwd1 maxlength="12"> &nbsp;&nbsp;
									비밀번호확인 : <input type=password name=str_passwd2 maxlength="12">
								</div>
								<?}else{?>
									비밀번호 : <input type=password name=str_passwd1 maxlength="12"> &nbsp;&nbsp;
									비밀번호확인 : <input type=password name=str_passwd2 maxlength="12">
								<?}?>
								</td>
							</tr>
							<tr>
								<td>이메일</td>
								<td colspan="3"><font class=def><input type=text name=str_email value="<?=$arr_Data['STR_EMAIL']?>" size=50></td>
							</tr>
							<tr>
								<?$sTemp=explode("-",Fnc_Om_Conv_Default($arr_Data['STR_TELEP'],"--"))?>
								<td>전화번호</td>
								<td colspan="3"><font class=def>
								<input type=text name=str_telep1 value="<?=$sTemp[0]?>" size=4 maxlength=4> -
								<input type=text name=str_telep2 value="<?=$sTemp[1]?>" size=4 maxlength=4> -
								<input type=text name=str_telep3 value="<?=$sTemp[2]?>" size=4 maxlength=4>
								</td>
							</tr>
							<?If ($RetrieveFlag=="UPDATE") {?>
							<tr>
								<td>회원가입일</td>
								<td><font class=ver8><?=$arr_Data['DTM_INDATE']?></td>
								<td>최종로그인</td>
								<td><font class=ver8><?=$arr_Data['DTM_ACDATE']?> &nbsp;&nbsp; 방문 <?=$arr_Data['INT_LOGIN']?> 회</td>
							</tr>
							<?}?>
						</table>

						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						<a href='admi_user_list.php'><img src='/admincenter/img/btn_list.gif'></a>
						</div>

						</form>

						<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_btip_info.php";?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr><td height=3 bgcolor="#E6E6E6" colspan=2></td></tr>
	<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_copyright_info.php";?>
</table>
<script>table_design_load();</script>
</body>
</html>
