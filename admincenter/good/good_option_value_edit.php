<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						A.*
					FROM "
						.$Tname."comm_goods_option_value AS A
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
<?include $_SERVER[DOCUMENT_ROOT] . "/admincenter/inc/inc_header_info.php";?>
<link rel="stylesheet" type="text/css" href="/comm/js/jquery-ui/themes/base/jquery-ui.css" />
<script type="text/javascript" src="/comm/js/jquery.min.js"></script>
<script type="text/javascript" src="/comm/js/jquery-ui/ui/jquery-ui.js"></script>
<script language="javascript" src="js/good_option_value_edit.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td colspan=2 valign=top height=100%>
			<table width=100%>
				<tr>
					<td style="padding:10px">

						<form id="frm" name="frm" target="_self" method="POST" action="good_option_value_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_goodcode" value="<?=$str_goodcode?>">
						<input type="hidden" name="int_gubun" value="<?=$int_gubun?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="Obj">

						<div class="title title_top">옵션값</div>


						<table class=tb>
							<col class=cellC><col style="padding-left:10px">
							<col class=cellC><col style="padding-left:10px">
							<tr>
								<td>옵션값</td>
								<td><font class=def><input type=text name=str_option value="<?=$arr_Data['STR_OPTION']?>" size=20></td>
								<td>추가금액</td>
								<td><font class=def><input type=text name=int_aprice style="ime-mode:inactive" style="text-align:right;" required label="추가금액" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()" value="<?=$arr_Data['INT_APRICE']?>" size=20></td>
							</tr>
							<tr>
								<td>SKU번호</td>
								<td><input type=text name=str_skunum value="<?=$arr_Data['STR_SKUNUM']?>"></td>
								<td>관리코드</td>
								<td><input type=text name=str_manum value="<?=$arr_Data['STR_MANUM']?>"></td>
							</tr>
							<?if ($RetrieveFlag=="UPDATE") {?>
							<tr>
								<td>등록일자</td>
								<td colspan=3 class=noline><font class=def>
									<?=$arr_Data['DTM_INDATE']?>
								</td>
							</tr>
							<?}?>
						</table>


						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						<a href='good_option_value_list.php?str_goodcode=<?=$str_goodcode?>&int_gubun=<?=$int_gubun?>'><img src='/admincenter/img/btn_list.gif'></a>
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
<script type="text/javascript">

	$('#labSchAdd1').click(function(){
		$("#labCopyTable1").append('<tr>'+$("#labCopyTable1 tbody tr:first").html()+'</tr>');
	});
	function remSchedule1(obj)
	{
		$(obj).parent().parent().remove();
	}	
	
</script>