<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_userid = Fnc_Om_Conv_Default($_REQUEST[str_userid],"");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						FC.*
					FROM "
						.$Tname."comm_member_stamp AS FC
					WHERE
						FC.INT_NUMBER='$str_no' ";

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
<script language="javascript" src="js/memb_user_stamp_edit.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td colspan=2 valign=top height=100%>
			<table width=100%>
				<tr>
					<td style="padding:10px">

						<form id="frm" name="frm" target="_self" method="POST" action="memb_user_stamp_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="str_userid" value="<?=$str_userid?>">
						<input type="hidden" name="str_no" value="<?=$str_no?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="Obj">

						<div class="title title_top">적립금관리</div>


						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="padding-left:10px;width:88%">
							<tr>
								<td>구분</td>
								<td colspan=3>
									<input type="radio" value="1" name="str_gubun" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_GUBUN'],"1")=="1") {?>checked<?}?>> 멤버쉽가입
									<input type="radio" value="2" name="str_gubun" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_GUBUN'],"1")=="2") {?>checked<?}?>> 추천인ID
									<input type="radio" value="3" name="str_gubun" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_GUBUN'],"1")=="3") {?>checked<?}?>> 이미지후기
									<input type="radio" value="4" name="str_gubun" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_GUBUN'],"1")=="4") {?>checked<?}?>> 정기결제고객
									<input type="radio" value="5" name="str_gubun" class=null <?if (Fnc_Om_Conv_Default($arr_Data['STR_GUBUN'],"1")=="5") {?>checked<?}?>> 기타
									(<input type=text name=str_cont value="<?=$arr_Data['STR_CONT']?>" size=20>)
								</td>
							</tr>
							<tr>
								<td>사용적립금수</td>
								<td colspan="3"><font class=def><input type=text name=int_stamp value="<?=$arr_Data['INT_STAMP']?>" size=20> ※ 숫자만 기입 / 사용스템프는 '-'로 넣으세요.</td>
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
						<a href='memb_user_stamp_list.php?str_userid=<?=$str_userid?>'><img src='/admincenter/img/btn_list.gif'></a>
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