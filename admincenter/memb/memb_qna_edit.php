<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$str_muserid = Fnc_Om_Conv_Default($_REQUEST[str_muserid],"");
	$int_idx = Fnc_Om_Conv_Default($_REQUEST[int_idx],"0");
	$int_order = Fnc_Om_Conv_Default($_REQUEST[int_order],"0");
	$int_level = Fnc_Om_Conv_Default($_REQUEST[int_level],"0");
	
	$SQL_QUERY =	" SELECT
					A.*
				FROM "
					.$Tname."comm_member AS A
				WHERE
					A.STR_USERID='$str_muserid' ";

	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>
<html>
<head>
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/memb_qna_edit.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td colspan=2 valign=top height=100%>
			<table width=100%>
				<tr>
					<td style="padding:10px">

						<form id="frm" name="frm" target="_self" method="POST" action="memb_qna_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_muserid" value="<?=$str_muserid?>">
						<input type="hidden" name="int_idx" value="<?=$int_idx?>">
						<input type="hidden" name="int_order" value="<?=$int_order?>">
						<input type="hidden" name="int_level" value="<?=$int_level?>">
						<input type="hidden" name="str_email" value="<?=$arr_Data['STR_EMAIL']?>">

						<div class="title title_top">답글</div>


						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="padding-left:10px;width:88%">
							<tr>
								<td>문의답글</td>
								<td colspan=3>
									<textarea name="str_cont" style="width:100%;height:100px;"></textarea>
								</td>
							</tr>
							<tr>
								<td>첨부파일</td>
								<td colspan="3"><font class=def><input type=file name=str_Image1 style="width:200;" onChange="uploadImageCheck1(this)"></td>
							</tr>
						</table>


						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						</div>

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