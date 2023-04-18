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
						*
					FROM "
						.$Tname."comm_newsle_info AS A
					WHERE
						A.INT_NUMBER='$str_no' ";

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
<script language="javascript" src="js/news_news_edit.js"></script>
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

						<form id="frm" name="frm" target="_self" method="POST" action="news_news_edit.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">

						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="padding-left:10px;width:88%">
							<tr>
								<td>성별</td>
								<td colspan="3">
									<input type="radio" value="1" name="str_sex" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SEX'],"1")=="1") {?>checked<?}?>> 남자
									<input type="radio" value="2" name="str_sex" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_SEX'],"1")=="2") {?>checked<?}?>> 여자
								</td>
							</tr>
							<tr>
								<td>이메일</td>
								<td colspan="3"><font class=def><input type=text name=str_email value="<?=$arr_Data['STR_EMAIL']?>" size=80></td>
							</tr>
							<?If ($RetrieveFlag=="UPDATE") {?>
							<tr>
								<td>등록일자</td>
								<td colspan="3"><font class=ver8><?=$arr_Data['DTM_INDATE']?></td>
							</tr>
							<?}?>
						</table>


						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						<a href='news_news_list.php'><img src='/admincenter/img/btn_list.gif'></a>
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
