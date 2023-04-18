<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_gubun = Fnc_Om_Conv_Default($_REQUEST[str_gubun],"1");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						BO.CONF_SEQ,
						BO.CONF_TITLE,
						BO.CONF_WIDTH,
						BO.CONF_TYPE,
						BO.CONF_ATT_URL,
						BO.CONF_ICON_URL,
						BO.CONF_AUTH,
						BO.CONF_VIEW,
						BO.CONF_REPLY_YN,
						BO.CONF_MEMO_YN,
						BO.CONF_ATT_YN,
						BO.CONF_LIMIT_SIZE,
						BO.CONF_DENY_FILE,
						BO.CONF_IMG_WIDTH,
						BO.CONF_ALBUM_LIST_TYPE,
						BO.CONF_IMG_PREVIEW,
						BO.CONF_LIST_CNT,
						BO.CONF_PAGE_CNT,
						BO.CONF_GROUP_CODE,
						BO.MEM_CODE,
						BO.MEM_ID,
						BO.CONF_TOP_HTML,
						BO.CONF_MID_HTML,
						BO.CONF_BTM_HTML,
						BO.CONF_DENY_CHAR,
						BO.CONF_BD_PATH,
						BO.CONF_REG_DATE
					FROM "
						.$Tname."b_conf_bd AS BO
					WHERE
						BO.CONF_TB_NAME = '".$Tname."B_BD_DATA@01'
						AND
						BO.CONF_SEQ = '$str_no' ";

		$arr_Rlt_Data=mysql_query($SQL_QUERY);

		if (!$arr_Rlt_Data) {
    		echo 'Could not run query: ' . mysql_error();
    		exit;
		}
		$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	}else{
		switch ($str_gubun) {
			case "1" :
				$conf_bd_path = "/boad/bd_news/";
				$conf_att_url = "/admincenter/files/boad/";
				$conf_list_cnt="10";
				break;
			case "2" :
				$conf_bd_path = "/boad/bd_free/";
				$conf_att_url = "/admincenter/files/boad/";
				$conf_list_cnt="10";
				break;
			case "3"  :
				$conf_bd_path = "/boad/bd_photo/";
				$conf_att_url = "/admincenter/files/boad/";
				$conf_list_cnt="8";
				break;
		}
		$conf_width="600";
		$conf_limit_size="10";
		$conf_deny_file="asp,php,jsp,cgi,exe";
		$conf_page_cnt="10";
		$conf_deny_char="";
	}
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/boad_board_edit.js"></script>
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

						<form id="frm" name="frm" target="_self" method="POST" action="boad_board_edit.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_gubun" value="<?=$str_gubun?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">

						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<tr>
								<td>게시판URL</td>
								<td colspan="3">
									<input type=text name=conf_bd_path value="<?=Fnc_Om_Conv_Default($arr_Data['CONF_BD_PATH'],$conf_bd_path)?>" style="width:300px;">
									&nbsp;<?if ($RetrieveFlag=="UPDATE") {?><a href="<?=$arr_Data['CONF_BD_PATH']?>" target="_blank"><?=$arr_Data['CONF_BD_PATH']?></a><?}?>
								</td>
							</tr>
							<tr>
								<td>게시판명칭</td>
								<td><input type=text name=conf_title value="<?=$arr_Data['CONF_TITLE']?>"></td>
								<td>게시판너비</td>
								<td><input type=text name=conf_width value="<?=Fnc_Om_Conv_Default($arr_Data['CONF_WIDTH'],$conf_width)?>" style="ime-mode:inactive" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()"></td>
							</tr>
							<tr>
								<td>첨부파일경로</td>
								<td colspan=3>
									<input type=text name=conf_att_url value="<?=Fnc_Om_Conv_Default($arr_Data['CONF_ATT_URL'],$conf_att_url)?>" style="width:300px;">
								</td>
							</tr>
							<tr>
								<td>작성옵션</td>
								<td colspan=3>
									<input type="checkbox" name="conf_reply_yn" value="1" <?if (Fnc_Om_Conv_Default($arr_Data['CONF_REPLY_YN'],"1")=="1") {?>checked<?}?> <?if (trim($str_gubun)=="1" || trim($str_gubun)=="3") {?> disabled<?}?> class="Null"><font class=ver8>답글쓰기</font>
									<input type="checkbox" name="conf_memo_yn" value="1" <?if (Fnc_Om_Conv_Default($arr_Data['CONF_MEMO_YN'],"1")=="1") {?>checked<?}?> class="Null"><font class=ver8>메모글가능</font>
									<input type="checkbox" name="conf_att_yn" value="1" <?if (Fnc_Om_Conv_Default($arr_Data['CONF_ATT_YN'],"1")=="1") {?>checked<?}?> class="Null"><font class=ver8>파일첨부가능</font>
									<input type="checkbox" name="conf_img_preview" value="1" <?if (Fnc_Om_Conv_Default($arr_Data['CONF_IMG_PREVIEW'],"1")=="1") {?>checked<?}?> class="Null"><font class=ver8>이미지미리보기 </font>
								</td>
							</tr>
							<tr>
								<td>파일제한용량</td>
								<td colspan="3">
									<input type=text name=conf_limit_size value="<?=Fnc_Om_Conv_Default($arr_Data['CONF_LIMIT_SIZE'],$conf_limit_size)?>" style="width:40px;" style="ime-mode:inactive" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()"> <font class=ver8>mb</font>
								</td>
							</tr>
							<tr>
								<td>등록거부파일</td>
								<td colspan="3">
									<input type=text name=conf_deny_file value="<?=Fnc_Om_Conv_Default($arr_Data['CONF_DENY_FILE'],$conf_deny_file)?>" style="width:300px;"> <font class=ver8>※ 등록거부 파일 확장자명은 , 로 구분해 주세요</font>
								</td>
							</tr>
							<tr>
								<td>출력수</td>
								<td colspan=3>
									목록 <input type=text name=conf_list_cnt value="<?=Fnc_Om_Conv_Default($arr_Data['CONF_LIST_CNT'],$conf_list_cnt)?>" style="width:40px;" maxlength=4>
									&nbsp;
									페이지 <input type=text name=conf_page_cnt value="<?=Fnc_Om_Conv_Default($arr_Data['CONF_PAGE_CNT'],$conf_page_cnt)?>" style="width:40px;" maxlength=4>
								</td>
							</tr>
							<tr>
								<td>입력제한문자</td>
								<td colspan="3">
									<input type=text name=conf_deny_char value="<?=Fnc_Om_Conv_Default($arr_Data['CONF_DENY_CHAR'],$conf_deny_char)?>" style="width:300px;"> <font class=ver8>※ 입력제한문자는 , 로 구분해 주세요</font>
								</td>
							</tr>
						</table>

						<?If ($RetrieveFlag=="UPDATE") {?>
						<div class="title">게시판관리자<span>게시판을 관리할수 있는 회원을 선택합니다. <a href="javascript:popupLayer('/admincenter/boad/boad_admin_list.php?str_no=<?=$str_no?>&str_gubun=<?=$str_gubun?>',400,450)"><img src="/admincenter/img/i_search.gif" border=0 align=absmiddle hspace=2></a></div>

						<span id="idView_Admin"></span>

						<script language="javascript">
							fuc_set('/admincenter/boad/boad_board_edit_proc.php?RetrieveFlag=ADMINLOADING&str_no=<?=$str_no?>','_Admin');
						</script>

						<span id="idView_Proc"></span>

						<?}?>

						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						<a href='boad_board_list.php?str_gubun=<?=$str_gubun?>'><img src='/admincenter/img/btn_list.gif'></a>
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