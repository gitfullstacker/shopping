<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_filename = Fnc_Om_Conv_Default($_REQUEST[str_filename],"");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						UR.INT_NUMBER,
						UR.STR_FILENAME,
						UR.STR_TITLE,
						UR.STR_CONTENTS,
						UR.DTM_INDATE
					FROM "
						.$Tname."comm_check_tip AS UR
					WHERE
						UR.STR_FILENAME='$str_filename'
						AND
						UR.INT_NUMBER='$str_no' ";

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
<script language="javascript" src="js/comm_tip_edit.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	/* ++++++++++++++++++ *\
		웹 에디터 inc 파일
	\* ++++++++++++++++++ */
	var loc_Str_Comm_Path = '/pub/';
	var loc_Edit_Height = 200;
	document.write('<SCR'+'I'+'PT LANGUAGE="JavaScript" SRC="'+loc_Str_Comm_Path+'editor/editor_tmp2.js"><\/SCRIPT>');
//-->
</SCRIPT>
</head>
<body class=scroll>
<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" align="center">

			<table width=100%>
				<tr>
					<td style="padding:10px">

						<form id="frm" name="frm" target="_self" method="POST" action="comm_tip_edit.php">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_filename" value="<?=$str_filename?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<div class="title title_top">CHECK TIP정보</div>
						<table class=tb>
							<col class=cellC><col style="padding-left:10px">
							<tr>
								<td>제목</td>
								<td><input type=text name=str_title value="<?=$arr_Data['STR_TITLE']?>" style="width:200px;"></td>
							</tr>
							<tr>
								<td>내용</td>
								<td>
								<SCRIPT LANGUAGE="JavaScript">
								<!--
									document.write(fnc_Out_Editor_Menu('frm', 'txt_Format', 'str_contents'));

									document.frm.str_contents.value=unescape('<?=js_escape(Fnc_Om_Conv_Default($arr_Data['STR_CONTENTS'],""))?>');
									fncCngType(eval('ed_Type'), 'frm', 'sel_Editor_Format', 'txt_Format', 'str_contents', 'viewEditMenu', 'viewArea', 'viewIframe');
									document.frm.sel_Editor_Format.selectedIndex = 0;
								//-->
								</SCRIPT>
								</td>
							</tr>
							<?If ($RetrieveFlag=="UPDATE") {?>
							<tr>
								<td>최종수정일</td>
								<td><font class=ver8><?=$$arr_Data['DTM_INDATE']?></td>
							</tr>
							<?}?>
						</table>

						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}Else{?>modify<?}?>.gif"></a>
						<a href='comm_tip_list.php?str_filename=<?=$str_filename?>'><img src='/admincenter/img/btn_list.gif'></a>
						</div>

						<table border="0" style="display:none;">
							<tr>
								<td id="obj_Lbl" colspan="2" height="0"></td>
							</tr>
						</table>
						</form>

					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script>table_design_load();</script>
</body>
</html>