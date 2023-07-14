<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
//	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'],"");

	$SQL_QUERY =	"SELECT
						A.*
					FROM 
						" . $Tname . "comm_member_pay_info AS A
					WHERE
						A.INT_SNUMBER='$str_no' ";

	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	
	$RetrieveFlag="UPDATE";
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/pay_date_edit.js"></script>
</head>
<body class=scroll onload="init_orderid()">
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td colspan=2 valign=top height=100%>
			<table width=100%>
				<tr>
					<td style="padding:10px">

						<form id="frm" name="frm" target="_self" method="POST" action="pay_date_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">

						<div class="title title_top">기간수정</div>
						<table class=tb>
							<col class=cellC style="width:15%"><col class=cellL style="width:85%">
							<tr>
								<td>기간</td>
								<td colspan="3">
									<input type=text name=str_sdate value="<?=$arr_Data['STR_SDATE']?>" id="str_sdate" onclick="displayCalendar(document.frm.str_sdate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.str_sdate ,'yyyy-mm-dd',document.frm.str_sdate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.str_sdate.value=''";>
									~
									<input type=text name=str_edate value="<?=$arr_Data['STR_EDATE']?>" id="str_edate" onclick="displayCalendar(document.frm.str_edate ,'yyyy-mm-dd',this)">
									<img src="/pub/img/icons/calendar_add.gif" align="absmiddle" style="cursor:pointer" onclick="displayCalendar(document.frm.str_edate ,'yyyy-mm-dd',document.frm.str_edate)">
									<img src="/pub/img/icons/calendar_delete.gif" align="absmiddle" style="cursor:pointer" onclick="document.frm.str_edate.value=''";>
								</td>
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
